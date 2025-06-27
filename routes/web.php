<?php

use Altamasoft\JurnalUmum\Http\Controllers\Bukubesar\CoaController;
use Altamasoft\JurnalUmum\Http\Controllers\JurnalUmumController;
use Illuminate\Support\Facades\Route;

Route::resource('coa', CoaController::class)->names('coa');
Route::resource('jurnal-umum', JurnalUmumController::class)->names('jurnal-umum');
