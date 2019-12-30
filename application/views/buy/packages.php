<!DOCTYPE html>
<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
<style>
form {
    border: 3px solid #f1f1f1;
}
@media only screen and (min-width: 501px) {
		form{
			margin-top:4%;
			width:400px!important;
		}
		.container{
			width:400px!important;
		}
		.alert{
	width:400px;
	}
}
.a-button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}


.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}


</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
$data=isset($data)?$data:'';
?>
<div class="imgcontainer">
	<img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="120px" width="200px"/>
</div>
<div class="row">
	<?php 
		if(isset($data))
		{	
			for($i=0;$i<count($data['data']);$i++)
			{
				//print_r( $data['data'][$i]['name']);
	?>
			<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
				
					<form>
						<center>
							<h3 style="color:green"><?php echo $data['data'][$i]['name']." Package"; ?></h3>
						</center>	
			<div class="container">
				<h4>Prices</h4>
				<table width="100%">
					<tr>
						<td>
							<label>Base Price </label>
						</td>
						<td>
							<label>$ <b><?php $pm=$data['data'][$i]['usd']/12;
							echo round($pm,2)." /Month"; ?></b></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Per User Subscription</label>
						</td>
						<td>
							<label>$ <b><?php $pm=$data['data'][$i]['usdperuser']/12;
							echo round($pm,2)." /Month"; ?></b></label>
						</td>
					</tr>
					<tr>
						<td>
							<label><b>Free Users</label>
						</td>
						<td>
							<label><b> <?php echo $data['data'][$i]['user'].""; ?></b></label>
						</td>
					</tr>		
				</table>
				<a href="<?=URL.'Buypackage/vieworg/'.$data['data'][$i]['id'].""?>" class="btn <?php if($i==0) echo 'btn-success';else if($i==1) echo 'btn-success';else echo 'btn-warning'; ?> btn-block btn-lg" >Buy now</a>
				<br/>
			</div>
					 
					</form>
				
			</div>
	<?php  
			}// for close
		}
	// if close
	?>

</div>

</body>
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script>/*
	$(function(){
		$('#login').click(function(){
			var username=$('#uname').val();
			var password=$('#psw').val();
				var data = {username: username,password:password};
				$.ajax({
					url: '<?=URL?>ubitech/login',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function (data) {
						if(!data){
							$('.alert').fadeIn(2000);
						}else
							location.replace("<?=URL?>ubitech/dashboard");
					},
					error: function(data){
					}
					
				});
			
			return false;
		});
		$('.close').click(function(){
			$('.alert').fadeOut(1000);
		});
	});*/
	</script>
</html>