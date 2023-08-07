@extends('layouts.office')
@section('title', "Update Data Visitor")
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content" id="content">
    <div class="block block-fx-shadow">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-gd-sea p-10">
                <h3 class="block-title"><i class="fa fa-user mr-1"></i>Update Visitor</h3>
            </div>
        </div>
        <div id="alert" class="alert" style="display: none;"></div>
        <form method="post" action="{{ route('updateLogbook', ['id' => $order->id]) }}" id="editVisitor" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="block-content">
                <div id="alert3" class="alert alert-info" style="display:none;"></div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Nama Pengunjung<span style="color: blue;"> *</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control nama" id="editPengunjungName" name="pengunjung_name" value="{{ $order->name }}" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Company<span style="color: blue;"> *</span></label>
                        <div class="input-group">
                             <input type="text" class="form-control adress" id="editCompany" name="company" value="{{ $order->company }}" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="addPegawai">Pegawai yang Ditemui<span style="color: blue;"> *</span></label>
                        <select class="js-select22 form-control" id="editPegawai" name="pegawai" required>
                            @foreach(App\User::where('isActive', 1)->orderBy('name', 'ASC')->get() as $data)
                                <option value="{{ $data->id }}" {{ $data->id == $order->name_visitee? 'selected' : '' }}>
                                    {{ $data->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                      <div class="form-group col-md-6">
                        <label>Divisi<span style="color: blue;"> *</span></label>
                        <input type="text" class="form-control divisi" id="editDivisi" name="divisi" value="{{ $order->division_visitee }}" maxlength="11" required readonly>
                    </div>
                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 100%;"><i class="fas fa fa-window-restore"></i></span>
                                </div>
                                <textarea class="form-control" name="deskripsi" rows="5" placeholder="Tujuan Kunjungan *" required>{{ $order->tujuan_kunjungan }}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Relation Type<span style="color: blue;"> *</span></label>
                            <div class="input-group">
                                <select class="form-control" id="editStatus" name="status" required>
                                    <option value="customer" {{ $order->relation_type == 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="vendor" {{ $order->relation_type == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                    <option value="recruiter" {{ $order->relation_type == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                                    <option value="other" {{ $order->relation_type == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Jam Bertemu<span style="color: blue;"> *</span></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select class="form-control js-select2 ftime" id="editJam" name="jam" style="width:100%;" required>
                                        <?php
                                        $start_time = strtotime('07:30');
                                        $end_time = strtotime('16:30');
                                        while ($start_time <= $end_time) {
                                            $jam = date('H:i', $start_time);
                                            echo "<option value=\"$jam\" " . ($order->jam == $jam ? 'selected' : '') . ">$jam</option>";
                                            $start_time = strtotime('+30 minute', $start_time);
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="form-group col-md-6">
                                <label>No.Telp<span style="color: blue;"> *</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control telp" id="editTelp" name="notelp" value="{{ $order->no_telp }}" required maxlength="13" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>E-mail<span style="color: blue;"> </span></label>
                                <div class="input-group">
                                    <input type="email" class="form-control email" id="editEmail" name="email" value="{{ $order->email }}" required maxlength="50">
                                    <div class="invalid-feedback">Email tidak valid.</div>
                                </div>
                            </div>
                 </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-alt-primary" id="btnSubmit">
                                <i class="fa fa-save mr-2"></i>Submit
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-alt-secondary" data-dismiss="modal">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
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
        $('.telp').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
        $('.telp').on('keyup', function() {
            var maxLength = 13;
            if ($(this).val().length > maxLength) {
                $(this).val($(this).val().slice(0, maxLength));
            }
        });
        $(".js-select2").select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
        $("#editPegawai").select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
        $('#editPegawai').change(function () {
            var selectedUserId = $(this).val();
            $.ajax({
                url: '/VisitorLogBook/edit/getDivisi/' + selectedUserId,
                type: 'GET',
                success: function (response) {
                    $('#editDivisi').val(response.divisi);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
  });
  $("#editVisitor").on("submit", function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();
            $.ajax({
                url: url,
                type: method,
                data: data,
                beforeSend: function() {
                    $("#btnSubmit").attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');
                },
                success: function(data) {
                    $("#btnSubmit").attr('disabled', false).html('Submit');
                    $("#alert").removeClass('alert-danger').addClass('alert-info').html(data.message).show();
                    reloadDataTable();
                    form.trigger("reset");
                    setTimeout(function() {
                        $("#alert").hide();
                    }, 100);
                    window.location.href = '/VisitorLogBook';
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#btnSubmit").attr('disabled', false).html('Submit');
                    var err = JSON.parse(xhr.responseText);
                    var errorMessage = "<i class='em em-email em-svg mr-2'></i>" + err.message;
                    $("#alert").removeClass('alert-info').addClass('alert-danger').html(errorMessage).show();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                },
                cache: false
            });
        });
        function reloadDataTable() {
        $('#dataTable').DataTable().ajax.reload();
    }

</script>
@endsection