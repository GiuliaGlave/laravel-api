@extends('layouts.app')


@section('title', 'Project Details')

@section('content')

<div class="container text-dark">
    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-primary my-4">Torna ai progetti</>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary my-4">Modifica</a>
    </div>
     
    <div class="card">
        <div class="card-body my-2">
            <h5 class="card-title my-2"><strong>Titolo:</strong> {{ $project->title }}</h5>
            <h6 class="card-subtitle mb-2 my-2"><strong> Slug:</strong>
                {{ $project->slug }}
            </h6>

            <div class="row">
                <div class="col col-6 p-0">
                    <img class="w-100" src="{{$project->getPlaceholder()}}" alt="anteprima">
                </div>
                <div class="col col-6 p-3">
                    <h6><strong>Descrizione:</strong></h6>
                    <p class="card-text">{{ $project->details }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection