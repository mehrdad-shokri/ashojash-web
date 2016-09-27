<?php
	namespace app\Repository;


	use App\User;

	class DbUserRepository implements UserRepository {


		public function findByUsername($username)
		{
			$user = User::where('username', $username)->firstOrFail();

			return $user;
		}

		public function findByPrimaryEmail($email)
		{
			return User::where('email', $email)->firstOrFail();
		}

		public function findById($id)
		{
			return User::findOrFail($id);
		}


		public function all($with = null)
		{
			if (!is_null($with))
				return User::with($with);

			return User::all();

		}

		public function select(array $items)
		{
			return User::select($items);
		}

		public function like($column, $item, $model)
		{
			return $model->where($column, 'like', "%$item%");
		}

		public function create($username, $name, $email, $password)
		{
			$user = User::create([
				'username' => $username,
				'name'     => $name,
				'email'    => $email,
				'password' => bcrypt($password),
			]);

			return $user;
		}


	}