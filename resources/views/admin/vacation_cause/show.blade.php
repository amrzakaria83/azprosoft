@extends('admin.layout.master')

@section('css')
    
@endsection

@section('style')
    
@endsection

@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">البروفايل </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.vacation_causes.index')}}" class="text-muted text-hover-primary">طرق البيع</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">البروفايل</li>
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
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">الاسم</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="fw-bold fs-5">{{$data->name_ar}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">الاسم بالنجليزى</div>
                    </div>
                    <div class="col-xl-9 fv-row">
                        <div class="fw-bold fs-5">{{$data->name_en}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">الوصف</div>
                    </div>
                    <div class="col-xl-9 fv-row">
                        <div class="fw-bold fs-5">{{$data->description}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold"> ملاحظات</div>
                    </div>
                    <div class="col-xl-9 fv-row">
                        <div class="fw-bold fs-5">{{$data->note}}</div>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-xl-2">
                        <div class="fs-6 fw-semibold">تاريخ الانشاء</div>
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