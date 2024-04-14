$(document).on('submit','#demographics_form',function(e){
	// $(this).validate();
	
	var btn = $("#demographics_submit");
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
						location.href = data.redirect_url;
					}else{
						location.reload();
					}
				}else{
					toastr.error(data.message)
					location.reload();
				}
				
			}
		});
	}
});

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
				toastr.success(data.message)
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
				toastr.success(data.message);
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


$(document).on('submit','#add_prospect_form',function(e){
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
				location.reload();
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
				location.reload();
			}
		});
	}
});

$(document).on('click','button',function(e){
	if($(this).attr("data-dismiss") == "modal"){
		$(".modal").modal("hide");
	}
})

$(document).on('submit','#hire_prospect_form',function(e){
	var form = $("#hire_prospect_form");
    var formBtnId = 'hire_prospect_btn';
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
				location.reload();
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
				location.reload();
			}
		});
	}
});



$(document).on('click','#confirm_btn',function(e){
	eval($("#function_name").val() + "()");
});

function confirm_cancel_interview(){
	$("#modal_msg").text("Are you sure want cancel the Interview ?");
	$("#function_name").val("cancel_interview");
	$("#ConfirmModal").modal("show");
}

function openHireProspectModal(user_id){
	$("#user_id").val(user_id);
	$("#hireProspectModal").modal("show");
}

function cancel_interview(){
	var formBtnId = 'confirm_btn';
	let url = $("#cancel_interview_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	loadingButton(formBtnId)
	$.ajax({
		url: url, 
		type: "GET", 
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
			location.reload();
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
			location.reload();
		}
	});

}