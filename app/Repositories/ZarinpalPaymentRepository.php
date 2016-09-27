<?php namespace app\Repository;


use App\Payment;
use App\User;
use App\Venue;
use Carbon\Carbon;

class ZarinpalPaymentRepository implements PaymentRepository {

	public function findByAuthorityOrFail($authority)
	{
		return Payment::where("authority", $authority)->firstOrFail();
	}

	public function create(Venue $venue, User $user, $authority, $amount)
	{
		$venue->payments()->create(['authority' => $authority, 'amount' => $amount, 'user_id' => $user->getKey()]);
	}

	public function verifyPayment(Payment $payment, User $user, $refId)
	{
		$venue = $payment->venue;
		$venue->starts_at = Carbon::now();
		$venue->valid_until = Carbon::now()->addDays(31);
		$venue->owner_id = $user->getKey();
		$payment->ref_id = $refId;
		$venue->save();
		$payment->save();
	}

}