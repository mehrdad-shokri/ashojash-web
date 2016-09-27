<?php namespace app\Transformers;


class ReviewTransformer extends Transformer {

	public function transform($item)
	{

		// TODO: Implement transform() method.
		return [
			'comment'        => $item['comment'],
			'cost'           => $item['cost'],
			'quality'        => $item['quality'],
			'decor'          => $item['decor'],
			'date'           => $item['updated_at'],
			'user_image_url' => $item['user_image_url']
		];
	}
}