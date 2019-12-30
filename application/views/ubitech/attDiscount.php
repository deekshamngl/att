<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>ubiAttendance</title>
    <style>
    	.form-group label {
    margin-top: 14px;
    }
    </style>
  </head>
  <body>
    <div class="wrapper">
    <?php
      $data['pageid']=121.3;
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
                  <h4 class="title">Promotional Discount</h4>
                  <p class="category"></p>
                  <div class="nav-tabs-wrapper">
                    <h6 class="nav-tabs-title">
                      <button class="btn btn-sm btn-primary" class="hide1" readonly id="path"  data-background-color="purple" type="button" style="float:right;margin-top: -20px;" >
                        Edit
                        <div class="ripple-container"></div>
                      </button>
                      <button style="display:none;float: right;margin-top: -20px;" data-background-color="purple" class="btn btn-sm btn-primary" readonly class="hide1"  id="Edit_path" 
					  type="button">Done</button>
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
                    <!--<div class="col-sm-2">
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
                          <label for="inputsm" style="color:black;"><?=$res[0]['plan'];?> <b>(</b><?=$res[0]['curr'];?><b>)</b></label>
                        </div>
                      </div>
                  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="discount1" value="<?=$res[0]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="start1" value="<?= $res[0]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="end1" value="<?= $res[0]['end'];?>">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" disabled id="status1">		<option value="1" <?php if($res[0]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[0]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;"> <?=$res[1]['plan'];?> <b>(</b><?=$res[1]['curr'];?><b>)</b> </label>
                         
                        </div>
                      </div>
                 
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="discount2" value="<?=$res[1]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="start2" value="<?=$res[1]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="end2" value="<?=$res[1]['end'];?>" >
                        </div>
                      </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" disabled id="status2">	  <option value="1" <?php if($res[1]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[1]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black; margin-top:10px;"> <?=$res[2]['plan'];?> <b>(</b><?=$res[2]['curr'];?><b>)</b> </label>
                        </div>
                      </div>
                 
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="discount3" value="<?=$res[2]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="start3" value="<?=$res[2]['start'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="end3" value="<?=$res[2]['end'];?>" >
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" disabled id="status3">	  <option value="1" <?php if($res[2]['sts']=='1') echo "selected"; ?>  >Active</option>
                          <option value="0"  <?php if($res[2]['sts']=='0') echo " selected"; ?> >Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="inputsm" style="color:black;" class="form-contol"> <?= $res[3]['plan']; ?><b>(</b><?=$res[3]['curr'];?><b>)</b> </label>
                        </div>
                      </div>
                  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="number" style="width:100px" class="hide1 form-control" readonly id="discount4" value="<?=$res[3]['discount'];?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="start4" value="<?=$res[3]['start'];?>" >
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <input type="date" style="width:130px" class="hide1 form-control" readonly id="end4" value="<?=$res[3]['end'];?>">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <select  class="hide1 form-control" style="width:120px" disabled id="status4">	  <option value="1" <?php if($res[3]['sts']=='1') echo "selected"; ?>  >Active</option>
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
     $(".hide1").attr("disabled", false); 
    
    $('#Edit_path').show();
    $('#path').hide();
    
    });
    
    $('#Edit_path').click(function(){
		
    var discount1 = $('#discount1').val();
    var start1 = $('#start1').val();
    var end1 = $('#end1').val();
    var status1 = $('#status1').val();
    
    var discount2 = $('#discount2').val();
    var start2 = $('#start2').val();
    var end2 = $('#end2').val();
    var status2 = $('#status2').val();
    
    var discount3 = $('#discount3').val();
    var start3 = $('#start3').val();
    var end3 = $('#end3').val();
    var status3 = $('#status3').val();
    
    var discount4 = $('#discount4').val();
    var start4 = $('#start4').val();
    var end4 = $('#end4').val();
    var status4 = $('#status4').val();
    
   
    
    
      $.ajax({url: "<?php echo URL ?>/ubitech/updateDiscountPackages",
       data: {
    'discount4':discount4,
    'end4':end4,
    'start4':start4,
    'status4':status4,
    
     'discount3':discount3,
    'end3':end3,
    'start3':start3,
    'status3':status3,
    
     'discount2':discount2,
    'end2':end2,
    'start2':start2,
    'status2':status2,
    
     'discount1':discount1,
    'end1':end1,
    'start1':start1,
    'status1':status1,
    
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