@extends('admin.layout.main')
@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js','resources/js/bootstrap.js'])
@endsection
@section('title', 'Dashboard')
@section('prev_page', route('admin.main'))
@section('page_title', 'Dashboard')
@section('page_gm', 'A place where you can feel welcomed and loved.')
@section('css')
<style>
    .welcome_msg {
        margin-top: 50px;
        text-align: center;
    }

    .welcome_msg h5 {
        font-size: 3em;
    }

    .daily_msg {
        margin-top: 50px;
        text-align: center;
    }

    .daily_msg {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .daily_msg h5 {
        opacity: 0.5;
    }

    .daily_msg p {
        font-weight: 400;
        letter-spacing: -0.5px;
    }

    .daily_msg span {
        font-weight: 700;
        color: var(--blue);
        cursor: pointer;
        opacity: 0.8;
        transition: all 0.3s;
    }

    .daily_msg span:hover {
        opacity: 1;
    }

    .music_btn_wrap {
        display: flex;
        justify-content: center;
        padding-top: 20px;
        gap: 10px;
    }

    .btn_wrap {
        display: flex;
        padding: 10px 10px 10px 20px;
        border: 1px solid var(--adminmain);
        border-radius: 5px;
    }

    .btn_wrap label {
        width: 100px;
        font-size: 0.8em;
        font-weight: 700;
        letter-spacing: -0.5px;
        font-family: Arial, Helvetica, sans-serif;
        display: flex;
        justify-content: left;
        align-items: center;
    }

    .btn_wrap button {
        width: 40px;
        height: 40px;
        border-radius: 5px;
        outline: none;
        border: 1px solid var(--adminmain);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn_wrap i {
        font-size: 1.2em;
        color: var(--adminmain);
    }
</style>
@endsection


@section('content')
<div class="container">
    <div class="welcome_msg">
        <h5>Welcome Back, My Beloving {{Auth::guard('admin')->user()->name}}</h5>
    </div>
    <div class="daily_msg">
        <h5>Everything is running smoothly. Let's conquer today!</h5>
    </div>
    <div class="daily_msg">
        <h5>今日 の messēji</h5>
        <p>Please be <span onclick="play('happy')">happi happy happi</span></p>
    </div>
    <div class="music_btn_wrap">
        <div class="btn_wrap">
            <label>Maitake</label>
            <button id="maitake_btn" onclick="play('maitake')"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="btn_wrap">
            <label>Got one small bee</label>
            <button id="bee_btn" onclick="play('bee')"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="btn_wrap">
            <label>Welcome Admin Song</label>
            <button id="welcome_btn" onclick="play('welcome')"><i class="fa-solid fa-play"></i></button>
        </div>
    </div>

    <audio id="happy" src="{{ asset('audio/happy.mp3') }}"></audio>
    <audio id="maitake" src="{{ asset('audio/maitake.mp3') }}"></audio>
    <audio id="bee" src="{{ asset('audio/bee.mp3') }}"></audio>
    <audio id="welcome" src="{{ asset('audio/welcome.mp3') }}"></audio>
</div>
@endsection

@section('js')
<script>
    const happy = $('#happy');
    const maitake = $('#maitake');
    const bee = $('#bee');
    const welcome = $('#welcome');

    var playing = '';

    function play(song) {
        //store any playing
        happy[0].pause();
        maitake[0].pause();
        bee[0].pause();
        welcome[0].pause();

        $('.btn_wrap button').html('<i class="fa-solid fa-play"></i>');

        if (playing == song) {
            playing = '';
            return;
        } else {
            happy[0].currentTime = 0;
            maitake[0].currentTime = 0;
            bee[0].currentTime = 0;
            welcome[0].currentTime = 0;

            if (song == 'happy') {
                happy[0].play();
            } else if (song == 'maitake') {
                maitake[0].play();
                $('#maitake_btn').html('<i class="fa-solid fa-pause"></i>');
            } else if (song == 'bee') {
                bee[0].play();
                $('#bee_btn').html('<i class="fa-solid fa-pause"></i>');
            } else if (song == 'welcome') {
                welcome[0].play();
                $('#welcome_btn').html('<i class="fa-solid fa-pause"></i>');
            }

            playing = song;
        }
    }
</script>
@endsection