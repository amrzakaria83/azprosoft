
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
    Launch demo modal
</button>

<div class="modal fade" tabindex="-1" id="kt_modal_1" >
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="">
        @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">تأكيد التنفيذ</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <input type="number" placeholder="please insert your code" id="emp_code" name="emp_code" value="" required autocomplete="email" autofocus class="form-control bg-transparent @error('emp_code') is-invalid @enderror" />

                <div class="col-sm-4">
                    <label for="emp_name_ar">اسم صاحب الحركة</label>
                    <h1 id="emp_name_ar" style="border-style: double; text-align:center"  >
                        اسم صاحب الحركة
                    </h1>
                </div>
                <!--end::Email-->

                @error('emp_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-3">
                <!--begin::Password-->
                <input type="password" placeholder="" id="password" name="password" required autocomplete="current-password" class="form-control bg-transparent @error('password') is-invalid @enderror" />

                <!--end::Password-->

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    </form>
</div>
<script src="{{asset('dash/assets/js/custom/authentication/sign-in/general.js')}}"></script>
