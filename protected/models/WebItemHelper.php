<?php

class WebItemHelper
{
	/**
	 * [updateMediaReferences description]
	 * @param  [type] $collection [description]
	 * @param  [type] $oldFile    [description]
	 * @param  [type] $newFile    [description]
	 * @return [type]             [description]
	 */
	public static function updateMediaReferences($collection, $oldFile, $newFile)
	{
		foreach($collection as $item) {
			$data = $item->data;
			if(isset($data['media'])) {
				foreach($data['media'] as $key=>$media) {
					if($media['file'] === $oldFile) {
						if($newFile === false) {
							// delete media reference!
							unset($data['media'][$key]);
						} else {
							// update reference!
							$data['media'][$key]['file'] = $newFile;
						}
					}
				}
			}
			$item->data = $data;
			$item->save();
		}
	}
}