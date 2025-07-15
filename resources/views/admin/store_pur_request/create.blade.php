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
                <a  href="{{route('admin.store_pur_requests.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                        <form action="{{route('admin.store_pur_requests.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                        @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top " >

                                    <div class="row mb-6">
                                        <div class="col-lg-4 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2 required">{{trans('lang.store')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <select  data-placeholder="Select an option" class=" input-text form-control form-select  mb-3 mb-lg-0 text-center" required name="pro_start_id" id="pro_start_id" data-allow-clear="false" data-control="select2" >
                                                    <option  disabled selected></option>
                                                        @foreach (\App\Models\Pro_store::active()->get() as $az)
                                                            <option value="{{$az->store_id}}">{{$az->store_name}}</option>
                                                            @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2 required">{{trans('lang.product')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <select class=" pro_prod_id form-control" required id="pro_prod_id" name="pro_prod_id"  ></select>
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-2 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.quantity')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <input type="text" id="quantity" name="quantity" placeholder="{{trans('lang.quantity')}}" value="1" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <div class="col-lg-4 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2 required">{{trans('lang.name_ar')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <input type="text" id="name_cust" name="name_cust" placeholder="{{trans('lang.name_ar')}}" required value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2 required">{{trans('lang.phone')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <input type="text" id="phone_cust" name="phone_cust" placeholder="{{trans('lang.phone')}}" required value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                            </div>
                                        </div>
                                        <div class="col-lg-2 fv-row">
                                            <label class="col-sm-8 fw-semibold fs-6 mb-2 required">{{trans('lang.type_type')}} {{trans('lang.request')}}</label>
                                            <div class="col-sm-12 fv-row">
                                                <select class="form-select text-center text-danger fs-3" autofocus required aria-label="Select example" id="type_request" name="type_request" >
                                                    <option value="">اختر طبيعة الطلب</option>
                                                    <option value="0">cash</option>
                                                    <option value="1">phone</option>
                                                    <option value="2">whatsapp</option>
                                                    <option value="3">facebook</option>
                                                    <option value="4">instagram</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.note')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="note" name="note" placeholder="{{trans('lang.note')}}" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
            
@endsection

@section('script')

<script>

    $('.pro_prod_id').select2({
        placeholder: 'Select an item',
        minimumInputLength: 3,
        ajax: {
            type: "GET",
            url: '{{ url('admin/store_pur_requests/ProdName')}}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.product_name_en,
                        id: item.product_id,
                    }
                })
                }},
                    cache: true
                }});

</script>
@endsection
