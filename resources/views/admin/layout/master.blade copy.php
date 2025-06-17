<!DOCTYPE html>
<html @if (App::getLocale() == 'ar') lang="ar" direction="rtl" dir="rtl" style="direction: rtl;" @else lang="en" direction="ltr" dir="ltr" style="direction: ltr;" @endif>
	<!--begin::Head-->
	<head>
		<base href="{{url('/admin')}}"/>
		<title>{{$settings->append_name}}</title> 
		<meta charset="utf-8" />
		<meta name="description" content="{{$settings->append_description}}" />
		<meta name="keywords" content="{{$settings->append_keywords}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
        @include('admin.layout.head')
        <style>
            /* These !important overrides might indicate deeper CSS issues or conflicts. */
            /* Consider investigating the root cause if possible, but they are unlikely to break JS functionality directly. */
            .dropdown-menu { margin: 0 !important; }
            .nav-item.dropdown .dropdown-menu { margin: 0 !important; }
            .dropdown-menu li a { margin-bottom: 0 !important; }
    </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-hoverable="false" data-kt-app-sidebar-push-toolbar="false" data-kt-app-sidebar-push-footer="false" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="false" data-kt-app-aside-fixed="false" data-kt-app-aside-push-toolbar="false" data-kt-app-aside-push-footer="false" class="app-default">

		<style>body { background-image: url("{{asset('dash/assets/media/auth/14-2.jpg')}}"); } [data-bs-theme="dark"] body { background-image: url("{{asset('dash/assets/media/auth/bg10-dark.jpg')}}"); }</style>
		
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('admin.layout.header')
				
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					{{-- @include('admin.layout.sidebar') --}} {{-- Sidebar removed --}}
					
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							{{-- Optional: @include('admin.layout.toolbar') if you have one --}}
			
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid"> {{-- Single, correctly placed content area --}}
								<!--begin::Content container-->
								{{-- <div id="kt_app_content_container" class="app-container"> --}}
									@yield('content')
								{{-- </div> --}}
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						
						@include('admin.layout.footer')
					</div>
					<!--end::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->

		{{-- @include('admin.layout.aside') --}} {{-- Aside component and its layout effects disabled --}}	
		@include('admin.layout.footer-script')
        

	</body>
	<!--end::Body-->
</html>