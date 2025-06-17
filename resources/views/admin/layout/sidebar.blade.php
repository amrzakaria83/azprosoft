<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 my-lg-2" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-6 mb-5">

            <div class="menu-item">
                <a class="menu-link" href="{{url('/admin')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">لوحة التحكم</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.users.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الشركات</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">المديرين</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.settings.edit', 1)}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الاعدادات العامة</span>
                </a>
            </div>
             <!-- temporary -->
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">اضافة حساب</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">شجرة الحسابات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الحسابات البنكية</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">استلام دفتر</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">اصدار شيك</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title"> الشيكات الصادرة</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.create')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">استلام شيك</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">المناطق</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">المخازن</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">المهام</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">طرق البيع</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الخزائن</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الوحدات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">اسباب رفض الشيكات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title"> مدفوعات للموظفين</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الوظائف</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الموردين</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">الاصناف</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{route('admin.employees.index')}}">
                    <span class="menu-icon">
                        <i class="fonticon-setting fs-2"></i>
                    </span>
                    <span class="menu-title">خصائص الاصناف</span>
                </a>
            </div>
            <!-- endtemporary -->

        </div>

    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->