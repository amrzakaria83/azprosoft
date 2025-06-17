@extends('admin.layout.master')

@section('css')
<link href="{{asset('dash/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>

@endsection

@section('style')

@endsection

@section('breadcrumb')

@endsection

@section('content')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card card-bordered">
        <div class="card-header py-5">
            {{-- <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">تقرير الشركات</span>
                <span class="text-gray-400 mt-1 fw-semibold fs-6">الشركات المسجلة خلال عام</span>
            </h3> --}}
            <h1 id="codeinsite">{{ session()->get('insite')}}</h1>
            {{-- <a href="" target="-blank">
                <button type="button" class="btn btn-danger btn-lg container" onclick="">!!</button>
                </a> --}}

        </div>
        <div class="card-body">
            <div id="kt_apexcharts_1" ></div>
            
        </div>
     </div>
 </div>

@endsection

@section('script')
    <script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
@endsection
