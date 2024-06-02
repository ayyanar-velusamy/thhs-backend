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

function thisFileUpload() {
	document.getElementById("customFile").click();
}

function previewFile(name, target) { 
 
	const file = document.querySelector(`input[name=${name}]`).files[0];
	$(`#${target}`).text(file.name) 
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
