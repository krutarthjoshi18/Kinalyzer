#!/bin/bash
cd /opt/kinalyzer/
taskset -cp 25,27 /usr/bin/perl kinalyzer_scheduler.pl 
