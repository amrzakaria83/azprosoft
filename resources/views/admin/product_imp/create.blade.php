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
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('admin.employees.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <form action="{{ route('admin.product_imps.import') }}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">


                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">file</label>
                            <div class="col-lg-8 fv-row">
                                <input type="file" name="excel_file" placeholder="file" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->

                <div class="separator separator-content border-dark my-15">
                    
                            <span class="w-250px fw-bold text-info fs-2">فاصل</span>
                                
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-2">
                                <div class="fs-6 fw-semibold">تاريخ التحديث</div>
                            </div>
                            <div class="col-lg-9">

                            <div class="fw-bold fs-5">
                                {{ \App\Models\Product::latest('updated_at')->value('updated_at') }}
                            </div>
                            </div>
                        </div>
                        <a href="{{route('admin.product_imps.startSync')}}" class="btn  btn-primary me-3 p-3">
                                <i class="bi bi-plus-square fs-1x"></i>تحديث
                            </a>
            </div>
            <div class="separator separator-content border-dark my-15">
                    
                            <span class="w-250px fw-bold text-info fs-2">فاصل</span>
                                
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-2">
                                <div class="fs-6 fw-semibold">تاريخ التحديث</div>
                            </div>
                            <div class="col-lg-9">

                            <div class="fw-bold fs-5">
                                
                            </div>
                            </div>
                        </div>
                        <a href="{{route('admin.product_imps.newdb')}}" class="btn  btn-primary me-3 p-3">
                                <i class="bi bi-plus-square fs-1x"></i>تحديث
                            </a>
            </div>
            <!--end::Content--> 
        </div>
    </div>

@endsection

@section('script')

@endsection
