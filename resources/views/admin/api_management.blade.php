<!-- Api Management Page -->
<!-- Author: Loh Thiam Wei -->

@extends('admin.layout.main')

@section('title', 'API Management')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css','resources/js/bootstrap.js'])
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

    .top_content,
    .top_content *,
    .left_bar,
    .left_bar * {
        box-sizing: unset;
    }
</style>
@endsection


@section('page_title', 'API Management')
@section('page_gm', 'Generate API key for other application')

@section('content')
<div class="card shadow-sm p-3 position-static">
    <div class="card-body">
        <div class="card-title d-flex px-3">
            <div class="ms-auto">
                <form class="input-group" id="create_form" action="{{ route('admin.apikey.create')  }}" method="POST">
                    @csrf
                    <div class="form-outline">
                        <input type="search" id="form1" name="note" class="form-control rounded-0" placeholder="Create for ?"  required/>
                    </div>
                    <button class="btn btn-primary" type="submit">Generate API Key</button>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Note</th>
                    <th scope="col">API Key</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="data-holder">
                @php
                $index = 1;
                @endphp
                @foreach ($keys as $key)
                <tr id="">
                    <th scope="row">{{ $index++ }}</th>
                    <td>{{ $key->note }}</td>
                    <td>{{ $key->api_key }}</td>
                    <td>
                        <form class="input-group" id="delete_form" action="{{ route('admin.apikey.delete')  }}" method="POST">
                            @csrf
                            <input type="hidden" name="key" value="{{ $key->api_key }}">
                            <button class="btn btn-danger" type="submit"><i class="fa-regular fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#create_form').submit(function(e) {
        e.preventDefault();
        var note = $('#form1').val();
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            data: {
                note: note,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                location.reload();
            }
        });
    });

    $('#delete_form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            data: {
                key: $(this).find('input[name="key"]').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                location.reload();
            }
        });
    });
</script>
@endsection