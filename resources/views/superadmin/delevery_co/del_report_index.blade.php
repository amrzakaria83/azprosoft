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
                <a  href="#" class="text-muted text-hover-primary">شغل طيار</a>
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
                <ul class="fw-bold fs-7 my-1">
                    <li class="text-muted px-2">
                        <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-danger text-hover-primary fw-bold fs-2 ">- عودة طلبات التوصيل</a>
                    </li>
                </ul>
                <div class="row align-items-start">
                    <div class="col-sm-8 p-3">
                            <h3 style="width: 20%">حركة طيار
                            </h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <div class="row">
                                        <div class="col-sm-4 p-3">
                                            <select class="delivery_name_order form-control" id="delivery_name_order" name="delivery_name_order"  ></select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="required fw-semibold fs-6 mb-3">تاريخ  من</label>
                                            <div class="position-relative d-flex align-items-center">

                                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                        <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <input class="form-control form-control-solid ps-12" name="from_date" placeholder="من تاريخ" id="kt_datepicker_1" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label class="required fw-semibold fs-6 mb-2">تاريخ  الى</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                        <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <input class="form-control form-control-solid ps-12" name="to_date" placeholder="الى تاريخ" id="kt_datepicker_2" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>
                </div>

                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <div class="row align-items-start">
                                    <!--begin::Table-->
                                        <div class="col-sm-4 p-3">
                                            <h3 style="width: 20%"> التوريدات </h3>
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_del_report_index">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="max-w-10px text-center">تاريخ </th>
                                                        <th class="max-w-20px text-center"> التوصيل</th>
                                                        <th class="max-w-20px text-center"> التثبيت</th>
                                                        <th class="max-w-20px text-center">الاجمالى </th>
                                                        <th class="max-w-20px text-center">موظف التقفيل</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold text-center">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                        <div class="col-sm-4 p-3">
                                                <h3 style="width: 20%">طلب توصيل </h3>
                                                    <!--begin::Card body-->
                                                        <!--begin::Table-->
                                                                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="del_report_order_done12">
                                                                    <!--begin::Table head-->
                                                                    <thead class="bg-light-dark pe-3">
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                            <th class="max-w-10px text-center">العميل</th>
                                                                            <th class="max-w-20px text-center">الوقت</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="text-gray-600 fw-bold text-center">
                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                        <!--end::Table-->

                                                    <!--end::Card body-->
                                        </div>
                                        <div class="col-sm-4 p-3">
                                            <h3 style="width: 20%">طلب تثبيت </h3>
                                                <!--begin::Card body-->
                                                    <!--begin::Table-->
                                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="del_report_stable_done">
                                                                <!--begin::Table head-->
                                                                <thead class="bg-light-dark pe-3">
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                        <th class="max-w-10px text-center">العميل</th>
                                                                        <th class="max-w-20px text-center">الوقت</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="text-gray-600 fw-bold text-center">
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                    <!--end::Table-->

                                                <!--end::Card body-->
                                    </div>
                                    <!--end::Table-->
                                    </div>
                                <!--end::Card body-->
                                </div>
            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>
<script >
        $("#kt_datepicker_1").flatpickr({defaultDate: new Date(new Date().setDate(new Date().getDate() - 1))});
    $("#kt_datepicker_2").flatpickr({defaultDate: "today"});
</script>

<script>
        $('.delivery_name_order').select2({
                placeholder: 'Select an item',
                minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: "{{ url('superadmin/delevery_cos/getdelselect')}}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        if (data.length == 0) {
                            data = [{"id":"add","cutomer_del_name_ar":"Add client"}];
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.name_ar,
                                        id: item.del_code,
                                    }
                                })
                            }
                        } else {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.name_ar,
                                        id: item.del_code,
                                    }
                                })
                            }
                        }

                    },
                cache: true}
            });
            $('#delivery_name_order, #kt_datepicker_1, #kt_datepicker_2').on('change', function() {

                const del_code = $(this).val();
                var kt_datepicker_1 = $("#kt_datepicker_1").val();
                var kt_datepicker_2 =  $("#kt_datepicker_2").val();

                $(function () {

                    var table = $('#kt_datatable_table_del_report_index').DataTable({
                processing: false,
                serverSide: true,
                bDestroy: true,
                searching: false,
                autoWidth: false,
                responsive: true,
                pageLength: 10,
                sort: false,
                dom: 'Bfrtip',
                buttons: [
                    // {
                    //     extend: 'print',
                    //     className: 'btn btn-primary',
                    //     text: 'طباعه'
                    // },
                    // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                    // {
                    //     extend: 'excel',
                    //     className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
                    //     text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
                    // },
                    //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                ],
                ajax: {

                    url: "{{url('/')}}"+"/superadmin/delevery_cos/del_report_index?del_code="+del_code+"&from_date="+kt_datepicker_1+"&to_date="+kt_datepicker_2,
                    data: function (d) {
                        d.del_code = $('#delivery_name_order').val(),
                        d.total_order_values = $('#total_order_values').val(),
                        d.total_stable_values = $('#total_stable_values').val(),
                        d.del_total_valu = $('#del_total_valu').val(),
                        d.emp_code = $('#emp_code').val(),
                        d.search = $('#search').val()
                    }
                },
                columns: [
                    {data: 'del_code', name: 'del_code'},
                    {data: 'total_order_values', name: 'total_order_values'},
                    {data: 'total_stable_values', name: 'total_stable_values'},
                    {data: 'del_total_valu', name: 'del_total_valu'},
                    {data: 'emp_code', name: 'emp_code'},
                ]});

            table.buttons().container().appendTo($('.dbuttons'));
            // window.location = '{{route("superadmin.delevery_cos.del_report_index")}}'+ '/'+del_code;
            table.draw();
            })
        })
</script>
<script>
    $('#delivery_name_order, #kt_datepicker_1, #kt_datepicker_2').on('change', function() {

            const del_code = $(this).val();
            var kt_datepicker_1 = $("#kt_datepicker_1").val();
            var kt_datepicker_2 =  $("#kt_datepicker_2").val();

        $(function () {

            var table = $('#del_report_order_done12').DataTable({
                processing: false,
                serverSide: true,
                bDestroy: true,
                searching: false,
                autoWidth: false,
                responsive: true,
                pageLength: 20,
                sort: false,
                dom: 'Bfrtip',
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     className: 'btn btn-primary',
                        //     text: 'طباعه'
                        // },
                        // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                        // {
                        //     extend: 'excel',
                        //     className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
                        //     text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
                        // },
                        //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                    ],
                    ajax: {
                        url: "{{url('/')}}"+"/superadmin/delevery_cos/del_report_order_done?del_code="+del_code+"&from_date="+kt_datepicker_1+"&to_date="+kt_datepicker_2,
                        data: function (d) {
                            d.del_code = $('#delivery_name_order').val(),
                            d.delivery_customer_id = $('#delivery_customer_id').val(),
                            d.time_value = $('#time_value').val(),
                            d.search = $('#search').val()
                        }
                    },
                    columns: [
                    {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                    {data: 'time_value', name: 'time_value'},
                            ]});

                        table.buttons().container().appendTo($('.dbuttons'));
                        table.draw();
                    });
})
</script>

<script>
    $('#delivery_name_order, #kt_datepicker_1, #kt_datepicker_2').on('change', function() {

            const del_code = $(this).val();
            var kt_datepicker_1 = $("#kt_datepicker_1").val();
            var kt_datepicker_2 =  $("#kt_datepicker_2").val();

        $(function () {

            var table = $('#del_report_stable_done').DataTable({
                processing: false,
                serverSide: true,
                bDestroy: true,
                searching: false,
                autoWidth: false,
                responsive: true,
                pageLength: 20,
                sort: false,
                dom: 'Bfrtip',
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     className: 'btn btn-primary',
                        //     text: 'طباعه'
                        // },
                        // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                        // {
                        //     extend: 'excel',
                        //     className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
                        //     text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
                        // },
                        //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                    ],
                    ajax: {
                        url: "{{url('/')}}"+"/superadmin/delevery_cos/del_report_stable_done?del_code="+del_code+"&from_date="+kt_datepicker_1+"&to_date="+kt_datepicker_2,
                        data: function (d) {
                            d.del_code = $('#delivery_name_order').val(),
                            d.delivery_customer_id = $('#delivery_customer_id').val(),
                            d.time_value = $('#time_value').val(),
                            d.search = $('#search').val()
                        }
                    },
                    columns: [
                    {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                    {data: 'time_value', name: 'time_value'},
                            ]});

                        table.buttons().container().appendTo($('.dbuttons'));
                        table.draw();
                    });
})
</script>

@endsection
