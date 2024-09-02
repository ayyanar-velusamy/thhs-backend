<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jquery.datetimepicker.min.css') }}" />
    <link href="{{ asset('css/global.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap-datepicker.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link  rel="stylesheet" type="text/css" href="{{ asset('css/lib/toastr.css') }}"/>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
  />
    <link
      href="{{ asset('css/lib/dataTables.dataTables.css') }}"
      rel="stylesheet"
    />
    @php
      if(in_array("demographics",request()->segments())){
    @endphp
        <link href="{{ asset('css/personal_info.css') }}" rel="stylesheet" />
    @php
    }elseif(in_array("charts",request()->segments())){
    @endphp
        <link href="{{ asset('css/chart_manager.css') }}" rel="stylesheet" />
    @php
    }elseif(in_array("roles",request()->segments())){
    @endphp
        <link href="{{ asset('css/role_info.css') }}" rel="stylesheet" />
    @php
    }else{
    @endphp
        <link href="{{ asset('css/staff_manager.css') }}" rel="stylesheet" />
    @php
      }
    @endphp

    @php
    if(in_array("reports",request()->segments())){
    @endphp
    <link href="{{ asset('css/report.css') }}" rel="stylesheet" />
    @php
    }
    @endphp

    @php
    if(in_array("hr",request()->segments())){
    @endphp
     <script type="text/javascript" src="https://unpkg.com/dwt/dist/dynamsoft.webtwain.min.js"></script>
    @php
    }
    @endphp


    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
  crossorigin="anonymous"
></script>
    <!-- <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="{{ asset('js/lib/dataTables.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>

</head>

<body>

    <script src="{{ asset('js/lib/popper.min.js') }}"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/lib/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function showToast() {
            var toast = new bootstrap.Toast(document.getElementById("myToast"));
            toast.show();
        }

        function hideToast() {
            var toast = new bootstrap.Toast(document.getElementById("myToast"));
            toast.hide();
        }

        window.addEventListener("load", function() {
            showToast();
        });

        setTimeout(function() {
            var toastElement = document.getElementById("myToast");
            var toast = bootstrap.Toast.getInstance(toastElement);
            toast.hide();
        }, 3000);
        // {{base_path()}}
        let PROJECT_URL = "{{ Config::get('app.project_url') }}";
        let DYNAMSOFT_KEY = "{{ env('DYNAMSOFT_KEY') }}"
        console.log(PROJECT_URL);
    </script>

    <main>
        @php   
        $is_staff = false;
        $is_admin = false;
        if( Auth::user()->user_type === 1){    
           $is_staff = true;
        }
        if( Auth::user()->is_admin === 1){    
           $is_admin = true;
        }
        @endphp
        <div class="container-fluid">
            <!-- Sidebar -->
            <div class="sidebar-column">
                <nav id="sidebarMenu" class="collapse d-block sidebar collapse">
                    <div class="sidebar-list">
                        <a href="#" class="" aria-current="true">
                            <i class="icon icon-logo"></i><span></span> 
                        </a>
                        @php                      
                        if(request()->routeIs(['charts'])){                            
                        @endphp
                            <a href="{{ route('charts') }}" class="{{ request()->routeIs(['charts','charts.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-staffs-logo"></i>
                                <p>Chart Manager</p>
                            </a>
                        @php
                        }elseif(request()->routeIs(['roles']) || request()->routeIs(['users'])){     
                        @endphp
                            <a href="{{ route('roles') }}" class="{{ request()->routeIs(['roles','roles.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-prospects-logo"></i>
                                <p>User Roles</p>
                            </a>
                            <a href="{{ route('users') }}" class="{{ request()->routeIs(['users','users.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-staffs-logo"></i>
                                <p>User Manager</p>
                            </a>
                        @php 
                        }elseif(request()->routeIs(['reports'])){     
                        @endphp 
                            <a href="{{ route('reports') }}" class="{{ request()->routeIs(['reports','reports.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-sidebar-folder"></i>
                                <p>Reports</p>
                            </a>
                        @php 
                        }else{     
                        @endphp
                         
                            <a href="{{ route('staffs') }}" class="{{ request()->routeIs(['staffs','staffs.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-staffs-logo"></i>
                                <p>Staff Manager</p>
                            </a>  
                            <a href="{{ route('prospects') }}" class="{{ request()->routeIs(['prospects','prospects.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-prospects-logo"></i>
                                <p>Prospect Manager</p>
                            </a> 
                         </>
                        @php
                        }
                        @endphp
                         
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
                        <div class="dashboard-header-activity-wrapper d-flex justify-content-center align-items-center">
                            <i class="icon icon-bell with-red"></i>
                            <i class="icon icon-message"></i>
                            <div class="header-profile-wrapper d-flex justify-content-between align-items-center">
                                <img src="{{ asset('images/user.png') }}" />
                                <p class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    @php
                                        $current_user = Auth()->user()->name;
                                    @endphp
                                    {{ $current_user }}
                                    <i class="icon icon-arrow-down"></i>
                                </p>
                                <ul class="dropdown-menu">
                                    <!-- <li><p class="dropdown-item" href="#">View profile</p></li> -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="dashboard-heading-section">
                    <div class="d-block d-lg-flex justify-content-between align-items-center">
                        <div class="content">
                            <h1>Welcome to Trend Home Health Services Team</h1>
                            <p>We've Custom Healthcare HR Software Services</p>
                            @php
                              if(request()->routeIs(['staffs.*'])){
                            @endphp
                                <div class="top_ctas d-flex gap-4 mt-3">
                                    <a class="sub-menu" href="{{ @route('staffs.contact_information',  @request()->id) }}">
                                        <button class="defult-button {{ request()->routeIs('staffs.contact_information') ? 'active' : '' }}"">
                                    Contact Information
                                </button></a>
                                <a class="sub-menu" href="{{ @route('staffs.demographics', @request()->id) }}">
                                    <button class="defult-button {{ request()->routeIs('staffs.demographics') ? 'active' : '' }}">
                                    Demographics</button></a>
                                    <a class="sub-menu" href="{{ @route('staffs.hr', @request()->id) }}">
                                        <button class="defult-button {{ request()->routeIs('staffs.hr') ? 'active' : '' }}">
                                    HR</button></a>
                                    <div>{{ @$page_title}}<span class="phone_text">{{ @$user_phone }}</span></div>
                                </div>
                                
                            @php
                              }
                            @endphp  

                            @php
                              if(request()->routeIs(['prospects.*'])){
                            @endphp
                                <div class="top_ctas d-flex gap-4 mt-3">
                                    
                                <a class="sub-menu" href="{{ @route('prospects.demographics', @request()->id) }}">
                                    <button class="defult-button {{ request()->routeIs('prospects.demographics') ? 'active' : '' }}">
                                    Demographics</button></a>
                                    <a class="sub-menu" href="{{ @route('prospects.hr', @request()->id) }}">
                                        <button class="defult-button {{ request()->routeIs('prospects.hr') ? 'active' : '' }}">
                                    Package Items</button></a>
                                    <div>{{ @$page_title }}<span class="phone_text">{{ @$user_phone }}</span></div>
                                </div>
                            @php
                              }
                            @endphp 
                        </div>
                        
                        <div class="dashboard-tabs-wrapper d-flex justify-content-end">
                            <div class="dashboard-tabs {{ request()->routeIs(['prospects','prospects.*','staffs','staffs.*']) ? 'active' : '' }}">
                                
                                <a href="{{ route('prospects') }}" class="{{ request()->routeIs(['prospects','prospects.*','staffs','staffs.*']) ? 'active' : '' }}" aria-current="true">
                                    <i class="icon icon-teams"></i>
                                    <p class="mt-1">HR management</p>
                                </a>
                            </div>
                            <div  class="dashboard-tabs green {{ request()->routeIs(['charts','charts.*']) ? 'active' : '' }}">
                                <a href="{{ route('charts') }}" class="{{ request()->routeIs(['charts','charts.*']) ? 'active' : '' }}" aria-current="true">
                                <i class="icon icon-settings"></i> 
                                <p class="mt-1">Setup</p>
                                </a>
                            </div>
                            <div class="dashboard-tabs yellow {{ request()->routeIs(['reports','reports.*']) ? 'active' : '' }}">                              
                                <a href="{{ route('reports') }}" class="{{ request()->routeIs(['reports','reports.*']) ? 'active' : '' }}" aria-current="true">
                                    <i class="icon icon-file-logo"></i>
                                    <p class="mt-1">EHR</p>
                                </a>
                            </div>
                            <div class="dashboard-tabs purple {{ request()->routeIs(['roles','roles.*', 'users', 'users.*']) ? 'active' : '' }}">
                                <a href="{{ route('users') }}" class="{{ request()->routeIs(['roles','roles.*', 'users', 'users.*']) ? 'active' : '' }}" aria-current="true">
                                    <i class="icon icon-settings-rotate"></i>
                                    <p class="mt-1">Settings</p>
                                </a>
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
    <!-- Confirm dailog-->

    <div class="modal fade confirm_modal" id="ConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div>
                    <img src="{{ asset('images/confirm_popup.svg') }}" />
                </div>
                <div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            Confirm
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p id="modal_msg"></p>
                        <input type="hidden" id="function_name" value="">
                    </div>
                    <div class="cta_wrapper d-flex justify-content-center gap-5">
                        <button class="danger" data-dismiss="modal">Clear</button>
                        <button class="success" id="confirm_btn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </body>
  <script type="text/javascript" src="{{ asset('js/lib/jquery.datetimepicker.full.min.js') }}"></script>
  <script src="{{ asset('js/lib/moment.js') }}" ></script>
  <script type="text/javascript" src="{{ asset('js/lib/toastr.min.js') }}"></script> 
  <script src="{{ asset('js/common.js') }}"></script>
   
   <script src="{{ asset('js/helper.js') }}"></script>
  <script type="text/javascript"> 
      toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "10000",
      "hideDuration": "5000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
    //   "hideEasing": "linear",
      "showMethod": "fadeIn",
    //   "hideMethod": "fadeOut",
    }
  </script>  
  {{  moduleJs() }}
  <script type="text/javascript"> 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</html>
