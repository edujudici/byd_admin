<?php

namespace App\Http\Api;

use App\Http\Api\ContactInterface;
use App\Models\Contact;

class ContactServiceImpl implements ContactInterface
{

    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getData()
    {
        $contacts = $this->contact->all();
        return response()->api($contacts);
    }
}