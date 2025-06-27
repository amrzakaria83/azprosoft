@extends('admin.layout.master')

@section('css')

@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">البروفايل </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.employees.index')}}" class="text-muted text-hover-primary">الموظفين</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">البروفايل</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
</div>
@endsection

@section('content')

<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card">
            <div class="card-body p-9">
                <div class="row mb-8">
                    <div class="col-xl-3">
                        <div class="symbol symbol-100px">
                            @if ($data->getMedia('profile')->count())
                            <img src="{{$data->getFirstMediaUrl('profile')}}" >
                            @else
                            <img src="assets/media/svg/avatars/blank.svg" >
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">

                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">2الكود </label>
                    <div class="col-lg-8 fv-row">
                        <input readonly type="text" name="del_code" placeholder=" 2الكود" value="{{$data->del_code}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                    </div>
                </div>
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
                        <input readonly type="password" name="password" placeholder="كلمة المرور" value="{{$data->password}}" class="form-control form-control-lg form-control-solid" />
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
                            <option value="0" @if($data->role_code == '0') selected @endif disabled >متدرب</option>
                            <option value="1" @if($data->role_code == '1') selected @endif disabled >عامل</option>
                            <option value="2" @if($data->role_code == '2') selected @endif disabled >دليفري</option>
                            <option value="3" @if($data->role_code == '3') selected @endif disabled >موقوف</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label  fw-semibold fs-6"style=" max-width: 7% !important;">النوع</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select  class="form-select form-select-lg form-select-solid" value="{{$data->gender}}" id="gender" name="gender"  >
                            <option value="0"@if($data->gender == '0') selected @endif disabled >male</option>
                            <option value="1"@if($data->gender == '1') selected @endif disabled >female</option>
                        </select>
                    </div>
                    <label class="col-sm-1 col-form-label fw-semibold fs-6">collect</label>
                    <div class="col-sm-2 d-flex align-items-center" >
                        <select  class="form-select form-select-lg form-select-solid"  id="collect_m" value="{{$data->collect_m}}"  name="collect_m">
                            <option value="0"@if($data->collect_m == '0') selected @endif disabled >no</option>
                            <option value="1"@if($data->collect_m == '1') selected @endif disabled >yes</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label  fw-semibold fs-6">بنك </label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <select  class="form-select form-select-lg form-select-solid" value="{{$data->bank_code}}" id="bank_code" name="bank_code" >
                        @foreach ($banks as $asd)
                        <option value="{{ $asd->id }}" disabled>{{ $asd->name_ar }}</option>
                        @endforeach
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label  fw-semibold fs-6"style=" max-width: 7% !important;">الوظيفة </label>
                    <div class="col-sm-3 d-flex align-items-center" >
                        <select  class="form-select form-select-lg form-select-solid" value="{{$data->jobs_code}}" id="jobs_code" name="jobs_code" >
                        @foreach ($jobs as $asd)
                        <option value="{{ $asd->id }}" disabled>{{ $asd->name_en }}</option>
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
                        <option value="0"@if($data->type == '0') selected @endif disabled >dash</option>
                        <option value="1"@if($data->type == '1') selected @endif disabled >no dash</option>
                    </select>
                </div><br>
                <label class="col-sm-2 col-form-label required fw-semibold fs-6" style=" max-width: 7% !important;">is_active</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select  class="form-select form-select-lg form-select-solid" id="is_active"  name="is_active" value="{{$data->is_active}}" >
                        <option value="0"@if($data->is_active == '0') selected @endif disabled >not active</option>
                        <option value="1"@if($data->is_active == '1') selected @endif disabled >active</option>
                        <option value="2"@if($data->is_active == '2') selected @endif disabled >suspended</option>
                        <option value="3"@if($data->is_active == '3') selected @endif disabled >terminated</option>
                    </select>
                </div>
            </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label  fw-semibold fs-6">الراتب </label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <select  class="form-select form-select-lg form-select-solid" value="{{$data->salary_code}}" id="salary_code" name="salary_code" >
                         @foreach ($salaries as $asd)
                         <option value="{{ $asd->id }}" disabled>{{ $asd->value }}</option>
                         @endforeach
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label required  fw-semibold fs-6"> نوع الراتب</label>
                    <div class="col-sm-3 d-flex align-items-center"> <!--0 = cash, 1 = bank_transefer -->
                        <select  class="form-select form-select-lg form-select-solid"  name="method_for_payment" id="method_for_payment" value="{{$data->method_for_payment}}" >
                            <option value="0"@if($data->method_for_payment == '0') selected @endif disabled >كاش</option>
                            <option value="1"@if($data->method_for_payment == '1') selected @endif disabled >بنك</option>
                        </select>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection

@section('script')
@endsection
