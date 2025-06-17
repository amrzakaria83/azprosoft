@extends('superadmin.delevery_layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('style')
<style>
    .p-3 {
        padding: 0px!important;
        padding-left: 10px!important;
        padding-right: 0px!important;
    }
    .card-body {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .card {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .btn-group {
        display:none!important;
    }
    .table > :not(caption) > * > * {
        padding: 0px!important;
        padding-right: 0px!important;
    }
    .th {
        max-width: 10px!important;
    }
    .select2-search--dropdown{
    background-color: #000 !important;
    }
    .select2-container--bootstrap5 .select2-selection--single .select2-selection__placeholder{
            color: #4262f1 !important;
    }
</style>
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/superadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                عودة الى الرئيسية </h1></a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">طلبات التوصيل</a>
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card no-border">
                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />

                        <div class="row align-items-start">
                            <div class="col-sm-6 p-3">
                                <h3 style="width: 40%">طلب تثبيت </h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                                <!--begin::Table-->
                                        <form id="submitForm_set_stable_req" action="{{ route('superadmin.delevery_cos.moove_stable') }}" method="POST">
                                            @csrf
                                                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_stable">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-light-dark pe-3">
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                            <th class="max-w-20px text-center">العميل</th>
                                                            <th class="max-w-10px text-center">الطيار</th>

                                                        </tr>
                                                                <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                        <th class="max-w-10px text-start">
                                                                            <span>موعد التنفذ : </span>
                                                                            <input type="time" id="theTime" value=""  name="theTime"  step="1"><br>
                                                                            <select class=" delivery_customer_name_stable form-control" value="" id="delivery_customer_name_stable" name="delivery_customer_name_stable" aria-placeholder="اسم العميل" >
                                                                            </select>
                                                                        </th>
                                                                            <th class="max-w-10px text-center">
                                                                                </th>
                                                                                <th class="max-w-20px text-center">
                                                                                <a  href="javascript:;" id="asdasd" name="submitForm_add_stable_req" class="btn btn-sm btn-icon btn-primary btn-active-dark me-2" >
                                                                                    <i class="bi bi-plus-square fs-1x"></i>
                                                                                </a>
                                                                        </th>
                                                                    </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-bold text-center">
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                        </form>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <div class="col-sm-3 p-3">
                                <h3>تثبيت فى الخارج</h3>
                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_tablestabel_out">
                                                        <!--begin::Table head-->
                                                        <thead class="bg-light-dark pe-3">
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                <th class="max-w-20px text-center">اسم العميل</th>
                                                                <th class="max-w-20px text-center">الطيار</th>
                                                                <th class="max-w-20px text-center">الاجراء</th>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600 fw-bold text-center">
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                            </div>
                            <div class="col-sm-3 p-3">
                                <h3>الطياريين المتاحين
                                    <ul class="fw-bold fs-7 my-1">
                                        <li class="text-muted px-2">
                                            <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">طلبات التوصيل</a>
                                        </li>
                                    </ul>
                                </h3>
                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table30">
                                                        <!--begin::Table head-->
                                                        <thead class="bg-light-dark pe-3">
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                <th class="max-w-20px text-center">الموظف</th>
                                                                {{-- <th class="max-w-20px text-center">المكان</th>
                                                                <th class="max-w-20px text-center">الاجراء</th> --}}
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600 fw-bold text-center">
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                            </div>
                        </div>

                <div class="modal fade" id="kt_modal_add_delivery_order_requestforcostumer" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_delivery_order_requestforcostumer_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">اضافة عميل</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form action="{{route('superadmin.delevery_cos.storecutomer_del')}}" method="POST">
                                    @csrf
                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />

                                <div class="row mb-12">
                                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">اسم العميل</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" id="cutomer_del_name_ar" name="cutomer_del_name_ar" required placeholder="الاسم" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">التليفون</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" id="phone1" name="phone1" required placeholder="التليفون" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <label class="col-lg-2 col-form-label fw-semibold fs-6">العنوان</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" id="address" name="address"  placeholder="العنوان" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    </div>
                                </div>
                                    <div class="text-center pt-15">
                                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary" id="submit">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
$(document).ready(function() {
    // Convert the current time to the Laravel application's timezone
    var nowInLaravelTimezone = moment().format('HH:mm:ss');
    // Set the value of the input field to the converted time
    $('#theTime').val(nowInLaravelTimezone);
});


    $('.delivery_customer_name_stable').select2({
            placeholder: 'Select an item',
            minimumInputLength: 3,
            ajax: {
                type: "GET",
                url: "{{ url('superadmin/delevery_cos/getcutomer_del')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    if (data.length == 0) {
                        data = [{"id":"add","cutomer_del_name_ar":"Add client"}];
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.cutomer_del_name_ar,
                                    id: item.id,
                                }
                            })
                        }

                    } else {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.cutomer_del_name_ar,
                                    id: item.id,
                                }
                            })
                        }
                    }

                },
            cache: true}
        });
        $('.delivery_customer_name_stable').on('change', function() {
        if (this.value == "add") {
            $('#kt_modal_add_delivery_order_requestforcostumer').modal('show');
        }
        else {
            $('#delivery_customer_id').val(this.value);
        }
    });

    $(function () {

        var table = $('#kt_datatable_table_delivery_stable').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 10,
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
                url: "{{ route('superadmin.delevery_cos.delivery_stable_requests_add') }}",
                data: function (d) {
                    d.delivery_customer_id = $('#delivery_customer_id').val(),
                    d.del_code = $('#del_code').val(),
                    d.actions = $('#actions').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                // {data: 'time_go_request', name: 'time_go_request'},
                {data: 'del_code', name: 'del_code'},
                {data: 'actions', name: 'actions'},
            ]});

        table.buttons().container().appendTo($('.dbuttons'));

        $('.delivery_name_stable').select2({
                placeholder: 'ادخل كود الطيار او اسمه',
                minimumInputLength: 3,
                ajax: {
                type: "GET",
                url: "{{ url('superadmin/delevery_cos/getdelselect')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                        return {
                            text: item.name_ar,
                            id: item.del_code,
                        }
                        })
                    }

                },
                cache: true
                }
        });

        table.on( 'draw', function () {
            var elements = $('*[class^="itemNames"]');

            Array.from(elements).forEach((element, index) => {
                $(element).select2({
                    placeholder: 'ادخل كود الطيار او اسمه',
                minimumInputLength: 3,
                ajax: {
                type: "GET",
                url: "{{ url('superadmin/delevery_cos/getdelselect')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                        return {
                            text: item.name_ar,
                            id: item.del_code,
                        }
                        })
                    }

                },
                cache: true
                }
                });
            });

        });
        $(".itemNames").on('change', function() {
                if (this.value == "add") {
                    $('#kt_modal_add_delivery_order_requestforcostumer').modal('show');

                }
        });

        $('#asdasd').click(function(){
            var id = $( ".delivery_customer_name_stable option:selected" ).val();
            var del_code = $( ".delivery_name_stable option:selected" ).val();
            var theTime = $('#theTime').val();
            var is_del_code = '';

            if (del_code) {
                is_del_code = del_code;
            } else {
                $.ajax({url: "{{url('/')}}"+"/superadmin/delevery_cos/storestable?id="+id+"&time_go_request="+theTime+"&del_code="+is_del_code, success: function(result){
                if (del_code) {
                    table.draw();
                    location.reload();
                } else {
                    table.draw();
                    location.reload();
                }

            }});
            }
        });

        $('#submit').click(function(){
            $("#kt_modal_add_delivery_order_requestforcostumer").modal('hide');
            table.draw();
        });
        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table_delivery_stable input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>

<script>
    $(function () {

        var table = $('#kt_datatable_tablestabel_out').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
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
                url: "{{ route('superadmin.delevery_cos.delivery_stable_requests_out') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                    {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                    {data: 'del_code', name: 'del_code'},
                    {data: 'actions', name: 'actions'},
                    // {data: 'actions', name: 'actions'},

                        ]});

        table.buttons().container().appendTo($('.dbuttons'));

        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_tablestabel_out input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});


</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table30').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
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
                url: "{{ route('superadmin.delevery_cos.delivery_attendace_in') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                    {data: 'name_ar', name: 'name_ar'},
                    // {data: 'start_id', name: 'start_id'},
                    // {data: 'actions', name: 'actions'},

                        ]});

        table.buttons().container().appendTo($('.dbuttons'));

        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table30 input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});


</script>
<script>
    function customer_check_stable(id, value_return) {
        Swal.fire({
            html: '<input type="number" id="value_return_input" value="' + value_return + '" />',
            title: 'هل تريد تعديل القيمة',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            confirmButtonText: 'موافق',
            cancelButtonText: 'لا',
            preConfirm: function () {
                return {
                    value_return: document.getElementById('value_return_input').value
                };
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                var value_return = result.value.value_return;
                $.ajax({
                    url: "{{ url('/superadmin/delevery_cos/edit_value_return_stable_no_total') }}/" + id + "/" + value_return,
                    method: "GET",
                    success: function (result) {
                        location.reload();
                        var del_code = $('#delivery_name_order').val();
                $.ajax({
                url: "{{ route('superadmin.delevery_cos.get_totalorder_request') }}",
                method: 'GET',
                data: { delivery_name_order: del_code },
                success: function(data) {

                    location.reload();
                },

            });
                        Swal.fire('تم التعديل بنجاح', '', 'success');
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('حدث خطأ ما', 'حدث خطأ ما أثناء محاولة إتمام الطلب.', 'error');
                    }
                });
            } else {
                Swal.fire('لم يتم التعديل', '', 'info');
            }
        });
    }
</script>
<script>
    function customer_check_stable_change_total(id, totalValue) {
        Swal.fire({
            html: '<input type="number" id="totalValue_input" value="' + Math.floor(totalValue) + '" />',
            title: 'هل تريد تعديل القيمة',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            confirmButtonText: 'موافق',
            cancelButtonText: 'لا',
            preConfirm: function () {
                return {
                    totalValue: Math.floor(document.getElementById('totalValue_input').value)
                };
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                var totalValue = result.value.totalValue;
                $.ajax({
                    url: "{{ url('/superadmin/delevery_cos/edit_value_return_stable_total') }}/" + id + "/" + totalValue,
                    method: "GET",
                    success: function (result) {

                        location.reload();

                        Swal.fire('تم التعديل بنجاح', '', 'success');
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('حدث خطأ ما', 'حدث خطأ ما أثناء محاولة إتمام الطلب.', 'error');
                    }
                });
            } else {
                Swal.fire('لم يتم التعديل', '', 'info');
            }
        });
    }
</script>
<script>
                    function edit_status_stable_payment(id, status_payment) {
                    Swal.fire({
                        html: '<input type="hidden" id="status_payment_input" value="' + 4 + '" placeholder="توصيل آجل" />',
                        title: ' طبيعة السداد :' + '(توصيل آجل)',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger m-l-10',
                        confirmButtonText: 'حفظ',
                        cancelButtonText: 'إلغاء',
                        showCancelButton: true
                    }).then(function (result) {
                        if (result.value) {
                        var status_payment = document.getElementById('status_payment_input').value;

                        $.ajax({
                            url: "{{ url('/superadmin/delevery_cos/edit_status_stable_payment') }}/" + id + "/" + status_payment,
                            method: "GET",

                            success: function (result) {
                            var table = $('#kt_datatable_table_delivery_out').DataTable();
                            table.draw();
                            location.reload();
                            Swal.fire('تم التعديل بنجاح', '', 'success');
                            },
                            error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire('حدث خطأ ما', 'حدث خطأ أثناء محاولة إتمام الطلب.', 'error');
                            }
                        });
                        }
                    });
                    }
</script>
@endsection
