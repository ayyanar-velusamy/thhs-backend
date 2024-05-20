@extends('layouts.app')
@section('content')
    <!-- Dashboard Table -->

    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center">

            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Status: </label>
                <select class="form-control" id="">
                    <option value="">All</option>
                    <option value="Registered">Registered</option>
                    <option value="Verified">Verified</option>
                    <option value="Waiting for Documents">Waiting for Documents</option>
                    <option value="Interview Scheduled">Interview Scheduled</option>
                    <option value="Interview Confirmed">Interview Confirmed</option>
                    <option value="Interview Cancelled">Interview Cancelled</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Archived">Archived</option>
                    <option value="Re Apply">Re Apply</option>
                    <option value="Hired">Hired</option>
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>User Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p data-toggle="modal" data-target="#myModal">Add User</p>
                </div>
            </div>
        </div>
        <table class="w-100" id="datatable">
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
               
                            
                        <td>
                            Ayyanar
                        </td>
                       
                        <td>Velu</td>
                        <td title="">inr.cse@gmail.com</td>
                        <td class="phone_text">9952642738</td>
                        
                        <td>
                           12-05-2025 
                        </td>
                        <td>12-05-2025</td>
                        <td><span class="tag active">Active</span></td>
                        
                        <td class="icons" style="padding-top:20px">
                            <a title="Edit User" href=""><i
                                    class="icon icon-eye-green"></i></a>
                            <a title="Add Photo" href="#" >
                                <i class="icon icon-hire"></i></a>
                                <a title="Delete User Prospect" href="#"  id="reject_prospect_btn" >
                                    <i class="icon icon-reject"></i></a>
                                    
                            
                        </td>
                    </tr>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Add User
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="add_user_form" method="POST"  class="ajax-form" action="{{route('add_user')}}" role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper">
                                <label for="fname">First name<span class="mandate">*</span></label>
                                <input type="text" id="fname" name="firstname" placeholder="First name"
                                    required />
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
                                <label for="confirm_password">Confirm Password<span class="mandate">*</span></label>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required id="password-confirm"/>
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Email<span class="mandate">*</span></label>
                                <input type="email" id="lname" name="email" placeholder="Email" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Phone<span class="mandate">*</span></label>
                                <input type="text" id="phone" class="phone" name="phone_number" placeholder="Phone number" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Account Expire Date</label>
                                <div id="account_expire_date" class="date" data-date-format="dd/mm/yyyy">
                                    <input  type="text" name="account_expire_date" id="account_expire_date" readonly
                                        placeholder="Account Expire Date" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Password Expire Date</label>
                                <div id="password_expire_date" class="date" data-date-format="dd/mm/yyyy">
                                    <input  type="text" name="password_expire_date" id="account_expire_date" readonly
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
                            <button class="success" id="add_user_btn">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div
    class="modal fade"
    id="hireProspectModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
            Hire Prospect
          </h5>
        </div>
        <div class="modal-body">
          <form id="hire_prospect_form" class="ajax-form" method="POST" action="{{ @route('prospects.hire_prospect')}}">
            <div class="form-wrapper">
              <input type="hidden" name="user_id" id="user_id">
              <div class="field-wrapper">
                <label for="fname">Hire Date/Time</label>
                <div id="hire_date_div" class="date" data-date-format="mm/dd/yyyy H:i:s">
                  <input required type="text" name="hire_date" id="hire_date" readonly placeholder="Hire Date" />
                  <span class="input-group-addon d-none">
                    <i class="icon icon-eye"></i>
                  </span>
                </div>
              </div>
              
              
            
            <div class="cta_wrapper d-flex justify-content-center gap-5">
          <button class="danger" type="button" data-dismiss="modal">Close</button>
          <button class="success" id="hire_prospect_btn">Save</button>
        </div>
        </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>

@endsection
