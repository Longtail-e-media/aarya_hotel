<?php
require_once("includes/initialize.php");
$usermail = User::get_UseremailAddress_byId(1);
$ccusermail = User::field_by_id(1, 'optional_email');
$sitename = Config::getField('sitename', true);
	
	foreach($_POST as $key=>$val){$$key=$val;}
	
if($_POST['action']=="forcoment"):
	$body = '
	<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
	  <tr>
		<td><p>Dear Sir/Mam,</p>
		</td>
	  </tr>
	  <tr>
		<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Comment message</span><br />
		  The details provided are:</p>
		  <p><strong>Fullname</strong> : '.$name.'<br />		
		  <strong>E-mail Address</strong>: '.$email.'<br />
		  <strong>Address</strong>: '.$address.'<br />
		  <strong>Phone</strong>: '.$phone.'<br />
		  <strong>Message</strong>: '.$message.'<br />
		  </p>
		</td>
	  </tr>
	  <tr>
		<td><p>&nbsp;</p>
		<p>Thank you,<br />
		'.$name.'
		</p></td>
	  </tr>
	</table>
	';
	
	/*
	* mail info
	*/

	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->SetFrom($email, $name);
	$mail->AddReplyTo($email,$name);
	
	$mail->AddAddress($usermail, $sitename);
	// if add extra email address on back end
	if(!empty($ccusermail)){
		$rec = explode(';', $ccusermail);
		if($rec){
			foreach($rec as $row){
				$mail->AddCC($row,$sitename);
			}		
		}
	}
	
	$mail->Subject    = 'Enquiry mail from '.$name;
	
	$mail->MsgHTML($body);
	
	if(!$mail->Send()) {
		echo json_encode(array("action"=>"unsuccess","message"=>"We could not sent your message at the time. Please try again later."));
	}else{
		echo json_encode(array("action"=>"success","message"=>"Your message has been successfully sent."));
	}
endif;

if($_POST['action']=="forBooking"):
	$body = '
	<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
	  <tr>
		<td><p>Dear Sir,</p>
		</td>
	  </tr>
	  <tr>
		<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Book message</span><br />
		  The details provided are:</p>
		  <p><strong>Fullname</strong> : '.$name.'<br />		
		  <strong>E-mail Address</strong>: '.$email.'<br />
		  <strong>Class</strong>: '.$class_select.'<br />
		  <strong>Course</strong>: '.$course.'<br />
		  <strong>Date</strong>: '.$date.'<br />
		  <strong>Time</strong>: '.$time.'<br />
		  <strong>Address</strong>: '.$address.'<br />
		  <strong>Phone</strong>: '.$phone.'<br />
		  <strong>Message</strong>: '.$message.'<br />
		  </p>
		</td>
	  </tr>
	  <tr>
		<td><p>&nbsp;</p>
		<p>Thank you,<br />
		'.$name.'
		</p></td>
	  </tr>
	</table>
	';
	
	/*
	* mail info
	*/

	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->SetFrom($email, $name);
	$mail->AddReplyTo($email,$name);
	
	$mail->AddAddress($usermail, $sitename);
	// if add extra email address on back end
	if(!empty($ccusermail)){
		$rec = explode(';', $ccusermail);
		if($rec){
			foreach($rec as $row){
				$mail->AddCC($row,$sitename);
			}		
		}
	}
	
	$mail->Subject    = 'Booking mail from '.$name;
	
	$mail->MsgHTML($body);
	
	if(!$mail->Send()) {
		echo json_encode(array("action"=>"unsuccess","message"=>"We could not sent your message at the time. Please try again later."));
	}else{
		echo json_encode(array("action"=>"success","message"=>"Your booking has been successfully sent."));
	}
endif;
?>