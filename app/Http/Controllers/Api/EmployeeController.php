<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\FileRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\DataHandlers\EmployeeHandler;

use App\Http\Requests\SearchRequest;

class EmployeeController extends Controller
{
    public function all()
    {
        return EmployeeResource::collection(Employee::with(['campaign', 'company'])->get());
    }

    public function employeeList()
    {
        return EmployeeResource::collection(Employee::doesntHave('account')->get());
    }

    public function search(SearchRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }
        
        return EmployeeResource::collection(Employee::with(['company', 'campaign', 'cost_center'])->where('name', 'like', '%'.$request->search_name.'%')->get());
    }

    public function create(EmployeeRequest $request, EmployeeHandler $handler)
    {
        return $handler->create($request);
    }

    public function bulkUploads(FileRequest $request, EmployeeHandler $handler)
    {
        return $handler->bulk($request);
    }

    public function update(EmployeeRequest $request, EmployeeHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(EmployeeRequest $request, EmployeeHandler $handler)
    {
        return $handler->delete($request);
    }
}
