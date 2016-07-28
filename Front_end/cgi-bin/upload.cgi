#!/usr/bin/perl -w

use CGI qw(:standard);
use DBI;

$query = new CGI;

#Parameters from header
print $query->header();
$user = escapeHTML($query->param("user"));
$email = escapeHTML($query->param("email"));
$algo = $query->param("algo");
$algo = 0;
$nloci = $query->param("loci");
$population = $query->param("population");
$upload = $query->param("upload");

#Kinalyzer database 
my $dsn = 'DBI:mysql:kinalyzer:localhost';
my $db_username = 'kinalyzer';
my $db_password = 'OMDHaF!';
my $dbh = DBI->connect($dsn, $db_username, $db_password);

# Insert into requests table
if (!$dbh) {

  #Header section
  printheadererror();

  #Error section
  print "Oops! I could not connect to the Kinalyzer database <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

my $insert_handle = $dbh->prepare_cached('INSERT INTO requests (user,email,population,loci,upload,algorithm,state) VALUES (?,?,?,?,?,?,?)');
my $result = $insert_handle->execute($user,$email,$population,$nloci,$upload,$algo,'0');

# Insert into requests table
if (!$result) {

  #Header section
  printheadererror();

  #Error section
  print "Oops! I could not upload into the Kinalyzer database <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

# Getting the request_id from the table
$id = $dbh->last_insert_id(undef, undef, qw(requests id));

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
<h1>Upload complete</h1>
<div id="Sidebar-bar"></div>
</div>
END_HTML

print "<b>Request ID : </b>$id<br><br>";
print "Your upload has been completed succesfully. When Kinalyzer computation is completed, you will receive an email with the results.</br>";
print 'You can also use <a href="status.html">this page</a> to check the status of your submission (please, take note of your submission ID).</br>'; 

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

