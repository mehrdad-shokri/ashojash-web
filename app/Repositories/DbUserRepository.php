<?php
namespace app\Repository;


use App\User;

class DbUserRepository implements UserRepository
{


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

    /**
     * @param $name
     * @param $username
     * @param $email
     * @param $password
     * @param string $phone
     * @param string $bio
     * @return static
     */
    public function create($name, $username, $email, $password, $phone = '', $bio = '')
    {
        return User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'phone' => '',
            'bio' => '',
            'score' => 0,
            'password' => bcrypt($password),
            'email_token' => str_random(30)
        ]);
    }
    public function confirmEmailToken ($emailToken){
        $user = User::where('email_token', $emailToken)->firstOrFail();
        $user->email_token = null;
        $user->save();
    }
}