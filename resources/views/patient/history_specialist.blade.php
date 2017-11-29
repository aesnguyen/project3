@extends('patient.layout')
@section('title')
Sổ khám chuyên khoa
@stop
@section('content')

<style>
    .showButton{
        margin: 10px;
    }
</style>
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>

<div class="form-group pull-right" >
    <button class="btn btn-default " data-toggle="modal" data-target="#myShare">Chia sẻ</button>
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

<div id="myShare" class="modal fade" role="dialog">
    <div class="modal-dialog" style="z-index:10241;width: 800px" >

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chia sẻ với</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('patient-share') }}" method="POST">
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
                    <input type="hidden" name="resource_id" value="" />

                    <div>
                        <button class="btn btn-default" type="submit">Lưu thay đổi</button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <table id="table" data-toggle="table"
               data-url="{{ route('history-specialist-json') }}">
            <thead>
                <tr>

                    <th data-field="name">Chuyên khoa</th>
                    <th data-field="medical_date"
                        data-formatter="dateFormatter">Ngày khám</th>
                    <th data-field="status" data-formatter="statusFormatter">Trạng thái</th>
                    <th data-field="id"
                        data-formatter="operateFormatter"
                        data-events="operateEvents">Xem chi tiết</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="TestModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kết quả khám</h4>
                </div>

                <form  action="/doctor/examination_end" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="patientId">
                        <h4>khám sơ bộ</h4>
                        <div id="so_bo" class="form-group"></div>
                        <h4>Kết quả xét nghiệm liên quan</h4>
                        <div id="xet_nghiem" class="form-group"></div>
                        <h4>Chuẩn đoán</h4>
                        <div id="chan_doan" class="form-group"></div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Chi tiết</h4>
                </div>
                <div class="modal-body">
                    <table id="table-detail" 
                           data-toggle="table"
                           data-url="">
                        <thead>
                            <tr>
                                <th data-field="thong_tin">
                                    Xét nghiệm
                                </th>
                                <th data-field="chi_so">
                                    Kết quả
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="removeMedicalApp" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa đơn khám?</h4>
                </div>
                <div class="modal-body">
                    <p>Bạn chắc chắn muốn xóa đơn khám này chứ?</p>
                </div>
                <div class="modal-footer">

                    <a
                        onclick="event.preventDefault();
    document.getElementById('remove-medical-form').submit();">

                        <button class="btn btn-danger" id="btn-delete-user">Xóa</button>
                    </a>

                    <form id="remove-medical-form" action="{{ url('/remove-medical-application') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="hidden" id="medical_id" name="medical_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        var $table = $('#table-detail');

        window.operateEvents = {
            'click .remove': function (e, value, row) {
                document.getElementById('medical_id').setAttribute("value", value)
            }
        };
        function nameFormatter(value, row, index) {
            return [
                '<span>Khám sức khỏe</span>',
            ].join('');
        }
        function operateFormatter(value, row, index) {
            return [
                // '<div class="pull-left">',
                // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
                // '</div>',
                '<div class="">',
                '<button class="btn btn-primary" onclick="openModel(&#39;' + value + '&#39;)">Kết quả</button>',
               
                '<a class="remove" href="javascript:void(0)" title="Xóa">',
                '<button class="btn btn-danger" data-toggle="modal" data-target="#removeMedicalApp">Xóa</button>',
                '</a>',
                '</div>'
            ].join('');
        }
        function openModel(i) {
            document.getElementById('patientId').value = i;
            $('#TestModel').modal('show');
            //alert('????');
            $.ajax({
                type: 'GET',
                url: 'getMedicalSpecialistInfo/' + i,
                data: '_token = <?php echo csrf_token() ?>',
                success: function (data) {
                    $("#so_bo").html(data.so_bo);
                    $("#xet_nghiem").html(data.xet_nghiem);
                    $("#chan_doan").html(data.chan_doan);
                }
            });
        }
        function statusFormatter(value, row, index) {
            if (value == 0) {
                return [
                    '<span style="color:red">đã hoàn thành</span>'
                ].join('');
            }
            if (value == 1) {
                return [
                    '<span style="color:blue">đang đợi khám</span>'
                ].join('');
            }
            if (value >1) {
                return [
                    'đang khám '
                ].join('');
            }
        }
        function operateFormatter2(value, row, index) {
            return [
                // '<div class="pull-left">',
                // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
                // '</div>',
                '<div class="">',
                '<a class="like2" href="javascript:void(0)" title="Like2">',
                '<button class="btn btn-primary" data-toggle="modal" data-target="#modalTestTable">Xem</button>',
                '</a>  ',
                '<a class="remove" href="javascript:void(0)" title="Xóa">',
                '<button class="btn btn-danger" data-toggle="modal" data-target="#removeMedicalApp">Xóa</button>',
                '</a>',
                '</div>'
            ].join('');
        }
        function dateFormatter(value, row, index) {
            return[
                value.substring(0, 10)
            ]
        }
        function getTestmedical(i) {
            // alert(i);
            $table.bootstrapTable('refresh', {
                url: '../../patient/specialistDetail.json/' + i
            });
        }
    </script>		

    @stop