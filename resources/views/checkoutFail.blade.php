@extends('layout.shop')
{{-- Author: Tan Wei Siang --}}

@section('title', 'Cart')

@push('styles')
@vite(['resources/css/general.css'])
@endpush

@section('content')
 

    <div class="container-xl content-div" style="margin-bottom:6%;height:fit-content;">
     

        <p class="h2">Checkout Fail <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red"></i></p>
        <p>Sorry, you are fail to purchase!</p>

        

        Press here <a href="{{ url('/') }}" style="color: blue; text-decoration: underline;">"Go to Home"</a>

        
    </div>

  


@endsection

<script>

</script>