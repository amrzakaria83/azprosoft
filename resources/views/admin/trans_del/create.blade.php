@extends('admin.layout.master')

@section('css')
@endsection

@section('style')
    
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/admin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('admin.trans_dels.index')}}" class="text-muted text-hover-primary"></a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                add new
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
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{route('admin.trans_dels.store')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf
                    <input type="hidden" name="azaz" value="2" id="azaz" />

                    <!--begin::Card body-->
                    <div class="card-body  p-9">
                    <div class="row mb-6">
                            <label class="col-lg-2 col-form-label required text-info fw-semibold fs-6">خروج من</label>
                            <div class="col-sm-3  ">
                                    <select class="form-select " autofocus required aria-label="Select example" id="start_id" name="start_id" >
                                        <option value="">من</option>
                                        @foreach ($sites as $asd)
                                                <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                            @endforeach
                                    </select>
                            </div>

                        <!-- </div>

                    <div class="row mb-6"> -->
                            <label class="col-lg-2 col-form-label required text-info fw-semibold fs-6">الطيار</label>
                            <div class="col-lg-5 fv-row">
                                <select  data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0"  name="del_code" data-control="select2" >
                                    <option disabled  selected>Select an option</option>
                                    @if(isset($dataemp))
                                        @foreach ($dataemp as $item)
                                                <option value="{{$item->id}}">{{$item->name_ar}}-{{$item->del_code}}</option>
                                            @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label fw-semibold fs-6">النوع</label>
                            <div class="col-sm-2 d-flex align-items-center">
                            <select   data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0 text-center" id="type_tran" name="type_tran">
                                    <option value="0">تحويل</option>
                                    <option value="1">اوردر</option>
                                </select>
                            </div>
                            
                        
                            <!-- <label class="col-sm-1 col-form-label fw-semibold fs-6">النوع</label> -->
                            <div class="col-sm-2 d-flex align-items-center">
                                <select class="form-select" autofocus required aria-label="Select example" id="to_id" name="to_id" >
                                        <option disabled selected>الى</option>
                                            @foreach ($sites as $asd)
                                            <option value="{{ $asd->id }}">{{ $asd->name }}</option>
                                            @endforeach
                                    </select>
                            </div>
                        
                            <label class="col-sm-1 col-form-label fw-semibold fs-6">طبيعة</label>
                            <div class="col-sm-2 d-flex align-items-center">
                            <select   data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0 text-center"  name="urgent">
                                    <option value="0">غير عاجل</option>
                                    <option value="1">عاجل</option>                                    
                                </select>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-2 col-form-label fw-semibold fs-6">رقم الريسيت</label>
                            <div class="col-lg-3 fv-row">
                                <input type="number" name="no_receit" placeholder="رقم الريسيت" disabled value="" id="no_receit" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                            <div class="col-lg-3 fv-row">
                                <input type="number" name="val_receit" placeholder="قيمة الريسيت" disabled value="" id="val_receit" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        <!-- </div>

                        <div class="row mb-6"> -->
                            <!-- <label class="col-lg-2 col-form-label fw-semibold fs-6">ملاحظة</label> -->
                            <div class="col-lg-3 fv-row">
                                <input type="text" name="note" placeholder="ملاحظة" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                            </div>
                        </div>


                    </div>
                    <div class="card-footer card-footer-sm d-flex justify-content py-6 px-9">

                        <div class=" d-flex justify-content-start py-6 px-9">
                                <a href="" id="added" class="btn btn-lg  btn-danger btn-active-dark  align-middle container ">
                                <span>طلب طيار</span>
                                <i class="bi bi-plus-square fs-1x"></i>
                            </a>
                        </div>
                            <div class="col-4">
                            </div>
                           <div class="d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                            </div>
                        </div>

                    <!-- <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                    </div> -->
                    <!--end::Actions-->
                </form>
                <!--end::Form-->

                <div class="row mb-6">
                    <div class="col-8">
                        <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table">
                                <!--begin::Table head-->
                                <thead class="bg-light-dark pe-3">
                                    <!--begin::Table row-->
                                    <tr class="text-start text-dark fw-bold fs-4 text-uppercase gs-0">
                                        <th class="w-10px p-3">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-125px text-start">اسم الطيار</th>
                                        <th class="min-w-125px text-start">الاجراء</th>
                                        <th class="min-w-125px text-start">الحركة</th>
                                        <th class="min-w-125px text-start">ملاحظة</th>
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
                    <div class="col-4">
                        <table class="table align-middle table-rounded table-striped table-row-dashed fs-6" id="kt_datatable_table1">
                                <!--begin::Table head-->
                                <thead class="bg-light-dark pe-3">
                                    <!--begin::Table row-->
                                    <tr class="text-start text-dark fw-bold fs-4 text-uppercase gs-0">
                                        <th class="w-10px p-3">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table1 .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-125px text-start">اسم الطيار</th>
                                        <th class="min-w-125px text-start">الاجراء</th>
                                        <th class="min-w-125px text-start">الحركة</th>
                                        <th class="min-w-125px text-start">ملاحظة</th>
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
                </div>

            </div>
            <!--end::Content-->
                <div class="">
                        <div class="modal fade" tabindex="-1" id="kt_modal_1b">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="receiptNumber">رقم الريسيت:</h3>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('admin.trans_dels.editno_receit')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                                            @csrf
                                            <input type="hidden" name="id" id="receiptId" value="">
                                            <label class="col-lg-2 col-form-label fw-semibold fs-6">رقم الريسيت</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="number" name="no_receit" placeholder="رقم الريسيت" value="" id="no_receit" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                            </div>
                                            <label class="col-lg-2 col-form-label fw-semibold fs-6">قيمة الريسيت</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="number" name="val_receit" placeholder="قيمة الريسيت" value="" id="val_receit" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

@endsection

@section('script')

<script>
    $('#type_tran').on('change', function() {
            var type_tran = $('#type_tran option:selected').val();
            if (type_tran != 0){
                $('#to_id').prop('disabled', true);
                $('#no_receit').prop('disabled', false);
                $('#val_receit').prop('disabled', false);

            }else {
                $('#to_id').prop('disabled', false);
                $('#no_receit').prop('disabled', true);
                $('#val_receit').prop('disabled', true);

            }
        });
    
    </script>
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>

<script>
    $(function () {
      
        var table = $('#kt_datatable_table').DataTable({
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
                url: "{{ route('admin.trans_dels.indexsite') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'name', name: 'name'},
                {data: 'actions', name: 'actions'},
                {data: 'info', name: 'info'},
                {data: 'description', name: 'description'},
            ]
        });

        table.buttons().container().appendTo($('.dbuttons'));
        
        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        // const maritalStatus = document.querySelector('#marital_status');
        // maritalStatus.addEventListener('change', function () {
        //         table.draw();
        //     });
        
        
        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){
            event.preventDefault();
            var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){
            return $(this).val();
            }).get(); // <----

            if (checkIDs.length > 0) {
                var token = $(this).data("token");
                
                Swal.fire({
                    title: 'هل انت متأكد ؟',
                    text: "لا يمكن استرجاع البيانات المحذوفه",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger m-l-10',
                    confirmButtonText: 'موافق',
                    cancelButtonText: 'لا'
                }).then(function (isConfirm) {
                    if (isConfirm.value) {
                        $.ajax(
                        {
                            url: "{{route('admin.employees.delete')}}",
                            type: 'post',
                            dataType: "JSON",
                            data: {
                                "id": checkIDs,
                                "_method": 'post',
                                "_token": token,
                            },
                            success: function (data) {
                                if(data.message == "success") {
                                    table.draw();
                                    toastr.success("", "تم الحذف بنجاح");
                                } else {
                                    toastr.success("", "عفوا لم يتم الحذف");
                                }
                            },
                            fail: function(xhrerrorThrown){
                                toastr.success("", "عفوا لم يتم الحذف");
                            }
                        });
                    } else {
                        console.log(isConfirm);
                    }
                });
            } else {
                toastr.error("", "حدد العناصر اولا");
            }        

        });
    });
</script>
<script>
    $(function () {
      
        var table = $('#kt_datatable_table1').DataTable({
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
                url: "{{ route('admin.trans_dels.indexsiteondel') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'name', name: 'name'},
                {data: 'actions', name: 'actions'},
                {data: 'info', name: 'info'},
                {data: 'description', name: 'description'},
            ]
        });

        table.buttons().container().appendTo($('.dbuttons'));
        
        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
        // filterSearch.addEventListener('keyup', function (e) {
        //     table.draw();
        // });
        // const maritalStatus = document.querySelector('#marital_status');
        // maritalStatus.addEventListener('change', function () {
        //         table.draw();
        //     });
        
        
        $('#submit').click(function(){
            $("#kt_modal_filter").modal('hide');
            table.draw();
        });

        $("#btn_delete").click(function(event){
            event.preventDefault();
            var checkIDs = $("#kt_datatable_table input:checkbox:checked").map(function(){
            return $(this).val();
            }).get(); // <----

            if (checkIDs.length > 0) {
                var token = $(this).data("token");
                
                Swal.fire({
                    title: 'هل انت متأكد ؟',
                    text: "لا يمكن استرجاع البيانات المحذوفه",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger m-l-10',
                    confirmButtonText: 'موافق',
                    cancelButtonText: 'لا'
                }).then(function (isConfirm) {
                    if (isConfirm.value) {
                        $.ajax(
                        {
                            url: "{{route('admin.employees.delete')}}",
                            type: 'post',
                            dataType: "JSON",
                            data: {
                                "id": checkIDs,
                                "_method": 'post',
                                "_token": token,
                            },
                            success: function (data) {
                                if(data.message == "success") {
                                    table.draw();
                                    toastr.success("", "تم الحذف بنجاح");
                                } else {
                                    toastr.success("", "عفوا لم يتم الحذف");
                                }
                            },
                            fail: function(xhrerrorThrown){
                                toastr.success("", "عفوا لم يتم الحذف");
                            }
                        });
                    } else {
                        console.log(isConfirm);
                    }
                });
            } else {
                toastr.error("", "حدد العناصر اولا");
            }        

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#kt_modal_1b').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var receiptId = button.data('id');
            var receiptno = button.data('no');
            var receiptva = button.data('va');
            var modal = $(this);
            modal.find('#receiptId').val(receiptId);
            modal.find('#no_receit').val(receiptno);
            modal.find('#val_receit').val(receiptva);
            modal.find('#receiptNumber').text('رقم الريسيت: ' + receiptId);
        });

        $('#added').click(function(e) {
            e.preventDefault();
            // Get the input element by its ID
            const azazInput = document.getElementById('azaz');
            // Set the value to 1
            azazInput.value = 5;
            // Submit the form (if needed)
            $('#kt_account_profile_details_form').submit();
        });
    });
    </script>


@endsection