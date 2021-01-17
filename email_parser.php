<?php
if( isset($_POST['email']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['house']) && isset($_POST['street']) && isset($_POST['city']) && isset($_POST['apt']) && isset($_POST['inter']) && isset($_POST['phone']) ){
	$email = $_POST['email']; 
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $house = $_POST['house'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $apt = $_POST['apt'];
    $inter = $_POST['inter'];
    $phone = $_POST['phone'];

    $to = "myemail@gmail.com";	
	$from = $email;
    $subject = 'Form Submission Message';
    $subject2 = "Welcome Form Submission";
    $message = '<b>Name:</b> '.$name.' <br><b>Last Name:</b> '.$lastname.'<br><b>Email:</b> '.$email.' <br><b>Address:</b> '.$house. ' <br><b>House Num:</b> '.$street. ' <br><b>City:</b> '.$city. ' <br><b>Apt Num:</b> '.$apt. ' <br><b>Intercom Code:</b> '.$inter. ' <br><b>Phone:</b> '.$phone.;
    $message2 = "Welcome " . $first_name . "\n\n" . $_POST['message'];

	$headers = "From: $from\n";
	$headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers2 = "From:" . $to;
    $headers2 .= "MIME-Version: 1.0\n";
    $headers2 .= "Content-type: text/html; charset=iso-8859-1\n";
	if( mail($to, $subject, $message, $headers) ){
        echo "success";
        mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
	} else {
		echo "The server failed to send the message. Please try again later.";
	}
}
?>