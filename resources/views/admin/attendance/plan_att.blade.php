@extends('admin.layout.master')
@php
    $route = 'admin.attendances';
    $viewPath = 'admin.attendances';
@endphp

@section('style')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/admin')}}">
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
                <form action="{{ route('admin.attendances.store_plan_att') }}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">

                        <div class="row mb-6">
                            <div class="col-lg-3 fv-row">
                                <input type="textarea" id="name"  name="name" placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid" />
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('admin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />

                            </div>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select text-center"  required  id="type_plan" name="type_plan" >
                                    <option value="">نوع الخطة</option>
                                                <option value="2">شهرية</option>
                                                <option value="1">اسبوعية</option>
                                                <option value="3">سنوية</option>
                                                <option value="0">يومية</option>
                                </select>
                            </div>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select text-center"  required  id="type_att" name="type_att" >
                                                <option value="1">موظف</option>
                                                <option value="0">موقع</option>
                                                <option value="2">مهمة</option>
                                </select>
                            </div>
                            <div class="col-lg-2 fv-row">
                                <input type="textarea" id="note"  name="note" placeholder="ملاحظات" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-lg-6 fv-row max-w-20px text-center">
                                <label class="col-sm-3 col-form-label required fw-semibold  ">موعد الحضور </label>
                                <input type="time" id="attendance_time_in" value="02:00:00"  name="attendance_time_in" class="col-3 bold texet-center fs-12" style="font-size: x-large"  step="1">
                            </div>
                            <div class="col-lg-6 fv-row max-w-20px text-center">
                                <label class="col-sm-3 col-form-label required fw-semibold  ">موعد الانصراف </label>
                                <input type="time" id="attendance_time_out" value="14:00:00"  name="attendance_time_out" class="col-3 bold texet-center fs-12" style="font-size: x-large"  step="1">
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
{{-- <script>
$('#attendance_time_in, #attendance_time_out').on('change', function() {
            var attendance_time_in = $('#attendance_time_in').val();
            var attendance_time_out = $('#attendance_time_out').val();

            var diff = attendance_time_out - attendance_time_in;
            console.log(diff);

            if (attendance_time_in == attendance_time_out ) {
                alert("يجب أن يكون الفرق بين الحضور والانصراف ساعة على الأقل");
                location.reload() ;
            }
            });
</script> --}}
<script>

</script>
@endsection
