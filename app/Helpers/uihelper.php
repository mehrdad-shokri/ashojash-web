<?php


	use App\Photo;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Support\Facades\Storage;
	use Intervention\Image\Facades\Image;

	function flash($title = null, $message = null)
	{
		$flash = app('App\Http\Flash');
		if (func_num_args() == 0)
		{
			return $flash;
		}

		return $flash->info($title, $message);
	}

	function apiFlash($title = null, $message = null)
	{
		$flash = app('App\Http\ApiFlash');
		if (func_num_args() == 0)
		{
			return $flash;
		}

		return $flash->info($title, $message);
	}


	function bflash($title = null, $message = null)
	{

		$bflash = app('App\Http\BFlash');
		if (func_num_args() == 0)
		{
			return $bflash;
		}

		return $bflash->info($title, $message);
	}


	function cflash($title = null, $message = null)
	{
		$cflash = app("App\Http\CFlash");
		if (func_num_args() == 0)
			return $cflash;

		return $cflash->info($title, $message);
	}

//flash('title,'text')
//flash->success('title','success')

	function gravatarEmail($userEmail, $size)
	{
		$email = "//www.gravatar.com/avatar/{{md5($userEmail)}}?s=$size";

		return $email;
	}


	class UI {

		public static function specialActiveMenu($uri = "")
		{
			$active = '';

			if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri) || Request::is(Request::segment(1) . '/*' . $uri . '/*'))
			{
				$active = 'active';
			}

			return $active;
		}

		public static function activeMenu($uri = '')
		{
			$active = '';

			if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri) || Request::is(Request::segment(1) . '/*' . $uri))
			{
				$active = 'active';
			}

			return $active;

		}

		public static function ratingClass($ratingVal = 0)
		{

			$ratings = [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5];
			$precise = -1;
			if ($ratingVal < 1 || $ratingVal > 5)
				return "level-0";
			foreach ($ratings as $rating)
				if (($ratingVal - $rating <= 0.25))
				{
					$precise = $rating;
					break;
				}
			$precise = (($precise - 1) * 2) + 1;

			return "level-" . $precise;

		}

		public static function getReviewCountStateFa($venue)
		{
			if ($venue->score < 1)
				return "تعداد آرا هنوز کافی نیست.";

			return "بر اساس " . $venue->reviews->count() . " رای";
		}

		public static function getPhotoWidth($photoId)
		{
			try
			{
				$entry = Photo::findOrFail($photoId);
				if ($entry == null)
					abort(404);
				$file = Storage::disk('local')->get($entry->path);

				return Image::make($file)->width();
			} catch
			(ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public static function getPhotoHeight($photoId)
		{
			try
			{
				$entry = Photo::findOrFail($photoId);
				if ($entry == null)
					abort(404);
				$file = Storage::disk('local')->get($entry->path);

				return Image::make($file)->height();
			} catch
			(ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public static function getDayString($val)
		{
			if ($val < 0 || $val > 7)
				throw new InvalidArgumentException;
			if ($val == 0)
				return "شنبه ";
			else if ($val == 1)
				return "یکشنبه ";
			else if ($val == 2)
				return "دوشنبه ";
			else if ($val == 3)
				return "سه شنبه: ";
			else if ($val == 4)
				return "چهارشنبه: ";
			else if ($val == 5)
				return "پنج شنبه: ";
			else if ($val == 6)
				return "جمعه: ";
		}

		public static function setTimeDefault()
		{
			Carbon::setLocale('en');
		}

	}