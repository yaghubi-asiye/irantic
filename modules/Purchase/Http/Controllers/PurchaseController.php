<?php

namespace Modules\Purchase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Purchase\Database\Models\Product;
use Modules\Purchase\Services\PurchaseService;

class PurchaseController extends Controller
{
    public $purchaseService;
    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }
    public function index()
    {
        $productId = request()->input('product_id');
        $userId = request()->input('user_id');
        $user = User::lockForUpdate()->findOrFail($userId);

        $product = Product::findOrFail($productId);

        $success = $this->purchaseService->purchaseProduct($user, $product);

        if ($success)
            return response()->json(['message' => 'Purchase successful'], 200);

        return response()->json(['message' => 'Insufficient balance'], 403);

    }
}
