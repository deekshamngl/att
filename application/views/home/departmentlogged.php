<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />

  <title>Helppage</title>
  <style>
	
		.red
		{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
			
			.delete{
			cursor:pointer;
					}
					
			div.dt-buttons
			{
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
			 #example tbody tr td.lalign 
					{
             text-align: left;
                   }
				   .id
				   {
					   color:grey;
				   }
				 .empname
				 {
					font-Size:18px; 
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
		  {display:none;} /*class for the element we don’t want to print*/
		  
		  
	#cart_cancel
	{
		background-color: transparent!important;
        border: none;
        float: right;
	}	
	
     </style>
	 <!-- pre loader -->
	 <style>
	  /* Preloader */
	  #preloader {
	  position: fixed;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #fff;
	  /* change if the mask should have another color then white */
	   z-index: 99;
	  /* makes sure it stays on top */
	}
		#status {
		  width: 200px;
		  height: 200px;
		  position: absolute;
		  left: 60%;
		  /* centers the loading animation horizontally one the screen */
		  top: 50%;
		  /* centers the loading animation vertically one the screen */
		  background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
		  background-repeat: no-repeat;
		  background-position: center;
		  margin: -100px 0 0 -100px;
		  /* is width and height divided by two */
		}
	#addEmp{
       overflow: scroll;
   }
	 </style>
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
  <div class="modal fade" id="loadmodel" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index:11111111;" >
			<div class="modal-dialog">
				<center>
					<img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
				</center>
			</div>
       </div> 
<body>
   <div class="wrapper">
	
		<?php
			$data['pageid']=5.2;
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
                   <p class="category" style="color:#ffffff;font-size:17px;" > Department/Site Dashboard</p>
                    <!-- <p class="category" style="color:#ffffff;font-size:17px;" >Helppage </p> -->
                    <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                <i class="fa fa-question"></i></a>
                  </div>
                  <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<!--<div class="col-md-2" style="margin-top:-10px;" >
													<h3>Manage Active Employees </h3>
												</div>-->
												<div class="col-md-12 text-left" >
												
											
													
												</div>
													<div class="col-md-4 text-right" style="float:right;">	
													</div>
											</div>
										</div>
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th class="" width="15%">Departments</th>
													<th class="" width="15%">Total</th>
													<th>Present</th>
													<th>Absent</th>
													<th>Late Comers</th>
													<th>Early Leavers</th>
													<!--<th class="text-left" width="10%" 
													style="background-image:none"!important>Action</th>-->
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
            function openNav() 
            {
              document.getElementById("mySidenav").style.width = "360PX";
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'departLogged'});  
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }


            var specialKeys = new Array();
			specialKeys.push(8); //Backspace
			$(function () 
			{
				$(".numeric").bind("keypress", function (e) 
				{
					var keyCode = e.which ? e.which : e.keyCode
					var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
					$(".error").css("display", ret ? "none" : "inline");
					return ret;
				});
				
				$(".numeric").bind("drop", function (e) {
					return false;
				});
			});
			
			
			
			$(".alpha").keydown(function(e)
			{
				if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
				// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				(e.keyCode >= 35 && e.keyCode <= 40)) 
				{
				return;
				}// Ensure that it is a number and stop the keypress
				if ((e.keyCode < 65 || e.keyCode > 90) && (e.keyCode !=95 || e.keyCode > 123) && e.keyCode != 32)
				{
				e.preventDefault();
				}
			});
  
  </script>
  <script type="text/javascript">
	  
    	//$(document).ready(function() { 
		$(".datepicker" ).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
                yearRange: "1900:2050"				
			}); 
			var table=$('#example').DataTable( {
					"bProcessing": true,
					"printable": true,
				   // "bServerSide": true,
					"paging": true,
				    //"stateSave": true,
				     //"deferRender": true,
				     //"bSort": true,
				//"scrollX": true,
				//"contentType": "application/json",
				order: [[ 0, 'asc' ]],
					"orderable": false,
					//"scrollX": true,
				 dom: 'Bfrtip',
					buttons: [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',	
					}
				],
				"ajax": "<?php echo URL;?>userprofiles/departmentreport",	
				"columns": [
					{ "data": "departname" },
					{ "data": "total" },
					{ "data": "present"},
					{ "data": "absent" },
					{ "data": "latecomers" },
					{ "data": "earlyleavers" },
					//{ "data": "action"}
				]
			});
			</script>
			<script>
			var table = $('#example').DataTable();
			$('#example').on('click', 'tr', function () 
			{
				var id = table.row(this).data().id;
				window.location.href = '<?=URL?>admin/department?id='+id; 
			});
			</script>

  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'departLogged'}); 
    });
    
    });
  </script>

</html>