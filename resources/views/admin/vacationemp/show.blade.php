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
                {{trans('lang.dashboard')}}
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('admin.vacationemps.index')}}" class="text-muted text-hover-primary">{{trans('lang.administrators')}}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                {{trans('employee.profile')}}   
            </li>
        </ul>
    </div>
    <!--end::Page title-->
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
                            <img src="{{asset('dash/assets/media/svg/avatars/blank.svg')}}" >
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">
                        
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.name')}} </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->name}}</div>
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.email')}} </div>
                    </div>
                    <div class="col-xl-9 fv-row">
                        <div class="fw-bold fs-5">{{$data->email}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.phone')}} </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->phone}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.account_type')}} </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">
                            @if($data->type == 'dash')
                                <div class="badge badge-light-info fw-bold">{{trans('employee.administrator')}}</div>
                            @else
                            <div class="badge badge-light-primary fw-bold">{{trans('employee.teacher')}} </div>
                            @endif    
                        </div>
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('lang.attach')}} </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">
                            @if ($data->getMedia('attach')->count())
                            <a href="{{$data->getFirstMediaUrl('attach')}}" target="_blank" > {{trans('lang.attach')}} </a>
                            @else
                            ----
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.is_active')}}</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">
                            @if($data->is_active == 1)
                                <div class="badge badge-light-success fw-bold">{{trans('employee.active')}}</div>
                            @else
                            <div class="badge badge-light-danger fw-bold">{{trans('employee.notactive')}} </div>
                            @endif    
                        </div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">{{trans('employee.created_at')}}</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->created_at}}</div>
                    </div>
                </div>

            </div>

    </div>
</div>

@endsection

@section('script')
@endsection