<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\BrandLaptop;
use App\ProdukLaptop;

use Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Exception;

class LaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

            public function getBrand()
                {
                    $croso = BrandLaptop::get();
                
                    return DataTables::of($croso)
                        ->addColumn('totalassetbrand', function ($data) {
                            return 'Rp ' . number_format((float)$data->totalassetbrand, 0, ',', '.');
                        })
                        ->addColumn('action', function ($data) {
                            $val = array(
                                'id'              => $data->id,
                                'nama_brand'      => $data->nama_brand,
                                'description'     => $data->description,
                            );
                            return "<button data-url='" . route('Delete', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete-btn' title='Delete'><i class='fa fa-trash'></i></button>
                            <a href=" . route('brandlaptop.invoice', $data->id) . " class='btn btn-sm btn-outline-info btn-square' title='View invoice'><i class='fa fa-product-hunt'></i></a>
                            <a href='" . route('exportPdf', ['id' => $data->id]) . "' class='btn btn-light text-capitalize' data-mdb-ripple-color='dark'>
                                <i class='far fa-file-pdf text-danger'></i> Export
                            </a>";
                        })
                        ->addColumn('operations', function ($data) {
                            $buttonLabel = $data->status == 'Active' ? 'Change to Inactive' : 'Change to Active';
                            $buttonClass = $data->status == 'Active' ? 'btn-success' : 'btn-danger';
                            $buttonStatus = $data->status == 'Active' ? 'Inactive' : 'Active';
                            
                            return "<button data-id=" . $data->id . " class='btn btn-sm btn-square js-swal-delete2 " . $buttonClass . "' data-status='" . $buttonStatus . "'><i class='si si-check mr-2'></i>" . $data->status . "</button>";
                        })
                        ->rawColumns(['action','totalassetbrand','operations'])
                        ->make(true);
                }
            
                public function activeLaptop($id)
                {
                    $brandLaptop = BrandLaptop::findOrFail($id);
                
                    if ($brandLaptop->status == 'Active') {
                        $brandLaptop->status = 'Inactive';
                        $message = 'Successfully deactivated ' . $brandLaptop->nama_brand;
                    } else {
                        $brandLaptop->status = 'Active';
                        $message = 'Successfully activated ' . $brandLaptop->nama_brand;
                    }
                
                    $brandLaptop->save();
                
                    return response()->json([
                        'type' => 'success',
                        'message' => $message,
                    ]);
                }

            public function viewInvoice($id)
                {
                    $brand = BrandLaptop::findOrFail($id);
                    return view('brandlaptop.invoice', compact('brand'));
                }

            public function AddBrandLaptop(Request $request)
                {
                    $data = $request->all();

                    $limit = [
                        'nama_brand' => 'required|unique:brand_laptops,nama_brand|max:20'
                    ];

                    $validator = Validator::make($data, $limit);

                    if ($validator->fails()) {
                        return response()->json([
                            'success' => false,
                            'errors' => $validator->errors()
                        ], 422);
                    }

                    try {
                        DB::beginTransaction();

                        $brand = BrandLaptop::create([
                            'nama_brand' => $request->nama_brand,
                            'status' => $request->status,
                            'description' => $request->description
                        ]);

                        if ($request->has('nama_laptop')) {
                            foreach ($request->nama_laptop as $index => $namaLaptop) {
                                if (!empty($namaLaptop)) {
                                    $price = str_replace(',', '', $request->price[$index]);
                                    $discount = $request->discount[$index];
                                    $quantity = $request->quantity[$index];
                                    if (!empty($discount)) {
                                        $total = $price * $quantity * (1 - $discount / 100);
                                    } else {
                                        $total = $price * $quantity;
                                    }
                                    $produkData = [
                                        'brand_laptop_id' => $brand->id,
                                        'nama_laptop'     => $namaLaptop,
                                        'price'           => $price,
                                        'discount'        => $discount,
                                        'quantity'        => $quantity,
                                        'total'           => $total 
                                    ];

                                    if ($request->hasFile('file') && $request->file('file')[$index]->isValid()) {
                                        $gambar = $request->file('file')[$index];
                                        $gambarPath = $gambar->store('uploads', 'public');
                                        $produkData['file'] = $gambarPath;
                                    }

                                    DB::table('produk_laptop')->insert($produkData);
                                }
                            }

                            $totalAsset = DB::table('produk_laptop')
                                ->where('brand_laptop_id', $brand->id)
                                ->sum('total');

                            // Update total asset brand
                            BrandLaptop::where('id', $brand->id)
                                ->update(['totalassetbrand' => $totalAsset]);

                            DB::commit();

                            return response()->json([
                                'success' => true,
                                'message' => 'Successfully added Brand and Laptop!'
                            ]);
                        } else {
                            return response()->json([
                                'success' => true,
                                'message' => 'Berhasil menambahkan !'
                            ], 200);
                        }
                    } catch (\Exception $e) {
                        DB::rollback();

                        return response()->json([
                            'success' => false,
                            'message' => 'An error occurred: ' . $e->getMessage()
                        ], 500);
                    }
                }

                public function produkLaptop()
                {
                    return $this->hasMany(ProdukLaptop::class, 'brand_laptop_id')->withTrashed();
                }

                public function destroy($id)
                {
                    $brand = BrandLaptop::findOrFail($id);
                    ProdukLaptop::where('brand_laptop_id', $brand->id)->delete();
                    $brand->delete();

                    return response()->json(['message' => 'BrandLaptop berhasil dihapus']);
                }

                public function exportPdf($id)
                {
                    $brand = BrandLaptop::findOrFail($id);
            
                    $data = [
                        'brand' => $brand,
                    ];
            
                    $dompdf = new Dompdf();
            
                    try {
                        $html = view('brandlaptop.detail-invoice', $data)->render();
                        $dompdf->loadHtml($html);
                        $dompdf->setPaper('A4', 'portrait');
                        $dompdf->render();
            
                        return $dompdf->stream('detail-invoice.pdf');
                    } catch (Exception $e) {
                        // Tangani exception jika terjadi error saat memproses PDF
                        return $e->getMessage();
                    }
                }

        
}