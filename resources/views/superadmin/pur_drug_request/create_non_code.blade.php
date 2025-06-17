@extends('superadmin.layout.master')

@section('css')
<link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('superadmin.pur_drug_requests.index')}}" class="text-muted text-hover-primary">'طلب ادوية من صيدلية'</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                اضف جديد
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid" >
        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_docs_repeater_basic">
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{route('superadmin.pur_drug_requests.store_non_code')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <h1 class="text-info">هذه الصفحة مخصصة فقط للاصناف الغير مكودة</h1>
                        <div class="row mb-6">
                                    <div class="col-sm-3  ">
                                        <label for="toit">الصيدلية طالبة الصنف</label>
                                    <select class="form-select" autofocus required aria-label="Select example" id="toit" name="start_id" >
                                        <option disabled selected>الصيدلية طالبة الصنف</option>
                                        @foreach ($sites as $asd)
                                                    <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                    @endforeach
                                    </select>
                                    </div>
                                <div class="col-sm-6">
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="note1" placeholder="اسم العميل" value="" class="form-control form-control-lg form-control mb-3 mb-lg-0" required/>
                                        <input type="tel" name="note2" placeholder="رقم تليفون " value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    </div>
                                </div>
                                <div class="col-sm-3  ">
                                    <label for="type_request">طبيعة الطلب</label>
                                <select class="form-select text-center text-danger fs-3" autofocus required aria-label="Select example" id="type_request" name="type_request" >
                                    <option value="">اختر طبيعة الطلب</option>
                                    <option value="0">cash</option>
                                    <option value="1">phone</option>
                                    <option value="2">whatsapp</option>
                                    <option value="3">page</option>

                                </select>
                                </div>
                                <div class="col-lg-2 fv-row">
                                    <input type="text" name="note" placeholder=" ملاحظات" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                </div>
                            </div>
                    </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-3">
                                <label for="product_code">اسم الصنف بالانجليزية</label>
                                <input type="text" id="product_name_en" name="product_name_en" placeholder="اسم الصنف بالانجليزية" value="" class="form-control form-control-lg form-control-solid" required />
                            </div>
                            <div class="col-sm-3">
                                <label for="product_code">اسم الصنف بالعربية</label>
                                <input type="text" id="product_name_ar" name="product_name_ar" placeholder="اسم الصنف بالعربية" value="" class="form-control form-control-lg form-control-solid" required />
                            </div>
                            <div class="col-sm-1">
                                <label for="quantity">الكمية المطلوبة</label>
                                <input type="number" id="quantity" name="quantity" value="1" class="form-control form-control-lg form-control-solid" required style="text-align: center;background-color: #6d9eff;" required />
                            </div>
                            {{-- <div class="row mb-6">
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">صورة الصنف</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('dash/assets/media/avatars/blank.png')}})"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>

                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div> --}}
                            </div>
                            <div class="row mb-6">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6  " id="kt_datatable_table">
                    <!--begin::Table head-->
                    <thead class="bg-light-dark pe-1">
                        <!--begin::Table row-->
                        <tr class="text-start text-dark fw-bold fs-4 text-uppercase gs-0">
                            <th class="w-10px p-3">
                                <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-20px text-start">اسم العميل</th>
                            <th class="min-w-20px text-start">رقم العميل</th>
                            <th class="min-w-20px text-start">اسم الصنف</th>
                            <th class="min-w-10px text-start">الكمية</th>
                            <th class="min-w-10px text-start">الحالة</th>
                            <th class="min-w-10px text-start">الرد</th>
                            <th class="min-w-20px text-start">الوقت</th>
                            <th class="min-w-20px text-start">ملاحظات</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-bold">
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
    $('#product_code').keyup(function (e) {
        if ((e.keyCode || e.which) == 39) {
            var product_code =  $("#product_code").val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{ url('superadmin/pur_drug_requests/getprod')}}",
                data: {"product_code": product_code},
                success: function (data) {
                    console.log(data.data.product_name_en);
                    $("#product_name_en").html(data.data);}});};});

    $('.itemName').select2({
        placeholder: 'Select an item',
        minimumInputLength: 3,
        ajax: {
            type: "GET",
            url: '{{ url('superadmin/pur_drug_requests/ProdName')}}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.product_name_en,
                        id: item.product_code,
                    }})}},cache: true}});

    $('.itemName').change(function() {

        var proName = $('#itemName').find(":selected").text();
        var proValue = $('#itemName').find(":selected").val();
        $("#product_name_en").html(proName);
        $("#product_code").val(proValue);
    })
</script>
<script>
$(function () {

var table = $('#kt_datatable_table').DataTable({
    processing: false,
    serverSide: true,
    searching: false,
    autoWidth: true,
    responsive: true,
    pageLength: 20,
    sort: false,
    dom: 'Bfrtip',
    buttons: [
        // {
        //     extend: 'print',
        //     className: 'btn btn-primary',
        //     text: 'طباعه'
        // },
        // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
        // {
        //     extend: 'excel',
        //     className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
        //     text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
        // },
        //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
    ],
    ajax: {
        url: "{{ route('superadmin.pur_drug_requests.index_store_non_code') }}",
        data: function (d) {
            d.toit = $('#toit').find(":selected").val()
            // d.search = $('#search').val()

        },
    },
    columns: [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'note1', name: 'note1'},
            {data: 'note2', name: 'note2'},
            {data: 'product_name_en', name: 'product_name_en'},
            {data: 'quantity', name: 'quantity'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'note', name: 'note'},
                ]
            });

table.buttons().container().appendTo($('.dbuttons'));

$('#submit').click(function(){
    $("#kt_modal_filter").modal('hide');
    table.draw();
});

$('#toit').change(function() {
    table.draw();
});

$("#btn_delete").click(function(event){
    event.preventDefault();
    var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){
    return $(this).val();
    }).get(); // <----
if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});

</script>
@endsection

