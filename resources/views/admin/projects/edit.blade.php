@extends('layouts.app')

@section('title', 'Modifica progetto')

@section('content')

    <a class="btn btn-primary my-4" href="{{ route('admin.projects.index') }}">Torna ai progetti</a>

    <h1 class='mt-5'> Modifica "{{$project->title}}"</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Attenzione: </h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-5">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('name') ?? $project->title }}"/>
                 @error('title') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
            </div>
            <div class="col-5">
                <label for="thumbnail" class="form-label">URL immagine di anteprima</label>
                <input type="text" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail"
                    value="{{ old('thumbnail') ?? $project->thumbnail}}" />
                    @error('thumbnail') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
            </div>
            
            <textarea class="col-6 mt-3 ms-3 @error('details') is-invalid @enderror" name="details" id="details" placeholder="Descrizione">{{ old('details') ?? $project->details}}</textarea>
             @error('details') 
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Salva</button>
    </form>
@endsection