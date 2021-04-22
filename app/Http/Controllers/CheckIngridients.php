<?php

namespace App\Http\Controllers;


use App\Services\IngridientParser;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CheckIngridients extends Controller
{

    /**
     * @param Request $request
     * @return View
     */
    public function checkIngridients(Request $request)
    {
        /*   if () {
               // @todo add flash messaging
               Log::error('Could not load zones');
           }*/
       $parser = new IngridientParser();
       $result = $parser->analyse($request);

       // return response()->json($result);
        return back()->with('message', 'some data to send');
    }


}
