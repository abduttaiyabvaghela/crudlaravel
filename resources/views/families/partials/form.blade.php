    <!-- Head of Family Information -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter head of family's name" value="{{ old('name', $family->name ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" class="form-control" placeholder="Enter surname" value="{{ old('surname', $family->surname ?? '') }}" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" class="form-control" value="{{ old('birthdate', $family->birthdate ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">Mobile No</label>
                <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter mobile number" value="{{ old('mobile', $family->mobile ?? '') }}" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" value="{{ old('address', $family->address ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="state">State</label>
                <select id="state" name="state" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}" {{ old('state', $family->state ?? '') == $state ? 'selected' : '' }}>{{ $state }}</option>
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
                        <option value="{{ $city }}" {{ old('city', $family->city ?? '') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Enter pincode" value="{{ old('pincode', $family->pincode ?? '') }}" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="marital_status">Marital Status</label>
                <select id="marital_status" name="marital_status" class="form-control" required>
                    <option value="unmarried" {{ old('marital_status', $family->marital_status ?? '') == 'unmarried' ? 'selected' : '' }}>Unmarried</option>
                    <option value="married" {{ old('marital_status', $family->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 wedding-date" style="{{ old('marital_status', $family->marital_status ?? '') == 'married' ? '' : 'display:none;' }}">
            <div class="form-group">
                <label for="wedding_date">Wedding Date</label>
                <input type="date" id="wedding_date" name="wedding_date" class="form-control" value="{{ old('wedding_date', $family->wedding_date ?? '') }}">
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="hobbies">Hobbies</label>
        <div id="hobby-fields">
            @if(old('hobbies', $family->hobbies ?? []))
                @foreach(old('hobbies', $family->hobbies ?? []) as $hobby)
                    <div class="input-group mb-2">
                        <input type="text" name="hobbies[]" class="form-control" value="{{ $hobby }}" placeholder="Enter hobby">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-hobby">Remove</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" id="add-hobby" class="btn btn-primary mt-2">Add Hobby</button>
    </div>

    <div class="form-group mb-3">
        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" class="form-control">
        @if(old('photo', $family->photo ?? []))
            <img src="{{ asset('storage/'.$family->photo) }}" alt="Family Photo" class="img-thumbnail mt-2" style="width: 150px;">
        @endif
    </div>
    

    <div class="form-group mb-3">
        <h4 class="mb-2">Family Members</h4>
        <div id="family-member-fields">
            @if(old('members', $family->members ?? []))
                @foreach(old('members', $family->members ?? []) as $key => $member)
                    <div class="family-member mb-3 p-3 border rounded" data-index="{{ $key }}">
                        <input type="hidden" name="family_members[{{ $key }}][id]" value="{{ $member['id'] ?? '' }}">
                        <div class="form-group mb-2">
                            <label>Member Name</label>
                            <input type="text" name="family_members[{{ $key }}][name]" class="form-control" placeholder="Enter member's name" value="{{ $member['name'] }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Birthdate</label>
                            <input type="date" name="family_members[{{ $key }}][birthdate]" class="form-control" value="{{ $member['birthdate'] }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Marital Status</label>
                            <select name="family_members[{{ $key }}][is_married]" class="form-control marital-status">
                                <option value="0" {{ $member['is_married'] == 0 ? 'selected' : '' }}>Unmarried</option>
                                <option value="1" {{ $member['is_married'] == 1 ? 'selected' : '' }}>Married</option>
                            </select>
                        </div>
                        <div class="form-group wedding-date" style="{{ $member['is_married'] == 1 ? '' : 'display:none;' }}">
                            <label>Wedding Date</label>
                            <input type="date" name="family_members[{{ $key }}][wedding_date]" class="form-control" value="{{ $member['wedding_date'] }}">
                        </div>
                        <div class="form-group mb-2">
                            <label>Education</label>
                            <input type="text" name="family_members[{{ $key }}][education]" class="form-control" placeholder="Enter education details" value="{{ $member['education'] }}" required>
                        </div>
                        
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button" id="add-family-member" class="btn btn-primary mt-2">Add Family Member</button>
    </div>
    <script>
        var memberIndex = {{ count(old('family_members', $family->family_members ?? [])) }};
    </script>