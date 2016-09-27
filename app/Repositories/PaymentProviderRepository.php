<?php

namespace app\Repository;

use App\Payment;
use App\User;
use App\Venue;

interface PaymentProviderRepository {

	public function initializePayment(Venue $venue, User $user, $amount);

	public function handleCallbackPayment(Payment $payment);
}