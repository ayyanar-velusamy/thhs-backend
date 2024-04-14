$(document).on('submit','form',function(e){
	var btn = $("#personal_info_submit");
	var btn_text = btn.text();
	if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
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



$( document ).ready(function() { 
	var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG', guideline: true});
	$('#clear').click(function(e) {
		e.preventDefault();
		sig.signature('clear');
		$("#signature64").val('');
	});
});