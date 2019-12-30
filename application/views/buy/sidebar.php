<div class="sidebar" data-color="green" data-image="../assets/img/sidebar-1.jpg">
			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
				<a href="<?=URL?>dashboard" class="simple-text">
					UBIATTENDANCE
				</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	                <li <?php if(isset($pageid) and $pageid==1)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/dashboard">
	                        <i class="material-icons">dashboard</i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>
					<li <?php if(isset($pageid) and $pageid==2)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/slider">
	                        <i class="material-icons">unarchive</i>
	                        <p>Home slider</p>
	                    </a>
	                </li>
					<li <?php if(isset($pageid) and $pageid==3)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/organization">
	                        <i class="material-icons">unarchive</i>
	                        <p>Organization</p>
	                    </a>
	                </li>
					<li <?php if(isset($pageid) and $pageid==4)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/trial_setting">
	                        <i class="material-icons">unarchive</i>
	                        <p>Trial Setting</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
	    </div>