@extends('admin.layout.master')

@section('css')
@endsection

@section('style')
    
@endsection

@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">الاعدادات</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <li class="breadcrumb-item text-muted">اعدادات النظام</li>
    </ul>
    <!--end::Breadcrumb-->
</div>
@endsection

@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form action="{{route('admin.settings.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">

                        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-dark text-active-primary pb-5 active" data-bs-toggle="tab" href="#setting">
                                    <i class="las la-cog text-primary fs-3"></i>
                                    الاعدادات العامة
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark text-active-primary pb-5" data-bs-toggle="tab" href="#media">
                                    <i class="las la-image text-primary fs-3"></i>
                                    ميديا
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark text-active-primary pb-5" data-bs-toggle="tab" href="#social">
                                    <i class="las la-hashtag text-primary fs-3"></i>
                                    سوشيال ميديا
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark text-active-primary pb-5" data-bs-toggle="tab" href="#description">
                                    <i class="las la-comment text-primary fs-3"></i>
                                    الوصــف
                                </a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="setting" role="tabpanel">
                                <!--begin::Form-->
                                <form action="{{route('admin.settings.update')}}" method="POST" class="form" >
                                    @csrf
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>اسم الموقع</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="name_ar" value="{{$data->name_ar}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>اسم الموقع انجليزي</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="name_en" value="{{$data->name_en}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>البريد الالكتروني</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="email" name="email" value="{{$data->email}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>البريد الالكتروني 2</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="email" name="email2" value="{{$data->email2}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>رقم الهاتف</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="tel" name="phone" value="{{$data->phone}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>رقم الهاتف 2</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="tel" name="phone2" value="{{$data->phone2}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>واتس اب</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="tel" name="whatsapp" value="{{$data->whatsapp}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>العنوان</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="address" value="{{$data->address}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>العنوان 2</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="address2" value="{{$data->address2}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>الموقع على الخريطة</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="location" value="{{$data->location}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row py-5">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Action buttons-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <div class="tab-pane fade" id="media" role="tabpanel">
                                <!--begin::Form-->
                                <form action="{{route('admin.settings.update')}}" method="POST" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>اللوجو</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                @if ($data->getMedia('logo')->count())
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('logo')}})"></div>
                                                @else
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                                @endif
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                </label>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                            </div>
            
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>  اللوجو غامق</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                @if ($data->getMedia('logoDark')->count())
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('logoDark')}})"></div>
                                                @else
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                                @endif
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <input type="file" name="logodark" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                </label>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                            </div>
            
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>favicon</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                @if ($data->getMedia('fav')->count())
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('fav')}})"></div>
                                                @else
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                                @endif
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <input type="file" name="fav" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                </label>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                            </div>
            
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>breadcrumb</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                @if ($data->getMedia('breadcrumb')->count())
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$data->getFirstMediaUrl('breadcrumb')}})"></div>
                                                @else
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                                @endif
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <input type="file" name="breadcrumb" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                </label>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                            </div>
            
                                        </div>
                                    </div>

                                    <div class="row py-5">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                 </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <div class="tab-pane fade" id="social" role="tabpanel">
                                <!--begin::Form-->
                                <form action="{{route('admin.settings.update')}}" method="POST" class="form">
                                    @csrf
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Facebook</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="facebook" value="{{$data->facebook}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Twitter</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="twitter" value="{{$data->twitter}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Youtube</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="youtube" value="{{$data->youtube}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Linkedin</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="linkedin" value="{{$data->linkedin}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Instagram</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="instagram" value="{{$data->instagram}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Snapchat</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="snapchat" value="{{$data->snapchat}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row py-5">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                 </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <div class="tab-pane fade" id="description" role="tabpanel">
                                <!--begin::Form-->
                                <form action="{{route('admin.settings.update')}}" method="POST" class="form">
                                    @csrf

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>keywords ar</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="keywords_ar" value="{{$data->keywords_ar}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>description ar</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="description_ar" class="form-control form-control-solid">{{$data->description_ar}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>keywords en</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="keywords_en" value="{{$data->keywords_en}}" class="form-control form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row fv-row mb-7">
                                        <div class="col-md-3 text-md-end">
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>description en</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="description_en" class="form-control form-control-solid">{{$data->description_en}}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row py-5">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <!--end::Form-->
                            </div>
                        </div>

                    </div>

                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
@endsection