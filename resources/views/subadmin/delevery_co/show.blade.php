@extends('subadmin.layout.master')

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
            <a href="{{route('subadmin.employees.index')}}" class="text-muted text-hover-primary">الموظفين</a>
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
                <div class="row mb-8">

                    <div class="col-lg-8">
                            {{-- @foreach ($deliveryCustomerIds as $delCode => $deliveryCustomerIds)
                                <div class="col-sm-4 p-3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="text-gray-600 fw-bold">Del Code: {{ $delCode }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul>
                                                @foreach ($deliveryCustomerIds as $deliveryCustomerId)
                                                    <li>{{ $deliveryCustomerId }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach --}}
                        <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table10">
                            <!--begin::Table head-->
                            <thead class="bg-light-dark pe-3">
                                <!--begin::Table row-->
                                <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                    <th class="max-w-10px text-start">الطيار</th>
                                    <th class="max-w-20px text-start">العملاء</th>
                                    <th class="max-w-20px text-start">الاجراء</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>

                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <div class="col-sm-4 p-3">

                                    <tbody class="text-gray-600 fw-bold">

                                    </tbody>
                            </div>
                            <!--end::Table body-->
                        </table>
                    </div>
                </div>

            </div>
    </div>
</div>

@endsection

@section('script')
@endsection
