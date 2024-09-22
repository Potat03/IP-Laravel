@extends('admin.layout.main')
@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js','resources/js/bootstrap.js'])
@endsection
@section('title', 'Dashboard')
@section('prev_page', route('admin.main'))
@section('page_title', 'Dashboard')
@section('page_gm', 'A place where you can feel welcomed and loved.')
@section('css')

@endsection


@section('content')
<div class="container">
    <div class="welcome_msg">
        <h5>Welcome Back, My Beloving {{Auth::guard('admin')->user()->name}}</h5>
    </div>
    <div class="daily_msg">
        <h5>Today's Message</h5>
        <p>Today is a new day, a new beginning. You have been given this day to use as you will. You can waste it or use it for good. What you do today is important because you are exchanging a day of your life for it. When tomorrow comes, this day will be gone forever; in its place is something that you have left behind... let it be something good.</p>
    </div>
</div>
@endsection

@section('js')

@endsection