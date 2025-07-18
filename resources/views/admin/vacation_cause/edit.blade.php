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
                <a  href="{{route('admin.vacation_causes.index')}}" class="text-muted text-hover-primary">{{trans('lang.all')}} {{trans('lang.vacation')}} {{trans('lang.type_type')}}</a>
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
                <form action="{{route('admin.vacation_causes.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">الاسم</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="name_ar" placeholder="الاسم" value="{{$data->name_ar}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label  fw-semibold fs-6">الاسم بالانجليزي</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="name_en" placeholder="الاسم بالانجليزي " value="{{$data->name_en}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">ملاحظات</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="note" name="note" placeholder="ملاحظات" value="{{$data->note}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">الوصف</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="description" name="description" placeholder="الوصف" value="{{$data->description}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">الحالة</span>
                            </label>
                            <div class="col-sm-3 d-flex align-items-center text-center">
                                <select class="form-select text-center" autofocus required value="{{$data->status}}" aria-label="Select example" id="status" name="status" >
                                    <option value="0" @if($data->status == '0') selected @endif >مفعل</option>
                                    <option value="1" @if($data->status == '1') selected @endif >غير مفعل</option>
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
@endsection