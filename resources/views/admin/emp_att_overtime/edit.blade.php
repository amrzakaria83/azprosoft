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
                <form action="{{route($route. '.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <input type="hidden" id="lat" name="lat" value="{{$data->lat}}" />
                    <input type="hidden" id="lng" name="lng" value="{{$data->lng}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                    <h1>{{trans('lang.editview')}} {{trans('lang.att_overtime')}}</h1>
                        @include($viewPath. '.form')
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">{{trans('lang.director')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center"  autofocus required aria-label="Select example" id="statusmangeraprove" name="statusmangeraprove" >
                                        <option value="0" @if($data->statusmangeraprove == '0') selected  @endif >{{trans('lang.waiting')}}-{{trans('lang.approved')}}</option>
                                        <option value="1" @if($data->statusmangeraprove == '1') selected  @endif >{{trans('lang.approved')}}</option>
                                        <option value="2" @if($data->statusmangeraprove == '2') selected  @endif >{{trans('lang.reject')}}</option>
                                        <option value="3" @if($data->statusmangeraprove == '3') selected  @endif >{{trans('lang.delay')}}</option>
                                    </select>
                                </div>
                        </div>
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
            defaultDate: "{{$data->attendance_in_over_from}}",
            minDate:"{{$data->attendance_in_over_from}}",
            enableTime: true,
            allowInput: true,
            dateFormat: "Y-m-d h:i K",
            });
        $("#kt_datepicker_4").flatpickr({
            defaultDate: "{{$data->attendance_out_over_to}}",
            maxDate: new Date(new Date("{{$data->attendance_out_over_to}}").getTime() + (5 * 60 * 60 * 1000)),
            // maxDate:"{{$data->attendance_out_over_to}}", 
            enableTime: true,
            allowInput: true,
            dateFormat: "Y-m-d h:i K",
            });

</script>

@endsection