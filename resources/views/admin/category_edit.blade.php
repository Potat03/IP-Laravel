{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

@extends('admin.layout.main')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js','resources/js/bootstrap.js'])
@endsection

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

@section('prev_page', route('admin.product'))
@section('title', 'Edit Category')
@section('page_title', 'Edit Category')
@section('page_gm', 'Edit Category')

@section('content')
    <div class="px-2 py-3">
        <h1>Edit Category</h1>
    </div>
    <div class="card shadow-sm p-3">
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $category->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
        </div>
    </div>
@endsection
