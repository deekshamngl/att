 function doNotify(from, align,color,message){
    	//color = Math.floor((Math.random() * 4) + 1);
		/*
		1 sky blue
		2 sky green
		3 orange
		4 red
		5 blue
		6 blue
		*/
    	$.notify({
        	icon: "notifications",
        	message: message
        },{
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}
	//////////////////////////------dashboard functions
	function getTimeoffEmpCount() {  //alert();
		/*	$.ajax({ 
						url: 'https://ubiattendance.ubihrm.com/index.php/admin/getTimeOffEmpCount',type:'POST',headers:{
								"Content-Type":'application/x-www-form-urlencoded'
							},cache:false,
							success: function (data) {
								
								
								if($('#countTB').text()!=data)
								{ 
									$('#countTB').text(data);
									if ($('#countTB1').length)
									 $('#countTB1').text(data);
									getTimeoffEmpList();
									$("#timeBreakNotification").click();
								}
									
							},
							error:function(request, textStatus, errorThrown){
							//	doNotify('top','center',4,'Unable to count of employees currently on  TimeOff');
							}
						});*/
			}
			function getTimeoffEmpList() { /*
			$("#brk > tbody").html("");
			//getTimeoffEmpCount();
			$.ajax({ 
				url: 'https://ubiattendance.ubihrm.com/index.php/admin/getTimeOffEmpList',
					type:'POST',
					headers:{
						"Content-Type":'application/x-www-form-urlencoded'
					},
					cache:false,
					success: function (data) {
						$('#brk').find('tbody').append(data);
					},
					error:function(request, textStatus, errorThrown){
					//	doNotify('top','center',4,'Unable to fetch list of employees currently on  TimeOff');
					}
				})*/
			 }
///////////////////-----=------------------------------------------------------------
			  function getPresentEmpCount() { 
			  $.ajax({ 
						url: 'https://ubiattendance.ubihrm.com/index.php/admin/getPresentEmpCount',
						type:'POST',
						headers:{
							"Content-Type":'application/x-www-form-urlencoded'
						},
						cache:false,
							success: function (data) {
								if(data==false)
									return;
							
//							console.log(data.count);
								$('#presentCount').text();
								if ($('#presentCount').length)
									$('#presentCount').text();
									//alert($('#presentCount').text()+"=="+data);
								if($('#presentCount').text()!=data.count)
								{ 
									$('#presentCount').text(data.count);
									getPresentEmpList();
								    //	$("#notificationButton").click();
								    nofi(data.name);
								}
									
							},
							error:function(request, textStatus, errorThrown){
							//	doNotify('top','center',4,'Unable to count present employees');
							}
						});
			}
			
			    function getPresentEmpList() { 
			    $("#presentList > tbody").html("");
			    //getTimeoffEmpCount();
			    $.ajax({ 
				url: 'https://ubiattendance.ubihrm.com/index.php/admin/getPresentEmpList',
					type:'POST',
					headers:{
						"Content-Type":'application/x-www-form-urlencoded'
					},
					cache:false,
					success: function (data) {
						$('#presentList').find('tbody').append(data);
					},
					error:function(request, textStatus, errorThrown){
					//	doNotify('top','center',4,'Unable to fetch list of present employees');
					}
				})
			 }
	//////////////////////////------dashboard functions/
	
	///////////notifications----

	///////////notifications----close
	
	
function nofi(name){
					notifyBrowser("ubiAttendance Notification",name+" Marked the Attendance","http://ubiattendance.ubihrm.com/index.php/dashboard");
					//e.preventDefault();
				
}
	
	var counter=0;// to prevent notification for attendance on first loading of window
	var counter1=0;// to prevent notification for time break on first loading of window					
//		getTimeoffEmpCount();setInterval(getTimeoffEmpCount,5000);				
//		getPresentEmpCount();setInterval(getPresentEmpCount,5000);				
	 
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				$("#notificationButton").click(function(){
					notifyBrowser("ubiAttendance Notification","Attendance Marked","http://ubiattendance.ubihrm.com/index.php/dashboard");
					//e.preventDefault();
				});
				$("#timeBreakNotification").click(function(){
					notifyBrowser1("ubiAttendance Notification","TimeBreak Marked","http://ubiattendance.ubihrm.com/index.php/dashboard");
					//e.preventDefault();
				});
				function notifyBrowser(title,desc,url) 
				{
				if (!Notification) {
				console.log('Desktop notifications not available in your browser..'); 
				return;
				}
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				else {
				//alert(counter);
				if(counter!=0){
				var notification = new Notification(title, {
				icon:'http://ubiattendance.ubihrm.com/assets/img/important-Img-used-in-ubiattendance-push-notification.png',
				body: desc,
				});

				// Remove the notification from Notification Center when clicked.
				notification.onclick = function () {
				window.open(url);      
				};

				// Callback function when the notification is closed.
				notification.onclose = function () {
				console.log('Notification closed');
				};
				}
				counter++;
				}
				}
				function notifyBrowser1(title,desc,url) 
				{
				if (!Notification) {
				console.log('Desktop notifications not available in your browser..'); 
				return;
				}
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				else {
				//alert(counter);
				if(counter1!=0){
				var notification = new Notification(title, {
				icon:'http://ubiattendance.ubihrm.com/assets/img/important-Img-used-in-ubiattendance-push-notification.png',
				body: desc,
				});

				// Remove the notification from Notification Center when clicked.
				notification.onclick = function () {
				window.open(url);      
				};

				// Callback function when the notification is closed.
				notification.onclose = function () {
				console.log('Notification closed');
				};
				}
				counter1++;
				}
				}
	