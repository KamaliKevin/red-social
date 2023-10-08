<div class="col-md-8">
    <h1>Community</h1>
    @if(count($links))
        <ul class="list-style-none">
            @foreach ($links as $link)
                <li class="sx-padding my-padding lightgrey-border">
                    <a href="{{ $link->link }}" target="_blank">
                        {{ $link->title }}
                    </a>
                    <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>
                    <span class="label label-default" style="background: {{ $link->channel->color }}">
                        {{ $link->channel->title }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p>No approved contributions yet</p>
    @endif
</div>
