<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuthorResource::collection(Author::get()->take(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'max:10|min:3',
            'age' => 'max:10|min:1',
            'province' => 'nullable'
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->age = $request->age;
        $author->province = $request->province;
        $author->save();

        return response()->json(["Message" => "Create", "data" => $author], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AuthorResource(Author::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'max:10|min:3',
            'age' => 'max:10|min:1',
            'province' => 'nullable'
        ]);

        $author = Author::findOrFail($id);
        $author->name = $request->name;
        $author->age = $request->age;
        $author->province = $request->province;
        $author->save();

        return response()->json(["Message" => "Updated", "data" => $author], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDelete = Author::destroy($id);
        if ($isDelete === 1) {
            return response()->json(["Message" => "Deleted"]);
        } else {
            return response()->json(["Message" => "Cannot find id"], 401);
        }
    }
}
