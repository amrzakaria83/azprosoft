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
                تعديل
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
                <!--begin::Form-->
                <form action="{{route('admin.employees.updatepass')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الكود </label>
                            <div class="col-lg-8 fv-row">
                                <input readonly type="number" name="emp_code" placeholder="الكود " value="{{$data->emp_code}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الاسم بالعربي</label>
                            <div class="col-lg-8 fv-row">
                                <input readonly type="text" name="name_ar" placeholder="الاسم بالعربي" value="{{$data->name_ar}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label  fw-semibold fs-6">الاسم بالانجليزي</label>
                            <div class="col-lg-8 fv-row">
                                <input readonly type="text" name="name_en" placeholder="الاسم بالانجليزي " value="{{$data->name_en}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">كود الدخول </label>
                            <div class="col-lg-8 fv-row">
                                <input readonly type="text" id="emailaz" name="emailaz" placeholder="كود الدخول" value="{{$data->emailaz}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6 required">
                                كلمة المرور
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="لا يقل عن 6 حروف"></i>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input autofocus type="password" name="password" placeholder="كلمة المرور" value="{{$data->password}}" class="form-control form-control-lg form-control-solid" style="background-color: rgb(25, 218, 25)" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">رقم الهاتف</span>
                            </label>
                            <div class="col-sm-3 fv-row ">
                                <input readonly type="tel" name="phone" placeholder="رقم الهاتف" id="phone" value="{{$data->phone}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="tel" name="phone1" placeholder="رقم بديل" id="phone1" value="{{$data->phone1}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="tel" name="phone2" placeholder="رقم ارضي" id="phone2" value="{{$data->phone2}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">العنوان</label>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="text" name="address1" placeholder="العنوان" value="{{$data->address1}}" id="address1" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="text" name="address2" placeholder=" العنوان1" value="{{$data->address2}}" id="address2" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="text" name="address3" placeholder=" العنوان2" value="{{$data->address3}}" id="address3" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">الرقم القومي</label>
                            <div class="col-lg-8 fv-row">
                                <input readonly type="text" id="national_no" name="national_no" placeholder=" الرقم القومي" readonly value="{{$data->national_no}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label required fw-semibold fs-6">تاريخ التعيين</label>
                            <div class="col-sm-3 fv-row">
                                <input readonly class="form-control form-control-lg form-control-solid" type="date" name="work_date" placeholder="تاريخ التعيين" value="{{$data->work_date}}" id="work_date"/>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label fw-semibold fs-6">تاريخ الميلاد</label>
                            <div class="col-sm-3 fv-row">
                            <input readonly class="form-control form-control-lg form-control-solid" type="date" name="birth_date" placeholder="تاريخ الميلاد" value="{{$data->birth_date}}" id="birth_date"/>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label required fw-semibold fs-6">حالة الموظف</label>
                            <div class="col-sm-2 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid " type="text" value="{{$data->role_code}}" id="role_code" name="role_code" >
                                    <option value="0" @if($data->role_code == '0') selected @endif>متدرب</option>
                                    <option value="1" @if($data->role_code == '1') selected @endif>عامل</option>
                                    <option value="2" @if($data->role_code == '2') selected @endif>دليفري</option>
                                    <option value="3" @if($data->role_code == '3') selected @endif>موقوف</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label  fw-semibold fs-6" style=" max-width: 7% !important;">النوع</label>
                            <div class="col-sm-2 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" value="{{$data->gender}}" id="gender" name="gender"  >
                                    <option value="0"@if($data->gender == '0') selected @endif>Male</option>
                                    <option value="1"@if($data->gender == '1') selected @endif>Female</option>
                                </select>
                            </div>
                            <label class="col-sm-1 col-form-label fw-semibold fs-6">collect</label>
                            <div class="col-sm-2 d-flex align-items-center" >
                                <select  class="form-select form-select-lg form-select-solid"  id="collect_m" value="{{$data->collect_m}}"  name="collect_m">
                                    <option value="0"@if($data->collect_m == '0') selected @endif>no</option>
                                    <option value="1"@if($data->collect_m == '1') selected @endif>yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label  fw-semibold fs-6">بنك </label>
                            <div class="col-sm-3 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" value="{{$data->bank_code}}" id="bank_code" name="bank_code" >
                                <option value="">اختر بنك</option>
                                @foreach ($banks as $asd)
                                <option value="{{ $asd->id }}">{{ $asd->name_ar }}</option>
                                @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label  fw-semibold fs-6"style=" max-width: 7% !important;">الوظيفة </label>
                            <div class="col-sm-3 d-flex align-items-center" >
                                <select  class="form-select form-select-lg form-select-solid" value="{{$data->jobs_code}}" id="jobs_code" name="jobs_code" >
                                @foreach ($jobs as $asd)
                                <option value="{{ $asd->id }}">{{ $asd->name_en }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6" id="acc_bank_no" style="display: none">
                            <label class="col-sm-2 col-form-label fw-semibold fs-6">رقم الحساب</label>
                            <div class="col-sm-3 fv-row">
                                <input readonly type="text" name="acc_bank_no" id="acc_bank_no" placeholder="رقم الحساب" value="{{$data->acc_bank_no}}" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label required fw-semibold fs-6" >type</label>
                            <div class="col-sm-3 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" id="type"  name="type" value="{{$data->type}}" >
                                    <option value="0"@if($data->type == '0') selected @endif>Dash</option>
                                    <option value="1"@if($data->type == '1') selected @endif>No dash</option>
                                    <option value="2"@if($data->type == '2') selected @endif>Delivery access</option>
                                    <option value="3"@if($data->type == '3') selected @endif>all</option>
                                </select>
                            </div><br>
                            <label class="col-sm-2 col-form-label required fw-semibold fs-6" style=" max-width: 7% !important;">is_active</label>
                            <div class="col-sm-2 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" id="is_active"  name="is_active" value="{{$data->is_active}}" >
                                    <option value="0"@if($data->is_active == '0') selected @endif>not active</option>
                                    <option value="1"@if($data->is_active == '1') selected @endif>active</option>
                                    <option value="2"@if($data->is_active == '2') selected @endif>suspended</option>
                                    <option value="3"@if($data->is_active == '3') selected @endif>terminated</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-3 text-info">{{trans('lang.role_id')}} </label>
                            <div class="col-lg-8 fv-row">
                                <select  data-control="select2" data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0"  name="role_id">
                                <option value="">Select {{trans('lang.role_id')}}</option>
                                    @foreach (Spatie\Permission\Models\Role::all() as $item=>$row)
                                        <option value="{{$row->id}}" @if($row->id == $data->role_id) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label  fw-semibold fs-6">الراتب </label>
                            <div class="col-sm-3 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" value="{{$data->salary_code}}" id="salary_code" name="salary_code" >
                                @foreach ($salaries as $asd)
                                <option value="{{ $asd->id }}">{{ $asd->value }}</option>
                                @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label required  fw-semibold fs-6"> نوع الراتب</label>
                            <div class="col-sm-3 d-flex align-items-center"> <!--0 = cash, 1 = bank_transefer -->
                                <select  class="form-select form-select-lg form-select-solid"  name="method_for_payment" id="method_for_payment" value="{{$data->method_for_payment}}" >
                                    <option value="0"@if($data->method_for_payment == '0') selected @endif>كاش</option>
                                    <option value="1"@if($data->method_for_payment == '1') selected @endif>بنك</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    var accBankNoInput = $("#acc_bank_no_input");
    var accBankNoDiv = $("#acc_bank_no");
    if (accBankNoInput.val() !== "") {
    accBankNoDiv.show();}
    accBankNoInput.on("input", function() {
    if ($(this).val() !== "") {
        accBankNoDiv.show();} else {accBankNoDiv.hide();}});});
</script>
@endsection
