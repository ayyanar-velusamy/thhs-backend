var formTitle = $('#formTitle');
var formname = "save_staff_form";

/**DataTable */
var staff_table = $('#staff_datatable').dataTable({
	"lengthChange": false,
	"order": [],
	"columnDefs": [{
		"targets": 0,
		"bSort": false,
		"orderable": false,
		"className": "dt-center"	
	},
	{
		"targets": 10,
		"bSort": false,
		"orderable": false
	},
	{"className": "dt-center", "targets": "_all"}],
	autoWidth: false,
	initComplete: function () {
		$('#filter_status').trigger("change");
		this.api()
			.columns()
			.every(function () {
				let column = this;
				
			});
	}
});


/**Table filter */ 
$('#filter_status').on('change', function () {
	alert();
	var table = $('#staff_datatable').DataTable();
	table.column(7).
		search(this.value, true, false).
		draw();
});
$('#filter_organization').on('change', function() {
	var table = $('#staff_datatable').DataTable();
	table.column(9).
	  search(this.value && `^${this.value}$`, true, false).
		draw();
});

/**Form validation */
$(document).on('click', '#save_staff_btn', function () {
	jQuery(`#${formname}`).validate({
		rules: {
			firstname: {
				required: true,
				minlength: 1,
				maxlength: 40,
				lettersonly: true
			},
			lastname: {
				required: true,
				minlength: 1,
				maxlength: 40,
				lettersonly: true,
			},
			email: {
				required: true,
				maxlength: 64,
				validmail: true,
				noSpace: true,
			},
			submit_date: {
				required: true,
			},
			// termination_date: {
			// 	required: true,
			// },
			ssn: {
				required: true,
			},
			organization: {
				required: true,
			},
			position: {
				required: true,
			},
			gender: {
				required: true,
			},
			languages: {
				required: true,
			},
			employment_type: {
				required: true,
			},
			staff_status: {
				required: true,
			}
		},

		messages: {
			firstname: {
				required: "First Name cannot be empty",
				maxlength: "First Name cannot exceed 40 characters",
				lettersonly: "First Name should contain only alphabets",
			},
			lastname: {
				required: "Last Name cannot be empty",
				maxlength: "Last Name cannot exceed 40 characters",
				lettersonly: "Last Name should contain only alphabets",
			},

			email: {
				required: "Email ID cannot be empty",
				maxlength: "Email address cannot exceed 64 characters",
				validmail: "Enter a valid Email ID",
				noSpace: "Space are not allowed",
			},

			submit_date: {
				required: "Date hired cannot be empty",
			},
			// termination_date: {
			// 	required: "Terminatio Date hired cannot be empty",
			// },
			ssn: {
				required: "SSN cannot be empty",
			},
			organization: {
				required: "Organization cannot be empty",
			},
			gender: {
				required: "Gender cannot be empty",
			},
			languages: {
				required: "Language cannot be empty",
			},
			staff_status: {
				required: "Status cannot be empty",
			},
			corporation_name: {
				required: "corporation cannot be empty",
			},
			employment_type: {
				required: "Tax cannot be empty",
			},
			position: {
				required: "Position cannot be empty",
			},
			submit_date: {
				required: "Date Hired cannot be empty",

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

/**Form Submit */
$(document).on('submit', `#${formname}`, function (e) {
	var form = $(`#${formname}`);
	var formBtnId = 'save_staff_btn';
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
		$('.offcanvas').offcanvas('hide');
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
function delete_staff_confirmation() {
	$("#modal_msg").text("Are you sure want delete the Staff?");
	$("#function_name").val("delete_staff");
	$("#ConfirmModal").modal("show");
}



/**Open Popup */  
function openStaffPopup() {
	formTitle.text('Add new Staff');
	$('.hideField').show();
	$('.offcanvas').offcanvas('show');
	$(`#${formname}`).trigger("reset")
	$(`#${formname} [name=id]`).val('');
	uploadClear();
}

/**Upload Clear */  
function uploadClear() {
	const preview = document.getElementById("signature_image");
	preview.src = "";
	$(`#signature_image`).hide()
	$(`#signature64`).val("")
	$(`#upload_button`).text("Upload your e signature")
} 

/**Get Details */  
function get_staff(id) {
	formTitle.text('Edit Staff');
	$('.hideField').hide();
	$.ajax({
		url: `${location.pathname}/get_staff/${id}`,
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			$('.offcanvas').offcanvas('show');
			uploadClear();
			let staff = response.data.staff
			$(`#${formname} [name=id]`).val(staff.id);
			$(`#${formname} [name=firstname]`).val(staff.firstname);
			$(`#${formname} [name=middlename]`).val(staff.middlename);
			$(`#${formname} [name=lastname]`).val(staff.lastname);
			$(`#${formname} [name=dob]`).val(moment(staff.birth_date).format('MM/DD/YYYY'));
			$(`#${formname} [name=submit_date]`).val(moment(staff.hire_date).format('MM/DD/YYYY'));
			$(`#${formname} [name=ssn]`).val(staff.ssn);
			$(`#${formname} [name=organization]`).val(staff.organization);
			$(`#${formname} [name=position]`).val(staff.position);
			$(`#${formname} [name=gender]`).val(staff.gender);
			$(`#${formname} [name=email]`).val(staff.email);  
			$(`#${formname} [name=staff_status]`).val(staff.staff_status);
			$(`#${formname} [name=employment_type]`).val(staff.role);
			$('#languages').val(staff.language_id.split(",")).trigger('change');
			let termination_date = (staff.termination_date != null) ? moment(staff.termination_date).format('MM/DD/YYYY') : "";
			console.log(termination_date);
			$(`#${formname} [name=termination_date]`).val(termination_date);
			$(`#${formname} [name=corporation_name]`).val(staff.corporation_name);
			$(`#${formname} [name=tax_id]`).val(staff.tax_id);
			if (staff.signature_path) {
				document.getElementById('signature_image').src = `${window.location.origin}/${staff.signature_path}`;
				$(`#signature_image`).show()
			}
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
}


function previewFile(name, target, image) {
	const preview = document.getElementById(image);
	const file = document.querySelector(`input[name=${name}]`).files[0];
	const reader = new FileReader();   

	reader.addEventListener(
		"load",
		() => {
			// convert image file to base64 string 
			let newImage = new Image(); 
			newImage.src = URL.createObjectURL(file); 
			newImage.onload = function () { 
					let w = newImage.width; 
					let h = newImage.height;  
					if ((file.size / 1000) > 999) {
						$(`#${formname} [name=signature_file]`).val("");
						toastr.error('File too Big, please select a file less than 1mb')
						uploadClear();
					}else if(w > 500 || h > 200){
						$(`#${formname} [name=signature_file]`).val("");
						toastr.error('File dimention too Big, please select a image dimention width less than 500px and height less than 200px')
						uploadClear();
					} else {
						preview.src = reader.result;
						$(`#${target}`).val(reader.result)
						$(`#upload_button`).text(file.name)
						$(`#signature_image`).show()
					}
			};  
		},
		false,
	); 
	if (file) {
		reader.readAsDataURL(file);
	}
}

/**Delete */  
function delete_staff() {
	var formBtnId = 'confirm_btn';
	let url = $("#delete_staff_btn").attr('data-url');
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

function thisFileUpload() {
	document.getElementById("customFile").click();
}
$(document).on('submit','#staff_demographics_form',function(e){
	// $(this).validate();
	
	var btn = $("#staff_demographics_submit");
	var btn_text = btn.text();
	if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		// let myEle = document.getElementById("inputFile");
		var formData = new FormData(this);   
		btn.text("Loading..");
		btn.prop('disabled', true);
		$.ajax({
			url: url,
			// container	: target,
			type: "POST",
			// redirect: true,
			// disableButton: true,
			// file: true,
			data: formData, 
			contentType: false,
			dataType:'json',
			processData: false,
			success: function(data){
			
				if(data.status){
					toastr.success(data.message)
					if(data.redirect_url != ""){
						// location.href = data.redirect_url;
						reload_page(data.redirect_url);
					}else{
						reload_page();
						// location.reload();
					}
				}else{
					toastr.error(data.message)
					// location.reload();
					reload_page();
				}
				
			}
		});
	}
});