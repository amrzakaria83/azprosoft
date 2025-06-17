@extends('superadmin.layout.master')

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
            <a href="{{route('superadmin.cashiers.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
        <div class="card-body border-top " >
            <input type="hidden" name="id" value="{{$data->id}}" />
            <div class="row mb-6">
                <label class="col-lg-2 col-form-label required fw-semibold fs-6 ">الاسم بالعربي</label>
                <div class="col-lg-8 fv-row">
                    <input type="text" readonly name="name_ar" placeholder="الاسم بالعربي" value="{{$data->name_ar}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-2 col-form-label  fw-semibold fs-6">الوصف</label>
                <div class="col-lg-8 fv-row">
                    <input type="text" readonly name="description" placeholder="الوصف " value="{{$data->description}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                </div>
            </div>
        </div>

            </div>
    </div>
</div>

@endsection

@section('script')
@endsection
