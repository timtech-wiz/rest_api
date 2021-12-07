<?php

namespace App\Http\Controllers;

use App\Http\Resources\Project as ResourcesProject;
use App\Http\Resources\ProjectCollection;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $projects = Project::where('user_id', auth()->user()->id)
        ->withCount('tasks')
        ->paginate();
            return new ProjectCollection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        
        $project = auth()->user()->projects()->create($request->all());
        return new ResourcesProject($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $tasks = $project->tasks;
        return new ResourcesProject($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
       $project->update($request->all());
       $tasks = $project->tasks;
        return new ResourcesProject($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return [
            'status' => 'Ok'
        ];
    }
}
