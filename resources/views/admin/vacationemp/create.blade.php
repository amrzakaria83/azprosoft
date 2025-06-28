@extends('admin.layout.master')

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
                <a  href="{{route('admin.vacationemps.index')}}" class="text-muted text-hover-primary">{{trans('lang.vacation')}}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                {{trans('lang.addnew')}}
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
                <form action="{{route('admin.vacationemps.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{auth('admin')->user()->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <h1>
                            {{auth('admin')->user()->name_ar}}
                            </h1>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.vacation')}}<br><span class="text-success" id="timeDifference"></span></label>
                                    <div class="col-sm-3">
                                            <label class="required fw-semibold fs-6 mb-2">{{trans('lang.start_from')}}</label>
                                                <div class="position-relative d-flex align-items-center">
                                                    <input id="kt_datepicker_3" name="vactionfrom"  placeholder=""  class="form-control form-control-solid text-center" />
                                                </div>
                                        </div>
                                    <div class="col-sm-3">
                                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.end_to')}}</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input id="kt_datepicker_4" name="vactionto"  placeholder=""  class="form-control form-control-solid text-center" />
                                            </div>
                                    </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required"> 
                                        <span>{{trans('lang.vacation_type')}}</span>
                                </label>
                                <div class="col-sm-5 d-flex align-items-center text-center">

                                    <select  data-placeholder="Select an option" class="input-text form-control  form-select  mb-3 mb-lg-0" name="vacation_couse" id="vacation_couse" data-control="select2" >
                                    <option selected disabled>Select an option</option>
                                        @foreach (App\Models\Vacation_cause::where('status', 0)->get() as $item)
                                                <option value="{{$item->id}}">{{$item->name_ar}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-sm-4 d-flex align-items-center text-center">
                                    <button type="button" class="btn btn-success btn-lg col-3" data-bs-toggle="modal" data-bs-target="#kt_modal_1b">
                                        {{trans('lang.addnew')}} {{trans('lang.vacation_type')}}
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-6" >
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required"> 
                                        <span>{{trans('lang.vacation_payment')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center" autofocus required aria-label="Select example" id="vacationrequest" name="vacationrequest" >
                                            <option value="0">{{trans('lang.no_salary')}}</option>
                                            <option value="1">{{trans('lang.half_salary')}}</option>
                                            <option value="2">{{trans('lang.full_salary')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">Notes</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="noterequest" name="noterequest" placeholder="Notes" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center text-dark" />
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-3">{{trans('lang.attach')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="file" name="attach"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                </div>
                            </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
            <div class="">
                <div class="modal fade" tabindex="-1" id="kt_modal_1b">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" >{{trans('lang.vacation_type')}}-{{trans('lang.addnew')}}</h3>
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.vacation_causes.storemodel')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                                    @csrf
                                    
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required  fw-semibold fs-6">{{trans('lang.name_ar')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="name_ar" required placeholder="{{trans('lang.name_ar')}}" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required  fw-semibold fs-6">{{trans('lang.name_en')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="name_en" required placeholder="{{trans('lang.name_en')}}" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{trans('lang.note')}}</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="note" placeholder="{{trans('lang.note')}}" value="" class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>

@endsection

@section('script')

<script>
    $("#kt_datepicker_3").flatpickr({
        defaultDate: new Date(new Date()),  // Set day to 1 and then increase by 2 years
        enableTime: false,
        allowInput: true,
        dateFormat: "Y-m-d",
        minDate:new Date().setDate(new Date().getDate() - 5), // Previous 5 days
        });
    $("#kt_datepicker_4").flatpickr({
        defaultDate: new Date().setDate(new Date().getDate() + 1),  // Current date
        enableTime: false,
        allowInput: true,
        dateFormat: "Y-m-d",
        maxDate:new Date().setDate(new Date().getDate() + 30), // Previous day
        });

</script>

@endsection