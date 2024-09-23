

<!-- Add Emergency Contact Modal-->

<div
class="modal fade"
id="addEmergencyContactModal"
tabindex="-1"
role="dialog"
aria-labelledby="exampleModalCenterTitle"
aria-hidden="true"
data-bs-backdrop="static"
>
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="add_emergency_contact_form_title">
        Add Emergency Contact
      </h5>
    </div>
    <form id="add_emergency_contact_form" action="{{route('staffs.add_emergency_contact')}}" class="ajax-form">
    <div class="modal-body">
      <input type="hidden" name="user_id" value="{{@request()->id}}">
      <input type="hidden" name="id" value="">
        <div class="form-wrapper">
          <div class="field-wrapper">
            <label for="fname">Name</label><span class="mandate">*</span>
            <input type="text" id="relationship_name" name="relationship_name" required placeholder="Name" />
          </div>
          <div class="field-wrapper">
            <label for="mname">Relationship</label><span class="mandate">*</span>
            <select id="relationship" class="select-control" name="relationship_id" required>
              <option value="">Select Relationship</option>
              @foreach (@get_emergency_contact_list() as $emergency_contact)
              <option value="{{ $emergency_contact['id'] }}">{{ $emergency_contact['name'] }}</option>
              @endforeach
            </select>  
            
          </div>
          <div class="field-wrapper">
            <label for="mname">Address</label>
            <textarea
              id="relationship_address"
              name="relationship_address"
              placeholder="Address"
              ></textarea>
          </div>
          <div class="field-wrapper">
            <label for="mname">Email</label><span class="mandate">*</span>
            <input
              type="email"
              id="relationship_email"
              name="relationship_email"
              required
              placeholder="Email"
            />
          </div>
          <div class="field-wrapper">
            <label for="mname">Phone</label><span class="mandate">*</span>
            <input
              type="text"
              id="relationship_phone"
              name="relationship_phone"
              required
              class="phone"
              placeholder="Phone"
            />
          </div>
          <div class="field-wrapper">
            <label for="mname">Notes</label>
            <textarea
              id="relationship_notes"
              name="relationship_notes"
              value=""
              placeholder="Notes"
            ></textarea>
          </div>
        </div>
      
    </div>
    <div class="cta_wrapper d-flex justify-content-center gap-5">
      <button class="danger" type="button" data-dismiss="modal">
        Clear
      </button>
      <button class="success save-btn" id="add_emergency_contact_btn">Save</button>
    </div>
  </form>
  </div>
</div>
</div>


<!--End--->
