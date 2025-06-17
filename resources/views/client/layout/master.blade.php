<!DOCTYPE html>
<html @if (App::getLocale() == 'ar') lang="ar" direction="rtl" dir="rtl" style="direction: rtl;" @else lang="en" @endif>
	<!--begin::Head-->
	<head><base href="{{url('/')}}"/>
		<title>{{$settings->append_name}}</title>
		<meta charset="utf-8" />
		<meta name="description" content="{{$settings->append_description}}" />
		<meta name="keywords" content="{{$settings->append_keywords}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
        @include('client.layout.head')
        
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
		<style>body { background-image: url("{{asset('dash/assets/media/auth/14-2.jpg')}}"); } [data-bs-theme="dark"] body { background-image: url("{{asset('dash/assets/media/auth/bg10-dark.jpg')}}"); }</style>
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('client.layout.header')
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					
					@include('client.layout.sidebar')

					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Content-->
							
							<div id="kt_app_content" class="app-content flex-column-fluid">

								@yield('content')

							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->

						@include('client.layout.footer')
						
					</div>
					<!--end:::Main-->

					@include('client.layout.aside')
					
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
        
		@include('client.layout.footer-script')
	</body>
	<!--end::Body-->
</html>