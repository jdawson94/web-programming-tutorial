@extends('layouts.app')



@section('title', 'Edit signing')



@section('content')

<form action="{{ route('visitors.update', $visitor->id) }}" method="POST">

@csrf

@method('PUT')



<div class="my-10">

<label for="name">Name:</label>

<input type="text" name="name" id="name" value="{{ $visitor->name }}" class=" p-2 bg-gray-200 @error('name') is-invalid @enderror" />



@error('name')

<div class="alert alert-danger">{{ $message }}</div>

@enderror

</div>



<div class="my-10">

<label for="comments">Comments:</label>

<textarea name="comments" id="comments" row="5" class=" p-2 bg-gray-200 @error('comments') is-invalid @enderror"> {{ $visitor->comments }}</textarea>



@error('comments')

<div class="alert alert-danger">{{ $message }}</div>

@enderror

</div>



<button type="submit" class="btn btn-blue">Update</button>

</form>

@endsection