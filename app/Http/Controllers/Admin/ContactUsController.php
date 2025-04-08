<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Contact;

class ContactUsController extends Controller
{
   public function index(){
        $contacts = Contact::all(); 
        return view('Admin.Contact.index', compact('contacts'));
   } 
   public function delete($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();
    
    return redirect()->route('admin.contact')->with('success', 'Contact deleted successfully.');
}
}
