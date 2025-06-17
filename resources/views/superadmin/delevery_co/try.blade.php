@extends('superadmin.delevery_layout.master')

@section('css')
    <link href="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dash/assets/plugins/custom/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('style')
<style>
.p-3 {
    padding: 0px!important;
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

            <div class="card no-border">
                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                {{-- <input type="hidden" name="id" value="{{$data->id}}" /> --}}
                <div class="row align-items-start">
                    <div class="col-sm-4 p-3">

                        <div class="row">
                            <h3 style="width: 20%">طلب توصيل </h3>
                        </div>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->

                                                <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table10">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-light-dark pe-3">
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                            <th class="w-10px p-3">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table10 .form-check-input" value="1" />
                                                                </div>
                                                            </th>
                                                            <th class="max-w-10px text-start">العميل</th>
                                                            <th class="max-w-20px text-start">الطيار</th>
                                                            <th class="max-w-20px text-start">الاجراء</th>
                                                        </tr>
                                                        <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                            <th class="w-10px p-3">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table10 .form-check-input" value="1" />
                                                                </div>
                                                            </th>

                                                                    <th class="max-w-10px text-start"><select class=" delivery_customer_name form-control" value="" id="delivery_customer_name" name="delivery_customer_name" aria-placeholder="اسم العميل" ></select></th>
                                                                    <th class="max-w-20px text-start">
                                                                        <select class="itemName form-control" id="itemName" name="itemName"  ></select></th>
                                                                        <th class="max-w-20px text-start">
                                                                            <button  type="" onclick="submitForm_add_order_req()" class="btn btn-sm btn-icon btn-primary btn-active-dark me-2" >
                                                                                <i class="bi bi-plus-square fs-1x"></i>
                                                                            </button>
                                                                    </th>
                                                                </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <div class="col-sm-4 p-3">
                                                        <form id="delivery_form_add_order_req" action="{{route('superadmin.delevery_cos.store')}}" method="GET" >
                                                            @csrf
                                                                <input type="hidden" id="emp_code" readonly name="emp_code" value="{{Auth::guard('superadmin')->user()->emp_code}}" class="form-control form-control-lg form-control-solid" required style="text-align: center" />
                                                                <input type="hidden" id="delivery_customer_id" readonly name="delivery_customer_id" value="" class="form-control form-control-lg form-control-solid" required />
                                                            </form>
                                                    </div>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <div class="col-sm-4 p-3">
                                                        <form id="submitForm_set_del_req" action="{{ route('superadmin.delevery_cos.moove') }}" method="POST">
                                                            @csrf
                                                            <tbody class="text-gray-600 fw-bold">

                                                            </tbody>
                                                        </form>
                                                    </div>
                                                    <!--end::Table body-->
                                                </table>

                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>
                    <div class="col-sm-4 p-3">
                        <div class="row">
                            <h3 style="width: 20%">طلب تثبيت </h3>
                        </div>
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_delivery_stable">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="w-10px p-3">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table_delivery_stable .form-check-input" value="1" />
                                                            </div>
                                                        </th>
                                                        <th class="max-w-20px text-start">العميل</th>
                                                        <th class="max-w-20px text-start">من</th>
                                                        <th class="max-w-20px text-start">الحالة</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                    </div>
                    <div class="col-sm-4 p-2">
                        <h3>توصيل صيدلية</h3>
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_orderph">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="w-10px p-3">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table_orderph .form-check-input" value="1" />
                                                            </div>
                                                        </th>
                                                        <th class="max-w-20px text-start">الموظف</th>
                                                        <th class="max-w-20px text-start">الوقت</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-sm-4 p-3">
                        <h3>طيارين فى الخارج</h3>
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
                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table_delivery_out .form-check-input" value="1" />
                                                    </div>
                                                </th>
                                                <th class="max-w-20px text-start">العميل</th>
                                                <th class="max-w-20px text-start">الحالة</th>
                                                <th class="max-w-20px text-start">الحالة</th>
                                                <th class="max-w-20px text-start">الاجراء</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold">
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                    </div>
                    <div class="col-sm-4 p-3">
                        <h3>  تجربة</h3>
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table30">
                                                <!--begin::Table head-->
                                                <thead class="bg-light-dark pe-3">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                        <th class="w-10px p-3">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table30 .form-check-input" value="1" />
                                                            </div>
                                                        </th>
                                                        <th class="max-w-20px text-start">الموظف</th>
                                                        <th class="max-w-20px text-start">المكان</th>
                                                        <th class="max-w-20px text-start">الاجراء</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                    </div>
                    <div class="col-sm-3 p-3">
                        <h3> الطيارين الحاضرين </h3>
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table_att_in">
                                                        <!--begin::Table head-->
                                                        <thead class="bg-light-dark pe-3">
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-dark fw-bold fs-2 text-uppercase gs-0">
                                                                <th class="w-10px p-3">
                                                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table_att_in .form-check-input" value="1" />
                                                                    </div>
                                                                </th>
                                                                <th class="max-w-20px text-start">الموظف</th>
                                                                <th class="max-w-20px text-start">حضور من</th>
                                                                <th class="max-w-20px text-start">الاجراء</th>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600 fw-bold">
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
    function submitForm_add_order_req() {
        document.getElementById('delivery_form_add_order_req').submit();
        return false; // Prevents the default behavior of the <a> tag
    }
    </script>
    <script>
        function submitForm_set_del_req() {
            document.getElementById('submitForm_set_del_req').submit();
            return false; // Prevents the default behavior of the <a> tag
        }
        </script>
<script>
$('.delivery_customer_name').select2({
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
    $(".delivery_customer_name").on('change', function() {
    if (this.value == "add") {
        $('#kt_modal_add_delivery_order_requestforcostumer').modal('show');
    }
    else {
        $('#delivery_customer_id').val(this.value);
    }
});
//$(".delivery_customer_name").on('change', function() {
//     if (this.value == "add") {
//     $('#kt_modal_add_delivery_order_requestforcostumer').modal('show');
//     }
//     else {
//         $('#delivery_customer_id') == this.value ;

//     // var delivery_customer_id1 = $('#delivery_customer_name').value ;
//     //     console.log(delivery_customer_id1);
//     //     delivery_customer_id1 = $('#delivery_customer_id')

//     }}
// );
// var myInterval = setInterval(() => {
//     $('.itemNames').each(function(){
//         $(this).select2({
//         placeholder: 'Select an item',
//         minimumInputLength: 3,
//         ajax: {
//             type: "GET",
//             url: "{{ url('superadmin/delevery_cos/getdelselect1')}}",
//             dataType: 'json',
//             delay: 250,
//             processResults: function (data) {
//                 if (data.length == 0) {
//                     data = [{"id":"add","name_ar":"Add client"}];
//                     return {
//                         results:  $.map(data, function (item) {
//                             return {
//                                 text: item.name_ar,
//                                 id: item.del_code,
//                             }
//                         })
//                     }

//                 } else {
//                     return {
//                         results:  $.map(data, function (item) {
//                             return {
//                                 text: item.name_ar,
//                                 id: item.del_code,
//                             }
//                         })
//                     }
//                 }

//             },
//         cache: true}
//     });
//    });
    // $('.itemNames, .itemName').select2({
    //     placeholder: 'Select an item',
    //     minimumInputLength: 3,
    //     ajax: {
    //         type: "GET",
    //         url: "{{ url('superadmin/delevery_cos/getdelselect1')}}",
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             if (data.length == 0) {
    //                 data = [{"id":"add","name_ar":"Add client"}];
    //                 return {
    //                     results:  $.map(data, function (item) {
    //                         return {
    //                             text: item.name_ar,
    //                             id: item.del_code,
    //                         }
    //                     })
    //                 }

    //             } else {
    //                 return {
    //                     results:  $.map(data, function (item) {
    //                         return {
    //                             text: item.name_ar,
    //                             id: item.del_code,
    //                         }
    //                     })
    //                 }
    //             }

    //         },
    //     cache: true}
    // });

//     clearInterval(myInterval);
// }, 3000);


    $(function () {

        var table = $('#kt_datatable_table10').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                url: "{{ route('superadmin.delevery_cos.delivery_order_requests_add') }}",
                data: function (d) {
                    d.delivery_customer_id = $('#delivery_customer_id').val(),
                    d.del_code = $('#del_code').val(),
                    d.actions = $('#actions').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                {data: 'del_code', name: 'del_code'},
                {data: 'actions', name: 'actions'},
            ]});

        table.buttons().container().appendTo($('.dbuttons'));

        table.on( 'draw', function () {
            var elements = $('*[class^="itemNames"]');

            Array.from(elements).forEach((element, index) => {
                $(element).select2({
                    placeholder: 'Select an item',
                    minimumInputLength: 3,
                    ajax: {
                        type: "GET",
                        url: "{{ url('superadmin/delevery_cos/getdelselect1')}}",
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            if (data.length == 0) {
                                data = [{"id":"add","name_ar":"no"}];
                                return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.name_ar,
                                            id: item.del_code,
                                        }
                                    })
                                }

                            } else {
                                return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.name_ar,
                                            id: item.del_code,
                                        }
                                    })
                                }
                            }

                        },
                    cache: true}
                });
            });

        });
        $(".itemNames, .itemName").on('change', function() {
        if (this.value == "add") {
            $('#kt_modal_add_delivery_order_requestforcostumer').modal('show');
            // else {
            //     var del_ord = this.value;

            //     del_ord .val(this.value);
            //     $('#delivery_customer_id').val(this.value);
            // }
        }
});

        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        $('#submit').click(function(){
            $("#kt_modal_add_delivery_order_requestforcostumer").modal('hide');
            table.draw();
        });
        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table10 input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table_delivery_out').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                url: "{{ route('superadmin.delevery_cos.delivery_order_requests_out') }}",
                data: function (d) {
                    d.delivery_customer_id = $('#delivery_customer_id').val(),
                    d.del_code = $('#del_code').val(),
                    d.actions = $('#actions').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'delivery_customer_id', name: 'delivery_customer_id'},
                {data: 'del_code', name: 'del_code'},
                {data: 'actions', name: 'actions'},
            ]});

        table.buttons().container().appendTo($('.dbuttons'));
        // setInterval( table.draw(), 10000);
        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        $('#submit').click(function(){
            $("#kt_modal_add_delivery_order_requestforcostumer").modal('hide');
            table.draw();
        });
        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table_delivery_out input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table_delivery_stable').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                url: "{{ route('superadmin.drug_requests.index') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                    {data: 'checkbox', name: 'checkbox'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'quantity', name: 'quantity'},

                        ]});

        table.buttons().container().appendTo($('.dbuttons'));

        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table_delivery_stable input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table_att_in').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                url: "{{ route('superadmin.attendances.index_in') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'emp_code_att', name: 'emp_code_att'},
                {data: 'start_id', name: 'start_id'},
                {data: 'actions', name: 'actions'},
            ]
        });

        table.buttons().container().appendTo($('.dbuttons'));

        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table_att_in input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table_orderph').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                    {data: 'start_id', name: 'start_id'},
                    {data: 'created_at', name: 'created_at'},
            ]
        });

        table.buttons().container().appendTo($('.dbuttons'));

        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){event.preventDefault();var checkIDs = $("#kt_datatable_table_orderph input:checkbox:checked").map(function(){return $(this).val();
            }).get(); // <----
    if (checkIDs.length > 0) {var token = $(this).data("token");Swal.fire({title: 'هل انت متأكد ؟',text: "لا يمكن استرجاع البيانات المحذوفه",type: 'warning',showCancelButton: true,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger m-l-10',confirmButtonText: 'موافق',cancelButtonText: 'لا'}).then(function (isConfirm) {if (isConfirm.value) {$.ajax({url: "{{route('superadmin.drug_requests.delete')}}",type: 'post',dataType: "JSON",data: {"id": checkIDs,"_method": 'post',"_token": token,},success: function (data) {if(data.message == "success") {table.draw();toastr.success("", "تم الحذف بنجاح");} else {toastr.success("", "عفوا لم يتم الحذف");}},fail: function(xhrerrorThrown){toastr.success("", "عفوا لم يتم الحذف");}});} else {console.log(isConfirm);}});} else {toastr.error("", "حدد العناصر اولا");}});});
</script>
<script>
    $('.cutomer_del_name_ar').select2({
            placeholder: 'Select an item',
            minimumInputLength: 3,
            ajax: {
                type: "GET",
                url: "{{ url('superadmin/delevery_cos/getcutomer_del') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    console.log(data);
                return {

                    results:  $.map(data, function (item) {
                        return {
                            text: item.cutomer_del_name_ar,
                            id: item.phone1,
                        }})}},
            cache: true}});

    $('.cutomer_del_name_ar').change(function() {
    var delcustName = $(this).find(":selected").text();
    var delcustValue = $(this).find(":selected").val();
    console.log(delcustName);
    $("#cutomer_del_selected").html(delcustName);
    $("#cutomer_del_selected").val(delcustValue);
    });
</script>
<script>
    $(function () {

        var table = $('#kt_datatable_table30').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            autoWidth: false,
            responsive: true,
            pageLength: 5,
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
                    {data: 'checkbox', name: 'checkbox'},
                    {data: 'name_ar', name: 'name_ar'},
                    {data: 'start_id', name: 'start_id'},
                    {data: 'actions', name: 'actions'},

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
@endsection
