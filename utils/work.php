#!/usr/bin/php -q
<?php

//--------------------------------------------------------------------------------------
//   If run with no command line args, print out usage statement and bail
//--------------------------------------------------------------------------------------

  $argc = count($argv);

  if($argc==1)
  {
    print "\n\nUsage:\n";
    print "  read_ppm.php infile insert outfile\n\n";
    print "Examples:\n";
    print "  ./read_ppm.php grey-gradient.ppm mirror.ppm final.ppm\n\n";
    print "  \n";
    print "  \n\n";

    exit(0);
  }

  include 'library_ppm.php'; 

//--------------------------------------------------------------------------------------

  $infile  = $argv[1];
//  $insert  = $argv[2];
  $outfile = $argv[2];


  $image = read8BitImageArrayFromBinaryPPMFile($infile);
  rotate180_8BitImageArray($image);
  write8BitImageArrayToBinaryPPMFile($outfile,$image);



//  $image = read8BitImageArrayFromBinaryPPMFile($infile);
//  $add = read8BitImageArrayFromBinaryPPMFile($insert);

//  flip8BitImageArray($image);
//  mirror8BitImageArray($image);
//  insert8BitImageArray($image,$add,40,60);

//  $crop = cropFrom8BitImageArray($image,100,0,200,100);

//  write8BitImageArrayToBinaryPPMFile($outfile,$image);
//  write8BitImageArrayToBinaryPPMFile($outfile,$crop);

?>
