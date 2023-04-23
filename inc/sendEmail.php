<?php

// Replace this with your own email address
$siteOwnersEmail = 'juhinsohamdas@gmail.com';

if ($_POST) {

    $name = trim($_POST['contactName']);
    $email = trim($_POST['contactEmail']);
    $subject = trim($_POST['contactSubject']);
    $message = trim($_POST['contactMessage']);

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Check Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Check Message
    if (strlen($message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Set Subject
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    if (empty($error)) {

        // Set From: header
        $from = $name . " <" . $email . ">";

        // Email Headers
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Set Message
        $body = "Email from: " . $name . "<br />";
        $body .= "Email address: " . $email . "<br />";
        $body .= "Message: <br />";
        $body .= $message;
        $body .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

        // Send Email
        if (mail($siteOwnersEmail, $subject, $body, $headers)) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }

    } else {
        // Validation Errors
        $response = "";
        $response .= isset($error['name']) ? $error['name'] . "<br />\n" : "";
        $response .= isset($error['email']) ? $error['email'] . "<br />\n" : "";
        $response .= isset($error['message']) ? $error['message'] . "<br />\n" : "";
        echo $response;
    }

}
