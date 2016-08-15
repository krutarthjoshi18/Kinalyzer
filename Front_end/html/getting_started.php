<?php include("inc/global.php"); ?>
<?php
    $pagetitle = "Getting Started";
?>
<?php include("inc/doctype.php"); ?>
<html>
<head>
<title>Getting Started</title>
<?php include("inc/headIncludes.php"); ?>
</head>
<body>
<?php include("inc/header.php"); ?>

</div></div>
<br>
<div class="pageWidth gettingStarted">
    <h1>Program Description</h1>
    <br>
    <p>
    Kinalyzer reconstructs full-sibling groups without parental information. It uses data from codominant marker loci such as microsatellites. 
    <br>Details can be found in <a href="http://compbio.cs.uic.edu/~tanya/research/pubs/AshleyEtal_KINALYZER.pdf" target='_blank'>KINALYZER, A Computer Program for Reconstructing Sibling Groups</a> by  Ashley et.al 2009.
    </p>

    <br>
    <br>
    <h1>Input File</h1>
    <p>
    The setup for the input data file is as follows:
    </p>

    <br>
    <p style="font-family:'Courier New'" >
<b>Loci,1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b</b><br>
Animal1,244,248,135,149,-1,-1,123,123,183,187,137,139<br>
Animal2,264,330,135,143,171,171,-1,-1,-1,-1,133,139<br>
Animal3,264,270,135,143,171,203,-1,-1,-1,-1,137,139<br>
Animal4,264,330,133,135,171,203,-1,-1,-1,-1,133,139<br>
Animal5,264,270,133,135,171,203,-1,-1,-1,-1,137,139<br>
Animal6,264,270,135,143,171,203,-1,-1,-1,-1,133,139<br>
Animal7,264,270,133,135,171,203,-1,-1,-1,-1,133,139<br>
Animal8,-1,-1,133,135,171,203,-1,-1,-1,-1,133,139<br>
Animal9,264,270,135,143,171,171,-1,-1,-1,-1,137,139<br>
Animal10,230,248,133,175,189,189,-1,-1,-1,-1,133,141<br>
Animal11,230,248,173,175,189,189,-1,-1,-1,-1,133,141<br>
Animal12,230,248,133,175,161,189,-1,-1,-1,-1,-1,-1<br>
Animal13,230,346,173,175,161,189,-1,-1,-1,-1,133,141<br>
    </p>

    <br>
    <ol>
        <li>
        1. The first line is a header with the word Loci followed by locus identifiers with an 'a' and a 'b' for each, indicating the two alleles identified at the locus. <br><br>
        </li>
        <li>
        2. In the following lines, the first column is the sample identifier, followed by two allele values for each of the loci, separated by commas.  Either two digit or three digit allele values are acceptable. Missing values should be coded as negative one <b>(-1).</b><br><br>
        </li>
        <li>
        3. Kinalyzer accepts comma separated files (csv).<br><br>
        </li>
    </ol>

    <p>
    <b>Sample Input File:</b>  <a target='_blank' href="sample-data/samplefile1.txt">SampleFile.csv</a> 
    </p>

    <br>
    <br>
    <h1>Input Options</h1>
    <p>
    The program can be run using either of two algorithms:  2-allele or consensus. 
    <br>This option is selected after entering a name and email address on the Home page.
    </p>

    <br>
    <h1>Output</h1>
    <p>
    Results will be sent to the email address provided on the Home page and will include the request-id provided when the input file is accepted. This identifier will be included in the email subject line. Status of your analysis can be found under the Check Status tab by entering the request-id and the email address used on the submittal.
    </p>

    <br>
    <h1>Limits</h1>
    <p>
    There is no limit to sample size or number of loci. Time to get results will, of course, depend on input sizes.
    </p>

    <br>
    <h1>How to Cite</h1>
    <p>
    Ashley, Mary V., I. C. Caballero, W. Chaovalitwongse, Bhaskar DasGupta, P. Govindan, S. I. Sheikh, and Tanya Y. Berger‐Wolf. "KINALYZER, a computer program for reconstructing sibling groups." <i>Molecular Ecology Resources 9, no. 4 </i>(2009): 1127-1131.
    </p>
    <br>
    <p>
    Berger-Wolf, Tanya Y., Saad I. Sheikh, Bhaskar DasGupta, Mary V. Ashley, Isabel C. Caballero, Wanpracha Chaovalitwongse, and S. Lahari Putrevu. "Reconstructing sibling relationships in wild populations." <i>Bioinformatics 23, no. 13 </i>(2007): i49-i56.
    </p>

    <br>

</div>
<br>
<?php include("inc/footer.php"); ?>
</body>
</html>
