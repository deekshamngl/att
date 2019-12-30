<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		div.dt-buttons{
position:relative;
float:left;
margin-left:15px;
}
		
		      #example thead tr th.headerSortUp  {
               background-image: url('<?=URL?>../assets/img/up_arrow.png');
              }
              #example thead tr th.headerSortDown  {
              background-image: url('<?=URL?>../assets/img/down_arrow.png');
             }
			 #example tbody tr td.lalign {
             text-align: left;
                   }
				   .id{
					   color:grey;
				   }
				  
	.t2{display:none;}
	</style>
	<style type="text/css" media="print" >
 .print {
	
      margin-left:40px;
     align:center;
	 border:2px #666 solid; padding:5px;  
}

          .nonPrintable
		  {display:none;} /*class for the element we don�t want to print*/
         </style>
  <style>
  .h5, h5{
	margin-bottom: 2px;
}

	.heading {
		background-color:rgba(163, 175, 183, 0.58);
		color:#526069;
		padding: 6px;
	}
 .wizard {
    margin: 20px auto;
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
		border-bottom: 0px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 70%;
    margin: 0 auto;
	margin-top:-18px;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}



span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #43a047;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#fff;
}




.wizard .nav-tabs > li {
    width: 25%;
}
.wizard .nav-tabs > li > a{
    border: 0px;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}



.wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
}

   

.wizard .tab-pane {
    position: relative;
    padding-top: 50px;
}

.wizard h3 {
    margin-top: 0;
}

@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
}

	</style>		 
		 
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=$pageid;
			if($pageid == 2)
			$pagename = 'Userprofiles';
		    else
			  $pagename = 'Userprofiles/addemployee';	
		  
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
		
  	     <div class="content" id="content">
		  <div id = "loader" hidden >
		    <center>
			 <img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
			</center>
		  </div>
	        <div class="container-fluid" id="maincontainerdiv" >
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <h4 class="title">Import Employees </h4>
	                                <p class="category"> </p>
	                           </div>
	                    <div class="card-content">
    <div class="panel panel-default" id="login-form" style="display:block">
        <div class="panel-heading">Import Employees</div>
        <div class="panel-body" style="min-height: 400px;" >		
		 <form id="upload_csv" method="post" enctype="multipart/form-data">
		    
			    <h3 style="text-align:center">Steps for Import</h3>
				<div class="wizard" style="margin-top:-30px;" >
					<div class="wizard-inner">
						<div class="connecting-line"></div>
						<ul class="nav nav-tabs" role="tablist" style="background:none" >
							<li role="presentation" class="">
								<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" style="pointer-events: none">
									<span class="round-tab">
										<i class="fa fa-folder-open"></i>
									</span>
								</a>
								<h5 class="text-center">
								1.Prepare your data for import</h5>
							</li>
							<li role="presentation" class="">
								<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2" style="pointer-events: none">
									<span class="round-tab">
										<i class="fa fa-cloud-upload"></i>
									</span>
								</a>
								<h5 class="text-center">
								2. Choose data to import</h5>
							</li>
							<li role="presentation" class="">
								<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3" style="pointer-events: none">
									<span class="round-tab">
										<i class="fa fa-exchange"></i>
									</span>
								</a>
								<h5 class="text-center">
								3.Field mapping</h5>
							</li>
							<li role="presentation" class="">
								<a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete" style="pointer-events: none">
									<span class="round-tab">
										<i class="fa fa-check"></i>
									</span>
								</a>
								<h5 class="text-center">
								4. Start import</h5>
							</li>
						</ul>
					</div><!--wizard-inner-->
				</div><!--wizard-->
			
		     <div class="col-sm-12">					
				<div class="box box-solid" style="background-color:#EFEFF8;padding:10px">
					<div class="box-header with-border">
						<h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;Points to remember</h3>
					</div> <!--box-header-->
						<div class="box-body">
						 <ol>
							<li>The format of the data in the import file will be the same as the sample file. <a href="<?php echo IMGURL5;?>newjoiningfile.csv" > Download Sample file</a></li>
							<li>The columns should be the same, in the same order as the sample file</li>
							<li>Ensure that your file size does not exceed 5 Mb. </li>
							<li>Importing should be first tried with a single employee. </li>
							<li>First row of the given file will be treated as field names.</li>
							<li>Each subsequent row corresponds to a details of an Employee.
							</li>
							
			                <li>The departments, designations and shift have to be added before the import</li>
                            <li>You must include all mandatory fields( First Name, Last Name, Phone No., Shift, Department & Designation).</li>
                             <li>There should be no duplicate Email or Phone No.</li>
                             <li>Unexpected errors may occur if the csv file contains special controls like combo filters or images embedded with in.</li>
						 </ol>
						</div>				
					</div><!-- /.box -->
			 </div>
			 
			 
			 <div class="col-sm-12">
			     <p style="color:green" >Sample File</p>
			   <img  src="<?php echo IMGURL;?>imgnewemp.PNG" alt="IMG" />
			 </div>
			 <div class="col-md-12">
			<div class="col-sm-2 col-xs-2" style="margin-left:-15px;" >
			<label class="">Select Import File(.csv)</label>
			</div>
			<div class="col-sm-10">
				<input type="file" id="fileUpload" accept=".csv" name="fileUpload" accept=".csv,text/csv"/><br>
				
			</div>
			<div style="col-sm-12">
			  <br />
			  <center>
				<input type="submit" id="btn1" class="btn btn-success btnfile call" value="Import User" disabled>
               <input type="button" class="btn btn-success" value="Close" onclick="window.location='<?= URL.$pagename?>'">
			   </center>
		    </div>
		  </div>
			
    	</form>  
          </div>		
      
	</div>
		<div  id="register-form" style="display:none">
		<form method="" action="" id="contactForm">	
		<div class="row">
					
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">First Name</label>
							<div class="col-sm-6" >
								<select class="form-control services_list services0" id="firstName">
								<option value=""></option>	
								</select>
							</div>
					</div> 
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					<label class="control-label col-sm-4" for="dept">Last Name</label>
					<div class="col-sm-6" >
						<select class="form-control services_list services1" id="lastName">
						<option value=""></option>
						</select>
					</div>
					</div>
				</div>	
		</div>
		<div class="row"> 
	<div class="col-sm-6">
			<div class="form-group">
				<label class="control-label col-sm-4" for="dept">Email Id</label>
					<div class="col-sm-6" >
						<select class="form-control services_list services2" id="email" name="">
							<option value=""></option>
						</select>
					</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
			<label class="control-label col-sm-4" for="shift">Contact Number</label>
				<div class="col-sm-6" >
					<select class="form-control services_list services3" id="cont" name="" >
						<option value=""></option>
					</select>
				</div>
			</div> 
		</div>
		
	</div>
		<div class="row">
		<div class="col-sm-6">
					<div class="form-group">
					<label class="control-label col-sm-4" for="shift">Shift</label>
					<div class="col-sm-6" >
						<select class="form-control services_list services4" id="shift">
							<option value=""></option>
						</select>
					</div>
					</div> 
					</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label col-sm-4" for="department">Department</label>
						<div class="col-sm-6" >
						<select class="form-control services_list services5" id="dept">
							<option value=""></option>
						</select>
						</div>
				</div>
			</div>
			
			
			</div>
			<div class="row">		
				<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label col-sm-4" for="date">Designation</label>
						<div class="col-sm-6" >
							<select class="form-control services_list" id="desg">
							<option value=""></option>
							</select>
						</div>
					</div>
				</div>
					<div class="col-sm-6">
						<div class="form-group">
					<label class="control-label col-sm-4" for="pass">Employee Code</label>
					<div class="col-sm-6" >
						<select class="form-control services_list" id="ecode">
							<option value=""></option>
							
						</select>
					</div>
					</div>
					</div>
					
					</div>

				<div class="row">		
				<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label col-sm-4" for="date">Country</label>
						<div class="col-sm-6" >
							<select class="form-control services_list" id="country">
							<option value=""></option>
							</select>
						</div>
					</div>
				</div>
			</div>
					
		   <button type="submit" class="btn btn-success" id="registers" data-target="#showdata" data-toggle="modal">Import</button>	
           <button type="button" class="btn btn-success" onclick="window.location='<?=URL.$pagename?>'">Cancel</button>
		</form>
		</div>	
		<!--------------------->
		<div class="showresult" style="display:none;">
			<h4>Total records : <span id="repeatemp"></span></h4>
			<h4>Total inserted records : <span id="importemp"></span></h4>
			<a href="<?php echo URL ;?>Userprofiles/showTMP" class="btn btn-link">show insuffiecient record</a>
		</div>								
		<!--------------------->							
	</div>
	</div>
	</div>
	    </div>
	    
	
	       <div id="output"></div>
			<div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
	       
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
					</p>-->
					<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
			</div><!-- container flud -->
	</div>
		</div>
		</div>
			
<script>

	 $(document).ready(
		function(){
		$('#fileUpload').change(function(){
				if ($(this).val()) {
					$('#btn1').attr('disabled',false);
				} 
			});
});
	</script>
<script>
$(document).ready(function(){
	$("#btn1").click(function(){
	$("#login-form").css('display','none');
	$("#register-form").css('display','block');
	
	});
});
</script>

</body>
      <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
      <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
     <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
       <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
						
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
					
	<script>
	
	
	///////csv file read/////////////////////
   $(function (){		
     $("#btn1").bind("click", function () {
        var regex = /^([a-zA-Z0-9(0-9)\s_\\.\-:])+(.csv|.txt)$/;
        if (regex.test($("#fileUpload").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e){
                    var line = [];
                    var rows = e.target.result.split("\n");
                 
                        var row = [];
                        var cells = rows[0].split(",");
                        if(cells.length != 9){
                        	$("#registers").attr("disabled",true);
							alert(" Missing column(s) in the import file. Please refer the sample file.");							
							}
                        else{
                        for (var j = 0; j < cells.length; j++){
                            var cell = [];
                            cell.push(cells[j]);
                            row.push(cell);
                        }
                        line.push(row);
                    
                    console.log('---'+line[0]);
    				drawOutput(line[0]);
                  }
                }
                reader.readAsText($("#fileUpload")[0].files[0]);
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid CSV file.");
        }
    });
    ///////////maping column///////////
    function drawOutput(line){
		for(i = 0; i < line.length; i++)
		$('.services_list').append('<option value="'+i+'">'+line[i]+'</option>');
			$('#firstName>option:eq(1)').prop('selected', true);
			$('#lastName>option:eq(2)').prop('selected', true);
			$('#email>option:eq(3)').prop('selected', true);
			$('#cont>option:eq(4)').prop('selected', true);
			$('#shift>option:eq(5)').prop('selected', true);
			$('#dept>option:eq(6)').prop('selected', true);
			$('#desg>option:eq(7)').prop('selected', true);
			$('#ecode>option:eq(8)').prop('selected', true);
			$('#country>option:eq(9)').prop('selected', true);
  	}
	
	
});
	</script>
	<script>
	$("#upload_csv").on("submit",function(event) { 
	   
	  event.preventDefault();
      var demofile=$("#fileUpload").prop("files")[0];
      console.log(demofile);
     var form_data = new FormData();
     form_data.append("proposalfile",demofile);
     
  $.ajax({
    url: "<?php echo URL;?>userprofiles/emportUploads",
    method:"POST", 
     contentType: 'multipart/form-data', 
    contentType:false,          // The content type used when sending data to the server.  
    cache:false,                // To unable request pages to be cached  
    processData:false, 
    data:form_data,
    success: function(text) {
         console.log(text);
		 
        if(text == "success"){
            alert("Your file uploaded successfully");
        }
    },
    error: function() {
        alert("An error occured.");         
    }
  });   
});
	</script>
	<script>
    	$(document).ready(function(){
    	$("#registers").click(function(event){
				   $("#maincontainerdiv").hide("slow");
				   $("#loader").show("slow");
    			   event.preventDefault();
				   var fname=$('#firstName').val();
				   var lname=$('#lastName').val();
				   var dept=$('#dept').val();
				   var desg=$('#desg').val();
				   var shift=$('#shift').val();
				   var email=$('#email').val();
				   var country=$('#country').val();
				   //alert(email);
				   var password=$('#pass').val();
				   var cont=$('#cont').val();
				   var ecode=0;
				   if($('#ecode').val()!=undefined)
				   ecode=$('#ecode').val();
				   
				   $.ajax({url: "<?php echo URL;?>userprofiles/emportEmp",
				   method:"POST",
				     data: {"fname":fname,"lname":lname,"dept":dept ,"desg":desg ,"shift":shift,"email":email ,"password":password,"cont":cont,"ecode":ecode,"country":country},
						success: function(result){
			                  //alert(result);
							var obj = JSON.parse(result);
							var totlemp = obj["importemp"];
						   //$(".importemp").text(totalemp);
							var totalrecod = obj["repeatemp"];
							if(obj["sts"] == "true"){
								$("#contactForm").trigger("reset");
								doNotify('top','center',2,'User Added Successfully.');
								$(".showresult").css('display','block');
								$("#repeatemp").text(totalrecod);
								$("#importemp").text(totlemp);
							}else if(result == "false1"){
								doNotify('top','center',4,'Mail Id is already exist.');
							}else if(result == "false2"){
								doNotify('top','center',4,'Phone number is already exist.');
							}else if(result == "false3"){
								doNotify('top','center',4,'department is not valid.')
							}
							$("#maincontainerdiv").show("slow");
				            $("#loader").hide("slow");
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
							$("#maincontainerdiv").show("slow");
				            $("#loader").hide("slow");
						 }
				   });
			});
			$(".call").click(function(){
				
			 $.ajax({
          		type: "GET",
          		url: "<?php echo URL;?>Userprofiles/deleteTmp",
         		success: function(response) {

          		if(response == "Success")
          		{
             		//$(btn).closest('tr').fadeOut("slow");
         		 }
         	 else
          		{
            		//alert("Error");
          		}

       		}
    	});
		
		});	
	});
	
	
	</script>
	
	

</html>
