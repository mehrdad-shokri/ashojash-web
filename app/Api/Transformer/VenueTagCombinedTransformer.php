<?php

namespace App\Api\Transformer;


use App\Api\Transformer\Backend\TagTransformer;
use App\VenueTagCombined;

class VenueTagCombinedTransformer extends BaseTransformer {

	protected $defaultIncludes = ['venues','tags'];

	public function transform(VenueTagCombined $venueTagCombined)
	{
		return[

		];
	}

	public function includeVenues(VenueTagCombined $venueTagCombined)
	{
		return $this->collection($venueTagCombined->venues, new VenueTransformer());
	}

	public function includeTags(VenueTagCombined $venueTagCombined)
	{
		return $this->collection($venueTagCombined->tags, new TagTransformer());
	}
}