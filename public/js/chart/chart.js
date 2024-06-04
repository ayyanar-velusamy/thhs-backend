var formTitle = $('#formTitle');
var formname = "save_chart_form";
var catformname = "chart_category_form";


/**DataTable */
var staff_table = $('#chart_datatable').dataTable({
	"lengthChange": false,
	"order": [],
	"columnDefs": [{
		"targets": 0,
		"bSort": false,
		"orderable": false,
		"className": "dt-center"	
	},
	{
		"targets": 8,
		"bSort": false,
		"orderable": false
	},
	{"className": "dt-center", "targets": "_all"}],
	autoWidth: false,
	initComplete: function () {
		$('#filter_category').trigger("change");
		this.api()
			.columns()
			.every(function () {
				let column = this;
				
			});
	}
});


/**Table filter */ 
$('#filter_category').on('change', function () { 
	var table = $('#chart_datatable').DataTable();
	table.column(0).
		search(this.value, true, false).
		draw();
}); 

/**Form validation */
$(document).on('click', '#save_chart_btn', function () { 
	jQuery(`#${formname}`).validate({
		rules: {
			name: {
				required: true,
				minlength: 1,
				maxlength: 40,
			},  
			group: {
				required: true,
			},
			valid_interval: {
				required: true,
			},
			valid_number: {
				required: true,
			},
			renewal_interval: {
				required: true,
			},
			renewal_number: {
				required: true,
			},
			provide_interval: {
				required: true,
			},
			provide_number: {
				required: true,
			},
			// report: {
			// 	required: true,
			// },
			chart_handling: {
				required: true,
			} 
		},

		messages: {
			name: {
				required: "Name cannot be empty",
				maxlength: "Name cannot exceed 40 characters",
			}, 
			group: {
				required: "Group cannot be empty",
			},
			valid_interval: {
				required: "Valid For Interval cannot be empty",
			},
			valid_number: {
				required: "Number cannot be empty",
			},
			renewal_interval: {
				required: "Renewal Interval cannot be empty",
			},
			renewal_number: {
				required: "Number cannot be empty",
			},
			provide_interval: {
				required: " Provide Interval cannot be empty",
			},
			provide_number: {
				required: "Provide Number cannot be empty",
			},
			// report: {
			// 	required: "Report cannot be empty",
			// },
			chart_handling: {
				required: "Chart Handling cannot be empty",

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
	var formBtnId = 'save_chart_btn';
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

/**Open Popup */  
function openPopup() {
	// formTitle.text('Add new Chart');
	$('.hideField').show();
	$('.offcanvas').offcanvas('show');
	$(`#${formname}`).trigger("reset")
	$(`#${formname} [name=id]`).val(''); 
}
function openCategoryPopup(formname) {
	// formTitle.text('Add new Chart'); 
	$(`#${formname}Modal`).modal('show');
	$(`#chart_${formname}_form`).trigger("reset")
	// $(`#${formname} [name=id]`).val('');
	 
} 

/**Get Details */  
function get_chart(id) {
	// formTitle.text('Edit Chart');
	$('.hideField').hide();
	$.ajax({
		url: `${location.pathname}/get_chart/${id}`,
		type: "GET",
		contentType: false,
		dataType: 'json',
		success: function (response) {
			$('.offcanvas').offcanvas('show'); 
			let data = response.data.chart; 
			$(`#${formname} [name=id]`).val(data.id); 
			$(`#${formname} [name=group]`).val(data.group); 
			$(`#${formname} [name=name]`).val(data.name); 
			$(`#${formname} [name=provide_interval]`).val(data.provide_interval); 
			$(`#${formname} [name=provide_number]`).val(data.provide_number); 
			$(`#${formname} [name=renewal_interval]`).val(data.renewal_interval); 
			$(`#${formname} [name=renewal_number]`).val(data.renewal_number); 
			$(`#${formname} [name=report]`).val(data.report);  
			$(`#${formname} [name=valid_interval]`).val(data.valid_interval); 
			$(`#${formname} [name=valid_number]`).val(data.valid_number);  
			$(`#${formname} [name=chart_handling]`).val(data.chart_handling);  
			if(data.positions && data.positions.length > 0){
				let position_ids = [...new Set(data.positions.map(item => item.id))];  
				$('#positions').val(position_ids).trigger('change');
			} 
			if(data.required == 1){
				$(`#${formname} [name=required]`).attr('checked','checked');  
			} 
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


/* Category form*/
$(document).on('submit', `#${catformname}`, function (e) {
	var form = $(`#${catformname}`);
	var formBtnId = 'save_category_btn';
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


/**Form validation */
$(document).on('click', '#save_chart_category_btn', function () { 
	jQuery(`#${catformname}`).validate({
		rules: {
			category: {
				required: true,
				minlength: 1,
				maxlength: 40,
				lettersonly: true
			} 
		},

		messages: {
			category: {
				required: "Category cannot be empty",
				maxlength: "Category cannot exceed 40 characters",
				lettersonly: "Category should contain only alphabets",
			} 
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
			console.log(error);
			$('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			console.log(element);

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
