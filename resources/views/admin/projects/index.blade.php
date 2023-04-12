@extends('layouts.app')

@section('title', 'Project List')
@section('content')
<div class="container">

    <h1>tabella lista progetti</h1>
    @dump($projects)
</div>
@endsection