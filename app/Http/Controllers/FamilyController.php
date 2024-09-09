<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of families.
     */
    public function index()
    {
        $families = Family::withCount('members')->get();
        return view('families.index', compact('families'));
    }

    /**
     * Show the form for creating a new family.
     */
    public function create()
    {
        $states = ['California', 'Texas', 'New York']; // Example states
        $cities = ['Los Angeles', 'Houston', 'New York City']; // Example cities
        
        return view('families.create', compact('states', 'cities'));
    }

    /**
     * Store a newly created family in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:-21 years',
            'mobile' => 'required|string|max:10',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string',
            'marital_status' => 'required|string|in:married,unmarried',
            'wedding_date' => 'nullable|date|required_if:marital_status,married',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string|max:255',
            'photo' => 'nullable|image',
            'family_members.*.name' => 'required|string|max:255',
            'family_members.*.birthdate' => 'required|date',
            'family_members.*.is_married' => 'required|boolean',
            'family_members.*.wedding_date' => 'nullable|date|required_if:family_members.*.is_married,1',
            'family_members.*.education' => 'required|string|max:255',
        ]);

        // Create the family
        $familyData = $request->except(['family_members', 'photo']);
        $familyData['hobbies'] = $request->input('hobbies', []);
        $family = Family::create($familyData);

        // Create family members if they are provided
        if ($request->has('family_members') && !empty($request->family_members)) {
            foreach ($request->family_members as $member) {
                $family->members()->create($member);
            }
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $family->update(['photo' => $photoPath]);
        }

        return response()->json(['message' => 'Family saved successfully!']);
    }

    /**
     * Display the specified family.
     */
    public function show($id)
    {
        $family = Family::with('members')->findOrFail($id);

        // Provide a default photo if none exists
        $photoUrl = $family->photo ? asset('storage/' . $family->photo) : asset('images/default-photo.jpg');

        return response()->json([
            'family' => $family,
            'members' => $family->members,
            'photo_url' => $photoUrl,
        ]);
    }

    /**
     * Show the form for editing the specified family.
     */
    public function edit($id)
    {
        $family = Family::with('members')->findOrFail($id);
        $states = ['California', 'Texas', 'New York']; // Example states
        $cities = ['Los Angeles', 'Houston', 'New York City']; // Example cities

        return view('families.edit', compact('family', 'states', 'cities'));
    }

    /**
     * Update the specified family in the database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:-21 years',
            'mobile' => 'required|string|max:10',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string',
            'marital_status' => 'required|string|in:married,unmarried',
            'wedding_date' => 'nullable|date|required_if:marital_status,married',
            'hobbies' => 'nullable|array',
            'photo' => 'nullable|image',
            'family_members.*.name' => 'required|string|max:255',
            'family_members.*.birthdate' => 'required|date',
            'family_members.*.is_married' => 'required|boolean',
            'family_members.*.wedding_date' => 'nullable|date|required_if:family_members.*.is_married,1',
            'family_members.*.education' => 'required|string|max:255',
        ]);

        $family = Family::findOrFail($id);

        // Update family details
        $familyData = $request->except(['family_members', 'photo']);
        $family->update($familyData);

        // Update or create family members
        if ($request->has('family_members') && !empty($request->family_members)) {
            foreach ($request->family_members as $member) {
                if (isset($member['id'])) {
                    // Update existing family member
                    $familyMember = FamilyMember::findOrFail($member['id']);
                    $familyMember->update($member);
                } else {
                    // Create new family member
                    $family->members()->create($member);
                }
            }
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $family->update(['photo' => $photoPath]);
        }

        return response()->json(['message' => 'Family updated successfully!']);
    }

    /**
     * Remove the specified family and member from the database.
     */
    public function destroy($id)
    {
        $family = Family::with('members')->findOrFail($id);
        $family->members()->delete();
        $family->delete();

        return response()->json(['message' => 'Family and its members deleted successfully.']);
    }

}
