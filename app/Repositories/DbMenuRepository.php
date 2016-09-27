<?php namespace app\Repository;


use App\Venue;

class DbMenuRepository implements MenuRepository {

	public function findById(Venue $venue, $menuId)
	{
		return $venue->menus()->find($menuId)->firstOrFail();
	}

	public function menus(Venue $venue)
	{
		return $venue->menus;
	}

	public function menuPaginated(Venue $venue, $limit)
	{
		return $venue->menus()->paginate($limit);
	}

	public function create(Venue $venue, $menuItem, $price, $ingredients)
	{
		return $venue->menus()->create(['menu_item' => $menuItem, 'price' => $price, 'ingredients' => $ingredients]);
	}
}