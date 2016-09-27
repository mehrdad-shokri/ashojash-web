<?php
	use app\Transformers\Transformer;

	class MenuTransformer extends Transformer {

		public function transform($menu)
		{
			return [
				'name'        => $menu['menu_item'],
				'ingredients' => $menu['ingredients'],
				'price'       => $menu['price']
			];
		}
	}
