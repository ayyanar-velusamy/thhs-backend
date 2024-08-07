function showDeletedDocuments(checked) {
	console.log(checked);
	if(checked){
		let chart_id = $("#chart_id").val();
		let user_id = $("#hidden_user_id").val();
		
		let deleted_documents = get_deleted_documents(user_id,chart_id);
		console.log(deleted_documents);
		$(".deleted_files").html("");
		
		
		if( deleted_documents != ""){
			$.map(deleted_documents, function(val,i){
				$(".deleted_files").append('<tr><td onclick="recover_document('+val.id+')" class="text-start"><i class="icon icon-doc me-2"></i>'+get_file_name(val.document_path)+'</td></tr>');
			})
			toggleDeletedView();
		}
		
	}else{
		$(".deleted_files").html("");
		resetDeletedView();
	}
	
}

function toggleDeletedView(){
	// let checked = $("#show_deleted_documents").prop("checked")
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

function resetDeletedView(){
	$("#show_deleted_documents").prop("checked",false)
	let element = document.querySelector(".deleted-files-wrapper.d-none");
	let element1 = document.querySelector(".deleted-files-wrapper.d-flex");
	if(element1){
		element1.classList.add("d-none");
		element1.classList.remove("d-flex");
	}
	
}

function get_file_name(path){
	var ary = path.split("/");
  	return ary[ary.length - 1];
}


function recover_document(document_id){
	let url = PROJECT_URL+"/thhs/app/document/recover_deleted_document/"+document_id;
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		async: false,
		success: function(data){
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

function downloadFile(){
	var filePath = $("#document").attr("src");
	var filename= filePath.split('/').pop()

	$('#linkID').attr({target: '_blank', href : filePath, download: filename});
	$('#linkID')[0].click();
}
function get_deleted_documents(user_id,chart_id){
	let deleted_documents;
	let url = $("#show_deleted_documents").attr('data-url')+'?user_id='+user_id+'&chart_id='+chart_id; 
	let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	$.ajax({
		url: url, 
		type: "GET", 
		contentType: false,
		dataType:'json',
		processData: false,
		async: false,
		success: function(data){
			deleted_documents = data.data;
			// console.log(deleted_documents);
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
	return deleted_documents;
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
	$(".deleted_files").html("");
	// $("#show_deleted_documents").prop("checked",false);
	resetDeletedView();
	
	$(".tr_active").removeClass("tr_active");
	$(e.target).parent("tr").addClass("tr_active"); 
	$('.document_preview').show();
	
	$('#document').attr('src',"");
	$('#chart_id').val(chart.id)
	
	console.log('chart', chart); 
	
	sessionStorage.setItem("open_chart", chart.id)
	
	if(chart.document){
		$('#hidden_user_id').val(chart.document.user_id)
	
		$('#delete_document_btn').attr("data-id",chart.document.id);
		$('#document_text').text("");
		$('#document').attr('src', PROJECT_URL+`/${chart.document.document_path}`) 
		$('#delete_document_btn').attr("data-id",chart.document.id);
		
	}else if(chart.report && chart.report?.status != 0){ 
		$('#document_text').text(""); 
		$('#document').attr('src', `/thhs-backend/export?reportId=${chart.report.report_id}&userId=${chart.staff_id}`)   
	}else{
		$('#document_text').text("No Document");
	}
	

	// embed.setAttribute('src', embedUrl);

} 
 


function openEditDocumentDetail(id,issue_date,is_verified){
	// alert(is_verified);
	$("#hidden_id").val(id);
	$("#issue_date").val(issue_date);
	if(is_verified == 1)
	{
		$("#is_verified").attr("checked","checked")
	}
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




//Dynamsoft Script
var DWObject;
var deviceList = [];

window.onload = function() {
	if (Dynamsoft) {
		Dynamsoft.DWT.AutoLoad = false;
		Dynamsoft.DWT.UseLocalService = true;
		Dynamsoft.DWT.Containers = [{
			ContainerId: 'dwtcontrolContainer',
			Width: '640px',
			Height: '640px'
		}];
		Dynamsoft.DWT.RegisterEvent('OnWebTwainReady', Dynamsoft_OnReady);
		// https://www.dynamsoft.com/customer/license/trialLicense?product=dwt
		Dynamsoft.DWT.ProductKey =
			't01898AUAADVndWcV9XLSj7/TrvIYXEhpYYFrLxqx4/KI0MT6cSFqk4gb5BGyK4A25wgIDk0UFu+eL1EBI3RMW9wJ6ZxVFhW9fjnZwantnSrtnejg5COnyJiHsez2kOetE7gA7wzofhx2ADVQajkBH7fVBgugBagBqFUDLOB2FdefTzkHpP76z4auTnZwantnHZA2TnRw8pEzBcRHGaa02qkEBPXJOQC0AL0FsF1kl4DIGaAF6AUgvB8CZQYvECq6';
		Dynamsoft.DWT.ResourcesPath = 'https://unpkg.com/dwt/dist/';

		Dynamsoft.DWT.Load();
	}

};

function Dynamsoft_OnReady() {
	DWObject = Dynamsoft.DWT.GetWebTwain('dwtcontrolContainer');
	var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
	DWObject.SetHTTPFormField('csrf-token', token);

	let count = DWObject.SourceCount;
	// let select = document.getElementById("source");

	DWObject.GetDevicesAsync().then(function(devices) {
		console.log('deviceList', devices)
		for (var i = 0; i < devices.length; i++) { // Get how many sources are installed in the system
			let option = document.createElement('option');
			option.value = devices[i].displayName;
			option.text = devices[i].displayName;
			deviceList.push(devices[i]);
			// select.appendChild(option);
		   
			// select.options.add(new Option(devices[i].displayName, i)); // Add the sources in a drop-down list

			// twainsource.options.add(new Option(devices[i].displayName, i)); 
		}
	}).catch(function(exp) {
		alert(exp.message);
	});
}

function loadImage() {
	var OnSuccess = function() {};
	var OnFailure = function(errorCode, errorString) {};

	if (DWObject) {
		DWObject.IfShowFileDialog = true;
		DWObject.LoadImageEx("", Dynamsoft.DWT.EnumDWT_ImageType.IT_ALL, OnSuccess, OnFailure);
	}
}

function acquireImage() {
	if (DWObject) {
		// var sources = document.getElementById('source'); 
		if (deviceList.length > 0) {
			DWObject.SelectDeviceAsync(deviceList[0]).then(function() {
				return DWObject.AcquireImageAsync({
					IfShowUI: false,
					IfCloseSourceAfterAcquire: true
				});
			}).catch(function(exp) {
				alert(exp.message);
			});
		}
	}
}

function upload() {
	var OnSuccess = function(httpResponse) {
		alert("Succesfully uploaded");
	};

	var OnFailure = function(errorCode, errorString, httpResponse) {
		alert(httpResponse);
	};

	// var date = new Date();
	// DWObject.HTTPUploadThroughPostEx(
	// 	"{{ route('dwtupload_upload') }}",
	// 	DWObject.CurrentImageIndexInBuffer,
	// 	'',
	// 	date.getTime() + ".jpg",
	// 	1, // JPEG
	// 	OnSuccess, OnFailure
	// );
	DWObject.ConvertToBlob(
		[0],
		1,
        function(result, indices, type) {
			console.log('deviceList', result, indices, type)
            // var url = "https://YOUR-SITE:PORT/PATH/TO/SCRIPT.aspx";
            // var fileName = "SampleFile" + getExtension(type);
            // var formData = new FormData();
            // formData.append('RemoteFile', result, fileName);
            // makeRequest(url, formData, false);
        },
        function(errorCode, errorString) {
            console.log(errorString);
        }
    );
}

function source_onchange() {



	if (document.getElementById("source")) {
		var cIndex = document.getElementById("source").selectedIndex;
		if (!Dynamsoft.Lib.env.bWin) {
			if (document.getElementById("lblShowUI"))
				document.getElementById("lblShowUI").style.display = "none";
			if (document.getElementById("ShowUI"))
				document.getElementById("ShowUI").style.display = "none";
		} else {
			DWObject.SelectDeviceAsync(deviceList[cIndex]);

			var showUI = document.getElementById("ShowUI");
			if (showUI) {
				if (deviceList[cIndex] && deviceList[cIndex].displayName && deviceList[cIndex].displayName.indexOf(
						"WIA-") == 0) {
					showUI.disabled = true;
					showUI.checked = false;
				} else
					showUI.disabled = false;
			}
		}
	}
}
 