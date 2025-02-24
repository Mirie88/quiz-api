<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz)
    {
        $questions = Question::where('quiz_id', $quiz)->paginate(1);
        if($question->count() < 1)
        {
            return response()->json([
                'message' => 'Questions Unavailable'
            ]);
        }
    return response()->json([
       'questions' => $questions

    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $questions = $request->validate([
            'quiz_id' =>'required|exists:quizzes,id',
            'question' =>'required|string',
            'options' =>'required|array|min:2',
            'answer' =>'required|string'
            ]);

            $question = Question::create($questions);

            return response()->json([
                'message'=>'question has been created',
                'question' => $question,
            ]);
        } catch (\illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error'=>$e->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        try {
            $questions = $request->validate([
                'question' =>'sometimes|string',
                'options' =>'sometimes|array|min:2',
                'answer' =>'sometimes|string'
            ]);  

            $question =update($questions);
            return response()->json($questions);
        } catch (\Throwable $e) {
            return response()->json([
                "Error" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
    $questions->delete();
    return response()->json(['message'=>'Question has been deleted']);    
    }
}
