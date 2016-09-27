<?php namespace app\Repository;

use App\User;
use App\Venue;

interface ReviewRepository {

	public function userFeedSimplePaginated(User $user);

	public function userReviewsSimplePaginated(User $user);

	public function userVenueReviews(User $user, Venue $venue);

	public function findReviewById(Venue $venue, $commentId);

	public function userVenueLastReview(User $user, Venue $venue);

	public function userVenueHasPassedSevenDays(User $user, Venue $venue);

	public function venueReviews(Venue $venue);

	
	public function venueReviewsSimplePaginated(Venue $venue, $pagination = 10);

	public function create(User $user, Venue $venue, $decor, $quality, $cost, $comment);
}