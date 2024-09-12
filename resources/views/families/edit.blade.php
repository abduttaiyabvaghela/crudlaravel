@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Family</h1>
        <form id="family-form" action="{{ route('families.update', $family->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('families.partials.form', ['family' => $family])

            <button type="submit" class="btn btn-success">Update Family</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection
