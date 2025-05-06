<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // Help Center page
    public function helpCenter()
    {
        return view('resources.help_center');
    }

    // Student Guides page
    public function studentGuides()
    {
        return view('resources.student_guides');
    }

    // Company Resources page
    public function companyResources()
    {
        return view('resources.company_resources');
    }

    // Terms and Conditions page
    public function termsConditions()
    {
        return view('resources.terms_conditions');
    }

    // Privacy Policy page
    public function privacyPolicy()
    {
        return view('resources.privacy_policy');
    }

    // Blog page
    public function blog()
    {
        return view('resources.blog');
    }
}
