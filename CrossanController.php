<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\Crossan;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use File;

class CrossanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getData()
     {
         $croso = Crossan::get();
     
         return DataTables::of($croso)
             ->addColumn('file_link', function ($data) {
                 $fileLink = ($data->file) ? "<a href='" . asset('uploads') . '/' . $data->file . "' class='btn btn-sm btn-warning btn-square popup-image' title='download' download><i class='fa fa-download'></i></a>" : "";
                 return $fileLink;
             })
             ->addColumn('formatted_price', function ($data) {
                 $formattedPrice = "Rp " . number_format((float) $data->price, 0, ",", ",");
                 return $formattedPrice;
             })
             ->addColumn('formatted_discount', function ($data) {
                $formattedDiscount = ($data->discount) ? $data->discount . '%' : '';
                return $formattedDiscount;
            })
    
             ->addColumn('total', function ($data) {
                if ($data->discount) {
                    $total = $data->price * $data->quantity * (1 - $data->discount / 100);
                } else {
                    $total = $data->price * $data->quantity;
                }
                $data->total = $total;
                $data->save();
                return "Rp " . number_format((float) $total, 0, ",", ",");
             })
             ->addColumn('action', function ($data) {
                 $fileLink = ($data->file) ? "<a href='" . asset('uploads') . '/' . $data->file . "' class='btn btn-sm btn-warning btn-square popup-image' title='Download' download><i class='fa fa-download'></i></a>" : "";
                 $val = array(
                     'id'            => $data->id,
                     'title'         => $data->title,
                     'description'   => $data->description,
                     'status'        => $data->status,
                     'file'          => $data->file,
                     'price'         => $data->price,
                     'quantity'      => $data->quantity,
                     'discount'      => $data->discount,
                 );
                 return "<a href='javascript:void(0)' onclick='EditCrossan(" . json_encode($val) . ")' class='btn btn-sm btn-primary btn-square' title='Update'><i class='fa fa-edit'></i></a>
                 <button data-url='" . route('Delete.Crossan', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete' title='Delete'><i class='fa fa-trash'></i></button>
                 " . $fileLink;
             })
             ->editColumn('price', function ($data) {
                 return $data->formatted_price;
             })
             ->rawColumns(['formatted_price', 'total', 'action','formatted_discount'])
             ->make(true);
     }
     


        public function AddCrossan(Request $request)
        {
            $data = $request->all();
            $limit = [
                'title' => 'required|unique:crossans|string|max:5',
                'file' => 'mimes:jpg,png,pdf,docx,doc,docx,pdf,xlsx,xls|max:2048'
            ];
            $validator = Validator::make($data, $limit);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $this->createUploadsFolder();
                $crossan = new Crossan();
                $crossan->title = $request->input('title');
                $crossan->description = $request->input('description');
                $crossan->status = $request->input('status');
                $crossan->price = str_replace(',', '', $request->input('price'));
                $crossan->quantity = $request->input('quantity');
                $crossan->discount = $request->input('discount');
                if (!empty($crossan->discount)) {
                    $crossan->total = $crossan->price * $crossan->quantity * (1 - $crossan->discount / 100);
                } else {
                    $crossan->total = $crossan->price * $crossan->quantity;
                }
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $filename = $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $crossan->file = $filename;
                }
                $crossan->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan !'
                ], 200);
            }
        }
        
        public function createUploadsFolder()
        {
            $folderPath = public_path('uploads');
            
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }
        }


        public function EditCrossan(Request $request)
        {
            $dataEdit = Crossan::where('id', $request->id)->first();
            if ($dataEdit) {
                $data = $request->all();
                $limit = [
                    'title' => 'required|max:5',
                ];
                $validator = Validator::make($data, $limit);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'warning',
                        'message' => "<i class='em em-email mr-2'></i>" . $validator->errors()->first()
                    ]);
                } else {
                    try {
                        DB::beginTransaction();
                        $dataEdit->title = $request->input('title');
                        $dataEdit->description = $request->input('description');
                        $dataEdit->status = $request->input('status');
                        $dataEdit->price = str_replace(',', '', $request->input('price'));
                        $dataEdit->quantity = $request->input('quantity');
                        $dataEdit->discount = $request->input('discount');
                        if (!empty($dataEdit->discount)) {
                            $dataEdit->total = $dataEdit->price * $dataEdit->quantity * (1 - $dataEdit->discount / 100);
                        } else {
                            $dataEdit->total = $dataEdit->price * $dataEdit->quantity;
                        }
                                
                        if ($request->hasFile('file')) {
                            $size = (int) $request->file('file')->getSize();
                            $file_name = $request->id . "_" . preg_replace('/\s+/', '', $request->file('file')->getClientOriginalName());
                            $request->file('file')->move(public_path() . '/uploads/', $file_name);
                            
                            $path = public_path() . '/uploads/' . $dataEdit->file;
                            if (File::exists($path)) {
                                File::delete($path);
                            }
                            
                            $dataEdit->file = $file_name;
                        }
                        
                        $dataEdit->save();
                        DB::commit();
                        
                        return response()->json([
                            'type' => 'info',
                            'message' => "<i class='em em-email mr-2'></i>Dokumen berhasil diperbarui!"
                        ]);
                    } catch (Exception $e) {
                        DB::rollback();
                        return response()->json([
                            'type' => 'warning',
                            'message' => $e->getMessage()
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'type' => 'danger',
                    'message' => "<i class='em em-email mr-2'></i>Dokumen tidak ditemukan!"
                ]);
            }
        }

        public function DestroyCrossan($id)
        {
            $sr = Crossan::find($id);
            if($sr->delete()) {
                return redirect()->back()->with([
                    'type'      => 'info',
                    'message'   => '<i class="em em-email em-svg mr-2"></i>Successfully deleted!'
               ]);
            } else {
                return redirect()->back()->with([
                    'type'      => 'warning',
                    'message'   => '<i class="em em-email em-svg mr-2"></i>Not destroy!'
               ]);
            }
        }
    
   
}
