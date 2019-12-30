<?php
		$this->load->view('menubar/loadcss');			
		$this->load->view('menubar/loadjs_ubitech');
		?>
<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><strong>Super Administrator</strong></a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<!-- <li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">dashboard</i>
									<p class="hidden-lg hidden-md">Dashboard</p>-->
								<!-- </a>
							</li>  -->
					<!--		<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications</i>
									<span class="notification">5</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Mike John responded to your email</a></li>
									<li><a href="#">You have 5 new tasks</a></li>
									<li><a href="#">You're now friend with Andrew</a></li>
									<li><a href="#">Another Notification</a></li>
									<li><a href="#">Another One</a></li>
								</ul>
							</li>
					-->		<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
								   <?php if(isset($_SESSION['name']))echo $_SESSION['name']; else redirect(URL."ubitech");?>
		 						</a>
								<ul class="dropdown-menu">
									<!-- <li><a href="#">My Profile</a></li> -->
									<li><a href="<?= URL ?>ubitech/changePassword">Change Password</a></li>
									<li><a href="<?=URL?>/ubitech/Logout">Logout</a></li>
								</ul>
							</li>
						</ul>

						
					</div>
				</div>
			</nav>
	<script>		
			//// js code for archive organization-- view code is in superadmin's sidebar-start	
			$(document).on("click", ".delete", function () {
				$('#del_did').val($(this).data('id'));
				$('#dna').text($(this).data('orgname'));
				$('#delOrg').modal('show');
			});
			$(document).on("click", "#delete", function () {
				var id=$('#del_did').val();
				$.ajax({url: "<?php echo URL;?>ubitech/archiveOrg",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delOrg').modal('hide');
								doNotify('top','center',2,'Company archived successfully.');
								var table=$('#example').DataTable();
								 table.ajax.reload();
							}else{
								$('#delOrg').modal('hide');
								doNotify('top','center',4,'Unable to archive this company');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
//// js code for archive organization-- view code is in superadmin's sidebar	-ends</script>