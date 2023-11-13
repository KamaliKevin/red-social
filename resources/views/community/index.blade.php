@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left column to show all the links in the DB --}}
            @include('community.partials.links')
            {{-- Right column to show the form to upload a link --}}
            @include('community.partials.add-link')
        </div>
        {{ $links->appends($_GET)->links() }}
    </div>
@stop
