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

        // Collect product IDs
        $productIds = $lowStockProducts->pluck('product_id')->toArray();

        // Get main image URLs for these products
        $images = $this->getMainImages($productIds);

        // Aggregate product details into an HTML-formatted string
        $message = "<h2>Here are the products that are low in stock:</h2><ul>";

        foreach ($lowStockProducts as $product) {
            $imageUrl = url('storage/images/products/' . $product->product_id . '/main.png');

            $message .= "<li>";
            $message .= "<strong>Product ID:</strong> {$product->product_id}<br>";
            $message .= "<strong>Name:</strong> {$product->name}<br>";
            $message .= "<strong>Current Stock:</strong> {$product->stock}<br>";
            $message .= "<strong>Quantity to Reorder:</strong> 100<br>";
            $message .= "<strong>Message:</strong> Please restock this item.<br>";
            $message .= "<strong>Image:</strong><br><img src='{$imageUrl}' alt='{$product->name}' style='max-width: 200px;'><br>";
            $message .= "</li>";
        }

        $message .= "</ul><p>Please restock these items.</p>";

        // Send aggregated HTML message to Zapier
        Http::post('https://hooks.zapier.com/hooks/catch/20148429/2hvgf6e/', [
            'message' => $message
        ]);

        Log::info('Low stock data has been sent to Zapier.');
    }

    public function getMainImages($ids)
    {
        $images = [];
        foreach ($ids as $id) {
            $imageFiles = Storage::files('public/images/products/' . $id);

            $mainImage = null;

            foreach ($imageFiles as $file) {
                $filename = basename($file);

                if (strpos($filename, 'main') !== false && preg_match('/\.(jpg|jpeg|png)$/i', $filename)) {
                    $mainImage = Storage::url($file);
                    break;
                }
            }

            if (!$mainImage) {
                $mainImage = Storage::url('public/images/products/default.jpg'); // Ensure default image exists
            }

            $images[$id] = $mainImage;
        }

        return $images;
    }
}
