@extends('superadmin.layout.master')

@section('css')

@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('superadmin.azcustomers.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <form action="{{route('superadmin.azcustomers.importstore')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf

                    <input type="hidden" name="data" value="{{$data}}"/>
                    <!--begin::Card body-->
                    <div class="card-body  p-9">

                        <table>
                            <tr>
                                <td @class(['p-4', 'font-bold' => true])>كود العميل</td>
                                <td>
                                    <select name="cust_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true]) > اسم العميل عربى</td>
                                <td>
                                    <select name="name_ar">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])> اسم العميل انجليزى</td>
                                <td>
                                    <select name="name_en">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td @class(['p-4', 'font-bold' => true])>1 رقم التليفون  </td>
                                <td>
                                    <select name="phone1">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])>2 رقم التليفون  </td>
                                <td>
                                    <select name="phone2">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td @class(['p-4', 'font-bold' => true])>العنوان 1</td>
                                <td>
                                    <select name="address1">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])>العنوان 2</td>
                                <td>
                                    <select name="address2">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])>العنوان 3</td>
                                <td>
                                    <select name="address3">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])>العنوان 4</td>
                                <td>
                                    <select name="address4">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td @class(['p-4', 'font-bold' => true])>العنوان 5</td>
                                <td>
                                    <select name="address5">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td @class(['p-4', 'font-bold' => true])> ملاحظات</td>
                                <td>
                                    <select name="note">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])> طريقة الدفع</td>
                                <td>
                                    <select name="payment">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])> طبيعة العميل </td>                            <td>
                                    <select name="cust_nature">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td @class(['p-4', 'font-bold' => true])> حد الائتمان </td>                            <td>
                                    <select name="delay_value_max">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
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
