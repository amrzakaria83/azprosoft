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
                <a  href="{{route('superadmin.inventory_requests.index')}}" class="text-muted text-hover-primary">'طلب ادوية من صيدلية'</a>
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
                <form action="{{route('superadmin.inventory_requests.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                        <div class="row mb-6">

                                <div class="col-sm-6">

                                </div>
                                <div class="col-lg-2 fv-row">
                                    <input type="text" name="note" placeholder=" ملاحظات" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                </div>
                            </div>
                    </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-3">
                                <label for="itemName">ادخل اسم الصنف</label>
                                <select class=" itemName form-control" id='itemName' name="itemName"></select>
                            </div>

                            <div class="col-sm-3">
                                <label for="product_code">كودالصنف</label>
                                <input type="text" id="product_code" name="product_code" placeholder="كود الصنف" value="" class="form-control form-control-lg form-control-solid" required />
                            </div>
                                    <div class="col-sm-4">
                                    <label for="product_name_en">اسم الصنف</label>
                                        <h1 id="product_name_en" style="border-style: double; text-align:center"  >
                                        Name Product
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
                url: "{{ url('superadmin/inventory_requests/getprod')}}",
                data: {"product_code": product_code},
                success: function (data) {
                    console.log(data.data.product_name_en);
                    $("#product_name_en").html(data.data);}});};});

    $('.itemName').select2({
        placeholder: 'Select an item',
        minimumInputLength: 3,
        ajax: {
            type: "GET",
            url: '{{ url('superadmin/inventory_requests/ProdName')}}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.product_name_en,
                        id: item.product_code,
                    }
                })
            }
        },
        cache: true
        }
    });
    $('.itemName').change(function() {
        var proName = $('#itemName').find(":selected").text();
        var proValue = $('#itemName').find(":selected").val();
        $("#product_name_en").html(proName);
        $("#product_code").val(proValue);
    })
</script>
<script>


</script>
@endsection

