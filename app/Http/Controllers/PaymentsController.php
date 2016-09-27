<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Payment;
use app\Repository\PaymentProviderRepository;
use app\Repository\PaymentRepository;
use app\Repository\VenueRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;


class PaymentsController extends Controller {

	private $paymentProviderRepository;
	private $venueRepository;
	private $paymentRepository;


	public function __construct(PaymentProviderRepository $paymentProviderRepository, VenueRepository $venueRepository, PaymentRepository $paymentRepository)
	{
		$this->paymentProviderRepository = $paymentProviderRepository;
		$this->venueRepository = $venueRepository;
		$this->paymentRepository = $paymentRepository;
	}

	public function initialize($venueSlug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$user = Auth::user();
		$amount = Payment::getSubscriptionAmount();
		try
		{
			$response = $this->paymentProviderRepository->initializePayment($venue, $user, $amount);
			$status = $response['status'];
			if ($status == 100)
			{
				$authority = $response['authority'];
				$this->paymentRepository->create($venue, $user, $authority, $amount);
				return redirect()->to("https://www.zarinpal.com/pg/StartPay/" . $authority);
			}
			throw new RuntimeException;
		} catch (Exception $e)
		{
			$message = trans('modals.gateway_connection_error');
			flash()->overlay(trans('modals.error'), $message, 'error');
			return view("payments.failed", compact('message'));
		}
	}

	public function handleCallback(Request $request)
	{
		$authority = $request->get('Authority');
		$statusQuery = $request->get('Status');
		try
		{
			if ($statusQuery == "OK")
			{
				if (is_null($authority))
					throw new RuntimeException;

				$user = Auth::user();
				$payment = $this->paymentRepository->findByAuthorityOrFail($authority);
				$response = $this->paymentProviderRepository->handleCallbackPayment($payment);
				$status = $response['status'];
				$refId = $response['refId'];
				if ($status == 100 || $status == 101)
				{
					$this->paymentRepository->verifyPayment($payment, $user, $refId);
					flash()->overlay(trans('modals.finish'), trans('modals.payment_verified'), 'success');
					return view("payments.verified", compact('refId'));
				}
			}
			throw new RuntimeException;
		} catch (Exception $e)
		{
			$message = trans('modals.payment_failed');
			flash()->overlay(trans('modals.error'), $message, 'error');
			return view("payments.failed", compact('message'));
		}
	}

}

