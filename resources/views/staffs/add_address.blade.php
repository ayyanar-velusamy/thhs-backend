
  <!-- Add Address Modal-->

  <div
  class="modal fade"
  id="addAddressModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true"
  >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_address_form_title">
          Add Address
        </h5>
      </div>
      <form id="add_address_form" action="{{route('staffs.add_address')}}" class="ajax-form">
      <div class="modal-body">

        <input type="hidden" name="user_id" value="{{@request()->id}}">
        <input type="hidden" name="id" value="">
        
          <div class="form-wrapper">
            
            <div class="field-wrapper">
              <label for="mname">Address Type</label><span class="mandate">*</span>
              <select id="address_type" name="address_type" class="select-control">
                <option value="">Select Address Type</option>
                @foreach (@get_address_type_list() as $address_type)
                    <option value="{{ $address_type['id'] }}">{{ $address_type['name'] }}</option>
                @endforeach
              </select>  
              
            </div>
            <div class="field-wrapper">
              <label for="fname">Address</label><span class="mandate">*</span>
              <input type="text" id="address" name="address" value="" placeholder="Address" />
            </div>
            <div class="field-wrapper">
              <label for="fname">Country</label><span class="mandate">*</span>
              <input type="text" name="country" value="" placeholder="Country" />
            </div>
            <div class="field-wrapper">
              <label for="fname">State</label><span class="mandate">*</span>
              <input type="text" name="state" value="" placeholder="State" />
            </div>
            
            <div class="field-wrapper">
              <label for="mname">City</label><span class="mandate">*</span>
              <input
                type="text"
                name="city"
                placeholder="City"
              />
            </div>
            <div class="field-wrapper">
              <label for="mname">Zip</label><span class="mandate">*</span>
              <input
                type="text"
                name="zip"
                value=""
                placeholder="Zip"
              />
            </div>
            <div class="field-wrapper">
              <label for="mname">Is Default</label>
              <div class="checkbox-tick-wrapper default d-flex align-items-center">
                <label class="d-flex align-items-center">
                    <input type="checkbox" name="is_default" value="1"/>
                    <span class="cr me-3"><i class="icon icon-tick-white"></i></span>
                    
                </label>
            </div>
            </div>
          </div>
       
      </div>
      <div class="cta_wrapper d-flex justify-content-center gap-5">
        <button class="danger" type="button" data-dismiss="modal">
          Clear
        </button>
        <button class="success save-btn" id="add_address_btn">Save</button>
      </div>
    </form>
    </div>
  </div>
  </div>
  
  <!---End---->