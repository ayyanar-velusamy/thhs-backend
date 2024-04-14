function handleFail(response, opt) {  
    if (typeof response.errors != "undefined") {
        var keys = Object.keys(response.errors);
        
        $(opt.container).find(".has-error").find(".help-block").remove();
        $(opt.container).find(".has-error").removeClass("has-error");

        if (opt.errorPosition == "field") {
            for (var i = 0; i < keys.length; i++) {
                var temp = keys[i];
                // Escape dot that comes with error in array fields
                var key = temp.replace(".", '\\.');
                 
                var formarray = keys[i];
                // If the response has form array
                if(formarray.indexOf('.') >0){
                    var array = formarray.split('.');
                    response.errors[keys[i]] = response.errors[keys[i]];
                    if(array[0] == 'gradeId' || array[1] > 0){
                        key = array[0]+'['+ array[1] +']';
                    }else{
                        key = array[0]+'[]';
                    }
                }

                var ele = $(opt.container).find("[name='" + key + "']");
                
                // If cannot find by name, then find by id
                if (ele.length == 0) {
                    ele = $(opt.container).find("#" + key);
                }
                
                if (ele.length == 0) {
                    ele = $(opt.container).find("[name='" + key + "']");
                }
                
                
                var grp = ele.closest(".field-wrapper");
                $(grp).find(".help-block").remove();

                var helpBlockContainer = $(grp).find("div:first");
                if($(ele).is(':radio')){
                    helpBlockContainer = $(grp).find("div:eq(2)");
                }

                if (helpBlockContainer.length == 0) {
                    helpBlockContainer = $(grp);
                }
                if($('#'+keys[i]+'-error').length == 0){
                helpBlockContainer.append('<span id="'+ keys[i] +'-error" class="help-block error removeclass-valid">' + response.errors[keys[i]][0] + '</span>');
                }else{
                    $('#'+keys[i]+'-error').text(response.errors[keys[i]]).css('display','block');
                }
                $(grp).addClass("has-error");
            }

            if (keys.length > 0) {
                var element = $("[name='" + keys[0] + "']");
                if (element.length > 0) {
                    if(opt.container != '#duplicateJourneyForm')
                    $("html, body").animate({scrollTop: element.offset().top - 150}, 200);
                }
            }
        }
        else {
            var errorMsg = "<ul>";
            for (var i = 0; i < keys.length; i++) {
                errorMsg += "<li>" + response.errors[keys[i]] + "</li>";
            }
            errorMsg += "</ul>";

            var errorElement = $(opt.container).find("#alert");
            var html = '<div class="alert alert-danger">' + errorMsg +'</div>';
            if (errorElement.length == 0) {
                $(opt.container).find(".form-group:first")
                    .before('<div id="alert">' + html + "</div>");
            }
            else {
                errorElement.html(html);
            }
        }
    }
}

function loadingButton(selector) {
    var button = $(`#${selector}`);  
    var text = "Submitting...";  

    if (!button.is("input")) {
        button.attr("data-prev-text", button.html());
        button.text(text);
        button.prop("disabled", true);
    }
    else {
        button.attr("data-prev-text", button.val());
        button.val(text);
        button.prop("disabled", true);
    }
}

function unloadingButton(selector) {
    var button = $(`#${selector}`); 
    if (!button.is("input")) {
        button.html(button.attr("data-prev-text"));
        button.prop("disabled", false);
    }
    else {
        button.val(button.attr("data-prev-text"));
        button.prop("disabled", false);
    }
}
 