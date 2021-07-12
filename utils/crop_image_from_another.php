#!/usr/bin/php -q
<?php

//--------------------------------------------------------------------------------------
//   If run with no command line args, print out usage statement and bail
//--------------------------------------------------------------------------------------

  $argc = count($argv);

  if($argc==1)
  {
    print "\n\nUsage:\n";
    print "  crop_image_from_another.php source_file crop_left_x crop_top_y crop_width crop_height out_file\n\n";
    print "Examples:\n";
    print "  ./crop_image_from_another.php sample_data/GreyGradient-50x50.ppm 0 10 20 20 output.ppm\n\n";
    print "  Input a ppm file and crop out a portion.  User specifies the upper left corner to start\n";
    print "  the crop from and the width and height of the portion saved.  Original file is unchanged\n";
    print "  and new output file is the last arg.  If the cropped size exceeds the range dimensions of\n";
    print "  the original image, the 'overflow' areas will be solid white in the output.\n\n";

    exit(0);
  }

  include '../library/library_ppm.php'; 

//--------------------------------------------------------------------------------------

  $in_file     = $argv[1];
  $left_x      = $argv[2];
  $top_y       = $argv[3];
  $crop_width  = $argv[4];
  $crop_height = $argv[5];
  $crop_file   = $argv[6];


//--------------------------------------------------------------------------------------

  $image = read8BitImageArrayFromBinaryPPMFile($in_file);

  $crop_image = cropFrom8BitImageArray($image,$left_x,$top_y,$crop_width,$crop_height);

  write8BitImageArrayToBinaryPPMFile($crop_file,$crop_image);

?>
