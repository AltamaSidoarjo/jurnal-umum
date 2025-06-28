<?php

namespace Altamasoft\JurnalUmum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeCoa extends Model
{
    use HasFactory;

    protected $table = 'tipe_coa';

    public function scopeAktif($query)
    {
        $query->where('status_aktif', 1);
    }
}
