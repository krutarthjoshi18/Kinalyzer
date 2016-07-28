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


<p><p>
<center>
<font size="5" color="black"><b>
<p>&nbsp;<p><p>&nbsp;<p><p>&nbsp;<p><p>&nbsp;<p>
Kinalyzer is temporarily unavailable while we make improvements to our service.<p>&nbsp;<p>
Apologies for the inconvenience. Please check back shortly.
<p>&nbsp;<p>
If you have any questions please email us at <a href="mailto:kinalyzer@cs.uic.edu">kinalyzer@cs.uic.edu</a>.
<p>&nbsp;<p><p>&nbsp;<p><p>&nbsp;<p><p>&nbsp;<p>
</b></font>
</center>
<p><p>

                <div class="information">
                    <div class="pageWidth">
                        <div class="aboutUs">
                            <h2>About the Kinalyzer</h2>
                            <p>Kinalyzer is a sofware suite developed to reconstruct sibling groups using genotypes from codominant markers such as microsatellites. Currently there are two algorithms available to reconstruct full-sibling groups for cases where parental genotypes are not available. Kinalyzer uses combinatorial optimization based on Mendelian inheritance rules to find the fewest number of sibling groups that contain all the individuals in the sample ('2-allele set cover'). Also available is a 'concensus' method that reconstructs sibgroups using subsets of loci and finds the consensus of these different solutions. A sample dataset can be found <a href="sample-data/samplefile1.txt">here</a>.</p>
                        </div>
                        <br class="clear">
                    </div>
                </div>
        </div>


<?php include("inc/footer.php"); ?>
</body>
</html>
