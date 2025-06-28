<div class="row mb-6">
    <label class="required col-lg-2 col-form-label  fw-semibold fs-6">{{trans('lang.name')}} </label>
    <div class="col-lg-8 fv-row">
        <select class="input-text form-control  form-select  mb-3 mb-lg-0"  aria-label="Select example" name="emp_action_id" data-control="select2">
                <option value="" disabled selected>Select Employee</option>
                @foreach (App\Models\Employee::where('is_active', 1)->get() as $asd)
                    <option value="{{ $asd->id }}" >{{ $asd->name_ar }}</option>
                @endforeach
            </select>
    </div>
</div>


<div class="row mb-6" >
    <label class="col-lg-2 col-form-label fw-semibold fs-6">
        <span class="required"> 
            <span>{{trans('lang.type_type')}} </span>
    </label>
    <div class="col-sm-3 d-flex align-items-center text-center">
        <select class="form-select text-center" autofocus required aria-label="Select example" id="type" name="type" >
                <option value="" >{{trans('lang.select')}}</option>
                <option value="0" class="bg bg-danger">{{trans('lang.penalties')}}</option>
                <option value="1" class="bg bg-success">{{trans('lang.rewards')}}</option>
        </select>
    </div>
    <div class="col-sm-3 d-flex align-items-center text-center">
        <select class="form-select text-center" autofocus required aria-label="Select example" id="type_action" name="type_action" >
                <option value="" >{{trans('lang.select')}}</option>
                <option value="0" >{{trans('lang.days')}}</option>
                <option value="1" >{{trans('lang.value')}}</option>
        </select>
    </div>
</div>
<div class="row mb-6" id="daysrow">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.days')}}</label>
    <div class="col-lg-3 fv-row">
        <input type="number" min="0" max="30" name="no_days" placeholder="{{trans('lang.days')}}" value="{{old('no_days',$data->no_days ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
    </div>
</div>

<div class="row mb-6" id="valuerow">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.value')}}</label>
    <div class="col-lg-3 fv-row">
        <input type="text" name="value" min="0" placeholder="{{trans('lang.value')}}" value="{{old('value',$data->value ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
        <select  data-placeholder="Select an option" class="newstype input-text form-control  form-select  mb-3 mb-lg-0 text-center"  name="status">
                <option value="0" @if(isset($data) && $data->status == "0") selected @endif>{{trans('lang.active')}}</option>
                <option value="1" @if(isset($data) && $data->status == "1") selected @endif>{{trans('lang.inactive')}}</option>
                <option value="2" @if(isset($data) && $data->status == "2") selected @endif>{{trans('lang.done')}}</option>

            </select>
        </div>
    </div>
</div>
