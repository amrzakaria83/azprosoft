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
            color: #9d5ff3 !important;
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
                <a  href="#" class="text-muted text-hover-primary">الموظفين</a>
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

                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                <div class="row align-items-start">
                            <div class="col-sm-6 p-3">
                                    <ul class="fw-bold fs-7 my-1">
                                        <li class="text-muted px-2">
                                            <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">عودة طلبات التوصيل</a>
                                        </li>
                                    </ul>
                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                        <!--begin::Table-->
                                        @if(isset($data_order))
                                                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delevry_order_request_not_payment">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-light-dark pe-3">
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                            <th class="max-w-20px text-center">الطيار</th>
                                                            <th class="max-w-10px text-center">العميل</th>
                                                            <th class="max-w-20px text-center">الاجراء</th>
                                                        </tr>

                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-bold text-center">

                                                        @foreach ($data_order as $del_code => $data_order_group)
                                                        <tr>
                                                            <td colspan="2"><strong>كود الطيار : {{ $del_code }}</strong></td>
                                                        </tr>
                                                        @foreach ($data_order_group as $data_order1)
                                                        <tr>
                                                            <td>{{ $data_order1->getdelselect->name_ar }}</td>
                                                            <td>{{ $data_order1->getcustomerdel->cutomer_del_name_ar }}</td>

                                                        </tr>
                                                        @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <p>No data</p>
                                                @endif
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                        </div>
                        <div class="col-sm-6 p-3">
                            <h3 style="width: 40%">طلبات التثبيت </h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    @if(isset($data_stable))
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_stable_not_payment">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="max-w-20px text-center">الطيار</th>
                                                        <th class="max-w-10px text-center">العميل</th>
                                                        <th class="max-w-20px text-center">الاجراء</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold text-center">
                                                    @foreach ($data_stable as $del_code => $data_stable_group)
                                                    @foreach ($data_stable_group as $data_stable1)
                                                    <tr>
                                                        <td>{{ $data_stable1->getdelselect->name_ar }}</td>
                                                        <td>{{ $data_stable1->getcustomerdel->cutomer_del_name_ar }}</td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <p>No data</p>
                                            @endif
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>

                </div>

            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>


</script>

@endsection
