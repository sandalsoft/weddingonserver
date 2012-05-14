<?php

header('Content-type: image/jpeg');

$image = new Imagick('photos/images/album/392ef78ebab67fc11d6020d0c11a6d63.PNG');
//echo $image;
// If 0 is provided as a width or height parameter,
// aspect ratio is maintained
$image->cropThumbnailImage(100, 100);

echo $image;

?>
