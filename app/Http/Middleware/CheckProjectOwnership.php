<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $projectId = $request->route('id') ?? $request->route('project');
        
        if (!$projectId) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        if ($project->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}