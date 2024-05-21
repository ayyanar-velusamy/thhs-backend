@extends('layouts.app')
@section('content')
    <!-- Dashboard Table --> 
    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center"> 
            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Status: </label>
                <select class="form-control" id="filter_status">
                    <option value="">All</option>  
                    <option value='<span class="tag active">Active</span>'>Active</option>
                    <option value='<span class="tag deactivate">Inactive</span>'>Inactive</option> 
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>User Role</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p type="button" onclick="openPopup('role')">
                        Add Role
                    </p>
                </div>
            </div>
        </div>
        <table class="w-100" id="role_datatable">
            <thead>
                <tr>
                    <th>Role name</th>
                    <th>Status</th>  
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($role_list as $role)
                    <tr>
                        @php
                            if ($role->status == 1) {
                                $status = 'Active';
                            } else {
                                $status = 'Inactive';
                            }
                        @endphp
                        <td class="dt-center align-items-center">
                            {{ $role->role }}
                        </td>  
                        <td><span class="tag {{ $role->status == 2 ? 'deactivate' : 'active' }}">{{ $status }}</span></td> 
                        <td class="icons dt-center justify-content-center" style="padding-top:20px">
                            {{-- <a title="View Staff" href="{{ route('staffs.demographics', [$chart->id]) }}"><i
                                    class="icon icon-eye-green"></i></a> --}}
                            <a title="Edit Role" href="#" onclick="getData({{ $role->id }})">
                                <i class="icon icon-edit"></i></a>
                            <a title="Delete Chart" href="#" id="delete_role_btn"
                                data-url="{{ @route('delete_role', [$role->id]) }}"
                                onclick="delete_role_confirmation()">
                                <i class="icon icon-delete"></i></a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper with-data-table d-flex justify-content-center align-items-center pt-0">
            <!-- <div class="count-text">
                                                                                                                        <p>Showing data 1 to 8 of 256 entries</p>
                                                                                                                      </div> -->
            <!-- <div class="data-section d-flex justify-content-between align-items-center gap-4">
                <div class="green d-flex justify-content-center align-items-center">
                    <span></span>
                    <p>All clear</p>
                </div>
                <div class="yellow d-flex justify-content-center align-items-center">
                    <span></span>
                    <p>Doc about to expire</p>
                </div>
                <div class="red d-flex justify-content-center align-items-center">
                    <span></span>
                    <p>Already expired</p>
                </div>
            </div> -->

        </div>
    </section>

    <!-- Add Role -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTitle">
                        Add Role
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="save_role_form" method="POST" class="ajax-form" action="{{ route('save_role') }}"
                        role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper d-block">
                                <label for="group">Role Name :<span class="mandate">*</span></label>
                                <input required type="text" name="role" id="role" placeholder="Role" />
                                <input type="hidden" name="id" id="id" />

                            </div>
                            <div class="field-wrapper d-block">
                                <label for="status">Status :<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <select required class="select-control" name="status">
                                        <option value="2">Inactive</option>
                                        <option value="1">Active</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="cta_wrapper d-flex justify-content-center gap-5">
                                <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                                <button class="success" id="save_role_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
