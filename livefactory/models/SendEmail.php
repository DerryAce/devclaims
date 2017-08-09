<?php



namespace livefactory\models;



use Yii;

use yii\db\Query;

use livefactory\models\EmailTemplate;
use livefactory\models\PhpMailer;
class SendEmail extends \yii\db\ActiveRecord

{

	/**

     * @inheritdoc

     */

    public static function tableName()

    {

        return '';

    }

    public function emailSendMethod($uemail, $body, $cc = false, $subject) {

		// Always set content-type when sending HTML email

		$headers = "MIME-Version: 1.0" . "\r\n";

		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers

		$headers .= "From:".Yii::$app->params['SYSTEM_EMAIL']."\r\n";

		if ($cc)
			$headers .= "Cc:" . $cc . "\r\n";
			/*Yii::$app->mailer->compose()
		->setFrom('therockback@gmail.com')
		->setTo('kabir.mufiz49@gmail.com')
		->setSubject($subject)
		->send();*/
		$mail = new PhpMailer();
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//$mail->SMTPDebug  = 2;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		$mail->SMTPKeepAlive = true;
		//Set the hostname of the mail server
		$mail->Host       = 'smtp.yahoo.com';
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port       = 587;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth   = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username   = "username@yahoo.com";
		//Password to use for SMTP authentication
		$mail->Password   = "password";
		//Set who the message is to be sent from
		$mail->SetFrom(Yii::$app->params['SYSTEM_EMAIL']);
		//Set an alternative reply-to address
		//Set who the message is to be sent to
		$emails=explode(',',$uemail);
		if(count($emails)=='1'){
			$mail->AddAddress($uemail);
		}else if(count($emails) >1){
			foreach($emails as $email){
				$mail->AddAddress($email);
			}
		}
		if (!empty($cc)){
			$ccList=explode(',',$cc);
			if(count($ccList)=='1'){
				$mail->AddCC($ccList);
			}else if(count($ccList) >1){
				foreach($ccList as $cc){
					$mail->AddCC($cc);
				}
			}
		}
		
		//Set the subject line
		$mail->Subject = $subject;
		//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
		$mail->MsgHTML($body);
		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		//Attach an image file
		//$mail->AddAttachment('images/phpmailer_mini.gif');

	//	mail ($uemail, $subject, $body, $headers );

	}

	public function sendNoteEmailTemplate($email,$user_name,$user_by,$url){

		$tempalte = EmailTemplate::findOne(2);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK');

		$to   = array($user_name,$user_by,$url);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, $tempalte->template_subject);

	}

	public function sendNoteUpdateEmailTemplate($email,$user_name,$user_by,$url){

		$tempalte = EmailTemplate::findOne(3);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK');

		$to   = array($user_name,$user_by,$url);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, $tempalte->template_subject);

	}

	public function sendTaskEmailTemplate($email,$user_name,$url,$desc){

		$tempalte = EmailTemplate::findOne(9);

		$from = array('FIRST_NAME LAST_NAME', 'LINK','DISCRIPTION');

		$to   = array($user_name,$url,$desc);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, $tempalte->template_subject);

	}

	public function sendTaskChangedUserEmailTemplate($email,$user_name,$user_by,$url,$status){

		$tempalte = EmailTemplate::findOne(4);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','STATUS');

		$to   = array($user_name,$user_by,$url,$status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendTaskChangedPriorityEmailTemplate($email,$user_name,$user_by,$url,$from_label,$to_label){

		$tempalte = EmailTemplate::findOne(5);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_LABEL','TO_LABEL');

		$to   = array($user_name,$user_by,$url,$from_label,$to_label);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendTaskChangedStatusEmailTemplate($email,$user_name,$user_by,$url,$from_status,$to_status){

		$tempalte = EmailTemplate::findOne(6);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_STATUS','TO_STATUS');

		$to   = array($user_name,$user_by,$url,$from_status,$to_status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendAddAttachmentEmailTemplate($email,$user_name,$url,$entity_url){

		$tempalte = EmailTemplate::findOne(7);

		$from = array('FIRST_NAME LAST_NAME', 'LINK','ENTITY');

		$to   = array($user_name,$url,$entity_url);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendUpdateAttachmentEmailTemplate($email,$user_name,$url,$entity_url){

		$tempalte = EmailTemplate::findOne(8);

		$from = array('FIRST_NAME LAST_NAME', 'LINK','ENTITY');

		$to   = array($user_name,$url,$entity_url);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendResetPasswordEmailTemplate($email,$user_name,$password){

		$tempalte = EmailTemplate::findOne(1);

		$from = array('NAME', 'PASSWORD');

		$to   = array($user_name,$password);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendLeadChangedUserEmailTemplate($email,$user_name,$user_by,$url,$status){

		$tempalte = EmailTemplate::findOne(10);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','STATUS');

		$to   = array($user_name,$user_by,$url,$status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendLeadChangedPriorityEmailTemplate($email,$user_name,$user_by,$url,$from_label,$to_label){

		$tempalte = EmailTemplate::findOne(11);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_LABEL','TO_LABEL');

		$to   = array($user_name,$user_by,$url,$from_label,$to_label);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendLeadChangedStatusEmailTemplate($email,$user_name,$user_by,$url,$from_status,$to_status){

		$tempalte = EmailTemplate::findOne(12);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_STATUS','TO_STATUS');

		$to   = array($user_name,$user_by,$url,$from_status,$to_status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendLeadEmailTemplate($email,$user_name,$url,$desc){

		$tempalte = EmailTemplate::findOne(13);

		$from = array('FIRST_NAME LAST_NAME', 'LINK','DISCRIPTION');

		$to   = array($user_name,$url,$desc);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, $tempalte->template_subject);

	}
	public function sendDefectChangedUserEmailTemplate($email,$user_name,$user_by,$url,$status){

		$tempalte = EmailTemplate::findOne(14);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','STATUS');

		$to   = array($user_name,$user_by,$url,$status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendDefectChangedPriorityEmailTemplate($email,$user_name,$user_by,$url,$from_label,$to_label){

		$tempalte = EmailTemplate::findOne(15);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_LABEL','TO_LABEL');

		$to   = array($user_name,$user_by,$url,$from_label,$to_label);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendDefectChangedStatusEmailTemplate($email,$user_name,$user_by,$url,$from_status,$to_status){

		$tempalte = EmailTemplate::findOne(16);

		$from = array('FIRST_NAME LAST_NAME', 'USER_BY', 'LINK','FROM_STATUS','TO_STATUS');

		$to   = array($user_name,$user_by,$url,$from_status,$to_status);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false,$tempalte->template_subject);

	}

	public function sendDefectEmailTemplate($email,$user_name,$url,$desc){

		$tempalte = EmailTemplate::findOne(17);

		$from = array('FIRST_NAME LAST_NAME', 'LINK','DISCRIPTION');

		$to   = array($user_name,$url,$desc);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, $tempalte->template_subject);

	}
	public function sendNewUserEmailTemplate($email,$user_name,$username,$password){

		$tempalte = EmailTemplate::findOne(18);

		$from = array('EMAIL','FIRSTNAME LASTNAME', 'USERNAME','PASSWORD');

		$to   = array($email,$user_name,$username,$password);

		$body = str_replace($from, $to,$tempalte->template_body);

		$this->emailSendMethod($email, $body,false, str_replace('EMAIL',$email,$tempalte->template_subject));

	}

}

