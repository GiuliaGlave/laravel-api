@extends('layouts.app')

@section('title', 'Project List')
@section('content')
<div class="container">
        <a class="btn btn-primary my-3" href="{{ route('admin.projects.create') }}">Nuovo progetto</a>
        <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>{{ $project->thumbnail }}</td>
                    
                    <td>
                        <a href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
  

</div>
@endsection