<?php

namespace Altamasoft\JurnalUmum\Http\Controllers;

use Altamasoft\JurnalUmum\Http\Controllers\Controller;
use Altamasoft\JurnalUmum\Models\Bukubesar;
use Altamasoft\JurnalUmum\Models\Coa;
use Altamasoft\JurnalUmum\Models\JurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JurnalUmumController extends Controller
{

    public function index()
    {
        $data = JurnalUmum::all();

        return view('bukubesar.jurnal-umum.index', compact('data'));
    }

    public function create()
    {
        $coa = Coa::aktif()->get();

        return view(
            'bukubesar.jurnal-umum.create',
            compact(
                'coa'
            )
        );
    }

    public function edit(JurnalUmum $jurnal_umum)
    {
        $coa = Coa::aktif()->get();

        return view(
            'bukubesar.jurnal-umum.edit',
            compact(
                'jurnal_umum',
                'coa'
            )
        );
    }

    public function convert($value)
    {
        $titik = str_replace('.', '', $value);
        $koma = str_replace(',', '.', $titik);
        return $koma;
    }

    public function store(Request $request)
    {
        $rincian = $request->input('rincian');

        foreach ($rincian as $key => $value) {
            $rincian[$key]['debit'] = $this->convert($value['debit']);
            $rincian[$key]['kredit'] = $this->convert($value['kredit']);
        }

        $request->merge([
            'debit' => $this->convert($request->input('debit')),
            'kredit' => $this->convert($request->input('kredit')),
            'rincian' => $rincian
        ]);

        $request->validate([
            'nomer' => 'required|unique:jurnal_umum',
            'tanggal' => 'required',
            'debit' => 'required',
            'kredit' => 'required|same:debit',
            'rincian.*.coa_id' => 'required',
            'rincian.*.debit' => 'required',
            'rincian.*.kredit' => 'required',
        ], [
            'kredit.same' => 'Total debit & kredit harus sama.',
            'nomer.required' => 'Nomer harus diisi.',
            'nomer.unique' => 'Nomer sudah ada.',
            'rincian.*.coa_id.required' => 'Akun harus diisi.',
            'rincian.*.debit.required' => 'Debit harus diisi.',
            'rincian.*.kredit.required' => 'Kredit harus diisi.',
        ]);

        try {

            DB::beginTransaction();

            // insert parent
            $data = JurnalUmum::create([
                'nomer' => $request->nomer,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'debit' => $request->debit,
                'kredit' => $request->kredit,
            ]);

            // insert rincian
            foreach ($request->input('rincian') as $value) {
                $data->jurnalUmumRinci()->create([
                    'coa_id' => $value['coa_id'],
                    'debit' => $value['debit'],
                    'kredit' => $value['kredit'],
                    'catatan' => $value['catatan'],
                ]);

                // jurnal bukubesar
                Bukubesar::create([
                    'coa_id' => $value['coa_id'],
                    'sumber_id' => $data->id,
                    'tanggal' => $data->tanggal,
                    'nomer' => $data->nomer,
                    'sumber_transaksi' => 'JU',
                    'nominal' => $value['debit'] > 0 ? $value['debit'] : $value['kredit'],
                    'tipe_mutasi' => $value['debit'] > 0 ? 'D' : 'K',
                    'keterangan' => $value['catatan']
                ]);
            }

            DB::commit();

            return redirect()
                ->route('bukubesar.jurnal-umum.index')
                ->with('message', 'Data berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
            exit($th->getMessage());
        }
    }

    public function update(Request $request, JurnalUmum $jurnal_umum)
    {
        $rincian = $request->input('rincian');

        foreach ($rincian as $key => $value) {
            $rincian[$key]['debit'] = $this->convert($value['debit']);
            $rincian[$key]['kredit'] = $this->convert($value['kredit']);
        }

        $request->merge([
            'debit' => $this->convert($request->input('debit')),
            'kredit' => $this->convert($request->input('kredit')),
            'rincian' => $rincian
        ]);

        $request->validate([
            'nomer' => [
                'required',
                Rule::unique('jurnal_umum')->ignore($jurnal_umum->id)
            ],
            'tanggal' => 'required',
            'kredit' => 'required',
            'debit' => 'required|same:kredit',
            'rincian.*.coa_id' => 'required',
            'rincian.*.debit' => 'required',
            'rincian.*.kredit' => 'required',
        ], [
            'nomer.required' => 'Nomer harus diisi.',
            'nomer.unique' => 'Nomer sudah ada.',
            'rincian.*.coa_id.required' => 'Akun harus diisi.',
            'rincian.*.debit.required' => 'Debit harus diisi.',
            'rincian.*.kredit.required' => 'Kredit harus diisi.',
        ]);

        try {

            DB::beginTransaction();

            // delete jurnal bukubesar
            Bukubesar::where('sumber_id', $jurnal_umum->id)
                ->where('sumber_transaksi', 'JU')
                ->delete();

            // update parent
            $jurnal_umum->update([
                'nomer' => $request->nomer,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'debit' => $request->debit,
                'kredit' => $request->kredit,
            ]);

            $jurnal_umum->jurnalUmumRinci()->delete(); // delete rincian

            // insert rincian
            foreach ($request->input('rincian') as $value) {
                $jurnal_umum->jurnalUmumRinci()->create([
                    'coa_id' => $value['coa_id'],
                    'debit' => $value['debit'],
                    'kredit' => $value['kredit'],
                    'catatan' => $value['catatan'],
                ]);

                // jurnal bukubesar
                Bukubesar::create([
                    'coa_id' => $value['coa_id'],
                    'sumber_id' => $jurnal_umum->id,
                    'tanggal' => $jurnal_umum->tanggal,
                    'nomer' => $jurnal_umum->nomer,
                    'sumber_transaksi' => 'JU',
                    'nominal' => $value['debit'] > 0 ? $value['debit'] : $value['kredit'],
                    'tipe_mutasi' => $value['debit'] > 0 ? 'D' : 'K',
                    'keterangan' => $value['catatan']
                ]);
            }

            DB::commit();

            return redirect()
                ->route('bukubesar.jurnal-umum.index')
                ->with('message', 'Data berhasil diupdate!');
        } catch (\Throwable $th) {
            DB::rollBack();
            exit($th->getMessage());
        }
    }

    public function destroy(JurnalUmum $jurnal_umum)
    {
        try {
            DB::beginTransaction();

            // delete bukubesar
            Bukubesar::where('sumber_id', $jurnal_umum->id)
                ->where('sumber_transaksi', 'JU')
                ->delete();

            $jurnal_umum->delete();

            DB::commit();

            return redirect()
                ->route('bukubesar.jurnal-umum.index')
                ->with('message', 'Data berhasil dihapus!');
        } catch (\Throwable $th) {
            DB::rollBack();
            exit($th->getMessage());
        }
    }

    public function print($id)
    {
        $jurnal_umum = JurnalUmum::with('jurnalUmumRinci.coa')->findOrFail($id);

        return view('bukubesar.jurnal-umum.print', [
            'title' => 'Jurnal Umum',
            'jurnal_umum' => $jurnal_umum
        ]);
    }
}
