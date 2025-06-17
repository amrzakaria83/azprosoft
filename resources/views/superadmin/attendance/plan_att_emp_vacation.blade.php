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

        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{ route('superadmin.attendances.store_plan_att_emp_vacation') }}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <div class="row mb-6">
                                <div class="col-lg-3 fv-row">
                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                    {{-- <input type="hidden" id="emp_code_approved" readonly name="emp_code_approved" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" /> --}}
                                    <div class="col-sm-10">
                                        <select class=" name_ar form-control" id='name_ar' name="name_ar" placeholder="ادخل اسم الموظف"></select>
                                    </div>
                                </div>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select text-center"  required  id="type_plan_att_emp_vacation" name="type_plan_att_emp_vacation" >
                                    <option value="">طبعيعة الاذن</option>
                                                <option value="0">اجازة طبيعية</option>
                                                <option value="1">اجازة بدون مرتب</option>
                                                <option value="2">اجازة مدفوعة الاجر</option>
                                                <option value="3">اجازة نسبة الاجر</option>
                                                <option value="4">وقت عمل اضافى بدون اجر</option>
                                                <option value="5">وقت عمل اضافى باجر</option>
                                                <option value="6">وقت عمل اضافى باجر اضافى</option>
                                </select>
                            </div>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select text-center"  required  id="status_for_approved" name="status_for_approved" >
                                    <option value="0">مقبول</option>
                                    <option value="1">غير مقبول</option>
                                </select>
                            </div>
                            <div class="col-sm-1 fv-row">
                                <div class="input-group input-group-solid mb-5 text-center">
                                    <input type="text" id="percentage_value" name="percentage_value" class="form-control" placeholder="percentage value" aria-label="percentage value"/>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-lg-4 fv-row max-w-20px text-center">
                                <label class="col-sm-3 col-form-label required fw-semibold  ">الاذن يبدأ من</label>
                                <input type="datetime-local" id="attendance_datetime_in" value=""  name="attendance_datetime_in" class="col-8 bold texet-center fs-12" required style="font-size: x-large"  step="1">
                            </div>
                            <div class="col-lg-4 fv-row max-w-20px text-center">
                                <label class="col-sm-3 col-form-label required fw-semibold  ">نهاية الاذن</label>
                                <input type="datetime-local" id="attendance_datetime_out" value=""  name="attendance_datetime_out" class="col-8 bold texet-center fs-12" required style="font-size: x-large"  step="1">
                            </div>
                            <div class="col-lg-3 fv-row">
                                <input type="textarea" id="note"  name="note" placeholder="ملاحظات" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>

</script>

<script>
    $('.name_ar').select2({
            placeholder: 'ادخل اسم الموظف او كوده',
            minimumInputLength: 3,
            ajax: {
                type: "GET",
                url: "{{ url('superadmin/attendances/getempdelselect') }}",
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
    $('#name_ar').val(empValue);
    console.log(empValue);
});
    </script>
@endsection
