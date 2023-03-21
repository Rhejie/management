<?php

namespace App\Http\DataHandlers;

use App\Models\Segment;

use App\Http\Requests\SegmentRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class SegmentHandler
{
    use ResultTrait;

    public function __construct()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function create(SegmentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $Segment = Segment::firstOrCreate([
                'name' => $request->name,
            ]);
            return $this->result(false, ['id' => $Segment->id]);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(SegmentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $Segment = Segment::findOrFail($request->id);
            $Segment->update([
                'name' => $request->name,
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Segment not found.');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(SegmentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $AssetClass = Segment::findOrFail($request->id);
            $AssetClass->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Segment not found.');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    private function errors(SegmentRequest $request)
    {
        //custom errrors scenarios
        $errors = [];

        return $errors;
    }
}
