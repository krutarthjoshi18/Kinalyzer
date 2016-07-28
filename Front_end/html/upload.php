<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Data Submitted";

    if (isset($_POST['user'])) $user = htmlspecialchars($_POST['user']);
    if (isset($_POST['email'])) $email = htmlspecialchars($_POST['email']);
    if (isset($_POST['algo'])) $algo = htmlspecialchars($_POST['algo']);
    if (isset($_POST['loci'])) $nloci = htmlspecialchars($_POST['loci']);
    if (isset($_POST['population'])) $population = htmlspecialchars($_POST['population']);
    if (isset($_POST['upload'])) $upload = $_POST['upload'];


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

<div class="pageWidth upload">
    <?php
        $validInput = true;

        $mysqli = new mysqli("localhost", "kinalyzer", "OMDHaF!", "kinalyzer");
        if ($mysqli->connect_errno) {
            echo "<br>Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "<br>";
            $validInput = false;
        }

        if ($email == ""){
            echo "<br>Oops! You forgot to enter an email address. Please try again.<br>";
            $validInput = false;
        }

        if ($validInput){
            if ($stmt = $mysqli->prepare('INSERT INTO requests (user,email,population,loci,upload,algorithm,state) VALUES (?,?,?,?,?,?,?)')) {
                $state = 0;
                $bind = $stmt->bind_param("ssiisii", $user, $email, $population, $nloci, $upload, $algo, $state);
                if ($bind === false){
                    echo "<br>Oops! There was an error preparing the statement to insert. Please try again.<br>";
                    $validInput = false;
                } else {
                    $exec = $stmt->execute();
                    if ($exec === false){
                        echo "<br>Oops! There was an error inserting your data. Please try again.<br>";
                        $validInput = false;
                    }
                }
                
                $stmt->close();
            }
        }

        if ($validInput) {
            echo "<b>Request ID : </b>" . $mysqli->insert_id . "<br><br>";
            echo "Your upload has been completed succesfully. When Kinalyzer computation is completed, you will receive an email with the results.</br>";
            echo 'You can also use <a href="status.php">this page</a> to check the status of your submission (please, take note of your submission ID).</br></br>';  
        } else {
            echo "<br><a href='index.php' class='button'>Back</a><br>";
        }


        $mysqli->close();
    ?>
</div>

<?php include("inc/footer.php"); ?>
</body>
</html>