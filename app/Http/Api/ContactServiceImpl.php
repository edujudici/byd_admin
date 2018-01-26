<?php

namespace App\Http\Api;

use App\Http\Api\ContactInterface;
use App\Models\Company;
use App\Models\Contact;

class ContactServiceImpl implements ContactInterface
{
	protected $company;
    protected $contact;
    
    public function __construct(Company $company, Contact $contact)
    {
        $this->company = $company;
        $this->contact = $contact;
    }

    public function getCompany()
    {
        return $this->company->first();
    }
    
    public function getData()
    {
        $data = [
            'company' => $this->getCompany()
        ];
        return response()->api($data);
    }

    public function send($request)
    {
        $this->contact->CON_NAME = $request->name;
        $this->contact->CON_LASTNAME = $request->lastname;
        $this->contact->CON_EMAIL = $request->email;
        $this->contact->CON_PHONE = $request->phone;
        $this->contact->CON_MESSAGE = $request->message;
        $this->contact->save();

        return response()->api($this->contact);
    }
}