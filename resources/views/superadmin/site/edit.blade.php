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
                <a  href="{{route('superadmin.sites.index')}}" class="text-muted text-hover-primary">الشركات</a>
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
                <form action="{{route('superadmin.sites.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">كود الموقع</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="site_code" placeholder="كود الموقع" value="{{$data->site_code}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الموقع</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="name" placeholder="اسم الموقع" value="{{$data->name}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">طبيعة الموقع</label>
                            <div class="col-lg-8 fv-row">
                                    <select class="form-select" autofocus required aria-label="Select example" id="site" name="type" value="{{$data->type}}" >
                                        <option value="0" @if($data->type == '0') selected @endif>صيدلية</option>
                                        <option value="1"@if($data->type == '1') selected @endif>مخزن</option>
                                        <option value="2"@if($data->type == '2') selected @endif>نقطة تحرك</option>
                                        <option value="3"@if($data->type == '3') selected @endif>موقع معرف</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">رقم الهاتف</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="tel" name="phone1" placeholder="رقم الهاتف" value="{{$data->phone1}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">رقم الهاتف</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="tel" name="phone2" placeholder="رقم الهاتف" value="{{$data->phone2}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">رقم الهاتف</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="tel" name="phone3" placeholder="رقم الهاتف" value="{{$data->phone3}}" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">ملاحظات</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="note" placeholder="ملاحظات" value="{{$data->note}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">العنوان</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="address" placeholder="العنوان" value="{{$data->address}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6"> is_active</label>
                            <div class="col-lg-8 d-flex align-items-center">
                                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                    <input class="form-check-input w-45px h-30px" type="checkbox" name="active" value="1" id="allowmarketing" checked="checked" />
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">map_location</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="map_location" placeholder="map_location" value="{{$data->map_location}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
