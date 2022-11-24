@extends('layouts.app')



@section('title', 'Showing ' . $visitor->user->name)



@section('content')

<p>{{ $visitor->comments }}</p>

@endsection