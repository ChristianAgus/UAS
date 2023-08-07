<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\DataTables;
use App\LogBook;
use App\User;
use App\UserMap;
use App\MsDivisi;
use DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LBReportExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class LogBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function getlogbook ()
     {
        $vslog = LogBook::get();

        return DataTables::of($vslog)
        ->addColumn('name_visitee', function ($data) {
            return $data->visitdivisi->name;
        })
        ->addColumn('action', function ($data) {
            $val = array(
                'id'               => $data->id,
                'name'             => $data->name,
                'company'          => $data->company,
                'name_visitee'     => $data->visitdivisi->name,
                'division_visitee' => $data->division_visitee,
                'tujuan_kunjungan' => $data->tujuan_kunjungan,
                'relation_type'    => $data->relation_type,
                'no_telp'          => $data->no_telp,
                'email'            => $data->email,
                'jam'              => $data->jam,
            ); 

            return "
            <a href='javascript:void(0)' class='btn btn-sm btn-outline-info btn-square' onclick='openDetailModal(".json_encode($val).")' title='Detail'>Detail</a>
            <a href=".route('logbooks.edit', $data->id)." class='btn btn-sm btn-outline-info btn-square' title='Edit'>Edit</a>
            <button data-url=\"" . route('delete.logbook', $data->id) . "\" class=\"btn btn-sm btn-outline-danger btn-square delete-btn\" title=\"Delete\"><i class=\"fa fa-trash\"></i></button>
            ";
            })
            ->rawColumns(['action'])
            ->make(true);
     }

     public function getDivisi($id)
     {
         $userMap = UserMap::where('user_id', $id)->first();
         if ($userMap && $userMap->ms_divisi_id) {
             $divisi = MsDivisi::find($userMap->ms_divisi_id);
             if ($divisi) {
                 return response()->json(['divisi' => $divisi->name]);
             }
         }
         return response()->json([]);
     }

     public function addVisitor(Request $request)
     {
            $data = $request->all();
            $limit = [
                'pengunjung_name'   => 'required',
                'company'           => 'required',
                'pegawai'           => 'required',
                'divisi'            => 'required',
                'deskripsi'         => 'required',
                'status'            => 'required',
                'notelp'            => 'required',
                'email'             => 'required',
                'jam'               => 'required',
            ];
            $validator = Validator::make($data, $limit);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            } else {
                LogBook::create([
                    'name'             => $request->input('pengunjung_name'),
                    'company'          => $request->input('company'),
                    'name_visitee'     => $request->input('pegawai'),
                    'division_visitee' => $request->input('divisi'),
                    'tujuan_kunjungan' => $request->input('deskripsi'),
                    'relation_type'    => $request->input('status'),
                    'no_telp'          => $request->input('notelp'),
                    'email'            => $request->input('email'),
                    'jam'              => $request->input('jam'),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully added Visitor!'
                ], 200);
            }
     }
     
     public function showEditForm($id)
     {

        $order = LogBook::findOrFail($id);
        return view('logbooks.edit', compact('order'));

     }
     public function updateLogbook(Request $request, $id)
     {
            $dataEdit = LogBook::find($id);
            if (!$dataEdit) {
                return response()->json([
                    'type' => 'warning',
                    'message' => "<i class='em em-email mr-2'></i>Data not found!"
                ]);
            }
    
            $data = $request->all();
            $limit = [
                'pengunjung_name'   => 'required',
                'company'           => 'required',
                'pegawai'           => 'required',
                'divisi'            => 'required',
                'deskripsi'         => 'required',
                'status'            => 'required',
                'notelp'            => 'required',
                'email'             => 'required',
                'jam'               => 'required',
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
                    $dataEdit->name             = $request->input('pengunjung_name');
                    $dataEdit->company          = $request->input('company');
                    $dataEdit->name_visitee     = $request->input('pegawai');
                    $dataEdit->division_visitee = $request->input('divisi');
                    $dataEdit->tujuan_kunjungan = $request->input('deskripsi');
                    $dataEdit->relation_type    = $request->input('status');
                    $dataEdit->no_telp          = $request->input('notelp');
                    $dataEdit->email            = $request->input('email');
                    $dataEdit->jam              = $request->input('jam');
                    $dataEdit->save();
    
                    DB::commit();
    
                    return response()->json([
                        'type' => 'success',
                        'message' => "<i class='em em-email mr-2'></i>Successfully updated!"
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'type' => 'error',
                        'message' => "<i class='em em-email mr-2'></i>Error while updating data: " . $e->getMessage()
                    ]);
                }
            }
     }
     public function DestroyLogbook($id)
     {
         $sr = LogBook::find($id);
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

     public function LBReport(Request $request)
     {
            $dataLogBook = LogBook::query();

            if ($request->input('from') != null) {
                $dataLogBook->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
            }

            $data = array();
            foreach ($dataLogBook->get() as $log) {
                $data[] = array(
                    'name'              => $log->company . "<br><small>" . $log->name . "<br><i class='fa fa-envelope mr-1'></i>" . $log->email . "<br>" .
                                        "<i class='fa fa-phone mr-1'></i>" . $log->no_telp . "<br>" . $log->relation_type."</small>",
                    'relation'          => $log->tujuan_kunjungan . "<br><small>Meet at : " . $log->jam,
                    'employee'          => "<br><small><i class='fa fa-user mr-1'></i>".$log->visitdivisi->name."</br>".$log->division_visitee."</small>",
                    'date'              => $log->id."</small>"."<br><small><i class='fa fa-calendar mr-1'></i>".Carbon::parse($log->created_at)->format("Y-m-d"),
                ); 
            }

            return Datatables::of(collect($data))
                ->rawColumns(['name', 'relation', 'employee', 'date'])
                ->make(true);
     }

     public function LBReportExcel()
     {
            return Excel::download(new LBReportExport, "SR Report ".Auth::user()->name.".xlsx");
     }

     public function viewDetail($id)
     {
            $detail = LogBook::findOrFail($id);
                        return view('logbooks.detail', compact('detail'));
     }

     public function getVisitorData(Request $request)
     {
            $visitorId = $request->input('id');
            $visitor = LogBook::with('visitdivisi')->find($visitorId);
            return response()->json($visitor);
     }




     
}