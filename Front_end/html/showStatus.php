<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Check Status";

    $email = $_POST['email'];
    $id = intval($_POST['id']);


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
    <?php
        $validInput = true;

        $mysqli = new mysqli("localhost", "kinalyzer", "OMDHaF!", "kinalyzer");
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            $validInput = false;
        }

        if ($id <= 0){
            echo "<br>Oops! You forgot to enter the request ID. Please try again.<br>";
            $validInput = false;
        }

        if ($email == ""){
            echo "<br>Oops! You forgot to enter an email address. Please try again.<br>";
            $validInput = false;
        }

        if ($validInput){
            if ($stmt = $mysqli->prepare("SELECT * FROM requests WHERE id = ? and email = ?")) {
                $stmt->bind_param("is", $id, $email);
                $stmt->execute();
                $stmt->store_result();
                $num_of_rows = $stmt->num_rows;
                $stmt->bind_result($id, $time, $user, $email, $population, $nloci, $upload, $algorithm, $state, $result);

                if ($num_of_rows >= 1) {
                    while ($stmt->fetch()) {
                        echo '<b>User</b> '.$user.'<br>';
                        echo '<b>ID</b> '.$id.'<br>';
                        echo '<b>Time</b> '.$time.'<br>';
                        echo '<b>Loci</b> '.$nloci.'<br>';
                        echo '<b>Population</b> '.$population.'<br>';
                        if ($algorithm==0) {
                            echo '<b>Algorithm</b> 2-allele<br>';
                        }
                        if ($state==0) {
                            echo '<br><b>State</b> Not yet Kinalyzed<br>';
                        } else if ($state==1) {
                            echo '<b>State</b> Completed <br><br>';
                            echo '<b>Result</b><br>';
                            $data = explode("\n",$result);    
                            foreach ($data as $val) {
                                echo $val."<br>";
                            }
                        } else if ($state== 2) {
                            echo '<br><b>State</b> An error occurred and computation could not be completed<br>';
                        }
                   }
                } else {
                    echo "<br>Oops! The id and/or email you entered do not match any submission in the Kinalyzer database. Please try again.<br>";
                    $validInput = false;
                }

                $stmt->free_result();
                $stmt->close();
            }
        }

        if ($validInput) {

        } else {
            echo "<br><form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;' class='button'> </form><br>";
        }


        $mysqli->close();
    ?>
</div>

<?php include("inc/footer.php"); ?>
</body>
</html>