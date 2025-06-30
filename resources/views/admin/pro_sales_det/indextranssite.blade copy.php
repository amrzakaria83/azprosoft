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
        .sticky-left {
            position: sticky;
            left: 0;
            background-color: white; /* or your table's background color */
            z-index: 1;
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
                    <div class="row mb-6">
                        <!-- Store Buttons Section -->
                        <div class="col-sm-12 fv-row">
                            <div class="d-flex flex-wrap">
                                @foreach (\App\Models\Pro_store::whereIn('store_id', [1, 2, 3, 4, 6, 8, 9, 12, 13, 14, 21])->orderBy('store_name')->get() as $site)
                                    <button type="button" 
                                            class="btn btn-info btn-lg m-2 store-print-btn" 
                                            data-store-id="{{ $site->store_id }}"
                                            onclick="printStoreData({{ $site->store_id }}, '{{ addslashes($site->store_name) }}')">
                                        <i class="fas fa-print me-2"></i>
                                        {{ $site->store_name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
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
                                <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.store')}} {{trans('lang.transfer')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select data-placeholder="Select an option" class="input-text form-control form-select mb-3 mb-lg-0 text-center" name="store_id_transfer" id="store_id_transfer" data-allow-clear="true" style="background-color :#E3FFA0FF;">
                                    <option value="">Select an option</option>
                                    @foreach (\App\Models\Pro_store::get() as $store)
                                        <option value="{{ $store->store_id }}" {{ $store->store_id == 7 ? 'selected' : '' }}>
                                            {{ $store->store_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <h1><span>{{trans('lang.valued_date')}} <span id="valued_date">0</span></span></h1>
                    <!-- Summary Panel -->
                    <div class="alert alert-info mb-4 text-center">
                        <strong>{{trans('lang.summary')}}:</strong> 
                        {{trans('lang.start_from')}} <span id="start_from">0</span> , 
                        {{trans('lang.end_to')}} <span id="end_to">0</span> , 
                        {{trans('lang.duration')}} <span id="totalDays" class="text-danger">0</span> {{trans('lang.days')}},
                        <span id="totalProducts">0</span> {{trans('lang.products')}}, 
                        <span id="totalRecords">0</span> {{trans('lang.transactions')}}
                    </div>
                    
                    <div class="row mb-6">
                        <!-- <label class="col-sm-2 col-form-label fw-semibold fs-6">{{trans('lang.name')}}-{{trans('lang.employee')}}</label> -->
                        <div class="col-sm-4">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.type_type')}} {{trans('lang.product')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select id="drugFilter" class="form-control">
                                    <option value="">All Products</option>
                                    <option value="1">{{trans('lang.drug')}}</option>
                                    <option value="0">{{trans('lang.non_drug')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.stores')}}</label>
                            <div class="col-sm-12 fv-row">
                                <select  data-placeholder="Select an option" class=" input-text form-control form-select  mb-3 mb-lg-0 text-center" multiple="multiple" name="store_id[]" id="store_id" data-allow-clear="true" data-control="select2" >
                                    <option  disabled selected></option>
                                        @foreach (\App\Models\Pro_store::get() as $az)
                                            <option value="{{$az->store_id}}">{{$az->store_name}}</option>
                                            @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.consumption_rate')}} {{trans('lang.less_than')}}</label>
                            <div class="col-sm-12 fv-row">
                                <input type="number" name="c_r_less_than" placeholder="{{trans('lang.day')}}" id="c_r_less_than" value="10" class="form-control form-control-lg form-control-solid text-center" />

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2">{{trans('lang.quantity')}} {{trans('lang.consumption_rate')}}</label>
                            <div class="col-sm-12 fv-row">
                                <input type="number" name="c_r_quantity" placeholder="{{trans('lang.day')}}" id="c_r_quantity" value="20" class="form-control form-control-lg form-control-solid text-center" />

                            </div>
                        </div>
                    </div>
                    
                    <!-- Main Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6 w-100 sticky-left" id="kt_datatable_table">
                        <thead class="bg-light-dark pe-3">
                            <tr class="text-center text-dark fw-bold fs-4 text-uppercase gs-0">
                                <th class="min-w-125px text-center">Actions</th>
                                <th class="min-w-125px text-center">code</th>
                                <th class="min-w-125px text-center">{{trans('lang.product')}}</th>
                                <!-- <th class="min-w-125px text-center">code</th> -->
                                <!-- <th class="min-w-125px text-center">code</th> -->
                                <th class="min-w-125px text-center">{{trans('lang.sell_price')}} {{trans('lang.unit')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.sales')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.sales')}}/{{trans('lang.day')}}</th> <!-- Hidden column -->
                                <th class="min-w-125px text-center">{{trans('lang.total')}} {{trans('lang.balance')}}</th>

                                <!-- <th class="min-w-125px text-center">{{trans('lang.valued_date')}}</th> -->
                                @php
                                $sites = \App\Models\Pro_store::get()
                                @endphp
                                @foreach ($sites as $site) 
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-b">{{trans('lang.balance_acc')}} {{$site->store_name}}</th>
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-s">{{trans('lang.sale_acc')}} {{$site->store_name}}</th>
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-b">{{trans('lang.consumption_rate')}} {{$site->store_name}}/{{trans('lang.day')}}</th>
                                <th class="min-w-125px text-center" data-site-control="{{$site->store_id}}-b">{{trans('lang.quantity')}} {{$site->store_name}} {{trans('lang.transfer')}}</th>
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
    // console.log('Sites data:', sites);

    // First build the columns configuration
    var columns = [
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
        },
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
            render: function(data, type, row) {
                var content = type === 'display' && data && data.length > 50 ? 
                    data.substr(0, 50) + '...' : (data || 'N/A');
                
                if (type === 'display') {
                    var drugClass = row.drug == 1 ? 'text-info' : 'text-danger';
                    return '<span class="' + drugClass + '">' + content + '</span>';
                }
                return content;
            }
        },
        {
            data: 'sell_price',
            name: 'sell_price',
            render: function(data) {
                return data ? parseFloat(data).toFixed(2) : 0;
            },
            className: 'text-center',
            createdCell: function (td, cellData, rowData, row, col) {
                if (cellData > 250) {
                    $(td).addClass('text-info');
                }
            }
        },
        { 
            data: 'total_sales_amount',
            name: 'total_sales_amount',
            render: $.fn.dataTable.render.number(',', '.', 2),
            defaultContent: 0,
            className: 'text-center',
        },
        // Hidden column
        { 
            data: null,
            name: 'sales_per_day',
            
            visible: true,
            render: function(data, type, row, meta) {
                const json = meta.settings.json;
                const days = json?.summary?.days_diff || 1;
                const sales = parseFloat(row.total_sales_amount) || 0;
                return (sales / days).toFixed(2);
            }
        },
        { 
            data: 'total_prod_amount',
            name: 'total_prod_amount',
            render: $.fn.dataTable.render.number(',', '.', 2),
            defaultContent: 0,
            className: 'text-center',
            createdCell: function (td, cellData, rowData, row, col) {
                if (cellData < 3) {
                    $(td).addClass('text-info');
                }
            }
            
        }
        ];

    // Add dynamic site columns
    sites.forEach(function(site) {
        columns.push({
            data: null,
            name: 'site_' + site.store_id + '_balance',
            defaultContent: 0,
            className: 'text-center text-success',
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
            // Consumption Rate column (sales per day)
        columns.push({
            data: null,
            name: 'site_' + site.store_id + '_consumption_rate',
            defaultContent: 0,
            className: 'text-center text-secondary',
            render: function(data, type, row, meta) {
                if (!row.sites) return 0;
                var siteData = row.sites.find(s => s.site_id == site.store_id);
                if (!siteData || !siteData.sales_amount) return 0;
                
                // Get days_diff from the summary data
                const json = meta.settings.json;
                const daysDiff = json?.summary?.days_diff || 1; // Default to 1 if not available
                // Calculate and store consumption rate
                const consumptionRate = (siteData.sales_amount / daysDiff).toFixed(2);
                 // Store in row data for other columns to access
                if (type === 'display' || type === 'filter') {
                    if (!row._consumptionRates) row._consumptionRates = {};
                    row._consumptionRates[site.store_id] = consumptionRate;
                }
                // Calculate and return consumption rate (sales per day)
                return consumptionRate;
            }
        });
        // q_added
        columns.push({
            data: null,
            name: 'site_' + site.store_id + '_consumption_rate',
            defaultContent: 0,
            className: 'text-center text-info',
            render: function(data, type, row, meta) {
                // Early return if no site data
                if (!row.sites) return '0';
                
                const siteData = row.sites.find(s => s.site_id == site.store_id);
                if (!siteData || typeof siteData.prod_amount === 'undefined') return '0';
                
                // Get configuration values with defaults
                const c_r_less_than = parseFloat($('#c_r_less_than').val()) || 1;
                const c_r_quantity = parseFloat($('#c_r_quantity').val()) || 1;
                
                // Get consumption rate with safety checks
                const consumptionRate = parseFloat(row._consumptionRates?.[site.store_id]) || 0;
                if (consumptionRate <= 0) return '∞'; // Infinite supply
                
                // Calculate required quantities
                const q_c_r_quantity = consumptionRate * c_r_quantity;
                const q_added = q_c_r_quantity - (parseFloat(siteData.prod_amount) || 0);
                
                // Format output
                if (q_added > 0) {
                    // Round to nearest integer, minimum 1
                    return Math.max(1, Math.round(q_added)).toString();
                }
                return '0';
            }
        });
        
    });

        $('#store_id').select2({
        placeholder: "Select one or more stores",
        allowClear: true,
        width: '100%',
        closeOnSelect: false // Keep dropdown open for multiple selections
    });

    // Client-side filtering for multiple select
    $('#storeFilter').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('#store_id option').each(function() {
            var optionText = $(this).text().toLowerCase();
            $(this).toggle(optionText.includes(searchTerm));
        });
        
        // Reopen dropdown to show filtered results
        $('#store_id').select2('open');
    });

    // Initialize DataTable
    var table = $('#kt_datatable_table').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: "{{ route('admin.pro_sales_dets.transReport') }}",
            type: "GET",
    
            data: function(d) {
                    // Get all selected store IDs as array
                    // d.selected_stores = $('#store_id').val() || [];
                    // Pass filter values
                    // d.store_filter = $('#storeFilter').val();
                    d.store_id_transfer = $('#store_id_transfer').val(); // Pass filter value to server
                    d.drug_filter = $('#drugFilter').val(); // Pass filter value to server
                },
            dataSrc: function(json) {
                // console.log('json:', json);
                // console.log('json:', json.summary.days_diff);
                // console.log('First row summary:', json.data[0]?.summary);
                // console.log(json.summary);
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
                    $('#valued_date').text(json.summary.generated_at || 0);
                    $('#totalProducts').text(json.summary.total_products || 0);
                    $('#totalRecords').text(json.summary.total_records || 0);
                    $('#start_from').text(json.summary.start_from || 0);
                    $('#end_to').text(json.summary.end_to || 0);
                     // Calculate duration in days if both dates exist
                    if (json.summary.start_from && json.summary.end_to) {
                        const startDate = new Date(json.summary.start_from);
                        const endDate = new Date(json.summary.end_to);
                        const timeDiff = endDate - startDate;
                        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                        $('#totalDays').text(daysDiff);
                    } else {
                        $('#totalDays').text(0);
                    }
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

    $('#drugFilter,#store_id,#store_id_transfer').on('change', function() {
        table.ajax.reload(); // This will resend the request with the new filter
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

<!-- JavaScript Implementation -->
<script>
    // Ensure functions are available before buttons are clicked
    document.addEventListener('DOMContentLoaded', function() {
        window.printStoreData = function(storeId, storeName) {
            try {
                if (!window.kt_datatable) {
                    console.error('DataTable not initialized');
                    alert('Please wait until data is loaded');
                    return;
                }

                const table = $('#kt_datatable_table').DataTable();
                const printWindow = window.open('', `PRINT_${storeId}`, 'width=1000,height=700');
                const now = new Date();
                
                // Filter data for the specific store
                const filteredData = table.rows().data().toArray().filter(row => {
                    const needsTransfer = row.sites?.some(site => 
                        site.site_id == storeId && 
                        calculateTransferQty(row, storeId) > 0
                    );
                    return needsTransfer;
                });

                if (filteredData.length === 0) {
                    printWindow.close();
                    showAlert('No transfer items needed for ' + storeName, 'warning');
                    return;
                }

                // Generate print content
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>${escapeHtml(storeName)} Transfer List</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { padding: 20px; font-family: Arial; }
                                .header { margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
                                .title { font-size: 22px; font-weight: bold; }
                                .date { float: right; color: #666; }
                                table { width: 100%; margin-top: 15px; border-collapse: collapse; }
                                th { background: #f8f9fa; text-align: left; padding: 8px; border: 1px solid #ddd; }
                                td { padding: 8px; border: 1px solid #ddd; }
                                .text-end { text-align: right; }
                                .fw-bold { font-weight: bold; }
                                @media print {
                                    .no-print { display: none; }
                                    body { padding: 0; }
                                }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <div class="title">${escapeHtml(storeName)} - Transfer List</div>
                                <div class="date">${now.toLocaleDateString()} ${now.toLocaleTimeString()}</div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Transfer Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${generateTransferRows(filteredData, storeId)}
                                </tbody>
                            </table>
                            <div class="no-print text-center mt-3 text-muted">
                                <small>Generated by Inventory System</small>
                            </div>
                            <script>
                                window.onload = function() {
                                    setTimeout(function() {
                                        window.print();
                                        setTimeout(window.close, 100);
                                    }, 50);
                                };
                            <\/script>
                        </body>
                    </html>
                `);
                printWindow.document.close();
            } catch (error) {
                console.error('Print error:', error);
                showAlert('Failed to generate printout', 'error');
                if (printWindow) printWindow.close();
            }
        };

        // Helper functions
        window.calculateTransferQty = function(row, storeId) {
            const site = row.sites?.find(s => s.site_id == storeId);
            if (!site) return 0;
            
            const consumption = row._consumptionRates?.[storeId] || 0;
            const days = parseFloat($('#c_r_quantity').val()) || 1;
            const needed = consumption * days;
            const current = parseFloat(site.prod_amount) || 0;
            
            return Math.max(0, Math.ceil(needed - current));
        };

        window.generateTransferRows = function(data, storeId) {
            return data.map(row => {
                const site = row.sites.find(s => s.site_id == storeId);
                const transferQty = calculateTransferQty(row, storeId);
                
                return `
                    <tr>
                        <td>${escapeHtml(row.product_name || 'N/A')}</td>
                        <td class="text-end">${(site?.prod_amount || 0).toFixed(2)}</td>
                        <td class="text-end fw-bold">${transferQty}</td>
                    </tr>
                `;
            }).join('');
        };

        window.escapeHtml = function(text) {
            return text?.toString()
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;') || '';
        };

        window.showAlert = function(message, type) {
            if (window.toastr) {
                toastr[type](message);
            } else {
                alert(message);
            }
        };

        console.log('Transfer print functions initialized');
    });
</script>

@endsection
