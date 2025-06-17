@extends('admin.layout.master')

@php
    $route = 'admin.bill_sale_headers';
    $viewPath = 'admin.bill_sale_header';
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

                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_tabletittle">
                            <!--begin::Table head-->
                            <thead class="bg-light-dark pe-3">
                                <!--begin::Table row-->
                                <tr class="text-start text-dark fw-bold fs-4 text-uppercase gs-0">
                                    <th class="min-w-125px text-start text-center">نوع الفاتورة</th>
                                    <th class="min-w-125px text-start text-center">ال{{trans('lang.customer')}}</th>
                                    <th class="min-w-125px text-start text-center">الخصم</th>
                                    <th class="min-w-125px text-start text-center">الاجمالى</th>
                                    
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold text-center">
                                <tr>
                                    <td class="text-center">
                                        <select class="form-select text-center d-flex" autofocus  aria-label="Select example"  
                                            data-allow-clear="false" id="type_receipt" value="" name="type_receipt" >
                                                <option value="0">كاش</option>
                                                <option value="2">توصيل</option>
                                                <option value="3">Visa</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                    <select class="form-select text-center cust_id" autofocus  aria-label="Select example" data-control="select2"
                                        data-allow-clear="false"  id="cust_id" value="" name="cust_id" >
                                        <option value="">برجاء اختيار ال{{trans('lang.customer')}}</option>
                                            @foreach (\App\Models\Azcustomer::where('status' , 0)->get() as $contac)
                                                <option value="{{$contac->id}}"data-phone="{{$contac->phone}}" 
                                                data-phone1="{{$contac->phone1}}" 
                                                >{{$contac->name_ar}}</option>
                                            @endforeach
                                    </select>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" id="extra_discount" name="extra_discount" placeholder="" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center text-dark sm-success" />
                                    </td>
                                    <td class="text-center">
                                        <span class="fs-3 text-info" id="total_value"></span>  
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                            </table>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{trans('lang.save')}}</button>
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
@endsection