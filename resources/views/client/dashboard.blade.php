@extends('client.layout.master')

@section('css')
    
@endsection

@section('style')
    
@endsection

@section('breadcrumb')

@endsection

@section('content')

<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card card-bordered">
        <div class="card-header py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">تقرير البطاقات</span>
                <span class="text-gray-400 mt-1 fw-semibold fs-6">البطاقات المستخدمه خلال عام</span>
            </h3>
        </div>
        <div class="card-body">
            <div id="kt_apexcharts_1" style="height: 350px;"></div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    
    var element = document.getElementById('kt_apexcharts_1');

    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--bs-dark');
    var borderColor = KTUtil.getCssVariableValue('--bs-dark');
    var baseColor = KTUtil.getCssVariableValue('--bs-primary');
    var secondaryColor = KTUtil.getCssVariableValue('--bs-primary');


    var options = {
        series: [{
            name: 'البطاقات المستخدة',
            data: ["{{$count_used[0]}}", "{{$count_used[1]}}", "{{$count_used[2]}}", "{{$count_used[3]}}", "{{$count_used[4]}}", "{{$count_used[5]}}", "{{$count_used[6]}}", "{{$count_used[7]}}", "{{$count_used[8]}}", "{{$count_used[9]}}", "{{$count_used[10]}}", "{{$count_used[11]}}"],
        },{
            name: 'البطاقات الغير المستخدة',
            data: ["{{$count_user[0]}}", "{{$count_user[1]}}", "{{$count_user[2]}}", "{{$count_user[3]}}", "{{$count_user[4]}}", "{{$count_user[5]}}", "{{$count_user[6]}}", "{{$count_user[7]}}", "{{$count_user[8]}}", "{{$count_user[9]}}", "{{$count_user[10]}}", "{{$count_user[11]}}"],
        }],
        chart: {
            fontFamily: 'inherit',
            type: 'bar',
            height: height,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: ['30%'],
                endingShape: 'rounded'
            },
        },
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ["شهر {{$month_result[0][0]}}", "شهر {{$month_result[0][1]}}", "شهر {{$month_result[0][2]}}", "شهر {{$month_result[0][3]}}", "شهر {{$month_result[0][4]}}", "شهر {{$month_result[0][5]}}", "شهر {{$month_result[0][6]}}", "شهر {{$month_result[0][7]}}","شهر {{$month_result[0][8]}}", "شهر {{$month_result[0][9]}}", "شهر {{$month_result[0][10]}}","شهر {{$month_result[0][11]}}"],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                }
            }
        },
        fill: {
            opacity: 1
        },
        states: {
            normal: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            hover: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            active: {
                allowMultipleDataPointsSelection: false,
                filter: {
                    type: 'none',
                    value: 0
                }
            }
        },
        tooltip: {
            style: {
                fontSize: '12px'
            },
            y: {
                formatter: function (val) {
                    return  val 
                }
            }
        },
        colors: [baseColor, secondaryColor],
        grid: {
            borderColor: borderColor,
            strokeDashArray: 4,
            yaxis: {
                lines: {
                    show: true
                }
            }
        }
    };

    var chart = new ApexCharts(element, options);
    chart.render();
</script>
@endsection