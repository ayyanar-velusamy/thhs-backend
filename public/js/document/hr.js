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
function openDocument(chart) { 
	$('.document_preview').show();
	
	$('#chart_id').val(chart.id)
	$('#document').attr('src', `${window.location.origin}/thhs-backend/${chart.document}`)
	// embed.setAttribute('src', embedUrl);

}

$(document).on('click', 'button', function (e) {
	if ($(this).attr("data-dismiss") == "modal") {
		$(".modal").modal("hide");
	}
})
 



