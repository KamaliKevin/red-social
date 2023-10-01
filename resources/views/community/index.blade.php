@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left colum to show all the links in the DB --}}
            @include('community.partials.links')
            {{-- Right colum to show the form to upload a link --}}
            @include('community.partials.add-link')
        </div>
        {{ $links->links() }}
    </div>
@stop
