<div class="row mb-6">
    <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.permission_att')}}<br><span class="text-success" id="timeDifference"></span></label>
        <div class="col-sm-3">
                <label class="required fw-semibold fs-6 mb-2">{{trans('lang.start_from')}}</label>
                    <div class="position-relative d-flex align-items-center">
                        <input id="kt_datepicker_3" name="attendance_out_from"  placeholder=""  class="form-control form-control-solid text-center" />
                    </div>
            </div>
        <div class="col-sm-3">
            <label class="required fw-semibold fs-6 mb-2">{{trans('lang.end_to')}}</label>
                <div class="position-relative d-flex align-items-center">
                    <input id="kt_datepicker_4" name="attendance_in_to"  placeholder=""  class="form-control form-control-solid text-center" />
                </div>
        </div>
</div>

<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.note')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="noterequest" placeholder="{{trans('lang.note')}}" value="{{old('note',$data->note ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
    </div>
</div>
<div class="row mb-6" >
    <label class="col-lg-2 col-form-label fw-semibold fs-6">
        <span class="required"> 
            <span>{{trans('lang.type_type')}} {{trans('lang.permission_att')}}</span>
    </label>
    <div class="col-sm-3 d-flex align-items-center text-center">
        <select class="form-select text-center" autofocus required aria-label="Select example" id="emp_att_request" name="emp_att_request" >
                <option value="0" @if(isset($data) && $data->emp_att_request == "0") selected @endif>{{trans('lang.no_salary')}}</option>
                <option value="1" @if(isset($data) && $data->emp_att_request == "1") selected @endif>{{trans('lang.half_salary')}}</option>
                <option value="2" @if(isset($data) && $data->emp_att_request == "2") selected @endif>{{trans('lang.full_salary')}}</option>
        </select>
    </div>
</div>


<div class="fv-row mb-6">
    <div class="form-check form-switch form-check-custom form-check-solid">
        <label class="col-lg-2 form-check-label required fw-semibold fs-6" for="flexSwitchDefault">{{trans('lang.status')}}</label>
        <div class="col-lg-8 fv-row">
        <select  data-placeholder="Select an option" class="newstype input-text form-control  form-select  mb-3 mb-lg-0"  name="status">
                <option value="0" @if(isset($data) && $data->status == "0") selected @endif>{{trans('lang.active')}}</option>
                <option value="1" @if(isset($data) && $data->status == "1") selected @endif>{{trans('lang.inactive')}}</option>

            </select>
        </div>
    </div>
</div>
