var sig;
$(document).on('submit', 'form', function (e) {
	var btn = $("#personal_info_submit");
	var btn_text = btn.text();
	if ($(this).hasClass('ajax-form')) {
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#' + $(this).attr('id') == '#undefined') ? 'body' : '#' + $(this).attr('id');
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
			dataType: 'json',
			processData: false,
			success: function (data) {

				if (data.status) {
					toastr.success(data.message)
					if (data.redirect_url != "") {
						location.href = data.redirect_url;
					} else {
						location.reload();
					}
				} else {
					toastr.error(data.message)
					location.reload();
				}

			}
		});
	}
});

$(document).ready(function () {
	sig = $('#sig').signature({ syncField: '#signature64', syncFormat: 'PNG', guideline: true });
	$('#clear').click(function (e) {
		e.preventDefault();
		sig.signature('clear');
		$("#signature64").val('');
	});

	toggle_sign($("input[name='signature_type']:checked").val());

	$(".typed").on("click", function() {
		$(".typed").removeClass("active");
		$(this).addClass("active");
	});
  

});


function clear_draw_sign(value) {
	// var sig = $('#sig').signature({ syncField: '#signature64', syncFormat: 'PNG', guideline: true });
	sig.signature('clear');
}


function toggle_sign(value) {  
	if (value == "1") {
		$(".type_sign").show();
		$(".draw_sign").hide();
		$(".upload_sign").hide(); 
		type_signature()
	} else if (value == "2") { 
		$(".type_sign").hide();
		$(".draw_sign").show();
		$(".upload_sign").hide();
		clear_draw_sign()
	} else {
		$(".type_sign").hide();
		$(".draw_sign").hide();
		$(".upload_sign").show();
	}
	$("#signature64").val('');
	$("#customFile").val('');
	
}

function type_signature() {
	$(".typed").text($("#type_sign").val());
}


function text_to_image(id) { 
	// var imageElem = document.getElementById('image');
	html2canvas(document.getElementById(id), {
		allowTaint: true,
		useCORS: true,
	  })
	  .then(function (canvas) {
		// It will return a canvas element
		let image = canvas.toDataURL("image/png", 0.5); 
		// imageElem.src = image;
		console.log(image)
		$("#signature64").val(image)
	  })
	  .catch((e) => {
		// Handle errors
		console.log(e);
	  }); 
}


function previewFile(name, target) {
	const preview = document.getElementById('image'); 
	const file = document.querySelector(`input[name=${name}]`).files[0];
	const reader = new FileReader();
  
	reader.addEventListener(
	  "load",
	  () => {
		// convert image file to base64 string
		// preview.src = reader.result;
		$(`#${target}`).val(reader.result)
	  },
	  false,
	);
  
	if (file) {
	  reader.readAsDataURL(file);
	}
  }