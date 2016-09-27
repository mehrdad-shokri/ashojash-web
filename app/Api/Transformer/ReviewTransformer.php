<?php namespace App\Api\Transformer;


use App\Review;

class ReviewTransformer extends BaseTransformer {

	protected $defaultIncludes = ['user'];

	public function transform(Review $review)
	{
		return [
			'comment' => $review->comment,
			'quality' => $review->cost,
			'decor' => $review->decor,
			'cost' => $review->cost,
			'createdAt' => $review->created_at
		];
	}

	public function includeUser(Review $review)
	{
		return $this->item($review->user, new UserTransformer());
	}
}