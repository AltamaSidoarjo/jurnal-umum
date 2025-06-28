@extends('layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Daftar Coa</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('bukubesar.coa.index') }}">Daftar Coa</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<form action="{{ route('bukubesar.coa.store') }}" method="post">
    @csrf
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @if($errors->any())
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif

                    {{-- parent --}}
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <th width="15%">
                                        Tipe Coa*
                                    </th>
                                    <td width="85%">
                                        <select name="tipe_coa" id="" class="form-control select2" required>
                                            <option value="">-- TIPE COA --</option>
                                            @foreach($tipeCoa as $t)
                                                <option value="{{ $t->nama }}">{{ $t->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%">
                                        Kode*
                                    </th>
                                    <td width="85%">
                                        <input type="text" name="kode" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%">
                                        Nama*
                                    </th>
                                    <td width="85%">
                                        <input type="text" name="nama" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>
                                        <textarea name="deskripsi" class="form-control" id="keterangan" cols="30" rows="3"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @include('component.button-create', ['route' => route('bukubesar.coa.index')])
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</form>

@endSection