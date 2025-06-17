@extends('superadmin.delevery_layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('style')
<style>
    .p-3 {
        padding: 0px!important;
        padding-left: 10px!important;
        padding-right: 0px!important;
    }
    .card-body {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .card {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .btn-group {
        display:none!important;
    }
    .table > :not(caption) > * > * {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .th {
        max-width: 10px!important;
    }
    .select2-search--dropdown{
    background-color: #000 !important;
    }
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
                عودة الى الرئيسية </h1></a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">طلب التوصيل</a>
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card no-border">
                <div class="row">
                    <div class="col-sm-6 p-3">
                        <ul class="fw-bold fs-7 my-1">
                            <li class="text-muted px-2">
                                <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">-عودة طلب التوصيل</a>
                            </li>
                        </ul>
                        <div class="col-sm-6 p-3">
                            <select class=" delivery_customer_name_order form-control" value="" id="delivery_customer_name_order" name="delivery_customer_name_order" aria-placeholder="اسم العميل" style="background-color: rgb(0, 86, 156)" ></select>
                        </div>
                    </div>
                    <div class="col-sm-6 p-3">
                            @if(isset($datacust))
                                <span class="fs-1 ">اسم العميل : {{$datacust->cutomer_del_name_ar}}</span>
                                <span class="fs-1 text-danger">- الرصيد الحالى : {{$datacust->customer_balance}}</span>
                            @else
                                <span style="visibility: hidden">No data</span>
                            @endif
                    </div>
                </div>
                <div class="card-body py-4">
                        <div class="row">
                            <div class="col-sm-6 p-3">
                                @if(isset($datadebtor))
                                                <h3>مدين</h3>
                                                        <!--begin::Card body-->

                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_out">
                                                                <!--begin::Table head-->
                                                                <thead class="bg-light-dark pe-3">
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                        <th class="w-10px p-3">
                                                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1"  />
                                                                            </div>
                                                                        </th>
                                                                        <th class="max-w-20px text-center">اسم العملية</th>
                                                                        <th class="max-w-20px text-center">القيمة</th>
                                                                        <th class="max-w-20px text-center">التاريخ</th>
                                                                        <th class="max-w-20px text-center">رقم العملية</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="text-gray-600 fw-bold text-center">
                                                                    @foreach ($datadebtor as $debtor)
                                                                        <tr>
                                                                            <th scope="row"></th>
                                                                            <td>@if ($debtor->name_model === 'Delivery_order_request') {{ 'اوردر توصيل' }} @else {{ 'اوردر تثبيت' }} @endif</td>
                                                                            <td>{{ $debtor->value }}</td>
                                                                            <td>{{ $debtor->created_at }}</td>
                                                                            <td>{{ $debtor->id_model }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <th scope="row"></th>
                                                                        <td colspan="4">مجموع: {{ $totalValuedebtor }}</td>  <td colspan="2"></td>
                                                                    </tr>
                                                                </tbody>

                                                                <!--end::Table body-->
                                                            </table>

                                                            <button class="btn btn-success fw-bold fs-2 " id="supply_cus">
                                                                    توريد عميل
                                                            </button>
                                                            <!--end::Table-->
                                                        <!--end::Card body-->
                                            @else
                                            <span style="visibility: hidden">No data</span>
                                            @endif
                            </div>
                            <div class="col-sm-4 p-3">
                                @if(isset($datacreaditor))

                                                <h3>دائن</h3>
                                                        <!--begin::Card body-->
                                                        <div class="card-body py-4">
                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_out">
                                                                <!--begin::Table head-->
                                                                <thead class="bg-light-dark pe-3">
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                        <th class="w-10px p-3">
                                                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1"  />
                                                                            </div>
                                                                        </th>
                                                                        <th class="max-w-20px text-center">اسم العملية</th>
                                                                        <th class="max-w-20px text-center">القيمة</th>
                                                                        <th class="max-w-20px text-center">التاريخ</th>
                                                                        <th class="max-w-20px text-center">رقم العملية</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="text-gray-600 fw-bold text-center">
                                                                    @foreach ($datacreaditor as $creaditor)
                                                                        <tr>
                                                                            <th scope="row"></th>
                                                                            <td>@if ($creaditor->name_model === 'Cust_del_delay_tran-supply') {{ 'توريد عميل' }} @else {{ 'غير معرف ' }} @endif</td>
                                                                            <td>{{ $creaditor->value }}</td>
                                                                            <td>{{ $creaditor->created_at }}</td>
                                                                            <td>{{ $creaditor->id_model }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <th scope="row"></th>
                                                                        <td colspan="4">مجموع: {{ $totalValuecreaditor }}</td>  <td colspan="2"></td>
                                                                    </tr>
                                                                </tbody>

                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                        <!--end::Card body-->
                                            @else
                                            <span style="visibility: hidden">No data</span>
                                @endif
                            </div>
                        </div>
                </div>
                        <div class="modal fade" id="kt_modal_supply_cust_forcostumer" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_supply_cust_forcostumer_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">توريد عميل</h2>
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
                                    <form action="{{route('superadmin.delevery_cos.supply_cust_del_delay_payment')}}" method="POST">
                                        @csrf
                                        <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                        @if(isset($datacust))
                                        <input type="hidden" id="delivery_customer_id" readonly name="delivery_customer_id" value="{{$datacust->id}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                    <div class="row mb-12">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم العميل</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fs-1 text-danger">{{$datacust->cutomer_del_name_ar}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-12">
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">القيمة</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="value" name="value" required placeholder="القيمة" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" style="background-color: rgb(155, 253, 176)" />
                                        </div>
                                    </div>

                                    @else
                                    <span style="visibility: hidden">No data</span>
                                    @endif
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
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
        $(document).ready(function() {
            $('.delivery_customer_name_order').select2({
                placeholder: 'البحث عن عميل',
                minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: "{{ url('superadmin/delevery_cos/getcutomer_del')}}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.cutomer_del_name_ar,
                                        id: item.id,
                                    }
                                })
                            }
                        }
                    },
                cache: true
            })
            $('.delivery_customer_name_order').on('change', function() {
                const cust_del_code = $(".delivery_customer_name_order option:selected").val();
                window.location = '{{route("superadmin.delevery_cos.submit_cust_del_delay_payment")}}'+ '/'+cust_del_code;
                $('#delivery_customer_name_order').val(this.value);

        });

    })
</script>

<script>
        $('#supply_cus').on('click', function() {
        $('#kt_modal_supply_cust_forcostumer').modal('show');

        })
        </script>


@endsection
