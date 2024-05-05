$(function () {
  $("#ssn").inputmask({"mask": "999-99-9999"});
  $(".phone").inputmask({"mask": "(999)-999-9999"});

  $("#dob , #submit_date, #termination_date")
    .datepicker({
    format: "mm/dd/yyyy",
      autoclose: true,
      todayHighlight: true,
      onSelect: function(value, date) {
      date.dpDiv.find('.ui-datepicker-current-day a')
          .css('background-color', 'green');
      },
      beforeShow: function() {
        setTimeout(function(){
            $('.datepicker').css('z-index', 100);
        }, 0);
      }
    })
    .datepicker("update", new Date());
   
});

$(function () {
  $("#datepicker , #start_date , #influeza_vaccine_date, #hepatitis_vaccine_date, #date_completed")
    .datepicker({
      format: "mm/dd/yyyy",
      autoclose: true,
      todayHighlight: true,
      onSelect: function(value, date) {
      date.dpDiv.find('.ui-datepicker-current-day a')
          .css('background-color', 'green');
      }
    })

    $("#interview_date, #interview_date_div").datetimepicker({
      format: "m/d/Y H:i",
      autoclose: true,
      todayHighlight: true,
      onSelect: function(value, date) {
      date.dpDiv.find('.ui-datepicker-current-day a')
          .css('background-color', 'green');
      }
    })
    // .datepicker("update", new Date());

   
    if($("input[name='has_convicted_felony']:checked").val() == 1){
      $("#no_textarea").show();
      
    }else{
      $("#no_textarea").hide();
    }

    $(".influenza_reason").hide();
    $(".hepatitis_reason").hide();
    if($("input[name='had_influeza_vaccine']:checked").val() == 1){
      $(".influenza_reason").hide();
      $(".influenza_date").show();
    }else{
      $(".influenza_reason").show();
      $(".influenza_date").hide();
    }

    if($("input[name='had_hepatitis_vaccine']:checked").val() == 1){
      $(".hepatitis_reason").hide();
      $(".hepatitis_date").show();
    }else{
      $(".hepatitis_reason").show();
      $(".hepatitis_date").hide();
    }


    // $(".hepatitis_reason").hide();
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
  if(value == "1"){
      $(".influenza_date").show();
      $(".influenza_reason").hide();
  }else{
      $(".influenza_date").hide();
      $(".influenza_reason").show();
  }
}
function toggle_hepatitis(value){
  if(value == "1"){
      $(".hepatitis_date").show();
      $(".hepatitis_reason").hide();
  }else{
      $(".hepatitis_date").hide();
      $(".hepatitis_reason").show();
  }
}

function reload_page($url){
  if($url){
    setTimeout(function () {
      location.href = $url
    }, 3000);
  }else{
    setTimeout(function () {
      location.reload()
    }, 3000);
  }
  
}

// new DataTable('#datatable');
$('#datatable').dataTable( {
  "lengthChange": false,
  "order": [],
  "columnDefs": [ {
    "targets": 9,
    "bSort": false,
    "orderable": false
    } ],
    "columnDefs": [
      {"className": "dt-center", "targets": "_all"}
    ],
    autoWidth: false,
  initComplete: function () {
    this.api()
        .columns()
        .every(function () {
            let column = this;
        });
}
});


