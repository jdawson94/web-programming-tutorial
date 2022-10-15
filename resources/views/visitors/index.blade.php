@extends('layouts.app')



@section('title', 'All of our visitors')



@section('content')

@if ($message = Session::get('success'))

<div class="alert alert-success">

<p>{{ $message }}</p>

</div>

@endif

@foreach ($visitors as $visitor)

<article>

<h3><a href="{{ route('visitors.show', $visitor->id) }}">{{ $visitor->name }}</a></h3>



<p>{{ $visitor->comments }}</p>



<form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST">

<a class="btn btn-blue" href="{{ route('visitors.show', $visitor->id) }}">Show</a>

<a class="btn btn-blue" href="{{ route('visitors.edit', $visitor->id) }}">Edit</a>



@csrf

@method('DELETE')



<button type="submit" class="btn btn-red">Delete</button>

</form>

</article>

@endforeach



{{ $visitors->links() }}

@endsection