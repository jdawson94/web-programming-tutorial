@extends('layouts.app')



@section('title', 'Latest visitors')



@section('content')

@foreach ($latestVisitors as $visitor)

<article>

<h3><a href="{{ route('visitors.show', $visitor->id) }}">{{ $visitor->user->name }}</a></h3>



<p>{{ $visitor->comments }}</p>

</article>

@endforeach

@endsection
