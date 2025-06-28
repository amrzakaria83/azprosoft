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
                {{trans('lang.editview')}}
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
                <form action="{{route('admin.vacationemps.update')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <h1>
                        
                            {{$data->getemp->name_en}}
                            </h1>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.vacation')}}<br><span class="text-success" id="timeDifference"></span></label>
                                    <div class="col-sm-3">
                                            <label class="required fw-semibold fs-6 mb-2">{{trans('lang.start_from')}}</label>
                                                <div class="position-relative d-flex align-items-center">
                                                    <input id="kt_datepicker_3" name="vactionfrommanger"  placeholder="" value="{{$data->vactionfrom}}"  class="form-control form-control-solid text-center" />
                                                </div>
                                        </div> 
                                    <div class="col-sm-3">
                                        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.end_to')}}</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input id="kt_datepicker_4" name="vactiontomanger"  placeholder="" value="{{$data->vactionto}}"  class="form-control form-control-solid text-center" />
                                            </div>
                                    </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.note')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="noterequest" name="noterequest" readonly placeholder="Notes employee" value="{{$data->noterequest}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center text-dark" />
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">{{trans('lang.vacation_type')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center" disabled autofocus required aria-label="Select example" id="vacation_couse" name="vacation_couse" >
                                    @foreach (App\Models\Vacation_cause::where('status', 0)->get() as $item)
                                        <option value="{{$item->id}}"  @if($data->vacation_couse == $item->id) selected @endif >{{$item->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <!-- </div>
                            <div class="row mb-6"> -->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">{{trans('lang.vacation_payment')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center" disabled autofocus required aria-label="Select example" id="vacationrequest" name="vacationrequest" >
                                        <option value="0" @if($data->vacationrequest == '0') selected disabled @endif >{{trans('lang.no_salary')}}</option>
                                        <option value="1" @if($data->vacationrequest == '1') selected disabled @endif >{{trans('lang.half_salary')}}</option>
                                        <option value="2" @if($data->vacationrequest == '2') selected disabled @endif >{{trans('lang.full_salary')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">{{trans('lang.director')}}-{{trans('lang.status')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center"  autofocus required aria-label="Select example" id="statusmangeraprove" name="statusmangeraprove" >
                                        <option value="0" @if($data->statusmangeraprove == '0') selected  @endif >{{trans('lang.waiting')}}-{{trans('lang.approved')}}</option>
                                        <option value="1" @if($data->statusmangeraprove == '1') selected  @endif >{{trans('lang.approved')}}</option>
                                        <option value="2" @if($data->statusmangeraprove == '2') selected  @endif >{{trans('lang.reject')}}</option>
                                        <option value="3" @if($data->statusmangeraprove == '3') selected  @endif >{{trans('lang.delay')}}</option>
                                    </select>
                                </div>
                                
                            <!-- </div>
                            <div class="row mb-6"> -->
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">{{trans('lang.vacation_payment')}}-{{trans('lang.action')}}</span>
                                </label>
                                <div class="col-sm-3 d-flex align-items-center text-center">
                                    <select class="form-select text-center" autofocus required aria-label="Select example" id="typevacation" name="typevacation" >
                                            <option value="0" @if($data->typevacation == '0') selected  @endif >{{trans('lang.no_salary')}}</option>
                                            <option value="1" @if($data->typevacation == '1') selected  @endif >{{trans('lang.half_salary')}}</option>
                                            <option value="2" @if($data->typevacation == '2') selected  @endif >{{trans('lang.full_salary')}}</option>
                                        </select>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.note')}} {{trans('lang.director')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="notemanger" name="notemanger" placeholder="Director's note" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center text-dark" />
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
        </div>
    </div>

@endsection

@section('script')

<script>
        $("#kt_datepicker_3").flatpickr({
                        enableTime: false,
                        allowInput: true,
                        dateFormat: "Y-m-d",
                        });
        $("#kt_datepicker_4").flatpickr({
                        enableTime: false,
                        allowInput: true,
                        dateFormat: "Y-m-d",
                        });

</script>

<script>
    $('#dynamic_work').on('change', function() {
        if (this.value === 1) {

            }    })

    </script>
@endsection