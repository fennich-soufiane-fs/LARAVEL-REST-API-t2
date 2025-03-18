<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use App\Http\Resources\TodolistResource;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Logging;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodolistController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny', Todolist::class);
        try {
            $todolist = Todolist::latest()->where('user_id', auth()->user()->id)->get();
            Log::info('Todolist success');
            // return response()->json(['data' => $todolist], 200);
            return TodolistResource::collection($todolist);

        } catch(Exception $error) {
            Log::error("Todolist failed " . $error->getMessage());
            Logging::record(auth()->user()->id,'Todolist failed ' . $error->getMessage());
            return response()->json(['message' => 'Todolist failed ' . $error->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Todolist::class);
        $data = $request->validate([
            'title'=> 'required|min:3|max:255',
            'desc'=> 'required|min:3|max:255',
            'is_done'=> 'required|in:0,1'
        ]);

        try{
            $data['user_id'] = auth()->user()->id;
            $todolist = Todolist::create($data);    
            return response()->json([
                'message'=>'Todolist created successfully',
                'data'=>new TodolistResource($todolist)
        ], 201);
        } catch (Exception $error) {
            Logging::record(auth()->user()->id,'Todolist created failed' . $error->getMessage());
            return response()->json(['message'=>'Todolist created failed' . $error->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todolist = Todolist::find($id);
        $this->authorize('view', $todolist);

        if($todolist == null) {
            Logging::record(auth()->user()->id,'Todolist not found ' . $id);    
            return response()->json(['message' => 'Todolist not found : '. $id], 404);
        }
        return new TodolistResource($todolist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todolist = Todolist::find($id);
        $this->authorize('update', $todolist);
        $data = $request->validate([
            'title'=> 'required|min:3|max:255',
            'desc'=> 'required|min:3|max:255',
            'is_done'=> 'required|in:0,1'
        ]);
        if($todolist == null) {
            Logging::record(auth()->user()->id,'Todolist not found '. $id);
            return response()->json(['message' => 'Todolist not found : '. $id], 404);
        }
        try{
            $todolist->update($data);
            return response()->json([
                'message'=>'Todolist updated successfully',
                'data'=>new TodolistResource($todolist)
        ], 201);
        } catch (Exception $error) {
            Logging::record(auth()->user()->id,'Todolist updated failed' . $error->getMessage());
            return response()->json(['message'=>'Todolist updated failed' . $error->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todolist = Todolist::find($id);
        $this->authorize('delete', $todolist);
        if($todolist == null) {
            Logging::record(auth()->user()->id,'Todolist not found : '. $id);
            return response()->json(['message' => 'Todolist not found : '.$id], 404);
        }
        try{
            $todolist->delete($todolist);
            return response()->json([
                'message'=>'Todolist deleted successfully',
        ], 201);
        } catch (Exception $error) {
            Logging::record(auth()->user()->id,'Todolist deleted failed' . $error->getMessage());
            return response()->json(['message'=>'Todolist deleted failed'. $error->getMessage()], 500);
        }
    }
}
