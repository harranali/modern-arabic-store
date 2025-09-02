<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display the About Us page.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function about(Request $request)
    {
        return Inertia::render('AboutUs');
    }

    /**
     * Display the Contact Us page.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function contact(Request $request)
    {
        return Inertia::render('ContactUs');
    }
}
