<!-- Human Resources Menu -->
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="human_resoursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
              <button type="button" class="btn btn-info btn-lg fs-3">{{trans('lang.human_resourse')}}</button>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="human_resoursesDropdown">
              <!-- Attendance Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Attendance Management</li> --}}
              <li>
                <a class="dropdown-item py-3" href="{{route('admin.attendances.index')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-clipboard-list"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.reports')}} {{trans('lang.attendance')}}</span>
                </a>
              </li>
              
              <!-- Employees Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Employee Management</li> --}}
              <li>
                <a class="dropdown-item py-3" href="{{route('admin.employees.index')}}">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-users"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.administrators')}}</span>
                </a>
              </li>

              <!-- work_hours Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="work_hourDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.work_hours')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="work_hourDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_plan_atts.create')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-plus-circle"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.work_hours')}} {{trans('lang.employee')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_plan_atts.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.work_hours')}} {{trans('lang.administrators')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- overtime Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="overtimeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.overtime')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="overtimeDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_att_overtimes.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.requests')}} {{trans('lang.overtime')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_att_overtimes.create_bymanger')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.overtime')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Hierarchy Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="hierarchyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.hierarchy')}} {{trans('lang.administrators')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="hierarchyDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.hierarchy_emps.create')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-plus-circle"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.hierarchy')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.hierarchy_emps.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.view')}} {{trans('lang.hierarchy')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Permissions Submenu -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="permissionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-sitemap"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.permission_atts')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="permissionDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_att_permissions.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.requests')}} {{trans('lang.permission_att')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_att_permissions.indexall')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.permission_atts')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Vacation & Permissions Section -->
              {{-- <li class="dropdown-header py-2 px-3 fs-4 text-muted">Time Off Management</li> --}}
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="vacationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-calendar-days"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.vacation')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="vacationDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.vacationemps.create')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-paper-plane"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.request')}} {{trans('lang.vacation')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.vacationemps.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.requests')}} {{trans('lang.vacation')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.vacationemps.indexall')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list-check"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.vacations')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              
              <!-- Rewards & Penalties Section -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="penaltiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-scale-balanced"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.penalties')}} & {{trans('lang.rewards')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="penaltiesDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_actions.create')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-plus-circle"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.action')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_actions.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.all')}} {{trans('lang.actions')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
              
              <!-- Salary Management Section -->
              <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle py-3" href="#" id="salarysDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,8">
                  <span class="menu-icon me-3">
                    <i class="fa-solid fa-money-bill-wave"></i>
                  </span>
                  <span class="menu-title fs-3">{{trans('lang.salary')}}</span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="dropdown-menu dropdown-submenu-lg" aria-labelledby="salarysDropdown">
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_salarys.create')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-plus-circle"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.add')}} {{trans('lang.salary')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_salarys.index')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-list"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.view')}} {{trans('lang.salaries')}}</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item py-3" href="{{route('admin.emp_monthly_salarys.create_m_sa')}}">
                      <span class="menu-icon me-3">
                        <i class="fa-solid fa-calendar"></i>
                      </span>
                      <span class="menu-title fs-3">{{trans('lang.month')}} {{trans('lang.salary')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>