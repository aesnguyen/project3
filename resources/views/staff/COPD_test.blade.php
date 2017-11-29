@extends('staff.layout.master')

@section('title')
Phiếu đo dung phế
@stop

@section('content')

@if(1)
<div class="form-group pull-right" >
    <button class="btn btn-default " data-toggle="modal" data-target="#myShare">Chia sẻ</button>
</div>
@endif

<div id="myShare" class="modal fade" role="dialog">
    <div class="modal-dialog" style="z-index:10241;width: 800px" >

        <!-- Modal content-->
        @if(1)
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chia sẻ với</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('doctor-share') }}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    @foreach($role_data as $item)
                    @if(in_array($item['id'], $roles))
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}" checked="">{{$item['name']}}
                        </label>
                    </div>   
                    @else
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}">{{$item['name']}}
                        </label>
                    </div>
                    @endif
                    @endforeach
                    <input type="hidden" name="resource_id" value="{!!$medical_id!!}" />

                    <div>
                        <button class="btn btn-default" type="submit">Lưu thay đổi</button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        @endif

    </div>
</div>

<div class="col-lg-12  ">
    @if(Session::has('flash_message'))
    <div class="alert alert-danger {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
    @elseif(Session::has('flash_message_success'))
    <div class="alert alert-success {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message_success') !!}
    </div>
    @endif
</div>

<form class="form-horizontal" action="{{ route('update-COPD-test-medical-info') }}" enctype="multipart/form-data" method="post">
    <h2 class="col-md-offset-3"> Thông tin bệnh nhân</h2>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Họ tên  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ten_benh_nhan); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Ngày sinh  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ngay_sinh); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Hộ khẩu thường trú  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ho_khau); ?></p>
        </div>
    </div>

    <h2 class="col-md-offset-3">Kết quả khám bệnh</h2>
    <h3><a data-toggle="collapse" href="#theluc" > Đo phế dung phổi</a></h3>
    <div id = "theluc" class="">
        <div class="form-group">
            <label for="input_FVC" class="col-md-2 control-label">FVC :</label>
            <div class="col-md-6">
                <input type="text" name="FVC" class="form-control" id="input_FVC" value="{{$FVC}}" >
            </div>
        </div>
        <div class="form-group">
            <label for="input_FEV1" class="col-md-2 control-label">FEV1 :</label>
            <div class="col-md-6">
                <input type="text" name="FEV1" class="form-control" id="input_FEV1" value="{{$FEV1}}" >
            </div>
        </div>
        <div class="form-group">
            <label for="input_PEF" class="col-md-2 control-label">PEF :</label>
            <div class="col-md-6">
                <input type="text"  name="PEF" class="form-control" id="input_PEF" value="{{$PEF}}" >
                <?php
                $room = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
                ?>
                <input type="hidden" name="room" value="<?= $room ?>" >
            </div>
        </div>
    </div>



    <div class="form-group">
        <input type="hidden" name="medicalID" value="<?php echo($medical_id); ?>">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-offset-4">
            <label>Hoàn thiện</label><input type="checkbox" value="1" name="checkSubmit" id="checkSubmit">
            <button type="button" onclick="getApi()" class="btn btn-success btn-lg">Bắt đầu đo kết quả</button>
            <button type="submit" class="btn btn-primary btn-lg">Lưu kết quả </button>


        </div>
    </div>

</form>
<script>
    function load() {
        $.ajax({
            type: 'GET',
            url: '/staff/medical_test_by_api/<?php echo($medical_id); ?>',
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
		console.log(data.msg);
                document.getElementById('input_FVC').value = data.FVC[0];
                document.getElementById('input_FEV1').value = data.FEV1[0];
                document.getElementById('input_PEF').value = data.PEF[0];

            }
        });
    }

    function getApi() {
        load();
        window.setInterval(function () {
            load();
        }, 10000);
    }

</script>
</script>
@stop
