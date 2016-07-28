#!/usr/bin/perl -w

use CGI;
use DBI;

$query = new CGI;
$email_q = $query->param("email");
$id_q = $query->param("id");
print $query->header();

#Check if id has been inserted
if(!$id_q) { 

  #Header section 
  printheadererror();

  #Error section  
  print "Oops! You forgot to enter the request ID. Please try again.<br>
         <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

#Check if email has been inserted
if(!$email_q) {      
  #Header section
  printheadererror();

  #Error section
  print "Oops! You forgot to enter your email address. Please try again. <br>
  <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}

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

#Execute query
$get_requests = $dbh->prepare("SELECT * FROM requests WHERE id = ? and email = ?");
$get_requests->execute($id_q,$email_q);		

#No result
if ($get_requests->rows() != 1 ) {

  #Header section
  printheadererror();

  #Error section
  print "The id and/or email you entered do not match any submission in the Kinalyzer database. Please try again. <br> 
         <form><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'> </form>";
  printfooter();
  exit;
}


$get_requests->bind_columns(\$id,\$time,\$user,\$email,\$population,\$nloci,\$upload,\$algorithm,\$state,\$result);
while($get_requests->fetch())	{	

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
<h1>Kinalyzer Submission</h1>
<div id="Sidebar-bar"></div>
</div>
END_HTML
  
  print "<b>User : </b>$user<br>"; 
  print "<b>Email : </b>$email<br><br>";

  print "<b>ID : </b>$id<br>";
  print "<b>Time : </b>$time<br>";
  print "<b>Loci : </b>$nloci<br>";
  print "<b>Population : </b>$population<br>";
  if ($algorithm==0) {
    print "<b>Algorithm : </b>2-allele<br>";
  }

  if ($state==0) {
    print "<br><b>State : </b> Not yet Kinalyzed<br>"; 
  } 
  elsif ($state==1) {
    print "<b>State : </b> Completed <br><br>";
    print "<b>Result : </b><br>";
    @data = split("\n",$result);    
    for my $i (0 .. $#data) {
      print $data[$i]."<br>";
    } 
  }
  elsif ($state==2) {
    print "<br><b>State : </b> An error occurred and computation could not be completed<br>";
  }
 
  printfooter();
  exit;
}

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
