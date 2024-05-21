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
                    <option value='<span class="tag deactivate">Suspended</span>'>Suspended</option> 
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>User Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p onclick="openPopup('user')">Add User</p>
                </div>
            </div>
        </div>
        <table class="w-100" id="user_datatable">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Expire Date</th>
                    <th>Password Expire Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_list as $user)
                    <tr>
                        @php
                            if ($user->app_user_status == 1) {
                                $status = 'Active';
                            } else {
                                $status = 'Suspended';
                            }
                        @endphp
                        <td>{{ $user->firstname }}</td>

                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="phone_text">{{ $user->cellular }}</td>
                        <td>{{ update_date_format($user->account_expire_date, 'm-d-Y') }}</td>
                        <td>{{ update_date_format($user->password_expire_date, 'm-d-Y') }}</td>
                        <td><span
                                class="tag {{ $user->app_user_status == 2 ? 'deactivate' : 'active' }}">{{ $status }}</span>
                        </td>
                        <td class="icons" style="padding-top:20px">
                            <a title="Edit User" href="#"  onclick="getData({{ $user->id }})"><i class="icon icon-edit"></i></a>
                            {{-- <a title="Add Photo" href="#">
                                <i class="icon icon-hire"></i></a> --}}
                            <a title="Delete User" href="#" id="delete_user_btn"
                            data-url="{{ @route('delete_user', [$user->id]) }}"
                            onclick="delete_user_confirmation()">
                                <i class="icon icon-reject"></i></a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <div class="pagination-wrapper with-data-table d-flex justify-content-center align-items-center pt-0">
                <div class="data-section d-flex justify-content-between align-items-center gap-4">
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
                </div>
                
            </div> -->
    </section>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTitle">
                        Add User
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="save_user_form" method="POST" class="ajax-form" action="{{ route('save_user') }}"
                        role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper">
                                <label for="fname">First name<span class="mandate">*</span></label>
                                <input type="text" id="fname" name="firstname" placeholder="First name" required />
                                <input type="hidden" id="id" name="id" />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Last name<span class="mandate">*</span></label>
                                <input type="text" name="lastname" placeholder="Last name" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Password<span class="mandate">*</span></label>
                                <input type="password" name="password" id="password" placeholder="Password" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="password_confirmation">Confirm Password<span class="mandate">*</span></label>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                                    id="password-confirm" />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Email<span class="mandate">*</span></label>
                                <input type="email" id="lname" name="email" placeholder="Email" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Phone<span class="mandate">*</span></label>
                                <input type="number" id="phone" class="phone" name="phone_number"
                                    placeholder="Phone number" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Account Expire Date</label>
                                <div id="account_expire_date" class="date" data-date-format="dd/mm/yyyy">
                                    <input type="text" name="account_expire_date" id="account_expire_date" readonly
                                        placeholder="Account Expire Date" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Password Expire Date</label>
                                <div id="password_expire_date" class="date" data-date-format="dd/mm/yyyy">
                                    <input type="text" name="password_expire_date" id="password_expire_date" readonly
                                        placeholder="Password Expire Date" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Status :<span class="mandate">*</span></label>
                                <select required class="select-control" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="2">Suspended</option>

                                </select>
                            </div>
                        </div>
                        <div class="cta_wrapper d-flex justify-content-center gap-5">
                            <button class="danger" data-dismiss="modal">Cancel</button>
                            <button class="success" id="save_user_btn">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
