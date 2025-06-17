<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 my-lg-2" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-6 mb-5">

            <div class="menu-item">
                <a class="menu-link" href="{{url('/subadmin')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">لوحة التحكم</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.employees.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">الموظفين</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.sites.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">المخازن</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.drug_requests.create')}}" target="-blank">
                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">طلب تحويل ادوية</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.drug_requests.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">متابعة طلبات التحوبل</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.pur_drug_requests.create')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">طلب شراء ادوية</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.pur_drug_requests.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">متابعة طلبات الشراء</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.inventory_requests.create')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">طلب جرد صنف</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.inventory_requests.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">متابعة جرد صيدلية</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.inventory_requests.indexprod')}}" target="-blank">   <span class="menu-icon">       <i class="fonticon-setting fs-2"></i>   </span>   <span class="menu-title">متابعة جرد صنف</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.order_ph_requests.create')}}" target="-blank">   <span class="menu-icon">       <i class="fonticon-setting fs-2"></i>   </span>   <span class="menu-title">تسكين دليفرى لاوردر</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.order_ph_requests.index')}}" target="-blank">   <span class="menu-icon">       <i class="fonticon-setting fs-2"></i>   </span>   <span class="menu-title">الاستعلام عن دليفرى لاوردر</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.azcustomers.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">استرجاع عملاء  </span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.trans_ph_requests.create')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">تسكين دليفرى لتحويل</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.shippings.create')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">طلب شحن</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.shippings.shippingnone')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">تسكين شركة شحن</span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.attendances.index_all')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title"> تقرير الحضور </span></a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('subadmin.attendances.index_in')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title"> الموظفين الحاضرين </span></a>
            </div>
        </div>

    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
