function toggleVisibility() {
	let element = document.querySelector(".deleted-files-wrapper.d-none");
	let element1 = document.querySelector(".deleted-files-wrapper.d-flex");
	if (element) {
		element.classList.add("d-flex");
		element.classList.remove("d-none");
	}
	if (element1) {
		element1.classList.add("d-none");
		element1.classList.remove("d-flex");
	}
}
function toggleAllAccordions() {
	var accordionHeaders = document.querySelectorAll(
		".accordion-header button"
	);
	var accordionCollapses = document.querySelectorAll(
		".accordion-collapse"
	);

	let text = document.getElementById("toggle-button");
	var isCollapsed = Array.from(accordionHeaders).some(function (header) {
		return !header.classList.contains("collapsed");
	});

	if (isCollapsed) {
		accordionHeaders.forEach(function (header) {
			header.classList.add("collapsed");
			text.innerHTML = "Expand";
		});
		accordionCollapses.forEach(function (collapse) {
			collapse.classList.remove("show");
		});
	} else {
		accordionHeaders.forEach(function (header) {
			header.classList.remove("collapsed");
			text.innerHTML = "Collapse";
		});
		accordionCollapses.forEach(function (collapse) {
			collapse.classList.add("show");
		});
	}
}
function openDocument(chart,e) {
	$(".tr_active").removeClass("tr_active");
	$(e.target).parent("tr").addClass("tr_active"); 
	$('.document_preview').show();
	console.log(chart.document);
	$('#document').attr('src',"");
	$('#chart_id').val(chart.id)
	console.log(chart.document); 
	
	sessionStorage.setItem("open_chart", chart.id)
	
	if(chart.document){
		$('#document_text').text("");
		$('#document').attr('src', PROJECT_URL+`/${chart.document.document_path}`)
		$('#delete_document_btn').attr("data-id",chart.document.id);
		
	}else{
		$('#document_text').text("No Document");
	}
	

	// embed.setAttribute('src', embedUrl);

}


function openEditDocumentDetail(id){
	
	$("#hidden_id").val(id);
	$("#editDocumentDetail").modal("show");
}

$(document).on('click', 'button', function (e) {
	if ($(this).attr("data-dismiss") == "modal") {
		$(".modal").modal("hide");
	}
})

$( document ).ready(function() {
    console.log( "ready!" );
	let open_chart_id = sessionStorage.getItem("open_chart");
	$(`#open_chart_${open_chart_id}`).trigger("click");
});
 



