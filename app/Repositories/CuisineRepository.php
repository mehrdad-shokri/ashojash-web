<?php

	namespace app\Repository;


	use App\City;

	interface CuisineRepository {

		public function findBySlug($slug);

		public function findById($id);

		public function create($name);

		public function destroy($id);

		public function venuesByCuisineSlug(City $city, $slug);

		public function simplePaginate($count);
	}