<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use App\Http\Resources\TodolistResource;
use Exception;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todolist = Todolist::latest()->get();
        // return response()->json(['data' => $todolist], 200);
        return TodolistResource::collection($todolist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=> 'required|min:3|max:255',
            'desc'=> 'required|min:3|max:255',
            'is_done'=> 'required|in:0,1'
        ]);

        try{
            $todolist = Todolist::create($data);    
            return response()->json([
                'message'=>'Todolist created successfully',
                'data'=>new TodolistResource($todolist)
        ], 201);
        } catch (Exception $error) {
            return response()->json(['message'=>'Todolist created failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todolist = Todolist::find($id);
        if($todolist == null) {
            return response()->json(['message' => 'Todolist not found'], 404);
        }
        return new TodolistResource($todolist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title'=> 'required|min:3|max:255',
            'desc'=> 'required|min:3|max:255',
            'is_done'=> 'required|in:0,1'
        ]);
        $todolist = Todolist::find($id);
        if($todolist == null) {
            return response()->json(['message' => 'Todolist not found'], 404);
        }
        try{
            $todolist->update($data);
            return response()->json([
                'message'=>'Todolist updated successfully',
                'data'=>new TodolistResource($todolist)
        ], 201);
        } catch (Exception $error) {
            return response()->json(['message'=>'Todolist updated failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todolist = Todolist::find($id);
        if($todolist == null) {
            return response()->json(['message' => 'Todolist not found'], 404);
        }
        try{
            $todolist->update($data);
            return response()->json([
                'message'=>'Todolist deleted successfully',
        ], 201);
        } catch (Exception $error) {
            return response()->json(['message'=>'Todolist deleted failed'], 500);
        }
    }
}
