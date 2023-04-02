@extends('themes::themeffast.layout')

@push('header')
    <link rel="stylesheet" href="/themes/ffast/css/list.css">
    <link rel="stylesheet" href="/themes/ffast/css/list_filter.css">
@endpush

@section('content')
    <div class="container">
        <section class="tray ">
            <div class="tray-title">
                <span class="icon icon-cinema"></span>
                <h5>{{$section_name}}</h5>
            </div>
            <div class="tray-content">
                <div class="tray-left">
                    @if(count($data))
                        @foreach($data as $movie)
                            <div class="tray-item" id="film-id-{{$movie->id}}">
                                <a href="{{$movie->getUrl()}}">
                                    <img class="tray-item-thumbnail"
                                         src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                         data-src="{{$movie->thumb_url}}"
                                         alt="{{$movie->name}}">
                                    <div class="tray-item-description">
                                        <span class="tray-item-quality">{{$movie->quality}}</span>
                                        <span class="tray-item-point">
                                            <i class="icon-star"></i> {{number_format($movie->rating_star ?? 0, 1)}}/10
                                        </span>
                                        <div class="tray-item-title">{{$movie->name}}</div>
                                        <div class="tray-item-meta-info">
                                            <div class="tray-film-views">{{ffast_format_view($movie->view_total)}}xem
                                            </div>
                                            <div class="tray-film-likes">
                                                @if($movie->type == 'single')
                                                    {{$movie->episode_time ?? 'N/A'}}
                                                @else
                                                    {{$movie->episode_current }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tray-item-play-button">
                                        <i class="icon-play"></i>
                                    </div>
                                    <div class="tray-item-audio">{{$movie->language}}</div>
                                </a>
                                <div class="tray-item-trailer" data-id="{{$movie->id}}" title="Xem trailer">
                                    <i class="icon-youtube"></i>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Không có dữ liệu cho mục này.</p>
                    @endif
                </div>
                <div class="tray-right"></div>
            </div>
            <nav>
            </nav>
        </section>
    </div>
@endsection
