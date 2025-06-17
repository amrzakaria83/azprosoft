<div class="row">
    <div @if (isset($data) && $data->id == 1) class="col-lg-6" @else class="col-lg-12" @endif>

        <div class="row mb-6">
            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                <span class="required">المرفقات</span>
            </label>
            <div class="col-lg-8 fv-row">
                <input type="file" name="photo"  accept=".png, .jpg, .jpeg, .mp4, .pdf, .doc, .docx, .xlsx" class="form-control form-control-lg form-control-solid" />
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                <span class="required">ارسال الى</span>
            </label>
            <div class="col-sm-3 d-flex align-items-center">
                <select class="form-select" autofocus required aria-label="Select example" id="receiver_id" name="receiver_id[]" multiple="multiple"  data-control="select2">
                    @foreach (\App\Models\Employee::where('is_active', 1)->get() as $item)
                    <option value="{{$item->id}}">{{$item->name_ar}}</option>
                    @endforeach

                </select>
            </div>
            <label class="col-lg-2 col-form-label fw-semibold fs-6">
                <span class="text-center align-items-center">متابعة</span>
            </label>
            <div class="col-sm-3 d-flex align-items-center">
                <select class="form-select" autofocus  aria-label="Select example" id="report_to" name="report_to[]" multiple="multiple"  data-control="select2">
                    @foreach (\App\Models\Employee::where('is_active', 1)->get() as $item)
                    <option value="{{$item->id}}">{{$item->name_ar}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <!-- multiple="multiple"  data-control="select2" -->
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label required fw-semibold fs-6">محتوى الرسالة</label>
            <div class="col-lg-10 fv-row">
                <textarea name="description" id="kt_docs_tinymce_basic">
                    {{old('description',$data->description ?? '')}}
                </textarea>
            </div>
        </div>

    </div>
</div>

<script src="{{ URL::asset('dash/assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>

<script>
    var options = {selector: "#kt_docs_tinymce_basic,#kt_docs_tinymce_basic2,#kt_docs_tinymce_basic3,#kt_docs_tinymce_basic4"};

    tinymce.init(options);

</script>
