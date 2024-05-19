<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCountryAPIRequest;
use App\Http\Requests\API\V1\UpdateCountryAPIRequest;
use App\Models\Country;
use App\Repositories\Backend\CountryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CountryController
 * @package App\Http\Controllers\API\V1
 */

class CountryAPIController extends AppBaseController
{
    /** @var  CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepository = $countryRepo;
    }

    /**
     * Display a listing of the Country.
     * GET|HEAD /countries
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $structures = $request->get('structures');
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $countries = Country::orderByDesc('created_at')->paginate(5);
        }else{
            $countries = $this->countryRepository->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($countries, 'Countries retrieved successfully');
    }

    /**
     * Store a newly created Country in storage.
     * POST /countries
     *
     * @param CreateCountryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCountryAPIRequest $request)
    {
        $input = $request->all();

        $country = $this->countryRepository->create($input);

        return $this->sendResponse($country->toArray(), 'Country saved successfully');
    }

    /**
     * Display the specified Country.
     * GET|HEAD /countries/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Country $country */
        $country = $this->countryRepository->find($id);

        if (empty($country)) {
            return $this->sendError('Country not found');
        }

        return $this->sendResponse($country->toArray(), 'Country retrieved successfully');
    }

    /**
     * Update the specified Country in storage.
     * PUT/PATCH /countries/{id}
     *
     * @param int $id
     * @param UpdateCountryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCountryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Country $country */
        $country = $this->countryRepository->find($id);

        if (empty($country)) {
            return $this->sendError('Country not found');
        }

        $country = $this->countryRepository->update($input, $id);

        return $this->sendResponse($country->toArray(), 'Country updated successfully');
    }

    /**
     * Remove the specified Country from storage.
     * DELETE /countries/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Country $country */
        $country = $this->countryRepository->find($id);

        if (empty($country)) {
            return $this->sendError('Country not found');
        }

        $country->delete();

        return $this->sendResponse($id, 'Country deleted successfully');
    }
}
