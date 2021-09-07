<?php

  function read8BitImageArrayFromBinaryPPMFile($filename) {
    $inf = fopen($filename,"r");

    $line = trim(fgets($inf));
    if($line!="P6") { print "Fatal Error: Not Binary PPM File\n";  exit(0); }

    $line = trim(fgets($inf));
    if(substr($line,0,1)=="#") { $line = trim(fgets($inf)); }

    sscanf($line,"%d %d",$width,$height);

    $line = trim(fgets($inf));
    if(intval($line)!=255) { print "Not 8 bit color";  exit(0); }

    $image = array();

    for($y=0;$y<$height;++$y) {
      $image[$y] = array();
      for($x=0;$x<$width;++$x) {
        $image[$y][$x] = array();
        $binary_str = fread($inf,3);
        $pixel = unpack("c*",$binary_str);
        $image[$y][$x][0] = $pixel['1'];
        $image[$y][$x][1] = $pixel['2'];
        $image[$y][$x][2] = $pixel['3'];
      }
    }

    fclose($inf);
    return $image;
  }

  function get8BitImageArrayWidth($image) {
    return count($image[0]);
  }

  function get8BitImageArrayHeight($image) {
    return count($image);
  }

  function write8BitImageArrayToBinaryPPMFile($filename,$image) {
    $outf = fopen($filename,'w+');

    $width = get8BitImageArrayWidth($image);
    $height = get8BitImageArrayHeight($image);

    $bin_str = "P6\n#  Created by Kaney PPM Utils\n".$width." ".$height."\n255\n";
    fwrite($outf,$bin_str);

    $bin_str = "";
    for($y=0;$y<$height;++$y) {
      for($x=0;$x<$width;++$x) {
        $add_str = pack('C3',$image[$y][$x][0],$image[$y][$x][1],$image[$y][$x][2]);
        $bin_str = $bin_str.$add_str;
//        $add_str = pack('C',$image[$y][$x][1]);
//        $bin_str = $bin_str.$add_str;
//        $add_str = pack('C',$image[$y][$x][2]);
//        $bin_str = $bin_str.$add_str;
//        $bin_str = $bin_str.pack('C',$image[$y][$x][1]);
//        $bin_str = $bin_str.pack('C',$image[$y][$x][2]);
      }
    }

    fwrite($outf,$bin_str);
    fclose($outf);
  }

  function createBlank8BitImageArray($width,$height) {
    $image = array();

    for($y=0;$y<$height;++$y) {
      $image[$y] = array();
      for($x=0;$x<$width;++$x) {
        $image[$y][$x] = array();
        for($c=0;$c<3;++$c) { $image[$y][$x][$c] = 255; }
      }
    }
    return $image;
  }

  function set8BitImageArrayColor(&$image,$red,$green,$blue) {
    $width = get8BitImageArrayWidth($image);
    $height = get8BitImageArrayHeight($image);

    for($y=0;$y<$height;++$y) {
      for($x=0;$x<$width;++$x) {      
        $image[$y][$x][0] = $red;
        $image[$y][$x][1] = $green;
        $image[$y][$x][2] = $blue;
      }
    }
  }

  function flip8BitImageArray(&$image) {
    $width = get8BitImageArrayWidth($image);
    $height = get8BitImageArrayHeight($image);

    for($y=0;$y<floor($height/2);++$y) {
      for($x=0;$x<$width;++$x) {      
        $tem = $image[$y][$x][0];
        $image[$y][$x][0] = $image[$height-1-$y][$x][0];
        $image[$height-1-$y][$x][0] = $tem;

        $tem = $image[$y][$x][1];
        $image[$y][$x][1] = $image[$height-1-$y][$x][1];
        $image[$height-1-$y][$x][1] = $tem;

        $tem = $image[$y][$x][2];
        $image[$y][$x][2] = $image[$height-1-$y][$x][2];
        $image[$height-1-$y][$x][2] = $tem;
      }
    }
  }

  function mirror8BitImageArray(&$image) {
    $width = get8BitImageArrayWidth($image);
    $height = get8BitImageArrayHeight($image);

    for($y=0;$y<$height;++$y) {
      for($x=0;$x<floor($width/2);++$x) {      
        $tem = $image[$y][$x][0];
        $image[$y][$x][0] = $image[$y][$width-1-$x][0];
        $image[$y][$width-1-$x][0] = $tem;

        $tem = $image[$y][$x][1];
        $image[$y][$x][1] = $image[$y][$width-1-$x][1];
        $image[$y][$width-1-$x][1] = $tem;

        $tem = $image[$y][$x][2];
        $image[$y][$x][2] = $image[$y][$width-1-$x][2];
        $image[$y][$width-1-$x][2] = $tem;
      }
    }
  }

  function rotate180_8BitImageArray(&$image) {
    flip8BitImageArray($image);
    mirror8BitImageArray($image);
  }

  function rotate90_8BitImageArray($image,$dir) {
    $old_width = get8BitImageArrayWidth($image);
    $old_height = get8BitImageArrayHeight($image);
    $new_height = $old_width;
    $new_width = $old_height;

    $rot_image = createBlank8BitImageArray($new_width,$new_height);

    if($dir=="cw") {
      for($y=0;$y<$new_height;++$y) {
        for($x=0;$x<$new_width;++$x) {      
          $rot_image[$y][$x][0] = $image[$new_width-1-$x][$y][0];
          $rot_image[$y][$x][1] = $image[$new_width-1-$x][$y][1];
          $rot_image[$y][$x][2] = $image[$new_width-1-$x][$y][2];
        }
      }
    }
    if($dir=="ccw") {
      for($y=0;$y<$new_height;++$y) {
        for($x=0;$x<$new_width;++$x) {      
          $rot_image[$y][$x][0] = $image[$x][$new_height-1-$y][0];
          $rot_image[$y][$x][1] = $image[$x][$new_height-1-$y][1];
          $rot_image[$y][$x][2] = $image[$x][$new_height-1-$y][2];
        }
      }
    }

    return $rot_image;
  }

  function insert8BitImageArray(&$host,$insert,$left_x,$top_y) {
    $host_width = get8BitImageArrayWidth($host);
    $host_height = get8BitImageArrayHeight($host);

    $insert_width = get8BitImageArrayWidth($insert);
    $insert_height = get8BitImageArrayHeight($insert);

    for($y=0;$y<$insert_height;++$y) {
      if(($top_y+$y)<0 || ($top_y+$y)>=$host_height) { continue; }
      for($x=0;$x<$insert_width;++$x) {      
        if(($left_x+$x)<0 || ($left_x+$x)>=$host_width) { continue; }

        for($c=0;$c<3;++$c) { $host[$top_y+$y][$left_x+$x][$c] = $insert[$y][$x][$c]; }
      }
    }
  }

  function cropFrom8BitImageArray($image,$left_x,$top_y,$crop_width,$crop_height) {
    $crop_image = createBlank8BitImageArray($crop_width,$crop_height);

    $width = get8BitImageArrayWidth($image);
    $height = get8BitImageArrayHeight($image);

    for($y=0;$y<$crop_height;++$y) {
      if(($top_y+$y)<0 || ($top_y+$y)>=$height) { continue; }
      for($x=0;$x<$crop_width;++$x) {      
        if(($left_x+$x)<0 || ($left_x+$x)>=$width) { continue; }

        for($c=0;$c<3;++$c) { $crop_image[$y][$x][$c] = $image[$top_y+$y][$left_x+$x][$c]; }
      }
    }
    return $crop_image;
  }


?>
