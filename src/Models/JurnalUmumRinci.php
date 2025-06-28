<?php

namespace Altamasoft\JurnalUmum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmumRinci extends Model
{
    use HasFactory;

    protected $table = 'jurnal_umum_rinci';
    protected $guarded = [];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id');
    }
}
