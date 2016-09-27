<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class GoogleOauth extends Model {

		protected $table = 'google_oauth';
		protected $fillable = ['token', 'name', 'email', 'circled_by_count', 'lang', 'avatar', 'min_range', 'max_range', 'etag', 'url', 'social_id', 'is_plus_user', 'verified'];

		public function user()
		{
			return $this->belongsTo("App\User");
		}

	}
