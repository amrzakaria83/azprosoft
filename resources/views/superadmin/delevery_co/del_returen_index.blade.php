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
                <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">طلب التوصيل</a>
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
                <div class="row">
                    <div class="col-sm-6 p-3">
                        <ul class="fw-bold fs-7 my-1">
                            <li class="text-muted px-2">
                                <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">-عودة طلب التوصيل</a>
                            </li>
                        </ul>
                        <select class="delivery_name_order form-control" id="delivery_name_order" name="delivery_name_order"  ></select>
                    </div>
                </div>

                @if(isset($data_stable))
                <div class="row">
                    <div class="col-sm-3 p-3">
                        <h3>طلبات التوصيل</h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_out">
                                        <!--begin::Table head-->
                                        <thead class="bg-light-dark pe-3">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                <th class="w-10px p-3">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1"  />
                                                    </div>
                                                </th>
                                                <th class="max-w-20px text-center">اسم العميل</th>
                                                <th class="max-w-20px text-center">القيمة</th>
                                                <th class="max-w-20px text-center">ملاحظات</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold text-center">
                                            @foreach ($data_order as $data_order1)
                                            <tr value="{{$data_order1['id']}}" onclick="customer_check({{$data_order1['id']}}, {{$data_order1['value_return']}})">
                                                <th></th>
                                                    <td id="" style="display:none" > {{ $data_order1 }}</td>
                                                    <td   > {{ $data_order1->getcustomerdel->cutomer_del_name_ar }}</td>
                                                    <td value="{{$data_order1['value_return']}}" id="value_return"  > {{ $data_order1['value_return'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>
                    <div class="col-sm-3 p-3">
                        <h3>طلبات التثبيت</h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_stable_payment">
                                        <!--begin::Table head-->
                                        <thead class="bg-light-dark pe-3">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                <th class="w-10px p-3">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1"  />
                                                    </div>
                                                </th>
                                                <th class="max-w-20px text-center">اسم العميل</th>
                                                <th class="max-w-20px text-center">قيمة الساعة</th>
                                                <th class="max-w-20px text-center">الاجمالى</th>
                                                <th class="max-w-20px text-center">ملاحظات</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold text-center">

                                                @foreach ($data_stable as $data_stable1)
                                                <tr value="{{$data_stable1['id']}}" >
                                                    <th></th>
                                                        <td id="" style="display:none" > {{ $data_stable1 }}</td>
                                                        <td   > {{ $data_stable1->getcustomerdel->cutomer_del_name_ar }}</td>
                                                        <td value="{{$data_stable1['value_return']}}" id="value_return"  > {{ $data_stable1['value_return'] }}</td>
                                                        <td   > {{ $data_stable1['value_return_total'] }}</td>
                                                </tr>
                                                @endforeach

                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>

                    <div class="col-sm-1 p-3">

                    </div>

                <div class="col-sm-5 p-3">
                        <div class="col-sm-11 p-3">
                            @if(isset($name_del))
                            <h1 id="del_code_re_all" style="color:rgb(0, 74, 212)">{{$name_del}}</h1>
                            @endif
                            <h2>مجموع التوصيل :
                                <span id="total_order" value="{{$total_order}}" name="total_order"  class="text-center text-danger" >{{$total_order}}
                                </span>
                            </h2>
                            <h3> عدد التوصيل :
                                <span id="total_order_count" value="{{$total_order_count}}"  name="total_order_count" class="text-center ">{{$total_order_count}}</span>
                            </h3>
                            </div >

                            <div class="col-sm-11 p-3">
                                <h2>مجموع التثبيت :
                                <span id="total_stable" value="{{$total_stable }}" name="total_stable"  class="text-center text-danger" >{{$total_stable }}
                                </span>
                                </h2>
                                <h3> عدد التثبيت :
                                    <span id="total_stable_count" value="{{$total_stable_count}}" name="total_stable_count"  class="text-center "  >{{$total_stable_count}}</span>
                                </h3>
                            </div >
                            <div class="col-sm-11 p-3">
                                <h1> اجمالى القيمة  :
                                    <span id="del_total_valu" value="{{$del_total_valu}}" name="del_total_valu"  class="text-center text-success"  >{{$del_total_valu}}</span>
                                </h1>
                                @if ($del_total_valu > 0)
                                <a href="{{route('superadmin.delevery_cos.submit_totalorder_del', $del_code)}}" class="btn btn-success">Success</a>
                                @endif
                </div>
                @else
                No data
                @endif
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
        $('.delivery_name_order').select2({
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

    $("#delivery_name_order").on('change', function() {
    const del_code = $(".delivery_name_order option:selected").val();
    window.location = '{{route("superadmin.delevery_cos.delivery_order_requests_stable_payment")}}'+ '/'+del_code;

    });
});
</script>

<script>
        function customer_check(id, value_return) {
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
                        url: "{{ url('/superadmin/delevery_cos/edit_value_return') }}/" + id + "/" + value_return,
                        method: "GET",
                        success: function (result) {
                            location.reload();
                            var del_code = $('#delivery_name_order').val();

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


@endsection
