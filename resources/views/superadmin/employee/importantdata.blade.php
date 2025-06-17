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
                <a  href="{{route('superadmin.employees.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <form action="{{route('superadmin.employees.importstore')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf

                    <input type="hidden" name="data" value="{{$data}}"/>
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <table>
                            <tr>
                                <td>كود الموظف</td>
                                <td>
                                    <select name="emp_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>del_code</td>
                                <td>
                                    <select name="del_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        <tr>
                            <td>الاسم عربى</td>
                            <td>
                                <select name="name_ar">
                                    @foreach ($data[0] as $key => $item)
                                        <option value="{{$key}}">{{$key}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <td>الاسم انجليزى</td>
                                <td>
                                    <select name="name_en">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>التليفون</td>
                                <td>
                                    <select name="phone">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>1التليفون</td>
                                <td>
                                    <select name="phone1">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>2التليفون</td>
                                <td>
                                    <select name="phone2">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>emailaz</td>
                                <td>
                                    <select name="emailaz">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>كلمة السر</td>
                                <td>
                                    <select name="password">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>الرقم القومى</td>
                                <td>
                                    <select name="national_no">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>birth_date</td>
                                <td>
                                    <select name="birth_date">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>work_date</td>
                                <td>
                                    <select name="work_date">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                    <td>1العنوان</td>
                                    <td>
                                        <select name="address1">
                                            @foreach ($data[0] as $key => $item)
                                                <option value="{{$key}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                            </tr>
                            <tr>
                                <td>2العنوان</td>
                                <td>
                                    <select name="address2">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>3العنوان</td>
                                <td>
                                    <select name="address3">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>is_active</td>
                                <td>
                                    <select name="is_active">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>acc_bank_no</td>
                                <td>
                                    <select name="acc_bank_no">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>salary_id</td>
                                <td>
                                    <select name="salary_id">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>bank_code</td>
                                <td>
                                    <select name="bank_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>jobs_code</td>
                                <td>
                                    <select name="jobs_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>gender</td>
                                <td>
                                    <select name="gender">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>type</td>
                                <td>
                                    <select name="type">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>role_code</td>
                                <td>
                                    <select name="role_code">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>collect_m</td>
                                <td>
                                    <select name="collect_m">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>method_for_payment</td>
                                <td>
                                    <select name="method_for_payment">
                                        @foreach ($data[0] as $key => $item)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>azcustomers_id_old</td>
                                <td>
                                    <select name="azcustomers_id_old">
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
