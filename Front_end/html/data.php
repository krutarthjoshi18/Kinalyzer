<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Data Upload";

    if (isset($_POST['user'])) $user = htmlspecialchars($_POST['user']);
    if (isset($_POST['email'])) $email = htmlspecialchars($_POST['email']);
    if (isset($_POST['algo'])) $algo = htmlspecialchars($_POST['algo']);
    if (isset($_FILES['input_file'])) $fileContent = file_get_contents($_FILES['input_file']['tmp_name']);
?>
<html>
<head>
<title>Kinalyzer</title>
<?php include("inc/headIncludes.php"); ?>
<script src="js/tablesorter.js" type="text/javascript"></script>
</head>
<body>
<?php 
    include("inc/header.php"); 

    $validInput = true;

    if ($user == ""){
        echo "<br>Oops! You forgot to enter your name. Please try again.<br>";
        $validInput = false;
    }
    if ($email == ""){
        echo "<br>Oops! You forgot to enter an email address. Please try again.<br>";
        $validInput = false;
    } elseif (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/", $email)) {
        echo "<br>Oops! The email is not in a valid format. Please try again.<br>";
        $validInput = false;
    }
    if ($algo == ""){
        echo "<br>Oops! You forgot to enter an algorithm. Please try again.<br>";
        $validInput = false;
    }
    if (!isset($_FILES['input_file']['error']) || is_array($_FILES['input_file']['error'])) {
        echo "<br>Oops! There was an error uploading your file. Please try again.<br>";
        $validInput = false;
    }

    switch ($_FILES['input_file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "<br>Oops! There was an error uploading your file. Please try again.<br>";
            $validInput = false;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "<br>Oops! The file you have selected is too large. Please try again.<br>";
            $validInput = false;
        default:
            echo "<br>Oops! There was an error uploading your file. Please try again.<br>";
            $validInput = false;
    }
    if ($_FILES['input_file']['size'] > 10000000) {
        echo "<br>Oops! The file you have selected is too large. Please try again.<br>";
        $validInput = false;
    }

    if ($fileContent == ""){
            echo "<br>Oops! Your file is empty. Please try again.<br>";
            $validInput = false;
        }

    if ($validInput){
        $lines = preg_split('/\r\n|\n|\r/', trim($fileContent));

        if (count($lines) == 0){
            echo "<br>Oops! Your file doesn't seem to have enough lines. Please try again.<br>";
            $validInput = false;
        }

        for ($i=0; $i < count($lines); $i++) { 
            $lines[$i] = explode(',', $lines[$i]);
        }
        
        $n = count($lines[0]);
        $nloci = ($n - 1) / 2;
        if (!($n%2) || $n<3) {
            echo "<br>Oops! Data has only $n colums, but it needs exactly $n+1 to represent $nloci loci.<br>";
            $validInput = false;
        }

        $header = $lines[0];
        $isHeader = false;
        for ($i=0; $i < count($header); $i++) { 
            if (!is_numeric($header[$i])){
                $isHeader = true;
                break;
            }
        }
        if ($isHeader){
            $temp = array_shift($lines); // remove header
        } else {
            $header[0] = "Loci";
            for ($i=1; $i < $nloci; $i++) { 
                $header[2*$i-1] = "".$i."a";
                $header[2*$i] = "".$i."b";
            }
        }

        $population = count($lines);

        if (count($lines) == 0){
            echo "<br>Oops! Population is empty. Please try again.<br>";
            $validInput = false;
        }

        for ($i=0; $i < count($lines); $i++) { 
            if ($n != count($lines[$i])) {
                echo "<br>Oops! The animal on a line beginning with '" . $lines[$i][0] . "' does not have the same entries in its line as the first line (Please add/remove some commas).<br>";
                $validInput = false;
            }
            for ($j=1; $j < $n; $j++) { 
                if (!is_numeric($lines[$i][$j])){
                    echo "<br>Oops! The animal on a line beginning with '" . $lines[$i][0] . "' has an allele [".$header[$j]."] not specified as a numeric value.<br>";
                    $validInput = false;
                } elseif ($lines[$i][$j] < 0){
                    $lines[$i][$j] = -1;
                }
            }
        }
    }


    if ($validInput) {
        $numCols = 1 + (($n+1) / 2);

        echo "<br>";
        echo '<table border="1" id="newtable">';
        echo '  <thead>';
        echo '      <tr>';
        echo '          <td colspan="' . ($numCols) . '" class="thead">';
        echo '              Kinalyzer Data Selection';
        echo '          </td>';
        echo '      </tr>';
        echo '  </thead>';
        echo '  <tbody>';
        echo '      <tr class="topRow">';
        echo '          <td></td>';
        echo '          <td></td>';
        for ($i=2; $i < ($numCols); $i++) { 
            echo '<td><input type="checkbox" name="" value="" checked></td>';
        }
        echo '      </tr>';
        echo '      <tr>';
        echo '          <td></td>';
        for ($i=0; $i < $n; $i++) {
            if ($i == 0){
                echo '<td class="highlighted permanent">'.$header[$i].'</td>';
            } else {
                echo '<td class="highlighted">'.$header[$i].'/'.$header[$i+1].'</td>';
                $i++;
            }
        }
        echo '      </tr>';
        for ($i=0; $i < $population; $i++) {
            echo '      <tr>';
            echo '<td><input type="checkbox" name="" value="" checked></td>'; 
            for ($j=0; $j < $n; $j++) {
                if ($j == 0){
                    echo '<td class="highlighted">'.$lines[$i][$j].'</td>';
                } else {
                    echo '<td class="">'.$lines[$i][$j].'/'.$lines[$i][$j+1].'</td>';
                    $j++;
                }
            }
            echo '      </tr>';
        }
        echo '      </tr>';
        echo '  </tbody>';
        echo '  <tfoot>';
        echo '   <tr>';
        echo '      <td colspan="' . ($numCols) . '" class="tfoot">';
        echo '          <div class="foot_options">';
        echo '              <ul>';
        echo '                  <li>';
        echo '                      <a href="#" class="all_on">Select All</a>';
        echo '                  </li>';
        echo '                  <li>';
        echo '                      <a href="#" class="all_off">Deselect All</a>';
        echo '                  </li>';
        echo '              </ul>';
        echo '          </div>';
        echo '      </td>';
        echo '   </tr>';
        echo '  </tfoot>';
        echo '</table>';

        echo '<br><br>';
        echo '<FORM ACTION="upload.php" METHOD="post" ENCTYPE="multipart/form-data">';
        echo "<b>User</b> $user ".'<input type="hidden" name="user" value="'.$user.'">  <br>';
        echo "<b>Email</b> $email".'<input type="hidden" name="email" value="'.$email.'">  <br>';
        echo "<b>Loci</b> <span id='nloci'>$nloci</span>".'<input type="hidden" name="loci" value="'.$nloci.'" id="nlociData">  <br>';
        echo "<b>Population</b> <span id='population'>$population</span>".'<input type="hidden" name="population" value="'.$population.'" id="populationData">  <br>'; 
        echo '<input type="hidden" name="upload" value="" id="tableData">';
        echo '<input type="hidden" name="algo" value="'.$algo.'">';
        echo '<br><INPUT TYPE="submit" NAME="Kinalyze" VALUE="Kinalyze" class="button submit"><br><br>';
        echo "</FORM><br>";

    } else {
        echo "<br><form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;' class='button'> </form><br>";
    }
    
?>
    <br>
</div>


<?php include("inc/footer.php"); ?>
</body>
</html>