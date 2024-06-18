@extends('layouts.app')
@section('content')


<section class="table-wrapper contact-info bg-white">
    <div
      class="table-heading-data mb-5 d-flex align-items-center justify-content-between"
    >
      <!-- <h5>Adamenko Nataliia (HHA) | Mobile : 786-966-8411</h5> -->
      <h5>{{@$data->name. ' (' . @$data->position.')'}}</h5>
    </div>
    <div
      class="table-heading-data d-flex align-items-center justify-content-between"
    >
      <h5>Emergency Contacts</h5>
      <div
        class="table-center-heading-data d-flex align-items-center justify-content-between"
      >
      @php                      
      if(is_admin()){                            
      @endphp
        <div class="add-staff-field d-flex align-items-center">
          <i class="icon icon-plus"></i>
          <p data-toggle="modal" onclick="openEmergencyContactModal()">
            Add Emergency contact
          </p>
        </div>
      @php                      
      }                      
      @endphp
      </div>
    </div>
    <table class="w-100 contact-info" id="myTable">
      <thead>
        <tr>
          <td>Name</td>
          <td>Relationship</td>
          <td>Address</td>
          <td>Email</td>
          <td>Phone</td>
          <td>Notes</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['emergency_contacts'] as $emergency_contact)
        <tr>
          <td>{{ $emergency_contact->relationship_name }}</td>
          <!-- {{ @pr(get_emergency_contact_list()); }} -->
          <td>{{ @get_emergency_contact_details_by_id($emergency_contact->relationship_id)['name'] }}</td>
          <td>{{ @$emergency_contact->relationship_address }}
          </td>
          <td>{{ @$emergency_contact->relationship_email }}</td>
          <td class="phone_text">{{ @$emergency_contact->relationship_phone }}</td>
          <td></td>
          <td class="">
            <!-- <i class="icon icon-eye-green"></i> -->
            @php                      
            if(is_admin()){                            
            @endphp
            <a href="#" data-url="{{@route('staffs.get_emergency_contact',$emergency_contact->id)}}" onclick="get_emergency_contact(event)"><i class="icon icon-edit me-3" ></i></a>
            <a href="#" id="delete_emergency_contact_btn" data-url="{{@route('staffs.delete_emergency_contact',[$emergency_contact->id])}}" onclick="confirm_delete_emergency_contact()"><i class="icon icon-delete"></i></a>
            @php                      
            }                           
            @endphp
          </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
    @php
      if(count($data['emergency_contacts']) == 0){
        echo "<div style='text-align: center;'><span>No records found</span></div>";
      }
    @endphp
    <br>
    <br>
    <div
      class="table-heading-data mt-3 d-flex align-items-center justify-content-between"
    >
      <h5>Address</h5>
      <div
        class="table-center-heading-data d-flex align-items-center justify-content-between"
      >
      @php                      
      if(is_admin()){                            
      @endphp
        <div class="add-staff-field d-flex align-items-center">
          <i class="icon icon-plus"></i>
          <p data-toggle="modal" onclick="openAddressModal()">Add Address</p>
        </div>
      @php                      
      }                        
      @endphp
      </div>
    </div>
    <table class="w-100 contact-info">
      <thead>
        <tr>
          <td>Default</td>
          <td>Address Type</td>
          <td>Address</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['addresses'] as $address)
        <tr>
          <td> <i class="{{$address->is_default ? 'icon icon-tick-black' : '' }}"></i></td>
          <td>{{ @get_address_by_id($address->address_type)['name'] }}</td>
          @php 
          $user_address = @implode(", ",[$address->address,$address->city,$address->state,$address->country,$address->zip]);
          @endphp
          <td class="large_text_ellipsis" title="{{ @$user_address }}">{{ @$user_address }}</td>
          <td class="">
            <!-- <i class="icon icon-eye-green"></i> -->
            @php                      
            if(is_admin()){                            
            @endphp
            <a href="#" data-url="{{@route('staffs.get_address',$address->id)}}" onclick="get_address(event)"><i class="icon icon-edit me-3" ></i></a>
            <a href="#" id="delete_address_btn" data-url="{{@route('staffs.delete_address',[$address->id])}}" onclick="confirm_delete_address()"><i class="icon icon-delete"></i></a>
            @php                      
            }                     
            @endphp
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @php
    if(count($data['addresses']) == 0){
      echo "<div style='text-align: center;'><span>No records found</span></div>";
    }
  @endphp
    <br>
    <br>
    <div
      class="table-heading-data mt-3 d-flex align-items-center justify-content-between"
    >
      <h5>Phone</h5>
      <div
        class="table-center-heading-data d-flex align-items-center justify-content-between"
      >
      @php                      
      if(is_admin()){                            
      @endphp
        <div class="add-staff-field d-flex align-items-center">
          <i class="icon icon-plus"></i>
          <p data-toggle="modal" onclick="openPhoneModal()">Add Phone</p>
        </div>
        @php                      
        }                  
        @endphp
      </div>
    </div>
    
    <table class="w-100 contact-info">
      <thead>
        <tr>
          <td>Default</td>
          <td>Phone Type</td>
          <td>Number</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['phone_numbers'] as $phone_number)
        <tr>
          <td><i class="{{$phone_number->is_default ? 'icon icon-tick-black' : '' }}"></i></td>
          <td>{{ @get_phone_numbers_by_id($phone_number->phone_type)['name'] }}</td>
          <td class="phone_text">{{ $phone_number->phone_number }}</td>
          <td class="">
            <!-- <i class="icon icon-eye-green"></i> -->
            <a href="#" data-url="{{@route('staffs.get_phone',$phone_number->id)}}" onclick="get_phone(event)"><i class="icon icon-edit me-3" ></i></a>
            <a href="#" id="delete_phone_btn" data-url="{{@route('staffs.delete_phone',[$phone_number->id])}}" onclick="confirm_delete_phone()"><i class="icon icon-delete"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @php
      if(count($data['phone_numbers']) == 0){
        echo "<div style='text-align: center;'><span>No records found</span></div>";
      }
    @endphp
    <br>
    <br>
    <div
      class="table-heading-data mt-3 d-flex align-items-center justify-content-between"
    >
      <h5>Email</h5>
      <div
        class="table-center-heading-data d-flex align-items-center justify-content-between"
      >
      @php                      
      if(is_admin()){                            
      @endphp
        <div class="add-staff-field d-flex align-items-center">
          <i class="icon icon-plus"></i>
          <p data-toggle="modal"onclick="openEmailModal()">Add Email</p>
        </div>
        @php                      
      }                         
            @endphp
      </div>
    </div>
    <table class="w-100 contact-info">
      <thead>
        <tr>
          <td>Default</td>
          <td>Email Type</td>
          <td>Email</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['email_addresses'] as $email_address)
        <tr>
          <td><i class="{{$email_address->is_default ? 'icon icon-tick-black' : '' }}"></i></td>
          <td>{{ @get_email_addresses_by_id($email_address->email_type)['name'] }}</td>
          <td>{{ $email_address->email }}</td>
          <td class="">
            <!-- <i class="icon icon-eye-green"></i> -->
            @php                      
            if(is_admin()){                            
            @endphp
            <a href="#" data-url="{{@route('staffs.get_email',$email_address->id)}}" onclick="get_email(event)"><i class="icon icon-edit me-3" ></i></a>
            <a href="#" id="delete_email_btn" data-url="{{@route('staffs.delete_email',[$email_address->id])}}" onclick="confirm_delete_email()"><i class="icon icon-delete"></i></a>
            @php                      
             }                            
            @endphp
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @php
    if(count($data['email_addresses']) == 0){
      echo "<div style='text-align: center;'><span>No records found</span></div>";
    }
  @endphp
  </section>


  @include('staffs.add_emergency_contact');
  
  @include('staffs.add_address');

  @include('staffs.add_phone');

  @include('staffs.add_email');





@endsection