var formname = "upload";
function uploadForm() {
	// formTitle.text('Add new Chart'); 

	$(`#${formname}Modal`).modal('show');
	setTimeout(function(){
		$('#upload_button').text("Upload Document")
		$('#customFile').val("")
		$(`#${formname}`).trigger("reset")
	}, 100)

	
	// $(`#${formname}_form`).trigger("reset")
	// $(`#${formname} [name=chart_id]`).val('');
}

function scanForm() {
	// formTitle.text('Add new Chart'); 

	$(`#scanModal`).modal('show'); 
}

function thisFileUpload() {
	document.getElementById("customFile").click();
}

function previewFile(name, target) { 
	const file = document.querySelector(`input[name=${name}]`).files[0];
	$(`#${target}`).text(file.name) 
}
function open_delete_document() {
	$("#modal_msg").text("Are you sure want delete the document?");
	$("#function_name").val("delete_staff_document");
	$("#ConfirmModal").modal("show");
}

/**Form Submit */
$(document).on('submit', `#${formname}`, function (e) {
	var form = $(`#${formname}`);
	var formBtnId = 'upload_btn';
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

/**Form Submit */
$(document).on('submit', '#edit_document_form', function (e) {
	var form = $(`#edit_document_form`);
	var formBtnId = 'add_document_detail';
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


function delete_staff_document(){
	
	$(".error").remove();
	// if($("#cancellation_reason").val() == ""){
	// 	$("#cancellation_reason").parent("div").append("<span class='error'>Cancellatoin Reason cannot be empty</span>");
	// 	return false;
	// }
	var formBtnId = 'cancel_confirm_btn';
	let url = $("#delete_document_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	var formData = new FormData();  
	formData.append("document_id",$("#delete_document_btn").attr('data-id'));
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "POST", 
		data:formData,
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


$(document).on('click','#confirm_btn',function(e){
	console.log($("#function_name").val());
	eval($("#function_name").val() + "()");
});