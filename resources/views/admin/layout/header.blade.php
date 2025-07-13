<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Settings Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="createDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              <button type="button" class="btn btn-info btn-lg fs-3">{{trans('lang.settings')}}</button>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="createDropdown">
              <li>
                <a class="dropdown-item py-3" href="{{route('admin.product_imps.create')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-file-import"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.import')}} {{trans('lang.products')}}</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item py-3 bg-danger text-white" href="{{route('admin.settings.edit', 1)}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-gear"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.settings')}}</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item py-3" href="{{route('admin.messages.create')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-envelope"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.message')}}</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        @can('administrators')
       <!-- Human Resources Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="human_resoursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              <button type="button" class="btn btn-info btn-lg fs-3">{{trans('lang.human_resourse')}}</button>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="human_resoursesDropdown">
              
              <!-- Employees Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Employee Management</li> --}}
              @can('administrators')
              <!-- administrators Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="administratorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.administrators')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="administratorDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.employees.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.administrators')}}</span>
                    </a>
                  </li>
                  @can('all role')
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.roles.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.role_id')}}</span>
                    </a>
                  </li>
                  @endcan
                </ul>
              </li>
              @endcan
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="employeesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.employees')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="employeesDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emangeremps.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.employees')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_emp_atts.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.report')}} {{trans('lang.attendance')}}</span>
                    </a>
                  </li>
                
                </ul>
              </li>
              
            </ul>
          </li>
        </ul>
        @endcan
        <!-- purshase Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="purshasesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              <button type="button" class="btn btn-info btn-lg fs-3">{{trans('lang.purchases')}}</button>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="purshasesDropdown">
              
              <!-- Employees Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Employee Management</li> --}}
              @can('administrators')
              <!-- administrators Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="purshaseprodsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.purchases')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="purshaseprodsDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.employees.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.administrators')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="employeesssDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.employees')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="employeesssDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emangeremps.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.employees')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_emp_atts.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.report')}} {{trans('lang.attendance')}}</span>
                    </a>
                  </li>
                
                </ul>
              </li>
              
            </ul>
          </li>
        </ul>
        @can('sales')
       <!-- Human sales Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="salesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              <button type="button" class="btn btn-info btn-lg fs-3">{{trans('lang.sales')}}</button>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="salesDropdown">
            <li>
                <a class="dropdown-item py-3" href="{{route('admin.pro_customers.index')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-file-import"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.customers')}}</span>
                </a>
              </li>
              <!-- <li>
                <a class="dropdown-item py-3" href="{{route('admin.pro_products.index')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-file-import"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.products')}}</span>
                </a>
              </li> -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.reports')}} {{trans('lang.products')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="productsDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_products.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.products')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_prod_logs.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.movement')}} {{trans('lang.products')}}</span>
                    </a>
                  </li>
                  
                </ul>
              </li>
              <!-- Employees Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Employee Management</li> --}}
              @can('bill_of_sale')
              <!-- bill_of_sale Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="bill_of_saleDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.reports')}} {{trans('lang.sales')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="bill_of_saleDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_sales_hs.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.bills_of_sale')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_sales_dets.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.details')}} {{trans('lang.bills_of_sale')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_sales_dets.reportprodsaledet')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.report')}} {{trans('lang.sales')}} {{trans('lang.details')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_sales_dets.indextranssite')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.report')}} {{trans('lang.transfers')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_sales_dets.indexreportsale')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.report')}} {{trans('lang.sales')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="purchasesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.reports')}} {{trans('lang.purchases')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="purchasesDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_purchase_hs.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.purchases')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_purchase_ds.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.details')}} {{trans('lang.purchases')}}</span>
                    </a>
                  </li>
                  
                </ul>
              </li>
              @endcan
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="transfersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.reports')}} {{trans('lang.transfers')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="transfersDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_store_conv_hs.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.transfers')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.pro_prod_logs.index')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.movement')}} {{trans('lang.products')}}</span>
                    </a>
                  </li>
                  
                </ul>
              </li>
              @can('bill_of_sale')
              <!-- bill_of_sale Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="bill_of_saleDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.bill_of_sale')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="bill_of_saleDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.bill_sale_headers.create')}}">
                      <span class="menu-icon me-3">
                      <i class="fa-solid fa-users"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.bill_of_sale')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan
              
            </ul>
          </li>
        </ul>
        @endcan

        <!-- User Profile Menu -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-lg-45px" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              @if (Auth::guard('admin')->user()->getMedia('profile')->count())
                <img src="{{Auth::guard('admin')->user()->getFirstMediaUrl('profile')}}" alt="{{$settings->append_name}}" class="rounded-circle" />
              @else
                <img alt="{{$settings->append_name}}" src="{{asset('dash/assets/media/avatars/blank.png')}}" class="rounded-circle" />
              @endif
            </div>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
              <div class="d-flex flex-column align-items-center p-5">
                <div class="symbol symbol-70px mb-3">
                  @if (Auth::guard('admin')->user()->getMedia('profile')->count())
                    <img alt="{{$settings->append_name}}" src="{{Auth::guard('admin')->user()->getFirstMediaUrl('profile')}}" class="rounded-circle" />
                  @else
                    <img alt="{{$settings->append_name}}" src="{{asset('dash/assets/media/avatars/blank.png')}}" class="rounded-circle" />
                  @endif
                </div>
                <div class="text-center">
                  <div class="fw-bold fs-3 mb-1">{{Auth::guard('admin')->user()->name}}</div>
                  <div class="text-muted fs-6">{{Auth::guard('admin')->user()->email}}</div>
                </div>
              </div>
              <div class="separator my-0"></div>
              <div class="px-5 py-3">
                <a href="{{route('admin.employees.show', Auth::guard('admin')->id())}}" class="btn btn-light-primary w-100 py-2">
                  <i class="fa-solid fa-user me-2"></i> {{trans('auth.profile')}}
                </a>
              </div>
              <div class="px-5 py-3">
              @if (App::isLocale('en'))
                <a href="{{url('admin/lang-change?lang=ar')}}" class="btn btn-light-primary w-100 py-2">
                    <i class="fas fa-language fs-4"></i>
                    <span>{{trans('lang.arabic')}}</span>
                </a>
                @else
                <a href="{{url('admin/lang-change?lang=en')}}" class="btn btn-light-primary w-100 py-2">
                    <i class="fas fa-language fs-4"></i>
                    <span>{{trans('lang.english')}}</span>
                </a>
                @endif
                <!-- <a href="{{route('admin.employees.show', Auth::guard('admin')->id())}}" class="btn btn-light-primary w-100 py-2">
                  <i class="fa-solid fa-user me-2"></i> {{trans('lang.lang')}}
                </a> -->
              </div>
              <div class="px-5 pb-3">
                <a href="{{route('admin.logout')}}" class="btn btn-light-danger w-100 py-2">
                  <i class="fa-solid fa-right-from-bracket me-2"></i> {{trans('auth.logout')}}
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>