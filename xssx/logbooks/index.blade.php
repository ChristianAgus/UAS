@extends('layouts.office')
@section('title', "CMS My Haldin")
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-12 col-xs-3">
            <div class="block block-content">
                <div class="nav nav-pills push">
                    <li class="nav-item">
                        <a href="{{ route('logbooks.index') }}" class="nav-link {{ request()->is('VisitorLogBook') ? 'active' : '' }}">
                            <i class="fa fa-file mr-2"></i>Visitor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('LBReport') }}" class="nav-link {{ request()->is('VisitorLogBook/LB-Report') ? 'active' : '' }}">
                            <i class="fa fa-star mr-2"></i>Report
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </div>
     <div class="block block-themed">
          <div class="block">
            <div class="block-content block-content-full">
                 <div class="block-header p-0 mb-20">
                     <div class="block-title">
                        <a href="{{ route('logbooks.addvisitor') }}" class="btn btn-primary btn-square"><i class="fa fa-plus mr-2"></i>Add Visitor</a>                    
                     </div>
                   </div>                    
                    <table class="table table-bordered table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Personel Meet</th>
                            <th>Tujuan kunjungan</th>
                            <th>Relation Type</th>
                            <th>Jam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div> 
    </div>
</div>
<div class="modal fade" id="detailvisit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h2 class="block-title"><i class="fa fa-file mr-2"></i>Detail Visitor</h2>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>            
            <div class="modal-body">
                <div class="block-content">
                    <div id="alert4" class="alert alert-info" style="display:none;"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-vcenter modal-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>Company</th>
                                        <th>Pegawai</th>
                                        <th>Divisi</th>
                                        <th>Tujuan Kunjungan</th>
                                        <th>Relation Type</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Jam Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody id="list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <style>
        label {
            font-weight: 800;
        }
    </style>
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 34px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        }
        .modal-dialog.modal-full {
    </style>
@endsection

@section('script')
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/select2-handler.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
   $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".detail-visit-btn").click(function () {
                 var visitId = $(this).data("visit-id");
                 getDetailVisit(visitId);
            });
            $('.delete-btn').click(function() {
            var brandId = $(this).data('id');
            $.ajax({
                url: 'delete',
                type: 'DELETE',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            });
          $("#dataTable").DataTable({
                drawCallback: function(){
                    $('.delete-btn').on('click', function(){
                        var routers = $(this).data("url");
                        swal({
                            title: 'Anda Yakin?',
                            text: 'Data yang dihapus tidak dapat dikembalikan lagi!',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d26a5c',
                            confirmButtonText: 'Iya, hapus!',
                            html: false,
                            preConfirm: function() {
                                return new Promise(function (resolve) {
                                    setTimeout(function () {
                                        resolve();
                                    }, 50);
                                });
                            }
                        }).then(function(result){
                            if (result.value) {
                                $.ajax({
                                    url: routers,
                                    type: 'GET',
                                    success: function (data) {
                                        $("#dataTable").DataTable().ajax.reload();
                                    }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                        alert(errorThrown);
                                    },    
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            } else if (result.dismiss === 'cancel') {
                                swal('Cancelled', 'Your data is safe :)', 'error');
                            }
                        });
                    });
                 },
                processing: true,
                serverSide: true,
                ajax: "{{ route('getlogbook') }}",
                columns: [
                { data: 'name', name: 'name' },
                { data: 'name_visitee', name: 'name_visitee' },
                { data: 'tujuan_kunjungan', name: 'tujuan_kunjungan' },
                { data: 'relation_type', name: 'relation_type' },
                { data: 'jam', name: 'jam' },
                { data: 'action', name: 'action' }
            ],
         });
    });
    function openDetailModal(data) {
    $('#detailvisit').modal('show');
    $('#list').html(`
        <tr>
            <td>${data.id}</td>
            <td>${data.name}</td>
            <td>${data.company}</td>
            <td>${data.name_visitee}</td>
            <td>${data.division_visitee}</td>
            <td>${data.tujuan_kunjungan}</td>
            <td>${data.relation_type}</td>
            <td>${data.no_telp}</td>
            <td>${data.email}</td>
            <td>${data.jam}</td>
        </tr>
    `);
}

    </script>

@endsection
