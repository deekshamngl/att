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
        $data['pageid']=12.3;
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
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                  <p class="category" style="color:#ffffff;font-size:17px;" >Alert</p>
                    <!-- <p class="category" style="color:#ffffff;font-size:17px;" >Helppage </p> -->
                    <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                    <i class="fa fa-question"></i></a>
                  </div>
                  <div id="typography">
                      <br>
                      <br>
                     
                      <?php foreach(@$data as $dat){
              $time=@$dat->Time;
                        ?>  
                      <div class="row" style="min-height: 200px;margin-left:10px;" >
               <div class="col-sm-3 col-md-3" ></div>
               <div style="margin-left:50px;" class="col-sm-10 col-md-11 pull-left"  >
               <p class="category pull-left" style="font-size:17px;" >Mail daily attendance summary ?</p>
            </div>
            <br>
                        <form id="alertmsg">
                          <div class="col-sm-2 col-md-1"></div>
                          <div class="col-sm-4 col-md-4 col-xs-12" style="margin:0px;">
                            <div class="radio input-group">
                              <label class="radio-inline" style="color:#7d8088">
                              <input type="radio" name="opt" value="0" <?php echo @$dat->Status == 0 ? "checked" : "";?>>NO
                              </label>
                              <label class="radio-inline" style="color: #7d8088;">
                              <input  type="radio" name="opt" value="1" id="ena" <?php echo @$dat->Status == 1 ? "checked" : "";?>>Yes
                              </label>
                            </div>
                          </div>
                          <label for="inputSuccess2" class="col-sm-2 col-xs-5 col-md-2" style="margin:20px 0 0 0;margin-left: -166px;margin-top:11px">Select time:</label>
                          <div class="col-sm-2 col-md-2 col-xs-7" style="margin-left:0px;">
                            <div class="form-group has-success has-feedback" style="margin:0px;">
              <select type="text" class="form-control" name="time" id="time" value="<?php echo @$dat->Time;?>" style="margin-left: -81px;margin-top: -6px;">
              <option >Select Time</option>
              <option value="00:00:00">00:00 - 01:00</option>
              <option value="01:00:00">01:00 - 02:00</option>
              <option value="02:00:00">02:00 - 03:00</option>
              <option value="03:00:00">03:00 - 04:00</option>
              <option value="04:00:00">04:00 - 05:00</option>
              <option value="05:00:00">05:00 - 06:00</option>
              <option value="06:00:00">06:00 - 07:00</option>
              <option value="07:00:00">07:00 - 08:00</option>
              <option value="08:00:00">08:00 - 09:00</option>
              <option value="09:00:00">09:00 - 10:00</option>
              <option value="10:00:00">10:00 - 11:00</option>
              <option value="11:00:00">11:00 - 12:00</option>
              <option value="12:00:00">12:00 - 13:00</option>
              <option value="13:00:00">13:00 - 14:00</option>
              <option value="14:00:00">14:00 - 15:00</option>
              <option value="15:00:00">15:00 - 16:00</option>
              <option value="16:00:00">16:00 - 17:00</option>
              <option value="17:00:00">17:00 - 18:00</option>
              <option value="18:00:00">18:00 - 19:00</option>
              <option value="19:00:00">19:00 - 20:00</option>
              <option value="20:00:00">20:00 - 21:00</option>
              <option value="21:00:00">21:00 - 22:00</option>
              <option value="22:00:00">22:00 - 23:00</option>
              <option value="23:00:00">23:00 - 24:00</option>
              </select>
                             <!--  <div class="input-group clockpicker" data-placement="bottom" data-align="bottom"
                                data-autoclose="true" style="width:80%;">
                                <input type="text" class="form-control" name="time" id="time" value="<?php echo @$dat->Time;?>" >
                                <span class="form-control-feedback"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                              </div> --->
                            </div>
                          </div>
                          <div class="col-sm-1 col-md-1 col-xs-12"> 
                            <button type="button" id="btnset" class="btn btn-success" style="margin-left: -56px;    margin-top: 0px;padding:10px 29px;font-size:12px;">Update</button>
                          </div>
                          
                        </form>
                      </div>
             
            <?php
                         break;  
                            }
                          ?>
             
            <hr/>


        
  
  
                  </div>
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
  <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
    <div class="helpHeader"><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
    <div id="sidenavData" class="sidenavData">
    </div>
  </div>
  <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src='<?=URL?>../assets/clockpicker/bootstrap-clockpicker.min.js'></script>
  <script type="text/javascript" src='<?=URL?>../assets/clockpicker/jquery-clockpicker.min.js'></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/clockpicker.js"></script>
  
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
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'alert'});  
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
      doNotify('top','center',2,'Added successfully');
    }else{
      doNotify('top','center',2,'Alert updated successfully');
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
    $('#btnvisitset').click(function()
  {
    var enablevisit = $('input[name=visitopt]:checked').val();
    $.ajax({
    url: "<?php echo URL;?>dashboard/visitstatus",
    data:{"sts":enablevisit},
    success:function(result){
    if(result == "true"){
      doNotify('top','center',2,'Added successfully');
    }else
  {
      doNotify('top','center',2,'Visit added successfully');
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
        doNotify('top','center',2,' Added successfully.');
      }
    else
      {
        doNotify('top','center',2,'Attendance image status added successfully');
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
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'alert'}); 
    });
    
    });
  </script>

</html>