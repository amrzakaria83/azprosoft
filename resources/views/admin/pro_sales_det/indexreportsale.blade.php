@extends('admin.layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .export-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            font-size: 1.5rem;
        }
    </style>
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
                    <div class="alert alert-info mb-4 text-center">
                        <strong>{{trans('lang.summary')}}:</strong> 
                        {{trans('lang.start_from')}} <span id="start_from">0</span> , 
                        {{trans('lang.end_to')}} <span id="end_to">0</span> , 
                        <span id="totalProducts">0</span> {{trans('lang.products')}}, 
                        <span id="totalRecords">0</span> {{trans('lang.transactions')}}
                    </div>
                    <!-- Main Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table">
                        <thead class="bg-light-dark pe-3">
                            <tr class="text-center text-dark fw-bold fs-4 text-uppercase gs-0">
                                <th class="min-w-125px text-center">code</th>
                                <th class="min-w-125px text-center">{{trans('lang.product')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.sell_price')}} {{trans('lang.unit')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.sales')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.balance')}}</th>
                                <!-- <th class="min-w-125px text-center">{{trans('lang.valued_date')}}</th> -->
                                <th class="min-w-125px text-center">Actions</th>
                                @php
                                $sites = \App\Models\Pro_store::get()
                                
                                @endphp
                                @foreach ($sites as $site) 
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-b">{{trans('lang.balance')}} {{$site->store_name}}</th>
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-s">{{trans('lang.sales')}} {{$site->store_name}}</th>
                                @endforeach
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
                                    <th>{{trans('lang.name')}}</th>
                                    <th>{{trans('lang.sales')}}</th>
                                    <th>{{trans('lang.balance')}}</th>
                                    <!-- <th>Price</th> -->
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
<!-- <script src="{{asset('dash/assets/js/scripts.bundle.js')}}"></script> -->
<script>
$(document).ready(function() {
    // Get all sites from PHP
    var sites = {!! \App\Models\Pro_store::get(['store_id', 'store_name'])->toJson() !!};
    console.log('Sites data:', sites);

    // First build the columns configuration
    var columns = [
        { 
            data: 'product_id',
            name: 'product_id',
            render: function(data, type) {
                return type === 'display' && data && data.length > 50 ? 
                    data.substr(0, 50) + '...' : (data || 'N/A');
            }
        },
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
                return data ? + parseFloat(data).toFixed(2) : 0;
            },
            className: 'text-center'
        },
        { 
            data: 'total_sales_amount',
            name: 'total_sales_amount',
            render: $.fn.dataTable.render.number(',', '.', 2),
            defaultContent: 0,
            className: 'text-center'
        },
        { 
            data: 'total_prod_amount',
            name: 'total_prod_amount',
            render: $.fn.dataTable.render.number(',', '.', 2),
            defaultContent: 0,
            className: 'text-center'
        },
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
        }];

    // Add dynamic site columns
    sites.forEach(function(site) {
        columns.push({
            data: null,
            name: 'site_' + site.store_id + '_balance',
            defaultContent: 0,
            className: 'text-center',
            render: function(data, type, row) {
                if (!row.sites) return 0;
                var siteData = row.sites.find(s => s.site_id == site.store_id);
                return siteData ?  + siteData.prod_amount.toFixed(2) : 0;
            }
        });
        
        columns.push({
            data: null,
            name: 'site_' + site.store_id + '_sales',
            defaultContent: 0,
            className: 'text-center',
            render: function(data, type, row) {
                if (!row.sites) return 0;
                var siteData = row.sites.find(s => s.site_id == site.store_id);
                return siteData ?  + siteData.sales_amount.toFixed(2) : 0;
            }
        });
    });

    // Initialize DataTable
    var table = $('#kt_datatable_table').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: "{{ route('admin.pro_sales_dets.getReportData') }}",
            type: "GET",
            dataSrc: function(json) {
                if (typeof json === 'string') {
                    try {
                        json = JSON.parse(json);
                    } catch (e) {
                        console.error('Failed to parse JSON:', e);
                        return [];
                    }
                }
                
                if (!json) {
                    console.error('Empty response from server');
                    return [];
                }
                
                if (json.summary) {
                    $('#totalProducts').text(json.summary.total_products || 0);
                    $('#totalRecords').text(json.summary.total_records || 0);
                    $('#start_from').text(json.summary.start_from || 0);
                    $('#end_to').text(json.summary.end_to || 0);
                }
                
                return json.data || [];
            },
            error: function(xhr, textStatus, error) {
                console.error('AJAX Error:', textStatus, error);
                return [];
            }
        },
        
        columns: columns,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'fB>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
             buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Export All',
                    className: 'btn btn-success btn-sm',
                    action: function(e, dt, button, config) {
                        // Simple loading indicator (works without KTApp)
                        var loading = $('<div class="export-loading">Preparing export...</div>');
                        $('body').append(loading);
                        
                        // Create a temporary form
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('admin.pro_sales_dets.exportReport') }}";
                        form.target = '_blank';
                        
                        // Add CSRF token
                        var token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = "{{ csrf_token() }}";
                        form.appendChild(token);
                        
                        document.body.appendChild(form);
                        form.submit();
                        
                        // Clean up after download starts
                        setTimeout(function() {
                            document.body.removeChild(form);
                            loading.remove();
                        }, 3000); // Adjust timeout as needed
                    }
                }
            ],
        pageLength: 50,
        lengthMenu: [10, 25, 50, 100],
        order: [[3, 'asc']],
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
            console.log('DataTable initialized successfully');
        },
        createdRow: function(row, data, dataIndex) {
            if (data.sites) {
                sites.forEach(function(site) {
                    var siteData = data.sites.find(function(s) {
                        return s.site_id == site.store_id;
                    });
                    
                    var balanceCell = $(row).find(`td:eq(${$(`th[data-site-control="${site.store_id}-b"]`).index()})`);
                    balanceCell.text(siteData ?  + siteData.prod_amount.toFixed(2) : 0);
                    balanceCell.addClass('text-center');
                    
                    var salesCell = $(row).find(`td:eq(${$(`th[data-site-control="${site.store_id}-s"]`).index()})`);
                    salesCell.text(siteData ?  + siteData.sales_amount.toFixed(2) : 0);
                    salesCell.addClass('text-center');
                });
            }
        }
    });

    // Apply search to the table
    $('#search').keyup(function() {
        table.search($(this).val()).draw();
    });

    // Handle site details modal
    $('#kt_datatable_table').on('click', '.view-sites', function() {
        var productName = $(this).data('product');
        var sitesData = $(this).data('sites') || [];
        
        $('#sitesModal .modal-title').text('Site Details: ' + productName);
        
        if ($.fn.DataTable.isDataTable('#sitesTable')) {
            $('#sitesTable').DataTable().destroy();
        }
        
        var siteNameMap = {};
        sites.forEach(function(site) {
            siteNameMap[site.store_id] = site.store_name;
        });
        
        var processedData = sitesData.map(function(site) {
            return {
                store_name: siteNameMap[site.site_id] || 'Unknown Site',
                sales_amount: site.sales_amount,
                prod_amount: site.prod_amount
            };
        });
        
        $('#sitesTable').DataTable({
            data: processedData,
            columns: [
                { 
                    data: 'store_name', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data || 'Unknown Site';
                    }
                },
                { 
                    data: 'sales_amount',
                    render: $.fn.dataTable.render.number(',', '.', 2),
                    className: 'text-center'
                },
                { 
                    data: 'prod_amount',
                    render: $.fn.dataTable.render.number(',', '.', 2),
                    className: 'text-center'
                }
            ],
            pageLength: 20,
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

    // Prevent form submission from reloading page
    $(document).on('submit', 'form', function(e) {
        if ($(this).attr('target') === '_blank') {
            return true;
        }
        e.preventDefault();
        return false;
    });
});
</script>
@endsection
