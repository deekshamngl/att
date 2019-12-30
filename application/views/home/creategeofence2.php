
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker/github.min.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>../assets/standalone.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Geo setting</title>
    <style>
	.checkbox label, .radio label, label {
		color:#675d5d!important;
	}
      *{
      margin:0px;
      padding:0px;
      }
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
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
      tbody td:not(:nth-child(1)){
      text-align:center;
      }
      .form-group {
      padding-bottom: 0px; 
      margin:0px; 
      }
    </style>
	 <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 400px;
		border:1px solid black;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }
      .controls{
		  margin-top:8px;
		  height:40px;
		  border:1px solid black;
		  border-radius:5px;
	  }
      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
	  #pac-input{
        border-color: green;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
	 #imagelod
	 {
		 height:200px;
		 width :200px;
	 }	 
	  
	 
    </style>
  </head>
  <body>
    <div class="wrapper">
      <?php
        $data['pageid']=12.4;
        $this->load->view('menubar/sidebar',$data);
        $data=isset($data)?$data:'';
        ?>
      <div class="main-panel">
        <?php
          $this->load->view('menubar/navbar');
          ?>
        
        <section class="content" id="printsection">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header" data-background-color="green">
                      <p class="category" style="color:#ffffff;font-size:17px;"  >Add Geo Fence</p>
                    </div>
                   
                   <div class="card-body" style="height:600px;overflow-x:auto;" id="topdiv"  >
				      <div class="container-fluid" style="" >
					   <div class = "row container-fluid" >
				  <div class="col-md-7" >
				    <div class="row" id="mapdiv" style="margin-top:-30px;display:none" >
					  <!-- <input id="pac-input" class="controls" type="text" placeholder="Enter Your Location....." > -->
					  <div id="map" style="height:400px;" ></div>
					  <br />
					  <!-- <P> <b>Note* </b>&nbsp;&nbsp;&nbsp; <span style="color:green" > Enter your location in the search bar and click on the location marker </span><i class="fa fa-map-marker" style="color:#ff6666;font-size:20px; " aria-hidden="true"></i></p> -->
					</div>
					 
					<div id="loderdiv" style="padding-top:30%" >
						  <center>
						 <img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" id="imagelod" />
						</center>
					</div>
			    </div>
				  <div class="col-md-5" style="padding-left:30px;" >
                        <form class="form-horizontal" action="#"  method="post" >
					 <!--  <div class="row" >
						   <div class="col-sm-1">
						   </div>
					       <div class="col-sm-4" >
						     <button type="button" class="btn btn-info btn-lg pull-right" onclick="getcurrentLocation()" >Set Current Location</button>
						   </div>
				      </div>  -->
					  <div class="row" >
						   <div class="col-sm-4" >
				           <label for="text" class="form-group"><strong>Geo Center Name *</strong></label>
						   </div>
						   <div class="col-sm-8" >
                          <input type="text" class="form-control" id="name" name="name" value="" required placeholder="Eg. Connaught Place"  >
						  <input type="hidden" class="form-control" id="id" name="id" value="" >
						  </div>
				      </div>
					<!--  <div class="row" >
						<div class="col-sm-4" ></div>
						   <div class="col-sm-6" style="margin-left:-16px;" >
				             <a href="#" class="pull-left" id="showmap1" onclick="showmap()" ><u>Set Location on Map</u></a>
						   </div>
				      </div> -->
					  <div class="row"  >
						   <div class="col-sm-4" >
				           <label for="text" class="form-group"><strong>Latitude , Longitude *</strong></label>
						   </div>
						   <div class="col-sm-8" >
                          <input type="text" class="form-control" id="latlong" name="latlong" value="<?php echo $latit.",".$longi; ?>" required   disabled   >
						  </div>
				      </div> 
					  
					  <div class="row" >
						   <div class="col-sm-4" >
				           <label for="text" class="form-group"><strong>Geo Center Address *</strong></label>
						   </div>
						
						   <div class="col-sm-8" >
                          <textarea  rows="3" cols="50" class="form-control" id="location" name="location"  disabled ><?php echo decode5t($checkinloc);?></textarea>
						  
						  </div>
						  
				      </div>
					  <br />
					  <br />
					  <br />
					  <div class="row" >
						   <div class="col-sm-4" >
				           <label for="text" class="form-group" >
						   <strong>Fence Radius (Km) *</strong></label>
						   </div>
						   <div class="col-sm-8" > 
                            <input type="number" min="0" placeholder="" value="0.250"	class="form-control" id="radius" name="radius" required >
						  </div>
				      </div>
					 
					   <div class="row" >
					        <div class="col-sm-3">
						    </div>
						   <div class="col-sm-2" >
						   <?php echo isset($name); ?> 
						     <input type="button" name="save" class="btn btn-success pull-right" id="submit" value="<?= (isset($name)?'Update':'Add') ?>" />
						   </div>
						   <div class="col-sm-2">
						     <a href="<?= URL ?>Dashboard/geoLocations" class="btn btn-default pull-left" >Cancel
							 </a>
						   </div>
						   <div class="col-sm-5">
						   </div>
				      </div>
		            </form>
			    </div>
			</div>
					   <div>
					  </div>
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
	
    </section>
    <footer class="footer">
      <div class="container-fluid">
        <nav class="pull-left">
        </nav>
        <!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
	    </p>-->
		<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
      </div>
    </footer>
  </body>
  <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
    <div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
    <div id="sidenavData" class="sidenavData">
    </div>
  </div>
 
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js">
	 </script>
     
  <script>
           var data = <?php echo ($latit);  ?>;
              var data1 = <?php echo ($longi);  ?>;

	   setTimeout(function(){   
	       var x1 = document.getElementById("mapdiv");
	       var x2 = document.getElementById("loderdiv");
		   x1.style.display = "block";
		   x2.style.display = "none";
		   
	   }, 3000);
        
  
      $(document).on("click", "#submit", function (){

          // alert("<?php echo  '{ lat: '. $latit .", lng: ".$longi." }" ; ?>");
        // return false;
				var name=$('#name').val().trim();
				var id=$('#id').val();
				var location=$('#location').val().trim();
				var latlong=$('#latlong').val();
				var radius=$('#radius').val();
				
			     if(name == "")
				  {
					$('#name').val(name);
					$('#name').focus();
					doNotify('top','center',4,'Please enter the Geo Center Name .');
					return false;
                  } 
			 else if(latlong=="")
			 {
				$('#latlong').focus();
				doNotify('top','center',4,'Latitude and Longitude can not be null.');
				return false;
             }
			 else if(validatelatlong(latlong))
					{
					$('#latlong').focus();
					doNotify('top','center',4,'There is some problem,Please try again.');
					return false;
					}
			 else if(location == "")
			 {
                        $('#location').focus();
                        $('#location').val(location);
						doNotify('top','center',4,'Please enter the Geo Center Address .');
						return false;
             }
			 else if(radius=="")
			 {
                        $('#radius').focus();
						doNotify('top','center',4,'Please enter Fence Radius .');
						return false;
             }
			 else if(radius < 0.05)
			 {
                        $('#radius').focus();
						doNotify('top','center',4,'Radius should be greater than 0.05 (km) ');
						return false;
             }
				$.ajax({url: "<?php echo URL;?>Dashboard/saveGeolocation",
						data: {"id":id,"name":name,"location":location,"latlong":latlong,"radius":radius},
						success: function(result){
							var result=JSON.parse(result);
							 
							if(result.status)
							{
								doNotify('top','center',2,result.sms);
								 setTimeout(function()
									 {
									 window.location.replace("<?=URL?>dashboard/geoLocations");
									 }, 3000);
							}
								else
								{
								doNotify('top','center',4,'There is some error while insert location');
								}
						 },
						error: function(result)
							{
							doNotify('top','center',4,'Unable to connect API');
							}
				   });
			});
  
  
     var lat ;
     var lng ; 
	 var lat_lang = "";
   
      function validatelatlong(latlong) 
			{
			var re = /[a-z]/;
			return re.test(String(latlong).toLowerCase());
			}
	 

     
   function getLocation() { 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition,error,options); 
	  
    } else { 
        alert("Geolocation is not supported by this browser.");
		}
    }
    function error(err) {
		// alert("Please Allow to share your location..");	
         //lat = 26.196706799999998;	
		 //lng = 78.1969453;
		// alert(lat);
	}
	function options(err) {
		 alert("Other options");		
	}
  function showPosition(position) { 
	   

    lat = parseFloat(position.coords.latitude); 
    lng = parseFloat(position.coords.longitude);

    alert (parseFloat(position.coords.latitude));
  }
  
   
   function getcurrentLocation()
   {
			  if (navigator.geolocation)  {
             navigator.geolocation.getCurrentPosition(showPosition1,error1);
             } else  
			 {
             alert("Geolocation is not supported by this browser.");
             } 
		   function showPosition1(position)
     		   {
                 getcurrentLocation1();
               }
		   function error1(err) {
			  // console.log(err);
			    //alert("Please Allow to share your location");	
			  }
		     
   }
   getcurrentLocation();
   function getcurrentLocation1()
   {
	  // getLocation(); 
		  setTimeout(function()
		  {
			  lat_lang = $("#latlong").val();
			  //alert(lat);
		   getAddress(lat,lng);
		  },2000);	  
   }
//    function getAddress (latitude,longitude){
// 	   var geocoder = new google.maps.Geocoder();
//       var latlng = new google.maps.LatLng(latitude, longitude);
//     geocoder.geocode({'latLng': latlng}, function(results, status) {
//       if (status == google.maps.GeocoderStatus.OK) {
//       console.log(results)
//         if (results[1]) {
//          //formatted address
//          $("#location").val(results[0].formatted_address);
//           //alert(results[0].formatted_address)
//         } else {
//           alert("No address found");
//         }
//       } else 
// 	  {
//         alert("Geocoder failed due to: " + status);
//       }
//     });
// }

 /* function showmap()
   {
	  $("html body #topdiv").animate({ scrollTop: $(document).height() }, 1000);
	   var x = document.getElementById("mapdiv");
      if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
  }*/
  
     
      function initAutocomplete(){
		 var lat11 = "<?php echo  $latit; ?>";	
		 var lng11 = "<?php echo  $longi; ?>";
      // alert("<?php echo  '{ lat: '. $latit .", lng: ".$longi." }" ; ?>");
      // alert(lat11);
		 setTimeout(function(){ 
        var map = new google.maps.Map(document.getElementById('map'),
		{      
          center: {lat:   parseFloat(lat11), lng: parseFloat(lng11)},
          //center: {lat: lat, lng: lng},
          zoom: 18,
          mapTypeId: 'roadmap'
        });
       
         

         var marker = new google.maps.Marker({
    position:   {lat:   parseFloat(lat11), lng: parseFloat(lng11)},
    map: map,
    
  });
       
		
       
  },2000);
      }
	  
	 
	  
    </script>
	
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYh77SKpI6kAD1jiILwbiISZEwEOyJLtM&libraries=places&callback=initAutocomplete"
         async defer></script> 
	 
 
</html>