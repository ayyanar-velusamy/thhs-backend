<!-- Add Phone Modal-->

<div
class="modal fade"
id="addPhoneModal"
tabindex="-1"
role="dialog"
aria-labelledby="exampleModalCenterTitle"
aria-hidden="true"
>
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="add_phone_form_title">
        Add Phone number
      </h5>
    </div>
    <form id="add_phone_form" action="{{route('staffs.add_phone')}}" class="ajax-form">
    <div class="modal-body">
      
        <div class="form-wrapper">
          
        <input type="hidden" name="user_id" value="{{@request()->id}}">
        <input type="hidden" name="id" value="">
          
          <div class="field-wrapper">
            <label for="mname">Phone Type</label><span class="mandate">*</span>
            <select id="phone_type" name="phone_type" class="select-control">
              <option value="">Select Phone Type</option>
              @foreach (@get_phone_numbers_type_list() as $phone_type)
                    <option value="{{ $phone_type['id'] }}">{{ $phone_type['name'] }}</option>
                @endforeach
            </select>  
            
          </div>
          <div class="field-wrapper">
            <label for="fname">Extension</label>
            <input type="text" id="name" name="extension" value="" placeholder="Extension" />
          </div>
          <div class="field-wrapper">
            <label for="fname">Phone</label><span class="mandate">*</span>
            <input type="text" id="name"class="phone" name="phone_number" value="" placeholder="Phone" />
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
      <button class="danger"  type="button" data-dismiss="modal">
        Clear
      </button>
      <button class="success save-btn" id="add_phone_btn">Save</button>
    </div>
  </form>
  </div>
</div>
</div>

<!---End---->