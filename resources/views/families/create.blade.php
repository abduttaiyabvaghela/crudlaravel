@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Family</h1>
        <form id="family-form" action="{{ route('families.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('families.partials.form')
            <button type="submit" class="btn btn-success">Create Family</button>
        </form>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/form.js') }}"></script>
@endsection
