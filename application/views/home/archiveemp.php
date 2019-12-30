<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<title>Inactive Employees</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		.t2{display:none;}
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

	</style>
	<style type="text/css" media="print" >
		 .print
		  {
			 margin-left:40px;
			 align:center;
			 border:2px #666 solid; padding:5px;  
		  }

          .nonPrintable
		  {display:none;} /*class for the element we don’t want to print*/
		  
         </style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=14.1;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <p class="category" style="color:#ffffff;font-size:17px;" > List of Archived Employees</p>
									<a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right" style="position:relative;margin-top:-30px;" >
											<i class="fa fa-question"></i></a>
	                            </div>
                  <div class="card-content">
									<div id="typography">
										<div class="title">
										
										<div class="text-right">	
										<button  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" onclick="unarchive();">
											<i class="fa fa-material-icons">Unarchive</i> 
										</button>
										
										<button  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" onclick="alldelete();"> 
											<i class="fa fa-trash"> Delete</i>
										</button>
										</div>
										
										<div class="row" style="overflow-x:scroll;">
										<table id="example" class="display table">
											<thead>
												<tr>
												<th style="background-image:none"!important><input type="checkbox" id="select_all" value=""/> </th>
													<th>Name</th>
													<th width="25%">Designation</th>
													<th width="30%"> Department</th>
													<th width="15%" style="background-image:none"!important>Action</th>
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
			<div class="col-md-3 t2" id="sidebar" style="margin-top: 100px;"></div>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  <a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		</div>
	</div>
<!--- Archive Modal statart here -->
		  <div id="unarchive" class="modal fade" role="dialog">
			 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Restore Employee</h4>
			  </div>
			  <div class="modal-body">		
				<form>
					<input type="hidden" id="arc_id" />
					<div class="row">
						<div class="col-md-12">
							<h4>Restore This Employee "<span id="nameE"></span>" ?</h4>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" id="unarchiveE"  class="btn btn-success" data-dismiss="modal">Restore</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<!--- Archive Modal close here -->
		
		<!---------------------->
		
		  <div id="modalunarchive" class="modal fade" role="dialog">
			 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Unarchive Employee</h4>
			  </div>
			  <div class="modal-body">		
				<form>
					<input type="hidden" id="arc_id" />
					<div class="row">
						<div class="col-md-12">
							<h4>Unarchive  Employee?</h4>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" id="modalunarchiveE"  class="btn btn-success" data-dismiss="modal">Unarchive</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<!---------------------->
		<!--- Delete Modal statart here -->
		  <div id="delE" class="modal fade" role="dialog">
			 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Delete Employee</h4>
			  </div>
			  <div class="modal-body">		
				<form>
					<input type="hidden" id="emp_id" />
					<div class="row">
						<div class="col-md-12">
							<h4>Delete "<span id="Ename"></span>" ?</h4>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" id="deleteE"  class="btn btn-success" data-dismiss="modal">Delete</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		
		<!--- Delete Modal close here -->
		<!---->
		  <div id="delallemp" class="modal fade" role="dialog">
			 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Delete Employee</h4>
			  </div>
			  <div class="modal-body">		
				<form>
					<input type="hidden" id="emp_id" />
					<div class="row">
						<div class="col-md-12">
							<h4>Do You Want To Delete  Employee ?</h4>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" id="alldeleteE"  class="btn btn-success" data-dismiss="modal">Delete</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>





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
  

  <script>
            function openNav() 
            {
              document.getElementById("mySidenav").style.width = "360PX";
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'userArch'});  
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
  
  </script>
<script>
var favorite = [];
function unarchive(){
	if($('.checkbox:checked').length > 0)
	{
		$('#modalunarchive').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'select atleast 1 record to unarchive');
		
		return false;
	}
}
$(document).on("click", "#modalunarchiveE", function (e)
				{
				$.ajax({url: "<?php echo URL;?>userprofiles/unarchiveallemp",
						data: {"favorite":favorite}, 
						
						success: function(result){
						//alert(result);
							if(result == 1)
							{
							$('#modalunarchive').modal('hide');
							doNotify('top','center',2,'Employee(s)  unarchived  successfully.'); 
							table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							//alert("error");
							doNotify('top','center',4,'Unable to connect API');
						}								
});
				
			});
</script>
		
	<script>
var favorite = [];
function alldelete(){
	if($('.checkbox:checked').length > 0)
	{
		$('#delallemp').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'select atleast 1 record to delete');
		
		return false;
	}
}
$(document).on("click", "#alldeleteE", function (e)
				{
				$.ajax({url: "<?php echo URL;?>userprofiles/deleteallemp_permanent",
						data: {"favorite":favorite}, 
						
						success: function(result){
						//alert(result);
							if(result == 1)
							{
							$('#delallemp').modal('hide');
							doNotify('top','center',2,'Employee(s)  Deleted  successfully.'); 
							table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							//alert("error");
							doNotify('top','center',4,'Unable to connect API');
						}								
});
				
			});
</script>
		
			
	<script type="text/javascript">
    //	$(document).ready(function() {
			var table= $('#example').DataTable({
				order: [[ 0, 'asc' ]],
				 dom: 'Bfrtip',
				//scrollX:'true',
				buttons: [
					'pageLength','csv', 'excel','copy','print','colvis'
				],
				columnDefs: [ { orderable: false, targets: [3]}],
				"contentType": "application/json",
				//"ajax": "<?php echo URL;?>admin/getAbsent",
				"ajax": "<?php echo URL;?>userprofiles/getArchiveEmp",
				/*"columnDefs": [
					{ "visible": false, "targets": 2 }
				],*/
				
				"columns": [
				{"data":"change"},
					    { "data": "FirstName" },
						{ "data": "desg" },
						{ "data": "deprt" },
						{ "data": "action" }
				],
				
			});
			$(document).ready(function()		{
				$('#select_all').on('click',function()
				{
					
					if(this.checked){
						$('.checkbox').each(function(){
							this.checked = true;
						});
					}else{
						 $('.checkbox').each(function()
						 {
							this.checked = false;
						});
					}
				});
			
									});
		
		
	$(document).on("click", ".checkbox", function () {
						if($('.checkbox:checked').length == $('.checkbox').length)	
						{
							$('#select_all').prop('checked',true);
						}
						else
						{
						$('#select_all').prop('checked',false);
						}
			});
			
		$(document).on("click", ".unarchive", function(){
				var empid = $(this).data('id');
				var empname = $(this).data('name');
				 $("#arc_id").val(empid);
				 $("#nameE").text(empname);
			    });
		$(document).on("click","#unarchiveE",function(){
			  var empid = $("#arc_id").val();
			 $.ajax({url: "<?php echo URL;?>userprofiles/UnarchiveUser",
						data: {"sid":empid},
						success: function(result){
							//alert(result);
							if(result == 1){
								 doNotify('top','center',3,'User restored successfully'); 
								 table.ajax.reload();  
					        }
                            if(result == 2)
							{
								doNotify('top','center',4,"This user has admin permission Its can not be delete."); 
							}
                             							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
							 
						 }
				   });
		})	
				////////////delete employee
				$(document).on("click", ".delete", function (){
				     var empid = $(this).data('id');
				     var empname = $(this).data('name');
					 $("#emp_id").val(empid);
					 $("#Ename").text(empname);
					 
			   
			    });
		$(document).on("click","#deleteE",function(){
			var empid = $("#emp_id").val();
			
			$("#loadmodel").modal('show'); 
			        $.ajax({url: "<?php echo URL;?>userprofiles/deleteUserpermanent__New",
						data: {"sid":empid},
						success: function(result){
							 //alert(result);
					    $("#loadmodel").modal('hide'); 
							if(result == 1){
								 doNotify('top','center',3,'Deleted Successfully.'); 
								 table.ajax.reload();  
					        }
                            else
							{
								doNotify('top','center',4,"user not delete."); 
							}
              							
						 },
						error: function(result){
							$("#loadmodel").modal('hide');
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
		});		
				
         //   });
	</script>
  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'userArch'}); 
    });
    
    });
  </script>
	
	

</html>
