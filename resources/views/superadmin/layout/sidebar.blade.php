<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 my-lg-2" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-6 mb-5">
            
        <div>
                        <!--begin::Toggle-->
                        <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">
                            رسائل
                            <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>
                        </button>
                        <!--end::Toggle-->

                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a class="menu-link" href="{{route('superadmin.messages.create')}}" target="-blank">
                                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                                    <span class="menu-title">ارسال رسالة</span></a>
                                </div></a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <div class="separator mb-3 opacity-75"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('superadmin.messages.inbox')}}" target="-blank">
                                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                                    <span class="menu-title">جميع الرسائل</span></a>
                            </div>
                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('superadmin.employees.index')}}" target="-blank">
                                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                                    <span class="menu-title">جميع الموظفين</span></a>
                            </div>
                            <!--begin::Menu item-->
                            {{-- <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                <!--begin::Menu item-->
                                <a href="#" class="menu-link px-3">
                                    <span class="menu-title">New Group</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <!--end::Menu item-->

                                <!--begin::Menu sub-->
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Admin Group
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Staff Group
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Member Group
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu sub-->
                            </div> --}}
                            <!--end::Menu item-->


                            <!--begin::Menu separator-->
                            <div class="separator mt-3 opacity-75"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            {{-- <div class="menu-item px-3">
                                <div class="menu-content px-3 py-3">
                                    <a class="btn btn-light-primary btn-sm px-4" href="#">
                                        Generate Reports
                                    </a>
                                </div>
                            </div> --}}
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
            </div>
            <!--<div>-->
                        <!--begin::Toggle-->
            <!--            <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--                طلبات الشراء-->
            <!--                <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--            </button>-->
                        <!--end::Toggle-->

                        <!--begin::Menu-->
            <!--            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                            <!--begin::Menu item-->
            <!--                <div class="menu-item px-3">-->
            <!--                    <a class="menu-link" href="{{route('superadmin.pur_drug_requests.create')}}" target="-blank">-->
            <!--                    <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                        <span class="menu-title">طلب شراء ادوية</span></a>-->
            <!--                    </div></a>-->
            <!--                </div>-->
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
            <!--                <div class="separator mb-3 opacity-75"></div>-->
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
            <!--                <div class="menu-item">-->
            <!--                    <a class="menu-link" href="{{route('superadmin.pur_drug_requests.index')}}" target="-blank">-->
            <!--                        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                        <span class="menu-title">متابعة طلبات الشراء</span></a>-->
            <!--                </div>-->
                            <!--begin::Menu item-->
            <!--                {{-- <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">-->
                                <!--begin::Menu item-->
            <!--                    <a href="#" class="menu-link px-3">-->
            <!--                        <span class="menu-title">New Group</span>-->
            <!--                        <span class="menu-arrow"></span>-->
            <!--                    </a>-->
                                <!--end::Menu item-->

                                <!--begin::Menu sub-->
            <!--                    <div class="menu-sub menu-sub-dropdown w-175px py-4">-->
                                    <!--begin::Menu item-->
            <!--                        <div class="menu-item px-3">-->
            <!--                            <a href="#" class="menu-link px-3">-->
            <!--                                Admin Group-->
            <!--                            </a>-->
            <!--                        </div>-->
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
            <!--                        <div class="menu-item px-3">-->
            <!--                            <a href="#" class="menu-link px-3">-->
            <!--                                Staff Group-->
            <!--                            </a>-->
            <!--                        </div>-->
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
            <!--                        <div class="menu-item px-3">-->
            <!--                            <a href="#" class="menu-link px-3">-->
            <!--                                Member Group-->
            <!--                            </a>-->
            <!--                        </div>-->
                                    <!--end::Menu item-->
            <!--                    </div>-->
                                <!--end::Menu sub-->
            <!--                </div> --}}-->
                            <!--end::Menu item-->


                            <!--begin::Menu separator-->
            <!--                <div class="separator mt-3 opacity-75"></div>-->
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
            <!--                {{-- <div class="menu-item px-3">-->
            <!--                    <div class="menu-content px-3 py-3">-->
            <!--                        <a class="btn btn-light-primary btn-sm px-4" href="#">-->
            <!--                            Generate Reports-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                </div> --}}-->
                            <!--end::Menu item-->
            <!--            </div>-->
                        <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                            <!--begin::Toggle-->
            <!--                <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--                    الحسابات-->
            <!--                    <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--                </button>-->
                            <!--end::Toggle-->

                            <!--begin::Menu-->
            <!--                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                                <!--begin::Menu item-->
            <!--                    {{-- <div class="menu-item px-3">-->
            <!--                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>-->
            <!--                    </div> --}}-->
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
            <!--                    <div class="separator mb-3 opacity-75"></div>-->
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
            <!--                    <div class="menu-item">-->
            <!--                        <a class="menu-link" href="{{route('superadmin.cashiers.index')}}" target="-blank">-->
            <!--                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                            <span class="menu-title">الخزائن</span></a>-->
            <!--                    </div>-->
            <!--                    <div class="menu-item">-->
            <!--                        <a class="menu-link" href="{{route('superadmin.cashiers.get_cash_money_trans')}}" target="-blank">-->
            <!--                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">صرف نقدية</span></a>-->
            <!--                    </div>-->
            <!--                    <div class="menu-item">-->
            <!--                        <a class="menu-link" href="{{route('superadmin.cashiers.get_recivedcash_money_trans')}}" target="-blank">-->
            <!--                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">استلام نقدية</span></a>-->
            <!--                    </div>-->

                                <!--begin::Menu separator-->
            <!--                    <div class="separator mt-3 opacity-75"></div>-->
                                <!--end::Menu separator-->

                                <!--end::Menu item-->
            <!--                </div>-->
                            <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                        <!--begin::Toggle-->
            <!--            <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--                التحويلات-->
            <!--                <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--            </button>-->
                        <!--end::Toggle-->

                        <!--begin::Menu-->
            <!--            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                            <!--begin::Menu item-->
            <!--                <div class="menu-item px-3">-->
            <!--                    <a class="menu-link" href="{{route('superadmin.drug_requests.create')}}" target="-blank">-->
            <!--                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                            <span class="menu-title">طلب تحويل ادوية</span></a>-->
            <!--                    </div>-->
            <!--                </div>-->
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
            <!--                <div class="separator mb-3 opacity-75"></div>-->
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->

            <!--                <div class="menu-item">-->
            <!--                    <a class="menu-link" href="{{route('superadmin.drug_requests.index')}}" target="-blank"><span class="menu-icon"><i class="fonticon-setting fs-2"></i></span><span class="menu-title">متابعة طلبات التحوبل</span></a>-->
            <!--                </div>-->

                            <!--begin::Menu separator-->
            <!--                <div class="separator mt-3 opacity-75"></div>-->
                            <!--end::Menu separator-->

                            <!--end::Menu item-->
            <!--            </div>-->
                        <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                    <!--begin::Toggle-->
            <!--        <button type="button" class="btn btn-primary rotate container fw-bold fs-2  container" data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--            الجرد-->
            <!--            <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--        </button>-->
                    <!--end::Toggle-->

                    <!--begin::Menu-->
            <!--        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                        <!--begin::Menu item-->
            <!--            <div class="menu-item px-3">-->
            <!--                <a class="menu-link" href="{{route('superadmin.inventory_requests.create')}}" target="-blank">-->
            <!--                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title">طلب جرد صنف</span></a>-->
            <!--                </div>-->
            <!--            </div>-->
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
            <!--            <div class="separator mb-3 opacity-75"></div>-->
                        <!--end::Menu separator-->

                        <!--begin::Menu item-->
            <!--            {{-- <div class="menu-item">-->
            <!--                <a class="menu-link" href="{{route('superadmin.inventory_requests.create')}}" target="-blank">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title">طلب جرد صنف</span></a>-->
            <!--            </div> --}}-->
            <!--            <div class="menu-item">-->
            <!--                <a class="menu-link" href="{{route('superadmin.inventory_requests.index')}}" target="-blank">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title">متابعة جرد صيدلية</span></a>-->
            <!--            </div>-->
            <!--            <div class="menu-item">-->
            <!--                <a class="menu-link" href="{{route('superadmin.inventory_requests.indexprod')}}" target="-blank">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title">متابعة جرد صنف</span></a>-->
            <!--            </div>-->
                        <!--begin::Menu separator-->
            <!--            <div class="separator mt-3 opacity-75"></div>-->
                        <!--end::Menu separator-->
                        <!--end::Menu item-->
            <!--        </div>-->
                    <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                    <!--begin::Toggle-->
            <!--        <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--            الموظفين-->
            <!--            <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--        </button>-->
                    <!--end::Toggle-->

                    <!--begin::Menu-->
            <!--        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                        <!--begin::Menu item-->
            <!--            <div class="menu-item px-3">-->
            <!--                <a class="menu-link" href="{{route('superadmin.employees.index')}}" target="-blank">-->
            <!--                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                    <span class="menu-icon">-->
            <!--                        <i class="fonticon-setting fs-2"></i></span>-->
            <!--                        <span class="menu-title">الموظفين</span></a>-->
            <!--                </div>-->
            <!--            </div>-->
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
            <!--            <div class="separator mb-3 opacity-75"></div>-->
                        <!--end::Menu separator-->

                        <!--begin::Menu item-->

            <!--            <div class="menu-item">-->
            <!--                <a class="menu-link" href="{{route('superadmin.attendances.index_all')}}" target="-blank">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title"> تقرير الحضور </span></a>-->
            <!--            </div>-->
            <!--            <div class="menu-item">-->
            <!--                <a class="menu-link" href="{{route('superadmin.attendances.index_in')}}" target="-blank">-->
            <!--                    <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                    <span class="menu-title"> الموظفين الحاضرين </span></a>-->
            <!--            </div>-->

            <!--                <div class="menu-item">-->
            <!--                    <a class="menu-link" href="{{route('superadmin.attendances.plan_att')}}" target="-blank">-->
            <!--                        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                        <span class="menu-title">خطة </span></a>-->
            <!--                </div>-->
            <!--                <div class="menu-item">-->
            <!--                    <a class="menu-link " href="{{route('superadmin.attendances.plan_att_emp_vacation')}}" target="-blank">-->
            <!--                        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                        <span class="menu-title">اذن موظف</span></a>-->
            <!--                </div>-->
                        <!--begin::Menu separator-->
            <!--            <div class="separator mt-3 opacity-75"></div>-->
                        <!--end::Menu separator-->
                        <!--end::Menu item-->
            <!--        </div>-->
                    <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                <!--begin::Toggle-->
            <!--    <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--        طيار {{$settings->append_name}}-->
            <!--        <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--    </button>-->
                <!--end::Toggle-->

                <!--begin::Menu-->
            <!--    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                    <!--begin::Menu item-->
            <!--        <div class="menu-item px-3">-->
            <!--            <a class="menu-link" href="{{route('superadmin.order_ph_requests.create')}}" target="-blank">-->
            <!--            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تسكين دليفرى لاوردر</span></a>-->
            <!--            </div>-->
            <!--        </div>-->
                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
            <!--        <div class="separator mb-3 opacity-75"></div>-->
                    <!--end::Menu separator-->

                    <!--begin::Menu item-->
            <!--        {{-- <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.order_ph_requests.create')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تسكين دليفرى لاوردر</span></a>-->
            <!--        </div> --}}-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.order_ph_requests.index')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">الاستعلام عن دليفرى لاوردر</span></a>-->
            <!--        </div>-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.trans_ph_requests.create')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تسكين دليفرى لتحويل</span></a>-->
            <!--        </div>-->
                    <!--begin::Menu separator-->
            <!--        <div class="separator mt-3 opacity-75"></div>-->
                    <!--end::Menu separator-->
                    <!--end::Menu item-->
            <!--    </div>-->
                <!--end::Menu-->
            <!--</div>-->

            <!--<div>-->
                <!--begin::Toggle-->
            <!--    <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--        الاصناف {{$settings->append_name}}-->
            <!--        <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--    </button>-->
                <!--end::Toggle-->

                <!--begin::Menu-->
            <!--    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                    <!--begin::Menu item-->
            <!--        <div class="menu-item px-3">-->
            <!--            <a class="menu-link" href="{{route('superadmin.products.index')}}" target="-blank">-->
            <!--                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">الاصناف</span></a>-->
            <!--            </div>-->
            <!--        </div>-->
                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
            <!--        <div class="separator mb-3 opacity-75"></div>-->
                    <!--end::Menu separator-->

                    <!--begin::Menu item-->

                    
                    <!--begin::Menu separator-->
            <!--        <div class="separator mt-3 opacity-75"></div>-->
                    <!--end::Menu separator-->
                    <!--end::Menu item-->
            <!--    </div>-->
                <!--end::Menu-->
            <!--</div>-->
            <!--<div>-->
                <!--begin::Toggle-->
            <!--    <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--        عملاء {{$settings->append_name}}-->
            <!--        <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--    </button>-->
                <!--end::Toggle-->

                <!--begin::Menu-->
            <!--    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                    <!--begin::Menu item-->
            <!--        <div class="menu-item px-3">-->
            <!--            <a class="menu-link" href="{{route('superadmin.azcustomers.index')}}" target="-blank">-->
            <!--                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">استرجاع عملاء</span></a>-->
            <!--            </div>-->
            <!--        </div>-->
                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
            <!--        <div class="separator mb-3 opacity-75"></div>-->
                    <!--end::Menu separator-->

                    <!--begin::Menu item-->

            <!--        {{-- <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.products.index')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">الاستعلام عن دليفرى لاوردر</span></a>-->
            <!--        </div>-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.products.create')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تسكين دليفرى لتحويل</span></a>-->
            <!--        </div> --}}-->
                    <!--begin::Menu separator-->
            <!--        <div class="separator mt-3 opacity-75"></div>-->
                    <!--end::Menu separator-->
                    <!--end::Menu item-->
            <!--    </div>-->
                <!--end::Menu-->
            <!--</div>-->
            <div>
                <!--begin::Toggle-->
                <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">
                    موردين {{$settings->append_name}}
                    <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>
                </button>
                <!--end::Toggle-->

                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a class="menu-link" href="{{route('superadmin.suppliers.create')}}" target="-blank">
                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                            <span class="menu-title">اضافة مورد</span></a>
                        </div>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
                    <div class="separator mb-3 opacity-75"></div>
                    <!--end::Menu separator-->

                    <!--begin::Menu item-->

                    <div class="menu-item">
                        <a class="menu-link" href="{{route('superadmin.suppliers.index')}}" target="-blank">
                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                            <span class="menu-title">جميع الموردين</span></a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{route('superadmin.suppliers.create_cat_supplier')}}" target="-blank">
                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                            <span class="menu-title">اضافة تصنيف للموردين</span></a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{route('superadmin.suppliers.index_category')}}" target="-blank">
                            <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>
                            <span class="menu-title">مراجعة تصنيف للموردين</span></a>
                    </div>
                    <!--begin::Menu separator-->
                    <div class="separator mt-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--<div>-->
                <!--begin::Toggle-->
            <!--    <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--        طيار ايه زد-->
            <!--        <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--    </button>-->
                <!--end::Toggle-->

                <!--begin::Menu-->
            <!--    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                    <!--begin::Menu item-->
            <!--        <div class="menu-item px-3">-->
            <!--            <a class="menu-link " href="{{route('superadmin.delevery_cos.index')}}" target="-blank">-->
            <!--                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تحكم الطياريين </span></a>-->
            <!--            </div>-->
            <!--        </div>-->
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
            <!--        <div class="separator mb-3 opacity-75"></div>-->
                    <!--end::Menu separator-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.delevery_cos.del_report_index')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">الاستعلام عن حركات طيار</span></a></div>-->
            <!--        </div>-->

            <!--</div>-->
            <!--<div>-->
                <!--begin::Toggle-->
            <!--    <button type="button" class="btn btn-primary rotate container fw-bold fs-2 " data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-offset="30px, 30px">-->
            <!--        شحن {{$settings->append_name}}-->
            <!--        <span class="svg-icon fs-3 rotate-180 ms-3 me-0">...</span>-->
            <!--    </button>-->
                <!--end::Toggle-->

                <!--begin::Menu-->
            <!--    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">-->
                    <!--begin::Menu item-->

                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
            <!--        <div class="separator mb-3 opacity-75"></div>-->
                    <!--end::Menu separator-->

                    <!--begin::Menu item-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.shippings.create')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">طلب شحن</span></a>-->
            <!--        </div>-->
            <!--        <div class="menu-item">-->
            <!--            <a class="menu-link" href="{{route('superadmin.shippings.shippingnone')}}" target="-blank">-->
            <!--                <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--                <span class="menu-title">تسكين شركة شحن</span></a>-->
            <!--        </div>-->
                    <!--begin::Menu separator-->
            <!--        <div class="separator mt-3 opacity-75"></div>-->
                    <!--end::Menu separator-->
                    <!--end::Menu item-->
            <!--    </div>-->
                <!--end::Menu-->
            <!--</div>-->


            <!--<div class="menu-item">-->
            <!--    <a class="menu-link" href="{{route('superadmin.sites.index')}}" target="-blank">-->
            <!--        <span class="menu-icon"><i class="fonticon-setting fs-2"></i></span>-->
            <!--        <span class="menu-title">المخازن</span></a>-->
            <!--</div>-->

        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
