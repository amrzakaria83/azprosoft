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
                                    <input type="hidden" name="id" value="{{$data->id}}" />
                                    
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">{{trans('lang.name_ar')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_ar" name="name_ar" placeholder="{{trans('lang.name_ar')}}" value="{{$data->emp_name}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name_en')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="name_en" name="name_en" placeholder="{{trans('lang.name_en')}}" value="{{$data->emp_name_en}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">
                                        {{trans('lang.phone')}}
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="phone" placeholder="{{trans('lang.phone')}}" id="phone" value="{{$data->emp_tell}}" class="form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">{{trans('lang.email')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" required id="emailaz" name="emailaz" placeholder="{{trans('lang.email')}}" value="null" class="bg bg-danger text-dark form-control form-control-lg form-control-solid text-center" />
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6 required">
                                        {{trans('lang.password')}}
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="لا يقل عن 6 حروف"></i>
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="password" name="password" placeholder="{{trans('lang.password')}}" value="null" class="bg bg-danger text-dark form-control form-control-lg form-control-solid text-center" />
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
                                                <option value="1">{{trans('lang.active')}}</option>
                                                <option value="0">{{trans('lang.inactive')}}</option>
                                                <option value="2">{{trans('lang.suspended')}}</option>
                                                <option value="3">{{trans('lang.terminated')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-3 text-info">{{trans('lang.name_ar')}} </label>
                                        <div class="col-lg-8 fv-row">
                                            <select  data-control="select2" data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0" id="emangeremp_id" name="emangeremp_id">
                                            <option value="">Select {{trans('lang.name_ar')}}</option>
                                                @foreach (App\Models\Emangeremp::get() as $item)
                                                    <option value="{{$item->emp_id}}" @if(isset($data) && $data->emp_id == $item->emp_id) selected @endif>{{$item->emp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-3 text-info">{{trans('lang.role_id')}} </label>
                                        <div class="col-lg-8 fv-row">
                                            <select  data-control="select2" data-placeholder="Select an option" required class=" input-text form-control  form-select  mb-3 mb-lg-0"  name="role_id">
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
            
@endsection

@section('script')

@endsection
