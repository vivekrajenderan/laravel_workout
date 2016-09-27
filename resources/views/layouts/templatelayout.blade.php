
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AADHAR</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">              
        <!-- Custom Theme Style -->

        <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>  
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="javascript:void(0);" class="site_title"><i class="fa fa-paw"></i> <span>AADHAR</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="{{ asset('images/employee.png') }}" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?php echo Auth::user()->name;?></h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />
						<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Admin Panel</h3>
                <ul class="nav side-menu">
                  <li><a href="<?php echo url('/admin/dashboard');?>"><i class="fa fa-home"></i> Dashboard</a>                    
                  </li>
                  <li><a href="<?php echo url('/admin/user');?>"><i class="fa fa-user"></i> Users</a>                    
                  </li>
                 
                  <li><a href="<?php echo url('/admin/category');?>"><i class="fa fa-bar-chart-o"></i> Category List</a>                    
                  </li> 
                  <li><a href="<?php echo url('/admin/channel');?>"><i class="fa fa-tasks"></i> Channel List</a>                    
                  </li> 
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->
            
             </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/employee.png') }}" alt=""><?php echo Auth::user()->name;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo url('/admin/users/edit_profile');?>"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>                    
                    <li><a href="<?php echo url('logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

  @yield('content') 
  
<!-- footer content -->
<footer>
    <div class="pull-right">
        AADHAR APP by <a href="http://vijayglobal.com/">VGS</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>


<!-- Custom Theme Scripts -->
<script src="{{ asset('data_tables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('data_tables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>  
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert-success').hide('slow');
        }, 4000);
         setTimeout(function () {
            $('.alert-error').hide('slow');
        }, 4000);

        $('#datatable').dataTable();

    });
</script>
</body>
</html>

