<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\DeviceMaster;;
use App\OrderMaster;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use File;


class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getDevice()
     {
         $device = DeviceMaster::get();
         
         return DataTables::of($device)
         
             ->addColumn('DevicePrice', function ($data) {
                 return 'Rp ' . number_format((float)$data->device_price, 0, ',', '.');
             })
             ->addColumn('action', function ($data) {
                 $val = array(
                     'id'                  => $data->id,
                     'device_code'         => $data->device_code,
                     'device_name'         => $data->device_name,
                     'device_description'  => $data->device_description,
                 );
                 
                 return "<button data-url='" . route('Delete', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete-btn' title='Delete'><i class='fa fa-trash'></i></button>";
                 //<a href=".route('brandlaptop.invoice', $data->id)." class='btn btn-sm btn-outline-info btn-square' title='View invoice'><i class='fa fa-product-hunt'></i></a>
             }) 
             ->addColumn('operations', function ($data) {
                    $buttonLabel = $data->device_status == 'Active' ? 'Change to Inactive' : 'Change to Active';
                    $buttonClass = $data->device_status == 'Active' ? 'btn-success' : 'btn-danger';
                    $buttonStatus = $data->device_status == 'Active' ? 'Inactive' : 'Active';
                            
                    return "<button data-id=" . $data->id . " class='btn btn-sm btn-square js-swal-delete2 " . $buttonClass . "' data-status='" . $buttonStatus . "'><i class='si si-check mr-2'></i>" . $data->status . "</button>";
             })
             
             ->rawColumns(['action', 'DevicePrice','operations'])
             ->make(true);
     }

     public function getOrder()
     {
         $orde = OrderMaster::get();
         
         return DataTables::of($orde)
         
             ->addColumn('OrderTotalPrice', function ($data) {
                 return 'Rp ' . number_format((float)$data->total_price, 0, ',', '.');
             })
             ->addColumn('action', function ($data) {
                 $val = array(
                     'id'                  => $data->id,
                     'customer_name'       => $data->customer_name,
                     'customer_address'    => $data->customer_address,
                     'file_bukti_bayar'    => $data->file_bukti_bayar,
                 );
                 
                 return "<button data-url='" . route('Delete', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete-btn' title='Delete'><i class='fa fa-trash'></i></button>";
                 //<a href=".route('brandlaptop.invoice', $data->id)." class='btn btn-sm btn-outline-info btn-square' title='View invoice'><i class='fa fa-product-hunt'></i></a>
             })             
             ->rawColumns(['action', 'OrderTotalPrice',])
             ->make(true);
     }

                public function activeDevice($id)
                {
                    $device = DeviceMaster::findOrFail($id);
                
                    if ($device->device_status == 'Active') {
                        $device->device_status = 'Inactive';
                        $message = 'Successfully deactivated ' . $device->nama_brand;
                    } else {
                        $device->device_status = 'Active';
                        $message = 'Successfully activated ' . $device->nama_brand;
                    }
                
                    $device->save();
                
                    return response()->json([
                        'type' => 'success',
                        'message' => $message,
                    ]);
                }
                public function getDeviceDetails(Request $request)
                {
                    $deviceCode = $request->input('device_code');
                    
                    $device = DeviceMaster::where('device_code', $deviceCode)->first();
                    
                    if ($device) {
                        $response = [
                            'status' => 'success',
                            'deviceName' => $device->device_name,
                            'price' => $device->price,
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Device not found',
                        ];
                    }
                    
                    return response()->json($response);
                }
            public function veiwdevice($id)
                {
                    $deviceMasters = DeviceMaster::findOrFail($id);
                    return view('taskintern.order', compact('taskintern'));
                }
}
     
