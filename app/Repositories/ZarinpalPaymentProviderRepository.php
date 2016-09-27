<?php namespace app\Repository;


use App\Payment;
use App\User;
use App\Venue;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Artisaninweb\SoapWrapper\Service;

class ZarinpalPaymentProviderRepository implements PaymentProviderRepository {

	protected $merchantId = '56531e5e-ac94-40eb-9755-3e8c5bef37fa';

	public function initializePayment(Venue $venue, User $user, $amount)
	{
		$this->initializeService();
		$description = "خدمات معرفی، نقد و بررسی رستوران هاو کافه‌ها";
		$email = $user->email;
		$callbackUrl = action("PaymentsController@handleCallback");

		$data = [
			'MerchantID' => $this->merchantId,
			'Amount' => $amount,
			'Description' => $description,
			'Email' => $email,
			'CallbackURL' => $callbackUrl
		];
		$status = null;
		$authority = null;
		SoapWrapper::service('currency', function (Service $service) use ($data, &$status, &$authority)
		{
			$service->call('PaymentRequest', [$data]);
			$status = $service->call('PaymentRequest', [$data])->Status;
			$authority = $service->call('PaymentRequest', [$data])->Authority;
		});
		return array('status' => $status, 'authority' => $authority);
	}


	public function handleCallbackPayment(Payment $payment)
	{
		$this->initializeService();
		$data = [
			'MerchantID' => $this->merchantId,
			'Amount' => $payment->amount,
			'Authority' => $payment->authority,
		];
		$status = null;
		$refId = null;
		SoapWrapper::service('currency', function (Service $service) use ($data, &$status, &$refId)
		{
			$service->call('PaymentVerification', [$data]);
			dd("response" . $service->call('PaymentVerification', [$data]));
			$status = $service->call('PaymentVerification', [$data])->Status;
			$refId = $service->call('PaymentVerification', [$data])->RefID;
		});
		return array('status' => $status, 'refId' => $refId);
	}

	public function initializeService()
	{
		SoapWrapper::add(function ($service)
		{
			$service->name('currency')
				->wsdl('https://www.zarinpal.com/pg/services/WebGate/wsdl')
				->trace(true)// Optional: (parameter: true/false)
				->cache(WSDL_CACHE_NONE);// Optional: Set the WSDL cache
//					->options(['login' => 'username', 'password' => 'password']);   // Optional: Set some extra options
		});
	}


}