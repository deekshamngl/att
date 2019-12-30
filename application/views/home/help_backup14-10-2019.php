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
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Attendance</b></h3>
	<p class="simpleH">In this section, Attendance can be viewed & managed using Edit/Delete functionality.</p>
 <h3 style="color:purple;"><b>How it Works? </b></h3>
 <p  class="simpleH">Once you click on “Employees - Present” under “Attendance” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Shift </b><br/>
 
 <b>• Time In</b> <br/>
 <b>• Time In Image</b><br/>
 <b>• Time In Location</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Time Out Image</b> <br/>
 <b>• Time Out Location</b> <br/>
 <b>• Office Hours</b> <br/>
 <b>• Status</b> <br/> 
<p style="color:purple;"><b>To Delete the Attendance: </b></p>
<p class="simpleH"> > To delete Attendance, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete the Attendance.  </p> 
<p class="simpleH"> > When you click on "Delete" button, the Attendance will be deleted.</p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>
</div>
</div>
<?php
}elseif($page=='userInactive')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Inactive Employees</b></h3>
	<p class="simpleH">In this section, Inactive Employee Profiles can be viewed & managed using Add/Edit/Delete functionality.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Once you click on “Inactive Employees” under “Employees” from the left menu, a table will appear which contains fields like</p>
<p>
 <b>• Name </b> <br/>
 <b>• Username / Email Id </b><br/>
 <b>• Department</b><br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Phone</b> <br/>
 <b>• Status</b> <br/>
 
<p style="color:purple;"><b>To Edit Inactive Employee: </b></p>
<p class="simpleH"> > To Edit an Employee, click on "Edit" Icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Employee details.</p> 
<p class="simpleH"> > Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Employee details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete an Inactive Employee:</b></p>
<p class="simpleH"> > To Delete an Employee, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete an Employee.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Employee will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>
</div>
</div>
<?php
}elseif($page=='userH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Active Employees</b></h3>
	<p class="simpleH">In this section, Active Employee Profiles can be viewed & managed using Add/Edit/Delete functionality.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Once you click on “Active Employees” under “Employees” from the left menu, a table will appear which contains fields like</p>
<p>
 <b>• Name </b> <br/>
 <b>• Username / Email Id </b><br/>
 <b>• Department</b><br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Phone</b> <br/>
 <b>• Status</b> <br/>
 <p style="color:purple;"><b>To Add an Active Employee: </b></p>
<p class="simpleH"> > To add an Employee, click on "+Add" Button which is at the top-right.</p>
<p class="simpleH"> > A window will appear to fill the Employee details. </p> 
<p class="simpleH"> > Click on "Save" button to save the Employee details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b>To Edit Active Employee: </b></p>
<p class="simpleH"> > To Edit an Employee, click on "Edit" Icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Employee details.</p> 
<p class="simpleH"> > Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Employee details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete an Active Employee:</b></p>
<p class="simpleH"> > To Delete an Employee, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete an Employee.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Employee will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>

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
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Shifts</b></h3>
	<p class="simpleH">In this section, Shifts can be viewed & managed using Add/Edit/Delete functionality.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH">Once you click on “Shifts” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Time In</b><br/>
 <b>• Time Out</b> <br/>
 <b>• Break Time Start</b><br/>
 <b>• Break Time End</b><br/>
<b>• Shift Hours</b><br/>
<b>• Work Hours</b><br/>
 <b>• Status</b> <br/>
 <p style="color:purple;"><b>To Add a Shift:</b></p>
<p class="simpleH"> > To add Shift, click on "+Add" Button which is at the top-right.</p>
<p class="simpleH"> > A window will appear to fill the Shift details. </p> 
<p class="simpleH"> > Click on "Save" button to save the Shift details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b>To Edit a Shift: </b></p>
<p class="simpleH"> > To Edit a Shift, click on "Edit" Icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Shift details. </p> 
<p class="simpleH"> > Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Shift details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete a Shift:</b></p>
<p class="simpleH"> > To Delete a Shift,  click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete a  Shift.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Shift will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>

</div>
</div>

<?php
}elseif($page=='departH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Departments</b></h3>
	<p class="simpleH">In this section, Departments can be viewed & managed using Add/Edit/Delete functionality.</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH">Once you click on “Departments” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Status</b> <br/>
 <p style="color:purple;"><b>To Add a Department: </b></p>
<p class="simpleH"> > To add a Department, click on "+Add" Button which is at the top-right.</p>
<p class="simpleH"> > A window will appear to fill the Department details. </p> 
<p class="simpleH"> > Click on "Save" button to save the Department details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b>To Edit Department: </b></p>
<p class="simpleH"> > To Edit a Department, click on "Edit" Icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Department details.</p> 
<p class="simpleH"> > Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Department details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete a Department:</b></p>
<p class="simpleH"> > To Delete a Department, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete a Department.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Department will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>
</div>
</div>
<?php
}elseif($page=='desgH')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Designations</b></h3>
	<p class="simpleH">In this section, Designations can be viewed & managed using Add/Edit/Delete functionality.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Once you click on “Designations” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Description</b><br/>
 <b>• Status</b> <br/>
 <p style="color:purple;"><b>To Add a Designations: </b></p>
<p class="simpleH"> > To add a Designations, click on "+Add" Button which is at the top-right.</p>
<p class="simpleH"> > A window will appear to fill the Designations details. </p> 
<p class="simpleH"> > Click on "Save" button to save the Designations details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b>To Edit Designations: </b></p>
<p class="simpleH"> > To Edit a Designations, click on "Edit" Icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Designations details.</p> 
<p class="simpleH"> > Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Designations details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete a Designation:</b></p>
<p class="simpleH"> > To Delete a Designations, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete a Designations.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Designations will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>
</div>
</div>
<?php
}elseif($page=='absentH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Employees Absent</b></h3>
	<p class="simpleH">In this section, Attendance of Absent Employees can be viewed.</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH">Once you click “Employees - Absent” under “Attendance” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 
</div>
</div>
<?php
}elseif($page=='lateH')
{
 ?>
<div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Late Comers - Today</b></h3>
	<p class="simpleH">In this section, Employees who are Late Comers can be viewed.
</p>
 <h4 style="color:purple;"><b>How it Works? </b></h4>
 <p class="simpleH" >Once you click “Late Comers - Today” under “Attendance” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
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
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Early Leavers- Today</b></h3>
	<p class="simpleH">In this section, Employees who are Early Leavers can be viewed

</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH" >Once you click “Early Leavers - Today” under “Attendance” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Name </b> <br/>
 <b>• Department </b> <br/>
 <b>• Designation </b> <br/>
 <b>• Shift</b> <br/>
 <b>• Time Out</b> <br/>
 <b>• Early By </b> <br/>

</div>
</div>

 <?php
}elseif($page=='annualH')
{
 ?>
 <div class="card">
	<div class="card-header" data-background-color="green">
	    <h4 class="title">Help</h4>
			<p class="category">Guideline for user</p>
	</div>
	<div class="card-content">
 <h3 style="color:purple;"><b>Annual Holidays</b></h3>
	<p class="simpleH">In this section, Annual Holidays for an Organization can be viewed & managed using Add/Edit/Delete functionality.
</p>
 <h4 style="color:purple;"><b>How it Works ? </b></h4>
 <p class="simpleH" >Once you click on “Annual Holidays” under “Holidays” from the left menu, a table will appear which contains fields like:</p>
<p>
 <b>• Holiday Name</b> <br/>
 <b>• Description </b> <br/>
 <b>• From</b> <br/>
 <b>• To</b> <br/>
 
<p style="color:purple;"><b>To Add a Annual Holiday:</b></p>
<p class="simpleH"> >To add a Annual Holiday, click on "+Add" Button which is at the top-right.</p>
<p class="simpleH"> > A window will appear to fill the Annual Holiday details</p> 
<p class="simpleH"> > Click on "Save" button to save the Annual Holiday details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b>To edit Annual Holiday: </b></p>
<p class="simpleH"> >To edit Annual Holiday, click on “Edit” icon which is in the same row in the last column.</p>
<p class="simpleH"> > A window will appear - we can see the Annual Holiday details.</p> 
<p class="simpleH"> >Enter the details you want to edit or change.</p> 
<p class="simpleH"> > Click on "Update" button to update the Annual Holiday details.</p> 
<p class="simpleH"> > Click on "Close" button to cancel the process.</p> 

<p style="color:purple;"><b> To Delete Annual Holiday:</b></p>
<p class="simpleH"> > To Delete a Annual Holiday, click on "Delete" Icon which is in the same row in the last column.</p> 
<p class="simpleH"> > A window will appear asking you to delete a Annual Holiday.  </p> 
<p class="simpleH"> > When you click on "Delete" button, Annual Holiday will be deleted. </p> 
<p class="simpleH"> > When you click on "Close" button, the delete process will be cancelled.</p> <br/>

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
 

