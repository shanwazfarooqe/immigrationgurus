<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getCompany()
    {
        if(auth()->user()->company)
        {
            $companyid = auth()->user()->company;
        }
        else
        {
            $companyid = auth()->id();
        }

        return $companyid;
    }
}
