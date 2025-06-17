@extends('superadmin.layout.master')

@section('css')
<link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="" class="text-muted text-hover-primary">'طلب ادوية من صيدلية'</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                اضف جديد
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_docs_repeater_basic">
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{route('superadmin.trans_ph_requests.storechange')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <div class="row mb-6">
                        <div class="col-sm-6">
                            <h1 id="fromit" style="border-style: double; text-align:center;background-color: yellowgreen"  name="start_id" value="{{$data->start_id}}" >
                                محول من : {{$data->getstore->name}}
                            </h1>
                        </div>
                            <div class="col-sm-6">
                                <h1 id="toit" style="border-style: double; text-align:center;background-color: rgb(248, 190, 252)"  name="to_id"  value="{{$data->to_id}}" >
                                    محول الى : {{$data->idstore->name}}
                                </h1>
                                </div>
                                <div class="col-sm-3">
                                    <p id="" style="border-style: double; text-align:center;background-color: rgb(247, 247, 247)"  name=""  value="" >
                                    اسم الدليفرى القديم : {{$data->getempdel->name_ar}}
                                    </p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p id="" style="border-style: double; text-align:center;background-color: rgb(247, 247, 247)"  name=""  value="" >
                                        ملاحظات مع الادخال  : {{$data->note}}@if($data->note == null)
                                        لا يوجد ملاحظات
                                    @endif
                                    </p>
                                        </div>
                                        <input type="hidden" name="no_for_change" id="no_for_change" value="{{$data->id}}" >
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-2">
                                <label for="del_code">كود الدليفرى الجديد</label>
                                <input type="number" id="del_code" name="del_code" value="" class="form-control form-control-lg form-control-solid" required style="text-align: center; background-color: rgb(255, 145, 145)" />
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                            </div>
                            <div class="col-sm-2">
                                <label for="name_ar">ادخل اسم الدليفرى الجديد</label>
                                <select class=" name_ar form-control" id='name_ar' name="name_ar"></select>
                            </div>
                            <div class="col-sm-3">
                                <label for="note">ملاحظات</label>
                                <input type="text" id="note" name="note" placeholder="ملاحظات " value="" class="form-control form-control-lg form-control-solid"  />
                                </div>
                            </div>
                            <div class="row mb-6">
                                <div class="col-sm-4">
                                    <label for="emp_name_ar_re1">اسم الدليفرى</label>
                                        <h1 id="emp_name_ar_re1" style="border-style: double; text-align:center"  >
                                        Name Deleviry
                                        </h1>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
    $("#del_code").on('blur', function() {
    var code = $(this).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "GET",
        url: "{{ url('superadmin/trans_ph_requests/getemp')}}",
        data: {"code": code},
        success: function (data) {
        console.log(data.data);
        $("#emp_name_ar_re").val(data.data);
        $("#emp_name_ar_re1").html(data.data);}});});
        $('.name_ar').select2({
            placeholder: 'Select an item',
            minimumInputLength: 3,
            ajax: {
                type: "GET",
                url: "{{ url('superadmin/trans_ph_requests/getempdel') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name_ar,
                            id: item.emp_code,}})}},
            cache: true}});
    $('.name_ar').change(function() {
        var empName = $('#name_ar').find(":selected").text();
        var empValue = $('#name_ar').find(":selected").val();
        $("#emp_name_ar_re").val(empName);
        $("#del_code").val(empValue);});
    </script>
<script>

</script>
@endsection

