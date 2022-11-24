@extends('layouts.app')

@section('title', 'New signing')

@section('content')

<form action="{{ route('visitors.store') }}" method="POST">
    @csrf
    <div class=" my-10">
        <label for="comments">Comments:</label>
        <textarea name="comments" id="comments" row="5" class=" p-2 bg-gray-200 @error('comments') is-invalid @enderror"></textarea>
        @error('comments')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-blue">Create</button>
</form>

@endsection