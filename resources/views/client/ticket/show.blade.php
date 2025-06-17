@extends('client.layout.master')

@section('css')
    
@endsection

@section('style')
    
@endsection

@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">البروفايل </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{url('dashboard')}}" class="text-muted text-hover-primary">لوحة التحكم</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">البروفايل</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
</div>
@endsection

@section('content')

<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card">


            <div class="card-body p-9">

                <table class="table mb-0">

			        <tbody>

                    <tr>
                        <td class="col-4 text-start" style="border: none;"><h2>{{Auth::user()->company_name}}</h2></td>
                        <td class="col-4" style="border: none;"></td>
                        <td class="col-4 text-start" style="border: none;">{!! DNS1D::getBarcodeSVG((string)$data["barcode"], 'C128',2,33,'black', false)!!}</td>
                    </tr>
                    <tr>
                        <td class="col-4 text-start" style="border: none;"><span class="">اسم المشروع : <span class="fs-5">{{$data['project']}}</span></span></td>
                        <td class="col-4" style="border: none;"></td>
                        <td class="col-4 text-start" style="border: none;"><span class="">التاريخ : <span class="fs-5">{{$data['date']}}</span></span></td>
                    </tr>
                
                    <tr>
                        <td class="col-4 text-start" style="border: none;"><span class="">نوع الرد : <span class="fs-5">{{$data['name_rd']}}</span></span></td>
                        <td class="col-4" style="border: none;"></td>
                        <td class="col-4 text-start" style="border: none;"><span class="">سعر الرد : <span class="fs-5">{{$data['price_rd']}}</span></span></td>
                    </tr>
                    <tr>
                        <td class="col-4 text-start" style="border: none;"><span class=""> رقم السند : <span class="fs-5">{{$data['barcode']}}</span></span></td>
                        <td class="col-4" style="border: none;"></td>
                        <td class="col-4 text-start" style="border: none;"><span class=""> رقم السيارة : <span class="fs-5"></span></span></td>
                    </tr>
                    <tr>
                        <td class="col-4 text-start" style="border: none;"><span class=""> اسم المؤسسة : <span class="fs-5"></span></span></td>
                        <td class="col-4" style="border: none;"></td>
                        <td class="col-4 text-start" style="border: none;"><span class="" > توقيع المراقب : <span class="fs-5"></span></span></td>
                    </tr>
              
            </tbody>

          </table>
        </div>

            </div>

    </div>
</div>

@endsection

@section('script')
@endsection