@extends('layouts.app')

@section('cdn')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
@endsection


@section('title', 'Project List')
@section('content')
<div class="container">

    <div class="d-flex align-items-center justify-content-between">
     {{-- new project btn --}}
    <a class="btn btn-primary my-3" href="{{ route('admin.projects.create') }}">Nuovo progetto</a>
    {{-- search bar --}}
    <form class="d-flex my-4" role="search">
        <input class="form-control me-2" type="search" name="term" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>   
    </div>
    
        <table class="table table-striped mt-5 bg-light">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tecnologie</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    {{-- id --}}
                    <th scope="row">{{ $project->id }}</th>
                    {{-- title --}}
                    <td>{{ $project->title }}</td>
                    {{-- slug --}}
                    <td>{{ $project->slug }}</td>
                    {{-- types --}}
                    <td></strong><span class="badge ms-1" style="background-color:{{$project->type?->color}}"> {{ $project->type?->label }}</span></td>
                    {{-- tecnologies --}}
                    <td>
                        </strong><span class="badge ms-1 text-dark" >
                         @forelse ($project->technologies as $technology)
                        {{ $technology?->label }} 
                        
                        {{-- per levare la virgola all'ultimo elemento --}}
                        @if(!$loop->last) ,  @endif

                        @empty
                        -
                        @endforelse
                        
                    </span></td>
                    
                    {{-- actions --}}
                    <td class="d-flex justify-content-around">
                        <a  href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-eye"></i>
                        </a>
                        <a  href={{ route('admin.projects.edit', $project) }}>
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#delete-modal-{{$project->id}}"><i class="bi bi-trash"></i></button>
                     
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-light ">
      {{$projects->links('pagination::bootstrap-5')}}   
    </div> 
</div>                      
                
 @section('modals')
    @foreach($projects as $project)
        <div class="modal fade text-dark" id="delete-modal-{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina "{{$project->title}}"</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Attenzione! L'operazione non è reversibile
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="text-danger">              
                    @method('delete') 
                    @csrf

                   <button type="submit" class="btn btn-danger">Ok</button>
                </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@endsection