@extends('user.layout.master')
@php
    $route = 'user.messages';
    $viewPath = 'user.message';
@endphp
@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">الرسائل </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{route('user.all_supervisors.index')}}" class="text-muted text-hover-primary">الرسائل</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">عرض</li>
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
                        <div class="w-100">
                            @if ($data->getMedia('messages')->count())
                            <img src="{{$data->getFirstMediaUrl('messages')}}" class="w-100">
                                <a class="m-5 btn btn-success" href="{{$data->getFirstMediaUrl('messages')}}" download>تحميل الصورة</a>
                            @else
                            <img src="{{asset('assets/media/svg/avatars/blank.svg')}}" class="w-100">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">

                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">الاسم</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->name}}</div>
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">البريد الالكتروني</div>
                    </div>
                    <div class="col-xl-9 fv-row">
                        <div class="fw-bold fs-5">{{$data->email}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">رقم الهاتف</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->phone}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">محتوى الرسالة</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{!! $data->description !!}</div>
                    </div>
                </div>

            </div>

    </div>
</div>

@endsection

@section('script')
@endsection
