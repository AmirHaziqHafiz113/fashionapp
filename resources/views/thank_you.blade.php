@extends('layouts.main')

@section('content')

<section class="container mt-2 my-3 py-5">
    <div>
        @if(Session::has('order_id') && Session::get('order_id') != null)
            <h4>Order Id: {{ session::get('order_id') }}</h4>

        @endif
    </div>
</section>


@endsection
