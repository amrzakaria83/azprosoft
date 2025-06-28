<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.name_ar')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="name_ar" placeholder="{{trans('lang.name_ar')}}" value="{{old('name_ar',$data->name_ar ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
    </div>
</div>
<div class="row mb-6">
    <label class="col-lg-2 col-form-label fw-semibold fs-6">{{trans('lang.name_en')}}</label>
    <div class="col-lg-8 fv-row">
        <input type="text" name="name_en" placeholder="{{trans('lang.name_en')}}" value="{{old('name_en',$data->name_en ?? '')}}" class="text-center form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
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
