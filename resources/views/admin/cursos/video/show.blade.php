<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $video->nombre }} | CodeTech</title>
    <link rel="shortcut icon" href="" type="image/png">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
    <link rel="stylesheet" href="https://use.typekit.net/tlw5aua.css">
    <style>
        *{
            outline:0!important
        }
        body{
            height:100vh;
            width:100%;
            margin:0;
            margin:0;
            background-color:#ffffff
        }
        html{
            height:100vh;
            width:100vw;
        }
        .plyr{
            height: 100vh;
        }
        :root {
            --plyr-color-main: #f75757;
            --plyr-font-family: "lato", sans-serif;
        }
        .plyr__control.plyr__control--overlaid svg{
            left: 0;
        }
        .plyr__progress input[type=range] {
            cursor: pointer;
        }
        .plyr__controls__item.plyr__control{
            transition: all .5s ease-in-out;
        }
        .plyr__controls .plyr__progress input:focus ~ .plyr__progress__buffer{
            box-shadow:0 0 0 5px rgba(247,87,87,.5);
            outline:0
        }
        .plyr__volume input[type=range]{
            height: 5px;
        }
        .plyr__volume input[type=range]:focus{
            box-shadow: 0 0 0 5px rgba(247, 87, 87,.5) ;
        }
        .plyr__controls .plyr__progress__container {
            flex: 1;
            min-width: 0;
            position: absolute;
            bottom: 40px;
            width: 100%;
            padding-left: 5px!important;
            padding-right: 5px!important;
            margin-left: 0!important;
            margin-right: 0!important;
            left: 0!important;
        }

        @media (min-width: 480px){
            .plyr--video .plyr__controls {
                padding: 35px 10px 5px;
            }
        }

        @media (min-width: 400px){
            .plyr__controls .plyr__progress__container {
                bottom: 35px;
            }
        }

        .plyr__controls .plyr__controls__item:first-child {
            margin-left: 0;
            margin-right: 0;
        }
        .plyr__controls .plyr__controls__item.plyr__time--duration {
            padding: 0 5px;
            margin-right: auto;
        }
        .plyr__control--overlaid svg {
            width: 18px;
            height: 18px;
        }
        .plyr__control--overlaid{
            padding: 30px;
        }
        .plyr__control--overlaid:focus, .plyr__control--overlaid:hover {
            background: rgba(247,87,87,.5)!important;
            transform: translate(-50%,-50%) scale(1.3);
        }
        .plyr--video a.plyr__control:hover, .plyr--video button:not(.plyr__control--overlaid).plyr__control:hover {
            box-shadow: 0 0 10px 5px rgba(247,87,87,0.5);
            -webkit-box-shadow: 0 0 10px 5px rgba(247,87,87,0.5);
            -moz-box-shadow: 0 0 10px 5px rgba(247,87,87,0.5);
        }
        .plyr .plyr-dock-text {
            color: #fff;
            left: 0;
            margin: 0;
            width: 100%;
            background: rgba(0,0,0,.8);
            background: linear-gradient(to bottom,rgba(0,0,0,.8) 0,rgba(0,0,0,.7) 30%,rgba(0,0,0,.65) 65%,rgba(0,0,0,0) 100%);
            padding: 1em 25% 2em 1em;
        }
        .plyr .plyr-dock-text {
            opacity: 1;
            font-size: 18px;
            font-family: var(--plyr-font-family);
            pointer-events: none;
            position: absolute;
            top: 0;
            transition: opacity 1s;
            z-index: 1;
        }
        .plyr .plyr-dock-title {
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.333;
            margin-bottom: 0.333em;
        }
        .plyr .plyr-dock-title {
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .plyr .plyr-logo-div{
            position: absolute;
            right: 20px;
            bottom: 60px;
            z-index: 1;
            background-color: rgba(255,255,255,.7);
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            opacity: 1;
            transition: opacity .4s ease-in-out,transform .4s ease-in-out,opacity .4s ease-in-out;
            width: 5%
        }
        .plyr .plyr-logo-div img,.plyr .plyr-logo-div .plyr-logo-link{
            width: 100%;
            height: 100%;
        }
        .plyr .plyr-logo-div .plyr-logo-link{
            display: flex;
        }
        .plyr.plyr--hide-controls .plyr-logo-div{
            opacity: 0;
            transform: translateX(100%);
        }
    </style>
</head>
<body>
    <video id="player" controls data-poster="/storage/files/{{ $video->poster }}">
        @php
            $videos = explode(';', $video->videos);
            $calidad = explode(',', $video->calidad);
        @endphp
        @foreach ($videos as $key => $vid)
            <source src="{{ $vid }}" type="video/{{ $video->extension }}" size="{{ $calidad[$loop->index] }}" />
        @endforeach
        
        @foreach(explode(';', $video->subtitulos) as $subtitulo)
            @php
                preg_match('/vtt\/subtitulos_(\w{2})_(\w+)\.vtt/', $subtitulo, $matches);
                $lang = isset($matches[1]) ? $matches[1] : 'Desconocido';
                $label = isset($matches[2]) ? $matches[2] : 'Desconocido';
            @endphp
            <track kind="captions" label="{{ $label }}" src="/storage/files/{{ $subtitulo }}" srclang="{{ $lang }}" @if ($lang == 'en') default @endif>
        @endforeach
    </video>
    
    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
    <script>
        const options = {
            enabled: true,
            title: '{{ $video->nombre }}',
            debug: false,
            autoplay: false,
            autopause: false,
            playsinline: true,
            seekTime: 5,
            volume: 70,
            muted: false,
            duration: null,
            displayDuration: true,
            invertTime: true,
            toggleInvert: true,
            ratio: null,
            clickToPlay: true,
            hideControls: true,
            resetOnEnd: false,
            disableContextMenu: true,
            loadSprite: true,
            iconPrefix: 'plyr',
            iconUrl: "{{ asset('admin/assets/img/svg/player.svg') }}",
            blankVideo: 'https://cdn.plyr.io/static/blank.mp4',
            quality: {
                default: 720,
                options: [4320, 2880, 2160, 1440, 1080, 720, 576, 480, 360, 240, 144],
                forced: false,
                onChange: null,
            },
            loop: {
                active: false,
            },

            speed: {
                selected: 1,
                options: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
            },
            keyboard: {
                focused: true,
                global: false,
            },
            tooltips: {
                controls: true, 
                seek: true,
            },

            captions: {
                active: true,
                language: 'auto',
                update: false,
            },
            fullscreen: {
                enabled: true,
                fallback: true,
                iosNative: false, 
            },
            storage: {
                enabled: true,
                key: 'plyr',
            },
            controls: [
                'play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'mute',
                'volume',
                'progress',
                'current-time',
                'duration',
                'captions',
                'settings',
                'pip',
                'airplay',
                'download',
                'fullscreen',
            ],
            settings: ['captions', 'quality', 'speed'],
            i18n: {
                restart: 'Restart',
                rewind: 'Rewind {seektime}s',
                play: 'Play',
                pause: 'Pause',
                fastForward: 'Forward {seektime}s',
                seek: 'Seek',
                seekLabel: '{currentTime} of {duration}',
                played: 'Played',
                buffered: 'Buffered',
                currentTime: 'Current time',
                duration: 'Duration',
                volume: 'Volume',
                mute: 'Mute',
                unmute: 'Unmute',
                enableCaptions: 'Enable captions',
                disableCaptions: 'Disable captions',
                download: 'Download',
                enterFullscreen: 'Enter fullscreen',
                exitFullscreen: 'Exit fullscreen',
                frameTitle: 'Player for {title}',
                captions: 'Captions',
                settings: 'Settings',
                pip: 'Picture-in-Picture',
                menuBack: 'Go back to previous menu',
                speed: 'Speed',
                normal: 'Normal',
                quality: 'Quality',
                loop: 'Loop',
                start: 'Start',
                end: 'End',
                all: 'All',
                reset: 'Reset',
                disabled: 'Disabled',
                enabled: 'Enabled',
                advertisement: 'Ad',
                qualityBadge: {
                    2160: '4K',
                    1440: '4K',
                    1080: '4K',
                    720: 'HD',
                    576: 'HD',
                    480: 'HD',
                    360: 'SD',
                    240: 'SD',
                    144: 'SD',
                },
            },
            urls: {
                download: null,
                vimeo: {
                    sdk: 'https://player.vimeo.com/api/player.js',
                    iframe: 'https://player.vimeo.com/video/{0}?{1}',
                    api: 'https://vimeo.com/api/oembed.json?url={0}',
                },
                youtube: {
                    sdk: 'https://www.youtube.com/iframe_api',
                    api: 'https://noembed.com/embed?url=https://www.youtube.com/watch?v={0}',
                },
                googleIMA: {
                    sdk: 'https://imasdk.googleapis.com/js/sdkloader/ima3.js',
                },
            },

            // Custom control listeners
            listeners: {
                seek: null,
                play: null,
                pause: null,
                restart: null,
                rewind: null,
                fastForward: null,
                mute: null,
                volume: null,
                captions: null,
                download: null,
                fullscreen: null,
                pip: null,
                airplay: null,
                speed: null,
                quality: null,
                loop: null,
                language: null,
            },
            events: [
                'ended',
                'progress',
                'stalled',
                'playing',
                'waiting',
                'canplay',
                'canplaythrough',
                'loadstart',
                'loadeddata',
                'loadedmetadata',
                'timeupdate',
                'volumechange',
                'play',
                'pause',
                'error',
                'seeking',
                'seeked',
                'emptied',
                'ratechange',
                'cuechange',

                // Custom events
                'download',
                'enterfullscreen',
                'exitfullscreen',
                'captionsenabled',
                'captionsdisabled',
                'languagechange',
                'controlshidden',
                'controlsshown',
                'ready',

                // YouTube
                'statechange',

                // Quality
                'qualitychange',

                // Ads
                'adsloaded',
                'adscontentpause',
                'adscontentresume',
                'adstarted',
                'adsmidpoint',
                'adscomplete',
                'adsallcomplete',
                'adsimpression',
                'adsclick',
            ],
            selectors: {
                editable: 'input, textarea, select, [contenteditable]',
                container: '.plyr',
                controls: {
                    container: null,
                    wrapper: '.plyr__controls',
                },
                labels: '[data-plyr]',
                buttons: {
                    play: '[data-plyr="play"]',
                    pause: '[data-plyr="pause"]',
                    restart: '[data-plyr="restart"]',
                    rewind: '[data-plyr="rewind"]',
                    fastForward: '[data-plyr="fast-forward"]',
                    mute: '[data-plyr="mute"]',
                    captions: '[data-plyr="captions"]',
                    download: '[data-plyr="download"]',
                    fullscreen: '[data-plyr="fullscreen"]',
                    pip: '[data-plyr="pip"]',
                    airplay: '[data-plyr="airplay"]',
                    settings: '[data-plyr="settings"]',
                    loop: '[data-plyr="loop"]',
                },
                inputs: {
                    seek: '[data-plyr="seek"]',
                    volume: '[data-plyr="volume"]',
                    speed: '[data-plyr="speed"]',
                    language: '[data-plyr="language"]',
                    quality: '[data-plyr="quality"]',
                },
                display: {
                    currentTime: '.plyr__time--current',
                    duration: '.plyr__time--duration',
                    buffer: '.plyr__progress__buffer',
                    loop: '.plyr__progress__loop', // Used later
                    volume: '.plyr__volume--display',
                },
                progress: '.plyr__progress',
                captions: '.plyr__captions',
                caption: '.plyr__caption',
            },
            classNames: {
                type: 'plyr--{0}',
                provider: 'plyr--{0}',
                video: 'plyr__video-wrapper',
                embed: 'plyr__video-embed',
                videoFixedRatio: 'plyr__video-wrapper--fixed-ratio',
                embedContainer: 'plyr__video-embed__container',
                poster: 'plyr__poster',
                posterEnabled: 'plyr__poster-enabled',
                ads: 'plyr__ads',
                control: 'plyr__control',
                controlPressed: 'plyr__control--pressed',
                playing: 'plyr--playing',
                paused: 'plyr--paused',
                stopped: 'plyr--stopped',
                loading: 'plyr--loading',
                hover: 'plyr--hover',
                tooltip: 'plyr__tooltip',
                cues: 'plyr__cues',
                marker: 'plyr__progress__marker',
                hidden: 'plyr__sr-only',
                hideControls: 'plyr--hide-controls',
                isIos: 'plyr--is-ios',
                isTouch: 'plyr--is-touch',
                uiSupported: 'plyr--full-ui',
                noTransition: 'plyr--no-transition',
                display: {
                    time: 'plyr__time',
                },
                menu: {
                    value: 'plyr__menu__value',
                    badge: 'plyr__badge',
                    open: 'plyr--menu-open',
                },
                captions: {
                    enabled: 'plyr--captions-enabled',
                    active: 'plyr--captions-active',
                },
                fullscreen: {
                    enabled: 'plyr--fullscreen-enabled',
                    fallback: 'plyr--fullscreen-fallback',
                },
                pip: {
                    supported: 'plyr--pip-supported',
                    active: 'plyr--pip-active',
                },
                airplay: {
                    supported: 'plyr--airplay-supported',
                    active: 'plyr--airplay-active',
                },
                tabFocus: 'plyr__tab-focus',
                previewThumbnails: {
                    // Tooltip thumbs
                    thumbContainer: 'plyr__preview-thumb',
                    thumbContainerShown: 'plyr__preview-thumb--is-shown',
                    imageContainer: 'plyr__preview-thumb__image-container',
                    timeContainer: 'plyr__preview-thumb__time-container',
                    // Scrubbing
                    scrubbingContainer: 'plyr__preview-scrubbing',
                    scrubbingContainerShown: 'plyr__preview-scrubbing--is-shown',
                },
            },
            attributes: {
                embed: {
                    provider: 'data-plyr-provider',
                    id: 'data-plyr-embed-id',
                    hash: 'data-plyr-embed-hash',
                },
            },
            ads: {
                enabled: false,
                publisherId: '',
                tagUrl: '',
            },
            previewThumbnails: {
                enabled: true,
                src: '/storage/frames/{{ $video->id }}/thumbnails.vtt',
            },
            vimeo: {
                byline: false,
                portrait: false,
                title: false,
                speed: true,
                transparent: false,
                customControls: true,
                referrerPolicy: null,
                premium: false,
            },
            youtube: {
                rel: 0,
                showinfo: 0,
                iv_load_policy: 3,
                modestbranding: 1,
                customControls: true,
                noCookie: false,
            },
            mediaMetadata: {
                title: '{{ $video->nombre }}',
                artist: 'CodeTech',
                album: 'CodeTechVideos',
                artwork: [],
            },
            markers: {
                enabled: true,
                points: [1, 10, 12.5, 15],
            },
        };

        const player = new Plyr('#player',options);
    </script>
    <script>
        window.onload = function () {
            const button = document.querySelector('button[data-plyr="restart"]');
            button.style.display = 'none';
            button.addEventListener('click',()=>{
                setTimeout(()=>{
                    button.style.display = 'none';
                },100);
            });
        }

        const cont = document.querySelector('.plyr');
        var title = options.title;
        d = document.createElement("div");
        d.className = "plyr-dock-text";
        h = document.createElement("div"); 
        h.className = "plyr-dock-title"
        h.setAttribute('title', title);
        c = document.createTextNode(title);
        h.appendChild(c);
        d.appendChild(h);
        cont.appendChild(d);
        id = document.createElement("div");
        id.className = "plyr-logo-div";
        li = document.createElement("a");
        li.className = "plyr-logo-link"
        li.setAttribute('href', "/");
        li.setAttribute('target', "_blank");
        li.setAttribute('rel', "noopener noreferrer");
        i = document.createElement("img"); 
        i.className = "plyr-logo-img"
        i.setAttribute('src', "{{ asset('admin/assets/img/logo-ct.png') }}");
        li.appendChild(i);
        id.appendChild(li);
        cont.appendChild(id);

        player.on('playing', (event) => {
            d.style.opacity = 0;
        });

        player.on('volumechange', (event) => {
            const volume = event.detail.plyr.volume;
            const button = document.querySelector('.plyr__volume button .icon--not-pressed use');
            if (volume <= 0.3) {
                var href = "{{ asset('admin/assets/img/svg/player.svg') }}#plyr-volume-down";
                button.setAttribute('href',href);
            } else{
                var href = "{{ asset('admin/assets/img/svg/player.svg') }}#plyr-volume"
                button.setAttribute('href',href);
            }
        });

        player.on('ended', (event) => {
            const button = document.querySelector('button[data-plyr="restart"]');
            button.style.display = 'block';
        });

        player.on('progress', (event) => {
            const button = document.querySelector('button[data-plyr="restart"]');
            if (event.detail.plyr.currentTime != event.detail.plyr.duration) {
                button.style.display = 'none';
            } else if (event.detail.plyr.currentTime == event.detail.plyr.duration) {
                button.style.display = 'block';
            }
        });
    </script>
</body>
</html>