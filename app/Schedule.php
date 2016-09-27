<?php

	namespace App;

	use Carbon\Carbon;
	use DateTime;
	use DateTimeZone;
	use Illuminate\Database\Eloquent\Model;

	class Schedule extends Model {

		protected $fillable = ['opening_at', 'closing_at', 'day', 'venue_id'];

		public $timestamps = false;

		public function venue()
		{
			return $this->belongsTo('App\Venue');
		}

		public function isValid()
		{
			if ($this->day > 7 || $this->day < 1)
				return false;

			return true;
		}

		public function getOpeningAtAttribute($value)
		{
			$user_tz = 'Asia/Tehran';
			$schedule_date = new DateTime($value, new DateTimeZone("UTC"));
			$schedule_date->setTimezone(new DateTimeZone("$user_tz"));
			$value = $schedule_date->format('H:i');

			return $value;

			return Carbon::parse($value);
		}

		public function getClosingAtAttribute($value)
		{
			$user_tz = 'Asia/Tehran';
			$schedule_date = new DateTime($value, new DateTimeZone("UTC"));
			$schedule_date->setTimezone(new DateTimeZone("$user_tz"));
			$value = $schedule_date->format('H:i');

			return $value;

			return Carbon::parse($value);
		}

		public function setOpeningAtAttribute($value)
		{
			$user_tz = 'Asia/Tehran';
			$schedule_date = new DateTime($value, new DateTimeZone($user_tz));
			$schedule_date->setTimeZone(new DateTimeZone('UTC'));
			$this->attributes['opening_at'] = $schedule_date;
		}

		public function setClosingAtAttribute($value)
		{
			$user_tz = 'Asia/Tehran';
			$schedule_date = new DateTime($value, new DateTimeZone($user_tz));
			$schedule_date->setTimeZone(new DateTimeZone('UTC'));
			$this->attributes['closing_at'] = $schedule_date;
		}

		public function scopeDay($query, $day)
		{
			return $query->where('day', $day);
		}

		public function scopeToday($query)
		{
			return $query->where("day", self::getTodayInt());
		}

		private static function getTodayInt()
		{
			return ((date('w') == 6 ? 0 : date('w') + 1));
		}
	}
