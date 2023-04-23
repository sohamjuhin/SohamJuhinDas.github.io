<?php

require 'vendor/autoload.php'; // Make sure to update the path to the PHPMailer library

// Replace this with your own email address
$siteOwnersEmail = 'juhinsohamdas@ieee.org';

if($_POST) {
   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
   if (strlen($name) < 2) {
      $error['name'] = "Please enter your name.";
   }
   // Check Email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Please enter a valid email address.";
   }
   // Check Message
   if (strlen($contact_message) < 15) {
      $error['message'] = "Please enter your message. It should have at least 15 characters.";
   }
   // Subject
   if ($subject == '') { $subject = "Contact Form Submission"; }

   // Set Message
   $message = "";
   $message .= "Email from: " . $name . "<br />";
   $message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Create a new PHPMailer instance
   $mail = new PHPMailer\PHPMailer\PHPMailer();

   // SMTP settings (replace with your own)
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->Port = 587;
   $mail->SMTPSecure = 'tls';
   $mail->SMTPAuth = true;
   $mail->Username = 'your_email_address';
   $mail->Password = 'your_email_password';

   // Email Headers
   $mail->setFrom($email, $name);
   $mail->addAddress($siteOwnersEmail, 'Site Owner');
   $mail->isHTML(true);
   $mail->Subject = $subject;
   $mail->Body = $message;

   if (!$error) {
      if($mail->send()) {
         echo "OK";
      }
      else {
         echo "Something went wrong. Please try again.";
      }
   }
   else {
      $response = (isset($error['name'])) ? $error['name'] . "<br />"
