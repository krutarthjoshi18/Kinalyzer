<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Contact Us";
?>
<?php include("inc/doctype.php"); ?>
<html>
<head>
<title>Contact Us</title>
<?php include("inc/headIncludes.php"); ?>

<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<?php include("inc/header.php"); ?>

</div></div>
<br>
<div class="pageWidth">
    <form method="POST" action="sendMail.php" class="positioning">
        <div class="formControls">
            <span class="guide"><span class="requiredGuide">*</span> = Required</span><br />
            <input type="submit" class="button">
            <input type="reset" class="button blue-button">
        </div>
        <input type="text" name="user" size="35" id="contact_name" class="contact_name" placeholder="Name" autofocus><br>
        <input type="text" name="institution" size="37" class="contact_institution" placeholder="Institution"><br>
        <span class="required"><input type="email" name="email" class="contact_email" placeholder="E-mail"></span><br>
        <span class="required"><textarea name="comments" class="contact_text"></textarea></span>
        <div class="required g-recaptcha" data-sitekey="6LeZegYTAAAAAHh7Lws1jbCWGz596h5eMrBAITGT"></div>
    </form>
</div>
<br>
<?php include("inc/footer.php"); ?>
</body>
</html>