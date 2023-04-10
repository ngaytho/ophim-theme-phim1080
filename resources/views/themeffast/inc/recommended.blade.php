<div class="container">
    <section class="tray index top staff-pick">
        <div class="tray-title">
            <span class="icon icon-cinema"></span>
            <h5>
                <a href="/">Phim Đề Cử</a>
            </h5>
        </div>
        <div class="tray-content index">
            @foreach ($recommendations as $movie)
                @if ($loop->first)
                    <div class="hot-item">
                        <a href="{{ $movie->getUrl() }}">
                            <div class="hot-item-thumbnail">
                                <img
                                    src="{{$movie->getPosterUrl()}}">
                                <div class="hot-item-views">{{ ffast_format_view($movie->view_total) }} Views</div>
                            </div>
                            <div class="tray-item-description">
                                <span class="tray-item-quality">{{$movie->quality}}</span>
                                <span class="hot-item-imdb">
                                    <i class="icon icon-star-double"></i> {{$movie->getRatingStar()}}/10 </span>
                                <span class="tray-item-point">
                                    <i class="icon-star"></i> {{$movie->getRatingStar()}}/10 </span>
                                <h3 class="hot-item-title">{{$movie->name}}</h3>
                                <h4 class="hot-item-name">{{$movie->origin_name}}</h4>
                                <div class="tray-item-meta-info">
                                    <div class="tray-film-views">{{ ffast_format_view($movie->view_total) }} Views</div>
                                    <div class="tray-film-likes"> {{$movie->episode_current}}</div>
                                </div>
                            </div>
                            <div class="tray-item-audio">{{$movie->language}}</div>
                        </a>
                    </div>
                @else
                    <div class="tray-item" id="film-id-{{ $movie->id }}">
                        <a href="{{ $movie->getUrl() }}">
                            <img class="tray-item-thumbnail pick-thumbnail"
                                 src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                 data-src="{{$movie->getThumbUrl()}}"
                                 alt="{{$movie->name}}">
                            <img class="tray-item-thumbnail pick-poster"
                                 src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                 data-src="{{$movie->getPosterUrl()}}"
                                 alt="{{$movie->name}}">
                            <div class="tray-item-description">
                                <span class="tray-item-quality">{{$movie->quality}}</span>
                                <span class="tray-item-point">
                                    <i class="icon-star"></i> {{$movie->getRatingStar()}}/10 </span>
                                <div class="tray-item-title">{{$movie->name}}</div>
                                <div class="tray-item-meta-info">
                                    <div class="tray-film-views">{{ ffast_format_view($movie->view_total) }} Views</div>
                                    <div class="tray-film-likes"> {{$movie->episode_current}}</div>
                                </div>
                            </div>
                            <div class="tray-item-audio">{{$movie->language}}</div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
</div>
