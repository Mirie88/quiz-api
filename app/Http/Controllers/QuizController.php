<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return Quiz::with('questions')->get();
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
    public function store(StoreQuizRequest $request)
    {
        try {
            $newquiz = $request->validate([
                'title' =>'required',
                'description' =>'nullable'
            ]);

            // $newquiz['user_id'] = Auth::id();
            $newquiz['user_id'] = 2;
            $quiz = Quiz::create($newquiz, user()->id);

              return response()->json([
                'message'=>'quiz created successfully',
                'quiz' => $quiz,
              ]);
        } catch (\ILLuminate\Validation\ValidationException $e) {
            return response()->json([
                'error'=>$e->errors(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return response()->json($newquiz->load('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        if($request->user()->id  !== $newquiz->user_id){
            return response()->json([
                'message' =>'Unauthorized'
            ], 403);
        }

        $newquiz = $request->validate([
            'title' =>'sometimes',
            'description' =>'sometimes'
        ]);

        $quiz->update($newquiz);
        return response()->json([
            'message' =>'Quiz updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        if(auth()->user()->id  !== $newquiz->user_id){
            return response()->json([
                'message' =>'Unauthorized'
            ], 403);
        }
        $newquiz->delete();

        return response()->json([
            'message'=>'Quiz has been deleted'
        ]);
    }
}
