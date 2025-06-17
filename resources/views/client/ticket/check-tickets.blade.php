@extends('client.layout.master')

@section('css')
    
@endsection

@section('style')
   <style>
    .printhead {
        display: none;
    }
        @media print {
            body > *:not(#cart) {
                display: none;
            }
            .printhead {
        display: block;
    }
            .cart {
                display: block;
                position: absolute;
                top: 0px;
            }
        }
    </style> 
@endsection

@section('breadcrumb')
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3 pt-6">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">فحص البطاقات </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{url('dashboard')}}" class="text-muted text-hover-primary">لوحة التحكم</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">فحص البطاقات</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
</div>
@endsection

@section('content')

<div id="kt_app_content_container" class="app-container container-fluid">
    <form action="#" class="d-print-none">
        <!--begin::Card-->
        <div class="card mb-5">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Compact form-->
                <div class="d-flex align-items-center">
                    <!--begin::Input group-->
                    <div class="position-relative w-md-400px me-md-2">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" class="form-control form-control-solid ps-10" name="itm_ticket" value="" id="itm_ticket" placeholder="رقم البطاقه سكان" />
                    </div>
                    <!--end::Input group-->
                    <div class="position-relative w-md-400px me-md-2">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" class="form-control form-control-solid ps-10" name="itm_ticket_manal" value="" id="itm_ticket_manal" placeholder="رقم البطاقه يدوي" />
                    </div>
                    <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn border text-black-50 shadow-none" style="background: #000000;color: #ffffff !important;font-size: 18px;font-weight: bold;border: none !important;padding: 10px 25px;"> طباعه</a></div>
                </div>
                
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </form>

    <div class="card printhead">
        <!--begin::Card body-->
        <div class="card-body text-center" style="margin: -50px 0px 0px 0px">
            <h2>{{Auth::user()->company_name}}</h2>            
        </div>
        <!--end::Card body-->
    </div>

    <div class="separator separator-dashed mt-9 mb-6"></div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive border-bottom mb-9" id="cart">
                <table class="table align-middle table-rounded table-row-dashed fs-6">
                    <thead class="bg-light-dark pe-3">
                        <tr class="border-bottom fs-6 fw-bold text-bold">
                            <th class="min-w-25px p-3">م</th>
                            <th class="min-w-150px pb-2">اسم المشروع</th>
                            <th class="min-w-70px text-start pb-2">نوع الرد</th>
                            <th class="min-w-70px text-start pb-2">الكمية</th>
                            <th class="min-w-100px text-start pb-2">سعر الرد</th>
                            <th class="min-w-100px text-start pb-2">الاجمالي </th>
                            <th class="min-w-100px text-start p-3"><a href="javascript:;void(0)" class="text-danger" onclick="deleteCartall()">حذف الكل</a></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @php $totalcart = 0 ; @endphp
                        @foreach ($cartreport as $a => $cart)
                            @php $totalcart += $cart->qty * $cart->price_rd @endphp
                            <tr>
                                <td class="text-start">{{$a + 1}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-5">
                                            <div class="fw-bold">{{$cart->project}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-start">{{$cart->name_rd}}</td>
                                <td class="text-start">{{$cart->qty}}</td>
                                <td class="text-start">{{$cart->price_rd}}</td>
                                <td class="text-start">{{$cart->qty * $cart->price_rd}}</td>
                            </tr>
                        @endforeach
                
                        <tr>
                            <td colspan="5" class="fs-3 text-dark fw-bold text-end">الاجمالي</td>
                            <td class="text-dark fs-3 fw-bolder text-start">{{$totalcart}}</td>
                        </tr>
                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    window.onload = function () {
        document.getElementById("itm_ticket").focus();
    }

    var delayTimer;

        $("#itm_ticket").on("input", function() {
            var itm_ticket = $("#itm_ticket").val();          
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {

            $.ajax({
                type: "GET",
                url: "{{route('client.tickets.itemticket')}}", 
                data: {"itm_ticket": itm_ticket},
                success: function (data) {
                    // var audio = new Audio("{{ URL::asset('public/adminAssets/ar/barcode-beep.mp3') }}");
                    // audio.volume = .5;
                    // audio.play();
        

                    if(data.msg) {
                        if(data.msg == "faild") {
                            toastr.error("", "عفوا ، البطاقة غير متوفر");
                        }
                        document.getElementById('itm_ticket').value = '';
                        document.getElementById("itm_ticket").focus();
                    } else {
                        toastr.success("", "تم اضافة البطاقة بنجاح");
                        document.getElementById('itm_ticket').value = '';
                        document.getElementById("itm_ticket").focus();
                        $("#cart").html(data);
                    }
                }
            });

            }, 300);  
            
        });

    $('#itm_ticket_manal').keyup(function (e) {
        if ((e.keyCode || e.which) == 39) {
            var itm_ticket_manal = $("#itm_ticket_manal").val();
            $.ajax({
                type: "GET",
                url: "{{route('client.tickets.itemticket')}}", 
                data: {"itm_ticket": itm_ticket_manal},
                success: function (data) {
                    // var audio = new Audio("{{ URL::asset('public/adminAssets/ar/barcode-beep.mp3') }}");
                    // audio.volume = .5;
                    // audio.play();
        

                    if(data.msg) {
                        if(data.msg == "faild") {
                            toastr.error("", "عفوا ، البطاقة غير متوفر");
                        }
                        document.getElementById('itm_ticket_manal').value = '';
                        document.getElementById("itm_ticket_manal").focus();
                    } else {
                        toastr.success("", "تم اضافة البطاقة بنجاح");
                        document.getElementById('itm_ticket_manal').value = '';
                        document.getElementById("itm_ticket_manal").focus();
                        $("#cart").html(data);
                    }
                }
            });
        }
    });

    function deleteCart(id) {
        // var id = $(this).data('id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('tickets/deletecart')}}",
            data: {"id": id},
            success: function (data) {
                $("#cart").html(data);

            }
        })
    }

    function deleteCartall() {
        // var id = $(this).data('id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('tickets/alldeletordercart')}}",
            data: {"id": "all"},
            success: function (data) {
                $("#cart").html(data);

            }
        })
    }
</script>
@endsection