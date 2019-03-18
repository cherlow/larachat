@extends('layouts.master')

@section('content')
<div class="container mt-4">
        <div class="card">
                <div class="card-body">
                    <p class="lead text-center card-text">LaraChat App</p>
                </div>
            </div>
    <router-view></router-view>
</div>
@endsection
