<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::all(); // Mengambil semua kontak dari database
        return view('contacts.index', compact('contacts')); // Mengembalikan view contacts.index
    }    

    public function create() {
        return view('contacts.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
        ]);
    
        Contact::create($request->all());
    
        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil ditambahkan!');
    }
    

    public function edit($id) {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }    

    public function update(Request $request, Contact $contact) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'required'
        ]);

        $contact->update($request->all());
        return redirect()->route('contacts.index')
                         ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact) {
        $contact->delete();
        return redirect()->route('contacts.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}
