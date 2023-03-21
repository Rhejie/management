<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Segment;
use App\Http\Requests\SegmentRequest;
use App\Http\Resources\SegmentResource;
use App\Http\DataHandlers\SegmentHandler;

class SegmentController extends Controller
{

    public function index()
    {
        return SegmentResource::collection(Segment::all());
    }

    public function create(SegmentRequest $request, SegmentHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(SegmentRequest $request, SegmentHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(SegmentRequest $request, SegmentHandler $handler)
    {
        return $handler->delete($request);
    }
}
