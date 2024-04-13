$("#schedule_interview_form").on('submit',function(e){
	var btn = $("#schedule_interview_btn");
	var btn_text = btn.text();
	if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
		var formData = new FormData(this);     
		let messagePosition = 'toastr';
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
			// messagePosition:messagePosition,
			contentType: false,
			dataType:'json',
			processData: false,
			success: function(data){
				alert(data.message);
				if(data.status){
					if(data.redirect_url != ""){
						location.href = data.redirect_url;
					}else{
						location.reload();
					}
				}else{
					location.reload();
				}
				
			}
		});
	}
});


$("#confirm_interview_form").on('submit',function(e){
	var btn = $("#confirm_interview_btn");
	var btn_text = btn.text();
	if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
		var formData = new FormData(this);     
		let messagePosition = 'toastr';
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
			// messagePosition:messagePosition,
			contentType: false,
			dataType:'json',
			processData: false,
			success: function(data){
				alert(data.message);
				if(data.status){
					if(data.redirect_url != ""){
						location.href = data.redirect_url;
					}else{
						location.reload();
					}
				}else{
					location.reload();
				}
				
			}
		});
	}
});