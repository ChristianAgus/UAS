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
                            <th>file</th>
                            <th>lihat file</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form  id="addForm" action="{{ route('AddCrossan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataTitle">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addtitle">title</label>
                        <input type="text" class="form-control" id="addtitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="adddesc">Deskripsi</label>
                        <textarea class="form-control" id="adddesc" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addfile">File</label>
                        <input type="file" class="form-control-file" id="addfile" name="file">
                    </div>                                      
                    <div class="form-group">
                        <label for="addstatus">Pilih status todo</label>
                        <select class="form-control" id="addstatus" name="status">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-alt-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editdata" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
              <div class="block-header bg-gd-sea p-10">
                <h3 class="block-title"><i class="fa fa-edit"></i> Edit data</h3>
                <div class="block-options">
                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="si si-close"></i>
                  </button>
                </div>
              </div>
            </div>
            <form id="editForm" method="post" autocomplete="off">
                {!! method_field('PUT') !!}
                {!! csrf_field() !!}
                <div class="block-content">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="titleInput">Title</label><span style="color: blue;"> *</span>
                            <input type="text" class="form-control" name="title" id="titleInput" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="descInput">Description</label>
                            <input type="text" class="form-control" id="descInput" name="description">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="status">Select todo status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="fileInput">File</label>
                            <input type="file" class="form-control-file" id="fileInput" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Kembali</button>
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
                { data: 'file', name: 'file' },
                { data: 'file_link', name: 'file_link' },
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
        $('#addData').modal('hide');
        $('#dataTable').DataTable().ajax.reload();
        form[0].reset();
        $('.btn-primary').attr('disabled', false).html('Simpan');

        // Tampilkan notifikasi
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

        // Tampilkan notifikasi error
        Swal.fire({
          title: 'Warning',
          text: 'Title sudah digunakan.',
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        });
        $('.btn-primary').attr('disabled', false).html('Simpan');
      }
    });
  });
  function editModal(json) {
    $('#editdata').modal('show');
    $('#editForm').attr('action', "{{ url('/crossonto/editcros') }}/" + json.id);
    $('#titleInput').val(json.title);
    $('#descInput').val(json.description);
    $('#status').val(json.status);
    $('#file').val(json.file);
}
  $(document).on('submit', '#editForm', function(e) {
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
      $('#editData').modal('hide');
      $('#dataTable').DataTable().ajax.reload();
      form[0].reset();
      $('.btn-primary').attr('disabled', false).html('Update');

      // Tampilkan notifikasi
      Swal.fire({
        title: 'Sukses',
        text: 'Data berhasil diperbarui.',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
      });
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      console.log(err);

      // Tampilkan notifikasi error
      Swal.fire({
        title: 'Error',
        text: 'Terjadi kesalahan. Silakan coba lagi.',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
      });
      $('.btn-primary').attr('disabled', false).html('Update');
    }
  });
});
</script>

@endsection
