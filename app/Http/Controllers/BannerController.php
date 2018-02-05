<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\BannerInterface;

class BannerController extends Controller
{
    protected $bannerI;
    
    public function __construct(BannerInterface $bannerI)
    {
        $this->bannerI = $bannerI;
    }

    public function show()
    {
        $response = $this->bannerI->getData();               
        return view('banner')
            ->with('response', json_encode($response));
    }

    public function save(Request $req/*BannerFormRequest $req*/)
    {
        return $this->bannerI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->bannerI->delete($req->id);
    }
}
