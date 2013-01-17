<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserCollection
 *
 * @author ben
 */
class UserCollection extends WebCollection implements ISearchable
{

	public function search($query)
	{
		if (is_string($query)) {
			return $this->searchProperties(array(
				'id',
				'email',
				'firstname',
				'lastname',
				'display',
				'bio'
			), $query);
		} else {
			
		}
	}

}