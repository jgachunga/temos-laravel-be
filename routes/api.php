<?php

use App\Http\Controllers\API\V1\Auth\Role\RoleAPIController;
use App\Http\Controllers\API\V1\Auth\User\UserAPIController;
use App\Http\Controllers\API\V1\ChannelAPIController;
use App\Http\Controllers\API\V1\ClockInAPIController;
use App\Http\Controllers\API\V1\CustomerAPIController;
use App\Http\Controllers\API\V1\DashboardAPIController;
use App\Http\Controllers\API\V1\FormAPIController;
use App\Http\Controllers\API\V1\FormCategoryAPIController;
use App\Http\Controllers\API\V1\InvoiceAPIController;
use App\Http\Controllers\API\V1\OrderAPIController;
use App\Http\Controllers\API\V1\ProductAPIController;
use App\Http\Controllers\API\V1\ReportAppApiAPIController;
use App\Http\Controllers\API\V1\RouteAPIController;
use App\Http\Controllers\API\V1\SalesRepAPIController;
use App\Http\Controllers\API\V1\SaleStructureAPIController;
use App\Http\Controllers\API\V1\TeamsAPIController;
use App\Http\Controllers\API\V1\TypeAPIController;
use App\Http\Controllers\API\V1\UserDeviceInfoAPIController;
use App\Http\Controllers\API\V1\UserLocationHistoryAPIController;
use App\Http\Controllers\API\V1\ReportsAPIController;
use App\Http\Controllers\API\V1\StockistAPIController;
use App\Http\Controllers\API\V1\SubCustomerAPIController;
use App\Http\Controllers\API\V1\SyncAPIController;
use App\Models\ReportAppApi;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::group(['middleware' => ['json.response']], function () {

    // Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/sms', 'API\V1\AuthController@sms')->name('sms.api');
    // public routes
    Route::post('/login', 'API\V1\AuthController@login')->name('login.api');
    Route::post('/logincode', 'API\V1\AuthController@loginCode')->name('login.code');
    Route::post('auth/register', 'API\V1\AuthController@register')->name('register.api');

    Route::get('/structures/list', [SaleStructureAPIController::class, 'structuresList'])->name('structure.list');
    Route::get('/channel/list', [ChannelAPIController::class, 'channelList'])->name('channel.list');

    });
    // private routes
    Route::group(['prefix' => 'v1', 'namespace' => 'API\V1', 'middleware' => ['auth:api', 'json.response', 'structure'], 'as' => 'api.'], function () {
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::post('/registerrep', 'AuthController@registerSalesRep')->name('regrep.api');
        Route::resource('clients', 'ClientAPIController');
        Route::resource('channels', 'ChannelAPIController');
        Route::get('/channel/all', [ChannelAPIController::class, 'all'])->name('channel.all');
        Route::resource('products', 'ProductAPIController');
        Route::get('/product/serverside', [ProductAPIController::class, 'serverSide'])->name('channel.serverside');
        Route::get('/product/downloadtemplate', [ProductAPIController::class, 'downloadTemplate'])->name('product.template');
        Route::post('/product/import', [ProductAPIController::class, 'importExcel'])->name('product.import');
        Route::resource('categories', 'CategoryAPIController');
        Route::resource('sale_structures', 'SaleStructureAPIController');
        Route::get('/sale_structure/childs/{structure_id}', [SaleStructureAPIController::class, 'listChilds'])->name('sale_structure.childs');
        Route::get('/sale_structure/login', [SaleStructureAPIController::class, 'loginToUnit'])->name('sale_structure.login');
        Route::get('/sale_structure/loginreset', [SaleStructureAPIController::class, 'resetloginToUnit'])->name('sale_structure.loginreset');
        Route::resource('sales_reps', 'SalesRepAPIController');
        Route::get('/salesrep/users', [SalesRepAPIController::class, 'users'])->name('salesrep.users');
        Route::resource('payment_methods', 'PaymentMethodsAPIController');
        Route::resource('customers', 'CustomerAPIController');
        Route::resource('customer_sale_structrures', 'CustomerSaleStructrureAPIController');
        Route::resource('orders', 'OrderAPIController');
        Route::resource('order_details', 'OrderDetailAPIController');
        Route::get('/sale_structure/customer/{id}', [SaleStructureAPIController::class, 'custStructures'])->name('sale_structure.customer');
        Route::get('/product/structure', [ProductAPIController::class, 'serverSideApi'])->name('sale_structure.customer');
        Route::get('/order/customer', [OrderAPIController::class, 'customerOrders'])->name('order.customer');
        Route::get('/order/list', [OrderAPIController::class, 'listOrders'])->name('order.list');
        Route::get('/order/rep', [OrderAPIController::class, 'repOrders'])->name('order.rep');
        Route::resource('users', 'Auth\User\UserAPIController');
        Route::resource('roles', 'Auth\Role\RoleAPIController');
        Route::resource('permissions', 'PermissionAPIController');
        Route::resource('types', 'TypeAPIController');

        Route::resource('distributors', 'DistributorAPIController');
        Route::get('/type/all', [TypeAPIController::class, 'all'])->name('types.all');
        Route::resource('forms', 'FormAPIController');
        Route::get('/customer/index', [CustomerAPIController::class, 'indexapp'])->name('customer.index');
        Route::get('/form/index', [FormAPIController::class, 'indexapp'])->name('form.index');
        Route::get('/form/custom', [FormAPIController::class, 'indexcustom'])->name('form.indexcustom');
        Route::resource('versions', 'VersionAPIController');
        Route::post('/form/storeapi', [FormAPIController::class, 'storeApi'])->name('form.storeapi');
        Route::post('/form/custom', [FormAPIController::class, 'storeCustom'])->name('form.createapi');
        Route::resource('outlet_visits', 'OutletVisitAPIController');
        Route::resource('clock_ins', 'ClockInAPIController');
        Route::resource('teams', 'TeamsAPIController');
        Route::post('/team/attach', [TeamsAPIController::class, 'attach'])->name('team.attach');
        Route::get('/team/users', [TeamsAPIController::class, 'teamUsers'])->name('team.users');
        Route::resource('principals', 'PrincipalsAPIController');
        Route::get('/role/supervisor', [RoleAPIController::class, 'supervisors'])->name('role.supervisor');
        Route::resource('form_categories', 'FormCategoryAPIController');
        Route::resource('user_device_infos', 'UserDeviceInfoAPIController');
        Route::resource('countries', 'CountryAPIController');
        Route::resource('regions', 'RegionAPIController');
        Route::resource('routes', 'RouteAPIController');
        Route::post('/route/assign/{user_id}', [RouteAPIController::class, 'assign'])->name('route.assign');
        Route::resource('towns', 'TownAPIController');
        Route::resource('stockists', 'StockistAPIController');
        Route::resource('invoices', 'InvoiceAPIController');
        Route::resource('sale_unit_targets', 'SaleUnitTargetAPIController');
        Route::resource('user_targets', 'UserTargetAPIController');
        Route::post('/customer/storeapi', [CustomerAPIController::class, 'storeApi'])->name('customer.storeapi');
        Route::patch('/customer/updateapi/{id}', [CustomerAPIController::class, 'updateApi'])->name('customer.updateapi');
        Route::post('/invoice/sync', [InvoiceAPIController::class, 'sync'])->name('invoice.sync');
        Route::get('/invoice/list', [InvoiceAPIController::class, 'listInvoices'])->name('invoice.list');
        Route::get('/invoiceadmin/list', [InvoiceAPIController::class, 'list'])->name('invoiceadmin.list');
        Route::get('/activity/list', [UserLocationHistoryAPIController::class, 'list'])->name('activity.list');
        Route::get('/activity/listindividual', [UserLocationHistoryAPIController::class, 'listIndividual'])->name('activity.listindividual');
        Route::get('/userinfo/list', [UserDeviceInfoAPIController::class, 'list'])->name('userinfo.list');
        Route::get('/report/salebycustomer', [ReportsAPIController::class, 'saleByCustomer'])->name('report.salebycustomer');
        Route::post('/report/salebycustomerregion', [ReportsAPIController::class, 'saleByCustomerRegion'])->name('report.salebycustomerregion');
        Route::post('/report/salebyproduct', [ReportsAPIController::class, 'saleByProduct'])->name('report.saleByProduct');
        Route::get('/clockin/list', [ClockInAPIController::class, 'list'])->name('clockin.list');
        Route::resource('areas', 'AreaAPIController');
        Route::get('/route/getbyuser', [RouteAPIController::class, 'routeByUser'])->name('route.byuser');
        Route::get('/customer/byroute/{route_id}', [CustomerAPIController::class, 'listByRoute'])->name('customer.byroute');
        Route::post('/subcustomer/storeapi', [SubCustomerAPIController::class, 'storeApi'])->name('subcustomer.storeapi');
        Route::patch('/subcustomer/updateapi/{id}', [SubCustomerAPIController::class, 'updateApi'])->name('subcustomer.updateapi');
        Route::resource('user_routes', 'UserRouteAPIController');
        Route::resource('sub_customers', 'SubCustomerAPIController');
        Route::post('/clockin/list', [ReportsAPIController::class, 'getClockins'])->name('clockin.report');
        Route::post('/report/outlet_visits', [ReportsAPIController::class, 'outletVisits'])->name('outlets.report');
        Route::post('/invoice/order', [InvoiceAPIController::class, 'confirmOrder'])->name('invoice.order');
        Route::post('/form_category/status/{id}', [FormCategoryAPIController::class, 'updateStatus'])->name('formcategory.status');
        Route::resource('skip_options', 'SkipOptionAPIController');
        Route::resource('question_types', 'QuestionTypeAPIController');
        Route::resource('skip_conditions', 'SkipConditionAPIController');
        Route::resource('dashboard', 'DashboardAPIController');
        Route::get('/dashboarddata', [DashboardAPIController::class, 'indexAdmin'])->name('dashboard.list');
        Route::get('/dashboardchart', [DashboardAPIController::class, 'chart'])->name('dashboard.chart');
        Route::get('/dashboarduser', [DashboardAPIController::class, 'userSummary'])->name('dashboard.user');
        Route::post('/surveyreport/{id}', [ReportsAPIController::class, 'getSurvey'])->name('dashboard.user');
        Route::post('/report/salebycustomerregionorder', [ReportsAPIController::class, 'saleByCustomerRegionOrder'])->name('report.salebycustomerregionorder');
        Route::post('report/dailysales', [ReportsAPIController::class, 'dailySales'])->name('report.dailysale');
        Route::post('report/coverage', [ReportsAPIController::class, 'coverage'])->name('report.coverage');
        Route::resource('user_clients', 'UserClientAPIController');
        Route::get('/form/formAll', [FormAPIController::class, 'formAll'])->name('form.index');
        Route::resource('syncs', 'SyncAPIController');
        Route::post('/sync/customer', [SyncAPIController::class, 'customerSync'])->name('sync.customer');
        Route::post('/sync/invoice', [SyncAPIController::class, 'invoiceSync'])->name('sync.invoice');
        Route::post('/sync/clockIn', [SyncAPIController::class, 'clockInSync'])->name('sync.clockInSync');
        Route::post('/sync/survey', [SyncAPIController::class, 'surveySync'])->name('sync.survey');
        Route::get('/appreport/visits', [ReportAppApiAPIController::class, 'visitsSummary'])->name('appreport.visits');
        Route::get('/appreport/salesGraph', [ReportAppApiAPIController::class, 'salesGraph'])->name('appreport.sales');
        Route::get('/appreport/skuList', [ReportAppApiAPIController::class, 'skuList'])->name('appreport.skus');
        Route::get('/invoice/confirmOrder/{id}', [InvoiceAPIController::class, 'confirmOrderNew'])->name('invoice.confirmOrderNew');
        Route::get('/appreport/summary', [ReportAppApiAPIController::class, 'userSummary'])->name('appreport.summary');
        Route::post('/updateUser', 'AuthController@updateUser')->name('updateUser.api');
        Route::get('/isClockedIn', 'ClockInAPIController@isClockedIn')->name('isClockedIn.api');
        Route::post('/updateUserDetails', [UserAPIController::class, 'updateUserDetails'])->name('updateUserDetails.api');
    });


Route::resource('customer_details', 'CustomerDetailAPIController');

Route::resource('form_photos', 'FormPhotoAPIController');
