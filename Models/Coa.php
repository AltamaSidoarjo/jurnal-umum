<?php

namespace Altamasoft\JurnalUmum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;

    protected $table = 'coa';
    protected $guarded = [];

    public function scopeKasbank($query)
    {
        $query->where('tipe_coa', 'Kasbank');
    }

    public function scopeAktif($query)
    {
        $query->where('status_aktif', 1);
    }

    public function scopeAkunPersediaan($query)
    {
        $query->where('tipe_coa', 'Persediaan');
    }

    public function scopeAkunHutang($query)
    {
        $query->where('tipe_coa', 'Utang Usaha');
    }

    public function scopeAkunPiutang($query)
    {
        $query->where('tipe_coa', 'Akun Piutang');
    }
}
