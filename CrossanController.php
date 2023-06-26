<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\Crossan;
use Auth;

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
                $fileLink = ($data->file) ? "<a href='".asset('uploads').'/'.$data->file."' class='btn btn-sm btn-warning btn-square popup-image' title='download' download><i class='fa fa-download'></i></a>" : "";
                return $fileLink;
            })
             ->addColumn('action', function ($data) {
                 $val = array(
                     'id'            => $data->id,
                     'title'         => $data->title,
                     'description'   => $data->description,
                     'status'        => $data->status,
                     'file'          => $data->file,
                 );
                 return "<a href='javascript:void(0)' onclick='editModal(".json_encode($val).")' class='btn btn-sm btn-primary btn-square' title='Update'><i class='fa fa-edit'></i></a>
                 <button data-url='" . route('list.delete', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete' title='Delete'><i class='fa fa-trash'></i></button>";
                })
             ->rawColumns(['file_link','action'])
             ->make(true);
     }
        public function AddCrossan(Request $request)
        {
            $data = $request->all();
            $limit = [
                'title' => 'required|unique:todos|string',
                'file' => 'mimes:jpg,bmp,png,pdf,docx|max:2048'
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


        
    public function EditCrossan(Request $request, $id)
    {
        $dataEdit = Crossan::findOrFail($id);
        $data = $request->all();

        $limit = [
            'title' => 'string|required|unique:title,' . $dataEdit->id
        ];
        $validator = Validator::make($data, $limit);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $dataEdit->title = $request->input('title');
            $dataEdit->description = $request->input('description');
            $dataEdit->status = $request->input('status');

            // Jika ada perubahan pada file yang diunggah
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
                $dataEdit->file = $fileName;
            }

            $dataEdit->save();

            return redirect()->back()
                ->with([
                    'type' => 'info',
                    'message' => '<i class="em em-email mr-2"></i>Berhasil diubah'
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