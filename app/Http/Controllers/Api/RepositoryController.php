<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use Illuminate\Http\Request;
use App\Models\Tag;

class RepositoryController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Repository::all();
    }

  


     
   


    public function show(string $id)
    {
        // Buscamos el repositorio por ID
        $repository = Repository::find($id);

        // Si no existe el repositorio, respondemos con error 404
        if (!$repository) {
            return response()->json(['message' => 'Repository not found'], 404);
        }

        // Devolvemos el repositorio encontrado
        return response()->json($repository, 200);
    }

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscamos el repositorio por ID
        $repository = Repository::find($id);

        // Si no existe el repositorio, respondemos con error 404
        if (!$repository) {
            return response()->json(['message' => 'Repository not found'], 404);
        }

        // Eliminamos el repositorio
        $repository->delete();

        // Respondemos con mensaje de éxito
        return response()->json(['message' => 'Repository deleted successfully'], 200);
    }


   

        protected function validateTags(array $tags)
        {
            // Obtener todas las tags de MongoDB
            $existingTags = Tag::pluck('name')->toArray();

            // Verificar si todas las tags enviadas existen en MongoDB
            foreach ($tags as $tag) {
                if (!in_array($tag, $existingTags)) {
                    return false;  // Si alguna tag no existe, devolvemos false
                }
            }

            return true;  // Si todas las tags son válidas, retornamos true
        }


        public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'visibility' => 'required|in:public,private',
                'shared' => 'boolean',
                'tags' => 'required|array',
            ]);

            // Validar las tags
            if (!$this->validateTags($request->tags)) {
                return response()->json(['message' => 'Some tags are invalid.'], 422);
            }

            // 👇🏻 Aquí asignamos el user_id manualmente
            $validated['user_id'] = $request->user()->id;

            $repository = Repository::create($validated);

            return response()->json($repository, 201);
        }



        public function update(Request $request, string $id)
        {
            // Validamos los datos de la petición
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'visibility' => 'required|in:public,private',
                'shared' => 'boolean',
                'tags' => 'required|array',
            ]);

            // Validamos las tags contra la base de datos de MongoDB
            if (!$this->validateTags($request->tags)) {
                return response()->json(['message' => 'Some tags are invalid.'], 422);  // 422 Unprocessable Entity
            }

            // Buscamos el repositorio por ID
            $repository = Repository::find($id);

            // Si no existe el repositorio, respondemos con error 404
            if (!$repository) {
                return response()->json(['message' => 'Repository not found'], 404);
            }

            // Actualizamos el repositorio si las tags son válidas
            $repository->update($validated);

            // Devolvemos el repositorio actualizado
            return response()->json($repository, 200);
        }



}
