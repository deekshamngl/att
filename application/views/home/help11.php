<!doctype html>
<html lang="en">
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
	</style>
</head>
<body style="margin:20px;">

<div class="row">
<div class="col-md-12">
 <h3>Positions</h3>
	<p>In this section, Positions can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>
</div>
<?php
$pageid	= isset($_REQUEST['pageid']) ? ($_REQUEST['pageid']) : '';
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
if($pageid=='add')
{
 ?>
 <div class="col-md-12">
 <h3>Positions</h3>
	<p>In this section, Positions can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"All"</b> in the <b>"Positions"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Position-</b> where you can see all the Positions Name.</li>
	<li><b>Active-</b> where you can see and change the status of the position (Active or Inactive).</li>
	<li><b>Status-</b> where you can see and change the status of the position (Current or Past).</li>
	</ol>
	<blockquote>
			<p>Note 1: There are two basic Status for the visibility of Positions-<br/>
				<b>Active-</b> if you select active, the position will be displayed at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the position stops displaying on the website.
				</p>
	</blockquote>
	<blockquote>
			<p>Note 2: There are two basic Status for the requirement of Positions-<br/>
				<b>Current-</b> if you select Current status, the position will be displayed at the website for the current vacancy.<br/>
				<b>Past-</b> if you change the status from current to past, the position stops displaying on the website for the vacancy.
				</p>
	</blockquote>
<h4>To Add a Position</h4>

<p>To add a position, click on <b>"Add"<i class="fa fa-plus"></i></b> Button which is at the top-right.<br/>
> A window will display, here you can fill the Position Name and Select the Position Status. <br/>
	
> Click on <b>"Submit"</b> button to save the Position.<br/>
	
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a position</h4>
<p> 
> To Edit a position, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Position Name and the Position Status. <br/>
> Enter the position you want to edit and select status of position.<br/>
> And click on <b>"Submit"</b> button to save the Position.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>
<h4>To Delete the position</h4>
<p> 
> To Delete a position, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Position.<br/>
> When you click on <b>"Yes"</b> button, the position will be deleted.<br/>
> When you click on <b>"No"</b> button, the delete process will be canceled.</p>
</div>
 <?php
}
elseif($pageid=='add_position')
{
 ?>
 <div class="col-md-12">
 <h3>Add Position</h3>
 
	<p>In this section, a new Position can be added in the organization.</p>

<h4>How it works?</h4>

<p>
<li>In this window, you can add a position in your organization.</li>
<li>Enter the Position to be tested and select its duration.</li>
<!-- <blockquote>
			<p>Note 1: There are two basic Status for the requirement of Positions-<br/>
				<b>Current-</b> If position is in between start and end date than it is current position. <br/>
				
				<b>Past-</b> If position is not in between start and end date than it is past position. <br/>
				</p>
	</blockquote> -->
<li>Click on <b>"Submit"</b> button to save the Position.</li>
<li>Click on <b>"Cancel"</b> button to cancel the process.</li>
</p>

</div>
 <?php
}
elseif($pageid=='edit_position')
{
 ?>
 <div class="col-md-12">
 <h3>Edit Position</h3>
 
	<p>In this section, a Position can be edited in the organization.</p>

<h4>How it works?</h4>
<p>
<li>A window will display, here you can edit the position.</li>
<li>Enter the details that you want to change like Position Name and Position Status.</li>
<blockquote>
			<p>Note 1: There are two basic Status for the requirement of Positions-<br/>
				<b>Current-</b> If you select Current status, the position will be displayed at the website for the current vacancy.<br/>
				<b>Past-</b> If you change the status from current to past, the position will not be shown on the website for the vacancy.
				</p>
	</blockquote>
<li>Click on <b>"Submit"</b> button to save the Position</li>
<li>Click on <b>"Cancel"</b> button to cancel the process.</li>
</p>
</div>
 <?php
}
elseif($pageid=='current_position')
{
 ?>
 <div class="col-md-12">
 <h3>Current Positions</h3>
	<p>In this section, Open Positions can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"Open Positions"</b> in the <b>"Position"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Position-</b> where you can see all the Positions Name.</li>
	<li><b>Start Date-</b>Position opens at this date .</li>
	<li><b>End Date-</b>Position closed on this date.</li>
	</ol>
	<!-- <blockquote>
			<p>Note 1: There are two basic Status for the visibility of Positions-<br/>
				<b>Active-</b> if you select active, the position will be displayed at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the position stops displaying on the website.
				</p>
	</blockquote> --->
<h4>To Add a Position</h4>

<p>To add a position, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right<br/>
> A window will display, here you can fill the Position Name and its duration. <br/>
> Click on <b>"Submit"</b> button to save the Position<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a position</h4>
<p> 
> To Edit a position, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Position Name and Its duration. <br/>
> Enter the position you want to edit and select its duration.<br/>
> And click on <b>"Submit"</b> button to save the Position<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>
<h4>To Delete the position</h4>
<p> 
> To Delete a position, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Position <br/>
> When you click on <b>"Yes"</b> button, the position will be deleted <br/>
> When you click on <b>"No"</b> button, the delete process will be canceled</p>
</div>
 <?php
}
elseif($pageid=='past_position')
{
 ?>
 <div class="col-md-12">
 <h3>Closed Positions</h3>
	<p>In this section, Closed Positions can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"Closed Positions"</b> in the <b>"Past"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Position-</b> where you can see all the Positions Name.</li>
	<li><b>Start Date-</b>Position opens at this date .</li>
	<li><b>End Date-</b>Position closed on this date.</li>
	</ol>
	<!--- <blockquote>
			<p>Note 1: There are two basic Status for the visibility of Positions-<br/>
				<b>Active-</b> if you select active, the position will be displayed at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the position stops displaying on the website.
				</p>
	</blockquote> 
<h4>To Add a Position</h4>

<p>To add a position, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right<br/>
> A window will display, here you can fill the Position Name and Select the Position Status. <br/>
> Click on <b>"Submit"</b> button to save the Position<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a position</h4>
<p> 
> To Edit a position, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Position Name and the Position Status. <br/>
> Enter the position you want to edit and select status of position.<br/>
> And click on <b>"Submit"</b> button to save the Position<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>--->
<h4>To Delete the position</h4>
<p> 
> To Delete a position, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Position <br/>
> When you click on <b>"Yes"</b> button, the position will be deleted <br/>
> When you click on <b>"No"</b> button, the delete process will be canceled</p>
</div>
 <?php
}
elseif($pageid=='candidates')
{
 ?>
 <div class="col-md-12">
 <h3>Candidates</h3>
	<p>In this section, Candidates can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"All Candidates"</b> in the <b>"Candidates"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Name-</b> where you can see all the Candidates Name.</li>
	<li><b>Enroll No.-</b>It contains the Enroll No of the Candidates.</li>
	<li><b>Position-</b>Position of the candidate.</li>
	<li><b>Email-</b>Candidate's Email Id will be shown in this field.</li>
	<li><b>Contact No.-</b>It contains the Contact No of the Candidates.</li>
	<li><b>City-</b>City of the candidate where he/she lives.</li>
	
	</ol>
<!---	<blockquote>
			<p>Note 1: There are two basic Status for the visibility of Candidate-<br/>
				<b>Active-</b> if you select active, the candidate will be able to login at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the candidate will not be able to login to the website.
				</p>
	</blockquote>
---->
<h4>To Add a Candidate</h4>

<p>To add a candidate, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right.<br/>
> A window will display, here you can fill the Candidates details which are required.<br/>
> Click on <b>"Submit"</b> button to save the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a candidate</h4>
<p> 
> To Edit a candidate, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Candidate details. <br/>
> Enter the details you want to edit or change.<br/>
> And click on <b>"Submit"</b> button to update the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>
<h4>To Delete the Candidate</h4>
<p> 
> To Delete a candidate, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Candidate details. <br/>
> When you click on <b>"Delete"</b> button, the candidate will be deleted. <br/>
> When you click on <b>"Cancel"</b> button, the delete process will be canceled.</p>

<h4>To View the Candidate Details</h4>
<p> 
> To view a candidate detail, click on <b>"view"</b><i class="fa fa-eye"></i> Icon which is in the same row in the last column.<br/>
> A window will display, Here You can see all the candidate details. <br/>
> You can go back to the all candidate by clicking on "Back" Button.<br/>
</div>
 <?php
}
elseif($pageid=='candidatefeed')
{
 ?>
 <div class="col-md-12">
 <h3>Candidates Feedback</h3>
	<p>In this section, Candidates Feedback are shown.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"Candidates Feedback"</b> in the <b>"Candidates"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Candidate Name-</b> where you can see all the Candidates Name.</li>
	<li><b>Position-</b>Position of the candidate.</li>
	<li><b>Feedback-</b>Feedback given by the candidate after test.</li>
	</ol>
<!---	<blockquote>
			<p>Note 1: There are two basic Status for the visibility of Candidate-<br/>
				<b>Active-</b> if you select active, the candidate will be able to login at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the candidate will not be able to login to the website.
				</p>
	</blockquote>

<h4>To Add a Candidate</h4>

<p>To add a candidate, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right.<br/>
> A window will display, here you can fill the Candidates details which are required.<br/>
> Click on <b>"Submit"</b> button to save the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a candidate</h4>
<p> 
> To Edit a candidate, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Candidate details. <br/>
> Enter the details you want to edit or change.<br/>
> And click on <b>"Submit"</b> button to update the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>---->
<h4>To Delete the Candidate Feedback</h4>
<p> 
> To Delete a Candidate Feedback, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Candidate Feedback. <br/>
> When you click on <b>"Delete"</b> button, the Candidate Feedback will be deleted. <br/>
> When you click on <b>"Cancel"</b> button, the delete process will be canceled.</p>
</div>
 <?php
}
elseif($pageid=='takingtest')
{
 ?>
 <div class="col-md-12">
 <h3>Taking Test</h3>
	<p>In this section, Candidates giving test at present can be viewed and managed.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"Taking Test"</b> in the <b>"Candidates"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Name-</b> where you can see all the Candidates Name.</li>
	<li><b>Enroll No.-</b>It contains the enroll No of the Candidates.</li>
	<li><b>Position-</b>Position of the candidate.</li>
	<li><b>Email-</b>Candidate's Email Id will be shown in this field.</li>
	<li><b>Contact No.-</b>It contains the Contact No of the Candidates.</li>
	<li><b>City-</b>City of the candidate where he/she lives.</li>
	</ol>
	<!--<blockquote>
			<p>Note 1: There are two basic Status for the visibility of Candidate-<br/>
				<b>Active-</b> if you select active, the candidate will be able to login at the website.<br/>
				<b>Inactive-</b> if you change the status from active to inactive, the candidate will not be able to login to the website.
				</p>
	</blockquote> 
<h4>To Add a Candidate</h4>

<p>To add a candidate, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right.<br/>
> A window will display, here you can fill the Candidates details which are required and select positionaccording to "position status"(current or past).<br/>
> Enter Candidate Email Id and Password which will be used for Candidate Login.<br/>
> Click on <b>"Submit"</b> button to save the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a candidate</h4>
<p> 
> To Edit a candidate, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Candidate details. <br/>
> Enter the details you want to edit or change.<br/>
> And click on <b>"Submit"</b> button to update the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>
<h4>To Delete the Candidate</h4>
<p> 
> To Delete a candidate, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Candidate details. <br/>
> When you click on <b>"Delete"</b> button, the position will be deleted. <br/>
> When you click on <b>"Cancel"</b> button, the delete process will be canceled.</p>
--->
<h4>To View the Candidate Details</h4>
<p> 
> To view a candidate detail, click on <b>"view"</b><i class="fa fa-eye"></i> Icon which is in the same row in the last column.<br/>
> A window will display, Here You can see all the candidate details. <br/>
> You can go back to the all candidate by clicking on "Back" Button.<br/>
</div>
 <?php
}
elseif($pageid=='past_candidates')
{
 ?>
 <div class="col-md-12">
 <h3>Past Candidates</h3>
	<p>In this section, Past Candidates who have applied before for a position can be viewed and managed using Add/Edit/Delete functionality.</p>
 <h3>How it Works ? </h3>

<p>Once you click on <b>"Past Candidates"</b> in the <b>"Past"</b> from the left menu, a table will appear which contains fields like- </p>
	<ol>
	<li><b>Name-</b> where you can see all the Candidates Name.</li>
	<li><b>Enroll No.-</b>It contains the Enroll No of the Candidates.</li>
	<li><b>Position-</b>Position of the candidate.</li>
	<li><b>Email-</b>Candidate's Email Id will be shown in this field.</li>
	<li><b>Contact No.-</b>It contains the Contact No of the Candidates.</li>
	<li><b>City-</b>City of the candidate where he/she lives.</li>
	
	</ol>
	
<h4>To Add a Candidate</h4>

<p>To add a candidate, click on <b>"Add"</b><i class="fa fa-plus"></i> Button which is at the top-right.<br/>
> A window will display, here you can fill the Candidates details which are required.<br/>
> Enter Candidate Email Id and Password which will be used for Candidate Login.<br/>
> Click on <b>"Submit"</b> button to save the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>

<h4>To Edit a candidate</h4>
<p> 
> To Edit a candidate, click on <b>"Edit"</b><i class="fa fa-edit"></i> Icon which is in the same row in the last column.<br/>
> A window will display, here we can see the Candidate details. <br/>
> Enter the details you want to edit or change.<br/>
> And click on <b>"Submit"</b> button to update the Candidate details.<br/>
> Click on <b>"Cancel"</b> button to cancel the process.<br/>
</p>
<h4>To Delete the Candidate</h4>
<p> 
> To Delete a candidate, click on <b>"Delete"</b><i class="fa fa-trash-o"></i> Icon which is in the same row in the last column.<br/>
> A window will display, asking you to delete the Candidate details. <br/>
> When you click on <b>"Delete"</b> button, the position will be deleted. <br/>
> When you click on <b>"Cancel"</b> button, the delete process will be canceled.</p>

<h4>To View the Candidate Details</h4>
<p> 
> To view a candidate detail, click on <b>"view"</b><i class="fa fa-eye"></i> Icon which is in the same row in the last column.<br/>
> A window will display, Here You can see all the candidate details. <br/>
> You can go back to the all candidate by clicking on "Back" Button.<br/>
</div>
 <?php
}

 ?>

<div id="mySidenav" class="pull-right sidenav">
						<div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "400PX";
							$('#sidenavData').load('<?=URL?>help/helpNav');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

	<script type="text/javascript">
            $('.timepicker').timepicker();
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
			var table=$('#example').DataTable( {
				//"scrollX": true,
				   "searchable": false,
					"orderable": false,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllShift",
				"columns": [
					{ "data": "name" },
					{ "data": "timein" },
					{ "data": "timeout" },
					//{ "data": "timeingrace" },
					//{ "data": "timeoutgrace" },
					//{ "data": "timeinbreak" },
					//{ "data": "timeoutbreak" },
					{ "data": "status" },
					{ "data": "action" }
				]
			} );
			  $('input.timepicker').timepicker();
			  
			  $('#save').click(function(){
				  if($('#shiftName').val()==''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				   var sna=$('#shiftName').val();
				   var ti=$('#timeIn').val();
				   var to=$('#timeOut').val();
				   var tib=$('#timeInBreak').val();
				   var tob=$('#timeOutBreak').val();
				   var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts=$('#status').val();
				   $.ajax({url: "<?php echo URL;?>admin/registerShift",
						data: {"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Shift Added Successfully.');
								$('#addShift').modal('hide');
								 table.ajax.reload();
							}
							else
								doNotify('top','center',2,'There may error(s) in creating shift, try later.');
								document.getElementById('shifrFrom').reset();
								$('#addShift').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});  
			$('#saveE').click(function(){
				  if($('#shiftNameE').val()==''){
					  $('#shiftNameE').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				   var sid=$('#sid').val();
				   var sna=$('#shiftNameE').val();
				   var ti=$('#timeInE').val();
				   var to=$('#timeOutE').val();
				   var tib=$('#timeInBreakE').val();
				   var tob=$('#timeOutBreakE').val();
				   var tig=$('#timeInGraceE').val();
				   var tog=$('#timeOutGraceE').val();
				   var bog=$('#breakInGraceE').val();
				   var big=$('#breakOutGraceE').val();
				   var sts=$('#statusE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editShift",
						data: {"sid":sid,"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Shift Updated Successfully.');
								$('#addShiftE').modal('hide');
								 table.ajax.reload();
							}
							else
								doNotify('top','center',4,'There may error(s) in updating shift, try later.');
								document.getElementById('shifrFrom').reset();
								$('#addShiftE').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
			$(document).on("click", "#delete", function () {
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteShift",
						data: {"sid":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delShift').modal('hide');
								doNotify('top','center',2,'Shift deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delShift').modal('hide');
								doNotify('top','center',4,'This shift can not be delete, It is used in '+result.attn+' attendence(s) and currently assigned to '+result.emp+' employee(s).');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		});
			$(document).on("click", ".editShift", function () {
				$('#shiftNameLableE').text('');;
				$('#shiftNameE').attr('placeholder',"Shift Name");
				$('#sid').val($(this).data('sid'));
				$('#shiftNameE').val($(this).data('name'));
				$('#timeInE').val($(this).data('ti'));
				$('#timeOutE').val($(this).data('to'));
				$('#timeInBreakE').val($(this).data('tib'));
				$('#timeOutBreakE').val($(this).data('tob'));
				$('#timeInGraceE').val($(this).data('tig'));
				$('#timeOutGraceE').val($(this).data('tog'));
				$('#breakInGraceE').val($(this).data('big'));
				$('#breakOutGraceE').val($(this).data('bog'));
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".deleteShift", function () {
				$('#del_sid').val($(this).data('sid'));
				$('#sna').text($(this).data('sname'));
			});
			
		
	</script>

</html>
