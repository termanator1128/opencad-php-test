<?php

/**
Open source CAD system for RolePlaying Communities.
Copyright (C) 2017 Shane Gill

This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

This program comes with ABSOLUTELY NO WARRANTY; Use at your own risk.
**/


    session_start();
    // TODO: Verify user has permission to be on this page

    if (empty($_SESSION['logged_in']))
    {
        //header('Location: /index.php');
        die("Not logged in");
    }
    else
    {
      $name = $_SESSION['name'];
    }
	
	
    include("./actions/api.php");
    include("./actions/responderActions.php");

	callCheck();
    
    $citationMessage = "";
    if(isset($_SESSION['citationMessage']))
    {
        $citationMessage = $_SESSION['citationMessage'];
        unset($_SESSION['citationMessage']);
    }
    $warningMessage = "";
    if(isset($_SESSION['warningMessage']))
    {
        $citationMessage = $_SESSION['warningMessage'];
        unset($_SESSION['warningMessage']);
    }
	
?>

<!DOCTYPE html>
<html lang="en">
   <?php include "./oc-includes/header.inc.php"; ?>
   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;">
                     <a href="javascript:void(0)" class="site_title"><i class="fa fa-tachometer"></i> <span>Responder</span></a>
                  </div>
                  <div class="clearfix"></div>
                  <!-- menu profile quick info -->
                  <div class="profile clearfix">
                     <div class="profile_pic">
                        <img src="<?php echo get_avatar() ?>" alt="..." class="img-circle profile_img">
                     </div>
                     <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo $name;?></h2>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <!-- /menu profile quick info -->
                  <br />
                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                     <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                           <li class="active">
                              <a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu" style="display: block;">
                                 <li class="current-page"><a href="javascript:void(0)">Dashboard</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-book"></i> Warnings <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a type="button" data-toggle="modal" data-target="#createWarning" > Create Warning</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-book"></i> Citations <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a type="button" data-toggle="modal" data-target="#asdf" > Create Citation</a></li>
                              </ul>
                           </li>
                           <!--
                              <li><a><i class="fa fa-external-link"></i> Links <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                  <li><a href="https://goo.gl/forms/rEJOoJvIlCM5svSo1" target="_blank">Police PAL</a></li>
                                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSdDd1zZGTqUUuGQYuHzmz3TAIWb49y3BDFr8GwRbisLnwiRGg/viewform" target="_blank">Highway PAL</a></li>
                                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSd26EN4XdgKhbZBEJ16B8cx5LqTNxguh4O3wNggRqqzKOmXzg/viewform" target="_blank">Sheriff PAL</a></li>
                                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLScXgKDn0deB7zgnmBvDRJ7KllHLiQdmahvgQbphxZuNhU6h2g/viewform" target="_blank">Fire PAL</a></li>
                                  <li><a href="https://puu.sh/tRzTt/330b12ab3c.jpg" target="_blank">GTA 5 DOJRP Map</a></li>
                                </ul>
                              </li>
                              -->
                           <li>
                              <a><i class="fa fa-hashtag"></i> Callsign <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a id="changeCallsign" class="btn-link" name="changeCallsign" data-toggle="modal" data-target="#callsign">Change Callsign</a></li>
                              </ul>
                           </li>
                        </ul>
                     </div>
                     <!-- ./ menu_section -->
                  </div>
                  <!-- /sidebar menu -->
                  <!-- /menu footer buttons -->
                  <div class="sidebar-footer hidden-small">
                     <!--  —— Left in for user settings. To be introduced later. Probably after RC1. ——
                        <a data-toggle="tooltip" data-placement="top">
                          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>-->
                     <a data-toggle="tooltip" data-placement="top" title="FullScreen" onclick="toggleFullScreen()">
                     <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                     </a>
                     <a data-toggle="tooltip" data-placement="top" title="Go to Dashboard" href="<?php echo BASE_URL; ?>/dashboard.php">
                     <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                     </a>
                     <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo BASE_URL; ?>/actions/logout.php?responder=<?php echo $_SESSION['identifier'];?>">
                     <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                     </a>
                  </div>
                  <!-- /menu footer buttons -->
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
                           <img src="<?php echo get_avatar() ?>" alt=""><?php echo $_SESSION['name']; ?>
                           <span class=" fa fa-angle-down"></span>
                           </a>
                           <ul class="dropdown-menu dropdown-usermenu pull-right">
                              <li><a href="<?php echo BASE_URL; ?>/profile.php">My Profile</a></li>
                              <li><a href="<?php echo BASE_URL; ?>/actions/logout.php?responder=<?php echo $_SESSION['identifier'];?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                           </ul>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
               <div class="">
                  <div class="page-title">
                     <div class="title_left">
                        <h3>MDT Console</h3>
                        <?php echo $citationMessage;?>
                     </div>
                     <div class="x_footer">
                        <button class="btn btn-danger pull-right" name="new_call_btn" data-toggle="modal" data-target="#vehicles-bolo-board">View Vehicle BOLOs</button>
                        <button class="btn btn-danger pull-right" name="new_call_btn" data-toggle="modal" data-target="#persons-bolo-board">View Person BOLOs</button>

                     </div>
                     <!-- ./ title_left -->
                  </div>
                  <!-- ./ page-title -->
                  <div class="clearfix"></div>
                  <div class="row">
                    <!-- ./ x_content -->
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                           <div class="x_title">
                              <h2>Active Calls</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                              </ul>
                              <div class="clearfix"></div>
                           </div>
                           <!-- ./ x_title -->
                           <div class="x_content">
                              <div id="live_calls">
                              </div>
                           </div>
                           <!-- ./ x_content -->
                        </div>
                        <!-- ./ x_panel -->
                     </div>
                     <!-- ./ col-md-12 col-sm-12 col-xs-12 -->
                  </div>
                  <!-- ./ row -->
                  <div class="clearfix"></div>
                  <div class="row">
                     <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="x_panel">
                           <div class="x_title">
                              <h2>My Status</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                              </ul>
                              <div class="clearfix"></div>
                           </div>
                           <!-- ./ x_title -->
                           <div class="x_content">
                              <form id="myStatusForm">
                                 <!-- ./ form-group -->
                                 <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">My Callsign</label>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                       <input type="text" name="callsign" class="form-control" id="callsign1" value="<?php echo $_SESSION['identifier'];?>" readonly />
                                    </div>
                                    <!-- ./ col-sm-9 -->
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">My Status</label>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                       <input type="text" name="status" id="status" class="form-control" readonly />
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">Change Status</label>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                       <select name="statusSelect" class="form-control selectpicker <?php echo $_SESSION['identifier'];?>" id="statusSelect" onchange="responderChangeStatus(this);" title="Select a Status">
                                          <option value="10-6">10-6/Busy</option>
										  <option value="10-5">10-5/Meal Break</option>
										  <option value="10-7">10-7/Unavailable</option>
										  <option value="10-8">10-8/Available</option>
										  <option value="10-23">10-23/Arrived on Scene</option>
										  <option value="10-65">10-65/Transporting Prisoner</option>
                                          <option value="sig11">Signal 11</option>
                                       </select>
                                    </div>
                                    <!-- ./ col-sm-9 -->
                                 </div>
                                 <!-- ./ form-group -->
                              </form>
                           </div>
                        </div>
                        <!-- ./ x_panel -->
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="x_panel">
                           <div class="x_title">
                              <h2>My Call</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                              </ul>
                              <div class="clearfix"></div>
                           </div>
                           <!-- ./ x_title -->
                           <div class="x_content">
						   <?php getMyCall(); ?>
                           </div>
                           <!-- ./ x_content -->
                        </div>
                        <!-- ./ x_panel -->
                     </div>
                     <!-- ./ col-md-6 col-sm-6 col-xs-6 -->
                     <?php
                        if (isset($_GET['fire']))
                        {

                          if ($_GET['fire'] == "true")
                          {
                            //End the above row
                            echo '
                            </div>
                            <!-- ./ row -->

                            <div class="row">
                              <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>Fire PAL</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                  </div>
                                  <!-- ./ x_title -->
                                  <div class="x_content">
                                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScXgKDn0deB7zgnmBvDRJ7KllHLiQdmahvgQbphxZuNhU6h2g/viewform" height="400px" width="100%"></iframe>
                                  </div>
                                  <!-- ./ x_content -->
                                </div>
                                <!-- ./ x_panel -->
                              </div>
                              <!-- ./ col-md-4 col-sm-4 col-xs-4 -->
                              <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>Incident Report</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                  </div>
                                  <!-- ./ x_title -->
                                  <div class="x_content">
                                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeusONacJqMrKBoBxzhdn4Q53f7QjPwlDehjCmKPGLQgGVsKg/viewform?c=0&w=1" height="400px" width="100%"></iframe>
                                  </div>
                                  <!-- ./ x_content -->
                                </div>
                                <!-- ./ x_panel -->
                              </div>
                              <!-- ./ col-md-4 col-sm-4 col-xs-4 -->
                              <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>ePCR</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                  </div>
                                  <!-- ./ x_title -->
                                  <div class="x_content">
                                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeD7GBmb70LYfM7PLOOPddnyNrfYoO-m5NQwpTX1bSSn-9olQ/viewform?c=0&w=1" height="400px" width="100%"></iframe>
                                  </div>
                                  <!-- ./ x_content -->
                                </div>
                                <!-- ./ x_panel -->
                              </div>
                              <!-- ./ col-md-4 col-sm-4 col-xs-4 -->
                            </div>
                            <!-- ./ row -->
                            ';
                          }
                        }
                        else
                        {

                         /*

                              SG - Commenting out for now since citation creation isn't going to be a thing for LEOs

                         echo '
                         <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="x_panel">
                            <div class="x_title">
                              <h2>Citation Creator</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                              </ul>
                              <div class="clearfix"></div>
                            </div>
                            <!-- ./ x_title -->
                            <div class="x_content">
                              <div class="alert alert-info" style="text-align:center;"><span>Citations need to be approved by staff!</span></div>

                              <form id="newCitationForm">
                                <div class="row">
                                  <div class="form-group">
                                      <select class="form-control selectpicker civilian" data-live-search="true" name="civilian" id="civilian" title="Select Civilian" disabled>
                                        <?php getCivilianNamesOption();?>
                     </select>
                  </div>
                  <!-- ./ form-group -->
               </div>
               <!-- ./ row -->
               <div class="row">
                  <div class="form-group">
                     <select class="form-control selectpicker citation" data-live-search="true" name="citation[]" id="citation[]" multiple data-max-options="2" title="Select Citations (Limit 2)" disabled>
                     <?php getCitations();?>
                     </select>
                  </div>
                  <!-- ./ form-group -->
               </div>
               <!-- ./ row -->
            </div>
            <!-- ./ x_content -->
            <br/>
            <div class="x_footer">
               <button type="submit" class="btn btn-primary pull-right" id="newCitationSubmit" disabled>Submit Citation</button>
            </div>
            <!-- ./ x_footer -->
            </form>
         </div>
         <!-- ./ x_panel -->
      </div>
      <!-- ./ col-md-6 col-sm-6 col-xs-6 -->
      '; */
      }
      ?>
      <!-- ./ row -->
      </div>
      <!-- "" -->
      </div>
	  </div> 
      <!-- /page content -->
      <!-- footer content -->
      <footer>
         <div class="pull-right">
            <?php echo COMMUNITY_NAME?> CAD System
         </div>
         <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
      </div>
      </div>
      <!-- modals -->
      <!-- Callsign Modal -->
      <div class="modal fade" id="callsign" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-md">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" id="closeCallsign" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Enter Your Callsign for This Patrol</h4>
               </div>
               <!-- ./ modal-header -->
               <div class="modal-body">
                  <form class="callsignForm" id="callsignForm">
                     <div class="form-group">
                        <label class="col-md-2 control-label">Callsign</label>
                        <div class="col-md-10">
                           <input type="text" id="callsign" name="callsign" class="form-control" />
                        </div>
                        <!-- ./ col-sm-9 -->
                     </div>
                     <!-- ./ form-group -->
               </div>
               <!-- ./ modal-body -->
               <div class="modal-footer">
               <input type="submit" name="setCallsign" class="btn btn-primary" value="Set Callsign"/>
               </div>
               <!-- ./ modal-footer -->
               </form>
            </div>
            <!-- ./ modal-content -->
         </div>
         <!-- ./ modal-dialog modal-md -->
      </div>
      <!-- ./ modal fade -->
      <!-- Vehicle BOLO Board Modal -->
      <div class="modal fade" id="vehicles-bolo-board" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" id="closeCallsign" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Currently Active Vehicle BOLOs</h4>
               </div>
               <!-- ./ modal-header -->
               <div class="modal-body">
                  <form class="callsignForm" id="callsignForm">
                    <?php mdtGetVehicleBOLOS(); ?>
                        <!-- ./ col-sm-9 -->
                     </div>
                     <!-- ./ form-group -->
               </div>
               <!-- ./ modal-body -->
               </form>
            </div>
            <!-- ./ modal-content -->
         </div>
         <!-- ./ modal-dialog modal-md -->

      <!-- Person BOLO Board Modal -->
      <div class="modal fade" id="persons-bolo-board" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" id="closeCallsign" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Currently Active Person BOLOs</h4>
               </div>
               <!-- ./ modal-header -->
               <div class="modal-body">
                  <form class="callsignForm" id="callsignForm">
                    <?php mdtGetPersonBOLOS(); ?>
                        <!-- ./ col-sm-9 -->
                     </div>
                     <!-- ./ form-group -->
               </div>
               <!-- ./ modal-body -->
               </form>
            </div>
            <!-- ./ modal-content -->
         </div>
         <!-- ./ modal-dialog modal-md -->


      <!-- Call Details Modal -->
      <div class="modal fade" id="asdf" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" id="closecallDetails"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Citation Creation</h4>
            </div>
            <!-- ./ modal-header -->
          <div class="modal-body">
            <form role="form" action="<?php echo BASE_URL; ?>/actions/responderActions.php" method="post">
                <div class="form-group row">
                <label class="col-lg-2 control-label">Civilian Name</label>
                <div class="col-lg-10">
                  <select class="form-control selectpicker" name="civilian_names" id="civilian_names" data-live-search="true" required title="Select Civilian">
                    <?php getCivilianNamesOption();?>
                  </select>
                </div>
                <!-- ./ col-sm-9 -->
              </div>
              <!-- ./ form-group -->
              <div class="form-group row">
                <label class="col-lg-2 control-label">Citation Name</label>
                <div class="col-lg-10">
                  <select class="form-control selectpicker" data-live-search="true" name="citation_name" id="citation_name" title="Select Citation" required>
                    <?php getCitations();?>
                  </select>
                </div>
                <!-- ./ col-sm-9 -->
              </div>
              <!-- ./ form-group -->
          </div>
          <!-- ./ modal-body -->
          <div class="modal-footer">
                <input name="create_citation" type="submit" class="btn btn-primary" value="Create" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
          <!-- ./ modal-footer -->
        </div>
        <!-- ./ modal-content -->
      </div>
      <!-- ./ modal-dialog modal-lg -->
    </div>
    <!-- ./ modal fade bs-example-modal-lg -->
      <!-- Create Warning Modal -->
      <div class="modal fade" id="createWarning" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" id="closeNewCall"><span aria-hidden="true">×</span>
                  </button>
            <h4 class="modal-title" id="myModalLabel">Warning Creator</h4>
          </div>
          <!-- ./ modal-header -->
          <div class="modal-body">
            <form role="form" action="<?php echo BASE_URL; ?>/actions/responderActions.php" method="post">
                <div class="form-group row">
                <label class="col-lg-2 control-label">Civilian Name</label>
                <div class="col-lg-10">
                  <select class="form-control selectpicker" name="civilian_names" id="civilian_names" data-live-search="true" required title="Select Civilian">
                    <?php getCivilianNamesOption();?>
                  </select>
                </div>
                <!-- ./ col-sm-9 -->
              </div>
              <!-- ./ form-group -->
              <div class="form-group row">
                <label class="col-lg-2 control-label">Warning Name</label>
                <div class="col-lg-10">
					<input type="text" class="form-control" name="warning_name" id="warning_name" placeholder="Enter a warning" />
                </div>
                <!-- ./ col-sm-9 -->
              </div>
              <!-- ./ form-group -->
          </div>
          <!-- ./ modal-body -->
          <div class="modal-footer">
                <input name="create_warning" type="submit" class="btn btn-primary" value="Create" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
          <!-- ./ modal-footer -->
        </div>
        <!-- ./ modal-content -->
      </div>
      <!-- ./ modal-dialog modal-lg -->
    </div>
    <!-- ./ modal fade bs-example-modal-lg -->
      <!-- Call Details Modal -->
      <div class="modal fade" id="callDetails" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" id="closecallDetails"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Call Details</h4>
            </div>
            <!-- ./ modal-header -->
            <div class="modal-body">
               <form class="callDetailsForm" id="callDetailsForm">
                  <div class="form-group">
                     <label class="col-lg-2 control-label">Incident ID</label>
                     <div class="col-lg-10">
                        <input type="text" id="call_id_det" name="call_id_det" class="form-control" disabled>
                     </div>
                     <!-- ./ col-sm-9 -->
                  </div>
                  <br/>
                  <!-- ./ form-group -->
                  <div class="form-group">
                     <label class="col-lg-2 control-label">Incident Type</label>
                     <div class="col-lg-10">
                        <input type="text" id="call_type_det" name="call_type_det" class="form-control" disabled>
                     </div>
                     <!-- ./ col-sm-9 -->
                  </div>
                  <br/>
                  <!-- ./ form-group -->
                  <div class="form-group">
                     <label class="col-lg-2 control-label">Main Street</label>
                     <div class="col-lg-10">
                        <input type="text" id="call_street2_det" name="call_street2_det" class="form-control" disabled>
                     </div>
                     <!-- ./ col-sm-9 -->
                  </div>
                  <br/>
                  <!-- ./ form-group -->
                  <div class="form-group">
                     <label class="col-lg-2 control-label">Cross Street</label>
                     <div class="col-lg-10">
                        <input type="text" id="call_street3_det" name="call_street3_det" class="form-control" disabled>
                     </div>
                     <!-- ./ col-sm-9 -->
                  </div>
                  <br/>
                  <br />
                  <!-- ./ modal-body -->
                  <br/>
                  <div class="modal-footer">
                     <input type="submit" id="addCallNarrative" class="btn btn-primary pull-left" value="Add Narrative" />
                     <button id="closeDetailsModal" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                  <!-- ./ modal-footer -->
               </form>
            </div>
            <!-- ./ modal-content -->
         </div>
         <!-- ./ modal-dialog modal-lg -->
      </div>
      <!-- ./ modal fade bs-example-modal-lg -->
      <!-- AUDIO TONES -->
      <audio id="recurringToneAudio" src="<?php echo BASE_URL; ?>/sounds/priority.mp3" preload="auto"></audio>
      <audio id="priorityToneAudio" src="<?php echo BASE_URL; ?>/sounds/Priority_Traffic_Alert.mp3" preload="auto"></audio>
      <script>
         var vid = document.getElementById("recurringToneAudio");
         vid.volume = 0.3;
      </script>
      <?php
         if (isset($_GET['fire']))
         {

           if ($_GET['fire'] == "true")
           {
             echo '<audio id="newCallAudio" src="'.BASE_URL.'/sounds/Fire_Tones_Aligned.wav" preload="auto"></audio>';
           }
         }
         else
         {
           echo '<audio id="newCallAudio" src="'.BASE_URL.'/sounds/New_Dispatch.mp3" preload="auto"></audio>';
         }
         ?>
      <?php include "./oc-includes/jquery-colsolidated.inc.php"; ?>
      <script>
         $(document).ready(function() {
             $(function() {
                 $('#menu_toggle').click();
             });

             $('#callsign').modal('show');

             getCalls();
             getStatus();
             checkTones();

             $('#enroute_btn').click(function(evt) {
               console.log(evt);
               var callId = $('#call_id_det').val();

               $.ajax({
                   type: "POST",
                   url: "<?php echo BASE_URL; ?>/actions/api.php",
                   data: {
                       quickStatus: 'yes',
                       event: 'enroute',
                       callId: callId
                   },
                   success: function(response)
                   {
                     console.log(response);

                     new PNotify({
                       title: 'Success',
                       text: 'Successfully updated narrative',
                       type: 'success',
                       styling: 'bootstrap3'
                     });
                   },
                   error : function(XMLHttpRequest, textStatus, errorThrown)
                   {
                     console.log("Error");
                   }

                 });
             });

         });
      </script>
      <script>
         // PNotify Stuff
         priorityNotification = new PNotify({
             title: 'Priority Traffic',
             text: 'Priority Traffic Only',
             type: 'error',
             hide: false,
             auto_display: false,
             styling: 'bootstrap3',
             buttons: {
                 closer: false,
                 sticker: false
             }
           });

      </script>
      <script>
         function getCalls() {
             $.ajax({
                   type: "GET",
                   url: "<?php echo BASE_URL; ?>/actions/api.php",
                   data: {
                       getCalls: 'yes',
                       responder: 'yes'
                   },
                   success: function(response)
                   {
                     $('#live_calls').html(response);
                     setTimeout(getCalls, 5000);

                   },
                   error : function(XMLHttpRequest, textStatus, errorThrown)
                   {
                     console.log("Error");
                   }

                 });
           }
      </script>
      <script>
         function getMyCall() {
             $.ajax({
                   type: "GET",
                   url: "<?php echo BASE_URL; ?>/actions/api.php",
                   data: {
                       getMyCall: 'yes',
                       responder: 'yes'
                   },
                   success: function(response)
                   {
                     $('#mycall').html(response);
                     setTimeout(getMyCall, 5000);

                   },
                   error : function(XMLHttpRequest, textStatus, errorThrown)
                   {
                     console.log("Error");
                   }

                 });
           }
      </script>
      <script>
         $('#callsign').on('shown.bs.modal', function(e) {
             $('#callsign').find('input[name="callsign"]').val('<?php echo $_SESSION['identifier'];?>');
         });
      </script>
      <script>
         $(function() {
             $('.callsignForm').submit(function(e) {
                 e.preventDefault(); // avoid to execute the actual submit of the form.

                 $.ajax({
                   type: "POST",
                   url: "<?php echo BASE_URL; ?>/actions/responderActions.php",
                   data: {
                       updateCallsign: 'yes',
                       details: $("#"+this.id).serialize()
                   },
                   success: function(response)
                   {
                     console.log(response);

                     if (response.match("^Duplicate"))
                     {
                         var call2 = $('#callsign').find('input[name="callsign"]').val();
                         if (call2 == "<?php echo $_SESSION['identifier'];?>")
                         {
                             $('#closeCallsign').trigger('click');

                             new PNotify({
                                 title: 'Success',
                                 text: 'Successfully set your callsign',
                                 type: 'success',
                                 styling: 'bootstrap3'
                             });

                             return false;

                         }
                         else
                         {
                             $('#closeCallsign').trigger('click');

                             new PNotify({
                             title: 'Error',
                             text: 'That callsign is already in use',
                             type: 'error',
                             styling: 'bootstrap3'
                             });
                         }

                     }

                     if (response == "SUCCESS")
                     {

                       $('#closeCallsign').trigger('click');

                       new PNotify({
                         title: 'Success',
                         text: 'Successfully set your callsign',
                         type: 'success',
                         styling: 'bootstrap3'
                       });

                       var call1 = $('#callsign').find('input[name="callsign"]').val();

                       $('#callsign1').val(call1);
                     }

                   },
                   error : function(XMLHttpRequest, textStatus, errorThrown)
                   {
                     console.log("Error");
                   }

                 });

             });
           });
      </script>
      <script>
         function getStatus() {
         $.ajax({
             type: "GET",
             url: "<?php echo BASE_URL; ?>/actions/responderActions.php",
             data: {
                 getStatus: 'yes'
             },
             success: function(response)
             {
                 console.log(response);
                 if (response.match("^10-6/On"))
                 {
                     var currentStatus = $('#status').val();
                     if (currentStatus == "10-6/On a Call")
                     {
                         //Do nothing
                     }
                     else
                     {
                         document.getElementById('newCallAudio').play();
                         new PNotify({
                             title: 'New Call!',
                             text: 'You\'ve been assigned a new call!',
                             type: 'success',
                             styling: 'bootstrap3'
                         });

                         getMyCallDetails();
                     }
                 }
                 else if (response.match("^<br>"))
                 {
                     console.log("LOGGED OUT");
                     window.location.href = '<?php echo BASE_URL; ?>/actions/logout.php';

                 }
                 else
                 {

                 }

                 $('#status').val(response);
                 setTimeout(getStatus, 5000);
             },
             error : function(XMLHttpRequest, textStatus, errorThrown)
             {
             console.log("Error");
             }

         });
         }

         function getMyCallDetails()
         {
           console.log("Got here");
         }
      </script>
   </body>
</html>
