<?php

namespace Modules\Purchase\Services;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Database\Models\Order;
use Modules\Purchase\Database\Models\Product;
use Modules\Purchase\Sms\SmsInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PurchaseService
{
    protected $smsInterface;

    public function __construct(SmsInterface $smsInterface)
    {
        $this->smsInterface = $smsInterface;
    }
    public function purchaseProduct(User $user, Product $product): bool
    {
        if (!$this->hasEnoughBalance($user, $product)) {
            return false;
        }

        return DB::transaction(function () use ($user, $product) {
            $product = Product::where('id', $product->id)->lockForUpdate()->first();

            if ($product->quantity <= 0) {
                throw new HttpResponseException(
                    response()->json(
                        ['message' => 'Product is out of stock'],
                        ResponseAlias::HTTP_BAD_REQUEST
                    )
                );

            }

            $this->deductUserBalance($user, $product->price);

            $order = $this->createOrder($user, $product);

            $this->createTransaction($user, $order, $product->price);

            $this->decreaseProductQuantity($product);

            $this->smsInterface->sendSms($user->mobile, 'Your purchase was successful.');
            return true;
        });
    }

    protected function hasEnoughBalance(User $user, Product $product): bool
    {
        return $user->balance >= $product->price;
    }

    protected function deductUserBalance(User $user, float $amount): void
    {
        $user->balance -= $amount;
        $user->update();
    }

    protected function createOrder(User $user, Product $product): \Illuminate\Database\Eloquent\Model
    {
        return $user->orders()->create(['product_id' => $product->id]);
    }
    protected function decreaseProductQuantity(Product $product): void
    {
        $product->quantity--;
        $product->save();
    }

    protected function createTransaction(User $user, Order $order, float $amount): \Illuminate\Database\Eloquent\Model
    {
        return $user->transactions()->create([
            'order_id' => $order->id,
            'amount' => $amount,
            'status' => 'success',
        ]);
    }
}
