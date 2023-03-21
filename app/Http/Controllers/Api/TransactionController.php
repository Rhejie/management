<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\DataHandlers\BrandHandler;

class TransactionController extends Controller
{

    public function index()
    {
        //transactions list
        // return BrandResource::collection(Brand::all());
    }

    public function assign(BrandRequest $request, BrandHandler $handler)
    {
        return $handler->create($request);
    }
}
