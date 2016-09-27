<?php
namespace app\Repository;


use App\Review;
use App\User;
use App\Venue;
use Carbon\Carbon;

class DbReviewRepository implements ReviewRepository {

	public function userFeedSimplePaginated(User $user)
	{
		$followedUsersId = $user->follows()->pluck('followed_id');
		$followedUsersId[] = $user->getKey();
		return Review::with('user', 'venue')->whereIn("user_id", $followedUsersId)->latest()->simplePaginate();
	}

	public function userReviewsSimplePaginated(User $user)
	{
		return $user->reviews()->with('venue')->orderBy('updated_at', 'des')->simplePaginate(10);
	}

	public function userVenueReviews(User $user, Venue $venue)
	{
		return $user->reviews()->where("venue_id", $venue->getKey());
	}

	public function userVenueLastReview(User $user, Venue $venue)
	{
		$reviews = static::userVenueReviews($user, $venue);
		if ($reviews->count() > 0)
			return $lastReviewDate = $reviews->orderBy("created_at", "desc")->first();

		return null;
	}

	public function userVenueHasPassedSevenDays(User $user, Venue $venue)
	{
		$lastReview = self::userVenueLastReview($user, $venue);
		if (is_null($lastReview)) return true;
		return $lastReview->created_at->diffInDays(Carbon::now()) >= 7;
	}

	public function venueReviews(Venue $venue)
	{
		return $venue->reviews()->with('user')->latest();
	}

	public function findReviewById(Venue $venue, $commentId)
	{
		return $venue->reviews()->where("id", $commentId)->firstOrFail();
	}

	public function venueReviewsSimplePaginated(Venue $venue, $pagination = 10)
	{
		return $this->venueReviews($venue)->simplePaginate($pagination);
	}

	public function venueReviewsPaginated(Venue $venue, $pagination = 10)
	{
		return $this->venueReviews($venue)->paginate($pagination);
	}

	public function create(User $user, Venue $venue, $decor, $quality, $cost, $comment)
	{
		$user->reviews()->create(['venue_id' => $venue->getKey(), 'decor' => $decor, 'quality' => $quality, 'cost' => $cost, 'comment' => $comment]);
	}

}