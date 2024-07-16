var formTitle = $('#formTitle');
var formname = "report_form";
var catformname = "report_form";
 
/**Form validation */
$(document).on('click', '#save_report_btn', function () { 
	jQuery(`#${formname}`).validate({
		rules: {
			name: {
				required: true,
				minlength: 1,
				maxlength: 40,
			},  
			folder: {
				required: true,
			}
		},

		messages: {
			name: {
				required: "Report Name cannot be empty",
				maxlength: "Report Name cannot exceed 40 characters",
			}, 
			folder: {
				required: "Folder cannot be empty",
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
	var formBtnId = 'save_report_btn';
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
function delete_chart_confirmation() {
	$("#modal_msg").text("Are you sure want delete the chart?");
	$("#function_name").val("delete_chart");
	$("#ConfirmModal").modal("show");
} 

 
function openPopup() { 
	// formTitle.text('Add new Chart'); 
	$(`#reportAddModal`).modal('show');
	$(`#${formname}`).trigger("reset")
	// $(`#${formname} [name=id]`).val('');
	 
} 
function open_designer(report) {  
	// formTitle.text('Add new Chart'); 
	$(`#report_path`).show();
	// $(`#${formname}`).trigger("reset");
	$('#report_path').attr('src', `/thhs-backend/designer?reportId=${report.report_id}`) 
	 
}
function openFolder(reportFolder) {  
	sessionStorage.setItem("open_report_folder", reportFolder)
}



function open_viewer(report) {  
	// formTitle.text('Add new Chart'); 
	$(`#report_path`).show();
	// $(`#${formname}`).trigger("reset");
	$('#report_path').attr('src', `/thhs-backend/viewer?reportId=${report.report_id}`) 
	 
} 


 

/**Get Details */  
function get_report(id) {
	// formTitle.text('Edit Chart'); 
	$.ajax({
		url: `${location.pathname}/get_report/${id}`,
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			$(`#reportAddModal`).modal('show');
			let data = response.data.report; 
			$(`#${formname} [name=id]`).val(data.id); 
			$(`#${formname} [name=category]`).val(data.category_id); 
			$(`#${formname} [name=name]`).val(data.name);  
		},
		error: function (err) {
			toastr.error("Data getting failed")
		}
	});
} 

/**Delete */  
function delete_chart() {
	var formBtnId = 'confirm_btn';
	let url = $("#delete_chart_btn").attr('data-url');
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



$( document ).ready(function() {
    console.log( "ready!" );
	let open_report_folder = sessionStorage.getItem("open_report_folder");
	$(`#${open_report_folder}`).trigger("click");
});

 