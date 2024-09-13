@extends('admin.layout.main')

@section('css')
    <style>
        .btn {
            font-weight: 600;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('title', 'Product')
@section('page_title', 'Product')
@section('page_gm', 'Edit Product')

@section('content')
    <div class="card shadow-sm p-3 mb-5 w-100">
        <div class="overflow-auto">
            <div class="card-body">
                <form method="POST" id="productForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price"
                            value="{{ $product->price }}" required min="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            value="{{ $product->stock }}" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type"
                            value="{{ $product->getProductType() }}" disabled>
                    </div>

                    @if ($product->wearable)
                        <input type="hidden" id="isWearable" value="1">

                        <div class="mb-3">
                            <label for="size" class="form-label">Sizes:</label>
                            <div id="sizes-container">
                                @php
                                    $sizes = array_filter(array_map('trim', explode(',', $product->wearable->size)));
                                @endphp

                                @if (count($sizes) > 0)
                                    @foreach ($sizes as $index => $size)
                                        <div class="row mb-3 size-box align-items-center">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control size-input"
                                                    id="size_{{ $index }}" name="sizes[]" value="{{ $size }}"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-size"
                                                    data-index="{{ $index }}">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-3 mt-2">
                                <input type="text" id="new-size" class="form-control" placeholder="Enter new size">
                                <button type="button" class="btn btn-primary mt-2" id="add-size">Add Size</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Colors:</label>
                            <div id="colors-container">
                                @php
                                    $colors = array_filter(array_map('trim', explode(',', $product->wearable->color)));
                                @endphp

                                @if (count($colors) > 0)
                                    @foreach ($colors as $index => $color)
                                        <div class="row mb-3 color-box align-items-center">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control color-input"
                                                    id="color_{{ $index }}" name="colors[]"
                                                    value="{{ $color }}" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-color"
                                                    data-index="{{ $index }}">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-3 mt-2">
                                <input type="text" id="new-color" class="form-control" placeholder="Enter new color">
                                <button type="button" class="btn btn-primary mt-2" id="add-color">Add Color</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="user-group" class="form-label">User Group(s):</label>
                            <div class="user-group-container">
                                <button type="button" class="btn btn-outline-primary user-group-btn"
                                    data-group="children">Children</button>
                                <button type="button" class="btn btn-outline-primary user-group-btn"
                                    data-group="adult">Adult</button>
                                <button type="button" class="btn btn-outline-primary user-group-btn"
                                    data-group="unisex">Unisex</button>
                                <button type="button" class="btn btn-outline-primary user-group-btn"
                                    data-group="male">Male</button>
                                <button type="button" class="btn btn-outline-primary user-group-btn"
                                    data-group="female">Female</button>
                            </div>

                            <input type="hidden" id="selectedGroupsInput" name="selected_groups" value="">
                        </div>

                    @endif

                    @if ($product->consumable)
                        <input type="hidden" id="isConsumable" value="1">

                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date:</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                value="{{ $product->consumable->expiry_date }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="portion" class="form-label">Portion:</label>
                            <input type="number" class="form-control" id="portion" name="portion"
                                value="{{ $product->consumable->portion }}" required min="1">
                        </div>

                        <div class="mb-3">
                            <label for="halal" class="form-label">Halal:</label>
                            <select class="form-control" id="halal" name="halal" required>
                                <option value="1" {{ $product->consumable->halal ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->consumable->halal ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    @endif

                    @if ($product->collectible)
                        <input type="hidden" id="isCollectible" value="1">

                        <div class="mb-3">
                            <label for="supplier" class="form-label">Supplier:</label>
                            <input type="text" class="form-control" id="supplier" name="supplier"
                                value="{{ $product->collectible->supplier }}" required>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="active"
                            {{ $product->status == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusSwitch">
                            {{ $product->status == 'active' ? 'Active' : 'Inactive' }}
                        </label>

                        <input type="hidden" id="statusHidden" name="status"
                            value="{{ $product->status == 'active' ? 'active' : 'inactive' }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='{{ route('admin.product') }}'">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productForm = document.getElementById('productForm');
            const isWearableField = document.getElementById('isWearable');
            const isWearable = isWearableField ? isWearableField.value : "0";
            const isConsumableField = document.getElementById('isConsumable');
            const isConsumable = isConsumableField ? isConsumableField.value : "0";
            const isCollectibleField = document.getElementById('isCollectible');
            const isCollectible = isCollectibleField ? isCollectibleField.value : "0";

            const statusSwitch = document.getElementById('statusSwitch');
            const statusHidden = document.getElementById('statusHidden');
            const statusLabel = document.querySelector('label[for="statusSwitch"]');

            // Update hidden input and label based on the switch status
            statusLabel.textContent = statusSwitch.checked ? 'Active' : 'Inactive';
            statusHidden.value = statusSwitch.checked ? 'active' : 'inactive';

            statusSwitch.addEventListener('change', function() {
                const status = statusSwitch.checked ? 'active' : 'inactive';
                statusHidden.value = status;
                statusLabel.textContent = statusSwitch.checked ? 'Active' : 'Inactive';
            });

            const productId = @json($product->product_id);

            productForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Collect common attributes
                const form = new FormData(productForm);
                const name = form.get('name');
                const stock = form.get('stock');
                const description = form.get('description');
                const status = form.get('status');

                // form.append('status', status);

                // Handle attributes based on product type
                if (isWearableField && isWearableField.value) {
                    const sizes = Array.from(document.querySelectorAll('#sizes-container input')).map(
                        input => input.value.trim());
                    const colors = Array.from(document.querySelectorAll('#colors-container input')).map(
                        input => input.value.trim());
                    const userGroups = selectedGroupsInput.value.trim();

                    if (sizes.length === 0 && colors.length === 0) {
                        alert('Please enter at least one size or color for wearable products.');
                        return;
                    }

                    if (userGroups === '') {
                        alert('Please select at least one user group.');
                        return;
                    }

                    form.append('isWearable', isWearable);
                    form.append('sizes', sizes.join(','));
                    form.append('colors', colors.join(','));
                    form.append('user_groups', userGroups);
                }

                if (isConsumableField && isConsumableField.value) {
                    const expiryDate = form.get('expiry_date').trim();
                    const portion = form.get('portion').trim();
                    const halal = form.get('halal').trim();

                    if (expiryDate === '' || portion === '' || halal === '') {
                        alert(
                            'Please enter expiry date, portion, and halal status for consumable products.'
                        );
                        return;
                    }

                    form.append('expiry_date', expiryDate);
                    form.append('portion', portion);
                    form.append('halal', halal);
                }

                if (isCollectibleField && isCollectibleField.value) {
                    const supplier = form.get('supplier').trim();

                    if (supplier === '') {
                        alert('Please enter supplier for collectible products.');
                        return;
                    }

                    form.append('isCollectible', isCollectible);
                    form.append('supplier', supplier);
                }

                fetch("{{ route('product.update', $product->product_id) }}", {
                        method: 'POST',
                        body: form
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "{{ route('admin.product') }}";
                        } else {
                            alert('Failed to update product');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });

            });

            function handleWearableFields() {
                const sizesContainer = document.getElementById('sizes-container');
                const addSizeButton = document.getElementById('add-size');
                const newSizeInput = document.getElementById('new-size');

                addSizeButton.addEventListener('click', function() {
                    const newSize = newSizeInput.value.trim();
                    if (newSize === '') {
                        alert('Please enter a size.');
                        return;
                    }

                    const index = sizesContainer.children.length;

                    const sizeBox = document.createElement('div');
                    sizeBox.classList.add('row', 'mb-3', 'size-box', 'align-items-center');
                    sizeBox.innerHTML = `
            <div class="col-md-10">
                <input type="text" class="form-control size-input" id="size_${index}" name="sizes[]" value="${newSize}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-size" data-index="${index}">X</button>
            </div>
        `;

                    sizesContainer.appendChild(sizeBox);

                    newSizeInput.value = '';
                });

                sizesContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-size')) {
                        const sizeBox = event.target.closest('.size-box');
                        sizesContainer.removeChild(sizeBox);
                    }
                });

                const colorsContainer = document.getElementById('colors-container');
                const addColorButton = document.getElementById('add-color');
                const newColorInput = document.getElementById('new-color');

                addColorButton.addEventListener('click', function() {
                    const newColor = newColorInput.value.trim();
                    if (newColor === '') {
                        alert('Please enter a color.');
                        return;
                    }

                    const index = colorsContainer.children.length;

                    const colorBox = document.createElement('div');
                    colorBox.classList.add('row', 'mb-3', 'color-box', 'align-items-center');
                    colorBox.innerHTML = `
            <div class="col-md-10">
                <input type="text" class="form-control color-input" id="color_${index}" name="colors[]" value="${newColor}" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-color" data-index="${index}">X</button>
            </div>
        `;

                    colorsContainer.appendChild(colorBox);

                    newColorInput.value = '';
                });

                colorsContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-color')) {
                        const colorBox = event.target.closest('.color-box');
                        colorsContainer.removeChild(colorBox);
                    }
                });

                @if ($product->wearable)
                    const userGroupData = @json($product->wearable->user_group || '');

                    if (userGroupData) {
                        const existingUserGroups = @json($product->wearable->user_group).split(',').map(group => group.trim()
                            .toLowerCase());
                        const selectedGroupsInput = document.getElementById('selectedGroupsInput');
                        const userGroupButtons = document.querySelectorAll('.user-group-btn');

                        selectedGroupsInput.value = existingUserGroups.join(',');

                        userGroupButtons.forEach(button => {
                            const group = button.getAttribute('data-group').toLowerCase();

                            if (existingUserGroups.includes(group)) {
                                button.classList.add('btn-primary');
                                button.classList.remove('btn-outline-primary');
                            }

                            button.addEventListener('click', function() {
                                this.classList.toggle('btn-primary');
                                this.classList.toggle('btn-outline-primary');

                                const selectedGroups = Array.from(userGroupButtons)
                                    .filter(btn => btn.classList.contains('btn-primary'))
                                    .map(btn => btn.getAttribute('data-group'));

                                selectedGroupsInput.value = selectedGroups.join(',');
                            });
                        });
                    }
                @endif
            }

            if (isWearableField && isWearableField.value) {
                handleWearableFields();
            }
        });
    </script>
@endsection
