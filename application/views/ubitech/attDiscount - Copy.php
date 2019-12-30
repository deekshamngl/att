<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>ubiAttendance</title>
  </head>
  <body>
    <div class="wrapper">
    <?php
      $data['pageid']=10;
      $this->load->view('ubitech/sidebar',$data);
      ?>
    <div class="main-panel">
      <?php
        $this->load->view('ubitech/navbar');
        ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header" data-background-color="purple">
                  <h4 class="title">Package</h4>
                  <p class="category">Package Setting</p>
                  <div class="nav-tabs-wrapper">
                    <h6 class="nav-tabs-title">
                      <button class="btn btn-sm btn-primary" class="hide1" readonly id="path"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >
                        Edit
                        <div class="ripple-container"></div>
                      </button>
                      <button style="display:none;float: right;margin-top: -20px;" data-background-color="purple" class="btn btn-sm btn-primary"  class="hide1" readonly id="Edit_path" type="button" >Done</button>
                    </h6>
                  </div>
                </div>
                <div class="card-content">
                  <div class="hide1" readonly id="typography">
                  
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> <b>Plan</b></label>
                        </div>
                      </div>
                    <!--  <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"><b>Currency</b></label>
                        </div> 
                      </div>-->
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> <b>Discount(%)</b></label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"><b>Start Date</b></label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"><b>End Date</b></label>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> <b>Status</b></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;">Monthly for <b>USD</b></label>
                        </div>
                      </div>
                     <!-- <div class="col-sm-2">
                        <div class="form-group">
                          <select class="hide1 form-control" readonly id="usdmonthly1">							
<option value="USD" <?php if($res[0]['curr']==='USD'): ?> selected="selected" <?php endif; ?>>USD</option>
<option value="INR" <?php if($res[0]['curr']==='INR'): ?>  selected="selected"<?php endif; ?>>INR</option>
                          </select>
                        </div>
                      </div> -->
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="usdyearly1" value="<?=$res[0]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsmonthly1" value="<?= $res[0]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsyearly1" value="<?= $res[0]['end'];?>">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" readonly id="rsyearly1">		<option value="1" <?php if($res[0]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[0]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> Yearly for <b>USD</b> </label>
                         
                        </div>
                      </div>
                    <!--  <div class="col-sm-2">
                        <div class="form-group">
                          <select class="hide1 form-control" readonly id="usdmonthly1">							
                          	<option value="USD">USD</option>
                          	<option value="INR">INR</option>
                          </select>
                        </div>
                      </div> -->
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="usdyearly2" value="<?=$res[1]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsmonthly2" value="<?=$res[1]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsyearly2" value="<?=$res[1]['end'];?>" >
                        </div>
                      </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" readonly id="rsyearly1">	  <option value="1" <?php if($res[1]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[1]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> Mothly for <b>INR</b> </label>
                        </div>
                      </div>
                    <!--  <div class="col-sm-2">
                        <div class="form-group">
                         <select class="hide1 form-control" readonly id="usdmonthly1">							
                          	<option value="USD">USD</option>
                          	<option value="INR">INR</option>
                          </select>
                        </div>
                      </div> -->
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="usdyearly3" value="<?=$res[2]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsmonthly3" value="<?=$res[2]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsyearly3" value="<?=$res[2]['end'];?>" >
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" readonly id="rsyearly1">	  <option value="1" <?php if($res[2]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[2]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> Yearly for <b>INR</b> </label>
                        </div>
                      </div>
                    <!-- <div class="col-sm-2">
                        <div class="form-group">
                         <select class="hide1 form-control" readonly id="usdmonthly1">							
                          	<option value="USD">USD</option>
                          	<option value="INR">INR</option>
                          </select>
                        </div>
                      </div> -->
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="usdyearly4" value="<?=$res[3]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsmonthly4" value="<?=$res[3]['start'];?>" >
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1" readonly id="rsyearly4" value="<?=$res[3]['end'];?>">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" readonly id="rsyearly1">	  <option value="1" <?php if($res[3]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[3]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class="container-fluid">
            <p class="copyright pull-right">
              &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
            </p>
          </div>
        </footer>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    $('#trial_setting').click(function(){
    	var days = $('#days').val();
    	$.ajax({url: "<?php echo URL;?>/ubitech/trial_days",
           data: {'days':days},
    	success: function(result){
       if(result == 'true'){
    		  doNotify('top','center',2,'days updated successfully.');
    		   setTimeout(location.reload.bind(location), 2000);
    	  }else{
    		  doNotify('top','center',4,'some error occurs.');
    		   setTimeout(location.reload.bind(location), 2000);
    		  alert('false');
    	  }
    	  
       }});
    })
    
    
    $('#path').click(function(){
     $(".hide1").attr("readonly", false); 
    
    
    $('#Edit_path').show();
    $('#path').hide();
    
    })
    
    $('#Edit_path').click(function(){
    var usdmonthly1 = $('#usdmonthly1').val();
    var usdyearly1 = $('#usdyearly1').val();
    var rsmonthly1 = $('#rsmonthly1').val();
    var rsyearly1 = $('#rsyearly1').val();
    
    var usdmonthly2 = $('#usdmonthly2').val();
    var usdyearly2 = $('#usdyearly2').val();
    var rsmonthly2 = $('#rsmonthly2').val();
    var rsyearly2 = $('#rsyearly2').val();
    
    var usdmonthly3 = $('#usdmonthly3').val();
    var usdyearly3 = $('#usdyearly3').val();
    var rsmonthly3 = $('#rsmonthly3').val();
    var rsyearly3 = $('#rsyearly3').val();
    
    var usdmonthly4 = $('#usdmonthly4').val();
    var usdyearly4 = $('#usdyearly4').val();
    var rsmonthly4 = $('#rsmonthly4').val();
    var rsyearly4 = $('#rsyearly4').val();
    
    var usdmonthly5 = $('#usdmonthly5').val();
    var usdyearly5 = $('#usdyearly5').val();
    var rsmonthly5 = $('#rsmonthly5').val();
    var rsyearly5 = $('#rsyearly5').val();
    
    var usdmonthly6 = $('#usdmonthly6').val();
    var usdyearly6 = $('#usdyearly6').val();
    var rsmonthly6 = $('#rsmonthly6').val();
    var rsyearly6 = $('#rsyearly6').val();
    
    var usdmonthly7 = $('#usdmonthly7').val();
    var usdyearly7 = $('#usdyearly7').val();
    var rsmonthly7 = $('#rsmonthly7').val();
    var rsyearly7 = $('#rsyearly7').val();
    
    
      $.ajax({url: "<?php echo URL ?>/ubitech/",
       data: {
    'usdmonthly1':usdmonthly1,
    'usdyearly1':usdyearly1,
    'rsmonthly1':rsmonthly1,
    'rsyearly1':rsyearly1,
    
    'usdmonthly2':usdmonthly2,
    'usdyearly2':usdyearly2,
    'rsmonthly2':rsmonthly2,
    'rsyearly2':rsyearly2,
    
    'usdmonthly3':usdmonthly3,
    'usdyearly3':usdyearly3,
    'rsmonthly3':rsmonthly3,
    'rsyearly3':rsyearly3,
    
    'usdmonthly4':usdmonthly4,
    'usdyearly4':usdyearly4,
    'rsmonthly4':rsmonthly4,
    'rsyearly4':rsyearly4,
    
    'usdmonthly5':usdmonthly5,
    'usdyearly5':usdyearly5,
    'rsmonthly5':rsmonthly5,
    'rsyearly5':rsyearly5,
    
    'usdmonthly6':usdmonthly6,
    'usdyearly6':usdyearly6,
    'rsmonthly6':rsmonthly6,
    'rsyearly6':rsyearly6,
    
    'usdmonthly7':usdmonthly7,
    'usdyearly7':usdyearly7,
    'rsmonthly7':rsmonthly7,
    'rsyearly7':rsyearly7	
    },
    success: function(result){
           if(result == 1){
    	  doNotify('top','center',2,'Package updated successfully.');
    		   setTimeout(location.reload.bind(location), 1000);
    	  }else{
    		  doNotify('top','center',4,'some error occurs.');
    		  setTimeout(location.reload.bind(location), 2000);
    		 // alert('false');
    	  }
       }});
    }) 
  </script>
</html>