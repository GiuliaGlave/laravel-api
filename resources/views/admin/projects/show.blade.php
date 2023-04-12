@extends('layouts.app')


@section('title', 'Project Details')

@section('content')

<h1>dettaglio progetto</h1>
<div class="container">
    @dump($project)
</div>
@endsection