@extends('themes::themeffast.layout')

@push('header')
    <link rel="stylesheet" href="/themes/ffast/css/film.css">
@endpush

@section('content')
    <div class="container">
        <div class="player-wrapper" id="player-wrapper">
            @if(!$episode || $episode->link == "")
                <div style="background-image: url('{{$currentMovie->getPosterUrl()}}'); background-size: cover;" class="player-error-display">
                    <div style="background: #000000cf;width: 100%;height: 100%">
                        <i class="icon-alert"></i><span class="player-error-message">Phim đang được cập nhật</span>
                    </div>
                </div>
            @endif
        </div>
        @include('themes::themeffast.inc.sidebar')
        @include('themes::themeffast.inc.film_info')
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    {{-- <script src="/themes/ffast/player/js/p2p-media-loader-core.min.js"></script> --}}
    {{-- <script src="/themes/ffast/player/js/p2p-media-loader-hlsjs.min.js"></script> --}}

    {{-- <script src="/js/jwplayer-8.9.3.js"></script> --}}
    {{-- <script src="/js/hls.min.js"></script> --}}
    {{-- <script src="/js/jwplayer.hlsjs.min.js"></script> --}}

    <script src="/themes/ffast/player/skin/juicycodes.js"></script>
    <link href="/themes/ffast/player/skin/juicycodes.css" rel="stylesheet" type="text/css">

    <script src="/themes/ffast/player/jwplayer.js"></script>

    <script>
        jQuery(document).ready(function () {
            jQuery('html, body').animate({
                scrollTop: jQuery('#player-wrapper').offset().top
            }, 'slow');
        });
    </script>

    @if ($episode  && $episode->link != "")
        <script>
            var episode_id = {{$episode->id}};
            const wrapper = document.getElementById('player-wrapper');
            const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

            function chooseStreamingServer(el) {
                const type = el.dataset.type;
                const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
                const id = el.dataset.id;

                const newUrl =
                    location.protocol +
                    "//" +
                    location.host +
                    location.pathname.replace(`-${episode_id}`, `-${id}`);

                history.pushState({
                    path: newUrl
                }, "", newUrl);
                episode_id = id;


                Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                    server.classList.remove('active');
                })
                el.classList.add('active');

                renderPlayer(type, link, id);
            }

            function renderPlayer(type, link, id) {
                if (type == 'embed') {
                    if (vastAds) {
                        wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                        const fake_player = jwplayer("fake_jwplayer");
                        const objSetupFake = {
                            key: "{{ Setting::get('jwplayer_license') }}",
                            aspectratio: "16:9",
                            width: "100%",
                            file: "/themes/ffast/player/1s_blank.mp4",
                            volume: 100,
                            mute: false,
                            autostart: true,
                            advertising: {
                                tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                                client: "vast",
                                vpaidmode: "insecure",
                                skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                                skipmessage: "Bỏ qua sau xx giây",
                                skiptext: "Bỏ qua"
                            }
                        };
                        fake_player.setup(objSetupFake);
                        fake_player.on('complete', function (event) {
                            jQuery("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });

                        fake_player.on('adSkipped', function (event) {
                            jQuery("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });

                        fake_player.on('adComplete', function (event) {
                            jQuery("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });
                    } else {
                        if (wrapper) {
                            wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        }
                    }
                    return;
                }

                if (type == 'm3u8' || type == 'mp4') {
                    wrapper.innerHTML = `<div id="jwplayer"></div>`;
                    const player = jwplayer("jwplayer");
                    const objSetup = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        image: "{{ $currentMovie->getPosterUrl() }}",
                        file: link,
                        autostart: true,
                        controls: true,
                        primary: "html5",
                        playbackRateControls: true,
                        playbackRates: [0.5, 0.75, 1, 1.5, 2],
                        // sharing: {
                        //     sites: [
                        //         "reddit",
                        //         "facebook",
                        //         "twitter",
                        //         "googleplus",
                        //         "email",
                        //         "linkedin",
                        //     ],
                        // },
                        volume: 100,
                        mute: false,
                        logo: {
                            file: "{{ Setting::get('jwplayer_logo_file') }}",
                            link: "{{ Setting::get('jwplayer_logo_link') }}",
                            position: "{{ Setting::get('jwplayer_logo_position') }}",
                        },
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua",
                            admessage: "Quảng cáo còn xx giây."
                        },
                        tracks: [
                            {
                                "file": "/sub.vtt",
                                "kind": "captions",
                                label: "VN",
                                default: "true"
                            }
                        ],
                    };

                    if (type == 'm3u8') {
                        const segments_in_queue = 50;

                        var engine_config = {
                            debug: !1,
                            segments: {
                                forwardSegmentCount: 50,
                            },
                            loader: {
                                cachedSegmentExpiration: 864e5,
                                cachedSegmentsCount: 1e3,
                                requiredSegmentsPriority: segments_in_queue,
                                httpDownloadMaxPriority: 9,
                                httpDownloadProbability: 0.06,
                                httpDownloadProbabilityInterval: 1e3,
                                httpDownloadProbabilitySkipIfNoPeers: !0,
                                p2pDownloadMaxPriority: 50,
                                httpFailedSegmentTimeout: 500,
                                simultaneousP2PDownloads: 20,
                                simultaneousHttpDownloads: 2,
                                // httpDownloadInitialTimeout: 12e4,
                                // httpDownloadInitialTimeoutPerSegment: 17e3,
                                httpDownloadInitialTimeout: 0,
                                httpDownloadInitialTimeoutPerSegment: 17e3,
                                httpUseRanges: !0,
                                maxBufferLength: 300,
                                // useP2P: false,
                            },
                        };
                        // if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        //     var engine = new p2pml.hlsjs.Engine(engine_config);
                        //     player.setup(objSetup);
                        //     jwplayer_hls_provider.attach();
                        //     p2pml.hlsjs.initJwPlayer(player, {
                        //         liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                        //         maxBufferLength: 300,
                        //         loader: engine.createLoaderClass(),
                        //     });
                        // } else {
                            player.setup(objSetup);
                        // }
                    } else {
                        player.setup(objSetup);
                    }

                    player.addButton('<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind2" viewBox="0 0 240 240" focusable="false"><path d="m 25.993957,57.778 v 125.3 c 0.03604,2.63589 2.164107,4.76396 4.8,4.8 h 62.7 v -19.3 h -48.2 v -96.4 H 160.99396 v 19.3 c 0,5.3 3.6,7.2 8,4.3 l 41.8,-27.9 c 2.93574,-1.480087 4.13843,-5.04363 2.7,-8 -0.57502,-1.174985 -1.52502,-2.124979 -2.7,-2.7 l -41.8,-27.9 c -4.4,-2.9 -8,-1 -8,4.3 v 19.3 H 30.893957 c -2.689569,0.03972 -4.860275,2.210431 -4.9,4.9 z m 163.422413,73.04577 c -3.72072,-6.30626 -10.38421,-10.29683 -17.7,-10.6 -7.31579,0.30317 -13.97928,4.29374 -17.7,10.6 -8.60009,14.23525 -8.60009,32.06475 0,46.3 3.72072,6.30626 10.38421,10.29683 17.7,10.6 7.31579,-0.30317 13.97928,-4.29374 17.7,-10.6 8.60009,-14.23525 8.60009,-32.06475 0,-46.3 z m -17.7,47.2 c -7.8,0 -14.4,-11 -14.4,-24.1 0,-13.1 6.6,-24.1 14.4,-24.1 7.8,0 14.4,11 14.4,24.1 0,13.1 -6.5,24.1 -14.4,24.1 z m -47.77056,9.72863 v -51 l -4.8,4.8 -6.8,-6.8 13,-12.99999 c 3.02543,-3.03598 8.21053,-0.88605 8.2,3.4 v 62.69999 z"></path></svg>', "Forward 10 Seconds", () => player.seek(player.getPosition() + 10), "Forward 10 Seconds");
                    player.addButton('<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind" viewBox="0 0 240 240" focusable="false"><path d="M113.2,131.078a21.589,21.589,0,0,0-17.7-10.6,21.589,21.589,0,0,0-17.7,10.6,44.769,44.769,0,0,0,0,46.3,21.589,21.589,0,0,0,17.7,10.6,21.589,21.589,0,0,0,17.7-10.6,44.769,44.769,0,0,0,0-46.3Zm-17.7,47.2c-7.8,0-14.4-11-14.4-24.1s6.6-24.1,14.4-24.1,14.4,11,14.4,24.1S103.4,178.278,95.5,178.278Zm-43.4,9.7v-51l-4.8,4.8-6.8-6.8,13-13a4.8,4.8,0,0,1,8.2,3.4v62.7l-9.6-.1Zm162-130.2v125.3a4.867,4.867,0,0,1-4.8,4.8H146.6v-19.3h48.2v-96.4H79.1v19.3c0,5.3-3.6,7.2-8,4.3l-41.8-27.9a6.013,6.013,0,0,1-2.7-8,5.887,5.887,0,0,1,2.7-2.7l41.8-27.9c4.4-2.9,8-1,8,4.3v19.3H209.2A4.974,4.974,0,0,1,214.1,57.778Z"></path></svg>', "Rewind 10 Seconds", () => player.seek(player.getPosition() - 10), "Rewind 10 Seconds");


                    const resumeData = 'OPCMS-PlayerPosition-' + id;
                    player.on('ready', function () {
                        if (typeof (Storage) !== 'undefined') {
                            if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                                console.log("No cookie for position found");
                                var currentPosition = 0;
                            } else {
                                if (localStorage[resumeData] == "null") {
                                    localStorage[resumeData] = 0;
                                } else {
                                    var currentPosition = localStorage[resumeData];
                                }
                                console.log("Position cookie found: " + localStorage[resumeData]);
                            }
                            player.once('play', function () {
                                console.log('Checking position cookie!');
                                console.log(Math.abs(player.getDuration() - currentPosition));
                                if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                    5) {
                                    player.seek(currentPosition);
                                }
                            });
                            window.onunload = function () {
                                localStorage[resumeData] = player.getPosition();
                            }
                        } else {
                            console.log('Your browser is too old!');
                        }
                    });

                    player.on('complete', function () {
                        if (typeof (Storage) !== 'undefined') {
                            localStorage.removeItem(resumeData);
                        } else {
                            console.log('Your browser is too old!');
                        }
                    })

                    function formatSeconds(seconds) {
                        var date = new Date(1970, 0, 1);
                        date.setSeconds(seconds);
                        return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                    }
                }
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const episode = '{{$episode->id}}';
                let playing = document.querySelector(`[data-id="${episode}"]`);
                if (playing) {
                    playing.click();
                    return;
                }

                const servers = document.getElementsByClassName('streaming-server');
                if (servers[0]) {
                    servers[0].click();
                }
            });
        </script>

        <script>
            $('.film-report').on('click', function() {
                fetch("{{ route('episodes.report', ['movie' => $currentMovie->slug, 'episode' => $episode->slug, 'id' => $episode->id]) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        message: ''
                    })
                }).then((response) => {
                    $(this).remove();
                    alert("Báo cáo của bạn đã được gửi đi!");
                });
            })
        </script>
    @endif
    <link href="{{ asset('/themes/ffast/libs/jquery-raty/jquery.raty.css') }}" rel="stylesheet"/>
    <script src="{{ asset('/themes/ffast/libs/jquery-raty/jquery.raty.js') }}"></script>

    <script src="{{ asset('/themes/ffast/js/film.js') }}"></script>
    <script>
        var rated = false;
        jQuery(document).ready(function ($) {
            $('#star').raty({
                number: 10,
                starHalf: '/themes/ffast/libs/jquery-raty/images/star-half.png',
                starOff: '/themes/ffast/libs/jquery-raty/images/star-off.png',
                starOn: '/themes/ffast/libs/jquery-raty/images/star-on.png',
                click: function (score, evt) {
                    if (!rated) {
                        $.ajax({
                            url: '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}',
                            data: JSON.stringify({
                                rating: score
                            }),
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')
                                    .getAttribute(
                                        'content')
                            },
                            type: 'post',
                            dataType: 'json',
                            success: function (res) {
                                alert("Đánh giá của bạn đã được gửi đi!");
                                rated = true;
                            }
                        });
                    }
                }
            });
        })
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
