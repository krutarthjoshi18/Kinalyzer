<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Check Status";
?>
<?php include("inc/doctype.php"); ?>
<html>
<head>
<title>Check Status</title>
<?php include("inc/headIncludes.php"); ?>
</head>
<body>
<?php include("inc/header.php"); ?> 

</div></div>
<br>

<div class="pageWidth status">
    <form action="showStatus.php" method="post" enctype="multipart/form-data"><br>
        <h1>To find the status of a submitted request please enter the request-id and the email address</h1><br><br>
        <input type="text" name="id" size="25" placeholder="Request ID" autofocus>
        <br>
        <input type="text" name="email" size="31" placeholder="E-mail">
        <br>
        <input type="submit" name="Submit" value="Submit" class="button">
        <br><br><br>
    </form>
</div>

<?php include("inc/footer.php"); ?>
</body>
</html>