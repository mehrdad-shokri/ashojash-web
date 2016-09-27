<?php namespace App\Api\Transformer;


use App\Menu;
use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract {

	public function transform(Menu $menu)
	{
		return [
			'name' => $menu->menu_item,
			'ingredients' => $menu->ingredients,
			'price' => $menu->price
		];
	}
}