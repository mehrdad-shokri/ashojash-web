<?php namespace app\Repository;


interface UserRepository
{

    public function findByUsername($username);

    public function findByPrimaryEmail($email);

    public function findById($id);

    public function all($with);

    public function select(array $items);

    public function like($column, $item, $modelOrBuilder);

    public function create($name, $username, $email, $password, $phone = '', $bio = '');

    public function confirmEmailToken($emailToken);
}