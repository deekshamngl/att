type = ['','info','success','warning','danger'];


demo = {
    initPickColor: function(){
        $('.pick-class-label').click(function(){
            var new_class = $(this).attr('new-class');
            var old_class = $('#display-buttons').attr('data-class');
            var display_div = $('#display-buttons');
            if(display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
            }
        });
    },

    initFormExtendedDatetimepickers: function(){
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
         });
    },

    initDocumentationCharts: function(){
        /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */

        dataDailySalesChart = {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                [12, 17, 7, 17, 23, 18, 138]
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 150, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);
    },
	/////////////////---daily sales charts end
    initDashboardPageCharts: function(){
			// this code for get a current date start //
		var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
		if(dd<10){
			dd = '0'+dd
		} 
		if(mm<10){
			mm = '0'+mm
		} 
		
		var date_data = yyyy+"-"+mm+"-"+dd;
		// this code for get a current date end //
		// this code for get a month name start //
			var monthNames = ["January", "February", "March", "April", "May", "June",
	  "July", "August", "September", "October", "November", "December"
	   ];
 //var hello=[] ;
     var d = new Date();
	 var name11 = monthNames[d.getMonth()];
	 var variable2 = name11.substring(0, 3);
	 var hello=[];  
	   $.ajax({url: "dashboard/getDashboadAttendance/"+date_data+"", success: function(result){
		  var result1 = JSON.parse(result);
		  var myJSON=JSON.parse(result1.result);
		   var maxemp=JSON.parse(result1.maxemp);
		  for(var key in myJSON)
				hello.push(parseInt(myJSON[key].total));	
        dataDailySalesChart = {
            labels: [(dd-6)+'\n'+variable2, (dd-5)+'\n'+variable2, (dd-4)+'\n'+variable2, (dd-3)+'\n'+variable2, (dd-2)+'\n'+variable2, (dd-1)+'\n'+variable2, dd+'\n'+variable2],
            series: [ hello ]
        };
        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: maxemp, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }
        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);	
        md.startAnimationForLineChart(dailySalesChart);		 
        }});
		

        /* ----------==========     Daily Attendance Chart initialization    ==========---------- */


        /* ----------==========     Completed Tasks Chart initialization    ==========---------- */

        dataCompletedTasksChart = {
            labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
            series: [
                [230, 750, 450, 300, 280, 240, 200, 190]
            ]
        };

        optionsCompletedTasksChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0}
        }

        var completedTasksChart = new Chartist.Line('#completedTasksChart', dataCompletedTasksChart, optionsCompletedTasksChart);

        // start animation for the Completed Tasks Chart - Line Chart
        md.startAnimationForLineChart(completedTasksChart);



        /* ----------==========     monthly attendance Chart initialization    getMonthlyAttChart==========---------- */        
		var hello=[];
		var MON=['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var month=[];
		$.ajax({url: "dashboard/getMonthlyAttChart", success: function(result){
		  var myJSON = JSON.parse(result);
		  //console.log(myJSON[0].total);
	/*	  console.log("Max: "+Math.max.apply(Math,myJSON));
		  console.log('Monthly chart: '+myJSON[0].total);*/
		 var i=1;
	/*	 for(var key in myJSON){
			// if(myJSON[key].total){
				 month.push(i);
				hello.push(parseInt(myJSON[key].total));
			 
			 i++;
		 }*/
		 for(i=0;i<12;i++){
			// alert(myJSON[i]);
		//	if(myJSON[i].month==i){
				 if(myJSON[i]!==undefined){
					month.push(MON[i]);
					hello.push(parseInt(myJSON[i].total));
				}else{
					//alert(parseInt(myJSON[i].month));
					month.push(MON[i]);
					hello.push(0);
				}
			/* }else{
				//alert('false block');
			} */	
			 
		 }
		console.log("month "+month);
		console.log("hello "+hello);
		var max=Math.max.apply(Math,hello);
		var dataEmailsSubscriptionChart = {
          labels: [ month ],
          series: [ hello ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: max,
            chartPadding: { top: 0, right: 5, bottom: 0, left: 0}
        };
        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];
        var emailsSubscriptionChart = Chartist.Bar('#emailsSubscriptionChart', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart, responsiveOptions);
        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);
        }});
		
		

    }
}
