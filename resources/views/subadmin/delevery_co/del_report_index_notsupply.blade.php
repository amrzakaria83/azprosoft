@extends('subadmin.delevery_layout.master')

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
            color: #9d5ff3 !important;
    }
</style>
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/subadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                عودة الى الرئيسية </h1></a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="#" class="text-muted text-hover-primary">الموظفين</a>
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <h1 class="container-fluid text-danger">
            الطلبات الآجلة ولم يتم ترحيلها
        </h1>
            <div class="card no-border">
                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('subadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                <div class="row align-items-start">
                            <div class="col-sm-6 p-3">
                                    <ul class="fw-bold fs-7 my-1">
                                        <li class="text-muted px-2">
                                            <a  href="{{ route('subadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">عودة طلبات التوصيل</a>
                                        </li>
                                    </ul>
                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                        <!--begin::Table-->
                                        @if(isset($data_order))
                                                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delevry_order_request_not_payment">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-light-dark pe-3">
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                            <th class="max-w-20px text-center">الطيار</th>
                                                            <th class="max-w-10px text-center">العميل</th>
                                                            <th class="max-w-20px text-center">القيمة</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-bold text-center">
                                                        @foreach ($data_order as $del_code => $data_order_group)
                                                        <tr>
                                                            <td colspan="2"><strong>كود الطيار : {{ $del_code }}</strong></td>
                                                        </tr>
                                                        @foreach ($data_order_group as $data_order1)
                                                        <tr>
                                                            <td>{{ $data_order1->getdelselect->name_ar }}</td>
                                                            <td>{{ $data_order1->getcustomerdel->cutomer_del_name_ar }}</td>
                                                            <td>{{ $data_order1->value_return }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <p>No data</p>
                                                @endif
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                        </div>
                        <div class="col-sm-6 p-3">
                            <h3 style="width: 40%">طلبات التثبيت </h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    @if(isset($data_stable))
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_stable_not_payment">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="max-w-20px text-center">الطيار</th>
                                                        <th class="max-w-10px text-center">العميل</th>
                                                        <th class="max-w-20px text-center">القيمة</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold text-center">
                                                    @foreach ($data_stable as $del_code => $data_stable_group)
                                                        @foreach ($data_stable_group as $data_stable1)
                                                            <tr>
                                                                <td>{{ $data_stable1->getdelselect->name_ar }}</td>
                                                                <td class="text-danger">
                                                                    {{ $data_stable1->getcustomerdel->cutomer_del_name_ar }}<br>
                                                                    <p id="time-difference-{{$data_stable1->id}}" class="text-info asdf"></p>
                                                                    <script>
                                                                        var startTime{{$data_stable1->id}} = new Date("{{ $data_stable1->moove_time }}");
                                                                        var endTime{{$data_stable1->id}} = new Date("{{ $data_stable1->return_time }}");
                                                                        var timeDiff{{$data_stable1->id}} = endTime{{$data_stable1->id}} - startTime{{$data_stable1->id}};

                                                                        // Convert milliseconds to hours, minutes, and seconds
                                                                        var hours{{$data_stable1->id}} = Math.floor(timeDiff{{$data_stable1->id}} / (1000 * 60 * 60));
                                                                        var minutes{{$data_stable1->id}} = Math.floor((timeDiff{{$data_stable1->id}} % (1000 * 60 * 60)) / (1000 * 60));
                                                                        var seconds{{$data_stable1->id}} = Math.floor((timeDiff{{$data_stable1->id}} % (1000 * 60)) / 1000);

                                                                        var timeDifferenceString{{$data_stable1->id}} = hours{{$data_stable1->id}} + " ساعة: " + minutes{{$data_stable1->id}} + " دقية ";
                                                                        document.getElementById("time-difference-{{$data_stable1->id}}").textContent = "المدة: " + timeDifferenceString{{$data_stable1->id}};
                                                                    </script>
                                                                </td>
                                                                <td>
                                                                    {{ $data_stable1->value_return_total }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <p>No data</p>
                                            @endif
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>
                </div>
            </div>
    </div>
    <a href="{{route('subadmin.delevery_cos.submit_cust_del_delay_payment')}}" class="btn btn-success container">ترحيل الى الحساب</a>

    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
                function customer_check(id, name, value_return, note,status_payment) {
                    Swal.fire({
                        html: '<select class="form-control" id="status_edit">' +
                        '  <option selected value="2">تقفيل الطلب</option>' +
                        '  <option value="3">تم إلغاء الطلب</option>' +
                        '  <option value="5">تعديل القيمة </option>' +
                        '  <option value="6">تعديل ملاحظة </option>' +
                        '  <option value="7">توصيل آجل</option>' +
                        '</select>',
                        title: 'هل تريد اتقفيل طلب ' + name + ' قيمة الاوردر ' + value_return + '؟',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger m-l-10',
                        confirmButtonText: 'موافق',
                        cancelButtonText: 'لا',
                        preConfirm: function () {
                        var status = document.getElementById('status_edit').value;
                        if (status === '5') {
                            return {
                            status: status,
                            value_return: value_return
                            };
                        } else if(status === '6'){
                            return {
                            status: status,
                            note: note
                            };
                        } else if(status === '7'){
                            return {
                            status: status,
                            status_payment: status_payment
                            };
                        }
                        else {
                            return {
                            status: status
                            };
                        }
                        }
                    }).then(function (result) {
                        if (result.value) {
                        var status = result.value.status;
                        var value_return = result.value.value_return;
                        var note = result.value.note;
                        var status_payment = result.value.status_payment;

                        if (status === '6') {
                            editnote(id, note);
                        } else if(status === '5'){

                            editAction(id, value_return);
                        } else if(status === '7'){

                            edit_status_payment(id, status_payment);
                        }
                        else {
                            $.ajax({
                            url: "{{url('/')}}/subadmin/delevery_cos/remoove_done",
                            method: "GET",
                            data: {
                                id: id,
                                status: status,
                                value_return: value_return
                            },
                            success: function (result) {
                                var table = $('#kt_datatable_table_delivery_out').DataTable();
                                table.draw();
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                alert("حدث خطأ ما أثناء محاولة إتمام الطلب.");
                            }
                            });

                        }
                        // else {
                        // alert("عفواً لم يتم الحذف");
                        // }
                }});
                    }

                    function editAction(id, value_return) {
                    Swal.fire({
                        html: '<input type="number" id="value_return_input" value="' + value_return + '" />',
                        title: 'قيمة الإرجاع' + '(' + value_return + ')',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger m-l-10',
                        confirmButtonText: 'حفظ',
                        cancelButtonText: 'إلغاء',
                        showCancelButton: true
                    }).then(function (result) {
                        if (result.value) {
                        var value_return = document.getElementById('value_return_input').value;

                        $.ajax({
                            url: "{{ url('/subadmin/delevery_cos/edit_value_return') }}/" + id + "/" + value_return,
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
                    function editnote(id, note) {
                    Swal.fire({
                        html: '<input type="text" id="note_input" value="' + note + '" />',
                        title: ' ملاحظة :' + '(' + note + ')',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger m-l-10',
                        confirmButtonText: 'حفظ',
                        cancelButtonText: 'إلغاء',
                        showCancelButton: true
                    }).then(function (result) {
                        if (result.value) {
                        var note = document.getElementById('note_input').value;

                        $.ajax({
                            url: "{{ url('/subadmin/delevery_cos/edit_note') }}/" + id + "/" + note,
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
                    function edit_status_payment(id, status_payment) {
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
                            url: "{{ url('/subadmin/delevery_cos/edit_status_payment') }}/" + id + "/" + status_payment,
                            method: "GET",

                            success: function (result) {
                            var table = $('#kt_datatable_table_delivery_out').DataTable();
                            table.draw();
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
