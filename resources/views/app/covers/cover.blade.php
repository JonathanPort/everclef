@extends('app.base')

@section('content')

    @include('app.includes.lyrics', ['song' => $cover])

@endsection