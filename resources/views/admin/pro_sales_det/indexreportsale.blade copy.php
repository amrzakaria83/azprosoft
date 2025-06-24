@extends('admin.layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('style')
<style>
        /* Fix for DataTables width calculation */
        #kt_datatable_table {
            width: 100% !important;
        }
        /* Ensure proper spacing for RTL */
        .dataTables_wrapper .dataTables_filter input {
            margin-right: 0.5em;
            margin-left: 0;
        }
    </style>@endsection

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
                            <!-- <a href="{{route('admin.pro_sales_dets.create')}}" class="btn btn-sm btn-icon btn-primary btn-active-dark me-3 p-3">
                                <i class="bi bi-plus-square fs-1x"></i></a> -->
                            <!-- <button type="button" class="btn btn-sm btn-icon btn-primary btn-active-dark me-3 p-3" data-bs-toggle="modal" data-bs-target="#kt_modal_filter">
                                <i class="bi bi-funnel-fill fs-1x"></i></button> -->
                            <!-- <button type="button" class="btn btn-sm btn-icon btn-danger btn-active-dark me-3 p-3" id="btn_delete" data-token="{{ csrf_token() }}">
                                <i class="bi bi-trash3-fill fs-1x"></i></button> -->
                        </div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!-- Summary Panel -->
                    <div class="alert alert-info mb-4">
                        <strong>Summary:</strong> 
                        <span id="totalProducts">0</span> products, 
                        <span id="totalRecords">0</span> records
                    </div>
                    <!-- Main Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table">
                        <thead class="bg-light-dark pe-3">
                            <tr class="text-center text-dark fw-bold fs-4 text-uppercase gs-0">
                                <th class="min-w-125px text-center">{{trans('lang.product')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.sell_price')}} {{trans('lang.unit')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.sales')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.balance')}}</th>
                                <!-- <th class="min-w-125px text-center">{{trans('lang.valued_date')}}</th> -->
                                <th class="min-w-125px text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold text-center"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Sites Modal -->
        <div class="modal fade" id="sitesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Site Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm table-bordered" id="sitesTable">
                            <thead>
                                <tr>
                                    <th>Site ID</th>
                                    <th>Sales Amount</th>
                                    <th>Product Amount</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with proper configuration
    var table = $('#kt_datatable_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.pro_sales_dets.getReportData') }}",
            type: "GET",
            dataSrc: function(json) {
                if (!json) {
                    console.error('Empty response from server');
                    return [];
                }
                
                // Update summary panel
                if (json.summary) {
                    $('#totalProducts').text(json.summary.total_products || 0);
                    $('#totalRecords').text(json.summary.total_records || 0);
                }
                
                return json.data || [];
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX error:', error);
                return [];
            }
        },
        columns: [
            { 
                data: 'product_name',
                name: 'product_name',
                render: function(data, type) {
                    return type === 'display' && data && data.length > 50 ? 
                        data.substr(0, 50) + '...' : (data || 'N/A');
                }
            },
            { 
                data: 'sell_price',
                name: 'sell_price',
                render: function(data) {
                    return data ?  + parseFloat(data).toFixed(2) : '$0.00';
                },
                className: 'text-center'
            },
            { 
                data: 'total_sales_amount',
                name: 'total_sales_amount',
                render: $.fn.dataTable.render.number(',', '.', 2),
                defaultContent: '$0.00',
                className: 'text-center'
            },
            { 
                data: 'total_prod_amount',
                name: 'total_prod_amount',
                render: $.fn.dataTable.render.number(',', '.', 2),
                defaultContent: '$0.00',
                className: 'text-center'
            },
            // { 
            //     data: 'ins_date',
            //     name: 'ins_date',
            //     render: function(data) {
            //         return data ? new Date(data).toLocaleDateString() : 'N/A';
            //     },
            //     className: 'text-center'
            // },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    if (!row.sites || row.sites.length === 0) {
                        return '<span class="text-muted">No sites</span>';
                    }
                    return `<button class="btn btn-sm btn-info view-sites" 
                            data-product="${row.product_name || 'Unknown'}" 
                            data-sites='${JSON.stringify(row.sites || [])}'>
                        <i class="fas fa-eye"></i> View
                    </button>`;
                },
                className: 'text-center'
            }
        ],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        order: [[0, 'asc']],
        language: {
            emptyTable: "No data available",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            search: "Search:",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        initComplete: function() {
            // Recalculate column widths after initialization
            this.api().columns.adjust();
        }
    });

    // Apply search to the table
    $('#search').keyup(function() {
        table.search($(this).val()).draw();
    });

    // Handle site details modal
    $('#kt_datatable_table').on('click', '.view-sites', function() {
        var productName = $(this).data('product');
        var sites = $(this).data('sites') || [];
        
        $('#sitesModal .modal-title').text('Site Details: ' + productName);
        
        // Clear previous table if exists
        if ($.fn.DataTable.isDataTable('#sitesTable')) {
            $('#sitesTable').DataTable().destroy();
        }
        
        // Initialize sites table
        $('#sitesTable').DataTable({
            data: sites,
            columns: [
                { data: 'site_id', className: 'text-center' },
                { 
                    data: 'sales_amount',
                    render: $.fn.dataTable.render.number(',', '.', 2),
                    className: 'text-end'
                },
                { 
                    data: 'prod_amount',
                    render: $.fn.dataTable.render.number(',', '.', 2),
                    className: 'text-end'
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return row.sell_price ? '$' + parseFloat(row.sell_price).toFixed(2) : '$0.00';
                    },
                    className: 'text-end'
                }
            ],
            pageLength: 10,
            dom: 'tpi',
            language: {
                emptyTable: "No site data available"
            }
        });
        
        $('#sitesModal').modal('show');
    });

    // Clean up when modal closes
    $('#sitesModal').on('hidden.bs.modal', function() {
        if ($.fn.DataTable.isDataTable('#sitesTable')) {
            $('#sitesTable').DataTable().destroy();
        }
        $('#sitesTable tbody').empty();
    });
});
</script>
@endsection
