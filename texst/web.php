<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('log');
Route::post('/login-post', 'Auth\LoginController@login')->name('login-post');



Auth::routes();



Route::get('/dashboard', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/data', 'HomeController@filterRR')->name('filterRR')->middleware('auth');
Route::get('/RRToday', 'HomeController@RRToday')->name('RRToday')->middleware('auth');
Route::post('/change-avatar', 'HomeController@changeAvatar')->name('changeAvatar')->middleware('auth');

Route::get('/notification', 'HomeController@notification')->name('notification')->middleware('auth');
Route::get('/readAll', 'HomeController@readAll')->name('readAll')->middleware('auth');

Route::post('/upload-biling-num', 'HomeController@uploadBillingNum')->name('uploadBillingNum')->middleware('auth');
Route::post('/upload-vendor-sap', 'FadCaController@uploadMsVendorSap')->name('uploadMsVendorSap')->middleware('auth');
Route::get('/vendorAccExist', 'FadCaController@vendorAccExist')->name('vendorAccExist')->middleware('auth');


Route::post('/getBilNumSAP', 'HomeController@getBilNumSAP')->name('getBilNumSAP')->middleware('auth');
Route::post('/editTheme', 'HomeController@editTheme')->name('editTheme')->middleware('auth');

Route::group(['prefix' => 'profile'], function () {
    Route::get('/', 'HomeController@viewProfile')->name('viewProfile')->middleware('auth');
    Route::post('/editProfile', 'HomeController@editProfile')->name('editProfile')->middleware('auth');
    
});

Route::get('/dubaiexpo', 'HomeController@dubaiExpos')->name('dubaiExpo')->middleware('auth');
Route::get('/dataDubaiExpo', 'HomeController@dataDubaiExpo')->name('dataDubaiExpo')->middleware('auth');

Route::group(['prefix' => 'management'], function () {
    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', 'ManagementController@dataMenu')->name('management.menu')->middleware('auth');
        Route::post('/post', 'ManagementController@postMenu')->name('management.postMenu')->middleware('auth');
    });
    Route::group(['prefix' => 'group'], function () {
        Route::get('/', function () {
            return view('management.group');
        })->name('management.group')->middleware('auth');
        Route::get('/data', 'ManagementController@DataManagementGroup')->name('DataManagementGroup')->middleware('auth');
        Route::post('/post', 'ManagementController@TambahManagementGroup')->name('TambahManagementGroup')->middleware('auth');
        Route::put('/edit/{id}', 'ManagementController@EditManagementGroup')->name('EditManagementGroup')->middleware('auth');
        Route::get('/delete/{id}', 'ManagementController@HapusManagementGroup')->name('HapusManagementGroup')->middleware('auth');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', function () {
            return view('management.user');
        })->name('management.user')->middleware('auth');
        Route::get('/data', 'ManagementController@DataManagementUser')->name('DataManagementUser')->middleware('auth');
        Route::get('/active/{id}', 'ManagementController@activeDataManagementUser')->name('activeDataManagementUser')->middleware('auth');
        Route::get('/add', function () {
            return view('management.userCreate');
        })->name('management.userCreate')->middleware('auth');
        Route::post('/post', 'ManagementController@TambahManagementUser')->name('TambahManagementUser')->middleware('auth');
        Route::post('/import', 'ManagementController@uploadExcelUser')->name('uploadExcelUser')->middleware('auth');
        Route::get('/edit/{id}', 'ManagementController@viewEditUser')->name('viewEditUser')->middleware('auth');
        Route::post('/update-user', 'ManagementController@editUser')->name('editUser')->middleware('auth');
    
        Route::get('/divisi_by_company', 'ManagementController@divisi_by_company')->name('divisi_by_company')->middleware('auth');
        Route::get('/plant_by_company', 'ManagementController@plant_by_company')->name('plant_by_company')->middleware('auth');
        
        Route::get('/getSection', 'ManagementController@getSection')->name('getSection')->middleware('auth');
        Route::get('/getMappingDepart', 'ManagementController@getMappingDepart')->name('getMappingDepart')->middleware('auth');
        Route::get('/getMappingSec1', 'ManagementController@getMappingSec1')->name('getMappingSec1')->middleware('auth');
        Route::get('/getMappingSec2', 'ManagementController@getMappingSec2')->name('getMappingSec2')->middleware('auth');
        Route::get('/secCode', 'ManagementController@secCode')->name('secCode')->middleware('auth');
        Route::get('/planCode', 'ManagementController@planCode')->name('planCode')->middleware('auth');
    });
});


Route::get('datait-itasset', 'itassetController@DataITAsset')->name('DataITAsset.index');


Route::group(['prefix' => 'qa'], function () {
    Route::group(['prefix' => 'dokumen'], function () {
        Route::get('/divisi', function () {
            return view('qa.dokumen.divisi');
        })->name('qa.dokumen.divisi')->middleware('auth');
        Route::get('/divisi={id}', 'DocumentController@depart')->name('depart')->middleware('auth');
        Route::get('/divisi={divisi}/depart={depart}', 'DocumentController@section1')->name('section1')->middleware('auth');
        Route::get('/divisi={divisi}/depart={depart}/section1={section1}', 'DocumentController@section2')->name('section2')->middleware('auth');
        Route::get('/divisi={divisi}/depart={depart}/section1={section1}/section2={section2}', 'DocumentController@jenis')->name('jenis')->middleware('auth');

        Route::get('/file-divisi={divisi}/{jenis}/{depart?}/{section1?}/{section2?}', 'DocumentController@getFile')->name('getFile')->middleware('auth');
        Route::get('/dataFile-divisi={divisi}/{jenis}/{depart?}/{section1?}/{section2?}', 'DocumentController@dataFile')->name('dataFile')->middleware('auth');
        Route::get('/file/{id}', 'DocumentController@getFileFrame')->name('getFileFrame')->middleware('auth');
    
        Route::post('/setting', 'DocumentController@settingView')->name('settingView')->middleware('auth');
        Route::get('/showDistribution/{id}', 'DocumentController@showDistribution')->name('showDistribution')->middleware('auth');
        
        Route::post('/question', 'DocumentController@question')->name('question')->middleware('auth');
    
    });
    Route::group(['prefix' => 'procedure-old'], function () {
        Route::post('/import', 'DocumentController@uploadDocExcel')->name('uploadDocExcel')->middleware('auth');
    });
    
    Route::group(['prefix' => 'procedure'], function () {
        Route::post('rejectDok', 'DocumentController@rejectDok')->name('rejectDok')->middleware('auth');
        Route::post('editDocument', 'DocumentController@editDocument')->name('editDocument')->middleware('auth');

        Route::post('uploadFileFinal', 'DocumentController@uploadFileFinal')->name('uploadFileFinal')->middleware('auth');
        Route::get('/waiting_approve', function () {
            return view('qa.prosedur.index');
        })->name('prosedur.index')->middleware('auth');

        Route::get('/index-{status}', 'DocumentController@viewUserDoc')->name('viewUserDoc')->middleware('auth');
        Route::get('/data-index-{status}', 'DocumentController@dataUserDoc')->name('dataUserDoc')->middleware('auth');

        Route::get('/inbox-{status}', 'DocumentController@viewAppDoc')->name('prosedur.inbox')->middleware('auth');
        Route::get('/data-inbox-{status}', 'DocumentController@dataApprovalDoc')->name('dataApprovalDoc')->middleware('auth');


        Route::get('/revisi', function () {
            return view('qa.prosedur.revisi');
        })->name('prosedur.revisi')->middleware('auth');
        Route::get('/approve', function () {
            return view('qa.prosedur.approve');
        })->name('prosedur.approve')->middleware('auth');
        Route::get('/add', function () {
            return view('qa.prosedur.add');
        })->name('prosedur.add')->middleware('auth');

        Route::get('/revisiDocNew', function () {
            return view('qa.prosedur.addRevNew');
        })->name('prosedur.addRevNew')->middleware('auth');
        Route::get('/revisiDocExist', function () {
            return view('qa.prosedur.addRevExist');
        })->name('prosedur.addRevExist')->middleware('auth');


        Route::post('/post-prosedur', 'DocumentController@tambahPengajuanDokumen')->name('tambahPengajuanDokumen')->middleware('auth');
        Route::post('/revisi-qa/{id}', 'DocumentController@revisiDoc')->name('revisiDoc')->middleware('auth');
        Route::get('/detailPD/{id}', 'DocumentController@detailPD')->name('detailPD')->middleware('auth');
        Route::get('/RevisiViewPD/{id}', 'DocumentController@RevisiViewPD')->name('RevisiViewPD')->middleware('auth');
        Route::get('/histori-revisi/{id}', 'DocumentController@historiRevisi')->name('historiRevisi')->middleware('auth');


        Route::get('/delete/file/{id}', 'DocumentController@HapusFile')->name('HapusFile')->middleware('auth');
        Route::post('/approveORReject', 'DocumentController@approveORReject')->name('approveORReject')->middleware('auth');
    });

    Route::group(['prefix' => 'master_list_doc'], function () {
        Route::get('/', function () {
            return view('qa.list.index');
        })->name('qa.list.index')->middleware('auth');
        Route::get('/add', function () {
            return view('qa.list.add');
        })->name('qa.list.add')->middleware('auth');
        Route::post('/getData', 'DocumentController@getDokMasterList')->name('getDokMasterList')->middleware('auth');
        Route::post('/rilis-doc', 'DocumentController@rilisDok')->name('rilisDok')->middleware('auth');
        Route::post('/uploadDocReleased', 'DocumentController@uploadDocReleased')->name('uploadDocReleased')->middleware('auth');

        
        Route::post('/fileAksi', 'DocumentController@fileAksi')->name('fileAksi')->middleware('auth');
    
    });
});

Route::group(['prefix' => 'assets_request'], function () {
    Route::get('/', function () {
        return view('room.index');
    })->name('room.index')->middleware('auth');
    Route::get('/data', 'AssetRequestController@DataAssetRequest')->name('DataAssetRequest')->middleware('auth');
    Route::get('/add', function () {
        return view('room.add');
    })->name('room.add')->middleware('auth');
    Route::get('/detail/{id}', 'AssetRequestController@detailRequest')->name('room.detailRequest');
    Route::get('/edit/{id}', 'AssetRequestController@editView')->name('room.edit')->middleware('auth');
    Route::post('/post-request-room', 'AssetRequestController@TambahRequestRoom')->name('TambahRequestRoom')->middleware('auth');
    Route::post('/update-request-room/{id}', 'AssetRequestController@editRequestRoom')->name('editRequestRoom')->middleware('auth');
    Route::get('/delete/{id}', 'AssetRequestController@HapusRequestRoom')->name('HapusRequestRoom')->middleware('auth');
});


Route::group(['prefix' => 'list'], function () {
    Route::get('/', function () {
    return view('todo.list');
    })->name('todo.list')->middleware('auth');
    Route::get('/data', 'TodoController@getData1')->name('getData1')->middleware('auth');
    Route::post('/post', 'TodoController@TambahTodo')->name('TambahTodo')->middleware('auth');
    Route::put('/edit/{id}', 'TodoController@EditTodo')->name('EditTodo')->middleware('auth');
    Route::get('/delete/{id}', 'TodoController@HapusTodo')->name('list.delete')->middleware('auth');


});

Route::group(['prefix' => 'crossonto'], function () {
    Route::get('/', function () {
    return view('cross.crossonto');
    })->name('cross.crossonto')->middleware('auth');
    Route::get('/data', 'CrossanController@getData')->name('getData')->middleware('auth');
    Route::post('/post', 'CrossanController@AddCrossan')->name('AddCrossan')->middleware('auth');
    Route::put('/EditCrossan', 'CrossanController@EditCrossan')->name('EditCrossan')->middleware('auth');
    Route::get('/delete/{id}', 'CrossanController@DestroyCrossan')->name('Delete.Crossan')->middleware('auth');
});

Route::group(['prefix' => 'Brand'], function () {
    Route::get('/', function () {
        return view('brandlaptop.index');
    })->name('brandlaptop.index')->middleware('auth');
    Route::get('/invoice/{id}', 'LaptopController@viewInvoice')->name('brandlaptop.invoice')->middleware('auth');
    Route::get('/data', 'LaptopController@getBrand')->name('getBrand')->middleware('auth');
    Route::post('/post', 'LaptopController@AddBrandLaptop')->name('AddBrandLaptop')->middleware('auth');
    Route::get('/delete/{id}', 'LaptopController@destroy')->name('Delete')->middleware('auth');
    Route::put('/active-laptop/{id}', 'LaptopController@activeLaptop')->name('activeLaptop')->middleware('auth');
});

Route::group(['prefix' => 'Device'], function () {
    Route::get('/', function () {
        return view('device.index');
    })->name('device.index')->middleware('auth');
   // Route::get('/invoice/{id}', 'LaptopController@viewInvoice')->name('brandlaptop.invoice')->middleware('auth');
    Route::get('/data', 'DeviceController@getDevice')->name('getDevice')->middleware('auth');
   // Route::post('/post', 'LaptopController@AddBrandLaptop')->name('AddBrandLaptop')->middleware('auth');
   // Route::get('/delete/{id}', 'LaptopController@destroy')->name('Delete')->middleware('auth');
});

Route::group(['prefix' => 'xere'], function () {
    Route::get('/', function () {
        return view('ajax.xere');
    })->name('ajax.xere')->middleware('auth');

    Route::get('/data', 'AjaxdatatablesController@index')->name('xere.index')->middleware('auth');
    Route::post('/xere/store', 'AjaxdatatablesController@store')->name('xere.store')->middleware('auth');
    Route::post('/xere/update', 'AjaxdatatablesController@update')->name('xere.update')->middleware('auth');

    Route::get('/xere/destroy/{id}', 'AjaxdatatablesController@destroy')->name('xere.destroy')->middleware('auth');
});



Route::group(['prefix' => 'productAjax'], function () {
    Route::get('/', function () {
        return view('meyong.productAjax');
    })->name('meyong.productAjax')->middleware('auth');

    Route::get('/ajaxproducts', 'ProductController@index')->name('ajaxproducts.index');
    Route::post('/ajaxstore', 'ProductController@store')->name('ajaxproducts.store');
    Route::post('/ajaxedit', 'ProductController@edit')->name('ajaxproducts.edit');
    Route::get('/ajaxdelete', 'ProductController@destroy')->name('ajaxproducts.destroy');
});


//Route::group(['prefix' => 'sample-non-produksi'], function () {
//    Route::get('/overview', function () {
//        return view('sampleNonProduksi.overview');
//    })->name('overview')->middleware('auth');
//    Route::get('/overviewGrap', 'SampleNonProduksiController@overview')->name('overviewGrap')->middleware('auth');
//    Route::get('/counReeq', 'SampleNonProduksiController@counReeq')->name('counReeq')->middleware('auth');
//    Route::get('/requester', 'SampleNonProduksiController@dataRequestSample')->name('dataRequestSample')->middleware('auth');
//    Route::get('/approval', 'SampleNonProduksiController@dataApprovalSample')->name('dataApprovalSample')->middleware('auth');
//    Route::post('/buatSampleNon', 'SampleNonProduksiController@buatSampleNon')->name('buatSampleNon')->middleware('auth');
//    Route::post('/approvalSampleNon', 'SampleNonProduksiController@approvalSampleNon')->name('approvalSampleNon')->middleware('auth');
//    Route::get('/exportRevervasi/data', 'SampleNonProduksiController@exportRevervasi')->name('exportRevervasi')->middleware('auth');
//});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/joy', 'JoyController');
    Route::get('/joy-index', 'JoyController@index')->name('Joy.index');
    Route::get('/joy-create', 'JoyController@index')->name('Joy.create');
    Route::get('/joy-search', 'JoyController@search')->name('joy.search');
});

Route::group(['prefix' => 'project'], function () {
    Route::get('/', function () {
        return view('project.index');
    })->name('project.index')->middleware('auth');
    Route::get('/data', 'ProjectController@GetData')->name('GetData')->middleware('auth');
    Route::delete('/project/{id}', [ProjectController::class, 'delete'])->name('project.delete');

    ///Route::post('/post', 'ManagementController@TambahManagementGroup')->name('TambahManagementGroup')->middleware('auth');
    //Route::put('/edit/{id}', 'ManagementController@EditManagementGroup')->name('EditManagementGroup')->middleware('auth');
    //Route::get('/delete/{id}', 'ManagementController@HapusManagementGroup')->name('HapusManagementGroup')->middleware('auth');
});

Route::group(['prefix' => 'myInventory'], function () {

    Route::group(['prefix' => 'apd-atk'], function () {
     


        Route::group(['prefix' => 'data-pengajuan'], function () {
            Route::get('/approval/{tipe}', 'GaInventoriController@dataRequest')->name('dataRequest')->middleware('auth');
            Route::get('/apdatkExport', 'GaInventoriController@apdatkExport')->name('apdatkExport')->middleware('auth');

            Route::post('/approv/stokReturn', 'GaInventoriController@stokReturn')->name('stokReturn')->middleware('auth');
            Route::get('/approv/report', 'GaInventoriController@viewReport')->name('viewReport')->middleware('auth');
            Route::get('/approv/dataStatus', 'GaInventoriController@dataStatus')->name('dataStatus')->middleware('auth');
            Route::post('/approv/report/post', 'GaInventoriController@reportHistori')->name('reportHistori')->middleware('auth');
            Route::post('/post-approval/{tipe}', 'GaInventoriController@approvalPengajuan')->name('approvalPengajuan')->middleware('auth');
            Route::get('/index', 'GaInventoriController@dataPengajuan')->name('dataPengajuan')->middleware('auth');
            Route::get('/add', function () {
                return view('inventori.apd_atk.pengajuan.tambah');
            })->name('apd_atk.pengajuan.add')->middleware('auth');
            Route::get('/getProdukCat/{param}', 'GaInventoriController@getProdukCat')->name('getProdukCat')->middleware('auth');
            Route::post('/buatPengajuan', 'GaInventoriController@buatPengajuan')->name('buatPengajuan')->middleware('auth');


            Route::get('/report', function () {
                return view('inventori.apd_atk.pengajuan.report');
            })->name('apd_atk.pengajuan.report')->middleware('auth');
            Route::post('/report_apd_excel', 'GaInventoriController@download_report_apd')->name('download_report_apd')->middleware('auth');

            
        });
        Route::group(['prefix' => 'produk'], function () {
            Route::get('/keranjang', 'GaInventoriController@getKerajang')->name('getKerajang')->middleware('auth');
            Route::get('/deleteCart/{id}', 'GaInventoriController@deleteCart')->name('deleteCart')->middleware('auth');
            
            Route::get('/form-apd', function(){
	    		return response()->download(public_path('assets\Form APD.xlsx'));
	    	})->name('form-apd.download-template')->middleware('auth');

            Route::get('/{tipe}', 'GaInventoriController@apdATk')->name('apdATk')->middleware('auth');
            Route::get('/data/{tipe}', 'GaInventoriController@dataAPDGA')->name('dataAPDGA')->middleware('auth');
            Route::get('/detail/{id}', 'GaInventoriController@detailAPD')->name('detailAPD')->middleware('auth');
            Route::post('/upload-apd', 'GaInventoriController@uploadAPDExcel')->name('uploadAPDExcel')->middleware('auth');
            Route::post('/post-produk', 'GaInventoriController@tambahProduk')->name('tambahProduk')->middleware('auth');
            Route::get('/delete/{id}', 'GaInventoriController@deleteAPD')->name('deleteAPD')->middleware('auth');

            Route::get('/download_stok/{cat}', 'GaInventoriController@download_stok')->name('download_stok')->middleware('auth');

            

            Route::group(['prefix' => 'stok'], function () {
                Route::get('/-{id}', 'GaInventoriController@viewAPDStok')->name('viewAPDStok')->middleware('auth');
                Route::get('/getNamePenerima', 'GaInventoriController@getNamePenerima')->name('getNamePenerima')->middleware('auth');
                Route::get('/data/{id}/{plant}', 'GaInventoriController@dataStok')->name('dataStok')->middleware('auth');
                Route::post('/update-stok', 'GaInventoriController@updateStok')->name('updateStok')->middleware('auth');
                Route::get('/tanda-terima/{id}', 'GaInventoriController@tandaTerima')->name('tandaTerima')->middleware('auth');
                Route::post('/filter/{id}', 'GaInventoriController@filterStok')->name('filterStok')->middleware('auth');
            });
        
        });
    });
    Route::group(['prefix' => 'IT'], function () {
        Route::group(['prefix' => 'produk'], function () {
            Route::get('/', function () {
                return view('inventori.IT.produk');
            })->name('inventori.IT.produk')->middleware('auth');
            Route::post('/create', 'ItInventoriController@createProduk')->name('createProduk')->middleware('auth');
            Route::get('/data', 'ItInventoriController@dataProdukIT')->name('dataProdukIT')->middleware('auth');
            Route::post('/createTerima', 'ItInventoriController@createTerima')->name('createTerima')->middleware('auth');
            Route::get('/histori/{id}', 'ItInventoriController@viewHistori')->name('viewHistori')->middleware('auth');
            Route::get('/histori/data/{id}', 'ItInventoriController@dataInvHistori')->name('dataInvHistori')->middleware('auth');
            Route::post('/updateReturn', 'ItInventoriController@updateReturn')->name('updateReturn')->middleware('auth');
            Route::post('/changeStatus', 'ItInventoriController@changeStatus')->name('changeStatus')->middleware('auth');
            Route::get('/export/data', 'ItInventoriController@exportData')->name('exportData')->middleware('auth');
        });
    });

});

Route::group(['prefix' => 'tiketing-rnd'], function () {
    Route::get('/admin/{status}', 'TiketingController@viewTiketRND')->name('tiket.index')->middleware('auth');
    Route::delete('/delete', 'TiketController@deleteTicket')->name('deleteTicket');

    Route::get('/sender', function () {
        return view('tiket.indexSender');
    })->name('tiket.indexSender')->middleware('auth');
    Route::get('/sender/add', function () {
        return view('tiket.add');
    })->name('tiket.add')->middleware('auth');
    Route::post('/post-tiket', 'TiketingController@buatTiket')->name('buatTiket')->middleware('auth');
    Route::get('/dataAdmin/{status}', 'TiketingController@dataTiketAdminRD')->name('dataTiketAdminRD'); //Data Tiket RND Admin
    Route::get('/dataSender', 'TiketingController@dataTiketSender')->name('dataTiketSender'); //Data Tiket RND Sender
    Route::post('/delete1', 'TiketingController@hapusTiket')->name('hapusTiket')->middleware('auth');
    Route::post('/change-status', 'TiketingController@changeStatusAdmin')->name('changeStatusAdmin')->middleware('auth');
    Route::post('/buatFeedback', 'TiketingController@buatFeedback')->name('buatFeedback')->middleware('auth');
    Route::get('/getUserBYSection1', 'TiketingController@getUserBYSection1')->name('getUserBYSection1')->middleware('auth');
    Route::get('/exportDone', 'TiketingController@exportDone')->name('exportDone')->middleware('auth');
    Route::get('/delete/{id}', 'TiketingController@hapusDataTicketing')->name('hapusDataTicketing')->middleware('auth');
});

Route::group(['prefix' => 'wig'], function () {
    Route::get('/coreHead', 'WigController@indexCore')->name('wig.indexCore')->middleware('auth');
    Route::get('/coreHead/data/{id}', 'WigController@dataWigAccCore')->name('wig.dataWigAccCore')->middleware('auth');
    Route::get('/dataWigCompany/{company}', 'WigController@dataWigCompany')->name('dataWigCompany')->middleware('auth');

    Route::group(['prefix' => 'hr'], function () {
        Route::get('/exportHR', 'WigController@exportHR')->name('exportHR')->middleware('auth');
        Route::get('/dashboard', function () {
            return view('wig.hr.dashboard');
        })->name('wig.hr.dashboard')->middleware('auth');
        Route::post('/dashboard-post', 'WigController@grapWIG')->name('grapWIG')->middleware('auth');
        Route::get('/ind{tipe}', 'WigController@indexDataHR')->name('wig.hr.individual')->middleware('auth');
        Route::get('/dataHR{tipe}', 'WigController@dataHR')->name('wig.dataHR')->middleware('auth');
        Route::get('/dataHR/company/{tipe}/{company}', 'WigController@dataHRCompany')->name('dataHRCompany')->middleware('auth');

    });



    Route::get('/access/{user}/{type}/{year}', 'WigController@index')->name('wig.index')->middleware('auth');

    Route::post('/create', 'WigController@buatWIG')->name('buatWIG')->middleware('auth');
    Route::post('/ediWIG', 'WigController@editWIG')->name('editWIG')->middleware('auth');

    Route::post('/approvalAction', 'WigController@approvalAction')->name('approvalAction')->middleware('auth');

    Route::post('/achProgress', 'WigController@achProgress')->name('achProgress')->middleware('auth');
    Route::get('/deleteWIG/{id}', 'WigController@deleteWIG')->name('deleteWIG')->middleware('auth');
    Route::get('/deleteAll/{id}', 'WigController@deleteAll')->name('deleteAll')->middleware('auth');

    Route::get('/report', function () {
        return view('wig.report');
    })->name('wig.report')->middleware('auth');
    Route::post('/report/data', 'WigController@reportWIG')->name('reportWIG')->middleware('auth');
    Route::post('/report/export', 'WigController@exportWIG')->name('exportWIG')->middleware('auth');


    Route::get('/projectImprove/{year}/{user}', 'WigController@improvPlan')->name('projectImprove')->middleware('auth');

});

Route::group(['prefix' => 'packing-list'], function () {
    Route::get('/create', function () {
        return view('packing.new');
    })->name('packing.new')->middleware('auth');
    Route::post('/post', 'PackingListController@tambahPackList')->name('tambahPackList')->middleware('auth');
    Route::get('/detail/{id}', 'PackingListController@detailPackList')->name('detailPackList')->middleware('auth');

    Route::get('/data', function () {
        return view('packing.report');
    })->name('packing.report')->middleware('auth');
    Route::get('/allDataPack', 'PackingListController@allDataPack')->name('allDataPack')->middleware('auth');
    Route::post('/filterPack', 'PackingListController@filterPack')->name('filterPack')->middleware('auth');

    Route::get('/getByShipName', 'PackingListController@getByShipName')->name('getByShipName')->middleware('auth');
    Route::get('/getMsProduct', 'PackingListController@getMsProduct')->name('getMsProduct')->middleware('auth');
    Route::post('/getMasterByJa', 'PackingListController@getMasterByJa')->name('getMasterByJa')->middleware('auth');
});
Route::get('/product-master/{param}', 'PackingListController@getMasterByJa')->name('product-byCategory-select2');
Route::get('/productMSBYName/{param}', 'PackingListController@productMSBYName')->name('productMSBYName');

Route::group(['prefix' => 'sample-non-produksi'], function () {
    Route::get('/overview', function () {
        return view('sampleNonProduksi.overview');
    })->name('overview')->middleware('auth');
    Route::get('/overviewGrap', 'SampleNonProduksiController@overview')->name('overviewGrap')->middleware('auth');
    Route::get('/counReeq', 'SampleNonProduksiController@counReeq')->name('counReeq')->middleware('auth');
    Route::get('/requester', 'SampleNonProduksiController@dataRequestSample')->name('dataRequestSample')->middleware('auth');
    Route::get('/approval', 'SampleNonProduksiController@dataApprovalSample')->name('dataApprovalSample')->middleware('auth');
    Route::post('/buatSampleNon', 'SampleNonProduksiController@buatSampleNon')->name('buatSampleNon')->middleware('auth');
    Route::post('/approvalSampleNon', 'SampleNonProduksiController@approvalSampleNon')->name('approvalSampleNon')->middleware('auth');
    Route::get('/exportRevervasi/data', 'SampleNonProduksiController@exportRevervasi')->name('exportRevervasi')->middleware('auth');
});


Route::group(['prefix' => 'my-sales'], function () {
    Route::group(['prefix' => 'customer-master'], function () {
        Route::post('/buatCustomer', 'SampleServiceController@buatCustomer')->name('buatCustomer')->middleware('auth');
        Route::get('/detailCus/{id}/deals', 'SampleServiceController@detailCus')->name('detailCus')->middleware('auth');
        Route::get('/detailCus/{id}/deals/data', 'SampleServiceController@dataDeals')->name('dataDeals')->middleware('auth');
        Route::post('/detailCus/{id}/deals/post', 'SampleServiceController@buatDeal')->name('buatDeal')->middleware('auth');
        Route::get('/data/{status}', 'SampleServiceController@dataCus')->name('dataCus')->middleware('auth');
        Route::get('/mapCus', function () {
            return view('commercial.customer.map');
        })->name('mapCus')->middleware('auth');
        Route::get('/cusMasterALL', 'SampleServiceController@cusMasterALL')->name('cusMasterALL')->middleware('auth');
        Route::get('/getCustomer', 'SampleServiceController@getCustomer')->name('getCustomer')->middleware('auth');
    });
    Route::group(['prefix' => 'sample-service'], function () {
        Route::get('/dataOnvoice/{id}', 'SampleServiceController@dataOnvoice')->name('dataOnvoice')->middleware('auth');
        Route::get('/dataPacking/{id}', 'SampleServiceController@dataPacking')->name('dataPacking')->middleware('auth');
        Route::get('/editSample_Request/{SR}', 'SampleServiceController@editSample_Request')->name('editSample_Request')->middleware('auth');

        Route::get('/data/{status}', 'SampleServiceController@dataSample')->name('dataSample')->middleware('auth');
        Route::get('/dataSampleWeb/{status}', 'SampleServiceController@dataSampleWeb')->name('dataSampleWeb')->middleware('auth');

        Route::post('/buatSample', 'SampleServiceController@buatSample')->name('buatSample')->middleware('auth');
        Route::post('/editSample', 'SampleServiceController@editSample')->name('editSample')->middleware('auth');
        Route::post('/editInvoice', 'SampleServiceController@editInvoice')->name('editInvoice')->middleware('auth');
        Route::get('/SR-Report', function () {
            return view('commercial.sampleService.report');
        })->name('SRReport')->middleware('auth');
        Route::post('/SR-Report-Post', 'SampleServiceController@SRReport')->name('SRReportPOST')->middleware('auth');
        Route::post('/SRReportExcel', 'SampleServiceController@SRReportExcel')->name('SRReportExcel')->middleware('auth');


        Route::post('/changetoDeliv', 'SampleServiceController@changetoDeliv')->name('changetoDeliv')->middleware('auth');
        Route::post('/findWhenSR', 'SampleServiceController@findWhenSR')->name('findWhenSR')->middleware('auth');
        Route::get('/hapusSR/{id}', 'SampleServiceController@hapusSR')->name('hapusSR')->middleware('auth');
        Route::get('/exportSRCus', 'SampleServiceController@exportSRCus')->name('exportSRCus')->middleware('auth');
        Route::get('/backSR/{id}', 'SampleServiceController@backSR')->name('backSR')->middleware('auth');
        
    });

    Route::group(['prefix' => 'sample-rnd'], function () {
        Route::get('/data_sr_rnd/{status}', 'SampleServiceController@data_sr_rnd')->name('data_sr_rnd')->middleware('auth');
        Route::post('/create_sr_rnd', 'SampleServiceController@create_sr_rnd')->name('create_sr_rnd')->middleware('auth');
        Route::get('/delete_sr_rnd/{id}', 'SampleServiceController@delete_sr_rnd')->name('delete_sr_rnd')->middleware('auth');
        Route::get('/edit_view_sr_rnd/{id}', 'SampleServiceController@edit_view_sr_rnd')->name('edit_view_sr_rnd')->middleware('auth');
        Route::post('/edit_action_sr_rnd', 'SampleServiceController@edit_action_sr_rnd')->name('edit_action_sr_rnd')->middleware('auth');
        Route::post('/closed_sr_rnd', 'SampleServiceController@closed_sr_rnd')->name('closed_sr_rnd')->middleware('auth');
        Route::get('/report', function () {
            return view('commercial.sampleService.sr_rnd.report');
        })->name('sr_report_rnd')->middleware('auth');
        Route::post('/report-sr-rnd', 'SampleServiceController@report_sr_rnd')->name('report_sr_rnd')->middleware('auth');
        Route::post('/excel-sr-rnd', 'SampleServiceController@excel_sr_rnd')->name('excel_sr_rnd')->middleware('auth');

    });


    Route::group(['prefix' => 'customer_complaint'], function () {
        Route::get('/', 'CustomerComplaintController@customerComp')->name('customerComp')->middleware('auth');
        Route::post('/customerComp_create', 'CustomerComplaintController@customerComp_create')->name('customerComp_create')->middleware('auth');
        Route::get('/customerComp_hapus/{id}', 'CustomerComplaintController@customerComp_hapus')->name('customerComp_hapus')->middleware('auth');

    });

    Route::group(['prefix' => 'product_information'], function () {
        Route::get('/', 'ProductInformationController@pi_sales')->name('pi_sales')->middleware('auth');
        Route::post('/pi_create', 'ProductInformationController@pi_create')->name('pi_create')->middleware('auth');
        Route::get('/pi_delete/{id}', 'ProductInformationController@pi_delete')->name('pi_delete')->middleware('auth');
    });

    Route::group(['prefix' => 'qa_database'], function () {
        Route::group(['prefix' => 'compliance_docs'], function () {
            Route::get('/', 'DocumentCustomerController@compliance_docs')->name('cd_sales')->middleware('auth');
        });

        Route::group(['prefix' => 'product_certificate'], function () {
            Route::get('/', 'DocumentCustomerController@product_certificate')->name('pc_sales')->middleware('auth');
        });
    });

});

Route::group(['prefix' => 'bm'], function () {
    Route::group(['prefix' => 'wo'], function () {
        Route::get('/user', 'BmController@datauserWO')->name('datauserWO')->middleware('auth');
        Route::get('/apprroval', 'BmController@dataApprovalWO')->name('dataApprovalWO')->middleware('auth');
        Route::post('/buatWO', 'BmController@buatWO')->name('buatWO')->middleware('auth');
        Route::post('/approvalWO', 'BmController@approvalWO')->name('approvalWO')->middleware('auth');
        Route::get('/woBA/{id}', 'BmController@woBA')->name('woBA')->middleware('auth');
        Route::get('/exportWoAll', 'BmController@exportWoAll')->name('exportWoAll')->middleware('auth');
        Route::get('/dataPMQA', 'BmController@dataPMQA')->name('dataPMQA')->middleware('auth');
        Route::post('/editWO', 'BmController@editWO')->name('editWO')->middleware('auth');
        
    });
});

Route::group(['prefix' => 'document_customer'], function () {
    Route::group(['prefix' => 'master_product'], function () {
        Route::get('/', 'DocumentCustomerController@master_product')->name('master_product')->middleware('auth');
        Route::post('/create', 'DocumentCustomerController@master_product_create')->name('master_product_create')->middleware('auth');
        Route::post('/edit', 'DocumentCustomerController@master_product_edit')->name('master_product_edit')->middleware('auth');
    });
    Route::group(['prefix' => 'product_certificate'], function () {
        Route::get('/', 'DocumentCustomerController@product_certificate')->name('product_certificate')->middleware('auth');
        Route::post('/create', 'DocumentCustomerController@product_certificate_create')->name('product_certificate_create')->middleware('auth');
        Route::post('/update', 'DocumentCustomerController@product_certificate_update')->name('product_certificate_update')->middleware('auth');
        
    });
    Route::group(['prefix' => 'compliance_docs'], function () {
        Route::get('/', 'DocumentCustomerController@compliance_docs')->name('compliance_docs')->middleware('auth');
        Route::post('/create', 'DocumentCustomerController@compliance_docs_create')->name('compliance_docs_create')->middleware('auth');
        Route::post('/update', 'DocumentCustomerController@compliance_docs_update')->name('compliance_docs_update')->middleware('auth');
    });

    Route::group(['prefix' => 'cusComplient'], function () {
        Route::get('/-{status}', 'DocumentCustomerController@cusComplient')->name('cusComplient')->middleware('auth');
        Route::post('/approval', 'DocumentCustomerController@customerComp_approval')->name('customerComp_approval')->middleware('auth');
        Route::get('/report', function () {
            return view('qa.customer_dokumen.cus_complaint.report');
        })->name('cus_complaint.report')->middleware('auth');
        Route::post('/report/byYear', 'DocumentCustomerController@customerComp_report_byYear')->name('customerComp_report_byYear')->middleware('auth');
        Route::post('/report/exportCusCom', 'DocumentCustomerController@exportCusCom')->name('exportCusCom')->middleware('auth');
        
    });

    Route::group(['prefix' => 'product_information'], function () {
        Route::get('/-{status}', 'ProductInformationController@pi_qa')->name('pi_qa')->middleware('auth');
        Route::post('/pi_approval', 'ProductInformationController@pi_approval')->name('pi_approval')->middleware('auth');
    });
});
Route::group(['prefix' => 'qc'], function () {
    Route::group(['prefix' => 'nc'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/-{status}', 'NcController@dataUserNC')->name('dataUserNC')->middleware('auth');
        Route::get('/new-nc-form', function () {
            return view('qc.nc.newForm');
        })->name('nc.newForm')->middleware('auth');
        Route::get('/act/{category}/{id}', 'NcController@reORedit_nc')->name('reORedit_nc')->middleware('auth');
        Route::get('/nc_delete/{id}', 'NcController@nc_delete')->name('nc_delete')->middleware('auth');

        Route::post('/reORedit_nc_post', 'NcController@reORedit_nc_post')->name('reORedit_nc_post')->middleware('auth');


    });
    Route::get('/report', function () {
        return view('qc.nc.report');
    })->name('nc_report')->middleware('auth');
    Route::post('/report-post', 'NcController@nc_report')->name('nc_report_post')->middleware('auth');
    Route::post('/excel', 'NcController@nc_excel')->name('nc_excel')->middleware('auth');

    Route::get('/dataApprovall/{status}', 'NcController@dataApprovalNC')->name('dataApprovalNC')->middleware('auth');
    Route::post('/buatNC', 'NcController@buatNC')->name('buatNC')->middleware('auth');
    Route::post('/action_approval', 'NcController@action_approval')->name('action_approval')->middleware('auth');
    Route::get('/detail_nc_internal/{id}', 'NcController@detail_nc_internal')->name('detail_nc_internal')->middleware('auth');
    Route::get('/detail_nc_eksternal/{id}', 'NcController@detail_nc')->name('detail_nc')->middleware('auth');

    });
});


Route::group(['prefix' => 'fad'], function () {
    Route::group(['prefix' => 'master_data'], function () {
        Route::group(['prefix' => 'coa'], function () {
            Route::group(['prefix' => 'dashboard'], function () {
                Route::get('/grafik', 'FadCaController@master_coa_dashboard')->name('master_coa_dashboard')->middleware('auth');
            });
            Route::get('/index', 'FadCaController@master_coa_index')->name('master_coa_index')->middleware('auth');
            Route::post('/master_coa_create', 'FadCaController@master_coa_create')->name('master_coa_create')->middleware('auth');
            Route::post('/master_coa_update', 'FadCaController@master_coa_update')->name('master_coa_update')->middleware('auth');
            Route::get('/active/{id}', 'FadCaController@master_coa_change_status')->name('master_coa_change_status')->middleware('auth');
            Route::get('/download', 'FadCaController@master_coa_download')->name('master_coa_download')->middleware('auth');
        });

        Route::group(['prefix' => 'cost-center'], function () {
            Route::get('/index', 'FadCaController@master_costcenter_index')->name('master_costcenter_index')->middleware('auth');
            Route::post('/master_costcenter_create', 'FadCaController@master_costcenter_create')->name('master_costcenter_create')->middleware('auth');
            Route::get('/active/{id}', 'FadCaController@master_costcenter_change_status')->name('master_costcenter_change_status')->middleware('auth');
            Route::post('/master_costcenter_update', 'FadCaController@master_costcenter_update')->name('master_costcenter_update')->middleware('auth');
            Route::get('/download', 'FadCaController@master_costcenter_download')->name('master_costcenter_download')->middleware('auth');
        });
        Route::group(['prefix' => 'calendar'], function () {
            Route::get('/index', 'FadCaController@master_calendar_index')->name('master_calendar_index')->middleware('auth');
        });
    });
    Route::group(['prefix' => 'ca'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/request/-{status}', 'FadCaController@dataUserCA')->name('dataUserCA')->middleware('auth');
            Route::get('/form-request', 'FadCaController@formRequestCA')->name('ca.newForm')->middleware('auth');
            Route::post('/deleteItemCaEdit', 'FadCaController@deleteItemCaEdit')->name('deleteItemCaEdit')->middleware('auth');

            // Route::get('/form-request', function () {
            //     return view('fad.ca.user.newForm');
            // })->name('ca.newForm')->middleware('auth');
            Route::post('/buatCA', 'FadCaController@buatCA')->name('buatCA')->middleware('auth');
            Route::post('/updateCA', 'FadCaController@updateCA')->name('updateCA')->middleware('auth');
            Route::get('/formEditCA/{code}', 'FadCaController@formEditCA')->name('formEditCA')->middleware('auth');

            Route::get('/revisiCA/{id}', 'FadCaController@revisiCA')->name('revisiCA')->middleware('auth');

            Route::get('/deleteCA/{id}', 'FadCaController@deleteCA')->name('deleteCA')->middleware('auth');
            Route::group(['prefix' => 'realisasi'], function () {
                Route::get('/form/{id}', 'FadCaController@formRealisasi')->name('formRealisasi')->middleware('auth');
                Route::get('/form_revisi_realisasi/{id}', 'FadCaController@form_revisi_realisasi')->name('form_revisi_realisasi')->middleware('auth');
                Route::post('/action_revisi_realisasi', 'FadCaController@action_revisi_realisasi')->name('action_revisi_realisasi')->middleware('auth');
                                
                Route::post('/realisasiCA', 'FadCaController@realisasiCA')->name('realisasiCA')->middleware('auth');
                Route::get('/-{status}', 'FadCaController@indexRealisasiUser')->name('indexRealisasiUser')->middleware('auth');
            });
            Route::group(['prefix' => 'reimbursement'], function () {
                Route::get('/data/{status}', 'FadCaController@indexReimbursementUser')->name('indexReimbursementUser')->middleware('auth');
                Route::get('/edit/{id}', 'FadCaController@formEditReimbursement')->name('formEditReimbursement')->middleware('auth');
                Route::post('/editReimbursement', 'FadCaController@editReimbursement')->name('editReimbursement')->middleware('auth');
                Route::post('/deleteItemReimbursement', 'FadCaController@deleteItemReimbursement')->name('deleteItemReimbursement')->middleware('auth');
                
                Route::get('/new-form', function () {
                    return view('fad.ca.user.reimbursement.form');
                })->name('reimbursement.newForm')->middleware('auth');
                Route::post('/createReimbursement', 'FadCaController@createReimbursement')->name('createReimbursement')->middleware('auth');
            });
        });
        Route::group(['prefix' => 'approval'], function () {

            Route::get('/report', function () {
                return view('fad.ca.approval.report');
            })->name('CAReportView')->middleware('auth');
            Route::post('/CAReportData', 'FadCaController@CAReportData')->name('CAReportData')->middleware('auth');
            Route::post('/CAReportExcel', 'FadCaController@CAReportExcel')->name('CAReportExcel')->middleware('auth');
            

            Route::get('/-{status}', 'FadCaController@dataAppprovaCA')->name('dataAppprovaCA')->middleware('auth');
            Route::post('/action', 'FadCaController@actionApproval')->name('actionApproval')->middleware('auth');
            Route::get('/detail/{code}', 'FadCaController@printView')->name('printView')->middleware('auth');
            Route::get('/view_approval_ca_request/{id}/{approval_id}', 'FadCaController@view_approval_ca_request')->name('view_approval_ca_request')->middleware('auth');
            Route::post('/getTotalReimbursement', 'FadCaController@getTotalReimbursement')->name('getTotalReimbursement')->middleware('auth');
            Route::post('/getTotalRealisasi', 'FadCaController@getTotalRealisasi')->name('getTotalRealisasi')->middleware('auth');
            
            Route::get('/user_capacity', 'FadCaController@user_capacity_view')->name('user_capacity_view')->middleware('auth');
            Route::post('/user_capacity_update', 'FadCaController@user_capacity_update')->name('user_capacity_update')->middleware('auth');
            
            Route::group(['prefix' => 'realisasiCA'], function () {
                Route::get('/-{status}', 'FadCaController@indexRealisasiApproval')->name('indexRealisasiApproval')->middleware('auth');
                Route::post('/actionApprovalRealisasi', 'FadCaController@actionApprovalRealisasi')->name('actionApprovalRealisasi')->middleware('auth');
                Route::get('/print_realisasi/{id}', 'FadCaController@print_realisasi')->name('print_realisasi')->middleware('auth');
                Route::post('/update_last_printed_realiasi', 'FadCaController@update_last_printed_realiasi')->name('update_last_printed_realiasi')->middleware('auth');
                
            });

            Route::group(['prefix' => 'reimbursement'], function () {
                Route::get('/-{status}', 'FadCaController@indexReimbursementApproval')->name('indexReimbursementApproval')->middleware('auth');
            });
            
        });
   
    });
});

Route::group(['prefix' => 'qa'], function () {
    Route::group(['prefix' => 'change_management'], function () {
        Route::get('/user/{status}', 'ChangeManagementController@cm_user')->name('cm_user');
        Route::get('/request', function () {
            return view('qa.change_management.request');
        })->name('change_management.request')->middleware('auth');
        Route::post('/cm_create', 'ChangeManagementController@cm_create')->name('cm_create')->middleware('auth');
        Route::post('/cm_approval_action', 'ChangeManagementController@cm_approval_action')->name('cm_approval_action')->middleware('auth');
        Route::get('/approval/{status}', 'ChangeManagementController@cm_approval')->name('cm_approval')->middleware('auth');
        Route::post('/cm_qa_closed', 'ChangeManagementController@cm_qa_closed')->name('cm_qa_closed')->middleware('auth');
        Route::get('/cm_user_delete/{id}', 'ChangeManagementController@cm_user_delete')->name('cm_user_delete')->middleware('auth');
        Route::get('/cm_distributor_value/{id}', 'ChangeManagementController@cm_distributor_value')->name('cm_distributor_value')->middleware('auth');

    });
});


Route::group(['prefix' => 'mis'], function () {
    Route::group(['prefix' => 'troubleshoot'], function () {
        Route::group(['prefix' => 'user'], function () {

            Route::get('/request-form', function () {
                return view('mis.troubleshoot.user.form_request');
            })->name('troubleshoot.form_request')->middleware('auth');

            Route::get('/index/{status}', 'MisController@troubleshoot_user_it_index')->name('mis_user_index')->middleware('auth');
            Route::post('/troubleshoot_user_create', 'MisController@troubleshoot_user_create')->name('troubleshoot_user_create')->middleware('auth');
            Route::get('/troubleshoot_edit_view/{id}', 'MisController@troubleshoot_edit_view')->name('troubleshoot_edit_view')->middleware('auth');
            Route::post('/troubleshoot_edit_action', 'MisController@troubleshoot_edit_action')->name('troubleshoot_edit_action')->middleware('auth');
            
            Route::get('/troubleshooting_delete/{id}', 'MisController@troubleshooting_delete')->name('troubleshooting_delete')->middleware('auth');
        });

        Route::group(['prefix' => 'approver'], function () {
            Route::group(['prefix' => 'manager'], function () {
                Route::get('/dashboard', 'MisController@troubleshoot_dashboard_view')->name('mis.troubleshoot.manager.dashboard')->middleware('auth');
                Route::post('/troubleshoot_dashboard_post', 'MisController@troubleshoot_dashboard_post')->name('troubleshoot_dashboard_post')->middleware('auth');
                
                Route::get('/data/{status}', 'MisController@troubleshoot_manager_it_index')->name('troubleshoot_manager_it_index')->middleware('auth');
                Route::post('/troubleshoot_approval_action', 'MisController@troubleshoot_approval_action')->name('troubleshoot_approval_action')->middleware('auth');

                Route::get('/report', function () {
                    return view('mis.troubleshoot.approver.manager.report');
                })->name('mis.troubleshoot.approver.manager.report');
                Route::post('/troubleshoot_report', 'MisController@troubleshoot_report')->name('troubleshoot_report')->middleware('auth');
                Route::post('/troubleshoot_excel', 'MisController@troubleshoot_excel')->name('troubleshoot_excel')->middleware('auth');

            });
            Route::group(['prefix' => 'worker'], function () {
                Route::get('/data/{status}', 'MisController@troubleshoot_worker_it_index')->name('troubleshoot_worker_it_index')->middleware('auth');
                Route::post('/troubleshoot_worker_action', 'MisController@troubleshoot_worker_action')->name('troubleshoot_worker_action')->middleware('auth');
                Route::get('/report', function () {
                    return view('mis.troubleshoot.approver.worker.report');
                })->name('mis.troubleshoot.approver.worker.report');

                Route::get('/req_form', 'MisController@troubleshoot_worker_req_form')->name('troubleshoot_worker_req_form')->middleware('auth');
                Route::post('/troubleshoot_worker_create', 'MisController@troubleshoot_worker_create')->name('troubleshoot_worker_create')->middleware('auth');

            });
        });
    });
});

Route::group(['prefix' => 'ga'], function () {
    Route::group(['prefix' => 'barcode_kendaraan'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/form_pendaftaran', 'GA\KendaraanController@form_pendaftaran_withlogin')->name('ga_formbarcode_withlogin');
            Route::post('/find_by_nik_karywan', 'GA\KendaraanController@find_by_nik_karywan')->name('find_by_nik_karywan');
            Route::post('/create_barcode_with_login', 'GA\KendaraanController@create_barcode_with_login')->name('create_barcode_with_login');
        });
    });

});

//Di luar Kantor
Route::get('/scanner/{sr}', 'SampleServiceController@scanByBarcode')->name('scanner');
Route::get('test-email', 'JobController@enqueue');
Route::get('user-read-email/{id}', 'SampleServiceController@readEmail')->name('track');
Route::get('/getCostCenter_by_company', 'FadCaController@getCostCenter_by_company')->name('getCostCenter_by_company')->middleware('auth');
Route::get('/getCOA_by_company', 'FadCaController@getCOA_by_company')->name('getCOA_by_company')->middleware('auth');
Route::get('/getCOA_controller', 'FadCaController@getCOA_controller')->name('getCOA_controller')->middleware('auth');
Route::post('/update_coa_controller', 'FadCaController@update_coa_controller')->name('update_coa_controller')->middleware('auth');
Route::post('/update_cc_controller', 'FadCaController@update_cc_controller')->name('update_cc_controller')->middleware('auth');

Route::post('/update_coa_controller_realisasi', 'FadCaController@update_coa_controller_realisasi')->name('update_coa_controller_realisasi')->middleware('auth');
Route::post('/update_cc_controller_realisasi', 'FadCaController@update_cc_controller_realisasi')->name('update_cc_controller_realisasi')->middleware('auth');

Route::get('/getPlant_by_company', 'FadCaController@getPlant_by_company')->name('getPlant_by_company')->middleware('auth');



Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return 'Config Clear cleared';
}); 
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'cache Clear cleared';
});

Route::group(['prefix' => 'haldinfoods'], function () {
    Route::get('/page1', function () {
        return view('haldinfoods.page1');
    });
    Route::get('/page2', function () {
        return view('haldinfoods.page2');
    });
    Route::get('/page3', function () {
        return view('haldinfoods.page3');
    });
    Route::get('/page4', function () {
        return view('haldinfoods.page4');
    });
});


