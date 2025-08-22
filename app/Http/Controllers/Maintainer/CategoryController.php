<?php

namespace App\Http\Controllers\Maintainer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            $client = Client::where('id_user', $user->id)->first();
            $categoryexistperclient = Category::where('name',$request->name)->where('id_client', $client->id)->first();
            if (!$categoryexistperclient) {
                $category = Category::Create([
                    'name' => $request->name,
                    'id_client' => $client->id,
                    'color' => 'undefined',
                    'icon' => 'undefined',
                    'type' => $request->type,
                    'id_state' => 1,
                ]);
            }
        } catch (\Throwable $th) {
            error_log($th);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
