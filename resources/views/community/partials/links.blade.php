<div class="col-md-8">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link {{request()->exists('popular') ? '' : 'disabled' }}" href="{{request()->url()}}">Most recent</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{request()->exists('popular') ? 'disabled' : '' }}"
               href="?{{ http_build_query(array_merge($_GET, ['popular' => ''])) }}">
                Most popular
            </a>
        </li>
    </ul>
    <h1>
        <a href="{{ route('community') }}" class="text-decoration-none">Community</a>
        @if($channel) - {{ $channel->title }} @endif
    </h1>
    @if(count($links))
        <ul class="list-style-none">
            @foreach ($links as $link)
                <li class="sx-padding my-padding lightgrey-border">
                    <div class="d-flex justify-content-start align-content-end mb-3">
                        <a href="{{ $link->link }}" target="_blank" class="me-2">{{ $link->title }}</a>
                        @if ($link->creator)
                            <label>
                                Contributed by: <span class="fw-bold">{{ $link->creator->name }}</span>
                                <small>| {{ $link->updated_at->diffForHumans() }}</small>
                            </label>
                        @else
                            <label>
                                Contributed by: <span class="fst-italic">(Deleted user)</span>
                                <small>| {{ $link->updated_at->diffForHumans() }}</small>
                            </label>
                        @endif
                    </div>
                    <div class="d-flex justify-content-start align-content-end">
                        <a class="text-decoration-none p-2 me-2" href="/community/{{ $link->channel->slug }}"
                           style="background: {{ $link->channel->color }}">
                                {{ $link->channel->title }}
                        </a>
                        <form method="POST" action="/votes/{{ $link->id }}">
                            {{ csrf_field() }}
                            <button
                                type="submit"
                                class="btn
                                {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}"
                                {{ Auth::guest() ? 'disabled' : '' }}>
                                <i class="fa-solid fa-thumbs-up"></i> {{$link->users()->count()}} votes
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>No approved contributions yet</p>
    @endif
</div>
