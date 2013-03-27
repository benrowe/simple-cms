<?php

echo CHtml::image($file->url);

echo sprintf('%spx x %spx', $file->width, $file->height);


if(in_array($file->extensionName, array('jpg'))) {
	var_dump(exif_read_data($file->fullPath));
}
