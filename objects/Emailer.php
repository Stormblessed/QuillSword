<?php

	class Emailer
	{
		public static function SendEmail($to, $subject, $message, $headers)
		{
			mail($to, $subject, $message, $headers);
		}
		
		public static function SendAccountConfirmationEmail($to, $verity_hash)
		{
			$subject = 'Registration Verification - QuillSword';
			$message = '
			Thank you for signing up for QuillSword!
			Your account has been created, and can be activated by clicking the following link:
			
			------------------------------------------------------------------------
			http://www.quillsword.com/processes/activate.php?email='.$to.'&hash='.$verity_hash.'
			------------------------------------------------------------------------
			
			If you did not sign-up for an account at QuillSword, ignore this email.';
			
			$headers = 'From:noreply@quillsword.com' . "\r\n";
			mail($to, $subject, $message, $headers);
		}
	}

?>