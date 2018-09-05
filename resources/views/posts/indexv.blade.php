@extends('layouts.app')

@section('content')
    

    <div id="app">
        <post></post>
    </div>

	

@endsection

@section('myJs')
	<script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'api_token' => (Auth::user()) ? Auth::user()->api_token : null
        ]) !!};
    </script>

    <script src="js/app.js"></script>
    
@endsection
