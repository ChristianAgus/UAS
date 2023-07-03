@extends('layouts.office')
@section('title', "CMS My Haldin")
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="block block-themed"> 
        <div class="block-header bg-gd-sea pl-20 pr-20 pt-15 pb-15">
            <h3 class="block-title">ProjectITintership</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <div class="block">
            <div class="block-content block-content-full">
                <div class="block-header p-0 mb-20">
                    <div class="block-title">
                        <button class="btn btn-primary btn-square" data-toggle="modal" data-target="#addData"><i class="fa fa-plus mr-2"></i>Add</button>
                    </div>
                </div>
                <table class="table table-bordered table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th>title</th>
                            <th>description</th>
                            <th>status</th>
                            <th>price</th>
                            <th>discount</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>file</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div> 
    </div>
</div>

<!-- Modal Tambah Data -->

<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addDataTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-pencil mr-2"></i>Add Data</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
        <div class="modal-content">
            <form  id="addForm" action="{{ route('AddCrossan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label><code style="color:blue;"> *</code>
                        <input type="text" class="form-control title" id="addtitle" name="title" required maxlength="5">
                    </div>
                    <div class="form-group">
                        <label>Description</label><code style="color:blue;"> *</code>
                        <textarea class="form-control" id="adddesc" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addfile">File</label>
                        <input type="file" class="form-control-file" id="addfile" name="file">
                        <small style="color:grey">* Tipe File: jpg, png, doc, docx , pdf, xlsx,& xls</small><br>
                    </div>                                      
                    <div class="form-group">
                        <label for="addstatus">Pilih status todo</label>
                        <select class="form-control" id="addstatus" name="status">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label><code style="color:blue;"> *</code>
                        <input type="text" class="form-control price" id="addprice" name="price" required maxlength=11">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label><code style="color:blue;"> *</code>
                        <input type="text" class="form-control quantity" id="addquantity" name="quantity" required maxlength="3">
                    </div>
                    <div class="form-group">
                        <label>Discount %</label><code style="color:blue;"> *</code>
                        <input type="text" class="form-control discount" id="adddiscount" name="discount" maxlength="2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-alt-primary">
                        <i class="fa fa-save"></i> Add
                    </button>
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editData" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-pencil mr-2"></i>Edit Document</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            <form action="{{ route('EditCrossan') }}" method="post" autocomplete="off" id="formSubmit1">
                {!! csrf_field() !!}
                @method('PUT')
                <div class="block-content">
                    <div id="alert1" class="alert alert-primary"></div>
                    <input type="hidden" name="id" class="docID">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Title</label><code style="color:blue;"> *</code>
                            <input type="text" name="title" class="form-control title" required maxlength="5">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Description</label><code style="color:blue;"> *</code>
                            <input type="text" name="description" class="form-control description">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="addstatus">Pilih status todo</label>
                            <select class="form-control status" id="addstatus" name="status">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Price</label><code style="color:blue;"> *</code>
                            <input type="text" name="price" class="form-control price" required maxlength="11">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Quantity</label><code style="color:blue;"> *</code>
                            <input type="text" name="quantity" class="form-control quantity" required maxlength="3">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Discount</label><code style="color:blue;"> *</code>
                            <input type="text" name="discount" class="form-control discount" maxlength="2">
                        </div>
                            <div class="form-group col-md-12">
                              <label>File Submission</label><span class="badge badge-secondary ml-1">Optional</span>
                              <input type="file" name="file" class="form-control" accept='.doc, .docx,.pdf,.xlsx,.xls,.png,.jpg'>
                              <small style="color:grey">* Tipe File: jpg, png, doc, docx , pdf, xlsx,& xls</small><br>
                              <small style="color:grey"><b>NB : </b>Jika tidak ingin mengubah file sebelumnya, kosongkan saja.</small>
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


@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <style>
        label {
            font-weight: 800;
        }
    </style>
@endsection

@section('script')

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
            $('.title').on('input', function() {
                var title = $(this).val();
                var formattedTitle = title.replace(/\s/g, '');
                   formattedTitle = formattedTitle.charAt(0).toUpperCase() + formattedTitle.slice(1);
                 $(this).val(formattedTitle); 
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
                    $('.delete').on('click', function(){
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
                ajax: "{{ route('getData') }}",
                columns: [
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                { data: 'formatted_price', name: 'formatted_price' },
                { data: 'formatted_discount', name: 'formatted_discount' },
                { data: 'quantity', name: 'quantity' },
                { data: 'total', name: 'total' },
                { data: 'file', name: 'file' },
                { data: 'action', name: 'action' }
            ],
            });
        });
        function addModal(json) {
  $('#addData').modal('show');
  $('#addForm').attr('action', "{{ route('AddCrossan') }}");
  $('#addtitle').val(json.title);
  $('#adddesc').val(json.description);
  $('#addstatus').val(json.status);
  $('#addprice').val(json.price);
  $('#addquantity').val(json.quantity);
  $('#adddiscount').val(json.discount);
}
$(document).on('submit', '#addForm', function(e) {
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
            $('#addData').modal('hide');
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
  function EditCrossan(json) {
            $('#editData').modal('show');
            $('.docID').val(json.id);
            $('.title').val(json.title);
            $('.description').val(json.description);
            $('.status').val(json.status);
            $('.price').val(json.price);
            $('.quantity').val(json.quantity);
            $('.discount').val(json.discount);
        }
        $("#formSubmit1").submit(function(e){
            e.preventDefault();    
            var formData = new FormData(this);
            $("#btnLoading1").show();
            $("#btnSubmit1").hide();
            $("#alert1").removeClass('alert alert-danger');
            $("#alert1").removeClass('alert alert-primary');
            $("#alert1").html('');
            $("#alert1").hide();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (data) {
                    console.log(data.type);
                    $("#btnSubmit1").show();
                    $("#btnLoading1").hide();
                    if (data.type == "info") {
                        $("#alert1").addClass('alert alert-primary');
                        $("#alert1").show();
                        $("#alert1").html(data.message);
                        $("#editData").animate({scrollTop: $("#editData").offset().top});
                        $("#editData").modal('hide');
                        $("#dataTable").DataTable().ajax.reload();
                    } else {
                        $("#editData").animate({scrollTop: $("#editData").offset().top});
                        $("#alert1").addClass('alert alert-danger');
                        $("#alert1").show();
                        $("#alert1").html(data.message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#editData").animate({scrollTop: $("#editData").offset().top});
                    $("#alert1").addClass('alert alert-danger');
                    $("#alert1").show();
                    $("#alert1").html("<i class='em em-email mr-2'></i>"+xhr.responseText);
                    $("#btnSubmit1").show();
                    $("#btnLoading1").hide();
                },  
                cache: false,
                contentType: false,
                processData: false
            });
        });
</script>

@endsection
