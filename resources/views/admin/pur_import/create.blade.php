@extends('admin.layout.master')

@section('css')
@endsection

@section('style')

@endsection

@section('breadcrumb')
<div class="d-flex align-items-center" id="kt_header_nav">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <a  href="{{url('/admin')}}">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                لوحة التحكم
            </h1>
        </a>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted px-2">
                <a  href="{{route('admin.store_pur_requests.index')}}" class="text-muted text-hover-primary">الموظفين</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted px-2">
                اضف جديد
            </li>
        </ul>
    </div>
    <!--end::Page title-->
</div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card mb-5 mb-xl-10">
        <div id="kt_account_settings_profile_details" class="collapse show">
            <form action="{{route('admin.pur_imports.import')}}" method="POST" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" autocomplete="off">
                @csrf
                <div class="card-body border-top">
                    <div class="row mb-6">
                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">File</label>
                        <div class="col-lg-8 fv-row">
                            <input type="file" name="excel_file" id="excel_file" placeholder="file" value="" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" accept=".xls,.xlsx" />
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
            

<!-- Column Mapping Modal -->
<div class="modal fade" id="columnMappingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Map Excel Columns</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="mappingForm" action="{{route('admin.pur_imports.import')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="file_path" id="file_path">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Database Field</th>
                                    <th>Excel Column</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{trans('lang.products')}} CODE</td>
                                    <td>
                                        <select name="product_id_column" class="form-select">
                                            <option value="">Select Column</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{trans('lang.quantity')}}</td>
                                    <td>
                                        <select name="quantity_column" class="form-select">
                                            <option value="">Select Column</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{trans('lang.balance')}}</td>
                                    <td>
                                        <select name="balance_req_column" class="form-select">
                                            <option value="">Select Column</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>
                                        <select name="note_column" class="form-select">
                                            <option value="">Select Column</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import with Mapping</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- JavaScript for handling the file and modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('excel_file');
    const originalForm = document.getElementById('kt_account_profile_details_form');
    
    if (fileInput && originalForm) {
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                // Prevent original form submission
                originalForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Read the file and extract headers
                const file = this.files[0];
                const formData = new FormData();
                formData.append('excel_file', file);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Show loading state
                const submitButton = document.getElementById('kt_account_profile_details_submit');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                }
                
                // Send to a temporary endpoint to get headers
                fetch('{{ route("admin.pur_imports.preview") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.headers) {
                        // Store the temporary file path
                        document.getElementById('file_path').value = data.file_path;
                        
                        // Get all select elements in the modal
                        const selects = document.querySelectorAll('#columnMappingModal select');
                        
                        // Populate each select with header options
                        selects.forEach(select => {
                            // Clear existing options except the first one
                            while (select.options.length > 1) {
                                select.remove(1);
                            }
                            
                            // Add new options
                            data.headers.forEach(header => {
                                const option = document.createElement('option');
                                option.value = header;
                                option.textContent = header;
                                select.appendChild(option);
                            });
                        });
                        
                        // Show the modal
                        const modalElement = document.getElementById('columnMappingModal');
                        if (modalElement) {
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error processing file: ' + error.message);
                })
                .finally(() => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Import';
                    }
                });
            }
        });
    } else {
        console.error('Required elements not found on the page');
    }
});
</script>
@endsection
