<?php namespace App\Api\Transformer;


use app\Repository\DbMenuRepository;
use app\Repository\DbPhotoRepository;
use app\Repository\DbReviewRepository;
use app\Repository\DbVenueRepository;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract {

	protected $photoRepository;
	protected $menuRepository;
	protected $reviewRepository;
	protected $venueRepository;
	/**
	 * BaseTransformer constructor.
	 */
	public function __construct()
	{
		$this->photoRepository = new DbPhotoRepository();
		$this->menuRepository = new DbMenuRepository();
		$this->reviewRepository = new DbReviewRepository();
		$this->venueRepository=new DbVenueRepository();
	}

}