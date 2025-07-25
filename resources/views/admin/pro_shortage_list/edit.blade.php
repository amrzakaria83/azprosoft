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
                <a  href="{{route('admin.pro_shortage_lists.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <form action="{{route('admin.pro_shortage_lists.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">{{trans('lang.emp_id')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" required id="emp_code" name="emp_code" placeholder="{{trans('lang.emp_id')}}" value="{{$data->emp_code}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">{{trans('lang.name_ar')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_ar" name="name_ar" placeholder="{{trans('lang.name_ar')}}" value="{{$data->name_ar}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name_en')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_en" name="name_en" placeholder="{{trans('lang.name_en')}}" value="{{$data->name_en}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">
                                        {{trans('lang.phone')}}
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="phone" placeholder="{{trans('lang.phone')}}" id="phone" value="{{$data->phone}}" class="form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">{{trans('lang.email')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" required id="emailaz" name="emailaz" placeholder="{{trans('lang.email')}}" value="{{$data->email}}" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6 required">
                                        {{trans('lang.password')}}
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="لا يقل عن 6 حروف"></i>
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="password" name="password" placeholder="{{trans('lang.password')}}" value="{{$data->password}}" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" >type</label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" id="type" name="type" value="" >
                                                <option value="0" @if(isset($data) && $data->type == "0") selected @endif>Dash</option>   <!-- admin -->
                                                <option value="1" @if(isset($data) && $data->type == "1") selected @endif>No dash</option> <!-- No dash -->
                                                <option value="2" @if(isset($data) && $data->type == "2") selected @endif>subadmin</option>  <!-- subadmin -->
                                                <option value="3" @if(isset($data) && $data->type == "3") selected @endif>superadmin</option> <!-- superadmin -->
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" style=" max-width: 7% !important;">is_active</label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid text-center" id="is_active"  name="is_active" value="" >
                                                <option value="0" @if(isset($data) && $data->is_active == "0") selected @endif>not active</option>
                                                <option value="1" @if(isset($data) && $data->is_active == "1") selected @endif>active</option>
                                                <option value="2" @if(isset($data) && $data->is_active == "2") selected @endif>suspended</option>
                                                <option value="3" @if(isset($data) && $data->is_active == "3") selected @endif>terminated</option>
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
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.note')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="note" name="note" placeholder="{{trans('lang.note')}}" value="{{$data->note}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
