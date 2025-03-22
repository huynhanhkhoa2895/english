<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyRequest;
use App\Interface\VocabularyInterface;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    function __construct(private readonly VocabularyInterface $vocabularyService){
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

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
    public function store(VocabularyRequest $request)
    {
        if (!$request->validated()){
            return response()->json(["status" => false]);
        }
        $req = $request->all();
        $vocabulary = new Vocabulary([
            "vocabulary" => $req['vocabulary'],
            "translate" => $req['translate'],
            "spelling" => $req['spelling'],
            "parts_of_speech" => $req['parts_of_speech'],
            "priority" => $req['priority'],
            "level" => $req['level'],
        ]);
        $data = $this->vocabularyService->createVocabulary($vocabulary);
        if (!$data){
            return response()->json(["status" => false]);
        }

        return response()->json(["status" => true]);
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
