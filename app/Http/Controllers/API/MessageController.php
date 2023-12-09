<?php

namespace App\Http\Controllers\API;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Message::all();
    }



    //search
    public function search(String $id)
    {

        return Message::findOrfail($id);


    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function create(MessageRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $message = Message::create($validated);
        
        return $message;
    }

    /**
     * Display the specified resource.
     */

    //update
    public function update(MessageRequest $request, string $id)
    {
        $validated = $request->validated();
        $message = Message::findOrfail($id);
        $message->update($validated);
        return $message;
    }

    /**
     * Remove the specified resource from storage.
     */
    //destroy
    public function destroy(string $id)
    {
        $message = Message::findOrFail($id);
 
        $message->delete();

        return $message;
    }
}
