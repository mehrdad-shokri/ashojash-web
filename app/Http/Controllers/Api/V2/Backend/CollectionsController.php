<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/23/2016
 * Time: 5:53 PM
 */

namespace App\Http\Controllers\Api\V2\Backend;


use App\Api\Transformer\Backend\CollectionTransformer;
use App\Api\Transformer\CityTransformer;
use App\Api\Transformer\VenueTransformer;
use App\Collection;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\CityRepository;
use app\Repository\CollectionRepository;
use app\Repository\VenueRepository;
use App\Venue;
use Carbon\Carbon;
use Dingo\Api\Routing\Adapter\Laravel;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CollectionsController extends BaseController
{

    /**
     * @var CityRepository
     */
    private $cityRepository;
    /**
     * @var VenueRepository
     */
    private $venueRepository;
    /**
     * @var CollectionRepository
     */
    private $collectionRepository;


    /**
     * CollectionsController constructor.
     * @param CityRepository $cityRepository
     * @param VenueRepository $venueRepository
     * @param CollectionRepository $collectionRepository
     */
    public function __construct(CityRepository $cityRepository, VenueRepository $venueRepository, CollectionRepository $collectionRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->venueRepository = $venueRepository;
        $this->collectionRepository = $collectionRepository;
    }

    public function all(Request $request)
    {
        $collections = $this->collectionRepository->all()->sortBy('updated_at');
        return $this->response->collection($collections, new CollectionTransformer());
    }

    public function allCities()
    {
        $cities = $this->cityRepository->available();
        return $this->response->collection($cities, new CityTransformer());
    }

    public function searchVenues(Request $request)
    {
        $rules = [
            'slug' => 'required|exists:cities,slug',
            'query' => 'required',
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails()) {
            $this->response->errorBadRequest($this->errorResponse($validator));
        }
        $city = $this->cityRepository->findBySlugOrFail($request->get('slug'));
        $venues = $this->venueRepository->search($request->get('query'), $city);
        return $this->response->collection($venues, new VenueTransformer());
    }

    public function store(Request $request)
    {
        $dateValidation = 'required|integer';
        $rules = [
            'collectionName' => 'required|string',
            'collectionDescription' => 'string',
            'collectionType' => 'required|integer|min:1',
            'citySlug' => 'required|exists:cities,slug',
            'startDate' => $dateValidation,
            'startTime' => $dateValidation,
            'endDate' => $dateValidation,
            'endTime' => $dateValidation,
            'isActive' => 'required|boolean',
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails()) {
            $this->response->errorBadRequest($this->errorResponse($validator));
        }
        $start = Carbon::createFromTimestamp($request->get('startDate') / 1000, 'Asia/Tehran');
        $startTime = Carbon::createFromTimestamp($request->get('startTime') / 1000, 'Asia/Tehran');
        $end = Carbon::createFromTimestamp($request->get('endDate') / 1000, 'Asia/Tehran');
        $endTime = Carbon::createFromTimestamp($request->get('endTime') / 1000, 'Asia/Tehran');
        $this->mergeDateTimes($start, $startTime);
        $this->mergeDateTimes($end, $endTime);
        $name = $request->get('collectionName');
        $description = $request->get('collectionDescription');
        $type = $request->get('collectionType');
        $city = $this->cityRepository->findBySlugOrFail($request->get('citySlug'));
        $active = $request->get('isActive');
        $collection = $this->collectionRepository->create($name, $description, $type, $city->getKey(), $active, $start, $end);
        $this->collectionRepository->addVenues($request->get('venueSelect'), $collection, $start, $end);
        return $this->response->item($collection, new CollectionTransformer())->statusCode(201);
    }

    public function addPhoto(Request $request)
    {
        $rules = [
            'slug' => 'required',
            'file' => 'required|image|max:5000',
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails()) {
            $this->response->errorBadRequest($this->errorResponse($validator));
        }
        $collection = $this->collectionRepository->findBySlugOrFail($request->get('slug'));
        FileUploader::uploadFile($collection, $request->file('file'), Auth::user(), true);
        $this->response->created();
    }

    /**
     * @param Carbon $date
     * @param Carbon $time
     * @param bool $convertToUtc
     */
    private function mergeDateTimes(Carbon $date, Carbon $time, $convertToUtc = true)
    {
        $date->hour($time->hour)->minute($time->minute)->second($time->second);
        if ($convertToUtc)
            $date->setTimezone('UTC');
    }
}