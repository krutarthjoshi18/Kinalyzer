<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Welcome to Kinalyzer, the Kinship Analyzer";
?>
<?php include("inc/doctype.php"); ?>
<html>
<head>
<title>Kinalyzer</title>
<?php include("inc/headIncludes.php"); ?>
</head>
<body>
<?php include("inc/header.php"); ?>


                    <div class="signUp positioning">
                        <div class="stepTooltip step1">
                            <div class="positioning">
                                <div class="toolArrow"></div>
                                <span>Step 1: Enter Your Name</span>
                                <p>We will only use this information to Kinalyze your data. We will not contact you with offers or give it away.</p>
                            </div>
                        </div>
                        <div class="stepTooltip step2">
                            <div class="positioning">
                                <div class="toolArrow"></div>
                                <span>Step 2: Enter Your E-Mail</span>
                                <p>We will only use this information to Kinalyze your data. We will not contact you with offers or give it away.</p>
                            </div>
                        </div>
                        <div class="stepTooltip step3">
                            <div class="positioning">
                                <div class="toolArrow"></div>
                                <span>Step 3: Select Algorithm</span>
                                <p>We will only use this information to Kinalyze your data. We will not contact you with offers or give it away.</p>
                            </div>
                        </div>
                        <img src="images/duck.jpg" alt="Duck" />
                        <img src="images/fish.jpg" alt="Fishes" />
                        <img src="images/bear.jpg" alt="Bear" />
                        <form action="data.php" method="post" enctype="multipart/form-data" id="kin_form">
                            <div class="label nameInput"></div><input type="text" name="user" class="input_name" placeholder="Name"><br>
                            <div class="label emailInput"></div><input type="email" name="email" class="input_email" placeholder="Email"><br>
                            <div class="label algInput"></div><div class="algDrop"></div>
                            <select id="source" name="algo">
                                <option value="-1" selected="selected">Choose an Algorithm</option>
                                <option value="0">2-Allele</option>
                                <option value="1">Consensus</option>
                            </select>
                            <br><br>
                            <span class="file-input-wrapper">
                                <a href="#" class="choose button btn-file-input">Choose File</a>
                                <input type="file" name="input_file" id="fileToUpload">
                            </span>
                            <a href="#" class="continue button grayed">Continue</a>
                            <input TYPE="hidden" name="Kinalyze" value="Kinalize">
                        </form>
                    </div>
                </div>
                <div class="quote">
                    <div class="pageWidth">
                        <blockquote><span></span>"I do not believe that the accident of birth makes people sisters and brothers.<br>
                        It makes them siblings. Gives them mutuality of parentage."</blockquote>
                        <cite>--Maya Angelou</cite>
                    </div>
                </div>
                <div class="information">
                    <div class="pageWidth">
                        <div class="aboutUs">
                            <h2>About the Kinalyzer</h2>
                            <p>Kinalyzer is a sofware suite developed to reconstruct sibling groups using genotypes from codominant markers such as microsatellites. Currently there are two algorithms available to reconstruct full-sibling groups for cases where parental genotypes are not available. Kinalyzer uses combinatorial optimization based on Mendelian inheritance rules to find the fewest number of sibling groups that contain all the individuals in the sample '2-allele set cover'. Also available is a 'Consensus' method that reconstructs sibgroups using subsets of loci and finds the consensus of these different solutions. A sample dataset can be found <a href="sample-data/samplefile1.txt">here</a>.</p>
                        </div>
                        <br class="clear">
                    </div>
                </div>
        </div>


<?php include("inc/footer.php"); ?>
</body>
</html>
