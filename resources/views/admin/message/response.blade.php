@extends('admin.layout.master')

@php
    $route = 'admin.messages';
    $viewPath = 'admin.message';
@endphp


@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/admin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                الرئيسية
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route($route. '.index')}}" class="text-muted text-hover-primary">الرسائل</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
               الرد على الرسالة
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-3 my-1">الرسالة:</h2>
                        <div class="separator my-6"></div>
                        <div data-kt-inbox-message="message_wrapper">
                            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
        
                                <div class="d-flex align-items-center">
                                    <div class="pe-5">
                                        <div class="d-flex align-items-center flex-wrap gap-1">
                                            <a href="javascript:;" class="fw-bold text-dark text-hover-primary">{{$data->name}}</a>
                                        </div>
        
                                        <div data-kt-inbox-message="details">
                                            <span class="text-muted fw-semibold">{{$data->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                            <div class="collapse fade show" data-kt-inbox-message="message">
                                <div class="fw-bold fs-5 py-5">
                                    {{ $data->description }}
                                </div>
        
                                @if ($data->getMedia('messages')->count())
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <span class="fw-bold text-start me-3">
                                        <a href="{{$data->getFirstMediaUrl('messages')}}" target="_blank"> شاهد المرفقات </a>
                                        </span>
                                        <span class="fw-bold text-start me-3">
                                            <a href="{{$data->getFirstMediaUrl('messages')}}" download> تحميل المرفق </a>
                                        </span>
                                    </div>
                                @endif
        
                            </div>
                        </div>
        
                        <div class="separator my-6"></div>
                        <h2 class="fw-bold mb-3 my-1"> الردود على الرسالة:</h2>
                        
                        @if(!empty($data->responses))
                        @foreach($data->responses as $response)
                        @php
                            if ($response->sender_type == 'supervisor') {
                                $supervisor = \App\Models\Employee::find($response->sender_id);
                                $name = $supervisor->name_ar;
                            } else {
                                $username = \App\Models\Employee::find($response->sender_id);
                                $name = $username->name_ar;
                            }
                        @endphp
                            <div class="separator my-6"></div>
        
                            <div data-kt-inbox-message="message_wrapper">
                                <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
        
                                    <div class="d-flex align-items-center">
                                        <div class="pe-5">
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <a href="javascript:;" class="fw-bold text-dark text-hover-primary">{{$name}}</a>
                                            </div>
        
                                            <div data-kt-inbox-message="details">
                                                <span class="text-muted fw-semibold">{{$response->created_at}}</span>
                                            </div>
        
                                        </div>
                                    </div>
        
                                </div>
        
                                <div class="collapse fade show" data-kt-inbox-message="message">
                                    <div class="fw-bold fs-5 py-5">
                                        {!! $response->response !!}
                                    </div>
        
                                    @if ($response->getMedia('messages')->count())
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-start me-3">
                                            <a href="{{$response->getFirstMediaUrl('messages')}}" target="_blank"> شاهد المرفقات </a>
                                            </span>
                                            <span class="fw-bold text-start me-3">
                                                <a href="{{$response->getFirstMediaUrl('messages')}}" download> تحميل المرفق </a>
                                            </span>
                                        </div>
                                    @endif
                                </div>
        
                            </div>
                        @endforeach
                        @endif
        
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-3 my-1">ارسال رد:</h2>
                        <div class="separator my-6"></div>
                        <!--begin::Form-->
                        <form action="{{route($route. '.send_response', $data->id)}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                            @csrf
        
                            <!--begin::Card body-->
                            @include($viewPath. '.responseForm')
        
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
        
                    </div>
                </div>

            </div>
        </div>

        
    </div>


@endsection

@section('script')
@endsection
