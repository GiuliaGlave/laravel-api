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
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    
                    <td class="d-flex justify-content-between">
                        <a href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-light ">
      {{$projects->links('pagination::bootstrap-5')}}   
    </div>
   
</div>
@endsection