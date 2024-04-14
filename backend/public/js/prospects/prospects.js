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



$("#add_prospect_form").on('submit',function(e){
	var form = $("#add_prospect_form");
    var formBtnId = 'add_prospect_btn';
	if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action'); 
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		var formData = new FormData(this);  
		loadingButton(formBtnId)
		$.ajax({
			url: url, 
			type: "POST", 
			data: formData, 
			contentType: false,
			dataType:'json',
			processData: false,
			success: function(data){
				unloadingButton(formBtnId)
				form.trigger("reset");
				if(data.status){
					toastr.success(data.message) 
				}else{
					toastr.error(data.message) 
				} 
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
				
			}
		});
	}
});