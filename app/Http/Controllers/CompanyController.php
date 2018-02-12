<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\CompanyInterface;

class CompanyController extends Controller
{
    protected $companyI;
    
    public function __construct(CompanyInterface $companyI)
    {
        $this->companyI = $companyI;
    }

    public function show()
    {
        $response = $this->companyI->getData();               
        return view('company')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->companyI->save($req);
    }
}
