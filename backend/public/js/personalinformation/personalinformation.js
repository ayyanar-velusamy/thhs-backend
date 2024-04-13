
$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
		var formData = new FormData(this);     
		let messagePosition = 'toastr';
		// var formData = new FormData();
		// jQuery.each(jQuery('#inputFile')[0].files, function(i, file) {
		// 	formData.append('file-'+i, file);
		// });
		$.ajax({
			url: url,
			// container	: target,
			type: "POST",
			// redirect: true,
			// disableButton: true,
			// file: true,
			data: formData,
			// messagePosition:messagePosition,
			contentType: false,
			processData: false,
			success: function(data){
				// alert(data);
			}
		});
	}
});