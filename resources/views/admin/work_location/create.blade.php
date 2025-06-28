@extends('admin.layout.master')

@php
    $route = 'admin.work_locations';
    $viewPath = 'admin.work_location';
@endphp

@section('css')
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
                <!--begin::Form-->
                <form action="{{route($route. '.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" id="lat" name="lat" value="" />
                    <input type="hidden" id="lng" name="lng" value="" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                    <h1>{{trans('lang.add')}} {{trans('lang.work_location')}}</h1>
                        @include($viewPath. '.form')

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{trans('lang.save')}}</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
                <div id="map" style="height: 300px;"></div>

            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
<script>
    $("#kt_roles_select_all").click(function () {
        var items = $("#kt_account_profile_details_form input:checkbox");
        for (var i = 0; i < items.length; i++) {
            if (items[i].checked == true) {
                items[i].checked = false;
            } else {
                items[i].checked = true;
            }
            
        }
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