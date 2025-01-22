<?php

namespace App\Http\Controllers\ZohoAPI;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZohoAPI\AccountRequest;
use App\Services\ZohoAPI\Service;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function createAccount(AccountRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $response = $this->service->createAccount($data);

            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function createDeal(): JsonResponse
    {
        return response()->json("df");
    }
}
