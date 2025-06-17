@extends('subadmin.layout.master')

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
            <h1 id="codeinsite">{{ session()->get('insite')}}</h1>
        </div>
        <div class="card-body">
            <div id="kt_apexcharts_1" ></div>
                            {{-- <div class="container text-center " id="">
                                    <div class="row align-items-start">
                                        <h1>طلب دليفرى</h1>
                                        <div class="col-sm-3  ">
                                            <a href="http://127.0.0.1:8000/subadmin/tranph_requests/create" target="_blank" >
                                            <button type="button" class="btn btn-danger btn-lg container" onclick="">طلب تحويل صيدلية</button>
                                            </a>
                                        </div>
                                        <div class="col-sm-3  ">
                                            <a href="http://127.0.0.1:8000/subadmin/orderphs/create" target="_blank" >
                                            <button type="button" class="btn btn-success btn-lg container" onclick="">توصيل اوردر صيدلية </button>
                                            </a>
                                        </div>
                                        <div class="col-sm-2  ">
                                            <a href="" target="_blank" >
                                            <button type="button" class="btn btn-primary btn-lg container" onclick="">صرف تحويل من صيدلية</button>
                                            </a>
                                        </div>
                                        <div class="col-sm-1  ">
                                            <a href="" target="_blank" >
                                            <button type="button" class="btn btn-dark btn-lg container" onclick="">طلب خاص </button>
                                            </a>
                                        </div>
                                        <div class="col-sm-1  ">
                                            <a href="" target="_blank" >
                                            <button type="button" class="btn btn-warning btn-lg container" onclick="">تسجيل حضور </button>
                                            </a>
                                        </div>
                                        <div class="col-sm-1  ">
                                            <a href="" target="_blank" >
                                            <button type="button" class="btn btn-info btn-lg container" onclick="">تسجيل انصراف </button>
                                            </a>
                                        </div>
                                        </div>
                                <div class="separator border-danger my-10">
                                </div>
                                <div class="row align-items-start" >
                                    <h1>حركة دليفرى</h1>
                                    <div class="col-sm-3  ">
                                        <a href="http://127.0.0.1:8000/subadmin/tranph_requests" target="_blank" >
                                        <button type="button" class="btn btn-danger btn-lg container" onclick="">تسكين تحويل صيدلية </button>
                                        </a>
                                    </div>
                                    <div class="col-sm-3  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-success btn-lg container" onclick="">تسكين اوردر صيدلية </button>
                                        </a>
                                    </div>
                                    <div class="col-sm-2  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-primary btn-lg container" onclick="">تسكين دليفرى توصيل </button>
                                        </a>
                                    </div>
                                    <div class="col-sm-2  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-secondary  btn-lg container" onclick="">تثبيت دليفرى </button>
                                        </a>
                                    </div>

                                    <div class="col-sm-1  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-dark btn-lg container" onclick="">تسكين طلب خاص </button>
                                        </a>
                                    </div>

                                </div>
                                <div class="separator border-danger my-10"></div>
                                <div class="row align-items-start" >
                                    <h1>اخرى</h1>
                                    <div class="col-sm-2  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-warning  btn-lg container" onclick="">اضافة عميل توصيل</button>
                                        </a>
                                    </div>
                                    <div class="col-sm-2  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-danger  btn-lg container" onclick="">اذن طيار</button>
                                        </a>
                                    </div>
                                    <div class="col-sm-2  ">
                                        <a href="http://127.0.0.1:8000/subadmin/sites/create" target="_blank" >
                                        <button type="button" class="btn btn-warning  btn-lg container" onclick="">اضافة مخزن</button>
                                        </a>
                                    </div>

                                    <div class="col-sm-1  ">
                                        <a href="" target="_blank" >
                                        <button type="button" class="btn btn-warning  btn-lg container" onclick=""></button>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
     </div>
 </div>

@endsection

                        @section('script')
                        <script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
                        <script>

                        </script>
                        @endsection
