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
                <a  href="{{route('superadmin.drug_requests.spe')}}" class="text-muted text-hover-primary">'طلب ادوية من صيدلية'</a>
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

    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_docs_repeater_basic">
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{route('superadmin.drug_requests.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">

                        <div class="row mb-6">
                            <div class="col-sm-3  ">
                                <label for="fromit">اسم الصيدلية المراد التحويل منها</label>
                                        <select class="form-select" autofocus required aria-label="Select example" id="fromit" name="start_id" >
                                            <option value="">اسم الصيدلية المراد التحويل منها</option>
                                            @foreach ($sites as $asd)
                                                        <option value="{{ $asd->id }}">{{ $asd->name }}</option>
                                                        @endforeach
                                        </select>
                            </div>
                            <div class="col-sm-3  ">
                                        <label for="toit">اسم الصيدلية المراد التحويل اليها</label>
                                    <select class="form-select" autofocus required aria-label="Select example" id="toit" name="to_id" >
                                        <option value="">اسم الصيدلية المراد التحويل اليها</option>
                                        @foreach ($sites as $asd)
                                                    <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                    @endforeach
                                    </select>
                            </div>
                            <div class="col-sm-2" style="padding-top: 2%">
                                    <div class="form-check form-check-custom form-check-danger form-check-solid justify-content-center">
                                        <input class="form-check-input" type="checkbox" value="2" id="flexCheckChecked" name="urgent" />
                                        <label class="form-check-label" for="">
                                            عاجل
                                        </label>
                                    </div>
                            </div>
                            <div class="col-sm-4" style="padding-top: 1%">
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="note" placeholder="ملاحظات" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-3">
                                <label for="itemName">ادخل اسم الصنف</label>
                                <select class=" itemName form-control" id='itemName' name="itemName"  ></select>
                            </div>
                            <div class="col-sm-2">
                                <label for="quantity">الكمية المطلوبة</label>
                                <input type="number" id="quantity" name="quantity" value="1" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                            </div>
                            <div class="col-sm-3">
                                <label for="product_code">كودالصنف</label>
                                <input type="text" id="product_code" name="product_code" placeholder="كود الصنف" value="" class="form-control form-control-lg form-control-solid" required />
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                            </div>
                            <div class="col-sm-2">
                                <label for="product_name_en">اسم الصنف</label>
                                <h1 id="product_name_en" style="border-style: double; text-align:center"  >
                                            Name product
                                </h1>
                            </div>
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
                <div>
                    <a href="{{route('superadmin.drug_requests.import')}}" >
                        تحميل ملف اكسيل
                    </a>
                </div>

                <table  class="table align-middle table-rounded table-striped table-row-dashed fs-6  " id="kt_datatable_table">
                    <!--begin::Table head-->
                    <thead class="bg-light-dark pe-1">
                        <!--begin::Table row-->
                        <tr class="text-start text-dark fw-bold fs-4 text-uppercase gs-0">
                            <th class="w-10px p-3">
                                <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-50px text-start">اسم الصنف</th>
                            <th class="min-w-10px text-start">الكمية</th>
                            <th class="text-start">الرد</th>
                            <th class="min-w-10px text-start">الحالة</th>
                            <th class="min-w-50px text-start">وقت الطلب</th>
                            <th class="min-w-20px text-start">مطلوب التحوبل من</th>
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
                url: "{{ url('superadmin/drug_requests/getprod')}}",
                data: {"product_code": product_code},
                success: function (data) {
                    console.log(data.data.product_name_en);
                    $("#product_name_en").html(data.data);}});};});
    $('.itemName').select2({
        placeholder: 'Select an item',
        minimumInputLength: 3,
        ajax: {
            type: "GET",
            url: '{{ url('superadmin/drug_requests/ProdName')}}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.product_name_en,
                        id: item.product_code,
                    }})}},
        cache: true}});
    $('.itemName').change(function() {
        var proName = $('#itemName').find(":selected").text();
        var proValue = $('#itemName').find(":selected").val();
        $("#product_name_en").html(proName);
        $("#product_code").val(proValue);
    });
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
                url: "{{ route('superadmin.drug_requests.spe') }}",
                data: function (d) {
                    d.toit = $('#toit').find(":selected").val()
                    // d.search = $('#search').val()
                },},
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'actions', name: 'actions'},
                    {data: 'urgent', name: 'urgent'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'start_id', name: 'start_id'},
                    {data: 'note', name: 'note'},
                        ]});

        table.buttons().container().appendTo($('.dbuttons'));

        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });
        $('#toit').change(function() {
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----

            if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
@endsection

