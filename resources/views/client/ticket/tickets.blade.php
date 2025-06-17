
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="images/favicon.png" rel="icon" />
<title>Tax Invoice</title>
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
======================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<!-- Stylesheet
======================= -->
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/vendor/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/vendor/font-awesome/css/all.min.css"/>
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/css/stylesheet.css"/>
<style>
    body {
        font-family: 'Tajawal' !important;
    }
    .card-footer , .card-header{
        padding: 0.5rem 1rem;
        background: none; 

    }
    .card {
        border: none;
    }
    table {
      height: 4.1cm;
    }
    .table:not(.table-sm) > :not(caption) > * > * {
      padding: 1px;
    }
</style>
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container"> 
  
  <!-- Main Content -->
  <footer class="text-center">
    <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none" style="background: #000000;color: #ffffff !important;font-size: 18px;font-weight: bold;border: none !important;padding: 10px 25px;"> طباعه</a></div>
  </footer>
  <hr style="border-top: 2px dashed #000000;opacity: 1;color: #ffffff;">
  <main>

    <div class="card">
      
      <div class="card-body p-0">
        @foreach ($tickets as $tkts)
        
        <div class="table-responsive">
          <table class="table mb-0">

			        <tbody>

                    <tr>
                        <td class="col-4 text-end" style="border: none;">{!! DNS1D::getBarcodeSVG((string)$tkts["barcode"], 'C128',2,33,'black', false)!!}</td>
                        <td class="col-8 text-end" colspan="2" style="border: none;"><h5>{{Auth::user()->company_name}}</h5></td>
                    </tr>
                    <tr>
                      <td class="col-4 text-end" style="border: none;"><span class="">التاريخ : <span class="fs-5">{{$tkts['date']}}</span></span></td>
                      <td class="col-8 text-end" colspan="2" style="border: none;"><span class="">اسم المشروع : <span class="fs-5">{{$tkts['project']}}</span></span></td>
                    </tr>
                
                    <tr>
                        <td class="col-4 text-end" style="border: none;"><span class="">سعر الرد : <span class="fs-5">{{$tkts['price_rd']}}</span></span></td>
                        <td class="col-8 text-end" colspan="2" style="border: none;"><span class="">نوع الرد : <span class="fs-5">{{$tkts['name_rd']}}</span></span></td>
                    </tr>
                    <tr>
                        <td class="col-4 text-end" style="border: none;"><span class="">: رقم السيارة  <span class="fs-5"></span></span></td>
                        <td class="col-8 text-end" colspan="2" style="border: none;"><span class=""> رقم السند : <span class="fs-5">{{$tkts['barcode']}}</span></span></td>
                    </tr>
                    <tr>
                        <td class="col-4 text-end" style="border: none;"><span class="" >: توقيع المراقب  <span class="fs-5"></span></span></td>
                        <td class="col-4 text-end" style="border: none;"><span class="" >: التاريخ  <span class="fs-5"></span></span></td>
                        <td class="col-4 text-end" style="border: none;"><span class="">: اسم المؤسسة  <span class="fs-5"></span></span></td>
                    </tr>
              
            </tbody>

          </table>
        </div>
        <hr style="padding:7px 0px;border-top: 2px dashed #000000;opacity: 1;color: #ffffff;">
        @endforeach
      </div>

    </div>
  </main>

</div>

</body>

<script type="text/javascript">
    window.print();
    setTimeout("closePrintView()", 1000);

    function closePrintView() {
        document.location.href = "{{url('tickets/create')}}";
    }
</script>
</html>