<?php
namespace PortoContactForm;

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php-mailer/src/PHPMailer.php';
require 'php-mailer/src/SMTP.php';
require 'php-mailer/src/Exception.php';

// Step 1 - Enter your email address below.
$email = 'petr.machulskiy@gmail.com';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

// If contact form don't has the subject input change the value of subject here
$subject = ( isset($_POST['subject']) ) ? $_POST['subject'] : 'Заказ обратного звонка с сайта tent93.ru';

$mail = new PHPMailer(true);

if(isset($_POST['answers']) && isset($_POST['questions'])){
	$answers = explode('&', $_POST['answers']);
	$questions = $_POST['questions'];
	$result_string = '';

	foreach ($answers as $key => $value) {
		if(!stristr($value, 'quiz-val-') == FALSE) $value = str_replace(' ', '', str_replace('quiz-val-', '', $value));

		$answers[$key] = str_replace('=', '', stristr($value, '='));
		$result_string .= $questions[$key]['question'] .'<br>';

		if(is_array($questions[$key]['answer']['vars'])){
			$result_string .= urldecode(htmlspecialchars($questions[$key]['answer']['vars'][$answers[$key]], ENT_QUOTES));
		}else{
			$result_string .= urldecode(htmlspecialchars($answers[$key], ENT_QUOTES));
		}

		$result_string.='<br><hr>';
		
	}

	//echo $result_string;
$message = $result_string;

}else{
foreach($_POST as $label => $value) {
	$label = ucwords($label);

	// Use the commented code below to change label texts. On this example will change "Email" to "Email Address"

	// if( $label == 'Email' ) {
	// 	$label = 'Email Address';
	// }

	// Checkboxes
	if( is_array($value) ) {
		// Store new value
		$value = implode(', ', $value);
	}

	$message .= $label.": " . htmlspecialchars($value, ENT_QUOTES) . "<br>\n";
}
}





try {

	$mail->SMTPDebug = $debug;                                 // Debug Mode
	 $mail->IsMail();
    $mail->Mailer = "mail";

	// Step 2 (Optional) - If you don't receive the email, try to configure the parameters below:

	//$mail->IsSMTP();                                         // Set mailer to use SMTP
	//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
	//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
	//$mail->Username = 'user@example.com';                    // SMTP username
	//$mail->Password = 'secret';                              // SMTP password
	//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
	//$mail->Port = 587;   								       // TCP port to connect to

	$mail->AddAddress($email);	 						      
	$mail->AddAddress('torba.viktor2018@yandex.ru');
	$mail->AddAddress('tent.stail@mail.ru');     // Add a secondary recipient
	//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address.
	//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address.

	// From - Name
	$fromName = ( isset($_POST['name']) ) ? $_POST['name'] : 'Позвоните мне';
	$mail->SetFrom('noreply@'.$_SERVER['HTTP_HOST'], $fromName);

	// Repply To
	if( isset($_POST['email']) ) {
		$mail->AddReplyTo($_POST['email'], $fromName);
	}

	$mail->IsHTML(true);                                       // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	$mail->Send();
	$arrResult = array ('response'=>'success');

} catch (Exception $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
} catch (\Exception $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
}

echo "success";

exit();
die();