<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use App\Http\DataHandlers\PurchaseOrderHandler;
use App\Http\Requests\PurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    public function all()
    {
        return PurchaseOrderResource::collection(PurchaseOrder::all());
    }

    public function create(PurchaseOrderRequest $request, PurchaseOrderHandler $handler)
    {
        return $handler->create($request);
    }

    public function view(Request $request, $po_number)
    {
        return PurchaseOrderResource::collection(PurchaseOrder::where('po_number', $po_number)->get());
    }

    public function updateSummary(PurchaseOrderRequest $request, PurchaseOrderHandler $handler)
    {
        return $handler->updateSummary($request);
    }
}
