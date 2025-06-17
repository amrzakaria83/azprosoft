@extends('superadmin.layout.master')
@php
    $route = 'superadmin.attendances';
    $viewPath = 'superadmin.attendances';
@endphp

@section('style')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                الرئيسية
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="#" class="text-muted text-hover-primary">الموظفين</a>
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card no-border">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-db-table-filter="search" id="search" name="search" class="form-control form-control-solid bg-light-dark text-dark w-250px ps-14" placeholder="البحث" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <form action="{{route('superadmin.attendances.store_emp_index_plan')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <select class=" name_ar form-control" id="name_ar" name="name_ar" placeholder="ادخل اسم الموظف"></select>
                            </div>
                            <div class="col-sm-3">
                                <h1 id="discriptionplan_att_emp_vacation"></h1>
                            </div>
                            <div class="col-sm-3">
                                <select class=" plan_att_mission_id form-control" id='plan_att_mission_id' name="plan_att_mission_id" placeholder="ادخل اسم الخطة"></select>
                            </div>
                        </div>
                            <div class="row mb-6">
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Card body-->
            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>
    <script>
        $('.name_ar').select2({
                placeholder: 'ادخل اسم الموظف او كوده',
                minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: "{{ url('superadmin/order_ph_requests/getempdelselect') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name_ar,
                                id: item.emp_code,


                            }})}},
                cache: true}});

        $('.name_ar').change(function() {
        var empName = $(this).find(":selected").text();
        var empValue = $(this).find(":selected").val();
    });
        </script>
<script>
                var mission = [];
                $('.plan_att_mission_id').select2({
                        placeholder: 'برجاء اختيار خطة الموظف',
                        minimumInputLength: 0,
                        ajax: {
                            type: "GET",
                            url: "{{ url('superadmin/attendances/getplan_att_emp_vacation') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                mission = data;
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.name,
                                        id: item.id,

                                    }})}},
                        cache: true
                    }});

                $('.plan_att_mission_id').change(function() {

                var empName = $(this).find(":selected").text();
                var empValue = $(this).find(":selected").val();
                var attendance_time_in = mission.find(x => x.id == empValue).attendance_time_in;
                var attendance_time_out = mission.find(x => x.id == empValue).attendance_time_out;
                var plan_att_mission_id = "اسم الموظف :"+$('.name_ar').find(":selected").text()+ "<br>" +"اسم الخطة : "
                +empName+ "<br>" + "موعد حضور :  "+attendance_time_in+ "<br>" +"وقت الانصراف : "+attendance_time_out;

                $('#plan_att_mission_id').val(empValue);
                $('#discriptionplan_att_emp_vacation').html(plan_att_mission_id);

            });
    </script>

@endsection
