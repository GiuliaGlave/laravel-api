<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::paginate(10);

        if($request->has('term')){
            $term = $request->get('term');
            $projects = Project::where('title', 'LIKE', "%$term%")->paginate(10)->withQueryString();
        } else {
            $projects = Project::paginate(10);
        }
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $this->validation($request->all());

        $project = new Project;
        $project->fill($data);
       
        $project->save();

        return to_route("admin.projects.show", $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $this->validation($request->all(), $project->id);

        $project->update($data);
        return to_route("admin.projects.show", $project);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

    //VALIDATOR
    private function validation($data, $id = null){
        
        $validator= Validator::make(
             $data,
            [
            'title' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|string',
            'details' => 'nullable|string',

            ],
            [
    
            'title.max' => 'inserire titolo di max 50 caratteri',

            'thumbnail.string' => 'il link dell\'immagine deve essere una stringa',
            
            'details.string' => 'il testo deve contenere una stringa',
        
            ]
        )->validate();

        return $validator;
        
    }
}