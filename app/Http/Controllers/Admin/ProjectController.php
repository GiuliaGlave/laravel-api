<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        $project = new Project;
        $types = Type::orderBy('label')->get();

        $technologies = Technology::orderBy('label')->get();
        return view('admin.projects.form', compact('project', 'types', 'technologies'));
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
      /*  $data = $request->all(); */
            
            if (Arr::exists($data, 'thumbnail')) {
            $path = Storage::put('uploads/projects', $data['thumbnail']);
            $data['thumbnail'] = $path;
        }

        $project = new Project;
        $project->fill($data);
        $project->slug = Project::getSlug($project->title);
        $project->save();
        if(Arr::exists($data, "technologies")) $project->technologies()->attach($data["technologies"]);

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
         $types = Type::orderBy('label')->get();
         $technologies = Technology::orderBy('label')->get();

        $project_technologies = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.form', compact('project', 'types','technologies', 'project_technologies'));
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
 //se esiste l'array data con la hiave technologies, effettua il sync, altrimenti elmina tutte le associazioni esistenti
        if(Arr::exists($data, 'technologies'))
            $project->technologies()->sync($data ['technologies']);
        else 
            $project->technologies()->detach();
        if (Arr::exists($data, 'thumbnail')) {
            if ($project->thumbnail) Storage::delete($project->thumbnail); //quando carichiamo un immagine se già ne esiste una cancellaLA
            $path = Storage::put('uploads/projects', $data['thumbnail']);
            $data['thumbnail'] = $path;
        }
        
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
        if ($project->thumbnail) Storage::delete($project->thumbnail);
        $project->delete();
        return to_route('admin.projects.index');
    }

    //VALIDATOR
    private function validation($data, $id = null){
        
        $validator= Validator::make(
            $data,
            [
            'title' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg',
            'details' => 'nullable|string',
            'type_id' => 'nullable|exists:types,id',
            'technology_id' => 'nullable|exists:technologies,id',

            ],
            [
    
            'title.max' => 'inserire titolo di max 50 caratteri',

            'thumbnail.string' => 'il file deve essere un\'immagine',
            'thumbnail.mimes' => 'sono ammessi formati jpg , png e jpeg',
            
            'details.string' => 'il testo deve contenere una stringa',
            
            'type_id.exists' => 'L\'id della categoria non esiste',
            'technology_id.exists' => 'L\'id della tecnologia non esiste',
        
            ]
        )->validate();

        return $validator;
 
    }
}