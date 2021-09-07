#!/usr/bin/php -q
<?php

//--------------------------------------------------------------------------------------
//   If run with no command line args, print out usage statement and bail
//--------------------------------------------------------------------------------------

  $argc = count($argv);

  if($argc==1)
  {
    print "\n\nUsage:\n";
    print "  insert_image_into_another.php target_file source_file left_x top_y out_file\n\n";
    print "Examples:\n";
    print "  ./insert_image_into_another.php sample_data/GreyGradient-50x50.ppm sample_data/Red-20x10.ppm 10 5 output.ppm\n\n";
    print "  Input two ppm files and insert the second into the first and output the result as a third file.\n";
    print "  The upper left corner in the target image is also specified.  If the insert dimensions exceed\n";
    print "  the size of the target, the 'overflow' is safely ignored.\n\n";

    exit(0);
  }

  include '../library/library_ppm.php'; 

//--------------------------------------------------------------------------------------

  $target  = $argv[1];
  $source  = $argv[2];
  $left_x  = intval($argv[3]);
  $top_y   = intval($argv[4]);
  $outfile = $argv[5];

//--------------------------------------------------------------------------------------

  $image = read8BitImageArrayFromBinaryPPMFile($target);
  $add = read8BitImageArrayFromBinaryPPMFile($source);

  insert8BitImageArray($image,$add,$left_x,$top_y);

  write8BitImageArrayToBinaryPPMFile($outfile,$image);

?>
