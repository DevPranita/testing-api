<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the authenticated user's projects.
     */
    public function index(Request $request)
    {
        $projects = $request->user()
            ->projects()
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Projects retrieved successfully.',
            'data' => $projects
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project = $request->user()->projects()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully.',
            'data' => $project
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified project.
     */
    public function show(Request $request, $id)
    {
        $project = $request->user()
            ->projects()
            ->with('tasks')
            ->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $project
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, $id)
    {
        $project = $request->user()->projects()->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'data' => $project
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Request $request, $id)
    {
        $project = $request->user()->projects()->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.'
        ], Response::HTTP_OK);
    }
}