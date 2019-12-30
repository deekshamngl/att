<!DOCTYPE html>
<html lang="en">
<head>
  <title>UbiAttendance</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/styleqr2.css" />
  <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/styleqr.css" />
	 <style>
	   @media print {
        h1{page-break-after: always;}

        }

     }
	 </style>
</head>
<body> 

<div class="container" id='genQR' >
	    <div class="row">
		<?php 
		$i = 1;
		 foreach($adata['data'] as $data)
		 {
		?>
		<?php
		if($data['qrselect'] == 3)
		{
		?>
		<div class="col-sm-4" style="border:1px solid black;text-align:center;margin:20px;margin-left:90px;
		padding-top:100px;padding-bottom:56px;padding-left:60px;padding-right:60px;">
			<div style="font-size:20px">
			<b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b><br/>
			<?= $data['name'] ?>
			</div>
			<?=$data['code'] ?>
			<div style="color:#4C4C4C;">
				<?= $data['designation']; ?><br/>
				<?= $data['department']; ?><br/>
				<?= $data['shiftname'];   ?>(<?= $data['shift']; ?>)
			</div>
			<?= $data['qrcode']; ?>
		</div>
		  <?php 
          if($i%4==0)
		  {
		  ?>  
		 </div>
		  <h1></h1>
		  <div class="row">
		<?php
		   }
		}

		elseif($data['qrselect']== 2){ ?>
				<div class="col-sm-4" style="border:1px solid black;text-align:center;margin:7px;margin-left:90px;
		padding-top:100px;padding-bottom:56px;padding-left:85px;padding-right:60px;">
		<!-- <div style="position:relative;"> -->
		<div id="dytaa_qrCard">
              
                <!-- top side card -->
                <div id="dytaa_topSide">
			
			

                      <!-- companys name  -->
                <div id="dytaa_company_name" style="color:white;">
                        <b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b>     
                </div>

                    <!-- user circle image -->
                    <div id="dytaa_image_circle">
                             <!-- <img id="profile2" width="60px" height="60px" style="border-radius: 50%;
                 border-width:5px;"src=""  alt="user profile image"> -->
                <img src="<?php echo IMGURL3."uploads/".$_SESSION['orgid']."/"?><?= $data['profile'] ?> " width="60px" height="60px" style="border-radius: 50%;
                 border-width:5px;"src=""  alt="user profile image" id="profile2">
                    </div>

                    <!-- username -->
                    
                            <label for="user_name" style="font-weight: 600" ><span class="firstname2" id="firstName2"><?= $data['firstname']?></span> <span class="lastname2" id="lastName2" style="font-weight: 700"><?= $data['lastname']?></span></label>    </br> 
                        
    
                        <!-- user designation -->
                        <div id="dytaa_designation">
                            <label for="designation" style="font-weight: 400" > <span class="id1" id="desgName1"  style="font-weight: 700"><?= $data['designation']; ?></span></label> </br>    
                        </div>
    
                        <!-- User ID -->
                         <div id="dytaa_empid">
                            <label for="empid" style="font-weight: 800" ><span class="empecode1" id="empecode1"><?= $data['code'] ?></span></label>  </br>   
                        
    						</div>

                         <!-- qr code -->
                         
                   <div id="dytaa_qrcode_rectangle_dotted">
                    <div id="dytaa_qrcode_rectangle_line">
                     <img id="qrcode123" width="75px" height="75px" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8" alt="">
                    </div> 

                 </div>
            

                 <!-- company's email website -->
                 <div id="dytaa_company_website">
                         <label for="title"><span id="web1234" class="web1234">
                         	<?= $data['web'] ;?> </span></label>   
                          </div> 
                         	</div> 
                     </div>
                  </div>
		<?php }
		elseif($data['qrselect']== 1){?>
			<div class="col-sm-6"  style="border:1px solid black;text-align:center;margin:10px;margin-left:282px;
		padding-top:148px;padding-bottom:132px;padding-left:184px;padding-right:60px;">

				<div id="dayt_qrCard1"  style="margin-left:-93px;margin-top:-123px;height:200px;">

                <!-- left side card blue -->
                <div id="dayt-leftSide"  >

                    <!-- user circle image -->
                    <div id="dayt-image_circle">
                    	<!-- <span class="profile" id="profile"></span> -->
                        <img id="profile1" src="<?php echo IMGURL3."uploads/".$_SESSION['orgid']."/"?><?= $data['profile'] ?>" width="60px" height="60px" style="border-radius: 50%;
   							 border-width:5px;">
                    </div>

                    <!-- username -->
                    <div id="dayt-user_name">
                        <label for="user_name" style="font-weight:600;"><span class="firstname" id="firstName1"><?= $data['firstname']?></span> <span class="lastname" id="lastName1" style="font-weight: 700"><?= $data['lastname']?></span></label>     
                    </div>

                    <!-- user designation -->
                    <div id="dayt-designation">
                        <label for="designation" style="font-weight: 400" ><span class="id" id="desgName"><?= $data['designation']?></span></label>     
                    </div>

                    <!-- User ID -->
                    <div id="dayt-empid">
                        <label for="empid" style="font-weight: 400" ><span class="empecode" id="empecode"><?= $data['code']?></span></label>     
                    </div>
                    

                    <!-- user details email, address, phone number-->
                    <div id="dayt-user_details">
                        <div id="dayt-email_id">
                            <!-- <img id="email_icon" src="email.svg" alt=""> -->
                            <label for="email_id"><span class="email" id="email1"><?= $data['email']; ?></span></label>
                        </div>
                        <div id="dayt-phone_no">
                                <!-- <img id="phone_no_icon" src="phone-call.svg" alt=""> -->
                                <label for="phone_no"><span class="mobile" id="mobile1"><?= $data['mobile']; ?></span></label>
                            </div>
                            <div id="dayt-address">
                                    <!-- <img id="address_icon" src="location.svg" alt=""> -->
                                    <label for="address"><span class="address" id="address1"><?= $data['city']; ?></span></label>
                                </div>
                    </div>
                </div>

                <!-- right side card  -->
                <div id="dayt-rightSide">

                    <!-- companys name  -->
                    <div id="dayt-company_name">
                       <label for="title"><b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b></label>     
                    </div>


                    <!-- qr code -->
                    <div id="dayt-qrcode_rectangle_dotted">
                       <div id="dayt-qrcode_rectangle_line">
                        <img id="qrcode111" width="75px" height="75px" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8" alt="">
                       </div> 
                    </div>

                    <!-- company's email website -->
                    <div id="dayt-company_website">
                            <label for="title"><span id="web123" class="web123"><?= $data['web']; ?></span></label>     
                         </div>
                </div>
               
            </div>


	</div>
		<?php } 
		elseif($data['qrselect']== 4){ ?>

         <div  style="margin:10px;margin-left:47px;padding-bottom:10px;margin-top:7.5px;padding-top: 5px;
    padding-left: 40px;">
        <!-- <div class="modal-content print" style="border:2px solid black;width: 295px;height:470px;  -webkit-print-color-adjust:exact;"> -->

<div style="border : 3px solid black;border-radius: 5px;width: 295px; height: 470px;">
<div class="container" style="background-color: #D2E18C; -webkit-print-color-adjust: exact ;font-family: Arial black, Helvetica, sans-serif;">

<table>
  <tr>
    <td>
      <img src="<?=URL?>../assets/img/a.jpeg" style="width: 65px;height: 70px;">
    </td>
    <td style="color: #096340 ;text-align: center;">
            <p style="margin-top: 4px;font-weight: 800;font-size: 32px;">AHMADIYYA</p>
            <p style="margin-top: -26px;font-weight: 600;font-size: 22px;">MUSLIM JAMA'AT</p>
            <p style="font-weight: 600;margin-top: -20px;font-size: 23px;margin-left: -25px;">NIGERIA</p>
    </td>
  </tr>
</table>
</div>
 <div style="background-color: #0D6241;-webkit-print-color-adjust: exact ;padding-left: 40px;color: white;font-family: Arial, Helvetica, sans-serif;height: 40px;">
      <h3 style="padding-top: 7px;font-size: 25px;">MEMBER ID CARD</h3>
    </div>

<!-- </div>
</div> -->

          <strong>
          <!-- <div style="width:240px;">
            <img src ="<?=URL?>../assets/img/jalsa.png"  style="margin-top: -37px;
    margin-left: 0px;height:240px ;width:210px">
          </div> -->
         <center>
         
         
            <p style="color:#000;font-size:14px;">www.alislam.org | www.ahmadiyya.ng</p>
          <!-- <div style="margin-top:80%;">
            <label for="user_name" style="font-weight: 600" > <span class="lnamejal" id="lNamejal" style="font-weight: 700"></span><span class="fnamejal" id="fnamejal"></span></label>
          </div> -->
          <div style=" font-weight:bold;font-size: 18px;"><span class="lnamejal" id="lNamejal"><?= $data['lastname']?></span>
          <span class="fnamejal" id="fNamejal"><?= $data['firstname']?></span></br>
          <!-- <div><span class="empecodejal" id="empecodejal"></span></div> -->
          <span style="color:#000" class="idjal" id="deptNamejal"><?= $data['department']; ?></span></br>
           <span style="color:#000" class="idjal" id="desgName23"><?= $data['designation']?></span></br>
         
            <span class="idjal" id="shiftnamejal"><?= $data['shiftname'];?></span></div>
            <!-- <b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b> -->
            <!-- <div><span class="id" id="shiftname23"></span></div> -->
        </center>

        </strong>
        <center>
          <div style="margin-bottom:12%;"><?= $data['qrcode']; ?>
        </div>
        </center>

</div>

   
  </div>
      <?php 
          if($i%4==0)
      {
      ?>  
     </div>
      <h1></h1>
      <div class="row">



			<?php 
		}
}
    else {
      echo "not found";
		
		   $i++;
		   }
    }
		?>
			</div>
  
  
  
    <center><button class="btn btn-warning nonPrintable" onclick="printDiv('genQR')" value="print a div!" data-dismiss="modal" style="margin-top:10px;">Print</button></center>
</div>
<br>
<br>

</body>
<script>
	  function printDiv(genQR) 
	  {
			window.print();
	  }
	 </script>
</html>