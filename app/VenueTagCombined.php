<?php

namespace App;


class VenueTagCombined {

	public $venues;
	public $tags;

	/**
	 * VenueTagCombined constructor.
	 * @param $venues
	 * @param $tags
	 */
	public function __construct($venues, $tags)
	{
		$this->venues = $venues;
		$this->tags = $tags;
	}


	/**
	 * @param $venues
	 */
	public function setVenues($venues)
	{
		$this->venues = $venues;
	}

	/**
	 * @param $tags
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;
	}
}