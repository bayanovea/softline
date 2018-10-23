<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * @var Contact
     */
    private $contact;

    /**
     * @var Request
     */
    private $request;

    /**
     * ContactController constructor.
     *
     * @param Contact $contact
     * @param Request $request
     */
    public function __construct(Contact $contact, Request $request)
    {
        $this->contact = $contact;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contact->all()->keyBy('id');
        return view('contact.index', ['contacts' => $contacts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'second_name' => 'required',
                'phone' => 'required',
                'email' => 'required|email'
            ]);
        } catch (ValidationException $e) {
            return response($e->errors(), 400);
        }

        $newContact = Contact::create($this->request->all());

        return response($newContact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validate = $request->validate([
                'second_name' => 'required',
                'phone' => 'required',
                'email' => 'required|email'
            ]);
        } catch (ValidationException $e) {
            return response($e->errors(), 400);
        }

        Contact::find($id)->update( $request->all() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);
        return response($id);
    }
}
