<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UniveristyController extends Controller
{
    //apply university policies (its like roleBuck for your controller)
    use AuthorizesRequests;
    //list all universities
    public function universitiesList(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', $currentUser);

        if ($currentUser->user_role === 1) {
            $universities =  University::all();
        } else {
            $universities = University::where('id', $currentUser->university_id)->get();
        }
        return view('universities.universitiesList', compact('universities'));
    }


    //delete university
    public function delete(Request $request, $id)
    {
        $uniToDelete = University::findOrFail($id);
        $this->authorize('delete', $uniToDelete);
        $uniToDelete->delete();
        return redirect()->back()->with('success', 'University is Deleted');
    }
    //cahange university status
    public function statusUpdate(Request $request, $id)
    {
        $uniToUpdate = University::findOrFail($id);
        $this->authorize('update', $uniToUpdate);
        $uniToUpdate->Status = $request->input('UniversityStatus');
        $uniToUpdate->save();
        return redirect()->back()->with('success', 'University status is updated');
    }

    //create and store new universities

    public function create(Request $request)
    {
        $this->authorize('create', University::class);
        return view('universities.createUniversity');
    }

    public function store(Request $request)
    {
        $this->authorize('create', University::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:universities,name',
            'country' => 'required|string|max:100',
            'total_score' => 'required|numeric|min:0|max:1000',
            'status' => 'required|in:0,1', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        University::create([
            'name' => $request->input('name'),
            'country' => $request->input('country'),
            'total_score' => $request->input('total_score'),
            'Status' => $request->input('status'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('adminDashboard')->with('success', 'New university created successfully.');
    }

    //edit and update university

    public function edit(Request $request, $id)
    {
        $university = University::findOrFail($id);
        $this->authorize('edit', $university);

        return view('universities.editUniversity', compact('university'));
    }



    public function updateUniversity(Request $request, $id)
    {
        $universityToEdit = University::findOrFail($id);
        $this->authorize('edit', $universityToEdit);

        $request->validate([
            'name' => 'required|string|max:255|unique:universities,name,' . $universityToEdit->id,
            'country' => 'required|string|max:100',
            'total_score' => 'required|numeric|min:0|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $universityToEdit->name = $request->input('name');
        $universityToEdit->country = $request->input('country');
        $universityToEdit->total_score = $request->input('total_score');
        $universityToEdit->created_at = $universityToEdit->created_at;
        $universityToEdit->updated_at = now();

        $universityToEdit->save();

        return redirect()->route('adminDashboard')->with('success', 'University updated successfully.');
    }


    //list not active universities
    public function notActiveList(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('update', $currentUser);
        $universities =  University::where('Status', 0)->get();
        return view('universities.queueUniversity', compact('universities'));
    }

    // Create University from User (no auth needed)
    public function createUniFromUser(Request $request)
    {
        return view('universities.addUniversityFromUser');
    }

    public function storeUniFromUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:universities,name',
            'country' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        University::create([
            'name' => $request->input('name'),
            'country' => $request->input('country'),
            'Status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('dashboard')->with('success', 'University registration submitted successfully. It is pending approval.');
    }
}
