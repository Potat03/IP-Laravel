<?php

/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Admin;

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
        $lowStockProducts = Product::where('stock', '<', 50)->get();

        //manager(s) are under to
        $to = Admin::where('role', 'manager')->pluck('email')->toArray();

        //admins are under cc
        $cc = Admin::where('role', 'admin')->pluck('email')->toArray();

        $message = "<h2>Here are the products that are low in stock:</h2>";
        $message .= "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
        $message .= "<thead>";
        $message .= "<tr>";
        $message .= "<th>Product ID</th>";
        $message .= "<th>Product Name</th>";
        $message .= "<th>Current Stock</th>";
        $message .= "<th>Message</th>";
        $message .= "</tr>";
        $message .= "</thead>";
        $message .= "<tbody>";

        foreach ($lowStockProducts as $product) {
            $message .= "<tr>";
            $message .= "<td>{$product->product_id}</td>";
            $message .= "<td>{$product->name}</td>";
            $message .= "<td style='color: red; font-weight: bold;'>{$product->stock}</td>";
            $message .= "<td>Restock required</td>";
            $message .= "</tr>";
        }

        $message .= "</tbody>";
        $message .= "</table>";
        $message .= "<p>Please restock these items.</p>";

        Http::post('https://hooks.zapier.com/hooks/catch/20148429/2hvgf6e/', [
            'to' => $to,
            'cc' => $cc,
            'message' => $message,
        ]);

        Log::info('Low stock data has been sent to Zapier.');
    }
}
