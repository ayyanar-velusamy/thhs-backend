var formTitle = $('#formTitle');
var formname = "save_user_form"; 


/**DataTable */
var staff_table = $('#user_datatable').dataTable({
	"lengthChange": false,
	"order": [],
	"columnDefs": [{
		"targets": 0,
		"bSort": false,
		"orderable": false,
		"className": "dt-center"	
	},
	{
		"targets": 7,
		"bSort": false,
		"orderable": false
	},
	{"className": "dt-center", "targets": "_all"}],
	autoWidth: false,
	initComplete: function () {
		// $('#filter_status').trigger("change");
		// this.api()
		// 	.columns()
		// 	.every(function () {
		// 		let column = this;
				
		// 	});
	}
});


/**Table filter */ 
$('#filter_status').on('change', function () { 
	var table = $('#user_datatable').DataTable();
	// search(this.value, true, false).
	table.column(6). 
		search( this.value , {exact: true}).
		draw();
}); 

/**Form validation */
$(document).on('click', '#save_user_btn', function () { 
	jQuery(`#${formname}`).validate({
		rules: {
			firstname: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true
			},
			
			lastname: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true,
			},
			email: {
				required: true,
				maxlength: 64,
				validmail:true,
				noSpace:true,
			},
			phone_number:{
				required: true,
			},
			password:{
				required: true,
				newpassword:true,
				minlength:8,
				maxlength:16, 
				
			},
			password_confirmation: {
				required: true,
				confirmpassword:true,
				minlength:8,
				maxlength:16,
			}, 
			// account_expire_date:{
			// 	required: true,
			// },
			// password_expire_date:{
			// 	required: true,
			// },
			status: {
				required: true,
			} 
		},

		messages: {
			firstname: {
				required:"First Name cannot be empty",
				maxlength:"First Name cannot exceed 40 characters",
				lettersonly:"First Name should contain only alphabets", 
			},
			
			lastname: {
				required:"Last Name cannot be empty",
				maxlength:"Last Name cannot exceed 40 characters",
				lettersonly:"Last Name should contain only alphabets", 
			},	
			
			email: {
				required:"Email ID cannot be empty",
				maxlength:"Email address cannot exceed 64 characters",
				validmail:"Enter a valid Email ID", 
				noSpace:"Space are not allowed",
			},
			phone_number:{
				required:"Phone number cannot be empty",
			},
			password:{
				required:"Password cannot be empty",
				minlength:"Password cannot be less than 8 characters",
				maxlength:"Password cannot exceed 16 characters",
				newpassword:"Password must contain at least 1 digit, 1 lowercase letter,1 uppercase letter and 1 special character",
			
			},	
			password_confirmation:{
				required:"Confirm Password cannot be empty",
				confirmpassword:"Password mismatch! Retry",
			}, 
			status: {
				required: "Status cannot be empty",
			},
			// account_expire_date:{
			// 	required:"Account Expire date cannot be empty",
			// },
			// password_expire_date:{
			// 	required:"Password Expire date cannot be empty",
			// },
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

/**Form Submit */
$(document).on('submit', `#${formname}`, function (e) {
	var form = $(`#${formname}`);
	var formBtnId = 'save_user_btn';
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

/**Delete Popup */ 
$(function () {
	$(".cancel_btn").click(function () { 
		$(".modal").modal("hide");
	});
});
$(document).on('click', 'button', function (e) {
	if ($(this).attr("data-dismiss") == "modal") {
		$(".modal").modal("hide");
	}
})
$(document).on('click', '#confirm_btn', function (e) {
	eval($("#function_name").val() + "()");
});
function delete_user_confirmation() {
	$("#modal_msg").text("Are you sure want delete the user?");
	$("#function_name").val("delete_user");
	$("#ConfirmModal").modal("show");
} 

/**Open Popup */  
function openPopup(name) {
		formTitle.text('Add User'); 
		$(`#${name}Modal`).modal('show');
		$(`#${formname}`).trigger("reset")
		$(`#${formname} [name=id]`).val('');
		$(`span.error`).hide();
		$('#roles').val(null).trigger('change'); 
}  

/**Get Details */  
function getData(id) {
	formTitle.text('Edit User');
	// $('.hideField').hide(); 	 
	$.ajax({
		url: `${location.pathname}/get_user/${id}`,
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			$(`#userModal`).modal('show');
			let data = response.data.user
			$(`#${formname} [name=id]`).val(data.id);  
			$(`#${formname} [name=firstname]`).val(data.firstname);  
			$(`#${formname} [name=lastname]`).val(data.lastname);  
			$(`#${formname} [name=email]`).val(data.email);  
			$(`#${formname} [name=phone_number]`).val(data.cellular);   
			$(`#${formname} [name=status]`).val(data.app_user_status);  
			$(`#${formname} [name=password]`).val("TextPassword#003");  
			$(`#${formname} [name=password_confirmation]`).val("TextPassword#003");  
			$(`#${formname} [name=account_expire_date]`).val(moment(data.account_expire_date).format('MM/DD/YYYY'));
			$(`#${formname} [name=password_expire_date]`).val(moment(data.password_expire_date).format('MM/DD/YYYY'));
			$('#roles').val(data.role.split(",")).trigger('change');
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
} 

/**Delete */  
function delete_user() {
	var formBtnId = 'confirm_btn';
	let url = $("#delete_user_btn").attr('data-url');
	let target = ('#' + $(this).attr('id') == '#undefined') ? 'body' : '#' + $(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url,
		type: "GET",
		contentType: false,
		dataType: 'json',
		processData: false,
		success: function (data) {
			unloadingButton(formBtnId)
			$(".modal").modal("hide");
			if (data.status) {
				toastr.success(data.message)
			} else {
				toastr.error(data.message)
			}
			reload_page();
		},
		error: function (err) {
			unloadingButton(formBtnId)
			$(".modal").modal("hide");
			if (err.responseJSON) {
				toastr.error(err.responseJSON.message)
			}
			handleFail(err.responseJSON, {
				container: target,
				errorPosition: "field"
			})
			// reload_page();
		}
	});

} 
 