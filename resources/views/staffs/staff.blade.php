@extends('layouts.app')
@section('content')
    <!-- Dashboard Table -->

    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center">
            <div class="location-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Location: </label>
                <select class="form-control"  id="filter_organization">
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->name }}" {{ @$selected }}>{{ @$organization->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Status: </label>
                <select class="form-control" id="filter_status">
                    <option value="">All</option>
                    @foreach ($staff_statuses as $staff_status)
                        <option value="{{ $staff_status->status }}">{{ @$staff_status->status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>Staff Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p type="button" onclick="openStaffPopup()">
                        Add Staff
                    </p>
                </div>
            </div>
        </div>
        <table class="w-100" id="staff_datatable">
            <thead>
                <tr>
                    <th>Gender</th>
                    <th>Full Name</th>
                    <th>Date Hired</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Address</th>
                    <th>Zip Code</th>
                    <th>Status</th>
                    <th>Employment Type</th>
                    <th>Organization</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff_list as $staff)
                    <tr>
                        @php
                                if($staff->gender ==1){
                                    $class = "male";
                                    $image = "male.svg";
                                }elseif($staff->gender == 2){
                                    $class = "female";
                                    $image = "female.svg";
                                }else{
                                    $class = "others";
                                    $image = "others.png";
                                }
                            @endphp
                        <td class="dt-center align-items-center" style="gap: 7px">
                            <img class="userimage {{$class}}" src="{{ asset('images/'.$image) }}">
                        </td>

                        <td>
                            {{ $staff->name }}                           
                        </td>
                        <td>{{ update_date_format($staff->hire_date, 'm-d-Y') }}</td>
                        <td class="phone_text">{{ $staff->cellular }}</td>
                        <td>{{ $staff->position }}</td>
                        <td>
                            {{ $staff->address }}<br>{{ $staff->state, $staff->city }}
                        </td>
                        <td>{{ $staff->zip }}</td>
                        <td><span class="tag {{ $staff->staff_status_id == 5 ? 'deactivate' : 'active' }}">{{ $staff->staff_status }}</span></td>
                        <td>{{ $staff->role }}</td>
                        <td>{{ $staff->organization }}</td>
                        <td class="icons" style="padding-top:20px">
                            <a title="View Staff" href="{{ route('staffs.demographics', [$staff->id]) }}"><i
                                    class="icon icon-eye-green"></i></a>
                            <a title="Edit Staff" href="#" onclick="get_staff({{ $staff->id }})">
                                <i class="icon icon-edit"></i></a>
                            <a title="Delete Staff" href="#" id="delete_staff_btn"
                                data-url="{{ @route('delete_staff', [$staff->id]) }}" onclick="delete_staff_confirmation()">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body">
            <h5 id="formTitle">Add new Staff</h5>
            <form id="save_staff_form" method="POST" class="ajax-form" action="{{ route('save_staff') }}" role="form">
                <input type="hidden" name="id" />
                <div class="form-wrapper">
                    <div class="field-wrapper">
                        <label for="fname">First name<span class="mandate">*</span></label>
                        <input type="text" id="fname" name="firstname" placeholder="First name" required />
                    </div>
                    <div class="field-wrapper">
                        <label for="mname">Middle name</label>
                        <input type="text" name="middlename" placeholder="Middle name" />
                    </div>
                    <div class="field-wrapper">
                        <label for="lname">Last name<span class="mandate">*</span></label>
                        <input type="text" name="lastname" placeholder="Last name" required />
                    </div>
                    <div class="field-wrapper">
                        <label for="fname">Date hired<span class="mandate">*</span></label>
                        <div id="submit_date" class="date" data-date-format="mm/dd/yyyy">
                            <input required type="text" name="submit_date" readonly placeholder="Date hired" />
                            <span class="input-group-addon d-none">
                                <i class="icon icon-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="fname">Birth date</label>
                        <div id="dob" class="date" data-date-format="dd/mm/yyyy">
                            <input type="text" name="dob" id="dob" readonly placeholder="DOB" />
                            <span class="input-group-addon d-none">
                                <i class="icon icon-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="ssn">SSN<span class="mandate">*</span></label>
                        <input type="text" id="ssn" name="ssn" placeholder="SSN" required />
                    </div>
                    <div class="field-wrapper">
                        <label for="organization">Organization :<span class="mandate">*</span></label>
                        <select required class="select-control" name="organization" required>
                            <option value="">Organization</option>
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ @$selected }}>{{ @$organization->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label for="position">Position :<span class="mandate">*</span></label>
                        <select required class="select-control" name="position" required>
                            <option value="">Position</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" {{ @$selected }}>{{ @$position->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label for="gender">Gender :<span class="mandate">*</span></label>
                        <select required class="select-control" name="gender" required>
                            <option value="">Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                        </select>
                    </div>

                    <div class="field-wrapper hideField">
                        <label for="email">Email<span class="mandate">*</span></label>
                        <input type="email" id="lname" name="email" placeholder="Email id" required />
                    </div>
                    <div class="field-wrapper">
                        <label for="language">Preferred Language :<span class="mandate">*</span></label> 
                        <select id="languages" class="select2 select-control" name="languages[]" value="{{ @$user->language_id }}" placeholder="Select Languages" required multiple="multiple"> 
                            @foreach ($languages as $language)
                                @if (@in_array($language->id,explode(",",$user->language_id)))
                                    @php
                                        $selected = 'selected';
                                    @endphp
                                @else
                                    @php
                                        $selected = '';
                                    @endphp
                                @endif
                                <option value="{{ $language->id }}" {{ @$selected }}>{{ @$language->language_name }}</option>
                            @endforeach
            
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label for="status">Employment Type :<span class="mandate">*</span></label>
                        <select required class="select-control" name="employment_type" required>
                            <option value="">Employment Type</option>
                            @foreach ($employments as $employment)
                                <option value="{{ $employment->id }}">{{ @$employment->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-wrapper">
                        <label for="staff_status">Status :<span class="mandate">*</span></label>
                        <select required class="select-control" name="staff_status" required>
                            <option value="">Status</option>
                            @foreach ($staff_statuses as $staff_status)
                                <option value="{{ $staff_status->id }}">{{ @$staff_status->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label for="fname">Termination Date</label>
                        <div id="termination_date" class="date" data-date-format="dd/mm/yyyy">
                            <input type="text" name="termination_date" id="termination_date" readonly
                                placeholder="Termination Date" />
                            <span class="input-group-addon d-none">
                                <i class="icon icon-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="corporation_name">Corporation Name:</label>
                        <input type="text" id="corporation_name" name="corporation_name"
                            placeholder="Corporation Name" />
                    </div>
                    <div class="field-wrapper">
                        <label for="tax_id">Tax id</label>
                        <input type="text" id="tax_id" name="tax_id" placeholder="Tax id" />
                    </div> 
                    <div class="field-wrapper">
                        <label for="signedby">Signed by</label>
                        <div class="d-flex gap-4">
                            <div class="sign-left" style="height:100px;">
                                <img id='signature_image' width="250px" height="100px">
                            </div>
                            <button id="upload_button" name="button" type="button" value="Upload" onclick="thisFileUpload();"
                                style="background-color: #606060; flex: 0.7">
                                Upload signature
                            </button>
                            
                        </div> 
                        <input type="file" class="" id="customFile" name="signature_file"
                        placeholder="Upload Signature"
                        onchange="previewFile('signature_file', 'signature64', 'signature_image')"
                        accept="image/*"  style="opacity:0; height:0; position: absolute;"/>
                        <textarea id="signature64" name="signed" style="opacity:0; height:0; position: absolute;"></textarea>
                    </div>

                </div>
                <div class="cta_wrapper d-flex gap-5 mt-5">
                    <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                    <button class="success" id="save_staff_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
