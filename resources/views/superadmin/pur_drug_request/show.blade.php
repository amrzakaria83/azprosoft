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
            <a href="{{route('superadmin.sites.index')}}" class="text-muted text-hover-primary">الشركات</a>
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

                    <div class="col-lg-8">

                    </div>
                </div>


                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم الموقع</label>
                    <div class="col-lg-8 fv-row">
                    <span class="spantext">{{$data->name}}</span>
                    </div>
                </div>

                <div class="row mb-6">
                            <select class="form-select" autofocus required aria-label="Select example" id="site" name="type" value="{{$data->type}}" >
                                {{-- <option disabled selected >طبيع الموقع</option> --}}
                                <option value="0" @if($data->type == '0') selected @endif disabled>صيدلية</option>
                                <option value="1"@if($data->type == '1') selected @endif disabled>مخزن</option>
                                <option value="2"@if($data->type == '2') selected @endif disabled>نقطة تحرك</option>
                                <option value="3"@if($data->type == '3') selected @endif disabled>موقع معرف</option>
                            </select>
                   </div>

                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label fw-semibold fs-6">
                        <span class="required">رقم الهاتف</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->phone1}}</span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label fw-semibold fs-6">
                        <span class="">رقم الهاتف</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->phone2}}</span>                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label fw-semibold fs-6">
                        <span class="">رقم الهاتف</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->phone3}}</span>                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">ملاحظات</label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->note}}</span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">العنوان</label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->address}}</span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label fw-semibold fs-6"> is_active</label>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <span class="spantext">{{ $data->active == '1' ? 'active' : 'notactive' }}</span>
                            {{-- <input class="form-check-input w-45px h-30px" type="checkbox" name="active" value="1" id="allowmarketing" checked="checked" /> --}}
                            <label class="form-check-label" for="allowmarketing"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">map_location</label>
                    <div class="col-lg-8 fv-row">
                        <span class="spantext">{{$data->map_location}}</span>
                    </div>
                </div>

            </div>

    </div>
</div>

@endsection

@section('script')
@endsection
