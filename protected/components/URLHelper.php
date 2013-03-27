<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of URLHelper
 *
 * @author ben
 */
class URLHelper
{

	/**
	 * removes inappropriate characters from a string to ensure that string is safe 
	 * for use in urls & file paths
	 * 
	 * @param string $string the string to clean
	 * @param string $whiteSpaceChar the character to represent whitespace and replacement for other special characters. Defaults to -
	 * @return string the cleaned string
	 */
	public static function slugify($string, $whiteSpaceChar = '-')
	{
		$slug = preg_replace('/[\s!:;_\?=\\\+\*\\@\/%&#]+/', $whiteSpaceChar, $string);
		// this will replace all non alphanumeric char with '-'
		$slug = mb_strtolower($slug);
		// convert string to lowercase
		$slug = trim($slug, $whiteSpaceChar);
		return $slug;
	}

}