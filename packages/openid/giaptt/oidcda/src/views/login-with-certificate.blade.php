@extends('oidcda::app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div >
                    @if(isset($err))
                        {{ $err }}
                    @endif
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" id ="login-form" role="form" method="POST" action="{{ url('/login-with-certificate') }}" id="loginForm" onsubmit= "return hashPassword()">
                        {{ csrf_field() }}
                        <input type="hidden" name="_hashPass" id="_hashPass" value="">
                        <input type="hidden" name="_sess_id" id="_sess_id" value="{{ $sess_id }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button id="loginBtn" class="btn btn-primary btn-md">
                                            Login with Certificate
                                        </button>
                                    </div>
                                </div>                   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script type="text/javascript">
    document.getElementById("loginBtn").addEventListener("click", function(event){
        event.preventDefault();

        var originValue = '';
        $('#loginForm :input:not([type=hidden]):not([readonly])').each(function (index) {
            originValue += $(this).val();
        });
        var currentdate = new Date();
        var time = currentdate.getHours() + ":"
            + currentdate.getMinutes() + ":"
            + currentdate.getSeconds()
            + ' '
            + currentdate.getDate() + "/"
            + (currentdate.getMonth()+1)  + "/"
            + currentdate.getFullYear();
        originValue += time;
        console.log("before post create message"+originValue);
        window.postMessage({
            type: "CREATE_SIGNATURE_REQUEST",
            originValue: originValue
        }, "*");
        console.log("after create mess");
        window.addEventListener("message", function (event) {
            if (event.source != window)
        console.log("addEventListener false");
                return false;

            if (event.data.type && (event.data.type == "CREATE_SIGNATURE_RESPONSE")) {
        console.log("create response");
                if (event.data.success) {
        console.log("data success");
                    if (event.data.signature !== null) {
                        alert("Chứng từ số đăng nhập hợp lệ!");
                        $('#signatureValue').val(event.data.signature);
                        $('#signDatetime').val(time);
                        $('#certificate').val(event.data.certificate);
                        $('#loginForm :input:not([type=hidden]):not([readonly])').each(function (index) {
                            $(this).prop("readonly", true);
                        });
                        // get pass ng dùng nhập vào
				        // var inPass = document.forms['myForm']['password'].value;
				        //var inPass = document.getElementById('password').value;
				        var inPass = $('#password').val();
				        // get session_id from server
				        //var sess_id = document.forms['myForm']['_sess_id'].value;
				        var sess_id = $('#_sess_id').val();
				        // băm pass, session_id
				        var hashPass = CryptoJS.SHA256(inPass);
				        // nối chuỗi hashPass với hashSess, và tiến hành băm
				        var hPwdSess = CryptoJS.SHA256(hashPass + sess_id);

				        // set lại url, rồi gửi đến server
				        //document.forms['myForm']['_hashPass'].value = hPwdSess;
				        $('#_hashPass').val(hPwdSess);
				        return true;
                    } else {
                        alert("Chứng thư đã chọn không được dùng để đăng nhập!");
                    }
                }
                else {
                    alert("Chứng thư không hợp lệ!");
                }
            }
        })
    });
</script>

@stop
