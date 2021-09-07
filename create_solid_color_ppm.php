#!/usr/bin/php -q
<?php

//--------------------------------------------------------------------------------------
//   If run with no command line args, print out usage statement and bail
//--------------------------------------------------------------------------------------

  $argc = count($argv);

  if($argc==1)
  {
    print "\n\nUsage:\n";
    print "  create_solid_color_ppm.php out_file width height red green blue\n\n";
    print "Examples:\n";
    print "  ./create_solid_color_ppm.php sample.ppm 200 300 255 0 0\n\n";
    print "  Create a solid color binary ppm file with the filename given in the first argument.  The dimensions\n";
    print "  and color is specified in the next 5 args.\n\n";

    exit(0);
  }

  include '../library/library_ppm.php'; 

//--------------------------------------------------------------------------------------
//   Read in the command line arguments
//--------------------------------------------------------------------------------------

  $ppmfile = $argv[1];
  $width   = $argv[2];
  $height  = $argv[3];
  $red     = $argv[4];
  $green   = $argv[5];
  $blue    = $argv[6];

//--------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------

  $image = createBlank8BitImageArray($width,$height);

  set8BitImageArrayColor($image,$red,$green,$blue);

  write8BitImageArrayToBinaryPPMFile($ppmfile,$image);

?>
