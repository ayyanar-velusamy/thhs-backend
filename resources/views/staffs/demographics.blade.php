@php
    $user = $data["user"];
    $page_title = @$user->lastname." ".@$user->firstname . " ($user->user_position)";
@endphp
@extends('layouts.app',['page_title'=>  $page_title,"user_phone"=>(@$user->cellular)?", ".@$user->cellular:"" ])

@section('content')

@php
    $languages = $data["languages"];
    $positions = $data["positions"];
@endphp

<section class="form-section bg-white">
  <form id="staff_demographics_form" method="POST" class="ajax-form"  action="{{route('staffs.update_demographics', [$user->id])}}" role="form" enctype="multipart/form-data" >
 
    <div
    class="form-headings-wrapper d-flex align-items-center justify-content-between"
  >
    <!-- <a href="#" class="active"><h5>Demographics</h5></a>
    <a href="#" data-toggle="modal" data-target="#scheduleIntModal">Schedule Interview</a>
    <a href="#" data-toggle="modal" data-target="#ConfirmIntModal">Confirm Interview</a>
    <a href="#" id="cancel_interview_btn" data-toggle="modal" data-url="{{@route('prospects.cancel_interview',[$user->id])}}" onclick="confirm_cancel_interview()">Cancel Interview</a>
    <a href="#" id="reject_prospect_btn" data-toggle="modal" data-url="{{@route('prospects.reject_prospect',[$user->id])}}" onclick="confirm_reject_prospect()">Reject</a>
    <a href="#" id="reapply_prospect_btn" data-toggle="modal" data-url="{{@route('prospects.reapply_prospect',[$user->id])}}" onclick="confirm_reapply_prospect()">Re-apply</a> -->
<!-- <a href="#">Save Information</a> -->
<h6>Staff Demographics</h6>
@php                      
if(is_admin()){                            
@endphp
<div class="cta_wrapper d-flex">
    <button id="staff_demographics_submit" class="success">Save Information</button>
    <button class="danger">Clear</button>
</div>
@php                      
}                           
@endphp
  </div>

    <h3>Personal Information</h3>
    <div class="form-wrapper">
        <div class="field-wrapper">
            <label for="fname">First name</label><span class="mandate">*</span>
            <input type="text" id="fname" name="firstname" required placeholder="First name"
                value="{{ @$user->firstname }}" />
        </div>
        <div class="field-wrapper">
            <label for="mname">Middle name</label>
            <input type="text" id="mname" name="middlename" value="{{ @$user->middlename }}"
                placeholder="Middle name" />
        </div>
        <div class="field-wrapper">
            <label for="lname">Last name</label><span class="mandate">*</span>
            <input type="text" id="lname" required name="lastname" placeholder="Last name"
                value="{{ @$user->lastname }}" />
        </div>
        <div class="field-wrapper">
            <label for="fname">Birth date</label><span class="mandate">*</span>
            <div id="datepicker" class="date" data-date-format="dd/mm/yyyy" style="height: 0">
                <input type="text" name="dob" readonly value="{{ @update_date_format($user->birth_date) }}" required />
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper">
            <label for="mname">Gender :</label><span class="mandate">*</span>
            <select required name="gender" class="select-control">
                <option value="">Gender</option>
                <option value="1" @if ($user->gender == '1') selected @endif>Male</option>
                <option value="2" @if ($user->gender == '2') selected @endif>Female</option>
                <option value="3" @if ($user->gender == '3') selected @endif>Others</option>
            </select>
        </div>
        <div class="field-wrapper">
            <label for="mname">Languages :</label><span class="mandate">*</span> 
            <select class="select2 select-control" name="languages[]"  id="languages" value="{{ @$user->language_id }}" required multiple="multiple"> 
              
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
            <label for="ssn">SSN :</label><span class="mandate">*</span>
            <input type="text" id="ssn" value="{{ @$user->ssn }}" required name="ssn"
                placeholder="SSN" />
        </div>
        <div class="field-wrapper">
            <label for="Employment Authorization">Employment Authorization</label>
            <input type="text" id="Employment Authorization" value="{{ @$user->employement_authorization }}" name="employement_authorization"
                placeholder="Employment Authorization" />
        </div>
        <div class="field-wrapper">
            <label for="Corporation Name">Corporation Name:</label>
            <input type="text" id="Corporation Name" value="{{ @$user->corporation_name }}" name="corporation_name"
                placeholder="Corporation Name" />
        </div>
        <div class="field-wrapper">
            <label for="email">Email:</label><span class="mandate">*</span>
            <input type="email" p="email" value="{{ @$user->email }}" required name="email"
                placeholder="Email" />
        </div>
        <div class="field-wrapper">
            <label for="mname">Position :</label><span class="mandate">*</span>
            <select class="select-control" name="position" required>

                <option value="">Position</option>
                @foreach ($positions as $position)
                    @if (@$user->position == $position->id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $position->id }}" {{ @$selected }}>{{ @$position->position }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="tax_id">Tax id:</label>
            <input type="text" id="tax_id" name="tax_id" value="{{ @$user->tax_id }}" placeholder="Tax id" />
        </div>
    </div>
    
    <h3 class="heading-bg">Education</h3>
    <div class="form-wrapper four_grid ">
        <!-- Education 1-->
        <input type="hidden" name="education_id[0]" value="{{ @$user->user_education[0]->id }}">
        <div class="field-wrapper">
            <label for="education_type">Type</label><span class="mandate">*</span>
            <select required name="education_type[0]" class="select-control">
                <option value="">Select Type</option>
                
                @foreach (get_education_type_list() as $type)
                    @if (@$type["id"] == @$user->user_education[0]->id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    
                    <option value="{{ $type['id'] }}" {{$selected}}>{{ @$type['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="education_name">Name</label><span class="mandate">*</span>
            <input type="text" id="education_name" value="{{ @$user->user_education[0]->name }}"
                placeholder="Name" name="education_name[0]" />
        </div>
        <div class="field-wrapper">
            <label for="education_date_completed">Date Completed</label><span class="mandate">*</span>
            
            <div id="date_completed" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Date" readonly value="{{ @update_date_format($user->user_education[0]->date_completed) }}" required name="education_date_completed[0]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper">
            <label for="education_degree">Degree</label><span class="mandate">*</span>
            <select required name="education_degree[0]" class="select-control">
                <option value="">Select Degree</option>
                
                @foreach (get_education_degree_list() as $degree)
                    @if (@$degree["id"] == @$user->user_education[0]->degree_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $degree['id'] }}" {{$selected}}>{{ @$degree['name'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Education 1-->
        <!-- Education 2-->
        <input type="hidden" name="education_id[1]" value="{{ @$user->user_education[1]->id }}">
        <div class="field-wrapper">
            <label for="education_type">Type</label>
            <select name="education_type[1]" class="select-control">
                <option value="">Select Type</option>
                
                @foreach (get_education_type_list() as $type)
                    @if (@$type["id"] == @$user->user_education[1]->id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $type['id'] }}" {{$selected}}>{{ @$type['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="education_name">Name</label>
            <input type="text" id="education_name" value="{{ @$user->user_education[1]->name }}"
                placeholder="Name" name="education_name[1]" />
        </div>
        <div class="field-wrapper">
            <label for="education_date_completed">Date Completed</label>
            
            <div id="date_completed" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Date" readonly value="{{ @update_date_format($user->user_education[1]->date_completed)}}"  name="education_date_completed[1]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper">
            <label for="education_degree">Degree</label>
            <select  name="education_degree[1]" class="select-control">
                <option value="">Select Degree</option>
                
                @foreach (get_education_degree_list() as $degree)
                    @if (@$degree["id"] == @$user->user_education[1]->degree_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $degree['id'] }}" {{$selected}}>{{ @$degree['name'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Education 2-->
        <!-- Education 3-->
        <input type="hidden" name="education_id[2]" value="{{ @$user->user_education[2]->id }}">
        <div class="field-wrapper">
            <label for="education_type">Type</label>
            <select  name="education_type[2]" class="select-control">
                <option value="">Select Type</option>
                
                @foreach (get_education_type_list() as $type)
                    @if (@$type["id"] == @$user->user_education[2]->id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $type['id'] }}" {{$selected}}>{{ @$type['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="education_name">Name</label>
            <input type="text" id="education_name" value="{{ @$user->user_education[2]->name }}"
                placeholder="Name" name="education_name[2]" />
        </div>
        <div class="field-wrapper">
            <label for="education_date_completed">Date Completed</label>
            
            <div id="date_completed" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Date" readonly value="{{ @update_date_format($user->user_education[2]->date_completed)}}" name="education_date_completed[2]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper">
            <label for="education_degree">Degree</label>
            <select  name="education_degree[2]" class="select-control">
                <option value="">Select Degree</option>
                
                @foreach (get_education_degree_list() as $degree)
                    @if (@$degree["id"] == @$user->user_education[2]->degree_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $degree['id'] }}" {{$selected}}>{{ @$degree['name'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Education 3-->
    </div>
    <h3 class="heading-bg">Professional References</h3>
    <div class="form-wrapper four_grid ">
        <!-- References 1-->
        <input type="hidden" name="reference_relationship_id[0]" value="{{@$user->professional_references[0]->id}}">
        <div class="field-wrapper">
            <label for="employer">Relationship</label><span class="mandate">*</span>
            <select required name="reference_relationship[0]" class="select-control">
                <option value="">Select Relationship</option>
                
                @foreach (get_professional_relationships_list() as $relationship)
                    @if (@$relationship["id"] == @$user->professional_references[0]->relationship_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $relationship['id'] }}" {{$selected}}>{{ @$relationship['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="reference_name">Name</label><span class="mandate">*</span>
            <input type="text"  value="{{ @$user->professional_references[0]->name }}"
                placeholder="Name" name="reference_name[0]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_email">Email</label><span class="mandate">*</span>
            <input type="email"  value="{{ @$user->professional_references[0]->email }}"
                placeholder="Email" name="reference_email[0]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_phone">Phone</label><span class="mandate">*</span>
            <input type="text" class="phone" value="{{ @$user->professional_references[0]->phone }}"
                name="reference_phone[0]" placeholder="Phone" />
        </div>

        <!-- References 1-->

        <!-- References 2-->
        <input type="hidden" name="reference_relationship_id[1]" value="{{@$user->professional_references[1]->id}}">
        <div class="field-wrapper">
            <label for="employer">Relationship</label><span class="mandate">*</span>
            <select required name="reference_relationship[1]" class="select-control">
                <option value="">Select Relationship</option>
                
                @foreach (get_professional_relationships_list() as $relationship)
                    @if (@$relationship["id"] == @$user->professional_references[1]->relationship_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $relationship['id'] }}" {{$selected}}>{{ @$relationship['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="reference_name">Name</label><span class="mandate">*</span>
            <input type="text" id="reference_name" value="{{ @$user->professional_references[1]->name }}"
                placeholder="Name" name="reference_name[1]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_email">Email</label><span class="mandate">*</span>
            <input type="email" id="reference_email" value="{{ @$user->professional_references[1]->email }}"
                placeholder="Email" name="reference_email[1]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_phone">Phone</label><span class="mandate">*</span>
            <input type="text" class="phone" id="reference_phone" value="{{ @$user->professional_references[1]->phone }}"
                name="reference_phone[1]" placeholder="Phone" />
        </div>

        <!-- References 2-->

        <!-- References 3-->
        <input type="hidden" name="reference_relationship_id[2]" value="{{@$user->professional_references[2]->id}}">
        <div class="field-wrapper">
            <label for="employer">Relationship</label>
            <select  name="reference_relationship[3]" class="select-control">
                <option value="">Select Relationship</option>
                
                @foreach (get_professional_relationships_list() as $relationship)
                    @if (@$relationship["id"] == @$user->professional_references[2]->relationship_id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $relationship['id'] }}" {{$selected}}>{{ @$relationship['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-wrapper">
            <label for="reference_name">Name</label>
            <input type="text" id="reference_name" value="{{ @$user->professional_references[2]->name }}"
                placeholder="Name" name="reference_name[3]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_email">Email</label>
            <input type="text" id="reference_email" value="{{ @$user->work_history[2]->email}}"
                placeholder="Email" name="reference_email[3]" />
        </div>
        <div class="field-wrapper">
            <label for="reference_phone">Phone</label>
            <input type="text" class="phone" id="reference_phone" value="{{ @$user->professional_references[2]->phone }}"
                name="reference_phone[3]" placeholder="Phone" />
        </div>

        <!-- References 3-->


    </div>
    <h3 class="heading-bg">Work History (Last 3 years)</h3>
    <div class="form-wrapper six_grid ">
        <!-- Employer 1-->
        <input type="hidden" name="employer_id[0]" value="{{ @$user->work_history[0]->id }}">
        <div class="field-wrapper">
            <label for="employer">Employer</label>
            <input type="text" id="employer" value="{{ @$user->work_history[0]->employer_name }}"
                name="employer[0]" placeholder="Employer"  class="employer" />
        </div>
        <div class="field-wrapper">
            <label for="position">Position</label>
            <input type="text" id="position" value="{{ @$user->work_history[0]->position }}"
                placeholder="Position" name="prev_position[0]" />
        </div>
        <div class="field-wrapper">
            <label for="supervisor">Supervisors Name</label>
            <input type="text" id="supervisor" value="{{ @$user->work_history[0]->supervisor_name }}"
                placeholder="Supervisors Name" name="supervisor[0]" />
        </div>
        <div class="field-wrapper">
            <label for="email">Email</label>
            <input type="email" id="email" value="{{ @$user->work_history[0]->employer_email }}"
                name="employer_email[0]" placeholder="Email" />
        </div>
        <div class="field-wrapper">
            <label for="Fax">Fax</label>
            <input type="text" id="Fax" value="{{ @$user->work_history[0]->employer_fax }}"
                name="employer_fax[0]" placeholder="Fax" />
        </div>
        <div class="field-wrapper">
            <label for="Phone no">Phone no</label>
            <input type="text" id="Phone_no"  class="phone" value="{{ @$user->work_history[0]->employer_phone }}"
                placeholder="Phone no" name="employer_phone[0]" />
        </div>

        <!-- Employer 1-->

        <!-- Employer 2-->
        <input type="hidden" name="employer_id[1]" value="{{ @$user->work_history[1]->id }}">
        <div class="field-wrapper">
            <label for="employer">Employer</label>
            <input type="text" id="employer" value="{{ @$user->work_history[1]->employer_name }}"
                name="employer[1]" placeholder="Employer" class="employer" />
        </div>
        <div class="field-wrapper">
            <label for="position">Position</label>
            <input type="text" id="position" value="{{ @$user->work_history[1]->position }}"
                placeholder="Position" name="prev_position[1]" />
        </div>
        <div class="field-wrapper">
            <label for="employer">Supervisors Name</label>
            <input type="text" id="employer" value="{{ @$user->work_history[1]->supervisor_name }}"
                placeholder="Supervisors Name" name="supervisor[1]" />
        </div>
        <div class="field-wrapper">
            <label for="email">Email</label>
            <input type="email" id="email" value="{{ @$user->work_history[1]->employer_email }}"
                name="employer_email[1]" placeholder="Email" />
        </div>
        <div class="field-wrapper">
            <label for="Fax">Fax</label>
            <input type="text" id="Fax" value="{{ @$user->work_history[1]->employer_fax }}"
                name="employer_fax[1]" placeholder="Fax" />
        </div>
        <div class="field-wrapper">
            <label for="Phone no">Phone no</label>
            <input type="text" class="phone" id="Phone_no" value="{{ @$user->work_history[1]->employer_phone }}"
                placeholder="Phone no" name="employer_phone[1]" />
        </div>
        <!-- Employer 2-->

        <!-- Employer 3-->
        <input type="hidden" name="employer_id[2]" value="{{ @$user->work_history[2]->id }}">
        <div class="field-wrapper">
            <label for="employer">Employer</label>
            <input type="text" id="employer" value="{{ @$user->work_history[2]->employer_name }}"
                name="employer[2]" placeholder="Employer" class="employer" />
        </div>
        <div class="field-wrapper">
            <label for="position">Position</label>
            <input type="text" id="position" value="{{ @$user->work_history[2]->position }}"
                placeholder="Position" name="prev_position[2]" />
        </div>
        <div class="field-wrapper">
            <label for="employer">Supervisors Name</label>
            <input type="text" id="employer" value="{{ @$user->work_history[2]->supervisor_name }}"
                placeholder="Supervisors Name" name="supervisor[2]" />
        </div>
        <div class="field-wrapper">
            <label for="email">Email</label>
            <input type="email" id="email" value="{{ @$user->work_history[2]->employer_email }}"
                name="employer_email[2]" placeholder="Email" />
        </div>
        <div class="field-wrapper">
            <label for="Fax">Fax</label>
            <input type="text" id="Fax" value="{{ @$user->work_history[2]->employer_fax }}"
                name="employer_fax[2]" placeholder="Fax" />
        </div>
        <div class="field-wrapper">
            <label for="Phone no">Phone no</label>
            <input type="text" class="phone" id="Phone_no" value="{{ @$user->work_history[2]->employer_phone }}"
                placeholder="Phone no" name="employer_phone[2]" />
        </div>
        <!-- Employer 3-->

    </div>

    <h3 class="heading-bg">Termination History</h3>
    <div class="form-wrapper three_grid ">
        <!-- Termination History 1-->
        <input type="hidden" name="termination_history_id[0]" value="{{ @$user->termination_history[0]->id }}">
        <div class="field-wrapper">
            <label for="hire_date">Hire Date</label>
            <div id="hire_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Hire Date" readonly value="{{ @update_date_format($user->termination_history[0]->hire_date)}}" name="hire_date[0]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>

        <div class="field-wrapper">
            <label for="terminated_date">Termination Date</label>
            <div id="terminated_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Termination Date" value="{{ @update_date_format($user->termination_history[0]->termination_date)}}" readonly  name="termination_date[0]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        
        <div class="field-wrapper">
            <label for="terminated_by">Terminated By</label>
            <input type="text" id="terminated_by" value="{{ @$user->termination_history[0]->terminated_by }}"
                placeholder="Terminated By" name="terminated_by[0]" />
        </div>

        <!-- Termination History 1-->

          <!-- Termination History 2-->
          <input type="hidden" name="termination_history_id[1]" value="{{ @$user->termination_history[1]->id }}">
          <div class="field-wrapper">
            <label for="hire_date">Hire Date</label>
            <div id="hire_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Hire Date" readonly value="{{ @update_date_format($user->termination_history[1]->hire_date)}}" name="hire_date[1]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>

        <div class="field-wrapper">
            <label for="terminated_date">Termination Date</label>
            <div id="terminated_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" placeholder="Termination Date" value="{{ @update_date_format($user->termination_history[1]->termination_date)}}" readonly  name="termination_date[1]"/>
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        
        <div class="field-wrapper">
            <label for="terminated_by">Terminated By</label>
            <input type="text" id="terminated_by" value="{{ @$user->termination_history[1]->terminated_by }}"
                placeholder="Terminated By" name="terminated_by[1]" />
        </div>

        <!-- Termination History 2-->
</div>
    
</form>
          </section>
         
@endsection