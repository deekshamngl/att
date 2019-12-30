
 var demo ="";
$(function () {
var count=0;
fetchnotify("pagelinks2");
  /* For demo purposes */
  var pathname = window.location.pathname; // Returns path only
	var url      = window.location.href;     // Returns full URL

var path1=path+'login';
if(url != path1){

  demo = $("<div />").css({
    position: "fixed",
    top: "70px",
    right: "0",
	title:'Alerts',
    background: "red",
    "border-radius": "5px 0px 0px 5px",
    padding: "10px 15px",
    "font-size": "16px",
    "z-index": "99999",
    cursor: "pointer",
    color: "#3c8dbc",
    "box-shadow": "0 1px 3px rgba(0,0,0,0.1)"
  }).html('<i class="fa fa-bell" style="color:white"></i>').addClass("no-print");
 
/*setTimeout(function(){demo=demo.html('<i class="fa fa-bell" style="color:white;font-weight:bold"><sup style="color:white" >'+count+'</sup></i>').addClass("no-print");}, 3000);*/

  var demo_settings = $("<div />").css({
    "padding": "10px",
    position: "fixed",
    top: "70px",
    right: "-300px",
    background: "rgb(255,255,220)",
    border: "0px solid #ddd",
    "width": "300px",
    "z-index": "99999",
    "box-shadow": "0 1px 3px rgba(0,0,0,0.1)"
  }).addClass("no-print");
  demo_settings.append(
          "<h4 class='text-light-blue' style='margin: 0 0 5px 0; border-bottom: 1px solid #ddd; padding-bottom: 15px;'>Notifications</h4>"
          //Fixed layout
          + '<div class="box-body chat" id="alert-box" >'
          + "<div class='checkbox' id='pagelinks2'>No Notifications for you"
          + "</div>"
          + "</div>"
          );
		  demo_settings.append(
          "<h4 class='text-light-blue' style='margin: 10px 0 5px 0; border-bottom: 1px solid #ddd;border-top: 1px solid #ddd; padding-bottom: 15px;padding-top: 10px;'>Approvals</h4>"
          //Fixed layout
          + '<div class="box-body chat" id="approval-box" >'
          + "<div class='checkbox' id='pagelinks3'>No Approvals for you"
          + "</div>"
          + "</div>"
          );
  


  demo.click(function () {
    if (!$(this).hasClass("open")) {
      $(this).animate({"right": "300px"});
      demo_settings.animate({"right": "0"});
      $(this).addClass("open");
    } else {
      $(this).animate({"right": "0"});
      demo_settings.animate({"right": "-300px"});
      $(this).removeClass("open");
    }
	 
	 

  });

  $("body").append(demo);
  $("body").append(demo_settings);
  
  
 }  
  
	
 // setup();
//checkHistory("pagelinks2");
function fetchnotify(targetId)
	{	
		
		//$scope.hastrue=true;
		
		$.ajax({
			url: path+'profile/getallnotifications',
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data) {
						var returnedData = JSON.parse(data);
						
						//console.log(data)
						var htmlContent="";
						var htmlContent1="";
						var notification=returnedData.data['notification'];
						var approvals=returnedData.data['approvals'];
						count=notification.length;
						count+=approvals.length;
						$('#alert-box').slimScroll({
							height: '190px'
						  });
						  $('#approval-box').slimScroll({
							height: '190px'
						  });
							if (notification != "") {
							
								var sp = notification;
								for ( var i = 0; i < sp.length; i++) {
									htmlContent += '<div class="item" ><img src="'+sp[i].image+'" alt="user image" class="online"/><p class="message"><a href="'+path+sp[i].link+'" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '+sp[i].time+'</small><span  class="product-description" title="'+sp[i].employee+'"> '+sp[i].title+'</span></a><a ="message"><a href="'+path+sp[i].link+'" class="product-description" title="'+sp[i].message+'" style="color:black"> '+sp[i].message+' </a></p></div></div>';
									
									document.getElementById(targetId).innerHTML = htmlContent;
								}
								
								//setCookie("notification", sp.toString(), 30);
							}
					
							if (approvals != "") {
							
								var sp = approvals;
								for ( var i = 0; i < sp.length; i++) {
									htmlContent1 += '<div class="item" ><img  alt="user image" class="online" style="width:0px;visibility:hidden"/><p class="message" style="margin-left:10px"><a href="'+path+sp[i].link+'" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '+sp[i].time+'</small><span  class="product-description" title="'+sp[i].name+'"> '+sp[i].name+'</span></a<a ="message"><a href="'+path+sp[i].link+'" class="product-description" title="'+sp[i].message+'" style="color:black"> '+sp[i].message+' </a></p></div></div>';
									
									document.getElementById('pagelinks3').innerHTML = htmlContent1;
								}
								
								//setCookie("notification", sp.toString(), 30);
							}
					//$scope.notifyarr=data.data;
				
				
				//$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				//$scope.hastrue=false;
		});
	}
});	


//fetchnotify();
	