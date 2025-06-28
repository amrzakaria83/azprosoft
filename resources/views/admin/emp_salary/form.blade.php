<div class="row mb-6">
    <label class="required col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name')}} </label>
    <div class="col-lg-8 fv-row">
        <select class="input-text form-control  form-select  mb-3 mb-lg-0"  aria-label="Select example" name="emp_salary" data-control="select2">
                <option value="" disabled selected>Select Employee</option>
                @foreach (App\Models\Employee::where('is_active', 1)->get() as $asd)
                    <option value="{{ $asd->id }}" >{{ $asd->name_ar }}</option>
                @endforeach
            </select>
    </div>
</div>

<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.value')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="value" placeholder="{{trans('lang.value')}}" value="{{old('value',$data->value ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
    </div>
</div>
<div class="row mb-6" >
    <label class="col-lg-2 col-form-label fw-semibold fs-6">
        <span class="required"> 
            <span>{{trans('lang.type_type')}} {{trans('lang.salary')}}</span>
    </label>
    <div class="col-sm-3 d-flex align-items-center text-center">
        <select class="form-select text-center" autofocus required aria-label="Select example" id="type" name="type" >
                <option value="0">{{trans('lang.perhour')}}</option>
                <option value="1">{{trans('lang.total')}}</option>
        </select>
    </div>
</div>


<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.note')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="note" placeholder="{{trans('lang.note')}}" note="{{old('note',$data->note ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
