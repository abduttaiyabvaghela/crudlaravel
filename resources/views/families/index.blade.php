@extends('layouts.app')

@section('content')
    <h2>Families</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Head of Family</th>
                <th>Members Count</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($families->isEmpty())
                <tr>
                    <td colspan="3" class="text-center">No families found. Please add a new family.</td>
                </tr>
            @else
                @foreach($families as $family)
                <tr>
                    <td>{{ $family->name }} {{ $family->surname }}</td>
                    <td>
                        <a href="javascript:void(0);" onclick="showFamilyDetails({{ $family->id }})">
                            {{ $family->members_count }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('families.edit', $family->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteFamily({{ $family->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <a href="{{ route('families.create') }}" class="btn btn-primary btn-sm">Add Family</a>

    <!-- Family Details Modal -->
    <div class="modal fade" id="familyDetailsModal" tabindex="-1" aria-labelledby="familyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="familyDetailsModalLabel">Family Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 id="head-of-family-name"></h5>
                        </div>
                        <div class="col-md-4 text-end">
                            <img id="head-of-family-photo" src="" alt="Head of Family Photo" class="img-thumbnail" style="width: 150px;">
                        </div>
                    </div>
                    <hr>
                    <!-- Family Members Table -->
                    <h6>Family Members</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Birthdate</th>
                                <th>Marital Status</th>
                                <th>Wedding Date</th>
                                <th>Education</th>
                            </tr>
                        </thead>
                        <tbody id="family-members-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/form.js') }}"></script>
@endsection
