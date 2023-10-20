<div class="col-md-8">
    <h1>
        <a href="{{ route('community') }}" class="text-decoration-none">Community</a>
        @if($channel) - {{ $channel->title }} @endif
    </h1>
    @if(count($links))
        <ul class="list-style-none">
            @foreach ($links as $link)
                <li class="sx-padding my-padding lightgrey-border">
                    <a href="{{ $link->link }}" target="_blank">
                        {{ $link->title }}
                    </a>
                    <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>
                    <span class="label label-default" style="background: {{ $link->channel->color }}">
                        <a class="text-decoration-none" href="/community/{{ $link->channel->slug }}">
                            {{ $link->channel->title }}
                        </a>
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p>No approved contributions yet</p>
    @endif
</div>
