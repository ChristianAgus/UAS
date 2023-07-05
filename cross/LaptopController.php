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

     public function getLaptop()
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
     
    }