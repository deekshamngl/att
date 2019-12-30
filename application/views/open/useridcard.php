<html>
<head>
	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!-----Generate QR code start--->

<div id="genQR"  role="dialog" style="margin-left:10px;" >
  <div class="modal-" style="width: 250px; align:center;">
    <!-- Modal content-->
    <div class="modal-content print" >
      <div class="modal-header" style="background-color:green" >
        <button type="button" class="close nonPrintable" data-dismiss="modal"><i class="material-icons">X</i></button>
       <center>
		<h4 class="modal-title" id="title" >Employee Identity Card</h4>
		</center>
      </div>
      <div class="modal-body" >	<center>
			<div>
				<h4>
					<?php echo $org;?>
				</h4> 
			</div>
			<div>
				<strong>
					<div style="color:grey"><b><span class="id" id="empName"><?php echo $emp; ?></span></b></div>
					<div>Designation: <span class="id" id="desgName" style="color:grey"><?php echo $desg; ?></span></div>
					<div>Department: <span class="id" id="deptName" style="color:grey"><?php echo $dept; ?></span></div>
					<div>Shift: <span class="id" id="deptName" style="color:grey"><?php echo $shift; ?></span></div>
				</strong>
				<center>
					<img width="150px" id="qrCode" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $una;?> &choe=UTF-8"/>
				</center>
				
			</div>
			</center>
      </div>
	  
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<div style="width: 250px; align:center;margin-left:10px;margin-top:15px">
<button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('genQR')" value="print a div!">Print</button>
</div>
</div>
<!-----Generate QR code close--->
</body>
<script>
	 function printDiv(genQR) {
		  
      
     var printContents = document.getElementById(genQR).innerHTML;
	  
      var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

    window.print();
	

      document.body.innerHTML = originalContents;
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}
</script>
</html>