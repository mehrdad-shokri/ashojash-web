<?php

namespace App\Api\Transformer;


use App\User;

class UserRegisteredTransformer extends BaseTransformer {

	public function transform(User $user)
	{
		return [
			'emailSent' => true,
			'isGmailUser' => $this->isGmailUser($user->email)
		];
	}

	public function isGmailUser($email)
	{
		list($user, $email) = explode("@", strtolower($email));
		return $email == "gmail.com" || $email == "googlemail.com" || $email == "google.com";
	}
}