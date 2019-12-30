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
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=6;
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
	                                <h4 class="title">Import Designations</h4>
	                                <p class="category"> </p>
								</div>
  <div class="card-content">
	<div class="panel panel-default" id="login-form" style="display:block">
      <div class="panel-heading">Import Designations</div>
        <div class="panel-body" style="min-height: 400px;">		
		<form id="upload_csv" method="post" enctype="multipart/form-data">
		
		     <div class="col-sm-12">						
				<div class="box box-solid" style="background-color:#EFEFF8;padding:10px">
					<div class="box-header with-border">
						<h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;Points to remember</h3>
					</div> <!--box-header-->
						<div class="box-body">
							<ol>
							<li>The format of the data in the CSV file will be the same as the sample file.</li>
							<li>Ensure that your file size does not exceed 5 Mb. </li>
							<li>First row of the given file will be treated as field names.</li>
							<li>The columns should be the same, in the same as the sample CSV</li>
                            <li>There should be no duplicate Designation.</li>
                             <li>Unexpected errors may occur if the csv file contains special controls like combo filters or images embeded with in.</li>
							</ol>
						</div>						
					</div><!-- /.box -->
			   </div>
		
		    <div class="col-md-12">
				<div class="col-sm-2 col-xs-12" style="margin-left:-8px" ><label class="">Select File(.CSV)</label></div>
				<div class="col-sm-6">
				<input type="file" id="fileUpload" accept=".csv" name="fileUpload" accept=".csv,text/csv"/><br>
				<a href="<?php echo IMGURL;?>newdesignation.csv" >Sample file download</a>
			</div>
			<div class="col-md-12">
			  <center>
			   <input type="submit" id="btn1" class="btn btn-success btnfile call" value="Next" disabled>
			   <button type="button" class="btn btn-success" id="registers" disabled	 >Import</button>
                <input type="button" class="btn btn-success" value="Close" onclick="window.location='<?= URL?>admin/designations'">
			  </center>
			</div>
			</div>
          </div>
    	</form>
    </div>
	  <!------------>
		
		<div class="showresult" style="display:none;">
			<h4>Total records : <span id="repeatemp"></span></h4>
			<h4>Total inserted records : <span id="importemp"></span></h4>
			<a href="<?php echo URL ;?>admin/showTMPDes/1" class="btn btn-link">show insuffiecient record</a>
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
		$('#fileUpload').change(function()
			{
				if ($(this).val()) {
					$('#btn1').attr('disabled',false);
					 $('#registers').attr('disabled',true);
				} 
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
   $(function () {		
    $("#btn1").bind("click", function () {
		 $('#registers').attr('disabled',true);
        var regex = /^([a-zA-Z0-9(0-9)\s_\\.\-:])+(.csv|.txt)$/;
        if (regex.test($("#fileUpload").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e){
                    var line = [];
                    var rows = e.target.result.split("\n");
                                   
                        var row = [];
                        var cells = rows[0];
						 cells = cells.trim();
                        if(cells != "Designation")
						     {
						    	alert("Please make Format as sample file.");							
							}
                        else
						{
						$('#registers').attr('disabled',false);
						$('#btn1').attr('disabled',true);
                       console.log('---'+line[0]);
                       console.log('---'+line[0]);
    				//drawOutput(line[0]);
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
    url: "<?php echo URL;?>admin/importUploadsDeg",
    method:"POST", 
     contentType: 'multipart/form-data', 
    contentType:false,          // The content type used when sending data to the server.  
    cache:false,                // To unable request pages to be cached  
    processData:false, 
    data:form_data,
    success: function(text) {
         //console.log(text);
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
				   $.ajax({url: "<?php echo URL;?>admin/emportDeg",
				   method:"POST",
				   
						success: function(result){
			               
							var obj = JSON.parse(result);
							
							var totlemp = obj["importemp"];
						   //$(".importemp").text(totalemp);
							var totalrecod = obj["repeatemp"];
							if(obj["sts"] == "true"){
								$("#contactForm").trigger("reset");
								doNotify('top','center',2,'Designation Added Successfully.');
								$(".showresult").css('display','block');
								$("#repeatemp").text(totalrecod);
								$("#importemp").text(totlemp);
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
