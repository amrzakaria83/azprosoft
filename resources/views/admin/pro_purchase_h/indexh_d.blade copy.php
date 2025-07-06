@extends('admin.layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
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
                <a  href="#" class="text-muted text-hover-primary">{{trans('lang.products')}}</a>
            </li>
            {{-- <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li> --}}

        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card no-border">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-db-table-filter="search" id="search" name="search" class="form-control form-control-solid bg-light-dark text-dark w-250px ps-14" placeholder="Search user" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end dbuttons">
                            <a href="{{route('admin.pro_purchase_hs.create')}}" class="btn btn-sm btn-icon btn-primary btn-active-dark me-3 p-3">
                                <i class="bi bi-plus-square fs-1x"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-primary btn-active-dark me-3 p-3" data-bs-toggle="modal" data-bs-target="#kt_modal_filter">
                                <i class="bi bi-funnel-fill fs-1x"></i></button>
                            <button type="button" class="btn btn-sm btn-icon btn-danger btn-active-dark me-3 p-3" id="btn_delete" data-token="{{ csrf_token() }}">
                                <i class="bi bi-trash3-fill fs-1x"></i></button>
                        </div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <div class="row mb-6">
                        <div class="col-sm-4">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.supplier')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select data-placeholder="Select an option" class="input-text form-control form-select mb-3 mb-lg-0 text-center" 
                                name="vendor_id" id="vendor_id" data-control="select2">
                                        <option disabled selected></option>
                                        @foreach (\App\Models\Pro_vendor::get() as $az)
                                            <option value="{{$az->vendor_id}}">{{$az->vendor_name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.stores')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select data-placeholder="Select an option" class="input-text form-control form-select mb-3 mb-lg-0 text-center" 
                                name="store_id" 
                                id="store_id"  data-control="select2">
                                <option value="">Select an option</option>
                                    @foreach (\App\Models\Pro_store::get() as $store)
                                        <option value="{{ $store->store_id }}" {{ $store->store_id == 7 ? 'selected' : '' }}>
                                            {{ $store->store_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.employee')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select data-placeholder="Select an option" class="input-text form-control form-select mb-3 mb-lg-0 text-center" 
                                name="emp_id" 
                                id="emp_id" data-allow-clear="true" data-control="select2">
                                    <option disabled selected></option>
                                    @foreach (\App\Models\Emangeremp::whereIn('emp_kind', [0,1])->get() as $az)
                                        <option value="{{$az->emp_id}}">{{$az->emp_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2"></label>
                            <div class="col-sm-12 fv-row">
                            </div>
                        </div>
                    </div>

                    <select id="kt_multiselectsplitter_example_4" multiple="multiple">
                        <optgroup label="Category 1">
                            <option value="1">Choice 1</option>
                            <option value="2">Choice 2</option>
                            <option value="3" selected="selected">Choice 3</option>
                            <option value="4">Choice 4</option>
                        </optgroup>
                        <optgroup label="Category 2">
                            <option value="5">Choice 5</option>
                            <option value="6">Choice 6</option>
                            <option value="7">Choice 7</option>
                            <option value="8">Choice 8</option>
                        </optgroup>
                        <optgroup label="Category 3">
                            <option value="9">Choice 9</option>
                            <option value="10">Choice 10</option>
                            <option value="11">Choice 11</option>
                            <option value="12">Choice 12</option>
                        </optgroup>
                    </select>
                    
                    
                </div>
                <!--end::Card body-->

                <div class="modal fade" id="kt_modal_filter" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_filter_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Filter</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->

                                    <!-- <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                                            <select name="is_active" id="is_active" data-control="select2" data-placeholder="اختـر ..." data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                <option></option>
                                                <option value="1">مفعل</option>
                                                <option value="0">غير مفعل</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="text-center pt-15">
                                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary" id="submit">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#kt_multiselectsplitter_example_4").multiselectsplitter({
            groupCounter: true,
            maximumSelected: 3,
            onlySameGroup: true
        });
    })
</script>

@endsection
