<?php

namespace App\Http\Controllers\Api;

use App\Models\Site;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SiteRequest;
use App\Http\Resources\SiteResource;

use App\Http\Requests\SearchRequest;
use App\Http\DataHandlers\SiteHandler;

class SiteController extends Controller
{
    public function all()
    {
        return SiteResource::collection(Site::with('company')->get());
    }

    public function companySites(Company $company)
    {
        return SiteResource::collection($company->sites);
    }

    public function search(SearchRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }
        
        return SiteResource::collection(Site::with(['company'])->where('name', 'like', '%'.$request->search_name.'%')->get());
    }

    public function create(SiteRequest $request, SiteHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(SiteRequest $request, SiteHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(SiteRequest $request, SiteHandler $handler)
    {
        return $handler->delete($request);
    }
}
