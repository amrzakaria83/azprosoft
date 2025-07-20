@extends('admin.layout.master')

@php
    $route = 'admin.attendances';
    $viewPath = 'admin.attendance';
@endphp

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                <a  href="{{route($route. '.index')}}" class="text-muted text-hover-primary">{{trans('lang.role')}}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                
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
                <h1 class="text-center text-success fw-bold">{{trans('lang.in_attendance')}}</h1>
                <!--begin::Form-->
                <form action="{{route($route. '.in_attendance')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                        <input type="hidden" id="code" name="code" value="" />
                        <input type="hidden" id="lat" name="lat" value="" />
                        <input type="hidden" id="lng" name="lng" value="" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label for="">{{trans('lang.emp_id')}} </label>
                            <input type="text" id="emp_id_att" name="emp_id_att" placeholder="{{trans('lang.emp_id')}}" value="" class="form-control form-control-lg form-control-solid text-center" />

                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('lang.name')}} </label>
                            <input type="text" readonly id="emp_name_att" name="" placeholder="{{trans('lang.name')}}" value="" class="form-control form-control-lg form-control-solid text-center" />

                        </div>
                    </div>
                    <!-- <div class="row mb-6">
                            <label for="">{{trans('lang.name')}} </label>
                            <select class="form-select "  aria-label="Select example"   name="emp_id_att_select" data-control="select2">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach (App\Models\Employee::where('is_active', '1')->get() as $asd)
                                        <option value="{{ $asd->id }}" >{{ $asd->name_ar }}</option>
                                    @endforeach
                                </select>
                        </div> -->
                        

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="" id="in_attendance" class="btn btn-lg  btn-success btn-active-success  align-middle container ">
                                                            <span>{{trans('lang.in_attendance')}}</span>
                                                            
                                                        </a>
                        <!-- <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{trans('lang.in_attendance')}}</button> -->
                    </div>
                    <!--end::Actions-->
                    <div id="map" style="height: 300px; visibility: hidden;"></div>

                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')

<script>
    $(document).ready(function() {
    $('#emp_id_att').on('change', function() {
        const emp_id_att = $("#emp_id_att").val(); // Corrected selector for ID
        if (!emp_id_att) {
            toastr.error("{{ trans('lang.error') }}", "{{ trans('validation.attributes.suppliers') }} {{ trans('validation.required') }}");
            return;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "{{ route('admin.attendances.getempdelselect') }}",
            type: 'post',
            dataType: 'json',
            data: { // Send data as an object with the 'q' key
                q: emp_id_att,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token can be sent with data
            },
            delay: 250,
            cache: true, // Consider caching behavior
            success: function (response) {
                console.log(response);
                if (response && response.length > 0) {
                    // Assuming the first result is the one you want if emp_id_att is an exact emp_code
                    // Or if it's a partial search, you might want to handle multiple results differently (e.g., a dropdown)
                    $('#emp_name_att').val(response[0].name_ar); // Or response[0].name_en
                    $('#code').val(response[0].id); // Or response[0].name_en
                } else {
                    $('#emp_name_att').val(''); // Clear the name if no employee found
                    toastr.warning("{{ trans('lang.nodata') }}", "{{ trans('lang.name') }} {{ trans('lang.not_found') }}");
                }
            },
            error: function(xhr, status, error){
                console.error("AJAX Error: ", status, error, xhr.responseText);
                $('#emp_name_att').val(''); // Clear the name on error
                toastr.error("{{ trans('lang.error') }}", "{{ trans('lang.error') }}");
            }
        });

    });
});
</script>
<script>
$('#in_attendance').click(function(e) {
            e.preventDefault();
            // Get the input element by its ID
            
            // Submit the form (if needed)
            $('#kt_account_profile_details_form').submit();
        });
        </script>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsoJSU4k6RgH8tO2gM1WLZBjOFwUF4TcY&callback=initMap&v=weekly&language=ar"
defer
></script>
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15.3
        });
        
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "جاري تحديد موقعك الحالي...",
            position: map.getCenter()
        });
        infoWindow.open(map);
        
        // Try HTML5 geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    // Center map on user's location
                    map.setCenter(pos);
                    
                    // Update infoWindow
                    infoWindow.close();
                    infoWindow = new google.maps.InfoWindow({
                        position: pos,
                        content: "موقعك الحالي"
                    });
                    infoWindow.open(map);
                    
                    // Set initial values in form
                    $('#lat').val(pos.lat);
                    $('#lng').val(pos.lng);
                    
                    // Configure the click listener.
                    map.addListener("click", (mapsMouseEvent) => {
                        infoWindow.close();
                        infoWindow = new google.maps.InfoWindow({
                            position: mapsMouseEvent.latLng,
                        });
                        infoWindow.setContent(
                            JSON.stringify('تم تحديد الموقع', null, 2),
                        );
                        $('#lat').val(mapsMouseEvent.latLng.toJSON().lat);
                        $('#lng').val(mapsMouseEvent.latLng.toJSON().lng);
                        infoWindow.open(map);
                    });
                },
                () => {
                    // Handle location error
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setContent(
            browserHasGeolocation
                ? "Error: فشل خدمة تحديد الموقع. الرجاء التأكد من اعدادات الموقع."
                : "Error: متصفحك لا يدعم خدمة تحديد الموقع."
        );
        infoWindow.open(map);
    }

    window.initMap = initMap;
</script>
@endsection