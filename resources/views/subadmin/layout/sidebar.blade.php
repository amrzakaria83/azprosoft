<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 my-lg-2" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-6 mb-5">

            <div class="menu-item">
                <a class="menu-link" href="{{url('/subadmin')}}">
                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                    <span class="menu-title">لوحة التحكم</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.trans_dels.create')}}" target="-blank">
                    <span class="menu-icon">
                    <i class="fonticon-setting fs-2"></i></span>
                    <button class="menu-title">دليفرى الصيدلبة</button>
                </a>
            </div>
            
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.trans_dels.createmang')}}" target="-blank">
                    <span class="menu-icon">
                    <i class="fonticon-setting fs-2"></i></span>
                    <button class="menu-title bg-info">مشرف دليفرى</button>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.trans_dels.indexall')}}" target="-blank">
                    <span class="menu-icon">
                    <i class="fonticon-setting fs-2"></i></span>
                <button class="menu-title">الاستعلام عن حركة</button>
            </a>
            </div>
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.drug_requests.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">متابعة طلبات التحوبل</span></a>-->
            <!--</div>-->
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.order_ph_requests.create')}}" target="-blank">   <span class="menu-icon">       <i class="fonticon-setting fs-2"></i>   </span>   <span class="menu-title">تسكين دليفرى لاوردر</span></a>-->
            <!--</div>-->
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.order_ph_requests.index')}}" target="-blank">   <span class="menu-icon">       <i class="fonticon-setting fs-2"></i>   </span>   <span class="menu-title">الاستعلام عن دليفرى لاوردر</span></a>-->
            <!--</div>-->
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.cashiers.get_cash_money_trans')}}" target="-blank">-->
            <!--        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">صرف نقدية</span></a>-->
            <!--</div>-->
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.trans_ph_requests.create')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">تسكين دليفرى لتحويل</span></a>-->
            <!--</div>-->
            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('subadmin.delevery_cos.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">حركات التوصيل</span></a>-->
            <!--</div>-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
