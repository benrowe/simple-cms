<?php

/**
 * Additional functionality added to ZipArchive
 *
 *
 */
class Zip extends ZipArchive
{
	const CHMOD = 0755;

	public function addDirectory($path, $relPath = null)
	{
		foreach(glob($path . '/*') as $file) {
            if(is_dir($file)) {
                $this->addDirectory($file, $relPath);
            } else {
            	$newFile = substr($file, strlen($relPath)+1);
                $this->addFile($file, $newFile);
            }
        }
	}

	/**
	 * Extract the zip file, only extracting the files that match at least one of the supplied filters
	 *
	 * @param  string $directory where to extract the zip to
	 * @param  array  $filters either extensions, or regular expressions to match against each file name.
	 * @return boolean
	 */
	public function filteredExtractTo($directory, array $filters = null)
	{

		if(count($filters) === 0) {
			return $this->extractTo($directory);
		}

		$this->createDir($path);

		$copySource = 'zip://'.$this->filename.'#';
		for($i = 0; $i < $this->numFiles; $i++) {
			$entry = $this->getNameIndex($i);
			$filename = basename($entry);


			if($this->matchFileToFilter($filename, $filters)) {
				$base = dirname($entry);
				$newPath = $directory.DIRECTORY_SEPARATOR.$base.DIRECTORY_SEPARATOR;
				$this->createPath($newPath);

				// extract file
				copy($copySource.$entry, $newPath.$filename);
			}
		}
	}

	protected function createDir($path)
	{
		if(!is_dir($path)) {
			if(!mkdir($path, self::CHMOD, true)) {
				throw new Exception('unable to create path '.$path);
			}
		}
	}

	/**
	 * Match the file name to one of the filters
	 * @param  string $filename
	 * @param  array  $filters
	 * @return int array index of matched filter, or false for no match
	 */
	protected function matchFileToFilter($filename, array $filters)
	{
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if(in_array($ext, array_map('strtolower', $filters))) {
			// one of the filters is an extension, and it matches file extension
			return true;
		}

		foreach($filters as $i=>$filter) {
			// remove extension filters
			if(!ctype_alnum($filter[0]) && preg_match($filter, $filename)) {
				return true;
			}
		}
		return false;
	}
}