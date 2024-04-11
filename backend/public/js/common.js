$(function () {
  $("#dob , #submit_date")
    .datepicker({
    format: "mm/dd/yyyy",
      autoclose: true,
      todayHighlight: true,
      onSelect: function(value, date) {
      date.dpDiv.find('.ui-datepicker-current-day a')
          .css('background-color', 'green');
      }
    })
    .datepicker("update", new Date());
   
    
});

$(function () {
  $("#datepicker , #start_date , #end_date")
    .datepicker({
    format: "mm/dd/yyyy",
      autoclose: true,
      todayHighlight: true,
      onSelect: function(value, date) {
      date.dpDiv.find('.ui-datepicker-current-day a')
          .css('background-color', 'green');
      }
    })
    .datepicker("update", new Date());

   
    $("#no_textarea,.influenza_reason, .hepatitis_reason").hide();
});

function change_no_textarea(status){
  if(status){
      $("#no_textarea").show();
  }else{
      $("#no_textarea").hide();
  }
}
function change_no_textarea(status){
  if(status){
      $("#no_textarea").show();
  }else{
      $("#no_textarea").hide();
  }
}

function toggle_influeza(value){
  if(value == "yes"){
      $(".influenza_date").show();
      $(".influenza_reason").hide();
  }else{
      $(".influenza_date").hide();
      $(".influenza_reason").show();
  }
}
function toggle_hepatitis(value){
  if(value == "yes"){
      $(".hepatitis_date").show();
      $(".hepatitis_reason").hide();
  }else{
      $(".hepatitis_date").hide();
      $(".hepatitis_reason").show();
  }
}

// new DataTable('#datatable');
$('#datatable').dataTable( {
  "lengthChange": false
});