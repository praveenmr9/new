
<?php
//define variables and set to empty values....
$error_message = "";
$name = $email = $message = "";

//EDIT THE 2 LINES BELOW AS REQUIRED
$email_to = "praveenpds143@gmail.com";
$email_subject = "message from www.boomerdesigner.com";

function died($error)
{
  // This function trigger only when the valication fails....
  echo "We are very sorry,but there were error(s)found with the from you submitted.";
  echo "These error appear below.<br/><br/>";
  echo $error . "<br/><br/>";
  echo "Please go the back fix these errors.<br/><br/>";
  die();
}

function clean_string($data)
{
  // This function help to clean the string data by removing specialchars, / and spaces....
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // get front end data to php....
  $name = clean_string($_POST["name"]);
  $email = clean_string($_POST["email"]);
  $message = clean_string($_POST["message"]);

  // print the values....
  $mail_message = "Name : " . $name . "<br />" . "Email : " . $email . "<br />" . "Message : " . $message . "<br />";
  echo $mail_message;


  if (empty($name) || empty($email) || empty($message)) {
    $error_message .= "All fields are required";
  } else {


    // Check email....
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    // Check name....
    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $name)) {
      $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    // Check message length....
    if (strlen($message) < 1) {
      $error_message .= 'The Comments you entered do not appear to be valid.<br />';
    }

    // create email headers....
    $headers = 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    $is_mail_send = mail($email_to, $email_subject, $message, $headers);
    if ($is_mail_send) {
      echo "Thanks for contacting us.";
    } else {
      $error_message .= "Mail not send!";
    }
  }
  if (strlen($error_message) > 0) {
    died($error_message);
  }
}
?>