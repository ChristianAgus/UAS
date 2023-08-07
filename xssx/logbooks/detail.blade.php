@extends('layouts.office')
@section('title')
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Data Visitor Summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Nama</td>
                                    <td>Company</td>
                                    <td>Pegawai</td>
                                    <td>Divisi</td>
                                    <td>Tujuan Kunjungan</td>
                                    <td>Relation Type</td>
                                    <td>Telephone</td>
                                    <td>Email</td>
                                    <td>Jam Kunjungan</td>
                                </tr>
                            </thead>
                            <tbody>
                              
                                <tr>
                                    <td>{{ $detail->id }}</td>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->company }}</td>
                                    <td>{{ $detail->visitdivisi->name }}</td>
                                    <td>{{ $detail->division_visitee  }}</td>
                                    <td>{{ $detail->tujuan_kunjungan }}</td>
                                    <td>{{ $detail->relation_type }}</td>
                                    <td>{{ $detail->no_telp }}</td>
                                    <td>{{ $detail->email}}</td>
                                    <td>{{ $detail->jam }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .block-content p {
        margin-bottom: 0px;
    }
    .table thead th {
        border-top: none;
        border-bottom: none;
        text-transform: none;
        color: black;
        vertical-align: middle;
    }
    .table tbody td {
        vertical-align: middle;
    }
    </style>
@endsection