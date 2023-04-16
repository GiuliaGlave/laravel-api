@extends('layouts.app')

@section('title', 'Nuovo progetto')

@section('content')
    <a class="btn btn-primary my-4" href="{{ route('admin.projects.index') }}">Torna ai progetti</a>
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


    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-5">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('name') }}" />
            </div>
            <div class="col-5">
                <label for="thumbnail" class="form-label">URL immagine di anteprima</label>
                <input type="text" class="form-control" id="thumbnail" name="thumbnail"
                    value="{{ old('thumbnail') }}" />
            </div>
            
            <textarea class="col-6 mt-3 ms-3" name="details" id="details" placeholder="Descrizione">{{ old('details') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Salva</button>
    </form>
@endsection