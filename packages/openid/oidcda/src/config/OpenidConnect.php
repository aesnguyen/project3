<?php
	/**
	*	File config này chứa các thông tin cần cấu hình cho Relying Party,
	*	Openid Provider.
	*/
return [
	/**
	*	Phần cấu hình cho OpenID Provider
	*	Cấu hình URL cho Openid Provider
	*	url_op_authen : nơi xử lý request của rp
	*/
	'url_op_authen' => env('URL_SERVER').'/authen',

	/**
	* 	Cấu hình domain hay issuer(iss) trong id_token trả về cho RP
	*	Provider Name = config('app.name')
	*/
	'domain' => env('URL_SERVER'),

	/**
	*	Cấu hình id token Endpoint
	*/
	'token_endpoint' => env('URL_SERVER').'token',

	/**
	*	Cấu hình Info Endpoint
	*/
	'info_endpoint' => env('URL_SERVER').'/info-user',

	/**
	*	Cấu hình remove client endpoint
	*/
	'delete_endpoint' => env('URL_SERVER').'/admin/remove-oidc',

	/**
	*	Cấu hình callback URL, nơi để OP trả kết quả (id_token)
	*/
	'uri_rp_callback' => env('URL_SERVER').'/authen-success',

	/**
	*	Cấu hình URL, nơi để OP trả kết quả đăng ký client
	*/
	'uri_rp_get_result' => env('URL_SERVER').'/get-result-register',

	/**
	*	Cấu hình registration endpoint
	*/
	'registration_endpoint' => env('URL_SERVER').'/registration',

	/**
	* 	Cấu hình check session endpoint, nơi check xem user còn logged trong OP không, nếu đã logout thì
	*	gửi thông báo cho bên RP, để RP logout user ra.
	*/
	'check_session_endpoint' => env('URL_SERVER').'/check-session-iframe',

	//------------------------------------------------------------------------

	/**
	*	Cấu hình Url gửi request (vai RP)
	*/
	'url_rp_idp' => env('URL_SERVER').'/login-with-op',

	/**
	*	Cấu hình Url để xử lý resopnse từ OP (vai RP)
	*/
	'redirect_url' => env('URL_SERVER').'/authen-success',

	/**
	*	cấu hình url force logout
	*/
	'url_force_logout' => env('URL_SERVER').'/logout',

	/**
	*	Cấu hình origin url
	*/
	'url_origin' => env('URL_SERVER'),
	
	/**
	*	Cấu hình tên cho cookie lưu khi user đăng nhập
	*/
	'name_cookie' => 'loggedinstt1',

	/**
	*	Cấu hình tên cho cookie, khi admin đăng nhập
	*/
	'name_cookie_admin' => 'loggedinstt1ad',
	
	/**
	*	tên cookie khi user của viện ngoài đăng nhập vào.
	*/
	'name_cookie_ex' => 'tokenLogged',
	/**
	*	tên cookie khi user của viện ngoài đăng nhập vào.
	*/
	'login_with_certificate' => env('URL_SERVER').'/login-with-certificate',

];

?>
