@extends('layouts.office')
@section('title')
@section('content')
<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <p style="color: #7e8d9f;font-size: 20px;">Invoice  <strong> #{{ $brand->id }}</strong></p>
                    </div>
                    <div class="col-xl-3 float-end">

                        <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark" onclick="printDiv('printArea')"><i
                            class="fas fa-print text-primary"></i> Print</a>
                            <a href="{{ route('exportPdf', ['id' => $brand->id]) }}" class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <i class="far fa-file-pdf text-danger"></i> Export
                            </a>
                    </div>
                </div>
                <hr>
        <div id="printArea">
                <div class="container">
                    <div class="col-md-12">
                        <div class="text-center">
                            <p class="pt-0"><strong style="color: #5d9fc5; font-size: 24px;">{{ $brand->nama_brand }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8">
                            <ul class="list-unstyled">
                                <li class="text-muted">To: <span style="color:#5d9fc5 ;">Direktur</span></li>
                                <li class="text-muted">Jl. Irian V Blok MM-2, Kawasan Industrial MM2100</li>
                                <li class="text-muted">Bekasi, Indonesia</li>
                                <li class="text-muted"><i class="fas fa-phone"></i> (021) 89981788</li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <p class="text-muted">Invoice</p>
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="fw-bold">ID:</span>#{{ $brand->id }}</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="fw-bold">Creation Date: </span>{{ $brand->created_at }}</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="me-1 fw-bold">Status:</span><span
                                        class="badge bg-warning text-black fw-bold">{{ $brand->status }}</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-striped table-borderless">
                            <thead style="background-color:#84B0CA ;" class="text-white">
                                <tr>
                                    <th scope="col">Laptop Name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brand->produkLaptop as $produk)
                                <tr>
                                    <td>{{ $produk->nama_laptop }}</td>
                                    <td>{{ $produk->quantity }}</td>
                                    <td>Rp {{ number_format($produk->price, 0, ',', ',') }}</td>
                                    <td>{{ $produk->discount }}%</td>
                                    <td>Rp {{ number_format($produk->total, 0, ',', ',') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-xl-9">
                        </div>
                        <div class="col-xl-3">
                            <p class="text-black float-start"><span class="text-black me-3">Total </span><span style="font-size: 25px;">Rp {{ number_format($brand->totalassetbrand, 0, ',', ',') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .border-cus {
        border: 2px solid #1b1c1c;
    }

    .table .custom {
        padding: 2px;
    }

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