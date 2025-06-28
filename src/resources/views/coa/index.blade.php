@extends('template::layouts.app')

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
                        <a href="{{ route('coa.index') }}">Daftar Coa</a>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('coa.create') }}" class="btn btn-primary">Buat Daftar Coa</a>
                    <hr>
                    <table class="table table-striped" id="tabel_dt">
                        <thead>
                            <tr>
                                <th style="text-align: left">Kode</th>
                                <th style="text-align: left">Nama</th>
                                <th style="text-align: left">Keterangan</th>
                                <th>Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>
                                        <a href="{{ route('coa.edit', $i->id) }}">{{ $i->kode }}</a>
                                    </td>
                                    <td>{{ $i->nama }}</td>
                                    <td>{{ $i->keterangan }}</td>
                                    <td>{{ $i->tipe_coa }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabel_dt').DataTable()
    })
</script>
@endsection