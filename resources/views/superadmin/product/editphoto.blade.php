@extends('superadmin.layout.master')

@section('css')
@endsection

@section('style')
<style>
.select2-container--bootstrap5 .select2-selection--single .select2-selection__placeholder{
    color: #4262f1 !important;
}
    </style>

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('superadmin.cashiers.index')}}" class="text-muted text-hover-primary">الخزائن</a>
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
                            <form action="{{route('superadmin.products.updatephoto')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                                @csrf
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                <!--begin::Card body-->
                                <div class="card-body border-top " >
                                    <div class="col-md-6">
                                        <br>
                                        <input type="text" readonly value="{{$data->id}}" name="id">
                                        <span class="fs-1 text_danger py-5" style="float: left">
                                        Name product : {{$data->product_name_en}}
                                    </span><br>
                                    </div>
                                <div class="row container py-10">
                                    <div class="col-lg-6 align-items-start">
                                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            @if ($data && $data->getMedia('img_prod')->count())
                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('img_prod','imgprodofferthumb')}})"></div>
                                            @else
                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                            @endif
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="img_prod" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                            </label>
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <div class="form-text">Product photo</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 align-items-start">
                                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            @if ($data && $data->getMedia('img_prod_offer')->count())
                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('img_prod_offer','imgprodofferthumb')}})"></div>
                                            @else
                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                            @endif
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="img_prod_offer" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                            </label>
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <div class="form-text">Offer photo</div>
                                        </div>
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
            <!--end::Content-->

@endsection

@section('script')
<script>

    </script>
@endsection
