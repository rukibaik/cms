<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::with('items')->orderBy('sort_order')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:services',
            'subtitle' => 'nullable',
            'description' => 'nullable',
        ]);

        return Service::create($data);
    }

    public function show($slug)
    {
        return Service::where('slug', $slug)
            ->with('items')
            ->firstOrFail();
    }

    public function update(Request $request, Service $service)
    {
        $service->update($request->all());
        return $service;
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
