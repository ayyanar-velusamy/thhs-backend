/**Form validation */
$(document).on('click', '#add_emergency_contact_btn', function () {
    jQuery("#add_emergency_contact_form").validate({
		rules: {
			relationship_name: {
				required: true,
				minlength: 1,
				maxlength: 40,
			},
            relationship_email: {
				required: true,
				minlength: 1,
				maxlength: 40,
                validmail:true
                
			},
			relationship_id: {
				required: true
			},
			relationship_phone: {
				required: true,
				maxlength: 64,
				noSpace: true,
			},
		},

		messages: {
			relationship_name: {
				required: "Name cannot be empty",
				maxlength: " cannot exceed 40 characters",
			},
            relationship_email: {
				required: "Email cannot be empty",
				maxlength: "Email cannot exceed 40 characters",

			},
			relationship_id: {
				required: "Relationship cannot be empty",
				
			},

			relationship_phone: {
				required: "Phone cannot be empty",
			},
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
            $('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				if (element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				} else {
					error.insertAfter(element);
				}
			}
		}
	});
}); 

$(document).on('click', '#add_address_btn', function () {
    jQuery("#add_address_form").validate({
		rules: {
			address_type: {
				required: true,
			},
            address: {
				required: true,
				minlength: 1,
				maxlength: 40,
                
			},
            country :{
                required: true
            },
			state: {
				required: true
			},
			city: {
				required: true,
				
			},
            zip:{
                required: true,
            }
		},

		messages: {
			address_type: {
				required: "Address type cannot be empty",
            },
            address: {
				required: "Address cannot be empty",
            },
			state: {
				required: "State cannot be empty",
				
			},
            country: {
				required: "Country cannot be empty",
			},

			city: {
				required: "City cannot be empty",
			},
            zip: {
                required: "Zip cannot be empty",
            },
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
            $('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				if (element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				} else {
					error.insertAfter(element);
				}
			}
		}
	});
}); 


$(document).on('click', '#add_phone_btn', function () {
    jQuery("#add_phone_form").validate({
		rules: {
			phone_type: {
				required: true,
			},
            phone_number :{
                required: true
            },
		},

		messages: {
			phone_type: {
				required: "Phone type cannot be empty",
            },
            phone_number: {
				required: "Phone number cannot be empty",
            },
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
            $('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				if (element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				} else {
					error.insertAfter(element);
				}
			}
		}
	});
}); 



$(document).on('click', '#add_email_btn', function () {
	
    jQuery("#add_email_form").validate({
		rules: {
			email_type: {
				required: true,
			},
            email :{
                required: true,
				validmail:true,
            },
		},

		messages: {
			email_type: {
				required: "Email type cannot be empty",
            },
            email: {
				required: "Email cannot be empty",
            },
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
            $('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				if (element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				} else {
					error.insertAfter(element);
				}
			}
		}
	});
}); 



$(document).on('submit',".ajax-form",function (e) {
	
    var form = $(this);
	var formBtnId = $(this).find(".save-btn").attr("id");
    console.log(new FormData(this));
	if ($(this).hasClass('ajax-form')) {
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#' + $(this).attr('id') == '#undefined') ? 'body' : '#' + $(this).attr('id');
		var formData = new FormData(this);
		loadingButton(formBtnId)
		$.ajax({
			url: url,
			type: "POST",
			data: formData,
			contentType: false,
			dataType: 'json',
			processData: false,
			success: function (data) {
				unloadingButton(formBtnId)
				form.trigger("reset");
				if (data.status) {
					toastr.success(data.message)
					location.reload();
				} else {
					toastr.error(data.message)
				}

			},
			error: function (err) {
				unloadingButton(formBtnId)
				if (err.responseJSON) {
					toastr.error(err.responseJSON.message)
				}
				handleFail(err.responseJSON, {
					container: target,
					errorPosition: "field"
				})
				// location.reload();
			}
		});
	}
});



/**Get Details */  
function get_emergency_contact($this) {
    let formTitle = $("#add_emergency_contact_form_title");
    let formname = "add_emergency_contact_form";
	formTitle.text('Edit Emergency Contact');
	// $('.hideField').hide();
	$.ajax({
		url: $($this.target).parent("a").attr("data-url"),
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			let emergency_contact = response.data;
            $(`#${formname} [name=id]`).val(emergency_contact.id);
            $(`#${formname} [name=user_id]`).val(emergency_contact.user_id);
			$(`#${formname} [name=relationship_name]`).val(emergency_contact.relationship_name);
			$(`#${formname} [name=relationship_id]`).val(emergency_contact.relationship_id);
			$(`#${formname} [name=relationship_address]`).val(emergency_contact.relationship_address);
			$(`#${formname} [name=relationship_email]`).val(emergency_contact.relationship_email);
			$(`#${formname} [name=relationship_phone]`).val(emergency_contact.relationship_phone);
			$(`#${formname} [name=relationship_notes]`).val(emergency_contact.relationship_notes);
            $("#addEmergencyContactModal").modal("show");
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
}


/**Get Details */  
function get_address($this) {
    let formTitle = $("#add_address_form_title");
    let formname = "add_address_form";
	formTitle.text('Edit Address');
	// $('.hideField').hide();
	$.ajax({
		url: $($this.target).parent("a").attr("data-url"),
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			let address = response.data;
            $(`#${formname} [name=id]`).val(address.id);
            $(`#${formname} [name=user_id]`).val(address.user_id);
			$(`#${formname} [name=address_type]`).val(address.address_type);
			$(`#${formname} [name=address]`).val(address.address);
			$(`#${formname} [name=country]`).val(address.country);
			$(`#${formname} [name=state]`).val(address.state);
			$(`#${formname} [name=city]`).val(address.city);
			$(`#${formname} [name=zip]`).val(address.zip);
            
            if(address.is_default == 1){
                $(`#${formname} [name=is_default]`).attr("checked","checked");
            }
            $("#addAddressModal").modal("show");
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
}


/**Get Details */  
function get_phone($this) {
    let formTitle = $("#add_phone_form_title");
    let formname = "add_phone_form";
	formTitle.text('Edit Phone');
	// $('.hideField').hide();
	$.ajax({
		url: $($this.target).parent("a").attr("data-url"),
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			let phone = response.data;
            $(`#${formname} [name=id]`).val(phone.id);
            $(`#${formname} [name=user_id]`).val(phone.user_id);
			$(`#${formname} [name=phone_type]`).val(phone.phone_type);
			$(`#${formname} [name=extension]`).val(phone.extension);
			$(`#${formname} [name=phone_number]`).val(phone.phone_number);
			
            if(phone.is_default == 1){
                $(`#${formname} [name=is_default]`).attr("checked","checked");
            }
            $("#addPhoneModal").modal("show");
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
}



/**Get Details */  
function get_email($this) {
    let formTitle = $("#add_email_form_title");
    let formname = "add_email_form";
	formTitle.text('Edit Email');
	// $('.hideField').hide();
	$.ajax({
		url: $($this.target).parent("a").attr("data-url"),
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			let email = response.data;
            $(`#${formname} [name=id]`).val(email.id);
            $(`#${formname} [name=user_id]`).val(email.user_id);
			$(`#${formname} [name=email_type]`).val(email.email_type);
			$(`#${formname} [name=email]`).val(email.email);
			
			
            if(email.is_default == 1){
                $(`#${formname} [name=is_default]`).attr("checked","checked");
            }
            $("#addEmailModal").modal("show");
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
}




function openEmergencyContactModal(){
    $("#add_emergency_contact_form").trigger("reset");
    $("#add_emergency_contact_form_title").text("Add Emergency Contact");
    $("#addEmergencyContactModal").modal("show");
}


function openAddressModal(){
    $("#add_address_form").trigger("reset");
    // $(`#add_address_form [name=is_default]`).attr("checked");
    $("#add_address_form_title").text("Add Address");
    $("#addAddressModal").modal("show");
}


function openPhoneModal(){
    $("#add_phone_form").trigger("reset");
    // $(`#add_address_form [name=is_default]`).attr("checked");
    $("#add_phone_form_title").text("Add Phone");
    $("#addPhoneModal").modal("show");
}


function openEmailModal(){
    $("#add_email_form").trigger("reset");
    // $(`#add_address_form [name=is_default]`).attr("checked");
    $("#add_email_form_title").text("Add Email");
    $("#addEmailModal").modal("show");
}

function confirm_delete_emergency_contact(){
	$("#modal_msg").text("Are you sure want to delete the Contact?");
	$("#function_name").val("delete_emergency_contact");
	$("#ConfirmModal").modal("show");
}

function confirm_delete_address(){
	$("#modal_msg").text("Are you sure want to delete the Address?");
	$("#function_name").val("delete_address");
	$("#ConfirmModal").modal("show");
}

function confirm_delete_phone(){
	$("#modal_msg").text("Are you sure want to delete the Phone number?");
	$("#function_name").val("delete_phone");
	$("#ConfirmModal").modal("show");
}

function confirm_delete_email(){
	$("#modal_msg").text("Are you sure want to delete the Email Address?");
	$("#function_name").val("delete_email");
	$("#ConfirmModal").modal("show");
}

function delete_emergency_contact(){
	var formBtnId = 'confirm_btn';
	let url = $("#delete_emergency_contact_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		success: function(data){
			unloadingButton(formBtnId)
			if(data.status){
				toastr.success(data.message) 
			}else{
				toastr.error(data.message) 
			} 
			reload_page();
		},
		error: function(err){
			unloadingButton(formBtnId)
			if(err.responseJSON){  
				toastr.error(err.responseJSON.message) 
			}
			handleFail(err.responseJSON,{
				container : target,
				errorPosition : "field"
			})
			reload_page();
		}
	});

}

function delete_address(){
	var formBtnId = 'confirm_btn';
	let url = $("#delete_address_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		success: function(data){
			unloadingButton(formBtnId)
			if(data.status){
				toastr.success(data.message) 
			}else{
				toastr.error(data.message) 
			} 
			reload_page();
		},
		error: function(err){
			unloadingButton(formBtnId)
			if(err.responseJSON){  
				toastr.error(err.responseJSON.message) 
			}
			handleFail(err.responseJSON,{
				container : target,
				errorPosition : "field"
			})
			reload_page();
		}
	});

}


function delete_phone(){
	var formBtnId = 'confirm_btn';
	let url = $("#delete_phone_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		success: function(data){
			unloadingButton(formBtnId)
			if(data.status){
				toastr.success(data.message) 
			}else{
				toastr.error(data.message) 
			} 
			reload_page();
		},
		error: function(err){
			unloadingButton(formBtnId)
			if(err.responseJSON){  
				toastr.error(err.responseJSON.message) 
			}
			handleFail(err.responseJSON,{
				container : target,
				errorPosition : "field"
			})
			reload_page();
		}
	});

}


function delete_email(){
	var formBtnId = 'confirm_btn';
	let url = $("#delete_email_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		success: function(data){
			unloadingButton(formBtnId)
			if(data.status){
				toastr.success(data.message) 
			}else{
				toastr.error(data.message) 
			} 
			reload_page();
		},
		error: function(err){
			unloadingButton(formBtnId)
			if(err.responseJSON){  
				toastr.error(err.responseJSON.message) 
			}
			handleFail(err.responseJSON,{
				container : target,
				errorPosition : "field"
			})
			reload_page();
		}
	});

}

