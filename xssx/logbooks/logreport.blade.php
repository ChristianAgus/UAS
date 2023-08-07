@extends('layouts.office')
@section('title', "Sample Report")
@section('content')
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
            <div class="block">
             <div class="block-content block-content-full form-inline">
                <form  class="form-inline" method="post" id="filter" autocomplete="off">
                    {!! csrf_field() !!}
                    <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <input type="text" class="form-control mb-2 mb-sm-0"" id="example-daterange1" name="from" placeholder="Date From" data-week-start="1" data-autoclose="true" data-today-highlight="true" required>
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text font-w600">to</span>
                        </div>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0"" id="example-daterange2" name="to" placeholder="Date To" data-week-start="1" data-autoclose="true" data-today-highlight="true" required>
                    </div>
                    <button type="submit" class="btn btn-alt-primary mr-2"><i class="fa fa-recycle mr-2"></i>Filter</button>
                </form>
                <form method="post" action="{{ route('LBReportExcel') }}" autocomplete="off">
                    {!! csrf_field() !!}
                    <input type="hidden" id="fromExcel" name="fromExcel">
                    <input type="hidden" id="toExcel" name="toExcel">
                    <input type="hidden" id="accExcel" name="account">
                    <button type="submit" class="btn btn-alt-success mr-2"><i class="fa fa-cloud-download mr-2"></i>Excel</button>
                    <input type="button" id="filterReset" class="btn btn-alt-secondary" value="Reset"/>
                </form>
            </div>
        </div>

    <div class="block block-themed" id="table-block" style="display: none">
        <div class="block">        
            <div class="block-content block-content-full">
            <table class="table table-bordered table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width:110px;">no</th>
                            <th style="width:220px;">visitor</th>
                            <th style="width:190px;">employee</th>
                            <th style="width:190px;">tujuan kunjungan</th>
                        </tr>
                    </thead>
                </table>
                </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection


@section('script')
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>jQuery(function(){ Codebase.helpers(['datepicker']); });</script>
<script>
    $(document).ready(function() { 
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $("#example-daterange1").change(function(){
        var from = $('#example-daterange1').val();
        $('#fromExcel').val(from);
    });
    $("#example-daterange2").change(function(){
        var to = $('#example-daterange2').val();
        $('#toExcel').val(to);
    });
  

    $("#filterReset").click(function () {
        $('#example-daterange1').val(null);
        $('#example-daterange2').val(null);
    });
    $('#filter').submit(function(e) {
        $('#table-block').hide();
        e.preventDefault();
        var table = null;
        var url = '{!! route('LBReportPOST') !!}';
        table = $('#dataTable').DataTable({
            processing: true,
            ajax: {
                url: url + "?" + $("#filter").serialize(),
                type: 'POST',
                dataType: 'json',
                dataSrc: function(res) {
                    $('#table-block').show();
                    return res.data;
                },error: function (data) {
                    $('#table-block').hide();
                },
            },
            columns: [
                { data: 'date', name: 'date'},
                { data: 'name', name: 'name'},
                { data: 'employee', name: 'employee'},
                { data: 'relation', name: 'relation'}
            ],
            bDestroy: true
        });
    });
</script>
@endsection