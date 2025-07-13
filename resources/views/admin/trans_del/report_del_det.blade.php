@extends('admin.layout.master')

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
        <a  href="{{url('/admin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                عودة الى الرئيسية </h1></a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="#" class="text-muted text-hover-primary">تقرير بالمدة</a>
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
                <div class="row align-items-start">

                    <div class="row mb-6">
                            <input type="hidden" name="del_code" id="del_code" value="{{$del_code}}" />
                            <input type="hidden" name="fromdate" id="fromdate" value="{{$fromdate}}" />
                            <input type="hidden" name="todate" id="todate" value="{{$todate}}" />
                            

                            <div class="col-sm-1">
 
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="justify-content-center">
                            <span class="text-danger fs-1 fw-bold" id="dataname">{{$name_del->name_ar}}</span><br>
                            <span class="text-primary fs-1">من </span><span class="text-info fs-1" id="fromdatecarb" >{{$fromdate}}</span>
                            <span class="text-primary fs-1">الى </span><span class="text-info fs-1" id="todatecarb" >{{$todate}}</span>
                        <br>
                        
                        <div class="separator separator-content my-15">
                        </div>
                    </div>
                </div>
                    <div class="row align-items-start">
                        <div class="col-sm-12 p-3">
                            
                        </div>
                    
                    </div>
                <div class="row align-items-start">
                    <!--begin::Table-->
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
                                <th class="min-w-125px text-start">خروج من</th>
                                <th class="min-w-125px text-start">الحركة</th>
                                <th class="min-w-125px text-start">المدة</th>
                                <th class="min-w-125px text-start">المستلم</th>
                                <th class="min-w-125px text-start">{{trans('lang.start_from')}}</th>
                                
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
            </div>
    </div>
    <!--end::Container-->
@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dash/assets/plugins/custom/datatables/buttons.print.min.js')}}"></script>


<script>

        $(function () {
            const del_code = $('#del_code').val();
            const from_time = $('#fromdate').val();
            const to_time = $('#todate').val();
            // var asd = to_time.date(to_time);
            console.log(to_time);
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
              // },+ '/' + del_code + '/' + fromdate + '/' + todate
              // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
              // {
              //     extend: 'excel',
              //     className: 'btn btn-sm btn-icon btn-success btn-active-dark me-3 p-3',
              //     text: '<i class="bi bi-file-earmark-spreadsheet fs-1x"></i>'
              // },
              //{extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
          ],
          ajax: {
              url: "{{ route('admin.trans_dels.indexreport') }}"+ '/' + del_code + '/' + from_time + '/' + to_time ,
              data: function (d) {
                //   d.is_active = $('#is_active').val(),
               
                  d.del_code =  $('#del_code').val(),
                  d.from_time = $('#fromdate').val(),
                  d.to_time = $('#todate').val(),
                  d.search = $('#search').val()
              }
          },
          columns: [
              {data: 'checkbox', name: 'checkbox'},
              {data: 'name', name: 'name'},
              {data: 'info', name: 'info'},
              {data: 'description', name: 'description'},
              {data: 'note', name: 'note'},
              {data: 'start_time', name: 'start_time'},
              // {data: 'is_active', name: 'is_active'},
              // {data: 'actions', name: 'actions'},
          ]
      });

      table.buttons().container().appendTo($('.dbuttons'));
      
      // const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
      // filterSearch.addEventListener('keyup', function (e) {
      //     table.draw();
      // });
    //   const filterSearch = document.querySelector('[data-kt-db-table-filter="search"]');
    //   filterSearch.addEventListener('keyup', function (e) {

    //       table.draw();
    //   });

   
      
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


@endsection
