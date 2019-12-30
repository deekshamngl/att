<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/github.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/standalone.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Default</title>
     <style>
    
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
        $data['pageid']=7777;
        $this->load->view('menubar/sidebar',$data);
        $data=isset($data)?$data:'';
      ?>
      <div class="main-panel">
        <?php
          $this->load->view('menubar/navbar');
          ?>
        </br>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                   <?php foreach ($imgstatus as $row) {
                     if($row->image_status =='1'){

                                        ?>
                  <div class="card-header" data-background-color="green" >
                   
                  <!--  <h4 class="title">Attendance</h4> -->
                   <p class="category" style="color:#ffffff;font-size:17px;" > Attendance Picture</p>
                    <!-- <p class="category" style="color:#ffffff;font-size:17px;" >Helppage </p> -->
                    <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                    <i class="fa fa-question"></i></a>
                  </div>
                  <div id="typography">
                      <br>
                      <br>
                    
  
  <?php foreach(@$attvisit as $attvisit){
                        ?>  
                      <div class="row" style="min-height: 200px;margin-left:10px;" >
               <div class="col-sm-3 col-md-3" ></div>
               <div style="margin-left:50px;" class="col-sm-10 col-md-11 pull-left"  >
               <p class="category pull-left" style="font-size:17px;" >Enable Picture For Time In & Time Out ? </p>
            </div>
            <br>
                        <form id="alertmsg">
                          <div class="col-sm-2 col-md-1"></div>
                          <div class="col-sm-4 col-md-4 col-xs-12" style="margin:0px;">
                            <div class="radio input-group">

                              <label class="radio-inline" style="color: #7d8088;">
                              <input  type="radio" name="attopt" value="1" id="ena" <?php echo @$attvisit->AttnImageStatus == 1 ? "checked" : "";?>>Yes
                              </label>
                              <label class="radio-inline" style="color:#7d8088">
                              <input type="radio" name="attopt" value="0" 
                <?php echo @$attvisit->AttnImageStatus == 0 ? "checked" : "";?>>No
                              </label>
                              
                            </div>
                          </div>
                          
                          <div class="col-sm-1 col-md-1 col-xs-12"> 
                            <button type="button" id="btnattset" class="btn btn-success" style="margin:0;padding:10px 29px;font-size:12px;margin-left: -176px;">Update</button>
                          </div>
                        </form>
                      </div>
             
            <?php
                         break;  
             
                            }
                          ?>
                    </div>
                     <hr/>   
      <div class="card-header" data-background-color="green">
                      <p class="category" style="color:#ffffff;font-size:17px;" >Visit Picture</p>
                    </div>
                    <?php foreach(@$datavisit as $datavisit){
                        ?>  
                      <div class="row" style="min-height: 200px;margin-left:10px;" >
               <div class="col-sm-3 col-md-3" ></div>
               <div style="margin-left:50px;margin-top: 30px;" class="col-sm-10 col-md-11 pull-left"  >
               <p class="category pull-left" style="font-size:17px;" >Enable Picture For Visit In & Visit Out? </p>
            </div>
            <br>
                        <form id="alertmsg">
                          <div class="col-sm-2 col-md-1"></div>
                          <div class="col-sm-4 col-md-4 col-xs-12" style="margin:0px;">
                            <div class="radio input-group">
                              <label class="radio-inline" style="color: #7d8088;">
                              <input  type="radio" name="visitopt" value="1" id="ena" <?php echo @$datavisit->visitImageStatus == 1 ? "checked" : "";?>>Yes
                              </label>
                              <label class="radio-inline" style="color:#7d8088">
                              <input type="radio" name="visitopt" value="0" <?php echo @$datavisit->visitImageStatus == 0 ? "checked" : "";?>>No
                              </label>
                              
                            </div>
                          </div>
                          <div class="col-sm-1 col-md-1 col-xs-12"> 
                            <button type="button" id="btnvisitset" class="btn btn-success" style="margin:0;padding:10px 29px;font-size:12px;margin-left: -176px;">Update</button>
                          </div>
                          
                        </form>
                      </div>
                       <?php
                         break;  
                            }
                          ?>
                        <?php } }  ?>


  <hr/>
  <div class="card-header" data-background-color="green">
                      <p class="category" style="color:#ffffff;font-size:17px;" >Geo Fence Policy</p>
                    </div>
                    <?php foreach(@$outfence as $outfence){
                        ?>  
                      <div class="row" style="min-height: 200px;margin-left:10px;" >
               <div class="col-sm-3 col-md-3" ></div>
               <div style="margin-left:50px;margin-top: 30px;" class="col-sm-10 col-md-11 pull-left"  >
               <p class="category pull-left" style="font-size:17px;" >Restrict users to mark attendance from GeoFence area? </p>
            </div>
            <br>
                        <form id="alertmsg">
                          <div class="col-sm-2 col-md-1"></div>
                          <div class="col-sm-4 col-md-4 col-xs-12" style="margin:0px;">
                            <div class="radio input-group">
                              <label class="radio-inline" style="color: #7d8088;">
                              <input  type="radio" name="fenceopt" value="1" id="ena" <?php echo @$outfence->fencearea == 1 ? "checked" : "";?>>Yes
                              </label>
                              <label class="radio-inline" style="color:#7d8088">
                              <input type="radio" name="fenceopt" value="0" <?php echo @$outfence->fencearea == 0 ? "checked" : "";?>>No
                              </label>
                              
                            </div>
                          </div>
                          <div class="col-sm-1 col-md-1 col-xs-12"> 
                            <button type="button" id="btnfenceset" class="btn btn-success" style="margin:0;padding:10px 29px;font-size:12px;margin-left: -176px;">Update</button>
                          </div>
                          
                        </form>
                      </div>
             
            <?php
                         break;  
                            }
                          ?>


                        </hr>
              </div>
          </div>
      </div>

      
  </div>
</div>
   <div class="col-md-3 t2" id="sidebar" style=" margin-top:100px;"></div>
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


</div>
</div>



</body>
  <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
            <div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
            <div id="sidenavData" class="sidenavData">
            </div>
          </div>

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
  <script>
  var a='<?php echo @$dat->Status; ?>';
  if(a==0)
  {
    $('#time').val('');
    document.getElementById('time').disabled=true;
  }
  else
  {
  document.getElementById('time').disabled=false;
  }
</script>

  <script>
            function openNav() 
            {
              document.getElementById("mySidenav").style.width = "360PX";
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'selfie'});  
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
  
  </script>
    <script type="text/javascript">
    $(document).ready(function() {  
  $('#time').val('<?=$time;?>');
    $('#btnset').click(function(){
    var time = $('#time').val();
    var enable = $('input[name=opt]:checked').val();
    $.ajax({
    url: "<?php echo URL;?>dashboard/alertsubmission",
    data:{"sts":enable,"time":time},
    success:function(result){
    if(result == "true"){
      doNotify('top','center',2,'Added Successfully.');
    }else{
      doNotify('top','center',2,'Alert permission Updated successfully.');
    }
    },
    error: function(result){
        doNotify('top','center',4,'Unable to connect API');
       }
    });
    });
    
    $('.clockpicker').clockpicker({
    
    placement: 'bottom',  // clock popover placement
    align: 'left',        // popover arrow align
    donetext: 'Done',     // done button text
    autoclose: false,    // auto close when minute is selected
    vibrate: true        // vibrate the device when dragging clock hand
    
    });
  
    
    });
  </script>
  
  <script>
  $(document).ready(function() {  
    $('#btnfenceset').click(function()
  {
    var enablevisit = $('input[name=fenceopt]:checked').val();
    $.ajax({
    url: "<?php echo URL;?>dashboard/fencestatus",
    data:{"sts":enablevisit},
    success:function(result){
    if(result == "true"){
      doNotify('top','center',2,'Added Successfully.');
    }else
  {
      doNotify('top','center',2,'Fence area permission updated successfully');
    }
    },
    error: function(result){
        doNotify('top','center',4,'Unable to connect API');
       }
    });
    });
    
    });   
      </script>
      <script>
  $(document).ready(function() {  
    $('#btnvisitset').click(function()
  {
    var enablevisit = $('input[name=visitopt]:checked').val();
    $.ajax({
    url: "<?php echo URL;?>dashboard/visitstatus",
    data:{"sts":enablevisit},
    success:function(result){
    if(result == "true"){
      doNotify('top','center',2,'Added Successfully.');
    }else
  {
      doNotify('top','center',2,'Visit image updated successfully');
    }
    },
    error: function(result){
        doNotify('top','center',4,'Unable to connect API');
       }
    });
    });
    
    });   
      </script>
      
      <script>
  $(document).ready(function() {  
    $('#btnattset').click(function(){
    var enableatt = $('input[name=attopt]:checked').val();
    $.ajax({
    url: "<?php echo URL;?>dashboard/attstatus",
    data:{"sts":enableatt},
  
    success:function(result){
    if(result == "true")
      {
        doNotify('top','center',2,' Added successfully');
      }
    else
      {
        doNotify('top','center',2,'Attendance image updated successfully');
      }
    },
    error: function(result)
      {
        doNotify('top','center',4,'Unable to connect API');
      }
    });
    });
    
    });   
      </script>
<script>
  $(function(){
  $('input[type="radio"]').click(function(){
    {
     if($(this).val()==0)
  {
  document.getElementById('time').disabled=true;
  }
  else
  {
  document.getElementById('time').disabled=false;
  }
    }
  });
});
  </script>
  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'selfie'}); 
    });
    
    });
  </script>

</html>