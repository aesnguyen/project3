<?php


//------------ Authenticate Local --------------------------
Route::group(['middleware' => 'web'], function(){

	Route::get('home-admin', 'oidcda\controllers\AuthLocalController@getHomeAdmin');

	// Route login backend
	Route::get('backend/login', 'oidcda\controllers\AuthLocalController@getBackendLogin');
	Route::post('backend/login', 'oidcda\controllers\AuthLocalController@postBackendLogin');

	Route::get('backend/register', 'oidcda\controllers\AuthLocalController@getBackendRegister');
	Route::post('backend/register', 'oidcda\controllers\AuthLocalController@postBackendRegister');

	Route::get('backend/logout', 'oidcda\controllers\AuthLocalController@getBackendLogout');
	Route::post('backend/logout', 'oidcda\controllers\AuthLocalController@postBackendLogout');

	// Route Login Frontend
	Route::get('login', 'oidcda\controllers\AuthLocalController@getLogin');
	Route::post('login', 'oidcda\controllers\AuthLocalController@postLogin');
	Route::get('logout', 'oidcda\controllers\AuthLocalController@getLogout');
	Route::post('logout', 'oidcda\controllers\AuthLocalController@postLogout');

	// Login with certificate
	Route::get('login-with-certificate', 'oidcda\controllers\AuthLocalController@getLoginWithCertificate');
	Route::post('login-with-certificate', 'oidcda\controllers\AuthLocalController@postLoginWithCertificate');

	// Route Register
	Route::get('register', 'oidcda\controllers\AuthLocalController@getRegister');
	Route::post('register', 'oidcda\controllers\AuthLocalController@postRegister');

	//----------------- OP's Authentication (vai OP)----------------------------------
	Route::get('authen', 'oidcda\controllers\OPController@getAuthen');

	Route::post('verify-account', 'oidcda\controllers\OPController@postVerifyAcc');

	Route::get('info-user', 'oidcda\controllers\OPController@getInfoUser');

	//--------------------- RP request to OP to authenticate end-user (vai RP)---------------------------
	Route::get('login-with-op', 'oidcda\controllers\RPController@getLoginWithOP');

	Route::get('authen-success', 'oidcda\controllers\RPController@getAuthenSuccess');

	Route::get('doctor/external/index', 'oidcda\controllers\RPController@getHomeExternal')
		->name('doctor-ex-index');
	Route::get('doctor/external/info', 'oidcda\controllers\RPController@getInfo')
		->name('doctor-ex-info');

	Route::get('logout-ex', 'oidcda\controllers\RPController@getLogoutEx');

	Route::post('logout-ex', 'oidcda\controllers\RPController@postLogoutEx');

	//---------------------- Session Management (vai OP) ------------------------------------
	Route::get('check-session-iframe', 'oidcda\controllers\AuthLocalController@checkSessionIframe');


	//----------------------- Route for bs ngoài (vai RP) -----------------------------------
	Route::get('doctor/external/list-patient-share','oidcda\controllers\RPController@listPatientShare')
		->name('doctor-list-patient-share');

	Route::get('list.json-patient','oidcda\controllers\RPController@listAsJsonPatient')
		->name('list-as-json-patient');
		
	Route::get('doctor/external/view_medical_exam/{id}','oidcda\controllers\RPController@xemBenhAn')
		->name('view_medical_exam_by_id');

	//----------------------- Route để đăng ký OpenID với OP (vai RP )-------------------------------------
	Route::get('admin/register-openid', 'oidcda\controllers\AuthLocalController@getRegisterOpenId')->middleware('admin')
		->name('admin-register-openid');
	Route::post('admin/register-openid', 'oidcda\controllers\AuthLocalController@postRegisterOpenId'); 

	Route::post('get-result-register', 'oidcda\controllers\AuthLocalController@postGetResultRegister'); 

	//----------------------- Route cho phép Relying Party đăng ký (vai OP) -----------------
	Route::post('registration', 'oidcda\controllers\AuthLocalController@postRegistration');

	// ---------- route xử lý request xóa op/rp của server khác gửi đến (vai OP) -------------------
	Route::post('admin/remove-oidc', 'oidcda\controllers\AuthLocalController@postRemoveOidc');
	
		// --------------------------- xử lý List Providers (vai RP) ------------------------------------------
	Route::get('admin/list-providers', 'oidcda\controllers\AuthLocalController@getListProviders')->middleware('admin')
		->name('admin-list-providers');
	Route::get('admin/list.json-providers','oidcda\controllers\RPController@listAsJsonProviders')
		->name('list-as-json-providers');

	Route::post('admin/list-providers/delete', 'oidcda\controllers\RPController@deleteProvider')->middleware('admin')
		->name('admin-del-op');

		// -------------------- xử lý List Clients (vai OP) --------------------------------------
	Route::get('admin/list-clients', 'oidcda\controllers\AuthLocalController@getListClients')->middleware('admin')
		->name('admin-list-clients');
	Route::get('admin/list.json-clients','oidcda\controllers\OPController@listAsJsonClients')->name('list-as-json-clients');

	Route::post('admin/list-clients/delete', 'oidcda\controllers\OPController@deleteClient')->middleware('admin')
		->name('admin-del-rp');

	// ------------------- xử lý các request Đến/Đi (vai OP)-------------------------
	Route::get('admin/list-requests', 'oidcda\controllers\AuthLocalController@getListRequests')->middleware('admin')
		->name('admin-list-requests');

	Route::get('admin/list.json-requests','oidcda\controllers\AuthLocalController@listAsJsonRequests')
		->name('list-as-json-requests');

	Route::post('admin/list-requests/handle', 'oidcda\controllers\AuthLocalController@postHandleRequests')->middleware('admin')->name('admin-handle-requests');

	Route::get('about', 'oidcda\controllers\OPController@getAbout');

	/// ------------------------ Test -----------------------------------------
	Route::get('test-create-cookie', function () {
		$response = new Illuminate\Http\Response('Da tao cookie: myCookie');
		$response->withCookie(cookie('myCookie', 'giap123456', 60));
		return $response;
		
	});

	Route::get('test-set-cookie', 'oidcda\controllers\OPController@testCreateCookie');

	Route::get('test-del-cookie', 'oidcda\controllers\OPController@testDelCookie');

	Route::get('test-get-cookie', 'oidcda\controllers\RPController@testGetCurrCookie');

	Route::get('test-get-session', 'oidcda\controllers\RPController@testGetCurrSess')->middleware('web');

	Route::get('test-op-get-session', 'oidcda\controllers\OPController@testOPGetSess')->middleware('web');

	Route::get('test-get-email-logged', function () {
		$email = Authen::getEmailUser();
		echo "email: " . $email;
		
	});

});