<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CheckLowStockAndReorder extends Command
{
    protected $signature = 'check:lowstock';
    protected $description = 'Check for low stock products and reorder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch low stock products
        $lowStockProducts = Product::where('stock', '<', 50)->get();

        // Aggregate product details into an HTML-formatted string
        $message = "<h2>Here are the products that are low in stock:</h2>";
        $message .= "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
        $message .= "<thead>";
        $message .= "<tr>";
        $message .= "<th>Product ID</th>";
        $message .= "<th>Product Name</th>";
        $message .= "<th>Current Stock</th>";
        $message .= "<th>Link</th>";
        $message .= "</tr>";
        $message .= "</thead>";
        $message .= "<tbody>";

        foreach ($lowStockProducts as $product) {
            // Update the image URL to use the dev tunnel URL
           
            $message .= "<tr>";
            $message .= "<td>{$product->product_id}</td>";
            $message .= "<td>{$product->name}</td>";
            $message .= "<td>{$product->stock}</td>";
            $message .= "<td><button type='button'>Restock</button></td>";
            $message .= "</tr>";
        }

        $message .= "</tbody>";
        $message .= "</table>";
        $message .= "<p>Please restock these items.</p>";

        // Send aggregated HTML message to Zapier
        Http::post('https://hooks.zapier.com/hooks/catch/20148429/2hvgf6e/', [
            'message' => $message
        ]);

        Log::info('Low stock data has been sent to Zapier.');
    }
}
