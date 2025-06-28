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
                            <a href="{{route('admin.pro_sales_dets.create')}}" class="btn btn-sm btn-icon btn-primary btn-active-dark me-3 p-3">
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
                    
                    <!--begin::Table-->
                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table">
                        <!--begin::Table head-->
                        <thead class="bg-light-dark pe-3">
                            <!--begin::Table row-->
                            <tr class="text-center text-dark fw-bold fs-4 text-uppercase gs-0">
                                <th class="w-10px p-3">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-125px text-center">{{trans('lang.product')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.quantity')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.sell_price')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.numb')}} {{trans('lang.invoice')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.sell_price')}} {{trans('lang.unit')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.valued_date')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.numb')}} {{trans('lang.item')}}</th>
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

<script>
$(function () {
    var table = $('#kt_datatable_table').DataTable({
        processing: true, // Enable processing indicator
        serverSide: true,
        searching: true, // Enable searching
        autoWidth: false,
        responsive: true,
        pageLength: 10,
        order: [[4, 'desc']], // Default sorting by sales_d_id descending
        
        // Optimized for server-side processing
        ajax: {
            url: "{{ route('admin.pro_sales_dets.index') }}",
            type: 'GET', // Match your controller's expectation
            data: function (d) {
                // Transform DataTables parameters to match your controller
                d.search = $('#search').val();
                
                // Map DataTables sorting to your controller's expectations
                if (d.order && d.order.length > 0) {
                    d.orderBy = d.columns[d.order[0].column].name;
                    d.orderDirection = d.order[0].dir;
                }
            },
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
            }
        },
        
        // Column definitions matching your controller's output
        columns: [
            { 
                data: 'checkbox', 
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { 
                data: 'name_ar', 
                name: 'name_ar',
                orderable: false // Disable sorting as it's a computed column
            },
            { 
                data: 'amount', 
                name: 'amount',
                orderable: true 
            },
            { 
                data: 'total_item', 
                name: 'total_item',
                orderable: true 
            },
            
            { 
                data: 'sales_id', 
                name: 'sales_id',
                orderable: true 
            },
            { 
                data: 'price', 
                name: 'price',
                orderable: true 
            },
            { 
                data: 'ins_date', 
                name: 'ins_date',
                orderable: true,
                render: function(data) {
                    return data ? moment(data).format('YYYY-MM-DD HH:mm') : '';
                }
            },
            { 
                data: 'sales_d_id', 
                name: 'sales_d_id',
                orderable: true 
            }
        ],
        
        // DOM layout and buttons
        dom: '<"top"<"dbuttons"B>f<"clear">>rt<"bottom"lip<"clear">>',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
                text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        
        // Performance optimizations
        deferRender: true,
        scrollX: true,
        stateSave: false
    });

    // Optimized search input handler with debounce
    let searchTimer;
    $('#search').on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            table.search($('#search').val()).draw();
        }, 500);
    });

    // Button and delete handlers (unchanged)
    table.buttons().container().appendTo($('.dbuttons'));
    
    $("#btn_delete").click(function(event){
        event.preventDefault();
        var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        
        if (checkIDs.length > 0) {
            var token = $(this).data("token");
            Swal.fire({
                title: 'هل انت متأكد ؟',
                text: "لا يمكن استرجاع البيانات المحذوفه",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10',
                confirmButtonText: 'موافق',
                cancelButtonText: 'لا'
            }).then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url: "{{route('admin.pro_sales_dets.delete')}}",
                        type: 'post',
                        dataType: "JSON",
                        data: {
                            "id": checkIDs,
                            "_method": 'post',
                            "_token": token,
                        },
                        success: function (data) {
                            if(data.message == "success") {
                                table.draw();
                                toastr.success("", "تم الحذف بنجاح");
                            } else {
                                toastr.success("", "عفوا لم يتم الحذف");
                            }
                        },
                        fail: function(xhr, errorThrown) {
                            toastr.success("", "عفوا لم يتم الحذف");
                        }
                    });
                }
            });
        } else {
            toastr.error("", "حدد العناصر اولا");
        }
    });
});
</script>

<!-- <script>
    $(function () {

        var table = $('#kt_datatable_table').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 10,
            sort: true,
            order: [[4, 'desc']],
            
            dom: 'Bfrtip',
            buttons: [
                // {
                //     extend: 'print',
                //     className: 'btn btn-primary',
                //     text: 'طباعه'
                // },
                // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
                    text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
                },
                //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
            ],
            ajax: {
                url: "{{ route('admin.pro_sales_dets.index') }}",
                data: function (d) {
                    // d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'name_ar', name: 'name_ar'},
                {data: 'amount', name: 'amount'},
                {data: 'total_item', name: 'total_item'},
                {data: 'sales_d_id', name: 'sales_d_id'},
                {data: 'sales_id', name: 'sales_id'},
                {data: 'price', name: 'price'},
                {data: 'ins_date', name: 'ins_date'},
                // {data: 'actions', name: 'actions'},
            ]
        });

        table.buttons().container().appendTo($('.dbuttons'));

        const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            table.draw();
        });
        $('#phone').change(function() {
            table.draw();
        });

        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });
        $("#btn_delete").click(function(event){
            event.preventDefault();
            var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){
            return $(this).val();
            }).get(); // <----
            if (checkIDs.length > 0) {
                var token = $(this).data("token");
            Swal.fire({title: 'هل انت متأكد ؟',
            text: "لا يمكن استرجاع البيانات المحذوفه",
            type: 'warning',showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {
                if (isConfirm.value) {
            $.ajax({
                url: "{{route('admin.pro_sales_dets.delete')}}",
                type: 'post',
                dataType: "JSON",
                data: {
                    "id": checkIDs,
                    "_method": 'post',"_token": token,
                    },
            success: function (data) {if(data.message == "success") {
                table.draw();
            toastr.success("",
             "تم الحذف بنجاح");
            } else {
                toastr.success("", "عفوا لم يتم الحذف");}},
            fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});
            } else {
                console.log(isConfirm);}});
            } else {toastr.error("", "حدد العناصر اولا");

            }});
    });
</script> -->
@endsection
