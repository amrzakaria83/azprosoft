@php
$permissions = new Spatie\Permission\Models\Permission ;

if (isset($data)) {
    $role = Spatie\Permission\Models\Role::find($data->id);
}
@endphp

<div class="fv-row mb-10">
    <!--begin::Label-->
    <label class="fs-5 fw-bold form-label mb-2">
        <span class="required">{{trans('lang.role')}}</span>
    </label>
    <!--end::Label-->
    <!--begin::Input-->
    <!--end::Input-->
</div>

<div class="row mb-6">
    <label class="col-lg-2 col-form-label required fw-semibold fs-6">{{trans('page.name')}}</label>
    <div class="col-lg-10 fv-row">
        <input type="text" name="name" placeholder="{{trans('page.name')}}" value="{{old('name',$data->name ?? '')}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
    </div>
</div>


<div class="fv-row">
    <!--begin::Label-->
    <label class="fs-5 fw-bold form-label mb-2"></label>
    <!--end::Label-->
    <!--begin::Table wrapper-->
    <div class="table-responsive">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <!--begin::Table body-->
            <tbody class="text-gray-600 fw-semibold">
                <!--begin::Table row-->
                <tr>
                    <td class="text-gray-800">Administrator Access 
                    <span class="ms-1" data-bs-toggle="tooltip" title="Allows a full access to the system">
                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span></td>
                    <td>
                        <!--begin::Checkbox-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                            <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                            <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                        </label>
                        <!--end::Checkbox-->
                    </td>
                </tr>
                <!--end::Table row-->
                <tr>
                    <!--begin::Label-->
                    <td class="text-gray-800">{{trans('lang.human_resourse')}}</td>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <td>
                        <!--begin::Wrapper-->
                        <div class="d-flex">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('administrators')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('administrators')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">List</span>
                            </label>
                            <!--end::Checkbox-->
                            
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('administrators')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('administrators')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">{{trans('lang.all')}} {{trans('lang.administrators')}}</span>
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('all role')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('all role')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">{{trans('lang.all')}} {{trans('lang.role_id')}}</span>
                            </label>
                            <!--end::Checkbox-->
                            
                        </div>
                        <!--end::Wrapper-->
                    </td>
                    <!--end::Input group-->
                </tr>
                <tr>
                    <!--begin::Label-->
                    <td class="text-gray-800">{{trans('lang.sales')}} </td>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <td>
                        <!--begin::Wrapper-->
                        <div class="d-flex">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('sales')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('sales')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">List</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('bill_of_sale')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('bill_of_sale')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">Create</span>
                            </label>
                            
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Wrapper-->
                    </td>
                    <!--end::Input group-->
                </tr>
                <tr>
                    <!--begin::Label-->
                    <td class="text-gray-800">Roles </td>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <td>
                        <!--begin::Wrapper-->
                        <div class="d-flex">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('all role')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('all role')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">List</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('role new')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('role new')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">Create</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('role edit')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('role edit')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">Update</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('role delete')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('role delete')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">Delete</span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Wrapper-->
                    </td>
                    <!--end::Input group-->
                </tr>
                <tr>
                    <!--begin::Label-->
                    <td class="text-gray-800">Setting </td>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <td>
                        <!--begin::Wrapper-->
                        <div class="d-flex">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-3 me-lg-10">
                                <input class="form-check-input" type="checkbox" value="{{$permissions->findByName('setting')->id}}" {{ isset($data) ? $role->hasPermissionTo($permissions->findByName('setting')) ? 'checked' : '':'' }} name="permissions[]" />
                                <span class="form-check-label">Setting</span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Wrapper-->
                    </td>
                    <!--end::Input group-->
                </tr>
                <!--end::Table row-->

            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Table wrapper-->
</div>
