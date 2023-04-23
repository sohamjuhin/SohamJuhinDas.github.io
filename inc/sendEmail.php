<?php

// Replace this with your own email address
$siteOwnersEmail = 'juhinsohamdas@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = filter_var(trim($_POST['contactName']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['contactEmail']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['contactSubject']), FILTER_SANITIZE_STRING);
    $contact_message = filter_var(trim($_POST['contactMessage']), FILTER_SANITIZE_STRING);

    $errors = [];

    // Validate Name
    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }

    // Validate Email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate Message
    if (empty($contact_message) || strlen($contact_message) < 15) {
        $errors[] = "Please enter your message. It should have at least 15 characters.";
    }

    // Set Default Subject
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    // Set Email Message
    $message = "Email from: $name<br/>";
    $message .= "Email address: $email<br/>";
    $message .= "Message:<br/> $contact_message <br/>";
    $message .= "<br/>-----<br/>This email was sent from your site's contact form.<br/>";

    // Set Email Headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (empty($errors)) {

        // Send Email
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }

    } else {
        // Validation Errors
        foreach ($errors as $error) {
            echo $error . "<br/>";
        }
    }
}
