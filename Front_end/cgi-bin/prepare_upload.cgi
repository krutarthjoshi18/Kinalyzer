#!/usr/bin/perl -w

use CGI qw(:standard);
use DBI;
use Scalar::Util qw(looks_like_number);

$query = new CGI;

#Parameters from header
print $query->header();
$filename = $query->param("input_file");
$user = escapeHTML($query->param("user"));
$email = escapeHTML($query->param("email"));
$algo = $query->param("algo");
$nloci = 0;
$linesbyloci=0;
$filename =~ s/.*[\/\\](.*)/$1/;
$upload_filehandle = $query->upload("input_file");

#Check if file has been upload
if (!$filename) {	
  
  #Header section
  printheadererror();

  #Error section
  print "Oops! You forgot to select a file for uploading. Please try again. <br> 
        <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check if username has been inserted
elsif(!$user)
{	

  #Header section
  printheadererror();

  #Error section
  print "Oops! You forgot to enter your name. Please try again.<br> 
         <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check if username has been inserted
elsif(!$email)
{	
  #Header section
  printheadererror();

  #Error section	
  print "Oops! You forgot to enter your email address. Please try again. <br> 
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}


#Check email format
$email_temp = $email;
if (!($email_temp =~ m!\s*(\S+@+(\S+))\s*!)) {

  #Header section	
  printheadererror();

  #Error section	
  print "Oops! The email is not in a valid format. Please try again. <br> 
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Sanitize
my @data = <$upload_filehandle>; 
for my $i (0 .. $#data) {
  chomp($data[$i]);
  $data[$i] = [split(',',$data[$i])];
}
if (!(@data)) {
   
  #Header section
  printheadererror();

  #Error section
  print "Oops! Data is empty <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check alleles consistency
$n = @{$data[0]};
$nloci = ($n-1)/2;
if (!($n%2) || $n<3) {

  #Header section
  printheadererror();

  #Error section
  print "Oops! Data has only $n colums, but it needs exactly $n+1 to represent $nloci loci <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check header (possibly first line)
@header = @{$data[0]};
$is_header = 0;
for my $i (1 .. $#header) {
  $temp = $header[$i];
  if (!(looks_like_number($temp))) {
    $is_header = 1;
    break;
  }
}
if ($is_header) {
  @data = @data[1..$#data];
} else {
  $header[0] = "Loci";
  for my $i (1..$nloci) {
    $header[2*$i-1] = "".$i."a";
    $header[2*$i] = "".$i."b";
  }
}
$population = @data;
if (!(@data)) {
   
  #Header section
  printheadererror();

  #Error section
  print "Oops! Population is empty <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check data 
for my $i (0 .. $#data) {
  $temp = @{$data[$i]};
  if ($temp != $n) {

    #Header section
    printheadererror();

    #Table
    print "<br>";
    print "<table border=1>";
    print "<tr>";
    for my $j (0 .. $n-1) {
      print "<td><b>$header[$j]</b></td></font>";
    }
    print "</tr>";
    print "<tr>"; 
    for my $j (0 .. $n-1) {
      print "<td><font color= '#726E6D'>$data[$i][$j]</td></font>";
    }
    print "</tr>";
    print "</table>";
    print "<br>";

    #Error section
    print "Oops! This animal does not have the right number of entries in its line (Please add/remove some commas) <br>
    <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
    printfooter();
    exit;
  }
}

#Check alleles data 
for my $i (0 .. $#data) {
  for my $j (1 .. $n-1) {  

    if (!looks_like_number($data[$i][$j])) {

      #Header section
      printheadererror();

      #Table
      print "<br>";
      print "<table border=1>";
      print "<tr>";
      for my $j (0 .. $n-1) {
        print "<td><b>$header[$j]</b></td></font>";
      }
      print "</tr>";
      print "<tr>";
      for my $j (0 .. $n-1) {
        print "<td><font color= '#726E6D'>$data[$i][$j]</td></font>";
      }
      print "</tr>";
      print "</table>";
      print "<br>";

      #Error section
      print "Oops! This animal has an allele [".$header[$j]."] not specified as a numeric value <br>
      <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
      printfooter();
      exit;
    }
  }
}

#Sanitize missing values
for my $i (0 .. $#data) {
  for my $j (1 .. $n-1) {
    if ($data[$i][$j]<0) {
      $data[$i][$j] = -1;
    }
  }
}

#Prepare data to be passed over HTTP
$data_string = join(",",@header)."\n";
for my $i (0 .. $#data) {
  $data_string .= join(",",@{$data[$i]})."\n"; 
}

#Header section
$headerfile = "../html/header.html";
open( FILE, "<$headerfile" ) or die "Can't open $filename : $!";
while( <FILE> ) {
  print;
}
close FILE;

#HTML section
print <<END_HTML;
<link href="css.css" rel="stylesheet" type="text/css">
<div id="Sidebar">
<h1>Submission ready</h1>
<div id="Sidebar-bar"></div>
</div>
END_HTML

print '<FORM ACTION="cgi-bin/upload.cgi" METHOD="post" ENCTYPE="multipart/form-data">';
print "<b>User : </b>$user ".'<input type="hidden" name="user" value="'.$user.'">  <br>';
print "<b>Email : </b>$email".'<input type="hidden" name="email" value="'.$email.'">  <br>';
print "<b>Loci : </b>$nloci".'<input type="hidden" name="loci" value="'.$nloci.'">  <br>';
print "<b>Population : </b>$population".'<input type="hidden" name="population" value="'.$population.'">  <br>'; 
print '<input type="hidden" name="upload" value="'.$data_string.'">';
print '<input type="hidden" name="algo" value="'.$data_string.'">';
print '<INPUT TYPE="submit" NAME="Kinalyze" VALUE="Kinalyze"><br><br>';
print "</FORM>";

$algo = $query->param("algo");
$nloci = 0;

#Table
print "<b>Upload : </b><br>";
print "<table border=1>";
print "<tr>";
for my $j (0 .. $n-1) {
  print "<td><b>$header[$j]</b></td></font>";
}
print "</tr>";
for my $i (0 .. $#data) {  
  print "<tr>";
  for my $j (0 .. $n-1) {
    print "<td><font color= '#726E6D'>$data[$i][$j]</td></font>";
  }
  print "</tr>";
}
print "</table>";
print "<br>";

printfooter();
exit;

sub printheadererror {

  #Header section
  $headerfile = "../html/header.html";
  open( FILE, "<$headerfile" ) or die "Can't open $filename : $!";
  while( <FILE> ) {
    print;
  }
  close FILE;

#HTML section
print <<END_HTML;
<link href="css.css" rel="stylesheet" type="text/css">
<div id="Sidebar">
<h1>Error</h1>
<div id="Sidebar-bar"></div>
</div>
END_HTML

}

sub printfooter { 
  $footerfile = "../html/footer.html"; 
  open( FILE, "<$footerfile" ) or die "Can't open $filename : $!";
  while( <FILE> ) {
    print;
  }
  close FILE;
}
