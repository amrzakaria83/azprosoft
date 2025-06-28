@extends('admin.layout.master')

@php
    $route = 'admin.emp_att_overtimes';
    $viewPath = 'admin.emp_att_overtime';
@endphp

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
                {{trans('lang.dashboard')}}
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route($route. '.index')}}" class="text-muted text-hover-primary">{{trans('lang.role')}}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                
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
                <form action="{{route($route. '.storemanger')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" id="lat" name="lat" value="" />
                    <input type="hidden" id="lng" name="lng" value="" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                    <h1>{{trans('lang.director')}} {{Auth::guard('admin')->user()->name_ar}}</h1>
                    <div class="row mb-6">
                        <label class="required col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name')}} </label>
                        <div class="col-lg-8 fv-row">
                            <select class="input-text form-control  form-select  mb-3 mb-lg-0"  aria-label="Select example" name="emp_att_overtime" data-control="select2">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach (App\Models\Employee::where('is_active', 1)->get() as $asd)
                                        <option value="{{ $asd->id }}" >{{ $asd->name_ar }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                        @include($viewPath. '.form')

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{trans('lang.save')}}</button>
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
    $("#kt_roles_select_all").click(function () {
        var items = $("#kt_account_profile_details_form input:checkbox");
        for (var i = 0; i < items.length; i++) {
            if (items[i].checked == true) {
                items[i].checked = false;
            } else {
                items[i].checked = true;
            }
            
        }
    });
</script>

<script>
$("#kt_datepicker_3").flatpickr({
    defaultDate: new Date(new Date()),  // Set day to 1 and then increase by 2 years
    enableTime: true,
    allowInput: true,
    dateFormat: "Y-m-d h:i K",
    });
$("#kt_datepicker_4").flatpickr({
    defaultDate: new Date(new Date().getTime() + (60 * 60 * 1000)), // 1 hour from now
    enableTime: true,
    allowInput: true,
    dateFormat: "Y-m-d h:i K",
    });
</script>
@endsection