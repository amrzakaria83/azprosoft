@extends('subadmin.layout.master')

@section('css')

@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/subadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('subadmin.drug_requests.index')}}" class="text-muted text-hover-primary">طلبات التحويل</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                اضف جديد
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
                <form action="{{route('subadmin.drug_requests.importstore')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <input type="hidden" name="data" value="{{$data}}"/>

                        <div class="row mb-6">
                            <div class="col-sm-3  ">
                                <label for="fromit">اسم الصيدلية المراد التحويل منها</label>
                                        <select class="form-select" autofocus required aria-label="Select example" id="fromit" name="start_id" >
                                            <option value="">اسم الصيدلية المراد التحويل منها</option>
                                            @foreach ($sites as $key => $asd)
                                                        <option value="{{ $asd->id }}">{{ $asd->name }}</option>
                                                        @endforeach
                                        </select>
                                        <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('subadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />

                            </div>
                            <div class="col-sm-3  ">
                                        <label for="toit">اسم الصيدلية المراد التحويل اليها</label>
                                    <select class="form-select" autofocus required aria-label="Select example" id="toit" name="to_id" >
                                        <option value="">اسم الصيدلية المراد التحويل اليها</option>
                                        @foreach ($sites as $key => $asd)
                                                    <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td @class(['p-4', 'font-bold' => true])>كود الصنف</td>
                                <td>
                                    <select class="form-select" required name="product_code">
                                        <option value="">برجاء اختيار كود الصنف</option>
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true]) >الكمية</td>
                                <td>
                                <select class="form-select" required autofocus name="quantity" style="background-color: rgba(224, 124, 254, 0.329)">
                                    <option disabled selected >برجاء اخنيار الكمية </option>
                                    @foreach ($data[0] as $key => $item)

                                        <option value="{{$key}}">{{$key}}</option>

                                    @endforeach
                                </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])> ملاحظات</td>
                                <td>
                                <select name="note">
                                    @foreach ($data[0] as $key => $item)
                                        <option value="{{$key}}">{{$key}}</option>
                                    @endforeach
                                </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')

@endsection
