<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Interface\LessonInterface;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    function __construct(private LessonInterface $lessonService){
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "data" => new LessonCollection($this->lessonService->getList())
        ]);
    }


    public function getDetailList(Request $request)
    {
        $data = $this->lessonService->getById($request->id);
        return response()->json([
            "data" => $data ? new LessonCollection($data) : null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,Request $request)
    {
        //
        if($request->type === "timeout"){
            $data = $this->lessonService->preparePracticeTimeout($id);
        }else{
            $data = new LessonResource($this->lessonService->getById($id));
        }
        return response()->json([
            "data" => $data
        ]);
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
