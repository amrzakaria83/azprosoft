@extends('superadmin.delevery_layout.master')

@section('css')

@endsection

@section('style')
<style>

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

    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card no-border">
                <div class="col-sm-4">
                    <ul class="fw-bold fs-7 my-1">
                        <li class="text-muted px-2">
                            <a  href="{{ route('superadmin.delevery_cos.index') }}" class="text-muted text-hover-primary fw-bold fs-2 ">-عودة طلب التوصيل</a>
                        </li>
                    </ul>
                    <label class="required fw-semibold fs-6 mb-2">التاريخ</label>
                    <div class="position-relative d-flex align-items-center">
                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <input class="form-control form-control-solid ps-12" name="to_date" placeholder="الى تاريخ" id="kt_datepicker_2" />
                    </div>

                </div>
                <canvas id="kt_chartjs_3" class="mh-400px"></canvas>
                {{-- <canvas id="kt_chartjs_2" class="mh-400px"></canvas> --}}
            </div>


    </div>
    <!--end::Container-->
@endsection

@section('script')

<script>
        var ctx1 = document.getElementById('kt_chartjs_3');

        // Define colors
        var primaryColor1 = '#221155';
        var dangerColor1 = 'red';

        // Define fonts
        var fontFamily1 = KTUtil.getCssVariableValue('--bs-font-sans-serif');

        // Chart labels
        const labels1 = ['12 am', '1 am', '2 am', '3 am', '4 am', '5 am', '6 am','7 am', '8 am', '9 am', '10 am', '11 am', '12 am',
        '1 pm','2 pm', '3 pm', '4 pm', '5 pm', '6 pm', '7 pm', '8 pm','9 pm', '10 pm', '11 pm', '12 pm'];

        // Chart data
        const data1 = {
            labels: labels1,
            datasets: [
                {
                    label: 'التثبيت',
                    borderColor: '#58e500',
                    backgroundColor: '#58e500',
                    data: ["{{$countstable[0]}}","{{$countstable[1]}}"
                    ,"{{$countstable[2]}}","{{$countstable[3]}}","{{$countstable[4]}}","{{$countstable[5]}}","{{$countstable[6]}}","{{$countstable[7]}}"
                    ,"{{$countstable[8]}}","{{$countstable[9]}}","{{$countstable[10]}}","{{$countstable[11]}}","{{$countstable[12]}}","{{$countstable[13]}}"
                    ,"{{$countstable[14]}}","{{$countstable[15]}}","{{$countstable[16]}}","{{$countstable[17]}}","{{$countstable[18]}}","{{$countstable[19]}}"
                    ,"{{$countstable[20]}}","{{$countstable[21]}}","{{$countstable[22]}}","{{$countstable[23]}}","{{$countstable[24]}}"]
                },
                {
                    label: 'طلبات التوصيل',
                    borderColor: '#0400e5',
                    backgroundColor: '#0400e5',
                    data: ["{{$countorder[0]}}","{{$countorder[1]}}"
                    ,"{{$countorder[2]}}","{{$countorder[3]}}","{{$countorder[4]}}","{{$countorder[5]}}","{{$countorder[6]}}","{{$countorder[7]}}"
                    ,"{{$countorder[8]}}","{{$countorder[9]}}","{{$countorder[10]}}","{{$countorder[11]}}","{{$countorder[12]}}","{{$countorder[13]}}"
                    ,"{{$countorder[14]}}","{{$countorder[15]}}","{{$countorder[16]}}","{{$countorder[17]}}","{{$countorder[18]}}","{{$countorder[19]}}"
                    ,"{{$countorder[20]}}","{{$countorder[21]}}","{{$countorder[22]}}","{{$countorder[23]}}","{{$countorder[24]}}"]
                },
                {
                    label: 'اوردرات الصيدلية',
                    borderColor: '#ff4545',
                    backgroundColor: '#ff4545',
                    data: ["{{$Order_ph[0]}}","{{$Order_ph[1]}}"
                    ,"{{$Order_ph[2]}}","{{$Order_ph[3]}}","{{$Order_ph[4]}}","{{$Order_ph[5]}}","{{$Order_ph[6]}}","{{$Order_ph[7]}}"
                    ,"{{$Order_ph[8]}}","{{$Order_ph[9]}}","{{$Order_ph[10]}}","{{$Order_ph[11]}}","{{$Order_ph[12]}}","{{$Order_ph[13]}}"
                    ,"{{$Order_ph[14]}}","{{$Order_ph[15]}}","{{$Order_ph[16]}}","{{$Order_ph[17]}}","{{$Order_ph[18]}}","{{$Order_ph[19]}}"
                    ,"{{$Order_ph[20]}}","{{$Order_ph[21]}}","{{$Order_ph[22]}}","{{$Order_ph[23]}}","{{$Order_ph[24]}}"]
                },
            ]
        };

        // Chart config
        const config1 = {
            type: 'line',
            data: data1,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: ' تاريخ اليوم :<?php echo $to_date; ?>',
                        font: {size: 30}
                    }
                },
                responsive: true,
            },
            defaults:{
                global: {
                    defaultFont: fontFamily1
                }
            }
        };

        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        var myChart1 = new Chart(ctx1, config1);


</script>
<script>
    // var today = new Date();
    // var dateString = today.toLocaleDateString(); // Format as needed
    // document.getElementById("datetoday").textContent = dateString;
    // $("#kt_datepicker_2").flatpickr({defaultDate: new Date(new Date().setDate(new Date().getDate() - 1))})
    $("#kt_datepicker_2").flatpickr({defaultDate: new Date(new Date().setDate(new Date().getDate() - 1))})

</script>

<script>
$('#kt_datepicker_2').on('change', function() {
    const to_date = $('#kt_datepicker_2').val();
    window.location = '{{ route("superadmin.delevery_cos.chart_del_search") }}/' + to_date;
    });

    </script>

{{-- <script>
            var ctx = document.getElementById('kt_chartjs_2');

            // Define colors
            var primaryColor = KTUtil.getCssVariableValue('--kt-primary');
            var dangerColor = KTUtil.getCssVariableValue('--kt-danger');

            // Define fonts
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            // Chart labels
            const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];


            // Chart data
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'first',
                        data: [5,1,3,4,5,6,7]
                    },
                    {
                        label: 'second',
                        data: [7,8,6,4,8,6,10]
                    }
                ]
            };
            // Chart config
            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: false,
                        }
                    },
                    responsive: true,
                },
                defaults:{
                    global: {
                        defaultFont: fontFamily
                    }
                }
            };
            // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
            var myChart = new Chart(ctx, config);
</script> --}}

@endsection
