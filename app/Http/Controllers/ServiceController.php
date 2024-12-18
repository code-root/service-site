<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all(); // استرجاع جميع الخدمات
        return view('services.index', compact('services'));
    }
}
