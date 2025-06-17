@extends('admin.layout.master')

@section('css')
@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/admin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('admin.employees.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                        <form action="{{route('admin.employees.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                        @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top " >

                                    <div class="row mb-6" style="display:none;">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الكود </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="hidden" id="id" name="id" placeholder=" الكود" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                        <label class="col-sm-2 col-form-label fw-semibold fs-6">token </label>
                                        <div class="col-sm-3 fv-row">
                                            <input type="hidden" id="token" name="token" placeholder=" token" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                                        </div>
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">2الكود </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="hidden" id="del_code" name="del_code" placeholder=" 2الكود" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الكود </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" required id="emp_code" name="emp_code" placeholder="الكود " value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الاسم بالعربي</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_ar" name="name_ar" placeholder="الاسم بالعربي" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">الاسم بالانجليزي</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_en" name="name_en" placeholder="الاسم بالانجليزي " value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">كود الدخول </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" required id="emailaz" name="emailaz" placeholder="كود الدخول" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6 required">
                                            كلمة المرور
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="لا يقل عن 6 حروف"></i>
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="password" name="password" placeholder="كلمة المرور" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                            <span class="required">رقم الهاتف</span>
                                        </label>
                                        <div class="col-sm-3 fv-row ">
                                            <input type="tel" name="phone" placeholder="رقم الهاتف" id="phone" value="" class="form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                        <div class="col-sm-3 fv-row">
                                            <input type="tel" name="phone1" placeholder="رقم بديل"  id="phone1" value="" class="form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                        <div class="col-sm-3 fv-row">
                                            <input type="tel" name="phone2" placeholder="رقم ارضي" id="phone2" value="" class="form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">العنوان</label>
                                        <div class="col-sm-3 fv-row">
                                            <input type="text" name="address1" placeholder="العنوان" id="address1" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0 text-center" />
                                        </div>
                                        <div class="col-sm-3 fv-row">
                                            <input type="text" name="address2" placeholder=" العنوان1" id="address2" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0 text-center" />
                                        </div>
                                        <div class="col-sm-3 fv-row">
                                            <input type="text" name="address3" placeholder=" العنوان2" id="address3" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0 text-center" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">الرقم القومي</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="national_no" name="national_no" placeholder=" الرقم القومي" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6"  >
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6">تاريخ التعيين</label>
                                        <div class="col-sm-3 fv-row">
                                            <input class="form-control form-control-lg form-control-solid text-center" type="date" name="work_date" placeholder="تاريخ التعيين" value="" id="work_date"/>
                                        </div>
                                        <label class="col-sm-2 col-form-label fw-semibold fs-6">تاريخ الميلاد</label>
                                        <div class="col-sm-3 fv-row">
                                            <input class="form-control form-control-lg form-control-solid text-center" type="date" name="birth_date" placeholder="تاريخ الميلاد" value="" id="birth_date"/>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6">حالة الموظف</label>
                                        <div class="col-sm-3 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center " type="text" id="role_code" name="role_code" >
                                                <option value="0">متدرب</option>
                                                <option value="1">عامل</option>
                                                <option value="2">دليفري</option>
                                                <option value="3">موقوف</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6"  style=" max-width: 7% !important;">النوع</label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" required id="gender"  name="gender">
                                                <option value="">اختر</option>
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">collect</label>
                                        <div class="col-sm-2 d-flex align-items-center" >
                                            <select  class="form-select form-select-lg form-select-solid text-center"  id="collect_m"  name="collect_m">
                                                <option value="0">no</option>
                                                <option value="1">yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-sm-2 col-form-label fw-semibold fs-6">بنك </label>
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center"  id="bank_code" name="bank_code" >
                                                <option value="">اختر بنك</option>
                                                @foreach ($banks as $asd)
                                                    <option value="{{ $asd->id }}">{{ $asd->name_ar }}</option>
                                                @endforeach
                                            </select>
                                            <!-- <button type="button" class="btn btn-primary btn-sm col-sm-4" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
                                                Add Bank</button> -->
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center" id="acc_bank_no" style="display: none !important">
                                            <label class="col-sm-3 col-form-label required fw-semibold fs-6">رقم الحساب البنكى</label>
                                            <div class="col-sm-6 fv-row" >
                                                <input type="text" name="acc_bank_no"  placeholder=" رقم الحساب البنكى" value="" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6" id="" style="">
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" style="">الوظيفة </label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" value="" id="jobs_code" required name="jobs_code"  >
                                                <option value="">اختر</option>
                                                @foreach ($jobs as $asd)
                                            <option value="{{ $asd->id }}">{{ $asd->name_en }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                            <!-- <button type="button" class="btn btn-primary btn-sm col-sm-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                Add Job</button> -->
                                    </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" >type</label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" id="type" name="type" value="" >
                                                <option value="0">Dash</option>   <!-- admin -->
                                                <option value="1" selected>No dash</option>
                                                <option value="2">Delivery access</option>  <!-- subadmin -->
                                                <option value="3" disabled></option> <!-- admin -->
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" style=" max-width: 7% !important;">is_active</label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" id="is_active"  name="is_active" value="" >
                                                <option value="0">not active</option>
                                                <option value="1">active</option>
                                                <option value="2">suspended</option>
                                                <option value="3">terminated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-3 text-info">{{trans('lang.role_id')}} </label>
                                        <div class="col-lg-8 fv-row">
                                            <select  data-control="select2" data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0"  name="role_id">
                                            <option value="">Select {{trans('lang.role_id')}}</option>
                                                @foreach (Spatie\Permission\Models\Role::all() as $item=>$row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-sm-2 col-form-label  fw-semibold fs-6">الراتب </label>
                                        <div class="col-sm-3 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" value="" id="salary_code" name="salary_code" >
                                            @foreach ($salaries as $asd)
                                            <option value="{{ $asd->id }}">{{ $asd->value }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label required  fw-semibold fs-6"> نوع الراتب</label>
                                        <div class="col-sm-3 d-flex align-items-center"><!--0 = cash, 1 = bank_transefer -->
                                            <select  class="form-select form-select-lg form-select-solid text-center" id="method_for_payment"  name="method_for_payment" value="" >
                                                <option value="0">كاش</option>
                                                <option value="1">بنك</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.note')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="note" name="note" placeholder="{{trans('lang.note')}}" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
        </div>
    </div>
            <!--end::Content-->
            <div class="">
                <div class="modal fade" tabindex="-1" id="kt_modal_1">
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
                                        <form action="{{route('admin.employees.jobadd')}}" method="POST">
                                            @csrf
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الوظيفة بالعربية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_ar_job" name="name_ar_job" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الوظيفة بالانجليزية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_en_job" name="name_en_job" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
                <div class="modal fade" tabindex="-1" id="kt_modal_2">
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
                                        <form action="{{route('admin.employees.bankadd')}}" method="POST">
                                            @csrf
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم البنك بالعربية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_ar_bank" name="name_ar_bank" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                                </div>
                                            </div>
                                            <div class="row mb-12">
                                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم البنك بالانجليزية</label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" id="name_en_bank" name="name_en_bank" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
$(document).ready(function() {
    $("#bank_code").change(function() {
    if ($(this).val() !== "") {
    $("#acc_bank_no").show();
        document.getElementById("method_for_payment").value = 1;
        } else {
    $("#acc_bank_no").hide();
    }
});
});
</script>
@endsection
