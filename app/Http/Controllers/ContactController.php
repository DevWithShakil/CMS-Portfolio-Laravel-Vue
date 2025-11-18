<?php

namespace App\Http\Controllers;
use App\Models\Contact;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Get all contacts from the database
    public function index()
    {
        return Contact::all();
    }

    // Post a new contact to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Insert the contact into the database
        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Contact created successfully',
            'data' => $contact,
        ], 201);
    }

    // Get a single contact from the database
    public function show(string $id)
    {
        // Get the contact from the database
        $contact = Contact::findOrFail($id);

        return response()->json([
            'message' => 'Contact found successfully',
            'data' => $contact,
        ], 201);
    }

    // Update a contact in the database
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]));

        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact,
        ], 201);
    }

    // Delete a contact from the database
    public function destroy(string $id)
    {
        // Delete contact from the database
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully',
            'data' => $contact,
        ], 201);
    }
}
