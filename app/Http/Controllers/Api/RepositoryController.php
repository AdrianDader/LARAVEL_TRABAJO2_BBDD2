<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Repository::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'visibility' => 'required|in:public,private',
        'shared' => 'boolean',
        'tags' => 'required|array',
    ]);

    $repository = Repository::create([
        'user_id' => $request->user()->id, // 👈 AQUÍ asignas el usuario automáticamente
        'name' => $request->name,
        'description' => $request->description,
        'visibility' => $request->visibility,
        'shared' => $request->shared ?? false,
        'tags' => $request->tags,
    ]);

    return response()->json([
        'repository' => $repository,
        'message' => 'Repository created successfully.'
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
