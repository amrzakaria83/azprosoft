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
                <form action="{{route('superadmin.delivery_customers.updatecutomer_del_all_data')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">

                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الكود </label>
                            <div class="col-lg-8 fv-row">
                                <input type="number" name="emp_code" placeholder="الكود " value="{{$data->emp_code}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الاسم</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="cutomer_del_name_ar" placeholder="الاسم" value="{{$data->cutomer_del_name_ar}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">رقم الهاتف</span>
                            </label>
                            <div class="col-sm-3 fv-row ">
                                <input type="tel" name="phone1" placeholder="رقم الهاتف" id="phone1" value="{{$data->phone1}}" required class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-sm-3 fv-row">
                                <input type="tel" name="phone2" placeholder="رقم بديل"  id="phone2" value="{{$data->phone2}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-lg-2 col-form-label  fw-semibold fs-6">العنوان</label>
                            <div class="col-sm-3 fv-row">
                                <input type="text" name="address" placeholder="العنوان" id="address" value="{{$data->address}}" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">ملاحظات</label>
                            <div class="col-sm-3 fv-row">
                                <input type="text" name="note" placeholder="ملاحظات" id="note" value="{{$data->note}}" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2  required col-form-label fw-semibold fs-6">المنطقة </label>
                            <div class="col-sm-4 d-flex align-items-center">
                                <select  class="form-select form-select-lg form-select-solid" value="{{$data->area_id}}"  id="area_id" name="area_id" >
                                    <option value="">اختر المنطقة</option>
                                    @foreach ($areas as $asd)
                                <option value="{{ $asd->id }}"@if($asd->id == $data->area_id) selected @endif>{{ $asd->name_ar }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                                <label class="col-sm-1 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">collect</label>
                                <div class="col-sm-2 d-flex align-items-center" >
                                    <select  class="form-select form-select-lg form-select-solid" value="{{$data->status}}" id="status"  name="status">
                                        <option value="0"@if($data->status == '0') selected @endif>مفعل</option>
                                        <option value="1"@if($data->status == '1') selected @endif>مقفول</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-lg-2 col-form-label  fw-semibold fs-6">map_location</label>
                            <div class="col-sm-3 fv-row">
                                <input type="text" name="map_location" placeholder="map_location" id="map_location" value="{{$data->map_location}}" class="form-control form-control-lg form-control-solid mb-3 mb-sm-0" />
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

@endsection
