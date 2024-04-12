@extends('layouts.app2')
@section('content')
<link href="{{ asset('css/personal_info.css') }}" rel="stylesheet" />
<section class="form-section bg-white">
<form id="personal_info_form" method="POST">
            <div class="form-headings-wrapper d-flex align-items-center justify-content-between">
              <!-- <a href="#" class="active">Prospect registration</a> -->
              <!-- <a href="#">Save Information</a> -->
              <!-- <a href="#">Schedule Interview</a> -->
              <!-- <a href="#">Confirm Interview</a> -->
              <!-- <a href="#">Cancel Interview</a> -->
              <!-- <a href="#">Reject</a> -->
              <!-- <a href="#">Apply</a> -->
			  <h6>Prospect Registration</h6>
			  <div class="cta_wrapper d-flex">
                <button id="personal_info_submit" class="success">Save Information</button>
                <button class="danger">Clear</button>
              </div>
            </div>
            
              <h3>Personal Information</h3>
              <div class="form-wrapper">
                <div class="field-wrapper">
                  <label for="fname">First name</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="fname"
                    name="firstname"
                    required
                    placeholder="First name"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="mname">Middle name</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="mname"
                    name="middlename"
                    value=""
                    placeholder="Middle name"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="lname">Last name</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="lname"
                    required
                    name="lastname"
                    placeholder="Last name"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="fname">Birth date</label><span class="mandate">*</span>
                  <div
                    id="datepicker"
                    class="date"
                    
                    data-date-format="dd/mm/yyyy"
                    style="height: 0"
                  >
                    <input type="text" name="dob" readonly  required/>
                    <span class="input-group-addon">
                      <i class="icon icon-eye"></i>
                    </span>
                  </div>
                </div>
                <div class="field-wrapper">
                  <label for="mname">Gender :</label><span class="mandate">*</span>
                  <select required name="gender" class="select-control">
                    <option value="">Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
                <div class="field-wrapper">
                  <label for="mname">Languages :</label><span class="mandate">*</span>
                  <select class="select-control" name="languages" required>
                    <option value="">Languages</option>
                    <option value="english">English</option>
                    <option value="french">French</option>
                    <option value="german">German</option>
                    <option value="greek">Greek</option>
                    <option value="hungarian">Hungarian</option>
                    <option value="italian">Italian</option>
                    <option value="polish">Polish</option>
                    <option value="russian">Russian</option>
                    <option value="spanish">Spanish</option>
                    <option value="ukarainian">Ukarainian</option>
                    <option value="yiddish">Yiddish</option>
                  </select>
                </div>
                <div class="field-wrapper">
                  <label for="ssn">SSN :</label><span class="mandate">*</span>
                  <input type="text" id="ssn" value="" required name="ssn" placeholder="SSN" />
                </div>
                <div class="field-wrapper">
                  <label for="Employment Authorization"
                    >Employment Authorization</label
                  >
                  <input
                    type="text"
                    id="Employment Authorization"
                    value=""
                    placeholder="Employment Authorization"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="Corporation Name">Corporation Name:</label>
                  <input
                    type="text"
                    id="Corporation Name"
                    value=""
                    placeholder="Corporation Name"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="email">Email:</label><span class="mandate">*</span>
                  <input type="email" p="email" value="" required name="email" placeholder="Email" />
                </div>
                <div class="field-wrapper">
                  <label for="mname">Position :</label><span class="mandate">*</span>
                  <select class="select-control" name="position" required>

                    <option value="">Position</option>
                    <option value="1">CNA – Certified Nursing Assistant</option>
                    <option value="2">DON – Director of Nursing</option>
                    <option value="3">HHA – Home Health Aide</option>
                    <option value="4">Human Resource</option>
                    <option value="5">LPN – Practical Registered Nurse</option>
                    <option value="6">MSW – Medical Social Worker</option>
                    <option value="7">OT – Occupational Therapist</option>
                    <option value="8">OTA - Occupational Therapist Assistant</option>
                    <option value="9">PT- Physical Therapist</option>
                    <option value="10">PTA – Physical Therapist Assistant</option>
                    <option value="11">RN- Registered Nurse</option>
                    </select>
                </div>
                <div class="field-wrapper">
                  <label for="tax_id">Tax id:</label>
                  <input
                    type="text"
                    id="tax_id"
                    value=""
                    placeholder="Tax id"
                  />
                </div>
                <div class="field-wrapper address">
                  <label for="address">Address:</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="address"
                    required
                    name="address"
                    placeholder="Address"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="city">State:</label><span class="mandate">*</span>
                  <input type="text" id="state" required name="state" placeholder="State" />
                </div>
                <div class="field-wrapper">
                  <label for="city">City:</label><span class="mandate">*</span>
                  <input type="text" id="city" name="city" required placeholder="City" />
                </div>
                <div class="field-wrapper">
                  <label for="zip">Zip:</label><span class="mandate">*</span>
                  <input type="text" id="zip" required name="zip" placeholder="Zip" />
                </div>
                <div class="field-wrapper">
                  <label for="phone_home">Phone home:</label>
                  <input
                    type="number"
                    id="phone_home"
                    value=""
                    placeholder="Phone home"
                  />
                </div>
                <div class="field-wrapper address">
                  <label for="business">Business:</label>
                  <input
                    type="text"
                    id="business"
                    value=""
                    placeholder="Business"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="cellular">Cellular:</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="cellular"
                    required
                    name="cellular"
                    placeholder="Cellular"
                  />
                </div>
              </div>
              <div class="disclaimer-section">
                <p class="semi-bold">Disclaimer:</p>
                <p class="semi-bold mb-2">
                  Agreement to do business with Trend Home Health Services
                </p>
                <p>ELECTRONIC RECORD AND SIGNATURE DISCLOSURE</p>
                 <p class="disclaimer">
                 From time to time, Trend Home Health Services (we, us or Company) may be required by law to provide to you certain written notices or disclosures. Described below are the terms and conditions for providing to you such notices and disclosures electronically through the email system and or company portal. Please read the information below carefully and thoroughly, and if you can access this information electronically to your satisfaction and agree to this Electronic Record and Signature Disclosure (ERSD), please confirm your agreement by selecting the check-box next to ‘I agree to use electronic records and signatures’ before clicking ‘CONTINUE’ within the company portal.
Getting paper copies At any time, you may request from us a paper copy of any record provided or made available electronically to you by us. You may request delivery of such paper copies from us by following the procedure described below.
Withdrawing your consent If you decide to receive notices and disclosures from us electronically through our email system, you may at any time change your mind and tell us that thereafter you want to receive required notices and disclosures only in paper format. How you must inform us of your decision to receive future notices and disclosure in paper format and withdraw your consent to receive notices and disclosures electronically is described below.
All notices and disclosures will be sent to you electronically Unless you tell us otherwise in accordance with the procedures described herein, we will provide electronically to you through the company email system all required notices, disclosures, authorizations, acknowledgements, and other documents that are required to be provided or made available to you during the course of our relationship with you. To reduce the chance of you inadvertently not receiving any notice or disclosure, we prefer to provide all of the required notices and disclosures to you by the same method and to the same address that you have given us. Thus, you can receive all the disclosures and notices electronically or in paper format through the paper mail delivery system. If you do not agree with this process, please let us know as described below.
How to contact Trend Home Health Services : You may contact us to let us know of your changes as to how we may contact you electronically, to request paper copies of certain information from us, and to withdraw your prior consent to receive notices and disclosures electronically as follows: To contact us by email send messages to: HR@trendhhs.com
To advise Trend Home Health Services of your new email address To let us know of a change in your email address where we should send notices and disclosures electronically to you, you must send an email message to us at HR@trendhhs.com and in the body of such request you must state: your previous email address, your new email address. We do not require any other information from you to change your email address.
To request paper copies from Trend Home Health Services To request delivery from us of paper copies of the notices and disclosures previously provided by us to you electronically, you must send us an email to HR@trendhhs.com and in the body of such request you must state your email address, full name, mailing address, and telephone number.
                </p>
              </div>
              <div class="form-wrapper">
                <div class="field-wrapper">
                  <div class="checkbox-tick-wrapper d-flex align-items-center">
                    <label class="d-flex align-items-center">
                      I agree
                      <input type="checkbox" value="" id="i_agree" required name="i_agree"/>
                      <span class="cr ms-3"
                        ><i class="icon icon-tick-white"></i
                      ></span>
                    </label>
                  </div>
                </div>
                <div class="field-wrapper position-relative">
                  <label for="customFile">Upload signature</label>
                  <input
                    type="file"
                    class=""
                    id="customFile"
                    name="signature_file"
                    placeholder="Upload Signature"
                    required
                  />
                  <span class="with-icon"
                    ><i class="icon icon-upload"></i
                  ></span>
                </div>
              </div>
              <h3 class="heading-bg">Position Information</h3>
              <div class="form-wrapper single_row">
                <div class="field-wrapper w-25">
                  <label for="start_date">Date you can start</label><span class="mandate">*</span>
                  <div
                    id="start_date"
                    class="date"
                    data-date-format="dd/mm/yyyy"
                  >
                    <input type="text" readonly required name="start_date"/>
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
                  <input onchange="change_no_textarea(true)" type="radio" id="test1" name="radio-group1" />
                  <label for="test1">Yes</label>
                  <input onchange="change_no_textarea(false)" type="radio" id="test2" name="radio-group1" checked  />
                  <label for="test2">No</label>
                  
                </div>
                <div class="field-wrapper w-100"id="no_textarea">
                  <textarea
                    placeholder="Reason"
                    id="business"
                    name="business"
                  ></textarea>
                </div>
                <div class="field-wrapper">
                  <div
                    class="checkbox-tick-wrapper default d-flex align-items-center"
                  >
                    <label class="d-flex align-items-center">
                      <input type="checkbox" value="" />
                      <span class="cr me-3"
                        ><i class="icon icon-tick-white"></i
                      ></span>
                      I have been told the essential functions of the job offered and I have reviewed a copy of the job description listing the essentials function of the job.
                    </label>
                  </div>
                </div>
                <div class="field-wrapper">
                  <div
                    class="checkbox-tick-wrapper default d-flex align-items-center"
                  >
                    <label class="d-flex align-items-center">
                      <input type="checkbox" value="" />
                      <span class="cr me-3"
                        ><i class="icon icon-tick-white"></i
                      ></span>
                       I can perform these essential job functions with or without reasonable accommodation.
                    </label>
                  </div>
                </div>
                
              </div>
              <h3 class="heading-bg">Work History (Last 3 years)</h3>
              <div class="form-wrapper six_grid ">
                <div class="field-wrapper">
                  <label for="employer">Employer</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="employer"
                    value=""
                    name="employer[]"
                    placeholder="Employer"
                    required
                    class="employer"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="position">Position</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="position"
                    value=""
                    placeholder="Position"
                    name="prev_position[]"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="employer">Supervisors Name</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="employer"
                    value=""
                    placeholder="Supervisors Name"
                    name="supervisor[]"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="email">Email</label><span class="mandate">*</span>
                  <input type="email" id="email" value="" name="employer_email[]" placeholder="Email" />
                </div>
                <div class="field-wrapper">
                  <label for="Fax">Fax</label><span class="mandate">*</span>
                  <input type="text" id="Fax" value="" name="employer_fax[]" placeholder="Fax" />
                </div>
                <div class="field-wrapper">
                  <label for="Phone no">Phone no</label><span class="mandate">*</span>
                  <input
                    type="number"
                    id="Phone_no"
                    value=""
                    placeholder="Phone no"
                    name="employer_phone[]"
                  />
                </div>
                
                <div class="field-wrapper">
                  <label for="employer">Employer</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="employer"
                    value=""
                    name="employer[]"
                    class="employer"
                    placeholder="Employer"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="position">Position</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="position"
                    value=""
                    placeholder="Position"
                    name="prev_position[]"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="employer">Supervisors Name</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="employer"
                    value=""
                    placeholder="Supervisors Name"
                    name="supervisor[]"
                  />
                </div>
                <div class="field-wrapper">
                  <label for="email">Email</label><span class="mandate">*</span>
                  <input type="email" id="email" value="" name="employer_email[]" placeholder="Email" />
                </div>
                <div class="field-wrapper">
                  <label for="Fax">Fax</label><span class="mandate">*</span>
                  <input type="text" id="Fax" value="" name="employer_fax[]" placeholder="Fax" />
                </div>
                <div class="field-wrapper">
                  <label for="Phone no">Phone no</label><span class="mandate">*</span>
                  <input
                    type="number"
                    id="Phone_no"
                    value=""
                    placeholder="Phone no"
                    name="employer_phone[]"
                  />
                </div>
                
              </div>
              <h3 class="heading-bg d-flex gap-3">
                Special Skils
                <span style="font-weight: 300"
                  >List any special skils or experience that you feel would help
                  you in the position that you are applying for leadership,
                  actions teams, etc.
                </span>
              </h3>
              <div class="form-wrapper single_row">
                <div class="field-wrapper w-100">
                  <textarea
                    placeholder="Business: "
                    id="business"
                    name="business"
                  ></textarea>
                </div>
              </div>
              <h3 class="heading-bg">Emergency Contacts</h3>
              <div class="form-wrapper four_grid">
                <div class="field-wrapper">
                  <label for="Relationship">Relationship</label><span class="mandate">*</span>
                  <input
                    type="text"
                    id="Relationship"
                    value=""
                    placeholder="Relationship"
                    name="relationship[]"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="name">Name </label><span class="mandate">*</span>
                  <input type="text" id="name" value="" placeholder="Name *" name="relationship_name[]" required/>
                </div>
                <div class="field-wrapper">
                  <label for="name">Email </label><span class="mandate">*</span>
                  <input
                    type="email"
                    id="name"
                    value=""
                    placeholder="Email *"
                    name="relationship_email[]"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="phone">Phone </label><span class="mandate">*</span>
                  <input
                    type="number"
                    id="phone"
                    value=""
                    placeholder="Phone"
                    name="relationship_phone[]"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="Relationship">Relationship</label>
                  <input
                    type="text"
                    id="Relationship"
                    value=""
                    placeholder="Relationship"
                    name="relationship[]"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="name">Name *</label>
                  <input type="text" id="name" value="" placeholder="Name *" name="relationship_name[]" required/>
                </div>
                <div class="field-wrapper">
                  <label for="name">Email *</label>
                  <input
                    type="email"
                    id="name"
                    value=""
                    placeholder="Email"
                    name="relationship_email[]"
                    required
                  />
                </div>
                <div class="field-wrapper">
                  <label for="phone">Phone *</label>
                  <input
                    type="number"
                    id="phone"
                    value=""
                    placeholder="Phone"
                    name="relationship_phone[]"
                    required
                  />
                </div>
              </div>

              <h3 class="heading-bg">Medical Information</h3>
             <div class="form-wrapper single_row">
                <div class="field-wrapper">
                  <p class="mb-2">
                    Did you receive an Influenza Vaccine this year?
                  </p>
                  <input onchange="toggle_influeza(event.target.value)" type="radio" id="yes1" name="influenza" checked value="yes"/>
                  <label for="yes1">Yes</label>
                  <input onchange="toggle_influeza(event.target.value)" type="radio" id="no1" name="influenza" value="no"/>
                  <label for="no1">No</label>
                </div>
                <div class="field-wrapper w-25 influenza_date">

                  <label for="end_date">Vaccinated Date<span class="mandate">*</span></label>

                  <div id="end_date" class="date" data-date-format="mm/dd/yyyy">
                    <input type="text" readonly />
                    <span class="input-group-addon">
                      <i class="icon icon-eye"></i>
                    </span>
                  </div>
                </div>
                <div class="field-wrapper w-100 influenza_reason">
                  <p class="mb-2">If No, Why?</p>
                  <textarea
                    placeholder="Disclaimer: You will need to bring a Physicians note to this affect!!!"
                    id="business"
                    name="business"
                  ></textarea>
                </div>
                <div class="field-wrapper" >
                  <p class="mb-2">
                    Did you receive an Hepatitis Vaccine this year?
                  </p>
                  <input onchange="toggle_hepatitis(event.target.value)" type="radio" id="yes" name="radio-group" value="yes" checked />
                  <label for="yes">Yes</label>
                  <input onchange="toggle_hepatitis(event.target.value)" type="radio" id="no" name="radio-group" value="no"/>
                  <label for="no">No</label>
                </div>
                <div class="field-wrapper w-25 hepatitis_date">
                  <label for="end_date">Vaccinated date<span class="mandate">*</span></label>
                  <div id="end_date" class="date" data-date-format="mm/dd/yyyy">

                    <input type="text" readonly />
                    <span class="input-group-addon">
                      <i class="icon icon-eye"></i>
                    </span>
                  </div>
                </div>
                <div class="field-wrapper w-100 hepatitis_reason">
                  <p class="mb-2">If No, Why?</p>
                  <textarea
                    placeholder="Disclaimer: You will need to bring a Physicians note to this affect!!!"
                    id="business"
                    name="business"
                  ></textarea>
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
            </div>
            <div class="modal-body">
              <form id="schedule_interview_form" method="POST" action="">
                <div class="form-wrapper">
                  
                  <div class="field-wrapper">
                    <label for="fname">Interview Date/Time</label>
                    <div id="interview_date_div" class="date" data-date-format="mm/dd/yyyy H:i:s">
                      <input required type="text" name="interview_date" id="interview_date" readonly placeholder="Interview Date" />
                      <span class="input-group-addon d-none">
                        <i class="icon icon-eye"></i>
                      </span>
                    </div>
                  </div>
                  
                  
                
                <div class="cta_wrapper d-flex justify-content-center gap-5">
              <button class="danger" data-dismiss="modal">Clear</button>
              <button class="success" id="schedule_interview_btn">Save</button>
            </div>
            </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>


@endsection