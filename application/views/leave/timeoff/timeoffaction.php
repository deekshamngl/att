<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ubiattendance |Timeoff Approval</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
    <link href="<?=URL?>../assets/css/demo.css" rel="stylesheet" />
    
    
    
  
  <!-- ============================================================================= -->

 
   
  
  
  
  
  
  
  
 
  


  <!-- ============================================================================= -->
   <script src="<?=URL?>../assets/js/custom.js" type="text/javascript"></script>
   <script src="<?=URL?>../assets/js/demo.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-notify.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
   <link href="<?=URL?>../assets/css/css.css" rel="stylesheet" />
   <link href="<?=URL?>../assets/css/material-dashboard.css" rel="stylesheet"/>
   <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<!-- <?php var_dump($appsts); ?> -->


  <!-- <?php 
// var_dump($approverresult);
// var_dump($orgid);
// var_dump($uid);
// var_dump($timeoffid);
// var_dump($ptoff);

?> --> 
  <?php  
  if($ptoff==3 and $ptoff !=5){
  if($approverresult == 2) {
// var_dump($approverresult);
  
echo '
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <form method="post" id="chkapp">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Remarks for Approving Timeoff</h4>
        </div>
        <div class="modal-body">
        <input type="hidden" id="uid1" value="'.$uid.'">
        <input type="hidden" id="orgid1" value="'.$orgid.'">
        <input type="hidden" id="timeoffid1" value="'.$timeoffid.'">
        <input type="hidden" id="approverresult1" value="'.$approverresult.'">
      
          <textarea class="form-control" rows="4" id="remark1" name="comment1" placeholder="Please enter your remarks here"></textarea>
        </div>
        <div class="modal-footer">
        <a  id="timeoff2" class="btn btn-success" >Approve</a>
      </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
        </form>
      </div>
      
    </div>
  </div>
  
</div>';
}
elseif($approverresult == 1) {
// var_dump($approverresult);
  echo'

<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <form method="post" id="chkrej">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Remarks for Rejecting Timeoff</h4>
        </div>
        <div class="modal-body">
        <input type="hidden" id="uid" value="'.$uid.'">
        <input type="hidden" id="orgid" value="'.$orgid.'">
        <input type="hidden" id="timeoffid" value="'.$timeoffid.'">
        <input type="hidden" id="approverresult" value="'.$approverresult.'">
      
          <textarea class="form-control" rows="4" id="remark" name="comment" placeholder="Please enter your remarks here"></textarea>
        </div>
        <div class="modal-footer">
        <a  id="timeoff1" class="btn btn-danger" >Reject</a>
      </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
        </form>
      </div>
      
    </div>
  </div>
  
</div>';

 }
}
else{

// $sql1 = "select * from TimeoffApproval WHERE TimeofId=?";
            // $query1 = $this->db->query($sql1,array( $timeoffid));
            // $query1->execute(array( $timeoffid));
            
            if($ptoff == 1){

              echo '<div style="text-align:center; font-weight:bold; margin-top:50px; font-size:30px;" >Timeoff has already been Rejected. </div>
              ';
            }
            elseif($ptoff == 2){
              echo '<div style="text-align:center; font-weight:bold; margin-top:50px; font-size:30px;" >Timeoff has already been Approved. </div>';
            }
            elseif($ptoff == 5){
              echo '<div style="text-align:center; font-weight:bold; margin-top:50px; font-size:30px;" >Timeoff has been Withdrawn. </div>';
            }
            
            else{
              echo '<div style="text-align:center; font-weight:bold; margin-top:50px; font-size:30px;" > Not Found </div>';
            }
              
              
  
}
 
?>

<!-- <?php var_dump($arr); ?>  -->


<script type="text/javascript">
   
    
$('#myModal').modal({
    backdrop: 'static',
    keyboard: false
})
$('#myModal1').modal({
    backdrop: 'static',
    keyboard: false
})
 // $('#myModal1').on('shown.bs.modal', function() {
 //        $(document).off('focusin.modal');
 //    });

 // $(document).on("click", "#timeoff1", function (){
           
            
 //        var uid=$('#uid').val(); 
 //        // alert(uid);
 //        var remark=$('#remark').val(); 

 //        $.ajax({url: "<?php echo URL;?>Login/timeoffstatus",
 //            data: {"id":uid, "ApproverComment":remark},

 //            success: function(result){
              
 //              if(result == 1){
 //                 $('#myModal1').modal('hide');
 //                 doNotify('top','center',3,'Timeoff has been Rejected Successfully.'); 
 //                 table.ajax.reload();  
 //                  }
 //                            if(result == 2)
 //              {
 //                doNotify('top','center',4,"This user has admin permission Its can not be delete."); 
 //              }
 //                 alert(uid);                        
 //             },
 //            error: function(result){
 //              doNotify('top','center',4,'Unable to connect API');
              
 //             }
 //           });
 //      });
      
    
</script>

<script>
  // var ptoff = "<?php echo $ptoff ?>" ;
  // alert(ptoff);

$('#timeoff1').click(function(){
  // $('#myModal1').modal('hide');
              // var id=$('#uid').val();

             var comment=$('#remark').val();
             var uid=$('#uid').val();
             var orgid=$('#orgid').val();
             var timeoffid=$('#timeoffid').val();
             var approverresult=$('#approverresult').val();
             // alert(comment);
             // alert( uid);
             // alert(orgid);
             // alert(timeoffid);
             // alert(approverresult);
             // var comment = $.trim($("#remark").val());
             
           // var sts=$('#timoffstatusE').val();
           
          
         
           $.ajax({url: "<?php echo URL;?>Login/approvetimeoffapprovalreject",
            data: {"remark":comment,"uid":uid,"orgid":orgid,"timeoffid":timeoffid,"approverresult":approverresult},
            type:"post",
            success: function(result){
              // alert(result);
              if(result==1){
                doNotify('top','center',2,'Timeoff has been Rejected successfully...');
                // alert("Timeoff has been Rejected successfully..");
                $('#myModal1').modal('hide');
                // document.getElementById('timeoffE').reset();
                 table.ajax.reload();
              }else if(result==2){
                // $('#myModal1').modal('hide');
                doNotify('top','center',3,'Timeoff has not been updated...');
                // alert("Timeoff has not been updated...");
              }
              else{
              doNotify('top','center',4,'No Changes Found');
              // alert("No Changes Found");
              // document.getElementById('timeoffE').reset();
                $('#myModal1').modal('hide');
              }
             },
            error: function(result){
              doNotify('top','center',4,'Unable to connect API');
              // alert("Unable to connect API");
             }
           });
      });


  
     

$('#timeoff2').click(function(){
  // $('#myModal1').modal('hide');
              // var id=$('#uid').val();

             var comment1=$('#remark1').val();
             var uid1=$('#uid1').val();
             var orgid1=$('#orgid1').val();
             var timeoffid1=$('#timeoffid1').val();
             var approverresult1=$('#approverresult1').val();
             

             // alert(comment1);
             // alert( uid1);
             // alert(orgid1);
             // alert(timeoffid1);
             
             // var comment = $.trim($("#remark").val());
             
           // var sts=$('#timoffstatusE').val();
           
          
         
           $.ajax({url: "<?php echo URL;?>Login/approvetimeoffapprovalapprove",
            data: {"remark1":comment1,"uid1":uid1,"orgid1":orgid1,"timeoffid1":timeoffid1,"approverresult1":approverresult1},
            type:"post",
            success: function(result){
              // alert(result);
              
              if(result==1){
                doNotify('top','center',2,'Timeoff has been Approved successfully...');
                // alert("Timeoff has been Approved successfully..");
                $('#myModal').modal('hide');
                // document.getElementById('timeoffE').reset();
                 table.ajax.reload();
              }else if(result==2){
                // $('#myModal1').modal('hide');
                doNotify('top','center',3,'Timeoff has not been updated...');
                // alert("Timeoff has not been updated");
              }
              else{
              doNotify('top','center',4,'No Changes Found');
              // alert("No Changes Found");
              // document.getElementById('timeoffE').reset();
                $('#myModal').modal('hide');
              }
            
             
             },
            error: function(result){
              doNotify('top','center',4,'Unable to connect API');
              // alert("Unable to connect API");
             }
           });
      });







  </script>
 



</body>
</html>