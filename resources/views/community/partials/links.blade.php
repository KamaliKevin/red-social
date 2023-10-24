<div class="col-md-8">
    <h1>
        <a href="{{ route('community') }}" class="text-decoration-none">Community</a>
        @if($channel) - {{ $channel->title }} @endif
    </h1>
    @if(count($links))
        <ul class="list-style-none">
            @foreach ($links as $link)
                <li class="sx-padding my-padding lightgrey-border">
                    <p>
                        <a href="{{ $link->link }}" target="_blank" class="me-2">{{ $link->title }}</a>
                        <span class="text-success fw-bold">{{ $link->users()->count() }} votes</span><br>
                        @if ($link->creator)
                            Contributed by: <span class="fw-bold">{{ $link->creator->name }}</span>
                            <small>| {{ $link->updated_at->diffForHumans() }}</small>
                        @else
                            Contributed by: <span class="fst-italic">(Deleted user)</span>
                            <small>| {{ $link->updated_at->diffForHumans() }}</small>
                        @endif
                    </p>
                    <a class="text-decoration-none me-2" href="/community/{{ $link->channel->slug }}">
                        <span class="label label-default p-1" style="background: {{ $link->channel->color }}">
                            {{ $link->channel->title }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No approved contributions yet</p>
    @endif
</div>
