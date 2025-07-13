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
                {{trans('lang.dashboard')}}
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="#" class="text-muted text-hover-primary">{{trans('lang.trans_del')}}</a>
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

<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card">
            <div class="card-body p-9">
                <div class="row mb-6">

                    <div class="col-sm-4">
                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.start_from')}}</label>
                        <div class="position-relative d-flex align-items-center">
                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input class="form-control form-control-solid ps-12 text-center" name="from_date" placeholder="{{trans('lang.start_from')}}" id="kt_datepicker_1" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.end_to')}}</label>
                        <div class="position-relative d-flex align-items-center">
                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input class="form-control form-control-solid ps-12 text-center" name="to_date" placeholder="{{trans('lang.end_to')}}" id="kt_datepicker_2" />
                        </div>
                    </div>
                    <div class="col-sm-2">
                            <label class="col-sm-8 fw-semibold fs-6 mb-2"></label>
                                <div class="col-sm-8 d-flex align-items-center">
                                    <button type="button" class="btn btn-success btn-lg " id="searchbtn" >
                                        Search
                                    </button> 
                                </div> 
                        </div>

                </div>
                <div class="row mb-6">
                    <div class="col-sm-4">
                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.duration')}} {{trans('lang.transfer')}}</label>
                        <div class="position-relative d-flex align-items-center">
                                <input type="number" id="durationt" name="durationt" placeholder="{{trans('lang.duration')}}"   value="{{ old('duration', $searches[2] ?? 15) }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                <span class="">{{trans('lang.minute')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.duration')}} {{trans('lang.order')}}</label>
                        <div class="position-relative d-flex align-items-center">
                                <input type="number" id="durationor" name="durationor" placeholder="{{trans('lang.duration')}}"   value="{{ old('duration', $searches[2] ?? 15) }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                <span class="">{{trans('lang.minute')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.duration')}} {{trans('lang.other')}}</label>
                        <div class="position-relative d-flex align-items-center">
                                <input type="number" id="durationot" name="durationot" placeholder="{{trans('lang.duration')}}"   value="{{ old('duration', $searches[2] ?? 15) }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                <span class="">{{trans('lang.minute')}}</span>
                        </div>
                    </div>
                   
                </div>

                @if(isset($groupedData))
                <div class="row mb-6">
                @if(isset($serches))
                    <h1>
                        <span>{{ trans('lang.start_from') }}</span>
                        <span class="text-info">{{ $serches[0] }}</span>
                        
                        <span>{{ trans('lang.end_to') }}</span>
                        <span class="text-info">{{ $serches[1] }}</span>
                        
                        <span>{{ trans('lang.duration') }}</span>
                        <span class="text-info">
                        {{ trans('lang.transfers') }}: {{ explode(',', $serches[2])[0] }}{{trans('lang.minute')}},
                        {{ trans('lang.orders') }}: {{ explode(',', $serches[2])[1] }}{{trans('lang.minute')}},
                        {{ trans('lang.other') }}: {{ explode(',', $serches[2])[2] }}{{trans('lang.minute')}}
                        </span>
                    </h1>
                @endif
                 <!--begin::Table-->
                 <table class="table align-middle table-rounded table-striped table-row-dashed fs-6 caption-top" id="kt_datatable_table">
                 @if(isset($serches)) <caption>
                 span>{{ trans('lang.start_from') }}</span>
                        <span class="text-info">{{ $serches[0] }}</span>
                        
                        <span>{{ trans('lang.end_to') }}</span>
                        <span class="text-info">{{ $serches[1] }}</span>
                        
                        <span>{{ trans('lang.duration') }}</span>
                        <span class="text-info">
                        {{ trans('lang.transfers') }}: {{ explode(',', $serches[2])[0] }}{{trans('lang.minute')}},
                        {{ trans('lang.orders') }}: {{ explode(',', $serches[2])[1] }}{{trans('lang.minute')}},
                        {{ trans('lang.other') }}: {{ explode(',', $serches[2])[2] }}{{trans('lang.minute')}}
                        </span>

                </caption>@endif
                        <!--begin::Table head-->
                        <thead class="bg-light-dark pe-3">
                            <!--begin::Table row-->
                            <tr class="text-center text-dark fw-bold fs-4 text-uppercase gs-0">
                                <th class="w-10px p-3">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-125px text-center">الطيار</th>
                                <th class="min-w-125px text-center">{{trans('lang.transfers')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.orders')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.other')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.long_duration')}} {{trans('lang.transfers')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.long_duration')}} {{trans('lang.orders')}}</th>
                                <th class="min-w-125px text-center">{{trans('lang.long_duration')}} {{trans('lang.other')}}</th>
                                <th class="min-w-125px text-center">التحويلات الملغية</th>
                                <th class="min-w-125px text-center">الاوردرات الملغية</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        
                        <tbody class="text-gray-600 fw-bold text-center fs-2">
                        @foreach($groupedData as $delCode => $group)
                            <tr>
                                <td>{{ $delCode }}</td>
                                <td>{{ $group['items']->first()->getemp->name_ar ?? 'N/A' }}</td>
                                <td class="text-info">{{ $group['transfers_done'] }}</td>
                                <td class="text-info">{{ $group['orders_done'] }}</td>
                                <td class="text-info">{{ $group['others_done'] }}</td>
                                <td class="text-muted">{{ $group['transfers_exceeded'] }}</td>
                                <td class="text-muted">{{ $group['orders_exceeded'] }}</td>
                                <td class="text-muted">{{ $group['others_exceeded'] }}</td>
                                <td class="text-danger">{{ $group['transfers_cancelled'] }}</td>
                                <td class="text-danger">{{ $group['orders_cancelled'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                @endif
                
            </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $("#kt_datepicker_1").flatpickr({
        defaultDate: new Date().setDate(new Date().getDate() - 1), // Previous day
        enableTime: true,
        allowInput: true,
        dateFormat: "Y-m-d H:i"
        });

    // Datepicker for the second input
    $("#kt_datepicker_2").flatpickr({
        defaultDate: new Date(),  // Current date
        enableTime: true,
        allowInput: true,
        dateFormat: "Y-m-d H:i"
    });

</script>

<script>
$('#searchbtn').click(function() {
    const from_time = $('#kt_datepicker_1').val();
    const to_time = $('#kt_datepicker_2').val(); // Fixed variable name (to_date → to_time)
    const durationt = $('#durationt').val();
    const durationor = $('#durationor').val();
    const durationot = $('#durationot').val();
    
    // Validate required fields
    if (!from_time || !to_time) {
        alert('Please select both date ranges');
        return;
    }
    
    // Convert duration values to integers with fallback to 0
    const duration = [
        parseInt(durationt) || 0,
        parseInt(durationor) || 0,
        parseInt(durationot) || 0
    ];
    
    // Encode the duration array as JSON string for URL
    const durationEncoded = encodeURIComponent(JSON.stringify(duration));
    
    // Construct the URL
    const url = '{{ route("admin.trans_dels.indexalldelrepdura") }}' + 
                '/' + encodeURIComponent(from_time) + 
                '/' + encodeURIComponent(to_time) + 
                '/' + durationEncoded;
    
    // Redirect
    window.location.href = url;
});
</script>
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#kt_datatable_table").DataTable({
            searching: false,
            dom: 'Bfrtip',
            pageLength: 100,
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-icon btn-success btn-active-dark mb-5 p-3',
                    text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
                }
            ]
        });
        
    });
    </script>
@endsection