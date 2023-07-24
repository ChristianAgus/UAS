@extends('layouts.office')
@section('title')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
                    <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                        <i class="si si-printer"></i>
                    </button>
                    <a href="{{ route('export.pdf', ['id' => $order->id]) }}" class="btn btn-primary" target="_blank">Export to PDF</a>
            <hr>
            <div class="invoice-title">
                <h2>Invoice</h2>
                <h3 class="pull-right">Order #{{ $order->id }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        {{ $order->customer_name }} <br>
                        {{ $order->customer_address }}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{ $order->customer_name }}<br>
                        {{ $order->customer_address }}<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        Visa ending **** 4242<br>
                        jsmith@email.com
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{ $order->created_at }}<br><br>
                    </address>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <td><strong>Code</strong></td>
                                            <td class="text-center"><strong>Device</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-center"><strong>Discount</strong></td>
                                            <td class="text-right"><strong>Totals</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderlist as $list)
                                        <tr>
                                            <td>{{ $list->device_code }}</td>
                                            <td class="text-center">{{ $list->device_name }}</td>
                                            <td class="text-center">Rp {{ number_format($list->device_price, 0, ',', ',') }}</td>
                                            <td class="text-center">{{ $list->qty }}</td>
                                            <td class="text-center">{{ $list->discount }}%</td>
                                            <td class="text-right">Rp {{ number_format($list->sub_total, 0, ',', ',') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-9">
                        </div>
                        <div class="col-xl-3">
                            <div class="text-black float-start">
                                <span class="text-black me-3" style="font-size: 25px;">Total </span>
                                <span style="font-size: 25px;">Rp {{ number_format($order->total_price, 0, ',', ',') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
</div>
    
@endsection

@section('css')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
@section('script')
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection
