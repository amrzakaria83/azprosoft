@extends('superadmin.layout.master')

@section('css')
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
                <a  href="{{route('superadmin.delivery_customers.indexcutomer_del_all_data')}}" class="text-muted text-hover-primary">عملاء التوصيل</a>
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
                        <div id="kt_account_settings_profile_details" class="collapse show">
                            <form action="{{route('superadmin.delivery_customers.storecutomer_del_all_data')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top " >
                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />

                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الاسم</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="cutomer_del_name_ar" placeholder="الاسم" value="" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                            <span class="required">رقم الهاتف</span>
                                        </label>
                                        <div class="col-sm-3 fv-row ">
                                            <input type="tel" name="phone1" placeholder="رقم الهاتف" id="phone1" value="" required class="form-control form-control-lg form-control-solid" />
                                        </div>
                                        <div class="col-sm-3 fv-row">
                                            <input type="tel" name="phone2" placeholder="رقم بديل"  id="phone2" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">العنوان</label>
                                        <div class="col-sm-3 fv-row">
                                            <input type="text" name="address" placeholder="العنوان" id="address" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">ملاحظات</label>
                                        <div class="col-sm-3 fv-row">
                                            <input type="text" name="note" placeholder="ملاحظات" id="note" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-sm-2  required col-form-label fw-semibold fs-6">المنطقة </label>
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid"  id="area_id" name="area_id" >
                                                <option value="">اختر المنطقة</option>
                                                @foreach ($areas as $asd)
                                            <option value="{{ $asd->id }}">{{ $asd->name_ar }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                            <label class="col-sm-1 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">collect</label>
                                            <div class="col-sm-2 d-flex align-items-center" >
                                                <select  class="form-select form-select-lg form-select-solid"  id="status"  name="status">
                                                    <option value="0">مفعل</option>
                                                    <option value="1">غير مفعل</option>
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-lg-2 col-form-label  fw-semibold fs-6">map_location</label>
                                    <div class="col-sm-3 fv-row">
                                        <input type="text" name="map_location" placeholder="map_location" id="map_location" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                                </div>
                                <!--end::Actions-->
                            </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
            <!--end::Content-->
            <div class="">
                <div class="modal fade" tabindex="-1" id="kt_modal_1b">
                    <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title"> Add Job</h3>
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('superadmin.employees.jobadd')}}" method="POST">
                                            @csrf
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الوظيفة بالعربية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_ar" name="name_ar" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->id}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الوظيفة بالانجليزية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_en" name="name_en" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">وصف الوظيفة </label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="description" name="description" required placeholder="وصف الوظيفة" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="jobadd" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="modal fade" tabindex="-1" id="kt_modal_2a">
                    <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title"> Add bank</h3>
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('superadmin.employees.bankadd')}}" method="POST">
                                            @csrf
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم البنك بالعربية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_ar" name="name_ar" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->id}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم البنك بالانجليزية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_en" name="name_en" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">رقم الحساب</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="acc_no" name="acc_no" required placeholder="رقم الحساب" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الفرع</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="branch" name="branch" required placeholder="اسم الفرع" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="bankadd" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('script')
<script>
$("#national_no").on('blur', function() {
    var national_no = $(this).val();
    var yb;
    var firstnational_no = national_no.toString().charAt(0);
if (firstnational_no < '3') {yb = '19';} else {yb = '20';}
var yearOfBirth = yb + national_no.substr(1, 2) ;
var monthOfBirth = national_no.substr(3, 2);
var dayOfBirth = national_no.substr(5, 2);
var birthdate = yearOfBirth + '-' + monthOfBirth + '-' + dayOfBirth;
document.getElementById("birth_date").value = birthdate;
var gender = national_no.substr(12,1);
    if (gender % 2 == 0) {document.getElementById("gender").value = 1; // female
    } else {document.getElementById("gender").value = 0; // male
    }
});

</script>
<script>
$(document).ready(function() {$("#bank_code").change(function() {if ($(this).val() !== "") {
$("#acc_bank_no").show();
document.getElementById("method_for_payment").value = 1;
} else {
$("#acc_bank_no").hide();
}});});
</script>
@endsection
