<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function projects()
    {
        return view('pages.projects');
    }

    public function team()
    {
        return view('pages.team');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function ethics()
    {
        return view('pages.ethics');
    }

    public function sitesurveyor()
    {
        return view('projects.sitesurveyor');
    }

    public function bizintel()
    {
        return view('projects.bizintel');
    }
}
