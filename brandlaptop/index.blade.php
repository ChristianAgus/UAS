@extends('layouts.office')
@section('title', "CMS My Haldin")
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="block block-themed"> 
        <div class="block-header bg-gd-sea pl-20 pr-20 pt-15 pb-15">
            <h3 class="block-title">Brand Laptop</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <div class="block">
            <div class="block-content block-content-full">
                <div class="block-header p-0 mb-20">
                    <div class="block-title">
                        <button class="btn btn-primary btn-square" data-toggle="modal" data-target="#addReq"><i class="fa fa-plus mr-2"></i>Add</button>
                    </div>
                </div>
                <table class="table table-bordered table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Brand</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Total Asset Brand</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div> 
    </div>
</div>

<div class="modal fade" id="addReq" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-registered mr-2"></i>Tambah Brand</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('AddBrandLaptop') }}" id="addBrandForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="block-content">
                    <div id="alert3" class="alert alert-info" style="display:none;"></div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Nama Brand Laptop<span style="color: blue;"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control nama" id="addbrand" name="nama_brand" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status<span style="color: blue;"> *</span></label>
                            <div class="input-group">
                                <select class="form-control" id="addstatus" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Description<span style="color: blue;"> *</span></label>
                            <textarea class="form-control" id="adddesc" name="description" required></textarea>
                        </div>
                        <input class="form-control" type="hidden" name="material_code[]" readOnly="readOnly" id="txt_name">
                        <div class="form-group col-md-6">
                            <label>Nama Laptop<span style="color: blue;"> *</span></label>
                            <input type="text" class="form-control nama" id="addnamalaptop" name="nama_laptop[]"  maxlength="20" required>
                        </div>  
                        <div class="form-group col-md-6">
                            <label>Price<span style="color: blue;"> *</span></label>
                            <input type="text" class="form-control price" id="addprice" name="price[]" required maxlength="11" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Discount<span style="color: blue;"> *</span></label>
                            <input type="text" class="form-control discount" id="addprice" name="discount[]" required maxlength="11" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Quantity<span style="color: blue;"> *</span></label>
                            <input type="text" class="form-control quantity" id="addqty" name="quantity[]" required maxlength="5" >
                         </div> 
                        <div class="form-group col-md-12">
                            <label for="addfile">File</label>
                            <input type="file" class="form-control-file" id="addfile" name="file[]" accept="image/*" multiple>
                            <small style="color:grey">* Tipe File: jpg, png</small><br>
                        </div>
                    </div>
                    <div class="emptyDivAddProdukFokus"></div>
                    <div class="form-group">
                        <div class="col-md-offset-4 text-center">
                            <a href="javascript:void(0)" class="btn btn-info btn-square" onclick="actAdd()"><i class="fa fa-plus mr-2"></i>Tambah Laptop</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <button type="submit" class="btn btn-alt-primary" id="btnSubmit1">Save</button>
                    <button type="button" style="display:none;" class="btn btn-alt-primary" id="btnLoading1"><i class="fa fa-spinner fa-spin"></i></button>
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-dropbox mr-2"></i>List Request Sample <b id="kodeHT"></b></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
            <div class="block-content" style="margin-top: -10px;margin-bottom: -20px;">
            </div>
            <div class="block-content" id="produkList">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="divAddProdukFokus" style="display:none;">
    <div id="addList">
        <div class="row form-group-product">
            <div class="form-group col-md-6">
                <label>Nama Laptop<span style="color: blue;"> *</span></label>
                <input type="text" class="form-control namadiv" name="nama_laptop[]" id="namalaptop" maxlength="20" required>
            </div>  
            <div class="form-group col-md-6">
                <label>Price<span style="color: blue;"> *</span></label>
                <input type="text" class="form-control price" id="price" name="price[]" required maxlength="11" required>
            </div>
            <div class="form-group col-md-6">
                <label>Discount<span style="color: blue;"> *</span></label>
                <input type="text" class="form-control discount" id="discount" name="discount[]" required maxlength="11" required>
            </div>
            <div class="form-group col-md-5">
                <label>Quantity<span style="color: blue;"> *</span></label>
                <input type="text" class="form-control quantity" id="qty" name="quantity[]" required maxlength="5" >
             </div> 
            <div class="form-group col-md-12">
                <label for="addfile">File</label>
                <input type="file" class="form-control-file" id="file" name="file[]" accept="image/*" multiple>
                <small style="color:grey">* Tipe File: jpg, png</small><br>
            </div>
            <div class="form-group col-md-1">
                <button id="buttonRemove" class="btn btn-warning" onclick="remLineAdd($(this))"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('additional-css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css') }}">
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
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
          visibility:hidden;
        }
        #printSection, #printSection * {
          visibility:visible;
        }
        #printSection {
          position:absolute;
          left:0;
          top:0;
        }
    }
    .modal-lg {
        max-width: 1200px;
    }
    .pac-container{z-index:2000 !important;}
</style>
@endpush

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <style>
        label {
            font-weight: 800;
        }
    </style>
@endsection

@push('additional-js')
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/select2-handler.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js') }}"></script>

@section('script')t
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
            $('.price').on('input', function() {
                 var input = $(this).val().replace(/[^0-9]/g, '');
                    if (input.length > 3) {
                        input = input.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                     }
                 $(this).val(input);
             });
             $('.quantity').on('input', function() {
                 var input = $(this).val().replace(/[^0-9]/g, '');
                 $(this).val(input);
             });
             $('.discount').on('input', function() {
                  var input = $(this).val().replace(/[^0-9]/g, '');
                  $(this).val(input);
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
                ajax: "{{ route('getBrand') }}",
                columns: [
                { data: 'nama_brand', name: 'nama_brand' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                { data: 'totalassetbrand', name: 'totalassetbrand' },
                { data: 'action', name: 'action' }
            ],
         });
    });
        function actAdd()
        {
            $('.emptyDivAddProdukFokus').append($('.divAddProdukFokus').html());
            $('#buttonRemove').attr('class', 'btn btn-warning');
            $('.emptyDivAddProdukFokus > #addList').attr('id', 'addList-' + $('.emptyDivAddProdukFokus > div').length);
            $('#' + 'addList-' + $('.emptyDivAddProdukFokus > div').length);
            $('#' + 'addList-' + $('.emptyDivAddProdukFokus > div').length + ' > div > .form-group > #price').attr('id', 'price_' + $('.emptyDivAddProdukFokus > div').length);
            $('#' + 'addList-' + $('.emptyDivAddProdukFokus > div').length + ' > div > .form-group > #discount').attr('id', 'discount_' + $('.emptyDivAddProdukFokus > div').length);
            $('#' + 'addList-' + $('.emptyDivAddProdukFokus > div').length + ' > div > .form-group > #qty').attr('id', 'qty_' + $('.emptyDivAddProdukFokus > div').length);
            $('#' + 'addList-' + $('.emptyDivAddProdukFokus > div').length + ' > div > .form-group > #namalaptop').attr('id', 'namalaptop_' + $('.emptyDivAddProdukFokus > div').length);
            price();
        }
        function price()
        {
            $('#price_' + $('.emptyDivAddProdukFokus > div').length).on('input', function() {
                 var input = $(this).val().replace(/[^0-9]/g, '');
                    if (input.length > 3) {
                        input = input.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                     }
                 $(this).val(input);
             });
             $('#discount_' + $('.emptyDivAddProdukFokus > div').length).on('input', function() {
                  var input = $(this).val().replace(/[^0-9]/g, '');
                  $(this).val(input);
             });
             $('#qty_' + $('.emptyDivAddProdukFokus > div').length).on('input', function() {
                 var input = $(this).val().replace(/[^0-9]/g, '');
                  $(this).val(input);
             });
             
        }
        function remLineAdd(event)
        {
          event.closest('.form-group-product').remove();
        }
            $(document).on('submit', '#addBrandForm', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = new FormData(form[0]);
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.btn-primary').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');
                    },
                    success: function(response) {
                        console.log(response);
                        $('#addReq').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                        form[0].reset();
                        $('.btn-primary').attr('disabled', false).html('Add');
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil ditambahkan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                        
                        if (err.errors && err.errors.title) {
                            var errorMessage = err.errors.title[0];
                            Swal.fire({
                                title: 'Warning',
                                text: errorMessage,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (err.errors && err.errors.file) {
                            var errorMessage = err.errors.file[0];
                            Swal.fire({
                                title: 'Warning',
                                text: errorMessage,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                title: 'Warning',
                                text: 'Terjadi kesalahan.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        $('.btn-primary').attr('disabled', false).html('Add');
                    }
                });
            });
        
</script>
@endsection
