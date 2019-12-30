<?php
require('fpdf.php');
$state = $data['state'];
$data1=array();
$plan_amt=$data['amount']-$_SESSION['tax']+$_SESSION['discount_amt']-$_SESSION['addon_amt'];
$planusers	= 	$_SESSION['plan_users'];
$addonamt	=	$_SESSION['addon_amt'];
$plan	=	$_SESSION['plan'];
$dis	=	$_SESSION['discount_amt'];
$tax	=	$_SESSION['tax'];
$email=getAdminEmail($_SESSION['orgid']);
 /*
Array ( [data] => Array ( [firstname] => Namrata Bhansali [amount] => 2655.0 [txnid] => abff505f65e9f943aa25 [country] => india [state] => Madhya Pradesh [city] => GWALIOR [zip] => 474001 [street] => gwalior [contact] => 9993414142 [cur] => INR [plan_users] => 5 [gstin] => 1254 [addon_amt] => 0 [addon_users] => [plan] => 12 [package] => STARTUP ) )

*/
if($state != 23 )
{
	
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
	// HTML parser
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extract attributes
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	// Opening tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF = $attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	// Closing tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF = '';
}

function SetStyle($tag, $enable)
{
	// Modify style and select corresponding font
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
	
}
$html = '
	<br/><br/>
	<br/><br/>
';

$pdf = new PDF();
// First page
$pdf->AddPage();
$number=3832;

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
//$pdf->WriteHTML($html);
$pdf->Cell(40,10,'Ubitech Solutions Pvt. Ltd');
$pdf->SetFont('Arial','',10);
$pdf->Ln();$pdf->Cell(40,0,'D-15, Kailash Nagar, Near Prime Hospital, ');
$pdf->Ln();$pdf->Cell(40,10,'City Centre, Gwalior- 474011');
$pdf->Ln();$pdf->Cell(40,0,'Madhya Pradesh, India ');
$pdf->Ln();$pdf->Cell(40,10,'Mob: + 91 9826274403 ');
$pdf->Ln();$pdf->Cell(40,0,'Email: accounts@ubitechsolutions.com');
$pdf->Ln();$pdf->Cell(40,10,'GSTIN:  23AAACU9333R1ZT');
$pdf->Ln();$pdf->Cell(40,0,'CIN: U72900MP2006PTC018872');
$pdf->Image(URL.'../assets/img/logo.png',150,40,40);

$pdf->SetFont('Arial','B',18);
$pdf->SetXY(80,65);
$pdf->Write(20,'Tax Invoice','');
/////////////check currency////////
$currency = $data['cur'];
if($currency == "USD")
{
		$curr  = "$" ;
}
else{
	$curr = "Rs.";
}

//////currency/////////
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(40,75);
$pdf->Write(20,'Invoice To','');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,85);
$pdf->Write(20,$_SESSION['orgName'],'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(15);
$pdf->Write(0,'Name:','');
$pdf->SetFont('Times','',12);
 $sname = $data['firstname'];
$pdf->Write(0,$sname,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'Address:','');
$pdf->SetFont('Times','',12);
$add = $data['street'];
$pdf->Write(0,$add,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
//$pdf->Write(0,'Email Id:','');
$pdf->SetFont('Times','',12);
$add = $data['street'];
//$pdf->Write(0,$data1['tax'],'');

$pdf->Ln(3);
$pdf->Write(0,'Place Of Supply:','');
$pdf->SetFont('Times','',12);
$city = $data['city'];
$state = getStateName($data['state']);
$pdf->Write(0,$city,'');
$pdf->Write(1,' ,'.$state,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'Pin Code:','');
$pdf->SetFont('Times','',12);
$code = $data['zip'];
$pdf->Write(0,$code,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'GSTIN:','');
$pdf->SetFont('Times','',12);
$gst = $data['gstin'];
$pdf->Write(0,$gst,'');
$pdf->rect(10,80, 190, 120);
$pdf->Line(10,88, 150, 88);
$pdf->Line(150,80, 150, 200);
$pdf->Line(10,130, 200, 130);
$pdf->Line(170,130, 170, 200);
$pdf->Line(10,138, 200, 138);
$pdf->Line(10,176, 200, 176);
$pdf->Line(10,182, 200, 182);
$pdf->Line(10,189, 200, 189);
///////start text edite//////

$pdf->SetFont('Arial','B','12');
$pdf->SetXY(40,120);
$pdf->Write(30,'Particulars');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(150,130);
$pdf->Write(10,'HSN NO.');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(170,130);
$pdf->Write(10,'Amount(       )','');
$pdf->Text(190,137,$curr);
$pdf->SetFont('Arial','B','10');
$pdf->SetXY(10,138);
$pdf->Write(10,'Annualsubscription of ubiAttendance App');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,142);
$pdf->Write(10,'Subscription Period: '.$plan.' months' );
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,146);
$pdf->Write(10,'Administrator Login: 1');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,150);
$pdf->Write(10,'User Logins: '.$data['plan_users']);
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,154);
$pdf->Write(10,'Additional users: '.$data['addon_users']);
$pdf->SetFont('Arial','B','13');
$pdf->SetXY(10,165);
$pdf->Write(10,'Less Discount');
$pdf->SetFont('Times','','14');
$pdf->SetXY(131,174);
$pdf->Write(10,'Amount');
$pdf->SetFont('Times','','13');
$pdf->SetXY(123,180);
$pdf->Write(10,'IGST @18%');
$pdf->SetFont('Arial','','13');
$pdf->SetXY(10,187);
$pdf->Write(10,'Grand Total');
//$name = convert_number($number);  Convert Number to words
//$pdf->Text(60,194,$name);
////HSN NO.
$pdf->SetFont('Arial','','13');
$pdf->SetXY(151,138);
$pdf->Write(10,'998314');

///Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,138);
$payamt = $data['amount'];
$pdf->Write(10,$plan_amt);//
///additional users
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,157);
$plan = $data['plan'];
$users = $data['addon_users'];
$pdf->Text(176,163,$addonamt);
///Less discount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,166);
$pdf->Write(10,$dis);
////Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(176,174);
$amt = $plan_amt; // amount
$pdf->Write(10,$amt+$addonamt-$dis);
$pdf->Text(171,180,$curr);
///IGST
$gst=0;
if($currency == 'INR')
{
$pdf->SetFont('Times','B','12');
$pdf->SetXY(176,181);
//$gst = $tax;
$pdf->Write(10,$tax);
$pdf->Text(171,187,$curr);
}
////Total Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(176,188);
$total = $data['amount'];
$pdf->Write(10,$total);
$pdf->Text(171,194,$curr);
////Date
$pdf->SetFont('Times','','12');
$pdf->SetXY(160,90);
$date = date("jS \ F Y"); 
$pdf->Text(160,90,$date);
/////////end////

$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);
}

/////////////////////////////////////start intra invoice///////////////////////

else
{
	
	
	
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
	// HTML parser
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extract attributes
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	// Opening tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF = $attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	// Closing tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF = '';
}

function SetStyle($tag, $enable)
{
	// Modify style and select corresponding font
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
	
}
$html = '
	<br/><br/>
	<br/><br/>
';

$pdf = new PDF();
// First page
$pdf->AddPage();
$number=3832;

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
//$pdf->WriteHTML($html);
$pdf->Cell(40,10,'Ubitech Solutions Pvt. Ltd');
$pdf->SetFont('Arial','',10);
$pdf->Ln();$pdf->Cell(40,0,'D-15, Kailash Nagar, Near Prime Hospital, ');
$pdf->Ln();$pdf->Cell(40,10,'City Centre, Gwalior- 474011');
$pdf->Ln();$pdf->Cell(40,0,'Madhya Pradesh, India ');
$pdf->Ln();$pdf->Cell(40,10,'Mob: + 91 9826274403 ');
$pdf->Ln();$pdf->Cell(40,0,'Email: accounts@ubitechsolutions.com');
$pdf->Ln();$pdf->Cell(40,10,'GSTIN:  23AAACU9333R1ZT');
$pdf->Ln();$pdf->Cell(40,0,'CIN: U72900MP2006PTC018872');
$pdf->Image(URL.'../assets/img/logo.png',150,40,40);

$pdf->SetFont('Arial','B',18);
$pdf->SetXY(80,65);
$pdf->Write(20,'Tax Invoice','');
/////////////check currency////////
$currency = $data['cur'];
if($currency == "USD")
{
		$curr  = "$" ;
}
else{
	$curr = "Rs.";
}

//////currency/////////
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(40,75);
$pdf->Write(20,'Invoice To','');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,85);
$pdf->Write(20,$_SESSION['orgName'],'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(15);
$pdf->Write(0,'Name:','');
$pdf->SetFont('Times','',12);
 $sname = $data['firstname'];
$pdf->Write(0,$sname,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'Address:','');
$pdf->SetFont('Times','',12);
$add = $data['street'];
$pdf->Write(0,$add,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
//$pdf->Write(0,'Email Id:','');
$pdf->SetFont('Times','',12);
$add = $data['street'];
//$pdf->Write(0,$data1['tax'],'');

$pdf->Ln(3);
$pdf->Write(0,'Place Of Supply:','');
$pdf->SetFont('Times','',12);
$city = $data['city'];
$state = getStateName($data['state']);
$pdf->Write(0,$city,'');
$pdf->Write(1,' ,'.$state,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'Pin Code:','');
$pdf->SetFont('Times','',12);
$code = $data['zip'];
$pdf->Write(0,$code,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'GSTIN:','');
$pdf->SetFont('Times','',12);
$gst = $data['gstin'];
$pdf->Write(0,$gst,'');
$pdf->rect(10,80, 190, 140);
$pdf->Line(10,88, 150, 88);
$pdf->Line(150,80, 150, 220);
$pdf->Line(10,130, 200, 130);
$pdf->Line(170,130, 170, 220);
$pdf->Line(10,138, 200, 138);
$pdf->Line(10,176, 200, 176);
$pdf->Line(10,182, 200, 182);
$pdf->Line(10,189, 200, 189);
$pdf->Line(10,200, 200, 200);
///////start text edite//////

$pdf->SetFont('Arial','B','12');
$pdf->SetXY(40,120);
$pdf->Write(30,'Particulars');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(150,130);
$pdf->Write(10,'HSN NO.');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(170,130);
$pdf->Write(10,'Amount(       )','');
$pdf->Text(190,137,$curr);
$pdf->SetFont('Arial','B','10');
$pdf->SetXY(10,138);
$pdf->Write(10,'Annualsubscription of ubiAttendance App');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,142);
$pdf->Write(10,'Subscription Period: '.$plan.' months' );
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,146);
$pdf->Write(10,'Administrator Login: 1');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,150);
$pdf->Write(10,'User Logins: '.$data['plan_users']);
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,154);
$pdf->Write(10,'Additional users: '.$data['addon_users']);
$pdf->SetFont('Arial','B','13');
$pdf->SetXY(10,165);
$pdf->Write(10,'Less Discount');
$pdf->SetFont('Times','','14');
$pdf->SetXY(131,174);
$pdf->Write(10,'Amount');
$pdf->SetFont('Times','','13');
$pdf->SetXY(123,180);
$pdf->Write(10,'SGST @9%');
$pdf->SetFont('Times','','13');
$pdf->SetXY(123,188);
$pdf->Write(10,'CGST @9%');
$pdf->SetFont('Arial','','13');
$pdf->SetXY(10,203);
$pdf->Write(10,'Grand Total');
//$name = convert_number($number);  Convert Number to words
//$pdf->Text(60,194,$name);
////HSN NO.
$pdf->SetFont('Arial','','13');
$pdf->SetXY(151,138);
$pdf->Write(10,'998314');

///Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,138);
$payamt = $data['amount'];
$pdf->Write(10,$plan_amt);//
///additional users
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,157);
$plan = $data['plan'];
$users = $data['addon_users'];
$pdf->Text(176,163,$addonamt);
///Less discount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(175,166);
$pdf->Write(10,$dis);
////Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(176,174);
$amt = $plan_amt; // amount
$pdf->Write(10,$amt+$addonamt-$dis);
$pdf->Text(171,180,$curr);
///IGST
$gst=0;
if($currency == 'INR')
{
$pdf->SetFont('Times','B','12');
$pdf->SetXY(176,181);
$pdf->Write(10,$tax/2);
$pdf->SetXY(176,188);
$pdf->Write(10,$tax/2);
$pdf->Text(171,187,$curr);
}
////Total Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(170,203);
$total = $data['amount'];
$pdf->Write(10,$curr.$total);
$pdf->Text(171,194,$curr);
////Date
$pdf->SetFont('Times','','12');
$pdf->SetXY(160,90);
$date = date("jS \ F Y"); 
$pdf->Text(160,90,$date);
/////////end////

$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);

	/* 
		
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
	// HTML parser
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extract attributes
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	// Opening tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF = $attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	// Closing tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF = '';
}

function SetStyle($tag, $enable)
{
	// Modify style and select corresponding font
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
	
}
$html = '
	<br/><br/>
	<br/><br/>
';

$pdf = new PDF();
// First page
$pdf->AddPage();
$number=3832;

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
//$pdf->WriteHTML($html);
$pdf->Cell(40,10,'Ubitech Solutions Pvt. Ltd');
$pdf->SetFont('Arial','',10);
$pdf->Ln();$pdf->Cell(40,0,'D-15, Kailash Nagar, Near Prime Hospital, ');
$pdf->Ln();$pdf->Cell(40,10,'City Centre, Gwalior- 474011');
$pdf->Ln();$pdf->Cell(40,0,'Madhya Pradesh, India ');
$pdf->Ln();$pdf->Cell(40,10,'Mob: + 91 9826274403 ');
$pdf->Ln();$pdf->Cell(40,0,'Email: accounts@ubitechsolutions.com');
$pdf->Ln();$pdf->Cell(40,10,'GSTIN:  23AAACU9333R1ZT');
$pdf->Ln();$pdf->Cell(40,0,'CIN: U72900MP2006PTC018872');
$pdf->Image(URL.'../assets/img/logo.png',150,40,40);

$pdf->SetFont('Arial','B',18);
$pdf->SetXY(80,65);
$pdf->Write(20,'Tax Invoice','');
/////////////check currency////////
$currency = $data['cur'];
if($currency == "USD")
{
		$curr  = "$" ;
}
else{
	$curr = "Rs.";
}

//////currency/////////
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(40,75);
$pdf->Write(20,'Invoice To','');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,85);
$pdf->Write(20,$_SESSION['orgName'],'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(15);
$pdf->Write(0,'Name:','');
$pdf->SetFont('Times','',12);
 $sname = $data['firstname'];
$pdf->Write(0,$sname,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'Address:','');
$pdf->SetFont('Times','',12);
$add = $data['street'];
$pdf->Write(0,$add,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$pdf->Write(0,'Email Id:','');

$pdf->Ln(5);
$pdf->Write(0,'Place Of Supply:','');
$pdf->SetFont('Times','',12);
$city = $data['city'];
$state = $data['state'];
$pdf->Write(0,$city,'');
$pdf->Write(1,' ,'.$state,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'State Code:','');
$pdf->SetFont('Times','',12);
$code = $data['zip'];
$pdf->Write(0,$code,'');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(5);
$pdf->Write(0,'GSTIN:','');
$pdf->SetFont('Times','',12);
$gst = $data['gstin'];
$pdf->Write(0,$gst,'');
$pdf->rect(10,80, 190, 140);
$pdf->Line(10,88, 150, 88);
$pdf->Line(150,80, 150, 220);
$pdf->Line(10,130, 200, 130);
$pdf->Line(170,130, 170, 220);
$pdf->Line(10,138, 200, 138);
$pdf->Line(10,176, 200, 176);
$pdf->Line(10,182, 200, 182);
$pdf->Line(10,189, 200, 189);
$pdf->Line(10,200, 200, 200);
///////start text edite//////

$pdf->SetFont('Arial','B','12');
$pdf->SetXY(40,120);
$pdf->Write(30,'Particulars');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(150,130);
$pdf->Write(10,'HSN NO.');
$pdf->SetFont('Arial','B','12');
$pdf->SetXY(170,130);
$pdf->Write(10,'Amount(       )','');
$pdf->Text(190,137,$curr);
$pdf->SetFont('Arial','B','10');
$pdf->SetXY(10,138);
$pdf->Write(10,'Annualsubscription of ubiAttendance App');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,142);
$pdf->Write(10,'Subscription Period:');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,146);
$pdf->Write(10,'Administrator Login ');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,150);
$pdf->Write(10,'User Logins');
$pdf->SetFont('Times','','10');
$pdf->SetXY(10,157);
$pdf->Write(10,'Additional 1 users');
$pdf->SetFont('Arial','B','13');
$pdf->SetXY(10,165);
$pdf->Write(10,'Less Discount');
$pdf->SetFont('Times','','14');
$pdf->SetXY(131,174);
$pdf->Write(10,'Amount');
$pdf->SetFont('Times','','13');
$pdf->SetXY(123,180);
$pdf->Write(10,'SGST @9%');
$pdf->SetFont('Times','','13');
$pdf->SetXY(123,188);
$pdf->Write(10,'CGST @9%');
$pdf->SetFont('Arial','','13');
$pdf->SetXY(10,199);
$pdf->Write(10,'Grand Total');
//$name = convert_number($number);  Convert Number to words
//$pdf->Text(60,194,$name);
////HSN NO.
$pdf->SetFont('Arial','','13');
$pdf->SetXY(151,138);
$pdf->Write(10,'998314');

///Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(182,138);
$payamt = $data['amount'];
$pdf->Write(10,$payamt);
///additional users
$pdf->SetFont('Times','B','12');
$pdf->SetXY(187,152);
$plan_amt = $data['addon_users'];
$pdf->Write(10,$plan_amt);
$plan = $data['plan'];
$pdf->Text(178,165,$plan);
///Less discount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(187,166);
$pdf->Write(10,'1080');
////Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(184,174);
$amt = $data['amount'];
$pdf->Write(10,$amt);
$pdf->Text(172,180,$curr);
///IGST
$gst=0;
$cgst=0;
if($currency == 'INR')
{
$pdf->SetFont('Times','B','12');
$pdf->SetXY(184,181);
$gst = $amt*9/100;
$pdf->Write(10,$gst);
$pdf->Text(178,187,$curr);
////////CGST
$pdf->SetXY(184,188);
$cgst = $amt*9/100;
$pdf->Write(10,$cgst);
$pdf->Text(178,194,$curr);
}
////Total Amount
$pdf->SetFont('Times','B','12');
$pdf->SetXY(178,200);
$total = $gst+$cgst+$amt;
$pdf->Write(10,$total);
$pdf->Text(172,206,$curr);
////Date
$pdf->SetFont('Times','','12');
$pdf->SetXY(160,90);
$date = date("jS \ F Y"); 
$pdf->Text(160,90,$date);
/////////end////

$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);
 */	
}
$pdf->Output();
?>
