#!/usr/bin/perl

					
#Prepare output mail
$sendmail = "/usr/sbin/sendmail -t";
$reply_to = "Reply-to: tanyabw\@uic.edu,mmaggi3\@uic.edu\n";
$send_to = "To: mmaggi3\@uic.edu\n";
$from = "From: Kinalyzer <kinalyzer\@pachy.cs.uic.edu>\n";
$subject = "Subject: Kinalyzer output for\n";

#Send mail	
open(SENDMAIL, "|$sendmail") or die "Cannot open $sendmail: $!";
print SENDMAIL $from;
print SENDMAIL $reply_to;
print SENDMAIL $subject;
print SENDMAIL $send_to;
print SENDMAIL "Content-type: text/plain\n\n";
print SENDMAIL $content;
close(SENDMAIL);


