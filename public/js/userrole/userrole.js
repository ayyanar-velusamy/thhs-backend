var formTitle = $('#formTitle');
var formname = "save_role_form";
var catformname = "chart_category_form";


/**DataTable */
var staff_table = $('#role_datatable').dataTable({
	"lengthChange": false,
	"order": [],
	"columnDefs": [{
		"targets": 0,
		"bSort": false,
		"orderable": false,
		"className": "dt-center"	
	},
	{
		"targets": 2,
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
	var table = $('#role_datatable').DataTable();
	// search(this.value, true, false).
	table.column(1). 
		search( this.value , {exact: true}).
		draw();
}); 

/**Form validation */
$(document).on('click', '#save_role_btn', function () { 
	jQuery(`#${formname}`).validate({
		rules: {
			role: {
				required: true,
				minlength: 1,
				maxlength: 40,
				lettersonly: true
			},  
			status: {
				required: true,
			} 
		},

		messages: {
			role: {
				required: "Role Name cannot be empty",
				maxlength: "Role Name cannot exceed 40 characters",
				lettersonly: "Role Name should contain only alphabets",
			}, 
			status: {
				required: "Status cannot be empty",
			},
			valid_interval: {
				required: "Valid For Interval cannot be empty",
			} 
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
	var formBtnId = 'save_role_btn';
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
function delete_role_confirmation() {
	$("#modal_msg").text("Are you sure want delete the role?");
	$("#function_name").val("delete_role");
	$("#ConfirmModal").modal("show");
} 

/**Open Popup */  
function openPopup(name) {
		formTitle.text('Add Role'); 
		$(`#${name}Modal`).modal('show');
		$(`#${formname}`).trigger("reset")
		$(`#${formname} [name=id]`).val('');
		$(`span.error`).hide();
		
}  

/**Get Details */  
function getData(id) {
	formTitle.text('Edit Role');
	// $('.hideField').hide();
	$.ajax({
		url: `${location.pathname}/get_role/${id}`,
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			$(`#roleModal`).modal('show');
			let data = response.data.role
			$(`#${formname} [name=id]`).val(data.id); 
			$(`#${formname} [name=status]`).val(data.status); 
			$(`#${formname} [name=role]`).val(data.role);  
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
} 

/**Delete */  
function delete_role() {
	var formBtnId = 'confirm_btn';
	let url = $("#delete_role_btn").attr('data-url');
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
 