<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
            $sale = Sale::create([
                'total_amount' => $request->total_amount,
            ]);

            foreach ($request->cart as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $cartItem['quantity'],
                ]);

                StockMutation::create([
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'mutation_type' => 'OUT',
                ]);

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

    public function generatePdf(Request $req){
        $data = DB::table('sales')
            ->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('product', 'product.id', '=', 'sale_items.product_id')
            ->select('sales.total_amount', 'product.name', 'sale_items.*')
            ->get();

        $pdf = PDF::loadView('pos.report', compact('data'));
        return $pdf->download('report.pdf');
    }

    public function laporanTransaction(){
        $sale = Sale::all();

        return view('pos.laporan', compact('sale'));
    }

    public function laporanTransactionDetail($id){
        $data = DB::table('sales')
            ->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('product', 'product.id', '=', 'sale_items.product_id')
            ->select('sales.total_amount', 'product.name', 'sale_items.*')
            ->where('sales.id', '=', $id)
            ->get();

        return view('pos.laporan_detail', compact('data'));
    }
}

