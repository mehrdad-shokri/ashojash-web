<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

	protected $fillable = ['authority', 'amount', 'user_id'];

	public static function getSubscriptionAmount()
	{
		return 168000;
	}

	public function venue()
	{
		return $this->belongsTo("App\Venue");
	}
}
