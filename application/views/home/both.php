<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet"/>
 <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
 <title>All Attendances</title>
    <style>
      $query = $this->db->query("SELECT `Id`,  `Shift`  FROM ` EmployeeMaster`  WHERE OrganizationId=? AND `Id` Not IN(SELECT `EmployeeId` FROM `AttendanceMaster` ) ",array($orgid)); 
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
      }
      .delete{
      cursor:pointer;
      }
    .bargraph{
         display:inline-block;
         margin-top:-8px;
         margin-left:-17px;
       }
      div.dt-buttons{
      position:relative;
      float:left;
      margin-left:15px;
      }
      .t2{display:none;}
     .modal-footer .btn+.btn 
    {
      margin-bottom: 10px!important;
    }
    a
    {
      cursor:pointer;
      
    }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <?php
        $data['pageid']=7.775;
        $this->load->view('menubar/sidebar',$data);
        ?>
      <div class="main-panel">
        <?php
          $this->load->view('menubar/navbar');
          ?>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                    <p class="category" style="color:#ffffff;font-size:17px;" >All Attendances </p>
                  </div>
                  <div class="card-content">
                    <div id="typography">
                      <div class="title">
                       <div class=" container-fluid row" style="margin-top:0px;" >
                          <div class="col-sm-3 bargraph" style="margin-top:0px;" >
                            <div id="reportrange" class="" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%;margin-left:-12px;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> <b class="caret"></b>
                            </div>
                          </div>
              
              <div class="col-sm-2">
              <div class="row" >
              <select id="desg" style="height:35px;position:relative;" class="col-sm-11">
              <option value="0">--All Designations--</option>
                <?php
                $data= json_decode(getAllDesg($_SESSION['orgid']));
                for($i=0;$i<count($data);$i++){
                  echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
                }?>
              </select>
               </div>
              </div>
              
                            <div class="col-sm-2" > 
                            <div class="row" >              
              <select id="deprt" name="deprt" style=" height:35px;position:relative;" class="col-sm-11">
                <option value="0">--All Departments--</option>
                <?php
                $data= json_decode(getAllDept($_SESSION['orgid']));
                for($i=0;$i<count($data);$i++)
                echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
                ?>
                </select>    
                </div>
                </div>
                <div class="col-sm-2" >
                <div class="row" >
                              <select id="shift" name="shift" style=" height:35px;position:relative;" class="col-sm-11">
                 <option value="0">--All Shifts--</option>
                <?php
                $data= json_decode(getAllShift($_SESSION['orgid']));
                for($i=0;$i<count($data);$i++)
                  echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
                TimeOut),0,5).')</option>';
                ?></select>
                </div>
                </div>
                <div class="col-sm-2">
                <div class="row">
                <select id="empl" style="height:35px;position:relative;" class="col-sm-12">
                 <option value="0">--All Employees--</option>
                <?php
                $data= json_decode(getAllemp($_SESSION['orgid']));
                for($i=0;$i<count($data);$i++){
                  echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
                }?>
                  </select>
                 </div>
                </div>
                 <div class="col-sm-1">
                 <button class="btn btn-success pull-left" style="position:relative; right:10px;margin-top:0px;height:35px;padding-top:8px;" id="getAtt" ><i class="fa fa-search"></i></button>
                </div>
                        </div>
                     <!--   <div class="row">
                          <div class="col-md-12 text-right">
                            <a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar">
                            <i class="fa fa-question"></i></a>
                          </div>
                        </div> -->
            <br>
                        <div class="row" style="overflow-x:scroll;">
                          <table id="example" class="display table"  width="100%">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Profile Image</th>
                                <th>Code</th>
                                <th>Shift</th>
                                <th>Date</th>
                                <th>Time In Date</th>
                                <th>Time In</th>
                                <th width='1%' >Time In Image</th>
                                <th width='50%'>Time In Location</th>
                          <th>Time Out Date</th>
                                <th>Time Out</th>
                                <th width='1%' >Time Out Image</th>
                                <th width='50%'>Time Out Location</th>
                                <th>Logged Hours</th>
                                <th>Device</th>
                                <th width="10%" style="background-image:none"!important>Status</th>
                                <th style="background-image:none"!important>Action</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 t2" id="sidebar" style=" margin-top:50px;"></div>
        <footer class="footer">
          <div class="container-fluid" style="" >
            <nav class="pull-left">
            </nav>
           <!-- <p class="copyright pull-right" style="padding-right:35px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
            </p>-->
      <a href="http://www.ubitechsolutions.com/" target="_blank" >
          <p class="copyright pull-right" style="padding-right:25px;padding-top:0px;" >
          Copyright &copy;<script>document.write(new Date().getFullYear())</script>
          Ubitech Solutions. All rights reserved.
          </p>
        </a>
          </div>
        </footer>
      </div>
    </div>
     <!------Edit attendance modal start------------>
    <div id="addAttATO" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update TimeOut</h4>
          </div>
          <div class="modal-body">
            <form id="AttFrom">
              <input type="hidden" id="id" />
         <!--<input  type="hidden" id="attDateE"   >-->
         <input  type="hidden" id="shifttype"   >
         <input  type="hidden" id="timeInE"   >
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time Out <span class="red">*</span></label>
                    <input type="text"  id="timeOutE"   class="form-control timepicker2" >
                  </div>
                </div>
              </div>
              <div class="row" id="shifttypedate">
          <div class="col-md-6">
            <div class="form-group ">
            <label class="control-label">Time Out Date <span class="red">*</span></label>
            <input type="text"  id="attDateE"   class="form-control datepicker" >
            </div>
          </div>   
              </div>
        
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="saveEE"  class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------Edit attendance modal close------------>
    <!-- data inset -->

      <!------Edit attendance modal start------------>
    <div id="addAttsk" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update Attendance</h4>
          </div>
          <div class="modal-body">
            <form id="AttFrom">
              <input type="hidden" id="id"/>
              <input  type="hidden" id="sid"/>
              <input  type="hidden" id="deptid"/>
              <input  type="hidden" id="desgid"/>
              <input  type="hidden" id="areaid"/>
              <input type="hidden" id="aname" />
         <!--<input  type="hidden" id="attDateE"   >-->
         <!-- <input  type="hidden" id="shifttype"   > -->
         <!--<input  type="hidden" id="timeInE"   >-->
              <!--<div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label>Name</label>
                    <input type="text" readonly='true' placeholder="Employee Name"  id="attNameE" class="form-control" >
                  </div>
                </div>
                <!--<div class="col-md-6">
                  <div class="form-group label-floating">
                    <label>Date</label>
                    <input placeholder="Attendance Date" readonly='true' type="text" id="attDateE"  class="form-control" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Shift</label>
                    <select class="form-control" id="shiftE" >
                    <?php
                      $data= json_decode(getAllShift($_SESSION['orgid']));
                      for($i=0;$i<count($data);$i++)
                        echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Status</label>
                    <select class="form-control" id="statusE" >
                      <option value='1'>Present</option>
                      <option value='0'>Absent</option>
                    </select>
                  </div>
                </div>
              </div>-->
              <div class="row">
        <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time In <span class="red">*</span></label>
                    <input type="text"  id="timein"   class="form-control timepicker" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time Out <span class="red">*</span></label>
                    <input type="text"  id="timeout"   class="form-control timepicker1" >
                  </div>
                </div>
              </div>
        
         
       
              <div class="row" id="shifttypedate">
          <div class="col-md-6">
            <div class="form-group ">
            <label class="control-label">Time In Date <span class="red">*</span></label>
            <input type="text"  id="attInDateE1"   class="form-control datepicker" readonly="readonly">
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group ">
            <label class="control-label">Time Out Date <span class="red">*</span></label>
            <input type="text"  id="attOutDateE1"   class="form-control datepicker" readonly="readonly">
            </div>
          </div>   
              </div>
        
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="savesk"  class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------Edit attendance modal close------------>


    <!-- data insert end -->
  
  
  
   <!------Edit attendance modal start------------>
    <div id="addAttE" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update Attendance</h4>
          </div>
          <div class="modal-body">
            <form id="AttFrom">
              <input type="hidden" id="id" />
              <input  type="hidden" id="sid">
              <input  type="hidden" id="deptid">
              <input  type="hidden" id="desgid">
              <input  type="hidden" id="areaid">
              <input type="hidden" id="aname" />
         <!--<input  type="hidden" id="attDateE"   >-->
         <!-- <input  type="hidden" id="shifttype"   > -->
         <!--<input  type="hidden" id="timeInE"   >-->
              <!--<div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label>Name</label>
                    <input type="text" readonly='true' placeholder="Employee Name"  id="attNameE" class="form-control" >
                  </div>
                </div>
                <!--<div class="col-md-6">
                  <div class="form-group label-floating">
                    <label>Date</label>
                    <input placeholder="Attendance Date" readonly='true' type="text" id="attDateE"  class="form-control" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Shift</label>
                    <select class="form-control" id="shiftE" >
                    <?php
                      $data= json_decode(getAllShift($_SESSION['orgid']));
                      for($i=0;$i<count($data);$i++)
                        echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Status</label>
                    <select class="form-control" id="statusE" >
                      <option value='1'>Present</option>
                      <option value='0'>Absent</option>
                    </select>
                  </div>
                </div>
              </div>-->
              <div class="row">
        <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time In <span class="red">*</span></label>
                    <input type="text"  id="timeInE1"   class="form-control timepicker1" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time Out <span class="red">*</span></label>
                    <input type="text"  id="timeOutE1"   class="form-control timepicker1" >
                  </div>
                </div>
              </div>
        
         
       
              <div class="row" id="shifttypedate">
          <div class="col-md-6">
            <div class="form-group ">
            <label class="control-label">Time In Date <span class="red">*</span></label>
            <input type="text"  id="attInDateE"   class="form-control datepicker" readonly="readonly">
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group ">
            <label class="control-label">Time Out Date <span class="red">*</span></label>
            <input type="text"  id="attOutDateE"   class="form-control datepicker" readonly="readonly">
            </div>
          </div>   
              </div>
        
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="saveE"  class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------Edit attendance modal close------------>
  
  
    <!------image modal ----->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <form id="imgE" method="POST" enctype="multipart/form-data" name="myformE">
    <input type="hidden" id="imgid">
        <img src="" class="imagepreview" style="width:550px!important;height:500px!important;" 
id="profileimg" >
      </div>
    <div class="modal-footer">
            <button type="button" id="setprofile"  class="btn btn-success">Set as Profile</button>
    </div>
     </form>
    </div>
  </div>
</div>
    <!----------->
<!-- profile modal Start -->


<div class="modal fade" id="imagemodal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <form id="imgE1" method="POST" enctype="multipart/form-data" name="myformE1">
    <input type="hidden" id="imgid1">
        <img src="" class="imagepreview1" style="width:550px!important;height:500px!important;" 
id="profileimg1" >
     </div>
    <div class="modal-footer">
            <button type="button" id="setprofile"  class="btn btn-success">Set as Profile</button>
    </div> 
     </form>
    </div>
  </div>
</div>



<!-- profile modal End -->

  
  <!------------------Location Modal --------------->
<div class="modal fade" id="locationmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
   <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <h4 class="modal-title" id="title"></h4>
          </div>
      <div class="modal-body">
    <form>
    <input type="hidden" id="latitid">
    <input type="hidden" id="latitinid">
    <input type="hidden" id="longiid">
    <input type="hidden" id="checkinloc">
    <div class="row">
                <div class="col-md-12">
                  <h4> Choose an option</h4>
                </div>
        </div>
              <div class="clearfix"></div>
    <div class="modal-footer">
           <!-- <button type="button" id="showgoogle"  class="btn btn-danger">Show Google Map</button>-->
      <a href="#"  class="btn btn-success" id="showgoogle" >Open In Google Maps</a>
      <a href="#"  id="creategeo" class="btn btn-success"  >Create GeoFence</a>
            <!--<button type="button" class="btn btn-danger" >Create GeoFence</button>-->
    </div>
     </form>
    </div>
  </div>
</div>
</div>
<!--------------------------------->
  
  
  
  
  
  
  <!-- edit attendance modal for current day -->
<div id="addAttc" class="modal fade" role="dialog">
 <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update Attendance</h4>
          </div>
          <div class="modal-body">
            <form id="AttForm">

              <input type="hidden" id="idc" />
              <input type="hidden" id="anamec" />
              <input type="hidden" id="attInDatec1" />
         <!--<input  type="hidden" id="attDateE"   >-->
         <input  type="hidden" id="shifttypec"   >

          <div class="row">
        <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time In <span class="red">*</span></label>
                    <input type="text"  id="timeInc1"   class="form-control timepicker" >
                  </div>
                </div>
            </div>
            <div class="clearfix"></div>

 </form>
</div>

     <div class="modal-footer">
            <button type="button" id="savec"  class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>



</div>
</div>  
</div>

<!-- end edit attendance modal for current day -->
  
  
  
    <!-----delete attendance start--->
     <div id="delAtt" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <h4 class="modal-title" id="title">Delete Attendance</h4>
          </div>
          <div class="modal-body">
            <form>
              <input type="hidden" id="del_aid" />
              <input type="hidden" id="del_att" />
             
              <div class="row">
                <div class="col-md-12">
                  <h4>Are you sure want to delete <span id="ana"></span>'s Attendance  ?</h4>
                </div>
              </div>
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="delete"  class="btn btn-danger" style="margin-top: -10px;">Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-----delete Attn close--->
  </body>
  
    
 
  <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
  
  <script type="text/javascript">
            $('.timepicker').timepicker({
      });
    </script>
  <script type="text/javascript">
   // $(document).ready(function() {
    var datestring="&date=";
  var ts;
    var ts1;
    var ss;
    var table= $('#example').DataTable( {
    
    order: [[ 4, 'desc' ],[0, "asc"]],
  //aaSorting: [],
    //"scrollX": true,
    dom: 'Bfrtip',
  
    //"bDestroy": true, // destroy data table before reinitializing
    buttons: [
    'pageLength','csv','excel','copy','print',
    {
      "extend":'colvis',
      "columns":':not(:last-child)',
    }
    ],
  columnDefs: [ { orderable: false, targets: [15,16]}],
    "contentType": "application/json",
    "ajax": "<?php echo URL;?>admin/getAttendances__both?datestatus="+7+datestring,
    "columnDefs": 
  [
    { "visible": false, "targets": [1,2,4,5,9,14] }
    ],
  
    "columns": [
    { "data": "name" },
    { "data": "proimage" },
    { "data": "code" },
    { "data": "shift" },
    { "data": "date" },
  { "data": "timeindate" },
    { "data": "tif" },
    { "data": "entryimg" },
    { "data": "chiloc" },
  { "data": "timeoutdate" },
    { "data": "tof" },
    { "data": "exitimg" },
    { "data": "choloc" },
    { "data": "wh" },
    { "data": "device" },
    { "data": "status" },
    { "data": "action" }
    ],
   "drawCallback": function ( settings ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;
     
          api.column(4, {page:'current'} ).data().each( function ( group, i ) {
            if ( last !== group ) {
              $(rows).eq( i ).before(
                '<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
              );
              last = group;
            }
          } );
        }
  
    });


  //  $('input.timepicker').timepicker();
   
   
  
    
       ////---------date picker
     var minDate = moment();
      var start = moment().subtract(6, 'days');
      // alert(start);
      var end = moment().subtract(0, 'days');
      function cb(start, end) {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
      }
      $('#reportrange').daterangepicker({
        maxDate:minDate,
        minDate:'-4M',
        startDate: start,
        endDate: end,
        ranges:{
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
           'Last 30 Days': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      }, cb);
      cb(start, end);
    ////---------/date picker
    //$('#reportrange').on('DOMNodeInserted',function(){ 
    $('#getAtt').click(function(){ 
          var range=$('#reportrange').text();
      var shift=$('#shift').val();
      var dept=$('#deprt').val();
      var empl=$('#empl').val();
      var desg=$('#desg').val();
      
 
      $('#example').DataTable({
          //order:[[0, "asc"]],
          order:[[4,'DESC'],[0, "asc"]],
          dom: 'Bfrtip',
          "bDestroy": true,// destroy data table before reinitializing
        buttons: [
          'pageLength','csv','excel','copy','print',
            {
              "extend":'colvis',
              "columns":':not(:last-child)',
            }
            ],
  //columnDefs: [ { orderable: false, targets: [14,15]}],
        
  
    "contentType": "application/json",
    "ajax": "<?php echo URL;?>admin/getAttendances__both?date="+range+"&shift="+shift+"&dept="+dept+"&empl="+empl+"&desg="+desg,
    "columnDefs": [
          { "visible": false, "targets": [1,2,4,5,9,14] }
          ],
    "columns": [
      { "data": "name" },
      { "data": "proimage" },
      { "data": "code" },
      { "data": "shift" },
      { "data": "date" },
      { "data": "timeindate" },
      { "data": "tif" },
      { "data": "entryimg" },
      { "data": "chiloc" },
    { "data": "timeoutdate" },
      { "data": "tof" },
      //{ "data": "ot" },//get Changed by Ma'am ..
      { "data": "exitimg" },
      { "data": "choloc" },
      { "data": "wh" },
      { "data": "device" },
      { "data": "status" },
      { "data": "action" }
    ],
      "drawCallback": function ( settings ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;
     
          api.column(4, {page:'current'} ).data().each( function ( group, i ) {
            if ( last !== group ) {
              $(rows).eq( i ).before(
                '<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
              );
              last = group;
            }
          });
          }
    } );
    });
    // $('#saveE').click(function(){
      // var id=$('#id').val();
          // // var na=$('#attNameE').val();
      // var ti=$('#timeInE').val();
      // var to=$('#timeOutE').val();
          // // var ad=$('#attDateE').val();
      // var sh=$('#shiftE').val();
      // var sts=$('#statusE').val();
      // $.ajax({url: "<?php echo URL;?>admin/editAtt",
      // data: {"id":id,"ti":ti,"to":to,"sh":sh,"sts":sts},
      // success: function(result){
        // if(result==1){
          // doNotify('top','center',2,'Attendance Updated Successfully.');
          // $('#addAttE').modal('hide');
           // table.ajax.reload();
        // }else{
          // doNotify('top','center',4,'can not be updated.');
        // }
        
       // },
      // error: function(result){
        // doNotify('top','center',4,'Unable to connect API');
       // }
      // });
    // }); 
   //////////////////////////
   $(document).on("click", ".loc",function ()
      {
        $('#latitid').val($(this).data('latit'));
        $('#latitinid').val($(this).data('latitin'));
        $('#longiid').val($(this).data('longiin'));
        $('#checkinloc').val($(this).data('checkinloc'));
        $('#locationmodal').modal('show');   
      });
      
      
    $('#showgoogle').click(function(){
       var latitid=$('#latitid').val();
       window.open("http://maps.google.com/?q="+latitid);
       //$("a").attr("href", "http://maps.google.com/?q="+latitid);
       //$("a").attr("target", "_blank");
       $('#locationmodal').modal('hide');  
       
    });     
      
    $('#creategeo').click(function(){
       //var latitid=$('#latitid').val();
       var latitid=$('#latitinid').val();
       var longiid=$('#longiid').val();
       var checkinloc=$('#checkinloc').val();
       window.open("<?= URL?>Dashboard/creategeofence/"+latitid+"/"+longiid+"/"+checkinloc);
       // $("a").attr("href", "<?= URL?>Dashboard/creategeofence/"+latitid+"/"+longiid+"/"+checkinloc);
       // $("a").attr("target", "_blank");
       $('#locationmodal').modal('hide');  
       
    }); 
      
   //////////////////////
  
  $(document).on("click", ".pop",function ()
      {
        
        $('#imgid').val($(this).data('id'));
      //  $('#profileimg').val($(this).data('enimage'));
      //  alert($(this).data('enimage'));
      $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('#imagemodal').modal('show');   
      });


  $(document).on("click", ".pop1",function ()
      {
        
        $('#imgid1').val($(this).data('id'));
      //  $('#profileimg').val($(this).data('enimage'));
      //  alert($(this).data('enimage'));
      $('.imagepreview1').attr('src', $(this).find('img').attr('src'));
        $('#imagemodal1').modal('show');   
      });
  
  $('#setprofile').click(function(){
      var id=$('#imgid').val();
   // alert($('#profileimg').prop("files")[0]);
   var imgg=$('#profileimg').attr('src');
  
    var  formdata = new FormData();
      formdata.append('profimg',imgg);
      formdata.append('id',id);
    
      $.ajax({
    processData: false,
    contentType: false,
    url: "<?php echo URL;?>admin/editimg",
      data: formdata,
    datatype:"json",
    type:"post",
      success: function(result){
        if(result==1)
      {
          datestring='&date='+$('#reportrange').text();
          doNotify('top','center',2,'Set as Profile Picture');
        $('#imagemodal').modal('hide');  
           $('#example').DataTable().ajax.reload();
        }
      else
      {
          doNotify('top','center',4,'can not be updated.');
        }
        
       },
      error: function(result)
      {
        doNotify('top','center',4,'Unable to connect API');
      }
      });
    }); 

  
  
 $(document).on("click", ".delete", function () {
    $('#del_aid').val($(this).data('aid'));
    $('#ana').text($(this).data('aname'));
    $('#del_att').val($(this).data('attdate'));
  
    });
  
  
  
    $(document).on("click", "#delete", function() 
  {
    var id=$('#del_aid').val();
    var ana=$('#ana').text();
    var del_att=$('#del_att').val();
    $.ajax({url: "<?php echo URL;?>admin/deleteAtt",
      data: {"aid":id,"ana":ana,"del_att":del_att},
      success: function(result)
    {
        if(result==1){
        datestring='&date='+$('#reportrange').text();
          $('#delAtt').modal('hide');
          doNotify('top','center',2,'Attendance deleted successfully.');
           $('#example').DataTable().ajax.reload();
        }else{
          $('#delAtt').modal('hide');
          doNotify('top','center',4,'There may problem(s) in deleting Attendance , try later.');
        }
      
       },
      error: function(result){
        doNotify('top','center',4,'Unable to connect API');
       }
      });
    });
  
  
  
 $('#saveEE').click(function(){
      var id=$('#id').val();
      var ti=$('#timeInE').val();
      var to=$('#timeOutE').val();
      var date=$('#attDateE').val();
      var shifttype=$('#shifttype').val();
    
      if(shifttype==1)
      {
        if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal than Time Out'); 
        return false;  
        }
       if(ti>to)
       {
        doNotify('top','center',4,'Time In can not be greater than Time Out'); 
        return false;
       }         
      }
       if(shifttype==2)
      {
        if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal than Time Out'); 
        return false;  
        }
       // if(ti<to)
       // {
        // doNotify('top','center',4,'Time Out can not be greater than Time In'); 
        // return false;
       // }        
      }
     
      $.ajax({url: "<?php echo URL;?>admin/editAttUBI",
      data: {"id":id,"ti":ti,"to":to,"date":date,"shifttype":shifttype},
      success: function(result){
        //alert(result);
        if(result==1)
        {
          datestring='&date='+$('#reportrange').text();
          // alert(datestring);
          doNotify('top','center',2,'TimeOut Updated Successfully.');
          $('#addAttATO').modal('hide');
          //table.ajax.reload();
          $('#example').DataTable().ajax.reload();
          
        }
        else
        {
          doNotify('top','center',4,'can not be updated.');
        }
        
       },
      error: function(result)
        {
          doNotify('top','center',4,'Unable to connect API');
        }
      });
    }); 

 $('#saveE').click(function(){
      var id=$('#id').val();
      var aname=$('#aname').text();
      var ti=$('#timeInE1').val();
      var to=$('#timeOutE1').val();
      var dateIn=$('#attInDateE').val();
      var dateOut=$('#attOutDateE').val();
      var shifttype=$('#shifttype').val();

      // alert(id);


     
      if(shifttype==1)
      {
       //  if(ti==to)
       //  {
        // doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        // return false;  
       //  }
       
        if(dateIn > dateOut){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
        if(dateIn==dateOut){
          if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }

        }
        if(dateIn == ''){
          doNotify('top','center',4,'Please select a value for Time In Date'); 
        return false;
        }
        if(dateOut == ''){
          doNotify('top','center',4,'Please select a value for Time Out Date'); 
        return false;
        }
        if( ti== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
         if( to== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
        // alert(fromd>tod);
        // alert(fromd);
        // alert(tod);
       // if(tidp>todp)
       // {
        // doNotify('top','center',4,'Time In can not be greater than Time Out'); 
        // return false;
       // }        
      }
       if(shifttype==2)
      {
       //  if(ti==to)
       //  {
        // doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        // return false;  
       //  }   
         if( ti== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
         if( to== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
        if(dateIn > dateOut){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
        if(dateIn == ''){
          doNotify('top','center',4,'Please select a value for Time In Date'); 
        return false;
        }
        if(dateOut == ''){
          doNotify('top','center',4,'Please select a value for Time Out Date'); 
        return false;
        }
        if(dateIn==dateOut){
          if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }


        }
      }
    
    
      $.ajax({url: "<?php echo URL;?>admin/editAtt",
      data: {"id":id,"ti":ti,"to":to,"dateIn":dateIn,"dateOut":dateOut,"shifttype":shifttype,"aname":aname,"ts":ts,"ts1":ts1},
      success: function(result){

        console.log(result);
        
        if(result==1)
        {
          datestring='&date='+$('#reportrange').text();
          doNotify('top','center',2,'Attendance Updated Successfully.');
          $('#addAttE').modal('hide');
          $('#example').DataTable().ajax.reload();
        }
        else if(result== 22)
              {
                doNotify('top','center',4,'TimeIn should be lesser than timeout '); 
              }
              else if(result== 111)
              {
                doNotify('top','center',4,'TimeOut should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 112)
              {
                doNotify('top','center',4,'TimeInDate should be  equal to current Date '); 
                return false;
              }
              else if(result== 114)
              {
                doNotify('top','center',4,'TimeIn should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 113)
              {
                doNotify('top','center',4,'TimeOutDate should be  equal to current Date '); 
                return false;
              }
        else
        {
          doNotify('top','center',4,'can not be updated.');
        }
       },
      error: function(result)
        {
          doNotify('top','center',4,'Unable to connect API');
        }
      });
    }); 
    
      
      $('#savesk').click(function(){
       var id=$('#id').val();
        var sid=$('#sid').val();
        var deptid=$('#deptid').val();
        var desgid=$('#desgid').val();
        var areaid=$('#areaid').val();
        var aname=$('#aname').text();
        // alert(aname);
        var areaid=$('#areaid').val();
        var tin=$('#timein').val();
        // alert(tin);
        var tout=$('#timeout').val();
        // alert(tout);
        var datein=$('#attInDateE1').val();
        var dateout=$('#attOutDateE1').val();
        var shifttype=$('#shifttype').val();


      // alert(id);
      // alert(sid);
      // alert(deptid);
      // alert(desgid);
      // alert(areaid);
      // alert(shifttype);
      // alert(tin);
      // alert(tout);
      // alert(datein);
      // alert(dateout);
      
      if(shifttype==1)
      {
        if(tin== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
        if(tout== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
       
        
        if(datein == dateout){
          if(tin==tout)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }
        

        }
        if(datein == ''){
          doNotify('top','center',4,'Please select The  Time In Date'); 
        return false;
        }
        if(dateout == ''){
          doNotify('top','center',4,'Please select The Time Out Date'); 
        return false;
        }
        
         if(tout== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
       if(datein > dateout){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
      }

      if (shifttype == 2) {
        if(tin== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
        if(tout== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
       
        
        if(datein == dateout){
          if(tin==tout)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }
        

        }
        if(datein == ''){
          doNotify('top','center',4,'Please select a value for Time In Date'); 
        return false;
        }
        if(dateout == ''){
          doNotify('top','center',4,'Please select a value for Time Out Date'); 
        return false;
        }
        
         if(tout== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
        if(datein > dateout){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
      }
      

     $.ajax({url: "<?php echo URL;?>admin/Attask",
      data: {"id":id,"tin":tin,"tout":tout,"datein":datein,"dateout":dateout,"shifttype":shifttype,"aname":aname,"sid":sid,"deptid":deptid,"desgid":desgid,"areaid":areaid,"ts":ts,"ts1":ts1},

       success: function(result){


       
       if(result==1)
        {
        
          datestring='&date='+$('#reportrange').text();
          doNotify('top','center',2,'Attendance Updated Successfully.');
          $('#addAttsk').modal('hide');
          $('#example').DataTable().ajax.reload();
        }
         else if(result== 22)
              {
                doNotify('top','center',4,'TimeIn should be lesser than timeout '); 
                return false;
              }
              else if(result== 111)
              {
                doNotify('top','center',4,'TimeOut should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 112)
              {
                doNotify('top','center',4,'TimeInDate should be  equal to current Date '); 
                return false;
              }
              else if(result== 114)
              {
                doNotify('top','center',4,'TimeIn should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 113)
              {
                doNotify('top','center',4,'TimeOutDate should be  equal to current Date '); 
                return false;
              }
      
         else
        {
          doNotify('top','center',4,'cannot be updated.');
        }
      },

       error: function(result)
        {
          doNotify('top','center',4,'Unable to connect API');
        }


      });
      
   
    
   
    
    $('#savec').click(function(){
      var id=$('#idc').val();
      var aname=$('#anamec').text();
      var ti=$('#timeInc1').val();
      var shifttype=$('#shifttypec').val();
      var dateIn=$('#attInDatec1').val();
      var dateOut='0000-00-00';
      var to='00:00:00';

      // alert(shifttype);
      // alert(id);
      // alert(dateIn);

      $.ajax({url: "<?php echo URL;?>admin/editAtt",
        data: {"id":id,"ti":ti,"to":to,"dateIn":dateIn,"dateOut":dateOut,"shifttype":shifttype,"aname":aname,"ts":ts,"ts1":ts1},
        success: function(result){
        if(result==1)
        {
          datestring='&date='+$('#reportrange').text();
          doNotify('top','center',2,'Attendance Updated Successfully.');
          $('#addAttc').modal('hide');
          $('#example').DataTable().ajax.reload();
        }
        else if(result== 22)
              {
                doNotify('top','center',4,'TimeIn should be lesser than timeout '); 
              }
              else if(result== 110)
              {
                doNotify('top','center',4,'TimeIn should be lesser than or equal to current time '); 
                return false;
              }
        else
        {
          doNotify('top','center',4,'cannot be updated.');
        }
       },
       error: function(result)
        {
          doNotify('top','center',4,'Unable to connect API');
        }

      });
      }); 
//      $('#addAttc').on('hidden.bs.modal', function () {
//     // $('#example').dataTable().reload();
//     location.reload();
});
  </script>
  <script>
$(document).ready(function(){
$(document).on("click", ".edit", function () 
  {
    $('#id').val($(this).data('id'));
    $('#aname').text($(this).data('aname'));
    $('#timeInE1').val($(this).data('timein'));
    $('#timeInE11').val($(this).data('timeInE1'));
    $('#timeInc1').val($(this).data('timein'));
    $('#timeOutE1').val($(this).data('timeout'));
    $('#timeOutE11').val($(this).data('timeOutE1'));
    $('#attInDateE').val($(this).data('tidate'));
    $('#attOutDateE').val($(this).data('todate'));
    $('#attInDateE1').val($(this).data('tidate'));
    $('#attOutDateE1').val($(this).data('todate'));
    $('#shifttype').val($(this).data('shifttype'));
    $('#attInDatec1').val($(this).data('tidate'));
    $('#shifttypec').val($(this).data('shifttype'));
    $('#anamec').text($(this).data('aname'));
    $('#idc').val($(this).data('id'));
    $('#sid').val($(this).data('sid'));
    $('#deptid').val($(this).data('deptid'));
    $('#desgid').val($(this).data('desgid'));
    $('#areaid').val($(this).data('areaid'));
  
  if($(this).data('shifttype')==1)
  {
    $('#shifttypedate').hide();
  }
  else
  {
  $('#shifttypedate').show(); 
  }
   ts=$(this).data('timein');
  ts1=$(this).data('timeout');
      setTimeout(function(){  
        $('.timepicker').timepicker({
        defaultTime: ts,
        //timeFormat: 'H:i',
                          });
   $('.timepicker1').timepicker({
        //timeFormat: 'H:i',
        defaultTime: ts1,
      });
      }, 1000);

      if($(this).data('sid')==1)
  {
    $('#shifttypedate123').hide();
  }
  else
  {
  $('#shifttypedate123').show(); 
  }
   ts=$(this).data('timein');
  ts1=$(this).data('timeout');
      setTimeout(function(){  
        $('.timepicker').timepicker({
        defaultTime: ts,
        //timeFormat: 'H:i',
                          });
   $('.timepicker1').timepicker({
        //timeFormat: 'H:i',
        defaultTime: ts1,
      });
      }, 1000);

  // var dateSelected=$(this).data('date'); 
  // $(".datepicker").datepicker
  //  ({
  //  "minDate": dateSelected ,
  //  "maxDate": "+0d",
  //  "dateFormat": 'yy-mm-dd'
  //  });
  var attdatein = $(this).data('tidate');



      
  // var dateSelected=$(this).data('date'); 
  // $(".datepicker").datepicker
  //  ({
  //  "minDate": dateSelected ,
  //  "maxDate": "+0d",
  //  "dateFormat": 'yy-mm-dd'
  //  });
  // var attdatein = $(this).data('tidate');
  
  // alert(dateSelected);
  $("#attInDateE1").datepicker
    ({
    "minDate": 0,
    "maxDate": "+0d",
    "dateFormat": 'yy-mm-dd'
    });
    var attdateout = $(this).data('todate');
    var attdateint = $(this).data('tidate');
    // alert(attdateout);
    $("#attOutDateE1").datepicker
    ({
    "minDate": 0 ,
    "maxDate": "+d",
    "dateFormat": 'yy-mm-dd'
    });
    });
});


</script>
<script>
   $("#attInDateE").datepicker
    ({
    "minDate": 0,
    "maxDate": "+0d",
    "dateFormat": 'yy-mm-dd'
    });
    var attdateout = $(this).data('todate');
    var attdateint = $(this).data('tidate');
    // alert(attdateout);
    $("#attOutDateE").datepicker
    ({
    "minDate": 0 ,
    "maxDate": "+1",
    "dateFormat": 'yy-mm-dd'
    });
   

</script>>
  <script>
  $(document).ready(function(){
   $(document).on("click", ".editATT", function () 
  {
    $('#id').val($(this).data('id'));
    $('#timeOutE').val($(this).data('timeout'));
    $('#attDateE').val($(this).data('date'));
    $('#shifttype').val($(this).data('shifttype'));
  
  if($(this).data('shifttype')==1)
  {
    $('#shifttypedate').hide();
  }
  else
  {
  $('#shifttypedate').show(); 
  }
   
  
     ts=$(this).data('ti');
  ss=$(this).data('timeout');
      setTimeout(function(){ 
   $('.timepicker2').timepicker({
        defaultTime: ss,
      });
      $('.timepicker').timepicker({
        defaultTime: ts,
      });

      },1000);  
      
      
  var dateSelected=$(this).data('date');  
  
  $(".datepicker").datepicker
    ({
    "minDate": dateSelected ,
    "maxDate": "+0d",
     "dateFormat": 'yy-mm-dd'
    });
    });
  });
  </script> 
  
  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});  
    });
    
    });
  </script>

   <script>
    $(".pencil").click(function () 
      {
      $("input[type='file']").trigger('click');
    });
    
    </script>

    <script>
      $("#TimeInDate").datepicker
    ({
    "minDate": 0 ,
    "maxDate": "+0d",
    "dateFormat": 'yy-mm-dd'
    });
    var attdateout = $(this).data('todate');
    var attdateint = $(this).data('tidate');
    // alert(attdateout);
    $("#TimeOutDate").datepicker
    ({
    "minDate": 0 ,
    "maxDate": "+0d",
    "dateFormat": 'yy-mm-dd'
    });
    </script>



</html>