<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarefaRequest;
use App\Models\Tarefa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Tarefa::query()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TarefaRequest $request): JsonResponse
    {
        $tarefa = Tarefa::query()->create($request->validated());

        return response()->json($tarefa, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa): JsonResponse
    {
        return response()->json($tarefa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TarefaRequest $request, Tarefa $tarefa): Response
    {
        $tarefa->update($request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa): Response
    {
        $tarefa->delete();

        return response()->noContent();
    }
}
