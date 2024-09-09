@extends('layouts.app')

@section('content')
<h2 class="mb-4">Add Family</h2>
<form id="family-form" action="{{ route('families.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Head of Family Information -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter head of family's name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" class="form-control" placeholder="Enter surname" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">Mobile No</label>
                <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter mobile number" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="state">State</label>
                <select id="state" name="state" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="city">City</label>
                <select id="city" name="city" class="form-control" required>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Enter pincode" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="marital_status">Marital Status</label>
                <select id="marital_status" name="marital_status" class="form-control" required>
                    <option value="unmarried">Unmarried</option>
                    <option value="married">Married</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 wedding-date" style="display:none;">
            <div class="form-group">
                <label for="wedding_date">Wedding Date</label>
                <input type="date" id="wedding_date" name="wedding_date" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="hobbies">Hobbies</label>
        <div id="hobby-fields"></div>
        <button type="button" id="add-hobby" class="btn btn-primary mt-2">Add Hobby</button>
    </div>

    <div class="form-group mb-3">
        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" class="form-control">
    </div>

    <div class="form-group mb-3">
        <h4 class="mb-2">Family Members</h4>
        <div id="family-member-fields"></div>
        <button type="button" id="add-family-member" class="btn btn-primary">Add Family Member</button>
    </div>

    <button type="submit" class="btn btn-success">Save Family</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('js/form.js') }}"></script>
@endsection
