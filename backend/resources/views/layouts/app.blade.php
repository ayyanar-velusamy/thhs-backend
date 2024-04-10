<!DOCTYPE html>
<html lang="en">
  <head>
   <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/staff_manager.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/personal_info.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/global.css') }}" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
  <script
      src="https://code.jquery.com/jquery-3.6.1.min.js"
      integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
      crossorigin="anonymous"
    ></script>
	
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  
  <script>
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
      </script>
<!--demographics-->
<script>
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
    </script>
      <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <main>
      <div class="container-fluid">
        <!-- Sidebar -->
        <div class="sidebar-column">
          <nav id="sidebarMenu" class="collapse d-block sidebar collapse">
            <div class="sidebar-list">
              <a href="#" class="" aria-current="true">
                <i class="icon icon-logo"></i><span></span>
              </a>
			  <a href="#" class="active" aria-current="true">
                <i class="icon icon-prospects-logo"></i>
                <p>Prospect Manager</p>
              </a>
              <a href="../staff_manager/staff_manager.html" class="" aria-current="true">
                <i class="icon icon-staffs-logo"></i>
                <p>Staff Manager</p>
              </a>
              
            </div>
          </nav>
        </div>

        <!-- Dashboard layout -->
        <div class="main-layout" style="background-color: #e5edf9">
          <section class="dashboard-header-wrapper">
            <div class="d-flex justify-content-end">
              <div></div>
              <div class="dashboard-header-section">
                <input type="text" placeholder="Search" />
                <a href="javascript:;"><i class="icon icon-search"></i></a>
              </div>
              <div
                class="dashboard-header-activity-wrapper d-flex justify-content-center align-items-center"
              >
                <i class="icon icon-bell with-red"></i>
                <i class="icon icon-message"></i>
                <div
                  class="header-profile-wrapper d-flex justify-content-between align-items-center"
                >
                  <img src="{{ asset('images/user.png')}}" />
                  <p
                    class="dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    George Rekblatt
                    <i class="icon icon-arrow-down"></i>
                  </p>
                  <ul class="dropdown-menu">
                    <li><p class="dropdown-item" href="#">View profile</p></li>
                    <li>
                      <p class="dropdown-item" href="#">Logout</p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
          <section class="dashboard-heading-section">
            <div
              class="d-block d-lg-flex justify-content-between align-items-center"
            >
              <div class="content">
                <h1>Welcome to Trend Home Health Services Team</h1>
                <p>We've Custom Healthcare HR Software Services</p>
              </div>
              <div class="dashboard-tabs-wrapper d-flex justify-content-end">
                <div class="dashboard-tabs">
                  <i class="icon icon-teams"></i>
                  <p class="mt-1">HR management</p>
                </div>
                <div class="dashboard-tabs green">
                  <i class="icon icon-settings"></i>

                  <p class="mt-1">System application</p>
                </div>
                <div class="dashboard-tabs yellow">
                  <i class="icon icon-file-logo"></i>
                  <p class="mt-1">EHR</p>
                </div>
                <div class="dashboard-tabs purple">
                  <i class="icon icon-settings-rotate"></i>
                  <p class="mt-1">Settings</p>
                </div>
              </div>
            </div>
          </section>
        @yield('content')
        </div>
      </div>
	  
	   <!-- Modal -->
      
	  
    </main>
    <!--Main layout-->
  </body>
  <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script> 
  <script src="{{ asset('js/validation.js') }}"></script>

  
</html>
