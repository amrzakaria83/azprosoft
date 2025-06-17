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
                    <form action="{{route('superadmin.order_ph_requests.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body  p-9">
                            <div class="row mb-6">
                                <div class="col-sm-3  ">
                                    <label for="toit">صرف الادوبة من صيدلية</label>
                                    <select class="form-select" autofocus required aria-label="Select example" id="toit" name="start_id" >
                                            <option disabled selected>اسم الصيدلية المراد الصرف منها</option>
                                                @foreach ($sites as $asd)
                                                <option value="{{ $asd->id }}"@if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                    <div class="row mb-6">
                            <div class="col-sm-3">
                                <label for="no_recepient">رقم الفاتورة </label>
                                <input type="number" id="no_recepient" name="no_recepient" value="" class="form-control form-control-lg form-control-solid" required style="text-align: center; background-color: bisque" />
                            </div>
                        <div class="col-sm-2">
                                <label for="del_code">كود الدليفرى</label>
                                <input type="number" id="del_code" name="del_code" value="" class="form-control form-control-lg form-control-solid" required style="text-align: center; background-color: rgb(255, 145, 145)" />
                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                        </div>
                        <div class="col-sm-2">
                                <label for="name_ar">ادخل اسم الدليفرى</label>
                                <select class=" name_ar form-control" id='name_ar' name="name_ar"></select>
                        </div>
                        <div class="col-sm-3">
                                <label for="note">ملاحظات</label>
                                <input type="text" id="note" name="note" placeholder="ملاحظات " value="" class="form-control form-control-lg form-control-solid"  />
                        </div>
                    </div>
                    <div class="row mb-6">
                                <div class="col-sm-4">
                                    <label for="emp_name_ar_re1">اسم الدليفرى</label>
                                    <h1 id="emp_name_ar_re1" style="border-style: double; text-align:center">
                                        </h1>
                                        {{-- <input type="hidden" name="checkdeliv" placeholder="name" value="" readonly id="emp_name_ar_re" /> --}}
                                </div>
                    </div>
            </div>
        </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
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
                            <th class="min-w-50px text-start">اسم الصدلية</th>
                            <th class="min-w-10px text-start">رقم الفاتورة</th>
                            <th class="min-w-10px text-start">وقت التحرك</th>
                            <th class="min-w-10px text-start">الرد</th>
                            <th class="min-w-50px text-start">ملاحظات</th>
                            <th class="min-w-20px text-start">الموظف</th>
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
    $("#del_code").on('input', function() {
    var code = $(this).val();
    if (code !== '') {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
        type: "GET",
        url: "{{ url('superadmin/order_ph_requests/getempdel')}}",
        data: {"code": code},
        success: function (data) {
            console.log(data.data);
            $("#emp_name_ar_re1").html(data.data);
        }});
    }
    });
</script>
<script>
    $('.name_ar').select2({
            placeholder: 'Select an item',
            minimumInputLength: 3,
            ajax: {
                type: "GET",
                url: "{{ url('superadmin/order_ph_requests/getempdelselect') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name_ar,
                            id: item.emp_code,
                        }})}},
            cache: true}});

    $('.name_ar').change(function() {
    var empName = $(this).find(":selected").text();
    var empValue = $(this).find(":selected").val();
    console.log(empValue);
    $("#emp_name_ar_re1").html(empName);
    $("#del_code").val(empValue);});
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
                url: "{{ route('superadmin.order_ph_requests.index') }}",
                data: function (d) {
                    d.toit = $('#toit').find(":selected").val()
                    // d.search = $('#search').val()
                },},
            columns: [
                    {data: 'checkbox', name: 'checkbox'},
                    {data: 'start_id', name: 'start_id'},
                    {data: 'no_recepient', name: 'no_recepient'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions'},
                    {data: 'note', name: 'note'},
                    {data: 'emp_code', name: 'emp_code'},
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

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){return $(this).val();}).get(); // <----
if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
@endsection

