@extends('subadmin.layout.master')

@section('css')
@endsection

@section('style')
    
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/subadmin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('subadmin.trans_dels.index')}}" class="text-muted text-hover-primary"></a>
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
                <form action="{{route('subadmin.trans_dels.storemang')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form">
                    @csrf

                    <!--begin::Card body-->
                    <div class="card no-border">
                        <div class="row">
                            
                            <div class="col-6 border border-end">

                                <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required text-info fw-semibold fs-6">خروج من</label>
                                        <div class="col-sm-8">
                                                <select class="form-select " autofocus required aria-label="Select example" id="start_id" name="start_id" >
                                                    <option value="">من</option>
                                                    @foreach ($sites as $asd)
                                                            <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>

                                        </div>
    
                                        <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label required text-info fw-semibold fs-6">الطيار</label>
                                        <div class="col-lg-8 fv-row">
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
                                                <option value="2">اخرى</option>                                    
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
                                        <div class="col-lg-8 fv-row">
                                            <input type="number" name="no_receit" placeholder="رقم الريسيت" disabled value="" id="no_receit" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                        </div>
                                        </div>
    
                                        <div class="row mb-6">
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">ملاحظة</label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="note" placeholder="ملاحظة" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 text-center" />
                                        </div>
                                        </div>
    
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">حفظ</button>
                                        </div>
                                </div>
                                
                                
                                <div class="col-6">
                                    <div class="row mb-6 justify-content-md-center">
                                        <div class="col-sm-4">
                                            <label class="" for="start_idreq">من</label>
                                                <select class="form-select " autofocus required aria-label="Select example" id="start_idreq" name="start_idreq" >
                                                    <option value="">من</option>
                                                    @foreach ($sites as $asd)
                                                            <option value="{{ $asd->id }}" @if($asd->id == session()->get('insite')) selected @endif>{{ $asd->name }}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="" for="type_tranreq">النوع</label>
                                            <select   data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0 text-center" id="type_tranreq" name="type_tranreq">
                                                    <option value="0">تحويل</option>
                                                    <option value="1">اوردر</option>                                    
                                                    <option value="2">اخرى</option>                                    
                                                </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="" for="to_idreq">الى</label>
                                                <select class="form-select" autofocus required aria-label="Select example" id="to_idreq" name="to_idreq" >
                                                        <option disabled selected>الى</option>
                                                        @foreach ($sites as $asd)
                                                        <option value="{{ $asd->id }}">{{ $asd->name }}</option>
                                                        @endforeach
                                                    </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="required text-info" for="to_idreq">الطيار</label>
                                                <select  data-placeholder="Select an option" class=" input-text form-control  form-select  mb-3 mb-lg-0" id="del_codereq"  name="del_codereq" data-control="select2" >
                                                    <option disabled  selected>Select an option</option>
                                                    @if(isset($dataemp))
                                                        @foreach ($dataemp as $item)
                                                                <option value="{{$item->id}}">{{$item->name_ar}}-{{$item->del_code}}</option>
                                                            @endforeach
                                                    @endif
                                                </select>
                                        </div>
                                        <div class="col-sm-2 ">
                                            <label class="" for="">اضافة</label>
                                            <a href="" id="added" class="btn btn-lg  btn-info btn-active-dark  align-middle container ">
                                                    <i class="bi bi-plus-square fs-1x"></i>
                                                </a>
                                        </div>
    
                                    </div>
                                    <div class="row mb-6">
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
                                                        <th class="min-w-125px text-start">الحركة</th>
                                                        <!-- <th class="min-w-125px text-start">الاجراء</th> -->
                                                        <!-- <th class="min-w-125px text-start">ملاحظة</th> -->
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

                                <div class="row mb-6">
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
                                                    <th class="min-w-125px text-start">الحركة</th>
                                                    <th class="min-w-125px text-start">الاجراء</th>
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

                </div>
            <!--end::Content-->
            <!--end::Actions-->
        </form>
        <!--end::Form-->
        </div>
    </div>

@endsection

@section('script')

<script>
    $('#type_tran').on('change', function() {
            var type_tran = $('#type_tran option:selected').val();
            if(type_tran == 0){
                $('#to_id').prop('disabled', false);
                $('#no_receit').prop('disabled', true);
            } else if(type_tran == 1){
                $('#to_id').prop('disabled', true);
                $('#no_receit').prop('disabled', false);
            } else {
                $('#no_receit').prop('disabled', true);
                $('#to_id').prop('disabled', true);

            }

        });
    
    </script>
<script>
    $('#type_tranreq').on('change', function() {
            var type_tranreq = $('#type_tranreq option:selected').val();
            if(type_tranreq == 0){
                $('#to_idreq').prop('disabled', false);
            } else if(type_tranreq == 1){
                $('#to_idreq').prop('disabled', true);
            } else {
                $('#to_idreq').prop('disabled', true);

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
                url: "{{ route('subadmin.trans_dels.index') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'name', name: 'name'},
                {data: 'info', name: 'info'},
                {data: 'actions', name: 'actions'},
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
                            url: "{{route('subadmin.employees.delete')}}",
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
                url: "{{ route('subadmin.trans_dels.index') }}",
                data: function (d) {
                    d.is_active = $('#is_active').val(),
                    d.search = $('#search').val()
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'name', name: 'name'},
                {data: 'info', name: 'info'},
                // {data: 'actions', name: 'actions'},
                // {data: 'description', name: 'description'},
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
                            url: "{{route('subadmin.employees.delete')}}",
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
$('#added').click(function(e) {
    e.preventDefault();
    // var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = {
        start_idreq: $('#start_idreq').val(),
        type_tranreq: $('#type_tranreq option:selected').val(),
        to_idreq: $('#to_idreq').val(),
        del_codereq: $('#del_codereq option:selected').val()
    };

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        url: "{{ route('subadmin.trans_dels.storemangwait') }}",
        type: 'post',
        // dataType: "JSON",
        data: formData, // Pass formData directly

        success: function(response) {
            // Handle success
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error); 

        }
    });
});
    </script>
@endsection