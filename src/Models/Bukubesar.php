<?php

namespace Altamasoft\JurnalUmum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukubesar extends Model
{
    use HasFactory;

    protected $table = 'bukubesar';
    protected $guarded = [];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id');
    }
}
