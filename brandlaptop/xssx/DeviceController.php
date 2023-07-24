<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\DeviceMaster;
use App\OrderMaster;
use App\OrderList;
use DB;
use PDF;
use TCPDF;

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
                 
                 return "<button data-url='" . route('Delete', $data->id) . "' class='btn btn-sm btn-outline-danger btn-square delete-btn' title='Delete'><i class='fa fa-trash'></i></button>
                 <a href=".route('taskintern.invoice1', $data->id)." class='btn btn-sm btn-outline-info btn-square' title='View invoice'><i class='fa fa-product-hunt'></i></a>
                    ";
             })             
             ->rawColumns(['action', 'OrderTotalPrice',])
             ->make(true);
     }

     public function exportPDF($id)
     {
        $order = OrderMaster::findOrFail($id);

        // Create a new TCPDF object
        $pdf = new TCPDF();
    
        // Set the page header
        $pdf->SetHeaderData('Invoice', 'Your Name', 'Order #' . $order->id);
    
        // Add a page
        $pdf->AddPage();
    
        // Set font
        $pdf->SetFont('times', '', 12);
    
         $html = '
         <div class="invoice-title">
             <h2>Invoice</h2>
             <h3 class="pull-right">Order #' . $order->id . '</h3>
         </div>
         <hr>
         <div class="row">
             <div class="col-xs-6">
                 <address>
                     <strong>Billed To:</strong><br>
                     ' . $order->customer_name . ' <br>
                     ' . $order->customer_address . '<br>
                 </address>
             </div>
             <div class="col-xs-6 text-right">
                 <address>
                     <strong>Shipped To:</strong><br>
                     ' . $order->customer_name . '<br>
                     ' . $order->customer_address . '<br>
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
                     ' . $order->created_at . '<br><br>
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
                                 <tbody>';
         foreach ($order->orderlist as $list) {
             $html .= '
                 <tr>
                     <td>' . $list->device_code . '</td>
                     <td class="text-center">' . $list->device_name . '</td>
                     <td class="text-center">Rp ' . number_format($list->device_price, 0, ',', ',') . '</td>
                     <td class="text-center">' . $list->qty . '</td>
                     <td class="text-center">' . $list->discount . '%</td>
                     <td class="text-right">Rp ' . number_format($list->sub_total, 0, ',', ',') . '</td>
                 </tr>';
         }
     
         $html .= '
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
                             <span style="font-size: 25px;">Rp ' . number_format($order->total_price, 0, ',', ',') . '</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>';
     
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF as a download
    $pdf->Output('invoice_' . $id . '.pdf', 'D');
     }
     public function viewInvoice1($id)
     {
           $order = OrderMaster::findOrFail($id);
                    return view('taskintern.invoice1', compact('order'));
     }
     public function orderlist()
     {
         return $this->hasMany(OrderList::class, 'order_id')->withTrashed();
     }
    
     public function AddDevice(Request $request)
        {
            $data = $request->all();

            $rules = [
                'device_code.*' => 'required|unique:device_master,device_code|max:20',
                'device_name.*' => 'required',
                'device_price.*' => 'required',
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                DB::beginTransaction();

                if ($request->has('device_code')) {
                    $devices = [];
                    
                    foreach ($request->device_code as $index => $devicecode) {
                        if (!empty($devicecode)) {
                            $devicenama = $request->device_name[$index];
                            $price = $request->device_price[$index];
                            $description = $request->device_description[$index];
                            
                            $device = [
                                'device_name' => $devicenama,
                                'device_code' => $devicecode,
                                'device_price' => $price,
                                'device_description' => $description,
                            ];
                            
                            $devices[] = $device;
                        }
                    }

                    DeviceMaster::insert($devices);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully added Order and Device!'
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

     public function getDeviceDetails(Request $request)
        {
            $deviceName = $request->input('device_name');
    
            $device = DeviceMaster::where('device_name', $deviceName)->first();
            
            if ($device) {
                $response = [
                    'status' => 'success',
                    'deviceCode' => $device->device_code,
                    'devicePrice' => $device->device_price,
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Device not found',
                ];
            }
            
            return response()->json($response);
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

                public function AddOrder(Request $request)
                {
                    $data = $request->all();

                    $limit = [
                        'customer_name' => 'required|max:20'
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

                        $order = OrderMaster::create([
                            'customer_name' => $request->customer_name,
                            'customer_address' => $request->customer_address
                        ]);

                        if ($request->has('device_name')) {
                            foreach ($request->device_name as $index => $namadevice) {
                                if (!empty($namadevice)) {
                                    $devicecode = $request->device_code[$index];
                                    $price = $request->device_price[$index];
                                    $discount = $request->discount[$index];
                                    $quantity = $request->quantity[$index];
                                    if (!empty($discount)) {
                                        $total = $price * $quantity * (1 - $discount / 100);
                                    } else {
                                        $total = $price * $quantity;
                                    }   
                                    $orderlist = [
                                        'order_id' => $order->id,
                                        'device_name'     => $namadevice,
                                        'device_code'     => $devicecode,
                                        'device_price'    => $price,
                                        'discount'        => $discount,
                                        'qty'             => $quantity,
                                        'sub_total'       => $total
                                    ];

                                    DB::table('order_list')->insert($orderlist);
                                }
                            }

                            $totalAsset = DB::table('order_list')
                                ->where('order_id', $order->id)
                                ->sum('sub_total'); 

                            // Update total asset brand
                            OrderMaster::where('id', $order->id)
                                ->update(['total_price' => $totalAsset]);

                            DB::commit();

                            return response()->json([
                                'success' => true,
                                'message' => 'Successfully added Order and Device!'
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
            public function veiwdevice($id)
                {
                    $deviceMasters = DeviceMaster::findOrFail($id);
                    return view('taskintern.order', compact('taskintern'));
                }
}
     
