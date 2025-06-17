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
                <a  href="{{route('superadmin.shippings.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <form action="{{route('superadmin.shippings.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم العميل</label>
                            <div class="col-lg-4 fv-row">
                                <input type="text" id="cust_name" name="cust_name" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                            </div>
                                <label class="col-lg-2 col-form-label fw-semibold fs-6" style=" max-width: 10% !important;">
                                    <span class="required"> تليفون العميل 1</span>
                                </label>
                                <div class="col-lg-4 fv-row">
                                    <input type="tel" id="cust_phone1" required name="cust_phone1" placeholder="رقم تليفون العميل 1" value="" class="form-control form-control-lg form-control-solid" />
                                </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">رقم تليفون ثابت</span>
                            </label>
                            <div class="col-lg-3 fv-row">
                                <input type="tel" id="cust_phone2"  name="cust_phone2" placeholder="رقم تليفون ثابت" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <label class="col-lg-2 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">
                                <span class="">ملاحظات</span>
                            </label>
                            <div class="col-lg-5 fv-row">
                                <input type="textarea" id="note"  name="note" placeholder="ملاحظات" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label for="governorate" class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">المحافظة</span>
                            </label>
                            <div class="col-lg-2 fv-row">
                            <select class="form-select" autofocus required  id="governorate" name="governorate" >
                                <option value="">المحافظة</option>
                                @foreach ($Governorate as $asd)
                                            <option value="{{ $asd->id }}">{{ $asd->governorate_name_ar }}</option>
                                            @endforeach
                            </select>
                        </div>
                            <label for="citiesSelect" class="col-lg-2 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">
                                <span class="required">المدينة</span>
                            </label>
                            <div class="col-lg-2 fv-row">
                            <select class="form-select" autofocus  id="citiesSelect" name="citiesSelect" ></select>
                        </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">العنوان1</span>
                            </label>
                            <div class="col-lg-5 fv-row">
                                <input type="text" id="address1"  name="address1" placeholder="العنوان1" value="" required class="form-control form-control-lg form-control-solid" />
                            </div>
                            <label class="col-sm-2 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">
                                <span class="">العنوان2</span>
                            </label>
                            <div class="col-lg-3 fv-row">
                                <input type="text" id="address2"  name="address2" placeholder="العنوان2" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label for="online_request_method" class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="required">الطلب الاليكترونى عن طريق</span>
                            </label>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select" autofocus required  id="online_request_method" name="online_request_method" >
                                    <option value="">الطلب عن طريق</option>
                                    <option value="0">Facebook Amr page</option>
                                    <option value="1">Facebook Other page</option>
                                    <option value="2">Web address</option>
                                    <option value="3">Whatsapp</option>
                                </select>
                            </div>
                            <label for="payment_method" class="col-lg-2 col-form-label fw-semibold fs-6" style=" max-width: 7% !important;">
                                <span class="required">طريقة الدفع</span>
                            </label>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select" autofocus required  id="payment_method" name="payment_method" >
                                    <option class="form-control-lg" value="">طريقة الدفع</option>
                                    <option class="form-control-lg" value="0">Vodafonecash</option>
                                    <option class="form-control-lg" value="1">Banktrans</option>
                                    <option class="form-control-lg" value="2">Ondelevery</option>
                                    <option class="form-control-lg" value="3">Fawery</option>
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <div class="col-lg-4 fv-row">
                                    <input type="number" id="value_payment"  name="value_payment" placeholder="المدفوع" value="" class="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6" style="display: none">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">رقم الريسيت</span>
                            </label>
                            <div class="col-lg-2 fv-row">
                                <input type="text" id="no_recepient"  name="no_recepient" placeholder="رقم الريسيت" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-lg-2 fv-row">
                                <select class="form-select"   id="shipping_co" name="shipping_co" >
                                    <option value="">شركة الشحن</option>
                                    @foreach ($Shipping_company as $asd)
                                                <option value="{{ $asd->id }}">{{ $asd->name_ar }}</option>
                                                @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 fv-row">
                                <input type="number" id="value_shipping"  name="value_shipping" placeholder="قيمة الشحن" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">

                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">location-map</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="map_location"  name="map_location" placeholder="" value="" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                <span class="">link-Customer Page</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="link_cust_page"  name="link_cust_page" placeholder="" value="" class="form-control form-control-lg form-control-solid" />
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
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
<script>
$('#governorate').change(function() {
    var governorateId = $(this).val();

    $.ajax({url: "{{route('superadmin.shippings.getCitiesByGovernorate')}}",type: 'GET',data: { governorate_id: governorateId },success: function(response) {var citiesSelect = $('#citiesSelect');citiesSelect.empty();$.each(response, function(key, city) {citiesSelect.append('<option value="' + city.id + '">' + city.city_name_ar + '</option>');});}});});
</script>
@endsection
