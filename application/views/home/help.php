<!doctype html>
<html lang="en" >

<!--
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
</head>
-->    <!--This code is conflicting with remain code of page-->
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.deleteShift{
			cursor:pointer;
		}
	
	.simpleH{
		font-family:Arial; 
		color:black;
		
	}
	
		blockquote{
			font-size: 14px;
		}
	</style>
</head>
<body style="margin:20px;">

<div class="row">

<?php
$page	= isset($_REQUEST['pageid']) ? ($_REQUEST['pageid']) : '';
/* <?php if(isset($pageid) and $pageid==1)echo 'class="active"'; ?>
page1 news
page2 pages
page3 pageimage         ////Site Manager->Images   ***data are not available
page4 indexing
page5 conference
page6 advertisement
page7 inc_menuscript
page8 submit_menuscript
page9 menuscript_under_revision  //////author-> manuscript under revision  ***update pagename
page10 revise_menuscript
page11 menuscript_under_review   //////author-> manuscripts under review  ***update pagename
page12 reject_menuscript
page13 publish_menuscript       //////author-> published manuscript    ***update pagename
page14 new_menuscript
page15 pending_menuscript
page16 sent_menuscript
page17 editor_new_menuscript
page18 editor_incomplete_menuscript
page19 editor_sent_for_revision     /////editor->sent for revision  ***data not available
page20 editor_revised_menuscript    /////editor->revised manuscripts ***data not available
page21 editor_sent_for_review
page22 editor_review_menuscript
page23 editor_rejected_menuscript
page24 editor_published_menuscript
page25 users_list                   /////users->user list  ***help link is not available
page26 change_password
page27 category
page28 article_type
page29 author_checklist		/////Author->Check List   ***help link is not available
page30 bank_details
page31 subscriber_list
page32 profile                
page33 article                ///////Publisher->Articles   ***it opens in new tab 
page34 rejected_manuscript
page35 revised_manuscript
page36 layout		/////Site Manager->Layout    ***help link is not available
page37 template

*/
if($page=='attendanceH')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Present Employees</b></h3>
	<p class="simpleH">When employees starts punching their attendance on regular basis their attendance starts appear under this section.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p  class="simpleH">1. Click on <b>“Present”</b> under <b>“Today’s Attendance”</b> from the left menu.</p>
<p class="simpleH">2. A table will appear which contains columns like : </p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Shift </b><br/>
 <b>• Time In</b> <br/>
 <b>• Time In Selfie</b><br/>
 <b>• Time In Location</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Time Out Image</b> <br/>
 <b>• Time Out Location</b> <br/>
 <b>• Logged Hours</b> <br/>
 <b>• Status</b> <br/> 
  
<br>
 <b>• <b style="color: green;">P</b>  - Present </b> <br/>
 <b>• <b style="color: green;">EC</b> - Early Coming</b><br/>
 <b>• <b style="color: green;">LC</b> - Late Coming</b> <br/>
 <b>• <b style="color: green;">EL</b> - Early Leaving</b><br/>
 <b>• <b style="color: green;">LL</b> - Late Leaving</b> <br/>
 <b>• <b style="color: green;">OT</b> - Over Time</b> <br/>
 <b>• <b style="color: green;">UT</b> - Under Time</b> <br/>

 <h4 style="color:purple;"><b>How to track visit(s)?</b></h4>
 <p  class="simpleH">To view the list of employees who are punching their attendance from different locations, Click on <b>“Track Visit(s)”</b> in the <b>“Action” </b>column. </p>

<h4 style="color:purple;"><b>How to delete attendance?</b></h4>
<p class="simpleH">1. To delete the attendance, Click on <b>"<span style="color:purple;font-size:20px;"> <i class="fa fa-trash"></i></span>"</b> Icon which is in the <b>“Action”</b> column.</p>
<p class="simpleH">2. A pop-up will appear asking for a confirmation.</p>
<p class="simpleH">3. Click on <b>"Delete"</b> button, The attendance will get deleted.</p>

<p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note: You can delete the attendance only for today, yesterday and day before yesterday. (Based on Add on feature)</i></b></p>
<h4 style="color:purple;"><b>How to edit Attendance?</b></h4>

<p class="simpleH">1. To edit attendance, Click on <b>“<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span> ”</b> Icon which is in the <b>“Action”</b> column.</p>
<p class="simpleH">2. A pop-up will appear asking you to edit the details.</p>
<p class="simpleH">3. Click on <b>“Update”</b> button, The attendance will get updated.</p>

<p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note: You can edit the attendance only for today, yesterday and day before yesterday.(Based on add on feature)</i></b></p>
</div>
</div>
<?php
}elseif($page=='userInactive')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Inactive Employees</b></h3>
	<p class="simpleH">Inactive employees are those users who have left the organization Their names will not appear in current attendance reports. In this section, Inactive employee profiles can be viewed.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Click on <b>“Inactive Employees”</b> under <b>“Employees”</b> from the left menu, A table will appear which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Username / Email</b><br/>
 <b>• Department</b><br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Phone</b> <br/>
 <b>• Status</b> <br/>
 <b>• Action</b> <br/>
 </p>
<h4 style="color:purple;"><b>To change the status: </b></h4>
<p class="simpleH">  1. To active an employee, Click on "<span style="color:purple;font-size:20px;"><i class= "fa fa-thumbs-up"></i></span>" Icon which is in the <b>“Action”</b> column.</p>
<p class="simpleH"> 2. A pop-up will appear asking for a confirmation.</p> 
<p class="simpleH"> 3. Click on <b>“Yes”</b> button to update the inactive employee.</p> 
 

<h4 style="color:purple;"><b>To archive an inactive employee:</b></h4>
<p class="simpleH">  1. To archive an employee, Click on "<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span>" Icon which is in the <b>“Action”</b> column.</p> 
<p class="simpleH"> 2. A pop-up will appear asking for a confirmation.  </p> 
<p class="simpleH"> 3. When you click on <b>"Yes”</b> button, Employee will be archived.</p> 
 <br/>
</div>
</div>
<?php
}elseif($page=='userH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Add Employees</b></h3>
 <p style="color: black;" class="simpleH">Employees who’s attendance needs to be marked on daily basis can be added under this column.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">1.Click on <b>“Add Employees”</b> under <b>“Employees”</b> from the left menu, A window will open which will contain following required fields like :</p>
<p class="simpleH">
 <b>• Full Name </b> <br/>
 <b>• Contact no</b><br/>
 <b>• Password </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Department</b> <br/>
 <b>• Country</b> <br/>
 <b>• Designation</b> <br/>
 <p class="simpleH">2. Click on <b>“Submit”</b> button to add the employee(s).</p>
 <h4 style="color:purple;"><b>Import Employees : </b></h4>
 <p class="simpleH">Multiple employees can be added through import. </p>
<p class="simpleH"> 1. Click on <b>“Import Employees”</b> download the sample file and follow the steps given.</p> 
<p class="simpleH"> 2. Upload the CSV file to <b>“Select Import file”</b> and click on <b>“Import User”</b>.</p> 
<p class="simpleH"> 3. Employees data will get uploaded.</p> 

<h4 style="color:purple;"><b>Self Registration : </b></h4>
<p class="simpleH">In this section, Employees can register themselves :</p>

<p class="simpleH"> 1. Click on <b>“Self Registration”</b>, A pop up will appear which will ask you to insert <b>“Email(s)”</b>.</p>
<p class="simpleH"> 2. Insert email for multiple emails use comma and click on <b> “Send Registration Link”</b>. </p> 
<p class="simpleH"> 3. Direct link will go to employee through which they can register themselves.  </p> 

<!-- <p class="simpleH"> > Click on "Close" button to cancel the process.</p> --> 
<br/>

</div>
</div>
<?php
}elseif($page=='useri')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Active Employees</b></h3>
 <p class="simpleH">Active employees are those employees who mark their attendance regularly. In this section, Active Employees profiles can be viewed & managed.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Click on <b>“Active Employees”</b> under <b>“Employees”</b> from the left menu, A table will appear which contains columns like:</p>
<p class="simpleH">
 <b>• Photo </b> <br/>
 <b>• Name </b><br/>
 <b>• Department</b> <br/>
 <b>• Designation</b> <br/>
 <b>• Shift</b> <br/>
 <b>• User ID/Phone no</b><br/>
 <b>• Permission </b> <br/>
 <b>• Action </b> <br/>
 </p>
 <h4 style="color:purple;"><b>To add an active employee: </b></h4>
 <p class="simpleH">1. To add an employee, Click on <b>"+Add Employee"</b> button which is at the top-left.</p>
 <p class="simpleH">2.  A pop-up will appear to fill the employee details.</p>
 <p class="simpleH">3. Click on <b>"Save"</b> button to save the employee details.</p>
 <h4 style="color:purple;"><b>To edit active employee: </b></h4>
 <p class="simpleH">1. To edit an employee, Click on "<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span> " Icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear which will show the details.</p>
 <p class="simpleH">3. Enter the details you want to edit or change.</p>
 <p class="simpleH">4. Click on <b>"Update"</b> button to update the employee details.</p>
<h4 style="color:purple;"><b>To archive an active employee: </b></h4>
<p class="simpleH">1. To archive an employee, Click on "<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span> " Icon which is in the <b>“Action”</b> column.</p>
<p class="simpleH">2. A pop-up will appear asking you to archive an employee.</p>
<p class="simpleH">3. Click on <b>"Archive"</b> button, Employee will be archive.</p>
<p style="color: #4F81BD;font-family: Cambria (Headings)"><i><b>Note: Archived users will still be counted in registered users. To reduce the no. of registered users, delete the user from the Archived list also.</b></i></p>
</div>
</div>
<?php
}elseif($page=='shiftH')
{
 ?>
 <!--<div class="col-md-12" style="background-color:#eed9fc;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Shifts</b></h3>
	<p class="simpleH">To manage multiple shifts of an organization under this section shifts can be created and assigned.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH">To view the list of shifts, Click on <b>“Shifts”</b> from the left menu, A table will appear which contains columns like :</p>
<p class="simpleH">
 <b>• Shifts </b> <br/>
 <b>• Time In</b><br/>
 <b>• Time Out</b> <br/>
 <b>• Break Start Time</b><br/>
 <b>• Break End Time</b><br/>
 <b>• Time In Grace</b><br/>
 <b>• Time Out Grace</b><br/>
 <b>• Shift Type</b><br/>
 <b>• Shift Hours</b><br/>
 <b>• Work Hours</b><br/>
 <b>• Status</b> <br/>
 <b>• Action</b> <br/>
 <h4 style="color:purple;"><b>To add a Shift :</b></h4>
<p class="simpleH"> 1. To add shift, Click on <b>"+Add"</b> button which is at the top-right.<br/>
2. A window will appear to fill the shift details.<br/>
3.Fill the given fields below :<br/><br>
<b style="color:purple;">• Shift type</b><br/>
<span ><b style="color:green;">Single Date-</b></span>Shift which starts & ends on the same date.<br/>
<span style=""><b style="color:green;">Multi Date-</b></span>Shift which ends on consecutive date & crosses midnight (12:00 AM).<br/>
<b>
• Shift Name<br/>
• Status<br/>
• Time In<br/>
• Time Out<br/>
• Break Starts At<br/>
• Break Ends At<br/>
• Grace Time In<br/>
• Grace Time Out<br/>
• Monthly Shift Calendar(To set the week-offs)</b><br/>
 
4. Click on <b>“Save” </b>button to save the shift details.
</p> 

<h4 style="color:purple;"><b>To Edit a Shift : </b></h4>
<p class="simpleH"> 1. To edit a shift, Click on "<span style="color:purple;font-size:20px;"><i class= "fa fa-pencil"></i></span>" Icon which is in the <b>“Action”</b> column.<br/>
2. A window will appear which will show the shift details.<br/>
3. Enter the details you want to edit or change.<br/>
4. Click on <b>"Save"</b> button to update the shift details.</p> 

<h4 style="color:purple;"><b> To Delete a Shift :</b></h4>
<p class="simpleH"> 1. To delete a shift, Click on <b>"<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span>"</b> Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking you to delete the shift.<br/>
3. Click on <b>"Delete"</b> button, Shift will get deleted. <br/>


<h4 style="color:purple;"><b> To Assign a Shift :</b></h4>
<p class="simpleH">
	1. Click on <b>“<img src="<?=URL?>../assets/img/unnamed.png" height="20px" width="20px"/>”</b> Icon which is in the <b>“Action”</b> column.<br/>
2. A pop- up will appear asking you to select the employee(s).<br/>
3. Select the employee(s), Click on <b>“Update”</b> button, Shift will be assigned to the employee(s).


</p>

</div>
</div>

<?php
}elseif($page=='departH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Departments</b></h3>
	<p class="simpleH">Various departments can be added at once by importing the CSV file.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH">Click on <b>“Departments”</b> from the left menu, A table will appear which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Status</b> <br/>
 <b>• Action</b> <br/>
 <h4 style="color:purple;"><b>To add a Department : </b></h4>
<p class="simpleH"> 1. To add a Department, click on <b>"+Add"</b> Button which is at the top-right.<br/>
	
2.  A pop-up will appear to add a department.<br/>
3. Click on <b>"Save"</b> button to save the department name.</p> 

<h4 style="color:purple;"><b>To import department : </b></h4>
<p class="simpleH">
	1. To add Departments in a bulk, Click on <b>"Import"</b> Button which is at the top-right.<br/>
2. Follow the instructions and upload the file in csv format.<br/>
3. Click on <b>“Choose file”</b> upload the csv file and click on <b>“Import”</b>.<br/>
4. Departments will get uploaded.
</p>
<!-- <p><u><b style="color: blue;">How to import departments & Designations</b></u></p> -->
<h4 style="color:purple;"><b>To edit a department : </b></h4>
<p class="simpleH"> 1. To edit a department, Click on "<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span>" Icon which is in the <b>“Action” </b>column.<br/>
2. A pop-up will appear asking you to edit the details.<br/>
3. Click on <b>"Update"</b> button to update the department details.</p> 

<h4 style="color:purple;"><b> To delete a department :</b></h4>
<p class="simpleH"> 1. To delete a department, Click on "<span style="color:purple;font-size:20px;"> <i class="fa fa-trash"></i></span>" Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking you to delete a department.<br/>
3. Click on <b>"Delete"</b> button, Department will get deleted.
</p> <br/>
</div>
</div>
<?php
}elseif($page=='desgH')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Designations</b></h3>
	<p class="simpleH">Various designations can be added at once by importing the CSV file.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Click on <b>“Designations”</b> from the left menu, A table will appear  which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Status</b> <br/>
 <b>• Action</b> <br/>
 <h4 style="color:purple;"><b>To add a Designation : </b></h4>
<p class="simpleH"> 1. To add a designation, Click on <b>"+Add"</b> button which is at the top-right.<br/>
2. A pop-up will appear to add a designation.<br/>
3. Click on <b>"Save"</b> button to save the designation name.</p> 

<h4 style="color:purple;"><b>To import  designations : </b></h4>
<p class="simpleH">
	1. To add designations in a bulk, Click on <b>"Import"</b> button which is at the top-right.<br/>
2.  Follow the instructions and upload the file in csv format.<br/>
3. Click on <b>“Choose file”</b> upload the csv file and click on <b>“Import”</b>.<br/>
4. Designations will get uploaded.


</p>

<h4 style="color:purple;"><b>To edit a designation: </b></h4>
<p class="simpleH"> 1. To edit a designation, Click on <b>"<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span>"</b> Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking you to edit the details.<br/>
3. Click on <b>"Update"</b> button to update the designation details.
</p> 

<h4 style="color:purple;"><b> To delete a designation:</b></h4>
<p class="simpleH"> 1. To delete a designation, Click on <b>"<span style="color:purple;font-size:20px;"> <i class="fa fa-trash"></i></span>"</b> Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking you to delete a designation.<br/>
3. Click on <b>"Delete"</b> button, Designation will get deleted.
</p> <br/>
</div>
</div>
<?php
}elseif($page=='absentH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Absent Employees</b></h3>
	<p class="simpleH">Employees who have not marked their attendance or are absent starts appearing under <b>“Employees-Absent”.</b></p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">1. Click on <b>“Absent”</b> under <b>“Today’s Attendance”</b> from the left menu.</p>
 <p class="simpleH"> A table will appear  which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 
</div>
</div>
<?php
}elseif($page=='monthlysummary')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Monthly Summary</b></h3>
	<p class="simpleH">Employee’s brief monthly attendance summary can be viewed under this section.</b></p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Click on <b>“Monthly Summary”</b> from the left menu to view employees monthly attendance. A table will appear which contains options like :  </p>
<p class="simpleH">
 <b>• Date </b> <br/>
 <b>• Status </b> <br/>
 <b>• <b style="color: green;">P</b> - Present </b> <br/>
 <b>• <b style="color: green;">A</b> - Absent</b><br/>
 <b>• <b style="color: green;">WO</b>- Week Off</b> <br/>
 <b>• <b style="color: green;">H</b> - Holiday</b><br/>
 <b>• <b style="color: green;">HD</b>- Half Day</b> <br/>
 <b>• <b style="color: green;">L</b> - Leave</b> <br/>
 <b>• <b style="color: green;">N/A</b>- Not Applicable</b> <br/><br>
 <b>• Time In </b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Time In Date </b> <br/>
 <b>• Time Out Date</b> <br/>
 <b>• Late By</b> <br/>
 <b>• Left Early By</b> <br/>
 <b>• Overtime</b> <br/>
 <b>• Under time</b> <br/>
 <b>• Logged Hours</b> <br/>
 <b>• Time Off</b> <br/>
 <p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note:The employees who have not marked time out will be appear with “*” icon.</i></b></p>
</div>
</div>
<?php
}elseif($page=='monthlyregister')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Monthly Register</b></h3>
	<p class="simpleH">Employee’s brief monthly attendance summary can be viewed under this section. </b></p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Click on <b>“Monthly Register”</b> under <b>“Attendance Reports”</b> from the left menu to view employees punched attendance. A table will appear which contains fields like : </p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Code</b> <br/>
 
 <b>• Date </b> <br/>
 <b>• Total Present</b> <br/>
 <b>• Total Absent</b> <br/>
 <b>• Weekly Offs</b> <br/>
 <b>• Total Holiday</b> <br/>
 <b>• Total Half Day</b> <br/>
 <b>• Total Leave</b> <br/>
 
</div>
</div>
<?php
}elseif($page=='attendance1')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Present Employees</b></h3>
	<p  class="simpleH">Employees who have marked their attendance or are present starts appearing under this section.</p>
 <!-- <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p  class="simpleH">Click on <b>“Attendance Reports”</b> from the left menu, A table will appear which contains columns like : </p>
<p class="simpleH"><b>
• Present<br/>
• Absent<br/>
• Late Comers<br/>
• Early Leavers<br/>
• Overtime<br/>
• Under time<br/>
• Not Synced<br/>
• On Time Off<br/>
• Punched Visits<br/>
• Flexi Reports<br/>
• Hourly Pay<br/>
 </b></p>
 -->
 <h4 style="color:purple;"><b>To view list of present employees :</b></h4>
 <p class="simpleH">Click on <b>“Present”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>

 <p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Shift </b><br/>
 <b>• Time In</b> <br/>
 <b>• Time In Image</b><br/>
 <b>• Time In Location</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Time Out Image</b> <br/>
 <b>• Time Out Location</b> <br/>
 <b>• Logged Hours</b> <br/>
 <b>• Action</b> <br/>
 <b>• Status :</b> <br/> <br/>   

 <b>• <b style="color: green;">P</b> - Present </b> <br/>
 <b>• <b style="color: green;">EC</b> - Early Coming</b><br/>
 <b>• <b style="color: green;">LC</b> - Late Coming</b> <br/>
 <b>• <b style="color: green;">EL</b> - Early Leaving</b><br/>
 <b>• <b style="color: green;">LL</b> - Late Leaving</b> <br/>
 <b>• <b style="color: green;">OT</b> - Over Time</b> <br/>
 <b>• <b style="color: green;">UT</b> - Under Time</b> <br/>

</p>
<h4 style="color:purple;"><b>How to delete the attendance?</b></h4>
<p class="simpleH">1. To delete the attendance, Click on "<span style="color:purple;font-size:20px;"> <i class="fa fa-trash"></i></span>" Icon which is in the <b>“Action”</b> column.</p>
<p class="simpleH">2. A window will appear asking for a confirmation.</p>
<p class="simpleH">3. When you click on <b>"Delete"</b> button, The Attendance will be deleted.</p>

<p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note: You can delete the attendance only for today, yesterday and day before yesterday. ( Based on Add on feature)</i></b></p>
<h4 style="color:purple;"><b>How to track visit(s)?</b></h4>
<p class="simpleH">To track the locations of employees, Click on <b>“Track Visit(s)”</b> in the <b>“Action”</b> column to see the visits.</p>

</div>
</div>
<?php
}elseif($page=='lateH')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Late Comers</b></h3>
	<p class="simpleH">When employees punch their attendance after their shift start timing appears under <b>“Late Comers Today”.</b>
</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH" >1. Click on <b>“Late Comers Today”</b> under <b>“Today’s Attendance”</b> from the left menu.</p> 
 <p class="simpleH">2. A table will appear  which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Time In</b> <br/>
 <b>• Late By</b> <br/>
</div>
</div>
<?php
}elseif($page=='latecomer')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
<!--  <h3 style="color:purple;"><b>Attendance Reports</b></h3>
	<p class="simpleH">According to the attendance various reports gets generated under this section.
</p> -->
 <h3 style="color:purple;"><b>Late Comers </b></h3>
 <p class="simpleH" >When employees punch their attendance after their shift start timing appears under this section.</p>
 <h4 style="color:purple;"><b>To view list of late comers : </b></h4>
 <p class="simpleH">Click on <b>“Late Comers”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :  </p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Designation</b> <br/>
 <b>• Department </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Time In</b> <br/>
 <b>• Late By</b> <br/>
</div>
</div>
<?php
}elseif($page=='earlyH')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Early Leavers</b></h3>
	<p class="simpleH">When employees punch out attendance before their shift end timing starts appearing under <b>“Early Leavers-Today”</b>.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH" >1. Click on <b>“Early Leavers Today”</b> under <b>“Today’s Attendance”</b> from the left menu.</p> 
 <p class="simpleH">2. A table will appear  which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Early By </b> <br/>

</div>
</div>
<?php
}elseif($page=='earlyreport')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Attendance Reports</b></h3>
	<p class="simpleH">According to the attendance various reports gets generated under this section.

</p>
 <h4 style="color:purple;"><b>Early Leavers </b></h4>
 <p class="simpleH" >When employees punch out attendance before their shift end timing starts appearing under this section.</p>
 <p>
 <h4 style="color:purple;"><b>To view list of early leavers :</b></h4>
 <p class="simpleH">Click on <b>“Early Leavers”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 <p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Early By </b> <br/>
</p>
</div>
</div>

 <?php
}elseif($page=='annualH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Holidays</b></h3>
	<p class="simpleH">The annual holidays of an organization can be managed under the column <b>“Holidays”</b>.

</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH" >To view the list of holidays, Click on <b>“Holidays”</b> under <b>“Settings”</b> from the left menu, A table will appear which contains columns like :<br/>
<b>• Holiday</b> <br/>
<b>• Description</b> <br/>
<b>• From</b> <br/>
<b>• To</b> <br/>
<b>• Total Days </b><br/>
<b>• Action </b><br/>

</p>

 
<h4 style="color:purple;"><b>To add a Holiday :</b></h4>
<p class="simpleH"> 1. To add a holiday, Click on <b>"+Add"</b> button which is at the top-right.<br/>
2. A pop-up will appear to fill the holiday details.<br/>
3. Click on <b>"Save"</b> button to save the holiday details.</p> 

<h4 style="color:purple;"><b>To edit a Holiday : </b></h4>
<p class="simpleH"> 1. To edit a holiday, Click on “<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span>” Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking to change or edit holiday details.<br/>
3. Enter the details, Click on <b>"Update"</b> button to update the holiday details.</p>
<p style="color: #4F81BD;font-family: Cambria (Headings)"><b><i>Note- A holiday cannot be edited if it is a past event.</i></b></p> 

<h4 style="color:purple;"><b> To delete a Holiday :</b></h4>
<p class="simpleH">1. To delete a holiday, Click on "<span style="color:purple;font-size:20px;"> <i class="fa fa-trash"></i></span>" Icon which is in the <b>“Action”</b> column.<br/>
2. A pop-up will appear asking you to delete a holiday.<br/>
3. Click on <b>"Delete"</b> button, Holiday will get deleted.</p> 
<p style="color: #4F81BD;font-family: Cambria (Headings)"><b><i>Note- A holiday cannot be deleted if it is a past event.</i></b></p>

</div>
</div>
<?php
}elseif($page=='absent')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
	<p class="simpleH">According to the attendance various reports gets generated under this section.</b> </p> -->
 <h3 style="color:purple;"><b>Absent Employees</b></h3>
 <p  class="simpleH">Employees who have not marked their attendance or are absent starts appearing under this section.</p>
 <h4 style="color:purple;"><b>To view list of absent employees :</b></h4>
 <p class="simpleH">Click on <b>“Absent”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Designation</b> <br/>
 <b>• Department</b><br/>
 <b>• Shift </b><br/>
 
<br>
 
</div>
</div>
<?php
}elseif($page=='notsync')
{
 ?>
<div class="card" style="margin-top: -440px; margin-left:800px; 
">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Absent Employees</b></h3>
	<p class="simpleH">Employees who have not marked their attendance or are absent starts appearing under<b> “Employees-Absent”</b> </p>
 <h3 style="color:purple;"><b>How it works? </b></h3>
 <p  class="simpleH">To view the list of employees who have not marked their attendance or to see absent employees, Click on <b>“Employees- Absent” </b>given below columns will appear </p>
<p>
 <b>• Name </b> <br/>
 <b>• Shift </b><br/>
 <b>• Designation</b> <br/>
 <b>•  Department</b><br/>
<br>
 
</div>
</div>
<?php
}elseif($page=='overtimereport')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section.</p> -->
 <h3 style="color:purple;"><b>Over Time</b></h3>
 <p class="simpleH">When employees work even after their shift end timing that extra time is called over time.</p>
 <h4 style="color:purple;"><b>To view list of over time :</b></h4>
 <p class="simpleH">Click on <b>“Over Time”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Designation</b> <br/>
 <b>• Department</b><br/>
 <b>• Shift </b><br/>
 <b>• Overtime </b><br/>
</p>
</div>
</div>
<?php
}elseif($page=='undertimereport')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>Under Time</b></h3>
 <p class="simpleH">When employees work lesser than their shift timing that is called under time.</p>
 <h4 style="color:purple;"><b>To view list of under time :</b></h4>
 <p class="simpleH">Click on <b>“Under Time”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Designation</b> <br/>
 <b>• Department</b><br/>
 <b>• Shift </b><br/>
 <b>• Under time </b><br/>
</p>
</div>
</div>
<?php
}elseif($page=='notsynced')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>Not Synced</b></h3>
 <p class="simpleH">Employees rejected attendance can be viewed under this section.</p>
 <h4 style="color:purple;"><b>To view list of not synced :</b></h4>
 <p class="simpleH">Click on <b>“Not Synced”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Sync Date </b> <br/>
 <b>• Date</b> <br/>
 <b>• Action</b><br/>
 <b>• Time </b><br/>
 <b>• Selfie </b><br/>
 <b>• Location </b><br/>
 <b>• Failure Reason </b><br/>
</p>
</div>
</div>
<?php
}elseif($page=='Timeoffreport')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>On time off</b></h3>
 <p class="simpleH">When employee's apply for a time off in between their working hours. Monthly report of employees can be viewed under this section.</p>
 <h4 style="color:purple;"><b>To view list of on time off :</b></h4>
 <p class="simpleH">Click on <b>“On Time Off”</b>. under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• From</b> <br/>
 <b>• To</b><br/>
 <b>• Duration </b><br/>
 <b>• Approval status </b><br/>
 <b>• Reason </b><br/>
   
</p>
</div>
</div>
<?php
}elseif($page=='Punchvisit')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>Punched Visits</b></h3>
 <p class="simpleH">When employee's punch their attendance from different locations. List of visits can be viewed under this section.</p>
 <h4 style="color:purple;"><b>To view list of punched visits :</b></h4>
 <p class="simpleH">Click on <b>“Punched Visits”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Employee </b> <br/>
 <b>• Visit Client</b> <br/>
 <b>• Visit In </b><br/>
 <b>• Time In </b><br/>
 <b>• Location In </b><br/>
 <b>• Visit Out </b><br/>
 <b>• Time Out</b><br/>
 <b>• Location Out </b><br/>
 <b>• Remarks </b><br/>
</p>
</div>
</div>
<?php
}elseif($page=='departdash')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category" style="font-weight:100 !important;">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Department Dashboard</b></h3>
 <p class="simpleH" style="font-weight:100 !important;">Employees can be viewed according to the department wise.</p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH"style="font-weight:100 !important;">1. Click on <b>“ Department Dashboard”</b> under <b>“Today’s Attendance”</b> from the left menu.</p>
 <p class="simpleH"style="font-weight:100 !important;">2. A department dashboard will appear which contain the departments.</p>
 <p class="simpleH"style="font-weight:100 !important;">3. Select the particular department and the report will get generated of that department.</p>
 
 </div>
</div>
<?php
}elseif($page=='alert')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Alerts</b></h3>
 <p class="simpleH">Admin receives a daily attendance summary through the mail at a specific timing. </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">1.Click on <b>“Alerts”</b> from the left menu.</p>
 <p class="simpleH">2.A window will appear which will ask you to receive <b>Daily mail</b><b> summary</b> and <b>Yes & No</b> button.</p>
 <p class="simpleH">3.Select the <b>timings</b> from drop-down at which you want to receive the summary report.</p>
 <p class="simpleH">4. Click on <b>"Update"</b> button.</b></p>
 </div>
</div>
<?php
}elseif($page=='profile')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Company Profile </b></h3>
 <p class="simpleH">A company’s detail are shown under this section to make any changes or edit the company’s details, It can be done under this. </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">1. To edit the fields, Click on <b>“Edit”</b> Icon, And the fields given below can only be edited :</p>
 <p class="simpleH"><b>
 	• Company<br>
 	• Website<br>
 	• Email<br>
 	• Address<br>
 </b></p>
 <p class="simpleH">2. Click on <b>“Done”</b> button, To update the changes.</p>
 <h4 style="color:purple;"><b>How to change the password of web admin panel ?</b></h4>
 <p class="simpleH">To change the password of web admin panel : </p>
 <p class="simpleH">1. Click on <b>“Company’s Profile”</b> in <b>"Settings"</b>, Go to the below page. </p>
 <p class="simpleH">2. Enter your <b>“Current Password”</b>. </p>
 <p class="simpleH">3. Enter your <b>“New Password”</b>.</p>
 <p class="simpleH">4. Re-enter your new password in <b>“Confirm Password”</b>, and click on <b>"Submit"</b> button.</p>
 </div>
</div>
<?php
}elseif($page=='approvetime')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Time Off</b></h3>
 <p class="simpleH">Time off is applied by employees in between their working hours and it is approved by admin. </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">Click on <b>“Approve Time Off”</b> from the left menu, A table will appear which contains columns like :</p>
 <p class="simpleH">
 	<b>• Employees</b><br>
 	<b>• Applied on</b><br>
 	<b>• Time Off Date</b><br>
 	<b>• From</b><br>
 	<b>• To</b><br>
 	<b>• Duration</b><br>
 	<b>• Reason</b><br>
 	<b>• Status</b><br>
 </p>
 <h4 style="color:purple;"><b>How to approve pending request ?</b></h4>
 <p class="simpleH">1.Click on <b>"Pending"</b> button.</p>
 <p class="simpleH">2.Select the status from the drop-down.</p>
 <p class="simpleH">3.Add remarks.</p>
 <p class="simpleH">4.Click on <b>"UPDATE"</b> button.</p>
 </div>
</div>
<?php
}elseif($page=='selfie')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Permission</b></h3>
 <p class="simpleH">Attendance can be marked either with selfie or without selfie. Under this section, We can enable or disable the settings.  </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">Click on <b>“Selfie”</b> from the settings in the left menu, A table will appear which contains 2 options like :</p>
 <p class="simpleH">
 	<b>•Attendance Picture</b><br>
 	<b>•Visit Picture</b><br>
 	<b>•Geo Fence Policy</b><br>
 </p>
 <p class="simpleH">Click on the radio button and click on <b>Update</b> button.</p>
 </div>
</div>
<?php
}elseif($page=='activitylog')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Activity Log</b></h3>
 <p class="simpleH">Activity log helps to track who does what on the panel. It helps to monitor all the activities performed. </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">Click on <b>“Activity Log”</b> from the left menu, a table will appear which contains columns like :</p>
 <p class="simpleH">
 <b>• Activities </b><br>	
 <b>• Module</b><br>	
 <b>• Users</b><br>	
 <b>• Date & Time</b><br>	
 </p>
 
 </div>
</div>
<?php
}elseif($page=='hourlyrate')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Hourly Rate</b></h3>
 <p class="simpleH">In this section, Hourly rate can be created and assigned to employees for calculating wages.  </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">Click on <b>“Hourly Rate”</b> from the left menu, A table will appear which contains columns like :</p>
 <p class="simpleH">
 <b>•Name</b><br>
 <b>•Rates</b><br>
 <b>•Status</b><br>
 <b>•Action</b><br>	
 </p>
 <h4 style="color:purple;"><b>To add a rate :</b></h4>
 <p class="simpleH">1. To add a rate, Click on <b>"+Add"</b> button which is at the top-right.</p>
 <p class="simpleH">2.  A pop-up will appear to fill the details.</p>
 <p class="simpleH">3. Click on <b>"Save"</b> button to save the hourly rate.</p>
 <h4 style="color:purple;"><b>To edit a rate :</b></h4>
 <p class="simpleH">1. To edit a rate, Click on <b>"<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span>"</b> Icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear which will show rate details.</p>
 <p class="simpleH">3. Enter the details you want to edit or change.</p>
 <p class="simpleH">4.  Click on <b>"Save"</b> button to update the rate details.</p>
 <h4 style="color:purple;"><b>To delete a rate :</b></h4>
 <p class="simpleH">1. To delete a rate, click on <b>"<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span> "</b> Icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear asking you to delete the rate.</p>
 <p class="simpleH">3. Click on <b>"Delete"</b> button, rate will get deleted.</p>
 </div>
</div>
<?php
}elseif($page=='geofence')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;" ><b>Geo-Fence</b></h3>
 <p class="simpleH">Employees can be assigned a specific area within which they can mark the attendance.  </p>
 <h4 style="color:purple;"><b>How it works?</b></h4>
 <p class="simpleH">To set a geo-fence, Click on <b>“Geo-Fence”</b> from the left menu, A table will appear which contains columns like :</p>
 <p class="simpleH">
 <b>• Geo center name</b><br>
 <b>• Geo centres</b><br>
 <b>• Radius(km)</b><br>
 <b>• Status</b><br>
 <b>• Action</b><br>	
 </p>
 <h4 style="color:purple;"><b>To add a geo center :</b></h4>
 <p class="simpleH">1. To add a geo center, Click on <b>"+Add"</b> button which is at the top-right.</p>
 <p class="simpleH">2. A window will appear to add the details.</p>
 <p class="simpleH">3. A map will be shown on the screen, Click on <b>“Enter Your Location”</b>, Drag the <b>“Hand”</b> Icon to the exact location, Click on <b>“OK”</b> to set <b>“Latitude and Longitude”</b>.</p>
 <p class="simpleH">4. Set the geo-fence radius.</p>
 <p class="simpleH">5. Click on <b>“Add”</b>, Geo center will get created.</p>

 <h4 style="color:purple;"><b>To edit a geo center :</b></h4>
 <p class="simpleH">1. To edit a geo center, Click on <b>"<span style="color:purple;font-size:20px;"> <i class="fa fa-pencil"></i></span>  "</b> Icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear asking you to edit the details.</p>
 <p class="simpleH">3. Click on <b>"Update"</b> button to update the geo center details.</p>
 
 <h4 style="color:purple;"><b>To delete a geo center :</b></h4>
 <p class="simpleH">1. To delete a geo center, click on <b>"<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span>"</b> Icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear asking you to delete a geo center.</p>
 <p class="simpleH">3. Click on <b>"Delete"</b> button, Geo center will be deleted.</p>

 <h4 style="color:purple;"><b>To assign a geo center :</b></h4>
 <p class="simpleH">1. To assign a geo center to the employee(s), Click on <b>“<img src="<?=URL?>../assets/img/unnamed.png" height="20px" width="20px"/>”</b> icon which is in the <b>“Action”</b> column.</p>
 <p class="simpleH">2. A pop-up will appear asking you to select the employee(s).</p>
 <p class="simpleH">3. Click on <b>“Update”</b>, Geo center will be assigned to the employee(s).</p>
 <!-- <p><b><u style="color: blue;">How to create,assign & check geo fence</u></b></p> -->
 </div>
</div>
<?php
}elseif($page=='flexireport')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>Flexi Report</b></h3>
 <p class="simpleH">Employees who are not allotted any shift can punch their attendance through flexi time in.</p>
 <h4 style="color:purple;"><b>To view list of flexi time in :</b></h4>
 <p class="simpleH">Click on <b>“Flexi Reports”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Employee </b> <br/>
 <b>• Visit In </b><br/>
 <b>• Time In </b><br/>
 <b>• Location In </b><br/>
 <b>• Visit Out </b><br/>
 <b>• Time Out</b><br/>
 <b>• Location Out </b><br/>
 <b>• Logged Hours </b><br/>
 <b>• Action </b><br/>
</p>
<p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note: Based on add on feature</i></b></p>
</div>
</div>
<?php
}elseif($page=='hourlypay')
{
 ?>
 <!--<div class="col-md-12" style="background-image:url(<?=URL?>../assets/img/bg7.jpg); background-repeat:no-repeat; width:400px; height:800px;">-->
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <!-- <h3 style="color:purple;"><b>Attendance Reports</b></h3>
 <p class="simpleH">According to the attendance various reports gets generated under this section</p> -->
 <h3 style="color:purple;"><b>Hourly Pay</b></h3>
 <p class="simpleH">Money that is paid or received for work or services, as by the hour. </p>
 <h4 style="color:purple;"><b>	To view list of hourly pay :</b></h4>
 <p class="simpleH">Click on <b>“Hourly Pay”</b> under <b>“Attendance Reports”</b> from the left menu. A table will appear which contains columns like :</p>
 	<p class="simpleH">
 <b>• Name </b> <br/>
 <b>• Worked Hours </b><br/>
 <b>• Hourly Pay </b><br/>
 <b>• Amount </b><br/>
 <b>• Action </b><br/>
</p>
<p style="color: #4F81BD;font-family: Cambria (Headings)" class="simpleH"><b><i>Note: Based on add on feature</i></b></p>
</div>
</div>
<?php
} elseif($page=='userArch')
{
 ?>

 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Archieved Employees</b></h3>
 <p class="simpleH">Archive employees are those inactive employees who’s attendance records are no longer required. Archive employees can be deleted permanently.</p>
<h4 style="color:purple;"><b>How it Works ? </b></h4>
<p class="simpleH">Click on <b>“Archive Employees”</b> from the left menu, A  table will appear which contain columns like :</p>
<p class="simpleH"><b>
• Name<br>
• Designation<br>
• Department<br>
• Action
</b></p>
<h4 style="color:purple;"><b>To permanently delete : </b></h4>
<p class="simpleH">
	1. To permanently delete an employee, Click on <b>"<span style="color:purple;font-size:20px;"><i class= "fa fa-trash"></i></span> "</b> Icon which is in the <b>“Action”</b> column.<br>
    2. A confirmation pop up will appear.<br>
    3. Click on <b>“Delete ”</b> button to permanently delete the employee.<br>

</p>
<h4 style="color:purple;"><b>To restore employee :</b></h4>
<p class="simpleH">1.To restore an employee, click on <b>"<span style="color:purple;font-size:18px;"><i class="unarchive fa fa-archive"></i></span>"</b> Icon which is in the “Action” column.</p>
<p class="simpleH">2. A confirmation pop up will appear.</p>
<p class="simpleH">3. Click on <b>“Restore”</b> to make employee an active user.</p>
</div>
</div>
<?php
}elseif($page=='departLogged')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for admin</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Department Summary</b></h3>
	<p class="simpleH">Employees attendance summary can be viewed according to department wise.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH">Click on <b>“Department Summary”</b> under <b>“Today’s Attendance”</b> from the left menu.</p>
  <p class="simpleH">2. A table will appear  which contains columns like :</p>
<p class="simpleH">
 
 <b>• Departments</b><br>
 <b>• Total</b><br>
 <b>• Present</b><br>
 <b>• Absent</b><br>
 <b>• Late Comers</b><br>
 <b>• Early Leavers</b><br>

</p>
</div>
</div>
 <?php
}

else{
?>
<h4> &nbsp;&nbsp; &nbsp;No Help Found</h4>
<?php

}
?>
</div>
</body>
</html>
 

