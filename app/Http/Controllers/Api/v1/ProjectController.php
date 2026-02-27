<?php

namespace App\Http\Controllers\Api\v1;

use App\Facades\Project as ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\AssignPerformerRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\GetTeamProjectsResource;
use App\Http\Resources\Project\MinifiedProjectResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('project.access')->only([
            'update',
            'destroy'
        ]);
    }

    public function index()
    {
        return   MinifiedProjectResource::collection(
            Project::query()
                ->where('user_id', authUserId())
                ->get()
        );
    }

    public function store(StoreProjectRequest $request)
    {
        return new ProjectResource(ProjectService::create($request->validated()));
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        // Fluent style (setProject() in the `ProjectService`:)
        return new ProjectResource(ProjectService::setProject($project)->update($request->validated()));

        //Standard style:
        // return new ProjectResource(ProjectService::update($request->validated()));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return responseOk($project);
    }

    public function listProjects()
    {
        return GetTeamProjectsResource::collection(auth()->user()->projects);
    }

    public function assignPerformer(AssignPerformerRequest $request)
    {
        $data = $request->validated();
        $project = new MinifiedProjectResource(Project::query()->find($data['projectId']));
        ProjectService::assignPerformer($data);

        return responseCreated($project);
    }
}
