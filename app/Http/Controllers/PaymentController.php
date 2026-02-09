<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    //

    public function initiate_stk(Request $request)
    {
        dd($request->request->get('token'));
    }

    public function callback(Request $request)
{
    $callbackRequest = $request->all();
    $stkCallback = $callbackRequest["Body"]["stkCallback"];
    $resultCode = $stkCallback["ResultCode"];
    $resultDesc = $stkCallback["ResultDesc"];
    $checkoutRequestID = $stkCallback["CheckoutRequestID"];

    // 1. Log the full response for auditing
    Log::info('M-Pesa Callback Received', $callbackRequest);

    // 2. Find the Order using the CheckoutRequestID we stored during STK push
    $order = Order::where('checkout_request_id', $checkoutRequestID)->first();

    if (!$order) {
        Log::error("M-Pesa Callback Error: No order found for CheckoutID: " . $checkoutRequestID);
        return response()->json(['status' => 'Order Not Found'], 404);
    }

    // 3. Handle Failure (Code != 0)
    if ($resultCode != 0) {
        $order->update(['status' => 'FAILED']);
        return response()->json(['status' => 'acknowledged']);
    }

    // 4. Handle Success (ResultCode 0)
    if (isset($stkCallback["CallbackMetadata"])) {
        // Convert the Metadata array to a Collection for easier searching
        $items = collect($stkCallback["CallbackMetadata"]["Item"]);

        $receipt = $items->where('Name', 'MpesaReceiptNumber')->first()['Value'] ?? null;
        $amount  = $items->where('Name', 'Amount')->first()['Value'] ?? 0;
        $phone   = $items->where('Name', 'PhoneNumber')->first()['Value'] ?? null;

        try {
            DB::transaction(function () use ($order, $receipt, $amount, $phone) {
                // Update Order Status
                $order->update(['status' => 'COMPLETED']);

                // Create the Payment Record
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'payment_method' => 'MPESA',
                    'transaction_reference' => $receipt,
                    'phone_number' => $phone,
                    'status' => 'COMPLETED'
                ]);

                // Note: OrderItems stay as they are, but are now 'unlocked'
                // because the parent Order status is 'paid'.
            });

            Log::info("Payment Successful for Order #{$order->id}. Receipt: {$receipt}");

        } catch (\Exception $e) {
            Log::error("M-Pesa Callback DB Error: " . $e->getMessage());
            return response()->json(['status' => 'Database Error'], 500);
        }
    }

    // 5. Safaricom expects a JSON success response
    return response()->json(['status' => 'success']);
}
}
