<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use Illuminate\Http\Request;
use App\Interface\ResultInterface;

class ResultController extends Controller
{
    function __construct(private readonly ResultInterface $resultService){
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(["data"=>200]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            "data" => 200
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResultRequest $request)
    {

        $datas = $request->validated() ;
        $datas = collect($datas['data']);
        $result = $datas->map(function($data){
            return $this->resultService->createResult($data);
        });

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json([
            "data" => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return response()->json([
            "data" => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return response()->json([
            "data" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
