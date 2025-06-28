<?php

namespace Altamasoft\JurnalUmum\Http\Controllers;

use Altamasoft\JurnalUmum\Http\Controllers\Controller;
use Altamasoft\JurnalUmum\Models\Coa;
use Altamasoft\JurnalUmum\Models\TipeCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CoaController extends Controller
{
    public function index()
    {
        $data = Coa::aktif()->get();

        return view('coa.index', compact('data'));
    }

    public function create()
    {
        $tipeCoa = TipeCoa::aktif()->get();

        return view('bukubesar.coa.create', compact('tipeCoa'));;
    }

    public function  store(Request $request)
    {
        $data = $request->validate([
            'tipe_coa' => 'required',
            'kode' => 'required|unique:coa',
            'nama' => 'required|unique:coa',
            'deskripsi' => 'nullable',
        ], [
            'tipe_coa.required' => 'Tipe coa harus diisi.',
            'kode.required' => 'Kode harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'nama.unique' => 'Nama sudah ada.',
            'nama.koda' => 'Kode sudah ada.',
        ]);

        try {
            DB::beginTransaction();

            Coa::create($data);

            DB::commit();
            return redirect()
                ->route('bukubesar.coa.index')
                ->with('message', 'Data berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function edit(Coa $coa)
    {
        $tipeCoa = TipeCoa::aktif()->get();
        return view('bukubesar.coa.edit', compact('coa', 'tipeCoa'));
    }

    public function update(Request $request, Coa $coa)
    {
        $data = $request->validate([
            'tipe_coa' => 'required',
            'kode' => [
                'required',
                Rule::unique('coa')->ignore($coa->id)
            ],
            'nama' => [
                'required',
                Rule::unique('coa')->ignore($coa->id)
            ],
            'status_aktif' => 'required',
            'deskripsi' => 'nullable',
        ], [
            'tipe_coa.required' => 'Tipe coa harus diisi.',
            'kode.required' => 'Kode harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'nama.unique' => 'Nama sudah ada.',
            'nama.koda' => 'Kode sudah ada.',
        ]);

        try {
            DB::beginTransaction();

            $coa->update($data);

            DB::commit();
            return redirect()
                ->route('bukubesar.coa.index')
                ->with('message', 'Data berhasil diupdate!');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function destroy(Coa $coa)
    {
        try {
            DB::beginTransaction();

            $coa->delete();

            DB::commit();
            return redirect()
                ->route('bukubesar.coa.index')
                ->with('message', 'Data berhasil dihapus!');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
