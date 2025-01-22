<?php

namespace App\Http\Controllers\ZohoAPI;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZohoAPI\DealRequest;
use App\Services\ZohoAPI\Service;
use Illuminate\Http\JsonResponse;

class DealController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function createDeal(DealRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $response = $this->service->createDeal($data);

            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
