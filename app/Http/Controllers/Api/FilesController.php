<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\Project as ResourcesProject;
use App\Models\Project;
use Illuminate\Http\Request;

class FilesController extends Controller
{
public function store(ImageRequest $request){

    $project = Project::findOrFail($request->project_id);
    $this->authorize('upload', $project);
    $image = $request->file('image');
    $filename = time().'.'.$image->getClientOriginalExtension();
    $image->storeAs('/public', $filename);
    $project->image = $filename;
    $project->save();
   // return new ResourcesProject($filename);
   return $filename;
}

}
