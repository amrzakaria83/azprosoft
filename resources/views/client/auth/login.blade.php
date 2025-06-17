<!DOCTYPE html>
<html @if (App::getLocale() == 'ar') lang="ar" direction="rtl" dir="rtl" style="direction: rtl;" @else lang="en" @endif>
	<!--begin::Head-->
	<head><base href="{{asset('dash/assets/')}}"/>
		<title>{{$settings->append_name}}</title>
		<meta charset="utf-8" />
		<meta name="description" content="{{$settings->append_description}}" />
		<meta name="keywords" content="{{$settings->append_keywords}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="shortcut icon" href="{{$settings->getFirstMediaUrl('fav')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

		@if (App::getLocale() == 'ar')
			<link href="{{asset('dash/assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('dash/assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
		@else
			<link href="{{asset('dash/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('dash/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		@endif
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center">

		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url("{{asset('dash/assets/media/auth/14-2.jpg')}}"); } [data-bs-theme="dark"] body { background-image: url("{{asset('dash/assets/media/auth/bg6-dark.jpg')}}"); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{$settings->getFirstMediaUrl('logo')}}" alt="" />
						<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{$settings->getFirstMediaUrl('logoDark')}}" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">{{$settings->append_name}}</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="text-gray-600 fs-base text-center fw-semibold">{{$settings->append_description}}</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
								<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{url('loginpost')}}">
									@csrf
									<!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-dark fw-bolder mb-3">{{trans('auth.login')}}</h1>
										<!--end::Title-->
									</div>
									<!--begin::Heading-->

									<!--begin::Input group=-->
									<div class="fv-row mb-8">
										<!--begin::Email-->
										<input type="email" placeholder="{{trans('auth.email')}}" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control bg-transparent @error('email') is-invalid @enderror" />
										<!--end::Email-->

										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<!--end::Input group=-->
									<div class="fv-row mb-3">
										<!--begin::Password-->
										<input type="password" placeholder="{{trans('auth.password')}}" id="password" name="password" required autocomplete="current-password" class="form-control bg-transparent @error('password') is-invalid @enderror" />
										<!--end::Password-->

										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<!--end::Input group=-->

									<!--begin::Submit button-->
									<div class="d-grid mb-10 mt-10">
										<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
											<!--begin::Indicator label-->
											<span class="indicator-label">{{trans('auth.login_btn')}}</span>
											<!--end::Indicator label-->
											<!--begin::Indicator progress-->
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</button>
									</div>
									<!--end::Submit button-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "{{asset('dash/assets/')}}";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('dash/assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{asset('dash/assets/js/custom/authentication/sign-in/general.js')}}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->

		<script>
			var defaultThemeMode = "light"; 
			var themeMode; 
			if ( document.documentElement ) { 
				if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
					themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
				} else { 
					if ( localStorage.getItem("data-bs-theme") !== null ) { 
						themeMode = localStorage.getItem("data-bs-theme"); 
					} else { 
						themeMode = defaultThemeMode; 
					} 
				} 
				if (themeMode === "system") { 
					if ( window.matchMedia("(prefers-color-scheme: dark)").matches == "dark") {
						themeMode = "dark";
					} else {
						themeMode = "light";
					}
				} 
				document.documentElement.setAttribute("data-bs-theme", themeMode); 
			}
		</script>
	</body>
	<!--end::Body-->
</html>