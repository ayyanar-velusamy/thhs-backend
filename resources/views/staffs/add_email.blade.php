

<!-- Add Email Modal-->

<div
class="modal fade"
id="addEmailModal"
tabindex="-1"
role="dialog"
aria-labelledby="exampleModalCenterTitle"
aria-hidden="true"
>
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="add_email_form_title">
        Add Email Address
      </h5>
    </div>
    <form id="add_email_form" action="{{route('staffs.add_email')}}" class="ajax-form">
    <div class="modal-body">
      <input type="hidden" name="user_id" value="{{@request()->id}}">
        <input type="hidden" name="id" value="">
        <div class="form-wrapper">
          
          <div class="field-wrapper">
            <label for="mname">Email Type</label><span class="mandate">*</span>
            <select id="email_type" name="email_type" class="select-control" required>
              <option value="">Select Email Type</option>
              @foreach (@get_email_addresses_type_list() as $email_type)
                    <option value="{{ $email_type['id'] }}">{{ $email_type['name'] }}</option>
                @endforeach
            </select>  
            
          </div>
          <div class="field-wrapper">
            <label for="fname">Email</label><span class="mandate">*</span>
            <input type="text" id="email" name="email" value="" placeholder="Email" required/>
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
      <button class="success save-btn" id="add_email_btn">Save</button>
    </div>
  </form>
  </div>
</div>
</div>

<!---End---->