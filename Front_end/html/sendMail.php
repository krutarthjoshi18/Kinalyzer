<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Send Contact";

    $user = htmlspecialchars($_POST['user']);
    $institution = htmlspecialchars($_POST['institution']);
    $email = htmlspecialchars($_POST['email']);
    $comments = htmlspecialchars($_POST['comments']);
    if (isset($_POST['g-recaptcha-response'])) $captcha=$_POST['g-recaptcha-response'];
?>
<?php include("inc/doctype.php"); ?>
<html>
<head>
<title>Send Contact</title>
<?php include("inc/headIncludes.php"); ?>

</head>
<body>
<?php include("inc/header.php"); ?>

</div></div>
<br>
<div class="pageWidth">
    <?php
        $validInput = true;

        if ($email == ""){
            echo "<br>Oops! You forgot to enter an email address. Please try again.<br>";
            $validInput = false;
        }

        if ($comments == ""){
            echo "<br>Oops! You forgot to enter a comment. Please try again.<br>";
            $validInput = false;
        }

        if ($captcha == ""){
            echo "<br>Oops! You forgot to enter the captcha. Please try again.<br>";
            $validInput = false;
        } else {
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeZegYTAAAAAAnRT8V8JhQzAeQoEy8_42_qG-e6&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
            if($response.success==false) {
                echo "<br>Oops! You didn't enter the captcha correctly. Please try again.<br>";
                $validInput = false;
            }
        }

        if ($validInput){
            $message = "A comment was received from the contact form. \r\n";
            if ($user == "") {
                $message = $message . "The user didn't enter their name. \r\n";
            } else {
                $message = $message . "Name: " . $user . "\r\n";
            }
            if ($institution == "") {
                $message = $message . "The user didn't enter their institution. \r\n";
            } else {
                $message = $message . "Institution: " . $institution . "\r\n";
            }
            $message = $message . "Email: " . $email . "\r\n";
            $message = $message . "Comment: " . $comments . "\r\n";

            $message = wordwrap($message, 70, "\r\n");

            $sent = mail( "tanyabw@uic.edu" , "Kinalyzer Contact Form" , $message );

            if (!$sent){
                echo "<br>Oops! Your contact request didn't email correctly. Please try again.<br>";
                $validInput = false;
            }
        }


        if ($validInput){
            echo "Thanks for your comment! It has been sent.";
        } else {
            echo "<br><form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;' class='button'> </form><br>";
        }

    ?>
</div>
<br>
<?php include("inc/footer.php"); ?>
</body>
</html>