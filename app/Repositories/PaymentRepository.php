<?php

namespace app\Repository;


use App\Payment;
use App\User;
use App\Venue;

interface PaymentRepository {

	public function findByAuthorityOrFail($authority);

	public function create(Venue $venue, User $user, $authority, $amount);

	public function verifyPayment(Payment $payment, User $user, $refId);
}