@extends('layouts.app')



@section('title', 'Showing ' . $visitor->name)



@section('content')

<p>{{ $visitor->comments }}</p>

@endsection