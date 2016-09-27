<?php namespace app\Repository;


use App\Venue;

interface MenuRepository {

	public function findById(Venue $venue, $menuId);

	public function menus(Venue $venue);

	public function create(Venue $venue, $menuItem, $price, $ingredients);

	public function menuPaginated(Venue $venue, $limit);
}