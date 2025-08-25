<?php 
 
 namespace App\Http\Controllers;

 use App\Http\Requests\StoreProjectRequest;
 use App\Http\Requests\UpdateProjectRequest;
 use App\Http\Resources\ProjectResource;
 use App\Http\Resources\ProjectCollection;
 use App\Models\Project;
 use Illuminate\Http\Request;


 class ProjectController extends Controller
 {
     /**
      * Display a listing of the resource.
      */
     public function index(Request $request)
     {
         $projects = Project::where('user_id', $request->user()->id)
                ->withCount('tasks')
                ->paginate(10);

         return new ProjectCollection($projects);
     }

     /**
      * Store a newly created resource in storage.
      */
     public function store(StoreProjectRequest $request)
     {
         $project = Project::create([
            'name' => $request->name,
            'description' => $request->description, 
            'user_id' => $request->user()->id
         ]);

         return new ProjectResource($project);
     }

     /**
      * Display the specified resource.
      */
     public function show(Project $project)
     { 
        $this->authorize('view', $project);

        $project->load('tasks.assignee');
         return new ProjectResource($project);
     }

     /**
      * Update the specified resource in storage.
      */
     public function update(UpdateProjectRequest $request, Project $project)
     {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return new ProjectResource($project);
     }

     /**
      * Remove the specified resource from storage.
      */
     public function destroy(Project $project)
     {
        $this->authorize('delete', $project);

        $project->delete();
        
        return new ProjectResource($project);
     }
 }