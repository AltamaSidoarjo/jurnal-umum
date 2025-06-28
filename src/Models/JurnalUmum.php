<?php

namespace Altamasoft\JurnalUmum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $table = 'jurnal_umum';
    protected $guarded = [];

    public function jurnalUmumRinci()
    {
        return $this->hasMany(JurnalUmumRinci::class, 'jurnal_umum_id');
    }
}
