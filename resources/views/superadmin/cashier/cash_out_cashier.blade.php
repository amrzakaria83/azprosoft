@extends('superadmin.layout.master')

@section('css')
@endsection

@section('style')

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
                            <form action="{{route('superadmin.cashiers.cash_out_cashier')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                                @csrf
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                <!--begin::Card body-->
                                <div class="card-body border-top " >
                                    <div class="row mb-6">

                                            <label class="col-sm-2 col-form-label required fw-semibold fs-6" style="">خزينة الصرف </label>
                                            <div class="col-sm-2 d-flex align-items-center">
                                                <select  class="form-select form-select-lg form-select-solid" value="" id="cashier_from" required name="cashier_from"  >
                                                    <option value="">خزينة الصرف</option>
                                                    @foreach ($cashier as $asd)
                                                <option value="{{ $asd->id }}" @if($asd->id == session()->get('cashier')) selected @endif>{{ $asd->name_ar }}</option>
                                                @endforeach
                                                </select>
                                            </div>

                                        <label class="col-sm-2 col-form-label required fw-semibold fs-6" style="">خزينة التوريد </label>
                                        <div class="col-sm-2 d-flex align-items-center">
                                            <select  class="form-select form-select-lg form-select-solid" value="" id="cashier_to" required name="cashier_to"  >
                                                <option value="">خزينة التوريد</option>
                                                @foreach ($cashier as $asd)
                                            <option value="{{ $asd->id }}" >{{ $asd->name_ar }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 1%">
                                        <div class="col-lg-8 fv-row">
                                            <input type="number" name="value" placeholder="القيمة" value="" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 1%">
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="note" placeholder="ملاحظات" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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

@endsection
