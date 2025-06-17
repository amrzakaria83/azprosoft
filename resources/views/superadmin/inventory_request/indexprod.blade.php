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
                <a  href="{{route('superadmin.inventory_requests.indexprod')}}" class="text-muted text-hover-primary">'طلب ادوية من صيدلية'</a>
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Content-->
            <div id="kt_docs_repeater_basic">
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{route('superadmin.inventory_requests.indexprod')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-3">
                                <label for="itemName">ادخل اسم الصنف</label>
                                <select class=" itemName form-control" id='itemName' name="itemName"  ></select>
                            </div>
                            <div class="col-sm-3">
                                <label for="product_code">كودالصنف</label>
                                <input type="text" id="product_code" name="product_code" placeholder="كود الصنف" value="" class="form-control form-control-lg form-control-solid" required />
                            </div>
                                <div class="col-sm-4">
                                    <label for="product_name_en">اسم الصنف</label>
                                    <h1 id="product_name_en" style="border-style: double; text-align:center"  >
                                                Name product
                                    </h1>
                                </div>
                        </div>
                            <div class="row mb-6">

                                <div class="col-sm-4">
                                    <h3  class="text-info" style="text-align: center" >
                                                عدد الصيدليات المجرودة <br> <span id="total_site"> {{$total[1]}} </span>
                                    </h3>
                                </div>
                                <div class="col-sm-4">
                                    <div  class="text-info" style="text-align: center">
                                        عدد المخازن لم يتم جردها <br> <span id="total_store"> {{$total[2]}}  </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <th class="min-w-50px text-start">اسم الصيدلية</th>
                            <th class="min-w-10px text-start">الكمية الفعلية</th>
                            <th class="min-w-10px text-start">الكمية على الحاسب</th>
                            <th class="min-w-10px text-start">الفرق</th>
                            <th class="min-w-10px text-start">الحالة</th>
                            <th class="min-w-50px text-start">وقت الطلب</th>
                            <th class="min-w-50px text-start">وقت التنفيذ</th>
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
                    }})}},cache: true}});

</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 30,
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
                url: "{{ route('superadmin.inventory_requests.indexprod') }}",
                data: function (d) {
                    d.product_code = $('#product_code').val(),
                    d.search = $('#search').val()
                },
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'product_code', name: 'product_code'},
                {data: 'actual_balance', name: 'actual_balance'},
                {data: 'vertiul_stoc', name: 'vertiul_stoc'},
                {data: 'difference', name: 'difference'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'note', name: 'note'},
            ]
        });

                table.buttons().container().appendTo($('.dbuttons'));

        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });

        $('.itemName').change(function() {

            var proName = $('#itemName').find(":selected").text();
            var proValue = $('#itemName').find(":selected").val();
            $("#product_name_en").html(proName);
            $("#product_code").val(proValue);

            $.ajax({
                type: "GET",
                url: "{{ url('superadmin/inventory_requests/get_total')}}"+'/'+proValue,
                data: {"proValue": proValue},
                success: function (data) {
                    console.log(data);
                    $("#total_site").html(data[1]);
                    $("#total_store").html(data[2]);
                }
            });

            table.draw();
        });

        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
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
