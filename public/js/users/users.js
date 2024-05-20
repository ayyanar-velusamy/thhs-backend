$(document).on('submit','#add_user_form',function(e){
	var form = $("#add_user_form");
    var formBtnId = 'add_user_btn';
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
});

$(document).on('click','button',function(e){
	if($(this).attr("data-dismiss") == "modal"){
		$(".modal").modal("hide");
	}
})




// $(document).on('click','#cancel_confirm_btn',function(e){
// 	console.log($("#cancel_function_name").val());
// 	eval($("#cancel_function_name").val() + "()");
// });

// $(document).on('click','#confirm_btn',function(e){
// 	console.log($("#function_name").val());
// 	eval($("#function_name").val() + "()");
// });

// function confirm_cancel_interview(){
// 	$("#cancel_modal_msg").text("Are you sure want cancel the Interview?");
// 	$("#cancel_function_name").val("cancel_interview");
// 	$("#CancelInterviewModal").modal("show");
// }

// function confirm_reject_prospect(){
// 	$("#modal_msg").text("Are you sure want reject the Prospect?");
// 	$("#function_name").val("reject_prospect");
// 	$("#ConfirmModal").modal("show");
// }

// function confirm_reapply_prospect(){
// 	$("#modal_msg").text("Are you sure?");
// 	$("#function_name").val("reapply_prospect");
// 	$("#ConfirmModal").modal("show");
// }

// function confirm_reject_prospect(){
// 	$("#modal_msg").text("Are you sure want to reject the Prospect?");
// 	$("#function_name").val("reject_prospect");
// 	$("#ConfirmModal").modal("show");
// }

// function confirm_archive_prospect(){
// 	$("#modal_msg").text("Are you sure want to archive the Prospect?");
// 	$("#function_name").val("archive_prospect");
// 	$("#ConfirmModal").modal("show");
// }


function openHireProspectModal(user_id){
	$("#user_id").val(user_id);
	$("#hireProspectModal").modal("show");
}

function cancel_interview(){
	$(".error").remove();
	if($("#cancellation_reason").val() == ""){
		$("#cancellation_reason").parent("div").append("<span class='error'>Cancellatoin Reason cannot be empty</span>");
		return false;
	}
	var formBtnId = 'cancel_confirm_btn';
	let url = $("#cancel_interview_btn").attr('data-url'); 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	var formData = new FormData();  
	formData.append("cancellation_reason",$("#cancellation_reason").val());
	loadingButton(formBtnId)
	$.ajax({
		url: url+"sds", 
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


function reject_prospect(){
	var formBtnId = 'confirm_btn';
	let url = $("#reject_prospect_btn").attr('data-url'); 
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


function reapply_prospect(){
	var formBtnId = 'confirm_btn';
	let url = $("#reapply_prospect_btn").attr('data-url'); 
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

function reject_prospect(){
	var formBtnId = 'confirm_btn';
	let url = $("#reject_prospect_btn").attr('data-url'); 
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


function archive_prospect(){
	var formBtnId = 'confirm_btn';
	let url = $("#archive_prospect_btn").attr('data-url'); 
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

$('#filter_status').on('change', function() {
	var table = $('#datatable').DataTable();
	console.log((table.column(7).data()));
	// oTable.fnFilter("^"+selectedValue+"$", 0, true); //Exact value, column, reg
	table.column(7).
	  search(this.value, true, false).
		draw();
  });

