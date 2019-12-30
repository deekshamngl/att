<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Department/Site</title>
  
     <style>
       
		.hover{background-color: #cc0000}
		.authorBlock{border-top:1px solid #cc0000;}
		
		.canvasjs-chart-credit{
			display:none;
		}
		tr {display: block; }
		th, td { width: 125px!important; }
		tbody { display: block; height: 550px; overflow: auto;} 

		thead{
			//background-color: rgb(242,155,20);
			}
			tbody {
				max-height: 300px;
				overflow-y: scroll;
				//overflow-x: scroll;
			}
			td{
				white-space: pre-wrap!important;
				
			}
	thead, tbody {
			/// display: table-header-group;
		}
		table td { 
		word-wrap:break-word!important;
		
		}	
		body{
			 position: relative;
		}
		
	   #absenttable tbody td 
	   {
		  width:25%;
		  text-align: left;
	   }
      .summry{
		  color:white;
		  font-size:2em;margin:10%;margin-left:28%;
		margin-right:28%;
		padding:12%;border-radius:4px 4px 4px 4px;
	  }
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
<body>
   <div class="wrapper">
		<?php 
			$data['pageid']=5.1;
			$this->load->view('menubar/sidebar',$data);
		?>
		<?php
        $data=isset($data)?$data:'';

        ?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                   <p class="category" style="color:#ffffff;font-size:17px;" > Department Dashboard</p>
                    <!-- <p class="category" style="color:#ffffff;font-size:17px;" >Helppage </p> -->
                    <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                    <i class="fa fa-question"></i></a>
                  </div>
                  <div class="row">
					<?php foreach($res as $row){ ?>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<a  href="<?=URL?>admin/attendances?id=<?php echo $row['id'] ?>">
							<!--<?=URL?>admin/attendances?id=<?php echo $row['id']?>-->
							<div class="card card-stats" style="border:2px solid gray;border-radius:5px 5px 5px 5px;min-height: 200px;padding:7px; "  >
								<center>
								<div class='summry' rel="tooltip" title="<?php echo $row['totalemp']." Present";?>" style="background-color:<?php echo $row['totalemp']==1?'#ff8100':($row['totalemp']>1 || $row['totalemp']==$row['allemp'] ?'#008067':'red');?>;">
									<span><?php echo $row['totalemp']; ?></span>
								</div>
								<h4 rel="tooltip" title="<?php echo $row['allemp']." Employees"; ?>"><b><?php 	echo $row['name']." (".$row['allemp'].")"; ?><b/></h4>
							<!--<?php  	echo $row['absemp'];?>
								<?php  	echo $row['lateemp'];?>
								<?php 	echo $row['earlyemp'];?>-->
								</center>
							</div>
							</a>
							
						</div>
						
						<?php } ?> 
						
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
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'departdash'});  
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
  
  </script>

  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'departdash'}); 
    });
    
    });
  </script>

</html>