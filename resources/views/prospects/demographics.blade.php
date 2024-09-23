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
  <form id="demographics_form" method="POST" class="ajax-form page-form"  action="{{route('update_demographics', [$user->id])}}" role="form" enctype="multipart/form-data" >
 
    <div
    class="form-headings-wrapper d-flex align-items-center justify-content-between demographics_head"
  >
    <a href="#" class="active"><h5>Demographics</h5></a>
    @php                     
    

    if(is_admin()){                            
    @endphp
    <a href="#" data-toggle="modal" data-target="#scheduleIntModal">Schedule Interview</a>
    <a href="#" data-toggle="modal" data-target="#ConfirmIntModal">Confirm Interview</a>
    <a href="#" id="cancel_interview_btn" data-toggle="modal" data-url="{{@route('prospects.cancel_interview',[$user->id])}}" onclick="confirm_cancel_interview()">Cancel Interview</a>
    <a href="#" id="reject_prospect_btn" data-toggle="modal" data-url="{{@route('prospects.reject_prospect',[$user->id])}}" onclick="confirm_reject_prospect()">Reject</a>
    <a href="#" id="reapply_prospect_btn" data-toggle="modal" data-url="{{@route('prospects.reapply_prospect',[$user->id])}}" onclick="confirm_reapply_prospect()">Re-apply</a>
   
<!-- <a href="#">Save Information</a> -->
<div class="btn-wrap">
        <button id="demographics_submit">Save Information</button>
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
            <select class="select2 select-control" name="languages[]" id="languages" value="{{ @$user->language_id }}" required multiple="multiple"> 
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
        <div class="field-wrapper address">
            <label for="address">Address:</label><span class="mandate">*</span>
            <input type="text" id="address" required name="address" placeholder="Address"
                value="{{ @$user->address }}" />
        </div>
        <div class="field-wrapper">
            <label for="city">State:</label><span class="mandate">*</span>
            <input type="text" id="state" required name="state" placeholder="State"
                value="{{ @$user->state }}" />
        </div>
        <div class="field-wrapper">
            <label for="city">City:</label><span class="mandate">*</span>
            <input type="text" id="city" name="city" required placeholder="City"
                value="{{ @$user->city }}" />
        </div>
        <div class="field-wrapper">
            <label for="zip">Zip:</label><span class="mandate">*</span>
            <input type="text" id="zip" required name="zip" placeholder="Zip"
                value="{{ @$user->zip }}" />
        </div>
        <div class="field-wrapper">
            <label for="phone_home">Phone home:</label>
            <input type="text" class="phone" id="phone_home"  name="phone_home" placeholder="Phone home" value="{{ @$user->phone_home }}" />
        </div>
        <div class="field-wrapper address">
            <label for="business">Business:</label>
            <input type="text" id="business" name="business" value="{{ @$user->business }}" placeholder="Business" />
        </div>
        <div class="field-wrapper">
            <label for="cellular">Cellular:</label><span class="mandate">*</span>
            <input type="text" id="cellular" class="phone" required name="cellular" placeholder="Cellular"
                value="{{ @$user->cellular }}" />
        </div>
    </div>
    <!-- <div class="disclaimer-section">
        <p class="semi-bold">Disclaimer:</p>
        <p class="semi-bold mb-2">
            Agreement to do business with Trend Home Health Services
        </p>
        <p>ELECTRONIC RECORD AND SIGNATURE DISCLOSURE</p>
        <p class="disclaimer">
            From time to time, Trend Home Health Services (we, us or Company) may be required by law to provide to
            you certain written notices or disclosures. Described below are the terms and conditions for providing
            to you such notices and disclosures electronically through the email system and or company portal.
            Please read the information below carefully and thoroughly, and if you can access this information
            electronically to your satisfaction and agree to this Electronic Record and Signature Disclosure (ERSD),
            please confirm your agreement by selecting the check-box next to ‘I agree to use electronic records and
            signatures’ before clicking ‘CONTINUE’ within the company portal.
            Getting paper copies At any time, you may request from us a paper copy of any record provided or made
            available electronically to you by us. You may request delivery of such paper copies from us by
            following the procedure described below.
            Withdrawing your consent If you decide to receive notices and disclosures from us electronically through
            our email system, you may at any time change your mind and tell us that thereafter you want to receive
            required notices and disclosures only in paper format. How you must inform us of your decision to
            receive future notices and disclosure in paper format and withdraw your consent to receive notices and
            disclosures electronically is described below.
            All notices and disclosures will be sent to you electronically Unless you tell us otherwise in
            accordance with the procedures described herein, we will provide electronically to you through the
            company email system all required notices, disclosures, authorizations, acknowledgements, and other
            documents that are required to be provided or made available to you during the course of our
            relationship with you. To reduce the chance of you inadvertently not receiving any notice or disclosure,
            we prefer to provide all of the required notices and disclosures to you by the same method and to the
            same address that you have given us. Thus, you can receive all the disclosures and notices
            electronically or in paper format through the paper mail delivery system. If you do not agree with this
            process, please let us know as described below.
            How to contact Trend Home Health Services : You may contact us to let us know of your changes as to how
            we may contact you electronically, to request paper copies of certain information from us, and to
            withdraw your prior consent to receive notices and disclosures electronically as follows: To contact us
            by email send messages to: HR@trendhhs.com
            To advise Trend Home Health Services of your new email address To let us know of a change in your email
            address where we should send notices and disclosures electronically to you, you must send an email
            message to us at HR@trendhhs.com and in the body of such request you must state: your previous email
            address, your new email address. We do not require any other information from you to change your email
            address.
            To request paper copies from Trend Home Health Services To request delivery from us of paper copies of
            the notices and disclosures previously provided by us to you electronically, you must send us an email
            to HR@trendhhs.com and in the body of such request you must state your email address, full name, mailing
            address, and telephone number.
        </p>
    </div>
    <div class="form-wrapper">
        <div class="field-wrapper">
            <div class="checkbox-tick-wrapper d-flex align-items-center">
                <div class="form-check">
                    <label class="form-check-label" for="i_agree">
                        I agree
                    </label>
                    <input class="form-check-input" type="checkbox" value="" id="i_agree"
                        name="i_agree">
                </div>
            </div>
        </div>
        <div class="field-wrapper position-relative">
            <label class="" for="">Signature:</label>
            <br/>
            <div id="sig" ></div>
            <br/>
            <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
            <textarea id="signature64" name="signed" style="opacity:0; height:0;"></textarea>
        </div>
        {{-- <div class="field-wrapper position-relative">
            <label for="customFile">Upload signature</label>
            <input type="file" class="" id="customFile" name="signature_file"
                placeholder="Upload Signature" required />
            <span class="with-icon"><i class="icon icon-upload"></i></span>
        </div> --}}
    </div> -->
    <h3 class="heading-bg">Position Information</h3>
    <div class="form-wrapper single_row">
        <div class="field-wrapper w-25">
            <label for="start_date">Applied Date</label><span class="mandate">*</span>
            <div id="prospect_submit_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" readonly required name="submit_date" value="{{  @update_date_format($user->submit_date) }}" />
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper w-25">
            <label for="start_date">Date you can start</label><span class="mandate">*</span>
            <div id="start_date" class="date" data-date-format="dd/mm/yyyy">
                <input type="text" readonly required name="start_date" value="{{  @update_date_format($user->start_date) }}" />
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper w-75">
            <p>
                Have you ever been convicted of a felony? (Convictions will
                not necessarily disqualify an applicant for employment.) If
                yes, explain:
            </p>
            @if (@$user->has_convicted_felony == 1)
                @php
                    $checked_yes = 'checked';
                    $checked_no = '';
                @endphp
            @else
                @php
                    $checked_yes = '';
                    $checked_no = 'checked';
                @endphp
            @endif
            <input onchange="change_no_textarea(true)" type="radio" id="has_convicted_felony_yes"
                value="1" name="has_convicted_felony" {{ @$checked_yes }} />
            <label for="has_convicted_felony_yes">Yes</label>
            <input onchange="change_no_textarea(false)" type="radio" id="has_convicted_felony_no"
                value="0" name="has_convicted_felony" {{ @$checked_no }} />
            <label for="has_convicted_felony_no">No</label>

        </div>
        <div class="field-wrapper w-100"id="no_textarea">
            <textarea placeholder="Reason" id="convicted_reason" name="convicted_reason">{{ @$user->convicted_reason }}</textarea>
        </div>
        <div class="field-wrapper">
            <div class="checkbox-tick-wrapper default d-flex align-items-center">
                <label class="d-flex align-items-center">
                    @if (@$user->has_reviewed_job_description == 1)
                        @php
                            $checked = 'checked';
                        @endphp
                    @else
                        @php
                            $checked = '';
                        @endphp
                    @endif
                    <input type="checkbox" {{ $checked }} name="has_reviewed_job_description" value="1"/>
                    <span class="cr me-3"><i class="icon icon-tick-white"></i></span>
                    I have been told the essential functions of the job offered and I have reviewed a copy of the
                    job description listing the essentials function of the job.
                </label>
            </div>
        </div>
        <div class="field-wrapper">
            <div class="checkbox-tick-wrapper default d-flex align-items-center">
                <label class="d-flex align-items-center">
                    @if (@$user->can_perform_without_accomodation == 1)
                        @php
                            $checked = 'checked';
                        @endphp
                    @else
                        @php
                            $checked = '';
                        @endphp
                    @endif
                    <input type="checkbox" {{ $checked }} value="1" name="can_perform_without_accomodation"/>
                    <span class="cr me-3"><i class="icon icon-tick-white"></i></span>
                    I can perform these essential job functions with or without reasonable accommodation.
                </label>
            </div>
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
                
                    @if (@$type["id"] == @$user->user_education[0]->type_id)
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
        <input type="hidden" name="education_id[3]" value="{{ @$user->user_education[3]->id }}">
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
        <input type="hidden" name="employer_id[1]" value="{{@$user->work_history[1]->id}}">
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
        <input type="hidden" name="employer_id[2]" value="{{@$user->work_history[2]->id}}">
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
    <h3 class="heading-bg d-flex gap-3">
        Special Skils
        <span style="font-weight: 300">List any special skils or experience that you feel would help
            you in the position that you are applying for leadership,
            actions teams, etc.
        </span>
    </h3>
    <div class="form-wrapper single_row">
        <div class="field-wrapper w-100">
            <textarea placeholder="Business: " id="special_skills" name="special_skills">{{ $user->special_skills }}</textarea>
        </div>
    </div>
    <h3 class="heading-bg">Emergency Contacts</h3>
    <div class="form-wrapper four_grid">
        <input type="hidden" name="emergency_contact_id[0]"  value="{{@$user->emergency_contacts[0]->id}}">
        <div class="field-wrapper">
            <label for="Relationship">Relationship</label><span class="mandate">*</span>
            <!-- <input type="text" id="Relationship" value="{{ @$emergency_contact->relationship }}"
                placeholder="Relationship" name="relationship[0]" required /> -->
            <select  name="relationship[0]" class="select-control">
                <option value="">Select Relationship</option>
                
                @foreach (get_emergency_contact_list() as $relationship)
                    @if (@$relationship["id"] == @$user->emergency_contacts[0]->relationship_id)
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
            <label for="name">Name </label><span class="mandate">*</span>
            <input type="text" value="{{ @$user->emergency_contacts[0]->relationship_name }}"
                placeholder="Name" name="relationship_name[0]" required />
        </div>
        <div class="field-wrapper">
            <label for="name">Email </label><span class="mandate">*</span>
            <input type="email" value="{{ @$user->emergency_contacts[0]->relationship_email }}"
                placeholder="Email" name="relationship_email[0]" required />
        </div>
        <div class="field-wrapper">
            <label for="phone">Phone </label><span class="mandate">*</span>
            <input type="text" class="phone" id="phone" value="{{ @$user->emergency_contacts[0]->relationship_phone }}"
                placeholder="Phone" name="relationship_phone[0]" required />
        </div>

    <input type="hidden" name="emergency_contact_id[1]"  value="{{@$user->emergency_contacts[1]->id}}">
    <div class="field-wrapper">
        <label for="Relationship">Relationship</label>
        <!-- <input type="text" id="Relationship" value="" placeholder="Relationship"
            name="relationship[1]" /> -->
            <select  name="relationship[1]" class="select-control">
                <option value="">Select Relationship</option>
                
                @foreach (get_emergency_contact_list() as $relationship)
                    @if (@$relationship["id"] == @$user->emergency_contacts[1]->relationship_id)
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
        <label for="relationship_name">Name</label>
        <input type="text" id="relationship_name" value="{{@$user->emergency_contacts[1]->relationship_name}}" placeholder="Name"
            name="relationship_name[1]" />
    </div>
    <div class="field-wrapper">
        <label for="relationship_email">Email </label>
        <input type="email" id="relationship_email" value="{{@$user->emergency_contacts[1]->relationship_email}}" placeholder="Email"
            name="relationship_email[1]" />
    </div>
    <div class="field-wrapper">
        <label for="relationship_phone">Phone </label>
        <input type="text" class="phone" id="relationship_phone" value="{{@$user->emergency_contacts[1]->relationship_phone}}" placeholder="Phone"
            name="relationship_phone[1]" />
    </div>
</div>

    <h3 class="heading-bg">Medical Information</h3>
    <div class="form-wrapper single_row">
        <div class="field-wrapper">
            <p class="mb-2">
                Did you receive an Influenza Vaccine this year?
            </p>
            @if (@$user->had_influeza_vaccine == 1)
                @php
                    $checked_yes = 'checked';
                    $checked_no = '';
                @endphp
            @else
                @php
                    $checked_yes = '';
                    $checked_no = 'checked';
                @endphp
            @endif
            <input onchange="toggle_influeza(event.target.value)" type="radio" id="yes1"
                name="had_influeza_vaccine" {{ $checked_yes }} value="1" />
            <label for="yes1">Yes</label>
            <input onchange="toggle_influeza(event.target.value)" type="radio" id="no1"
                name="had_influeza_vaccine" {{ $checked_no }} value="0" />
            <label for="no1">No</label>
        </div>
        <div class="field-wrapper w-25 influenza_date">

            <label for="influeza_vaccine_date">Vaccinated Date<span class="mandate">*</span></label>

            <div id="influeza_vaccine_date" class="date" data-date-format="mm/dd/yyyy">
                <input type="text" readonly name="influeza_vaccine_date"
                    value="{{ @update_date_format($user->influeza_vaccine_date) }}" />
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper w-100 influenza_reason">
            <p class="mb-2">If No, Why?</p>
            <textarea placeholder="Disclaimer: You will need to bring a Physicians note to this affect!!!" id="business"
                name="influeza_vaccine_reason">{{ @$user->influeza_vaccine_reason }}</textarea>
        </div>
        <div class="field-wrapper">
            <p class="mb-2">
                Did you receive an Hepatitis Vaccine this year?
            </p>
            @if (@$user->had_hepatitis_vaccine == 1)
                @php
                    $checked_yes = 'checked';
                    $checked_no = '';
                @endphp
            @else
                @php
                    $checked_yes = '';
                    $checked_no = 'checked';
                @endphp
            @endif
            <input onchange="toggle_hepatitis(event.target.value)" type="radio" id="yes"
                name="had_hepatitis_vaccine" value="1" {{ $checked_yes }} />
            <label for="yes">Yes</label>
            <input onchange="toggle_hepatitis(event.target.value)" type="radio" id="no"
                name="had_hepatitis_vaccine" value="0" {{ $checked_no }} />
            <label for="no">No</label>
        </div>
        <div class="field-wrapper w-25 hepatitis_date">
            <label for="hepatitis_vaccine_date">Vaccinated date<span class="mandate">*</span></label>
            <div id="hepatitis_vaccine_date" class="date" data-date-format="mm/dd/yyyy">
                
                <input type="text" readonly name="hepatitis_vaccine_date" value="{{ @update_date_format($user->hepatitis_vaccine_date) }}" />
                <span class="input-group-addon">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
        </div>
        <div class="field-wrapper w-100 hepatitis_reason">
            <p class="mb-2">If No, Why?</p>
            <textarea placeholder="Disclaimer: You will need to bring a Physicians note to this affect!!!" id="hepatitis_vaccine_reason"
                name="hepatitis_vaccine_reason">{{ $user->hepatitis_vaccine_reason }}</textarea>
        </div>
    </div>

</form>
          </section>
          <!-- Schedule Interviw Appointment -->
          <div
        class="modal fade"
        id="scheduleIntModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">
                Schedule Interview
              </h5>
              <button type="button" class="close close-modal-scan" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form id="schedule_interview_form" class="ajax-form" method="POST" action="{{route('prospects.schedule_interview', [$user->id])}}">
                <div class="form-wrapper">
                  
                  <div class="field-wrapper">
                    <label for="fname">Interview Date/Time</label>
                    <div id="interview_date_div" class="date" data-date-format="mm/dd/yyyy H:i">
                      <input required type="text" name="interview_date" id="interview_date" readonly placeholder="Interview Date" />
                      <span class="input-group-addon d-none">
                        <i class="icon icon-eye"></i>
                      </span>
                    </div>
                  </div>
                  
                  
                
                <div class="cta_wrapper d-flex justify-content-center gap-5">
              <button class="danger" data-dismiss="modal">Close</button>
              <button class="success" id="schedule_interview_btn">Save</button>
            </div>
            </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>

<!-- Confirm Interview Appointment-->

      <div
        class="modal fade"
        id="ConfirmIntModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">
                Confirm Interview
              </h5>
              <button type="button" class="close close-modal-scan" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form id="confirm_interview_form" class="ajax-form" method="POST" action="{{route('prospects.confirm_interview', [$user->id])}}">
                <div class="form-wrapper">
                  
                  <div class="field-wrapper">
                    <label for="fname">Interview Date/Time</label>
                    <div id="confirm_interview_date_div" class="date" data-date-format="mm/dd/yyyy H:i:s">
                      <input required type="text" name="interview_date" id="interview_date" readonly placeholder="Interview Date" />
                      <span class="input-group-addon d-none">
                        <i class="icon icon-eye"></i>
                      </span>
                    </div>
                  </div>
                  
                  
                
                <div class="cta_wrapper d-flex justify-content-center gap-5">
              <button class="danger" data-dismiss="modal">Close</button>
              <button class="success" id="confirm_interview_btn">Confirm</button>
            </div>
            </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>

      <div
        class="modal fade confirm_modal"
        id="CancelInterviewModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content align-items-center">
            <div>
                <img src="{{ asset('images/confirm_popup.svg') }}" class="pb-4"/>
            </div>
            <div>
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Confirm
                </h5>
                <button type="button" class="close close-modal-cancel-interview" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <p id="cancel_modal_msg" class="pb-3"></p>
                    <div class="field-wrapper w-100" id="">
                        <textarea style="height:100px" placeholder="Cancellation Reason" id="cancellation_reason" name="cancellation_reason"></textarea>
                    </div>
                <input type="hidden" id="cancel_function_name" value="">
                </div>
                <div class="cta_wrapper d-flex justify-content-center gap-5">
                <button class="danger" data-dismiss="modal">Clear</button>
                <button class="success" id="cancel_confirm_btn">Confirm</button>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection