/* Email Validation */
// $.validator.addMethod("validmail",function(value,element){
// 	return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
// }, "Enter a valid Email ID" ); 

/* Password Validation */
$.validator.addMethod("newpassword", function isPassword(newpassword) {
	var passwordExp = (/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/);
	return passwordExp.test(newpassword);
}, "Passwords must contain at least 8 characters, including uppercase, lowercase letters,special characters and numbers");

/* Re-enter New Password */
$.validator.addMethod("confirmpassword", function (value, element) { 
	var confirmPassword = $('#password').val();
	var reConfirmPassword = $('#password-confirm').val(); /* console.log(confirmPassword) console.log(reConfirmPassword)*/ 
	if ($("#password").val() == reConfirmPassword) { return true; } 
}, "Passwords mismatch. Retry");

 //Letters only
 jQuery.validator.addMethod("lettersonly",function(value,element){ return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); });
 
 
jQuery.validator.addMethod("lettersSpaceonly",function(value,element, options){
	if(options[0] == 4 ){
		return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
	}else{
		return true;
	}
});

// phonenumbers Only 
$.validator.addMethod("phonenumber", function (value, element) { return this.optional(element) || /^[0-9$&+,:;=?@#|'<>.^*()%!-\s]+$/.test(value); });

// Space Not Allowed /
jQuery.validator.addMethod("noSpace", function(value, element) { return value.indexOf(" ") < 1 && value != " "; }, "Space are not allowed");

// alphanumeric /
jQuery.validator.addMethod("alphanumeric", function(value, element, options) {
if(options[0] == 4 || options[0] == 3){
	return true;
}else{
	return this.optional(element) || /^[A-Za-z0-9? ]+$/.test(value);
}
}, "Letters, and numbers only please");

// numeric /
jQuery.validator.addMethod("numeric", function(value, element) {return this.optional(element) || /^[0-9?]+$/.test(value); }, "Letters, and numbers only please");

// Not allowed more than one space
jQuery.validator.addMethod("morespace", function isName(morespace) { var space = (/[ ]{2,}/); if(space.test(morespace) == false) return true; });

//End date should not be less than the start date
jQuery.validator.addMethod("greaterThan", function(value, element, params) {if (!/Invalid|NaN/.test(new Date(value))) {return new Date(value) >= new Date($(params).val());}
return isNaN(value) && isNaN($(params).val())|| (Number(value) >= Number($(params).val()));},'Must be greater than {0}.');


$(document).on('click','#signin_submit, #forget_submit' ,function(){  
    alert()
	jQuery("#signin-form, #forget_form").validate({
		rules: {
			username:{
				required: true,
				maxlength: 64,
				noSpace:true,
			},
			password:{
				required: true,
			},
		},
		messages: {
			email:{
				required:"Username cannot be empty",
				
				
			},
			password:{
				required:"Password cannot be empty",
			},	

		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				error.insertAfter(element);
			}
		}
	});
});

$(document).on('click','#reset_submit, #set_submit' ,function(){  
	jQuery("#reset_form, #set_form").validate({
		rules: {
			password:{
				required: true,
				minlength:8,
				maxlength:16,
				newpassword:true,
				
			},
			password_confirmation: {
				required: true,
				confirmpassword:true,
				minlength:8,
				maxlength:16,
			},
		},
		messages: {
			password:{
				required:"Password cannot be empty",
				minlength:"Password cannot be less than 8 characters",
				maxlength:"Password cannot exceed 16 characters",
				newpassword:"Password must contain at least 1 digit, 1 lowercase letter,1 uppercase letter and 1 special character",
			
			},	
			password_confirmation:{
				required:"Confirm Password cannot be empty",
				confirmpassword:"Password mismatch! Retry",
			},
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				error.insertAfter(element);
			}
		}
	});
});
 

 
 
$(document).on("focusout", "form .form-control, form .input_effect", function() {
  $(this).val(
    $(this)
      .val()
      .trim()
      .replace(/ +/g, " ")
  );
}); 



$(document).ready(function () {
		$("input[type=email], input[type='tel'], .removeSpace").on({
			keydown: function (e) {
				if (e.which === 32)
					return false;
			},
			change: function () {
				this.value = this.value.replace(/\s/g, "");
			}
		});
	});

	$("input[type='tel']").keypress(function(e){
	 var keyCode = e.which;

	 if ( !( (keyCode >= 48 && keyCode <= 57) 
	   ||(keyCode >= 65 && keyCode <= 90) 
	   || (keyCode >= 97 && keyCode <= 122) ) 
	   && keyCode != 8 && keyCode != 32) {
	   e.preventDefault();
	 }
	});



$(document).on('click','#userAddFormSubmit, #userEditFormSubmit' ,function(){ 
	jQuery("#userAddForm, #userEditForm").validate({
		rules: {
			first_name: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true
			},
			
			last_name: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true,
			},
			email: {
				required: true,
				maxlength: 64,
				validmail:true,
				noSpace:true,
			},
			mobile: {
				required: true,
				phonenumber:true,
				minlength:7,
				maxlength: 13,
				noSpace:true,
			},

			'roles[]' :{
				required: true,
			},
		},

		messages: {
			first_name: {
				required:"First Name cannot be empty",
				maxlength:"First Name cannot exceed 40 characters",
				lettersonly:"First Name should contain only alphabets", 
			},
			
			last_name: {
				required:"Last Name cannot be empty",
				maxlength:"Last Name cannot exceed 40 characters",
				lettersonly:"Last Name should contain only alphabets", 
			},	
			
			email: {
				required:"Email ID cannot be empty",
				maxlength:"Email address cannot exceed 64 characters",
				validmail:"Enter a valid Email ID", 
				noSpace:"Space are not allowed",
			},
			
			mobile: {
				required:"Phone Number cannot be empty",
				phonenumber:"Phone Number should contain only Numeric",  
				minlength:"Phone Number cannot be less than 7 digits",
				maxlength:"Phone Number cannot exceed 13 digits",

			},

			'roles[]' :{
				required:"Please choose a Role",
			},

		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element);
				}
			}
		}
	});
});

$(document).on('click','#pageAddFormSubmit, #pageEditFormSubmit' ,function(){ 
	jQuery("#pageAddForm, #pageEditForm").validate({
		rules: {
			title: { required: true, },
			menu_en: { required: true, },
			menu_es: { required: true, },
			menu_ar: { required: true, },
			meta_description: { required: true },
			meta_keyword: { required: true },
			parent_menu: { required: true },
			content_en: { required: true }, 
			content_es: { required: true }, 
			content_ar: { required: true }, 
		}, 
		messages: {
			title: {
				required:"Page Title cannot be empty", 
			},
			menu_en: {
				required:"Menu cannot be empty", 
			},
			menu_es: {
				required:"Menu cannot be empty", 
			},
			menu_ar: {
				required:"Menu cannot be empty", 
			},
			meta_description: {
				required:"Meta Description cannot be empty", 
			},
			meta_keyword: {
				required:"Meta Keyword cannot be empty", 
			},
			parent_menu: {
				required:"Please select parent menu", 
			},
			content_en: {
				required:"content cannot be empty",  
			},
			content_es: {
				required:"content cannot be empty", 
			},
			content_ar: {
				required:"content cannot be empty", 
			}			
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element);
				}
			}  
		}
	});
});

$(document).on('click','#sliderAddFormSubmit, #sliderEditFormSubmit' ,function(){ 
	jQuery("#sliderAddForm, #sliderEditForm").validate({
		rules: {
			name: {
				required: true,
				minlength:1, 
			}
		},

		messages: {
			name: {
				required:"Slider Name cannot be empty", 
			}
			 		
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element);
				}
			}  
		}
	});
});

// $('form#userAddForm').on('submit', function(event) {
	// $('select.select_level').each(function() {
			// $(this).rules("add", 
			// {
				// required: true,
				// messages: {
					// required:"Please choose Grade", 
				// },
			// });
	// });
// })

// $('form#userEditForm').on('submit', function(event) {
	// $('select.select_level').each(function() {
			// $(this).rules("add", 
			// {
				// required: true,
				// messages: {
					// required:"Please choose Grade", 
				// },
			// });
	// });
// })


$('button[type="reset"], input[type="reset"]').click(function() {
  $("span.error, div.error, .org-error").hide();
  $(".form-control").removeClass('error');
  $('.checkbox_label input.full_access').removeAttr('checked');
  $('.import_file #bulkimphrcsv, .import_file #bulkimphrzip').val(''); 
  //$(".error").removeClass("error");
});


//validate file extension custom  method.
jQuery.validator.addMethod("allextension", function (value, element, param) {
param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
});



$('#hrBulk').validate({
	rules: {
		bulkimphrcsv: {
			required:true,
			allextension: "csv"
		},
		bulkimphrzip: {
			allextension: "zip"
		},		

	},
	messages: {
		bulkimphrcsv: {
			required:"Please upload a file",
			allextension:"Invalid file format"
		},
		bulkimphrzip: {
			allextension:"Invalid file format"
		},
	},
	errorElement: "div",
	errorPlacement: function(error, element) {
		  var placement = $(element).data('error');
		  if (placement) {
			$(placement).append(error)
		  } else {
			error.insertAfter(element);
			$("#hrBulk #bulkimphrcsv-error").insertAfter("#bulkimphr .hrcsv label");
		  }
		}
});



/*User Roles*/
$(document).on('click','#rolesAddFormSubmit, #rolesEditFormSubmit' ,function(){ 
	jQuery("#rolesAddForm, #rolesEditForm").validate({
		rules: {
			name: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true
			},
			
			'permissions[]':{
				required: true,
			},
		},
		messages: {
			name: {
				required:"Role Name cannot be empty",
				maxlength:"Role Name cannot exceed 40 characters",
				lettersonly:"Role Name should contain only alphabets", 
			},
			'permissions[]':{
				required:"Please choose a permission ",
			},
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.parent().hasClass('toggle_check_label') && element.next('.togele_btn').length) {
					error.insertBefore(".permission_panel .inner-content .panel-default");
				}else{
					error.insertAfter(element);
				}
			}
		},
		
		"invalidHandler": function(form, validator) {
			if (!validator.numberOfInvalids())
				  return;
				jQuery('html, body').animate({
				  scrollTop: jQuery(validator.errorList[0].element).offset().top-400
			}, 1000);
		}
	});
});

$("#journeyAddForm, #journeyUpdateForm").validate({
	rules: {
		journey_name: {
			required: true,
			minlength:1,
			maxlength: 64,
			alphanumeric:true,
		},
		journey_type_id: {
			required: true,
		},
		visibility: {
			required: true,
		},
		read: {
			required: true, 
		},
		journey_description: {
			required: true,
			minlength:8,
			maxlength:1024,
		},
	
	},

	messages: {
		journey_name: {
			required:"Journey Name cannot be empty",
			maxlength:"Journey Name cannot exceed more than 64 characters",
			alphanumeric:"Journey Name should contain only Alphabets and Numerics", 
		},
		
		journey_type_id: {
			required:"Journey Type cannot be empty",
		},	
		visibility: {
			required:"Visibility cannot be empty",
		},
		read: {
			required:"Compulsory or Optional cannot be empty",
		},
		journey_description: {
			required:"Description cannot be empty",
			minlength:"Description cannot be less than 8 characters",
			maxlength:"Description cannot be more than 1024 characters",
		},

	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element);
			}
		}
	}
});

$(document).on('change','#content_type_id',function(){
	$this= $(this);
	//alert($this.val()); 
	
	$("#milestoneModalForm").validate({ 
		rules: {
			url: {
				required: function(element) {if ($this.val() == 4) {return false;}else{ return true;}},
				minlength:4,
				maxlength:2048,
				url:true,
				noSpace:function(element){if ($this.val() == 4) {return false;}else{ return true;}},
			},
			title: {
				required: true,
				minlength:4,
				maxlength: 64,
				alphanumeric:true,
			},
			provider: {
				required: true,
				minlength:function(element) {var length = "4"; if ($this.val() == 4 && $this.val() == 3) {length = "1"; }; return length;},
				maxlength:function(element) {var length = "64"; if ($this.val() == 4) {length = "40"; }; return length;},
				alphanumeric:function(element) { return [$this.val()] },
				lettersSpaceonly:function(element) {return [$this.val()]},
				
			},
			description: {
				required: false,
				maxlength:1024,
			},
			end_date: {
				required: true,
				greaterThan: '#start_date'
			},
			payment_type: {
				required:true,
			},
			difficulty: {
				required:true,
			},
			visibility: {
				required:true,
			},
			price: {
				required:true,
				maxlength: 7,
				number: true,
				min:1,
			},
			approver_id: {
				required:true,
			},
			length: {
				required: false,
				maxlength: 5,
				numeric:true,
				//noSpace:true,
			},
			
			notes: {
				maxlength: 40,
				alphanumeric:true,
			},
			/* "tags[]": {
				maxlength: 64, 
				lettersonly:true,	
			} */
		},

		messages: {
			url: {
				required:"URL cannot be empty.",
				url:"Enter a Valid URL", 
				noSpace:"URL cannot contain space",
			},
			title: {
				required:"Title cannot be empty",
				minlength:"Title cannot be less than 4 characters",
				maxlength:"Title cannot be more than 64 characters",
				alphanumeric:"Title should contain only Alphabets and Numerics", 
			},	
			provider: {
				required:function(element) {var message = "Provider cannot be empty"; if ($this.val() == 4) {message = "Author cannot be empty"; }else if($this.val() == 3){message = "Episode Name cannot be empty";}; return message;},
				minlength:function(element) {var message = "Provider cannot be less than 4 characters"; if ($this.val() == 4) {message = "Author cannot be less than 1 characters"; }else if($this.val() == 3){message = "Episode Name be less than 1 characters";}; return message;},
				maxlength:function(element) {var message = "Provider cannot be more than 64 characters"; if ($this.val() == 4) {message = "Author cannot be more than 40 characters"; }else if($this.val() == 3){message = "Episode Name cannot be more than 64 characters";}; return message;},
				alphanumeric:"Provider should contain only Alphabets and Numerics" , 
				lettersSpaceonly:"Author should contain only alphabets and spaces",
			},
			description: {
				maxlength:"Description cannot be more than 1024 characters",
			},
			notes: {
				maxlength:"Notes cannot be more than 40 characters.",
				alphanumeric: "Notes should contain only Alphabets and Numerics"
			},
			end_date: {
				required:"Targeted Completion Date cannot be empty",
				greaterThan: "Target date should not be less than the start date"
			},
			payment_type: {
				required:"Paid or Free cannot be empty",
			},
			difficulty: {
				required:"Difficulty cannot be empty",
			},
			visibility: {
				required:"Visibility cannot be empty",
			},
			price: {
				required:"Price cannot be empty",
				maxlength: "Price cannot be more than 7 characters",
				number:"Price should only consist of Numerics",
				min: "Price cannot be zero",
			},
			approver_id: {
				required:"Approver cannot be empty",
			},
			length: {
				maxlength: "Length cannot exceed more than 5 characters",
				numeric: "Length should contain only numeric's",
				//noSpace: "Length cannot contain space."
			},
			/* "tags[]": {
				maxlength: "Tags cannot be more than 64 characters",
				lettersonly: "fsd",
			} */

		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element); 
				}
			}
		}
	});
});

$("#milestoneEditNotesForm").validate({
	rules: {
		notes: {
			maxlength: 40,
			alphanumeric:true, 
		},
	},
	messages: {
		notes: {
			maxlength:"Notes cannot be more than 40 characters.",
			alphanumeric: "Notes should contain only Alphabets and Numerics"
		},

	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		}else{
				error.insertAfter(element);
		}
	}
});



$("#approval-form").validate({
	rules: {
		comment: {
			required: true,
			minlength:1,
			maxlength:40,
		},
	},

	messages: {
		comment: {
			required:"Comments cannot be empty",
			minlength:"Comments cannot be less than 1 characters",
			maxlength:"Comments cannot exceed more than 40 characters",
		},

	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		}else{
				error.insertAfter(element);
		}
	}
});

$("#ratingForm").validate({
	ignore: "",
	rules: {
		rating: {
			required: true,
		},
	},
	messages: {
		rating: {
			required:"Ratings cannot be empty",
		},

	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		}else {
			if(element.hasClass('ratings') && element.next('.rating_star').length) {
				error.insertAfter(element.next('.rating_star'));
			}else{
				error.insertAfter(element);
			}
		}
	}
});

/*PLJ Duplicate Jouerny Form*/

$("#duplicateJourneyForm").validate({
	ignore: "",
	rules: {
		journey_name: {
			required: true,
			minlength:1,
			maxlength: 64,
			alphanumeric:true,
		},
	},
	messages: {
		journey_name: {
			required:"Learning Journey Name cannot be empty",
			maxlength:"Learning Journey Name cannot exceed more than 64 characters",
			alphanumeric:"Learning Journey Name should contain only Alphabets and Numerics", 
		},
	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		}else{
				error.insertAfter(element);
		}
	}
});

/*Group Shared Board Forms*/

$("#groupPostAddForm").validate({
	rules: {
		journey_id: {
			required: true,
		},
		content: {
			required:true,
			maxlength: 1024,
		},
	},
	messages: {
		journey_id: {
			required:"Please select a Journey",
		},
		content: {
			required: "Post cannot be empty",
			maxlength:"Post cannot exceed more than 1024 characters",
		},
	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element); 
			}
		}
	}
});
$(document).on('click','.sharedBoard_textarea button.replyBtn', function() {
	$(this).parents(".groupCommentAddForm").validate({ 
		rules: {
			comment: {
				required:true,
				maxlength: 1024,
			},
		},
		messages: {
			comment: {
				required: "Comment cannot be empty", 
				maxlength:"Comment cannot exceed more than 1024 characters", 
			},
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			}else{
					error.insertAfter(element);
			}
		}
	});
});
/* Group Add/Edit  Form */

$("#groupAddForm, #groupEditForm").validate({
	rules: {
		group_name: {
			required: true,
			maxlength: 64,
			alphanumeric:true,
			
		},
		visibility: {
			required: true,
		},
		group_description: {
			required: true,
			minlength: 8,
			maxlength: 1024,
		},
	},
	messages: {
		group_name: {
			required:"Group Name cannot be empty",
			maxlength:"Group Name cannot exceed more than 64 characters",
			alphanumeric:"Group Name can contain only Alphabets and Numerics", 
		},
		visibility: {
			required:"Visibility cannot be empty",
		},
		group_description: {
			required:"Group Description cannot be empty",
			minlength:"Group Description cannot be less than 8 characters",
			maxlength:"Group Description cannot exceed more than 1024 characters",
		},
	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element); 
			}
		}
	} 
});

/*Assign New Admin*/
$("#assignAdminModalForm").validate({
	rules: {
		user_id:{
			required: true,
		},
	},
	messages: {
		user_id:{
			required:"Please select a User",
		},	

	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element); 
			}
		}
	}
});

 $("#assign_btn").click(function(){
    $("[id^=inputDateName]").each(function(){
        $(this).rules("add", {
            required: true,
			//greaterThan: "#start_date",
            messages: {
               required:"Targeted Completion Date cannot be empty",
			 //  greaterThan: "Target date should not be less than the start date"
            }
        } );            
    });
	$("[id^=inputMilestoneVisibility]").each(function(){
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Visibility of the milestone cannot be empty"
            }
        } );            
    });
	$("[id^=inputMilestoneCompulOpt]").each(function(){
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Please choose an option"
            }
        } );            
    });
	$("[id^=inputApprover]").each(function(){
        $(this).rules("add", {
            required: true,
            messages: {
                required:"Approver cannot be empty",
            }
        } );            
    });
	
	$("[id^=inputPrice]").each(function(){
        $(this).rules("add", {
            required: true,
			maxlength:7,
			number:true,
			min:1,
            messages: {
                required:"Price cannot be empty",
				maxlength: "Price cannot be more than 7 characters",
				number:"Price should only consist of Numerics",
				min: "Price cannot be zero",
            }
        } );            
    });
 });
 
 

$("#journeyAssignForm").validate({
	
	rules: {
		j_visibility: {
			required: true,
		},
		j_read: {
			required: true,
		},
	},

	messages: {
		j_visibility: {
			required:"Visibility of the Journey cannot be empty",
		},
		j_read: {
			required:"Please choose an option",
		},
	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element); 
			}
		}
	}
});

/*Passport User profile edit*/

$(document).on('click','#userEditFormSubmit' ,function(){ 
	jQuery("#userProfileEditForm").validate({
		rules: {
			first_name: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true
			},
			
			last_name: {
				required: true,
				minlength:1,
				maxlength: 40,
				lettersonly:true,
			},
			email: {
				required: true,
				maxlength: 64,
				validmail:true,
				noSpace:true,
			},
			mobile: {
				required: true,
				phonenumber:true,
				minlength:7,
				maxlength: 13,
				noSpace:true,
			},
			designation: {
				maxlength: 64,
			},
		},

		messages: {
			first_name: {
				required:"First Name cannot be empty",
				maxlength:"First Name cannot exceed 40 characters",
				lettersonly:"First Name should contain only alphabets", 
			},
			last_name: {
				required:"Last Name cannot be empty",
				maxlength:"Last Name cannot exceed 40 characters",
				lettersonly:"Last Name should contain only alphabets", 
			},	
			email: {
				required:"Email ID cannot be empty",
				maxlength:"Email address cannot exceed 64 characters",
				validmail:"Enter a valid Email ID", 
				noSpace:"Space are not allowed",
			},
			mobile: {
				required:"Phone Number cannot be empty",
				phonenumber:"Phone Number should contain only Numeric",  
				minlength:"Phone Number cannot be less than 7 digits",
				maxlength:"Phone Number cannot exceed 13 digits",

			},
			designation: {
				maxlength: "Designation cannot exceed more than 64 characters", 
			},
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element);
				}
			}
		}
	});
}); 


$(document).on('click','#submitChangePassword' ,function(){  
	jQuery("#changePasswordModalForm").validate({
		rules: {
			current_password:{
				required: true,
			},
			password:{
				required: true,
				minlength:8,
				maxlength:16,
				newpassword:true,
			},
			password_confirmation: {
				required: true,
				confirmpassword:true,
				minlength:8,
				maxlength:16,
			},
		},
		messages: {
			current_password:{
				required: "Current Password cannot be empty",
			},
			password:{
				required:"Password cannot be empty",
				minlength:"Password cannot be less than 8 characters",
				maxlength:"Password cannot exceed 16 characters",
				newpassword:"Password must contain at least 1 digit, 1 lowercase letter,1 uppercase letter and 1 special character",
			
			},	
			password_confirmation:{
				required:"Confirm Password cannot be empty",
				confirmpassword:"Password mismatch! Retry",
			},
		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
            var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				error.insertAfter(element);
			}
		}
	});
});
 
 
 $("#backfillMilestoneModalForm").validate({ 
	rules: {
		title: {
			required: true,
			maxlength: 64,
			alphanumeric:true,
		},
		description: {
			required: false,
			minlength:8,
			maxlength:1024,
		},
		end_date: {
			required: true,
			greaterThan: '#start_date'
		},
		difficulty: {
			required:true,
		},
	},

	messages: {
		title: {
			required:"Milestone Name cannot be empty",
			maxlength:"Milestone Name cannot be more than 64 characters",
			alphanumeric:"Milestone Name should contain only Alphabets and Numerics", 
		},	
		description: {
			minlength:"Description cannot be less than 8 characters",
			maxlength:"Description cannot be more than 1024 characters",
		},
		end_date: {
			required:"Targeted Completion Date cannot be empty",
			greaterThan: "Target date should not be less than the start date"
		},
		difficulty: {
			required:"Difficulty cannot be empty",
		},
	},
	errorElement: "span",
	errorPlacement: function(error, element) {
		$('span.removeclass-valid').remove();
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		 } else {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
				error.insertAfter(element.next('.select2-container'));
			}else{
				error.insertAfter(element); 
			}
		}
	}
});