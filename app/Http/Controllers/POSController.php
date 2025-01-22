<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        // Get all products
        $products = Product::all();

        return view('pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();

        try {
            // Create the sale
            $sale = Sale::create([
                'total_amount' => $request->total_amount, // Total amount sent from the frontend
            ]);

            // Loop through each item in the cart
            foreach ($request->cart as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                // Create a sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $cartItem['quantity'],
                ]);

                // Optionally, reduce stock in the products table
                $product->stock_quantity -= $cartItem['quantity'];
                $product->save();
            }

            // Commit the transaction
            \DB::commit();

            return response()->json(['message' => 'Transaction completed successfully!'], 200);

        } catch (\Exception $e) {
            // Rollback the transaction if anything goes wrong
            \DB::rollBack();
            return response()->json(['message' => $e], 500);
        }

        return redirect()->route('pos.index')->with('success', 'Transaction completed successfully!');
    }
}

