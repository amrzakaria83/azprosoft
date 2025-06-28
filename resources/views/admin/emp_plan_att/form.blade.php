
{{-- <div class="fv-row mb-6">
    <div class="form-check form-switch form-check-custom form-check-solid">
        <label class="col-lg-2 form-check-label required fw-semibold fs-6" for="flexSwitchDefault">{{trans('lang.status')}}</label>
        <div class="col-lg-8 fv-row">
        <select  data-placeholder="Select an option" class="newstype input-text form-control  form-select  mb-3 mb-lg-0"  name="coutnt_shift">
                <option value="0" @if(isset($data) && $data->coutnt_shift == "0") selected @endif>1</option>
                <option value="1" @if(isset($data) && $data->coutnt_shift == "1") selected @endif>2</option>
                <option value="2" @if(isset($data) && $data->coutnt_shift == "2") selected @endif>3</option>

            </select>
        </div>
    </div>
</div> --}}

<div class="row mb-6">
    <label class="col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.work_hours')}}<br><span class="text-success" id="timeDifference"></span></label>
    <div class="col-sm-3">
            <label class="required fw-semibold fs-6 mb-2">{{trans('lang.in_attendance')}}</label>
                <div class="position-relative d-flex align-items-center">
                    <input id="kt_datepicker_3" name="attendance_in_at"  placeholder="" value="{{old('attendance_in_at',$data->attendance_in_at ?? '')}}" class="form-control form-control-solid text-center" type="time" />
                </div>
        </div>
    <div class="col-sm-3">
        <label class="required fw-semibold fs-6 mb-2">{{trans('lang.out_attendance')}}</label>
            <div class="position-relative d-flex align-items-center">
                <input id="kt_datepicker_4" name="attendance_out_at"  placeholder="" value="{{old('attendance_out_at',$data->attendance_out_at ?? '')}}" class="form-control form-control-solid text-center" type="time" />
            </div>
    </div>
</div>
<div class="row mb-6">
    <label class="required col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name')}} </label>
    <div class="col-lg-8 fv-row">
        <select class="input-text form-control  form-select  mb-3 mb-lg-0"  aria-label="Select example" name="emp_plan_att" data-control="select2">
                <option value="" disabled selected>Select Employee</option>
                @foreach (App\Models\Employee::where('is_active', 1)->get() as $asd)
                    <option value="{{ $asd->id }}" @if (isset($data) && $data->emp_plan_att == $asd->id) selected @endif>{{ $asd->name_ar }}</option>
                @endforeach
            </select>
    </div>
</div>
<div class="row mb-6">
        <label class="col-lg-2 col-form-label required  fw-semibold fs-6">{{trans('lang.weekly_dayoff')}}</label>
        <div class="col-lg-8 fv-row">
            <select  data-placeholder="Select an option" class="input-text form-control  form-select  mb-3 mb-lg-0" name="weekly_dayoff[]" id="weekly_dayoff" data-allow-clear="true"  multiple="multiple" data-control="select2" >
            <option value="6" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(6, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.saturday')}}</option>
            <option value="0" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(0, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.sunday')}}</option>
            <option value="1" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(1, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.monday')}}</option>
            <option value="2" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(2, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.tuesday')}}</option>
            <option value="3" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(3, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.wednesday')}}</option>
            <option value="4" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(4, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.thursday')}}</option>
            <option value="5" @if (isset($data) && !empty($data->weekly_dayoff) && in_array(5, json_decode($data->weekly_dayoff))) selected @endif>{{trans('lang.friday')}}</option>
            </select>
        </div>
    </div>
<div class="row mb-6">
    <label class="required col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.work_location')}} </label>
    <div class="col-lg-8 fv-row">
        <select class="input-text form-control  form-select  mb-3 mb-lg-0"  aria-label="Select example" name="work_loct_id" data-control="select2">
                <option value="" disabled selected>Select {{trans('lang.work_location')}}</option>
                @foreach (App\Models\Work_location::where('status', 0)->get() as $asd)
                    <option value="{{ $asd->id }}" @if (isset($data) && $data->work_loct_id == $asd->id) selected @endif>{{ $asd->name_ar }}</option>
                @endforeach
            </select>
    </div>
</div>
<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.note')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="note" placeholder="{{trans('lang.note')}}" value="{{old('note',$data->note ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
