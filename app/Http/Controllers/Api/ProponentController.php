<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proponent;
use App\Models\ProponentType;
use App\Models\Rank;
use App\Http\Requests\ProponentRequest;
use App\Http\Requests\FileRequest;
use App\Http\Resources\ProponentResource;
use App\Http\Resources\ProponentTypeResource;
use App\Http\Resources\RankResource;

use App\Http\DataHandlers\ProponentHandler;

class ProponentController extends Controller
{
    public function types(){
        return ProponentTypeResource::collection(ProponentType::all());
    }

    public function ranks(){
        return RankResource::collection(Rank::all());
    }

    public function index(){
        return ProponentResource::collection(Proponent::with([
            'site', 'type', 'rank', 'tagged_proponent'
        ])->get());
    }

    public function employees(){
        return ProponentResource::collection(Proponent::with(['site', 'rank'])->where('proponent_type_id', 1)->get());
    }

    public function campaigns(){
        return ProponentResource::collection(Proponent::with(['site'])->where('proponent_type_id', 2)->get());
    }

    public function sites(){
        return ProponentResource::collection(Proponent::where('proponent_type_id', 3)->get());
    }

    public function hardwares(){
        return ProponentResource::collection(Proponent::with(['tagged_proponent'])->where('proponent_type_id', 4)->get());
    }

    public function create(ProponentRequest $request, ProponentHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(ProponentRequest $request, ProponentHandler $handler)
    {
        return $handler->update($request);
    }

    public function bulkUploads(FileRequest $request, ProponentHandler $handler)
    {
        return $handler->bulk($request);
    }

    public function delete(ProponentRequest $request, ProponentHandler $handler)
    {
        return $handler->delete($request);
    }
}
