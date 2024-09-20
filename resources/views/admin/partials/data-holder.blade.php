{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

@push('product', 'class="active"')

@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
@endsection

@section('css')
    <style>
        .btn {
            font-weight: 600;
        }
    </style>
@endsection

<table class="table">
    <tbody id="data-holder">
        @forelse ($products as $index => $product)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                @if ($product->stock < 50)
                    <td class="text-danger fw-bold">{{ $product->stock }}</td>
                @else
                    <td class="text-success fw-bold">{{ $product->stock }}</td>
                @endif
                <td>{{ $product->getProductType() }}</td>
                @if ($product->status == 'active')
                    <td class="text-success fw-bold">{{ $product->status }}</td>
                @else
                    <td class="text-danger fw-bold">{{ $product->status }}</td>
                @endif
                <td>
                    <button class="btn btn-warning"
                        onclick="window.location.href='{{ route('admin.product.edit', $product->product_id) }}'"><i
                            class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No products found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
