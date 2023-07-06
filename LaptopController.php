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
             
             ->addColumn('action', function ($data) {
                 $val = array(
                     'id'            => $data->id,
                     'nama_brand'    => $data->nama_brand,
                     'description'   => $data->description,
                     'status'        => $data->status,
                 );
                 return "<a href='javascript:void(0)' onclick='EditCrossan(" . json_encode($val) . ")' class='btn btn-sm btn-primary btn-square' title='Update'><i class='fa fa-edit'></i></a>
                 <button data-url='" . route('Delete.Crossan', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete' title='Delete'><i class='fa fa-trash'></i></button>
                 ";
             })
             ->editColumn('price', function ($data) {
                 return $data->formatted_price;
             })
             ->rawColumns(['action',])
             ->make(true);
     }

          public function AddBrandLaptop(Request $request)
     {
         $data = $request->all();
     
         $limit = [
             'nama_brand' => 'required|max:20',
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
         
             if ($request->input('nama_laptop')) {
                foreach ($request->input('nama_laptop') as $index => $namaLaptop) {
                    if (!empty($namaLaptop)) {
                        $produkData = array(
                            'brand_laptop_id' => $brand->id,
                            'nama_laptop' => $namaLaptop,
                            'price' => $request->price[$index],
                            'discount' => $request->discount[$index],
                            'quantity' => $request->quantity[$index]
                        );
            
                        if ($request->hasFile('file') && $request->file('file')[$index]->isValid()) {
                            $gambar = $request->file('file')[$index];
                            $gambarPath = $gambar->store('uploads', 'public');
                            $produkData['file'] = $gambarPath;
                        }
            
                        DB::table('produk_laptop')->insert($produkData);
                     }
                 }
                 DB::commit();
                    return response()->json([
                        'type'      => 'info',
                        'message'   => '<i class="em em-email em-svg mr-2"></i>Successfully added Sample Request!'
                    ]);
                } else {
                    return response()->json([
                        'type' 		=> 'warning',
                        'message'	=> '<i class="em em-email em-svg mr-2"></i>Please try again or contact the IT Dept ext.204!'
                    ]);
                }
            } catch (Exception $e) {
                DB::rollback();
                SampleServiceMaster::where('id', $insert->id)->delete();
                return response()->json([
                    'type'      => 'warning',
                    'message'   => $e->getMessage()
                ]);
            }
        }
}
     

