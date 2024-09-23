@extends('layouts.app')
@section('content')
    <!-- Dashboard Table -->

    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center">

            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Status: </label>
                <select class="form-control" id="filter_status">
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
                    <option value="Prospect">Prospect</option>
                    <option value="Terminated">Terminated</option> 
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>Prospect Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                @php                      
                if(is_admin()){                            
                @endphp
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p data-toggle="modal" data-target="#myModal">Add Prospect</p>
                </div>
                @php                      
                }                    
            @endphp
            </div>
        </div>
        <table class="w-100" id="datatable">
            <thead>
                <tr>
                    <th>Gender</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                    <!-- <th>Date Hired</th> -->
                    <th>Interview Scheduled Date</th>
                    <th>Interview Confirmed Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prospect_list as $prospect)
                    <tr>
                        <td>
                            @php
                                if($prospect->gender ==1){
                                    $class = "male";
                                    $image = "male.svg";
                                }else if($prospect->gender == 2){
                                    $class = "female";
                                    $image = "female.svg";
                                }else{
                                    $class = "others";
                                    $image = "others.png";
                                }
                            @endphp
                            <img class="userimage {{$class}}" src="{{ asset('images/'.$image) }}">
                        </td>
                        <td>
                            {{ $prospect->lastname . ", ". $prospect->firstname }}
                        </td>
                       
                        <td>{{$prospect->email}}</td>
                        <td title="{{ $prospect->position }}">{{ $prospect->short_name }}</td>
                        <td class="phone_text">{{ $prospect->cellular }}</td>
                        @php
                            $address = @implode(", ",array_filter([$prospect->address,$prospect->city,$prospect->state]));
                        @endphp
                        <td class="large_text_ellipsis" title="{{ @$address }}">
                            {{ @$address }}
                        </td>
                        <td><span class="tag active">{{ @$prospect->prospect_status }}</span></td>
                        <td>{{ update_date_format($prospect->submit_date,"m-d-Y") }}</td>
                        
                        <!-- <td>{{ update_date_format($prospect->hire_date,"m-d-Y") }}</td> -->
                        <td>{{ update_date_format($prospect->interview_schedule_date,"m-d-Y") }}</td>
                        <td>{{ update_date_format($prospect->interview_confirm_date,"m-d-Y") }}</td>
                        
                        
                        <td class="icons" style="padding-top:20px">
                            <a title="View Prospect" href="{{ route('prospects.demographics',[$prospect->id]) }}"><i
                                    class="icon icon-eye-green"></i></a>
                                    @php                      
                                    if(is_admin()){                            
                                    @endphp
                            <a title="Hire Prospect" href="#" onclick="openHireProspectModal({{$prospect->id}})">
                                <i class="icon icon-hire"></i></a>
                                <a title="Reject Prospect" href="#"  id="reject_prospect_btn" data-url="{{@route('prospects.reject_prospect',[$prospect->id])}}" onclick="confirm_reject_prospect()">
                                    <i class="icon icon-reject"></i></a>
                                    <a title="Archive Prospect" href="#" id="archive_prospect_btn" data-url="{{@route('prospects.archive_prospect',[$prospect->id])}}" onclick="confirm_archive_prospect()">
                                        <i class="icon icon-archive"></i></a>
                                        @php                      
                                      }                     
            @endphp
                            
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Add Prospect
                    </h5>
                    <button type="button" class="close close-modal-scan" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="add_prospect_form" method="POST"  class="ajax-form" action="{{route('add_prospect')}}" role="form">
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
                                <label for="mname">Email<span class="mandate">*</span></label>
                                <input type="email" id="lname" name="email" placeholder="Email" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Birth date</label>
                                <div id="dob" class="date" data-date-format="dd/mm/yyyy">
                                    <input required type="text" name="dob" id="dob" readonly
                                        placeholder="DOB" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Position :<span class="mandate">*</span></label>
                                <select required class="select-control" name="position" required>

                                    <option value="">Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}" {{ @$selected }}>
                                            {{ @$position->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Applied date</label>
                                <div id="submit_date" class="date" data-date-format="mm/dd/yyyy">
                                    <input required type="text" name="submit_date" readonly
                                        placeholder="Submit date" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="cta_wrapper d-flex justify-content-center gap-5">
                            <button class="danger" data-dismiss="modal">Cancel</button>
                            <button class="success" id="add_prospect_btn">Save</button>
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
