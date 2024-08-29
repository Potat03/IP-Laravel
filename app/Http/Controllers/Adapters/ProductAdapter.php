<?php
    namespace App\Http\Controllers\Adapters;

    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Http\Request;
    use App\Models\Product;

    class ProductAdapter implements TableAdapter
    {
        private $products;
        
        public function __construct($products)
        {
            if ($products instanceof Collection) {
                $this->products = $products;
            } else {
                $this->products = collect($products); // Convert array to Collection
            }
        }

        public function toRow()
        {
            $i = 1;
            $rows = [];
            foreach ($this->products as $product) {
                //html
                $rows[] = "<tr>
                    <td class='col'>{$i}</td>
                    <td class='col'>{$product->name}<span class='text-muted ps-1'>({$product->product_id})</span></td>
                    <td class='col'>{$product->price}</td>
                    <td class='col'>{$product->stock}</td>
                    <td class='col'>
                        <div class='d-flex align-items-center'>
                            <a href='#' class='btn btn-sm btn-primary me-2'><i class='fas fa-edit'></i></a>
                            <a href='#' class='btn btn-sm btn-danger' onclick='disableProduct({$product->product_id})'><i class='fas fa-eye-slash'></i></a>
                        </div>
                    </td>
                </tr>";
                $i++;
            }
            return $rows;
        }

        
    }