<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - Explore UMKM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg: #EFE6DB;
            --bg-soft: #F6F0E8;
            --surface: #FFFFFF;
            --text: #2B2621;
            --muted: #6E6258;

            --brown: #6B4B3E;
            --brown-2: #4B332B;
            --sand: #B28A62;

            --border: rgba(75,51,43,.14);
            --shadow: 0 10px 26px rgba(0,0,0,.08);

            --maxw: 1120px;
        }

        *{ box-sizing:border-box; }
        html{ scroll-behavior:smooth; }
        body{
            margin:0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            color: var(--text);
            background: var(--bg);
        }

        a, a:visited{ color: inherit; text-decoration:none; }
        a:hover{ text-decoration:none; }

        .container{
            width: min(100% - 32px, var(--maxw));
            margin-inline: auto;
        }

        /* ===================== HERO TOP ===================== */
        .hero{
            position: relative;
            min-height: 230px;
            padding: 120px 0 40px;
            overflow:hidden;
            color:#fff;
        }
        .hero-bg{
            position:absolute; inset:0;
            background:
                linear-gradient(180deg, rgba(44,30,24,.62) 0%, rgba(44,30,24,.58) 48%, rgba(44,30,24,.25) 100%),
                url("{{ asset('images/hero-bali.jpg') }}") center/cover no-repeat;
            filter: saturate(1.02) contrast(1.02);
        }
        .hero::after{
            content:"";
            position:absolute; inset:auto 0 0 0;
            height: 110px;
            background: linear-gradient(180deg, rgba(239,230,219,0) 0%, rgba(239,230,219,1) 100%);
        }

        /* ===================== NAVBAR ===================== */
        .nav{
            position: absolute;
            top: 0; left: 0; right: 0;
            z-index: 10;
            padding: 18px 0;
        }
        .nav-inner{
            display:grid;
            grid-template-columns: 1fr auto 1fr;
            align-items:center;
            gap: 18px;
        }
        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            font-weight: 800;
            letter-spacing: .6px;
            color: #fff;
        }
        .brand img{ height: 28px; width:auto; display:block; }

        .nav-links{
            display:flex;
            justify-content:center;
            gap: 22px;
            font-size: 13px;
            color: rgba(255,255,255,.88);
        }
        .nav-links a{
            position: relative;
            padding: 6px 2px;
            opacity: .92;
        }
        .nav-links a::after{
            content:"";
            position:absolute;
            left: 0;
            bottom: -6px;
            width: 100%;
            height: 2px;
            border-radius: 999px;
            background: rgba(255,255,255,.95);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .18s ease;
        }
        .nav-links a:hover{ opacity: 1; }
        .nav-links a:hover::after,
        .nav-links a.active::after{ transform: scaleX(1); }

        .nav-cta{
            display:flex;
            justify-content:flex-end;
            gap: 10px;
            align-items:center;
        }

        /* buttons landing */
        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 12.5px;
            border: 1px solid transparent;
            cursor: pointer;
            white-space: nowrap;
            transition: background .18s ease, color .18s ease, transform .18s ease, border-color .18s ease;
        }
        .btn:active{ transform: translateY(0); }

        .btn-ghost{
            background: rgba(255,255,255,.10);
            border-color: rgba(255,255,255,.22);
            color: #fff !important;
        }
        .btn-ghost:hover{
            background: rgba(255,255,255,.18);
            border-color: rgba(255,255,255,.30);
            transform: translateY(-1px);
        }
        .btn-ghost:active{ background: rgba(255,255,255,.25); }

        .btn-solid{
            background: #fff;
            color: var(--brown-2) !important;
            border-color: rgba(255,255,255,.25);
        }
        .btn-solid:hover{
            background: rgba(255,255,255,.92);
            transform: translateY(-1px);
        }
        .btn-solid:active{ background: rgba(255,255,255,.85); }

        /* ===================== CONTENT ===================== */
        .page{ padding: 44px 0 56px; }

        .headline{ text-align:center; margin-top: 10px; }
        .headline h1{
            margin:0 0 10px;
            font-family: "Playfair Display", serif;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .headline p{
            margin:0 auto;
            max-width: 86ch;
            font-size: 12.5px;
            line-height: 1.7;
            color: rgba(43,38,33,.78);
        }

        .search-wrap{ max-width: 760px; margin: 28px auto 18px; }
        .search{
            width:100%;
            height: 52px;
            border-radius: 14px;
            border: 1px solid rgba(75,51,43,.25);
            padding: 0 18px 0 44px;
            outline:none;
            font-size: 13px;
            color: var(--text);
            background:#fff;
        }
        .search:focus{
            border-color: rgba(178,138,98,.80);
            box-shadow: 0 0 0 4px rgba(178,138,98,.16);
        }
        .search-ico{ position: relative; }
        .search-ico::before{
            content:"🔍";
            position:absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            opacity:.7;
        }

        /* ================= FILTERS ================= */
        .filters{
            display:flex;
            gap: 14px;
            justify-content:center;
            flex-wrap:wrap;
            margin: 22px 0 30px;
        }
        .pill{
            min-width: 140px;
            height: 42px;
            padding: 0 18px;
            border-radius: 10px;
            border: 1px solid rgba(75,51,43,.25);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size: 12px;
            font-weight: 600;
            color: rgba(43,38,33,.80);
            background: #fff;
            transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
        }
        .pill:hover{
            background: rgba(107,75,62,.08);
            border-color: rgba(107,75,62,.45);
            transform: translateY(-1px);
        }
        .pill:active{ transform: translateY(0); }
        .pill.active{
            background: var(--sand);
            border-color: var(--sand);
            color:#fff;
            font-weight: 700;
        }
        .pill.active:hover{
            background: var(--brown);
            border-color: var(--brown);
        }

        /* ================= GRID & CARDS ================= */
        .grid{
            width: min(100%, 980px);
            margin: 0 auto;
            display:grid;
            grid-template-columns: repeat(3, 1fr);

            /* FIX: gap lebih enak */
            gap: 26px;
        }

        .card{
            background:#fff;
            border-radius: 18px;
            border: 1px solid rgba(75,51,43,.14);
            box-shadow: 0 10px 18px rgba(0,0,0,.10);
            overflow:hidden;
        }

        .media{
            height: 190px;
            background: #ddd center/cover no-repeat;
            position: relative;
        }

        .badge{
            position:absolute;
            top: 12px; left: 12px;
            font-size: 10px;
            font-weight: 800;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(39,32,28,.70);
            color:#fff;
            border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(6px);
        }

        /* FIX: spacing card + tombol nempel bawah */
        .body{
            padding: 14px 16px 16px;
            display:flex;
            flex-direction:column;

            /* FIX: jarak antar elemen supaya rapi kayak contoh */
            gap: 8px;

            /* biar tombol selalu rata bawah */
            min-height: 235px;
        }

        .rate{
            display:flex;
            align-items:center;
            gap: 6px;
            font-size: 11px;
            color: rgba(43,38,33,.72);

            /* FIX: jangan pakai margin-bottom lagi karena sudah gap */
            margin: 0;
        }
        .star{ color: #D3A24C; font-weight: 900; }

        .title{
            /* FIX: rapihin margin */
            margin: 0;
            font-family:"Playfair Display", serif;
            font-size: 20px;
            font-weight: 700;
            color: rgba(43,38,33,.92);
        }
        .meta{
            /* FIX: rapihin margin */
            margin: 0;
            font-size: 10.5px;
            color: rgba(43,38,33,.55);
        }
        .desc{
            /* FIX: rapihin margin */
            margin: 0;
            font-size: 11px;
            line-height: 1.6;
            color: rgba(43,38,33,.62);
            min-height: 44px;
        }

        .author{
            /* FIX: rapihin margin supaya tidak “naik” */
            margin: 2px 0 0;

            display:flex;
            align-items:center;
            gap: 8px;
            color: rgba(43,38,33,.60);
            font-size: 10.5px;
        }
        .ava{
            width: 18px; height: 18px;
            border-radius: 999px;
            background: rgba(178,138,98,.25);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            flex: 0 0 18px;
        }
        .ava img{
            width:100%; height:100%;
            object-fit:cover;
            display:block;
        }

        /* FIX UTAMA: tombol terlalu tinggi -> samakan kayak contoh */
        .btn-detail{
            margin-top: auto;          /* tetap nempel bawah */
            width: 100%;

            /* FIX: lebih pendek */
            height: 34px;              /* sebelumnya 38px */
            border-radius: 8px;
            padding: 0 12px;

            background: var(--brown);
            color:#fff !important;
            font-weight: 800;
            font-size: 10.5px;         /* lebih pas */
            letter-spacing: .2px;

            display:flex;
            align-items:center;
            justify-content:center;
            transition: background .18s ease, transform .18s ease;
        }
        .btn-detail:hover{ background: var(--brown-2); transform: translateY(-1px); }
        .btn-detail:active{ background: #36231D; transform: translateY(0); }

        /* ================= PAGINATION ================= */
        .pager{
            width: min(100%, 980px);
            margin: 18px auto 0;
            display:flex;
            justify-content:flex-end;
            gap: 8px;
            align-items:center;
        }
        .pg{
            height: 28px;
            padding: 0 14px;
            border-radius: 6px;
            border: 1px solid rgba(75,51,43,.22);
            background:#fff;
            font-size: 11px;
            color: rgba(43,38,33,.75);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width: 38px;
        }
        .pg.active{
            background: #3A2A25;
            border-color: #3A2A25;
            color:#fff;
            font-weight: 900;
        }

        /* ================= FOOTER ================= */
        footer{
            background: #2F2F2F;
            color: rgba(255,255,255,.72);
            padding: 46px 0 18px;
            margin-top: 44px;
        }
        .footer-inner{
            display:grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr;
            gap: 28px;
            align-items:start;
        }
        .footer-logo img{
            height: 28px;
            width:auto;
            display:block;
            margin-bottom: 12px;
        }
        .footer-title{
            color:#fff;
            font-weight: 800;
            margin: 0 0 12px;
            font-size: 13px;
        }
        .footer p{ margin:0; font-size: 12px; line-height: 1.7; }
        .footer-links{ display:flex; flex-direction:column; gap: 10px; font-size: 12px; }
        .footer-links a{ color: rgba(255,255,255,.70); }
        .footer-links a:hover{ color:#fff; text-decoration: underline; text-underline-offset: 6px; }

        .footer-bottom{
            text-align:center;
            padding-top: 18px;
            margin-top: 18px;
            border-top: 1px solid rgba(255,255,255,.10);
            font-size: 11px;
            color: rgba(255,255,255,.55);
        }

        @media (max-width: 980px){
            .nav-inner{ grid-template-columns: 1fr auto; }
            .nav-links{ display:none; }
            .grid{ grid-template-columns: 1fr; width: min(100%, 720px); }
            .pager{ width: min(100%, 720px); justify-content:center; }
            .footer-inner{ grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px){
            .headline h1{ font-size: 28px; }
            .footer-inner{ grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<section class="hero">
    <div class="hero-bg" aria-hidden="true"></div>

    <header class="nav">
        <div class="container">
            <div class="nav-inner">
                <a href="{{ route('landing-page') }}" class="brand" aria-label="Lokana">
                    <img src="{{ asset('images/logo.png') }}" alt="Lokana Logo">
                </a>

                <nav class="nav-links" aria-label="Main">
                    <a href="{{ route('landing-page') }}#home">Home</a>
                    <a href="{{ route('landing-page') }}#articles">Article</a>
                    <a class="active" href="{{ route('explore.umkm') }}">Explore</a>
                    <a href="{{ route('landing-page') }}#about">About Us</a>
                    <a href="{{ route('faq.page') }}">FAQ</a>
                </nav>

                <div class="nav-cta">
                    <a class="btn btn-ghost" href="{{ route('register.index') }}">Sign up</a>
                    <a class="btn btn-solid" href="{{ route('login.index') }}">Sign in</a>
                </div>
            </div>
        </div>
    </header>
</section>

<main class="page">
    <div class="container">

        <div class="headline">
            <h1>Discover Local MSME Products from Bali</h1>
            <p>
                getting to know and supporting the flagship products of local Bali MSMEs that are rich in cultural value,
                creativity, and quality. From handicrafts to culinary products, each creation reflects local wisdom and
                the uniqueness of the Island of the Gods.
            </p>
        </div>

        <div class="search-wrap">
            <div class="search-ico">
                <input class="search" type="text" placeholder="Search for MSME">
            </div>
        </div>

        <div class="filters">
            @foreach($categories as $idx => $cat)
                <a class="pill {{ $idx === 0 ? 'active' : '' }}" href="#">{{ $cat }}</a>
            @endforeach
        </div>

        <div class="grid">
            @php
                // pastikan selalu 6 card
                $list = $items ?? [];
                if (count($list) < 6) {
                    $need = 6 - count($list);
                    for ($k=0; $k<$need; $k++){
                        $list[] = [
                            'image' => asset('images/product-1.jpg'),
                            'badge' => 'HandCraft',
                            'rating' => '4.9',
                            'reviews' => '59 reviews',
                            'title' => "Bali’s Traditional Craft",
                            'products' => '38 Products',
                            'views' => '6.2k views',
                            'desc' => "At Bali’s Craft, we believe that greatness starts from small, meaningful steps. Established in [Tahun Berdiri], we are a local.",
                            'author' => 'Pande Sujana',
                            'avatar' => asset('images/avatar.jpg'),
                            'url' => '#',
                        ];
                    }
                }
            @endphp

            @foreach($list as $it)
                <article class="card">
                    <div class="media" style="background-image:url('{{ $it['image'] }}')">
                        <span class="badge">{{ $it['badge'] }}</span>
                    </div>

                    <div class="body">
                        <div class="rate">
                            <span class="star">★</span>
                            <span><strong>{{ $it['rating'] }}</strong> ({{ $it['reviews'] }})</span>
                        </div>

                        <div class="title">{{ $it['title'] }}</div>
                        <div class="meta">{{ $it['products'] }} &nbsp; • &nbsp; {{ $it['views'] }}</div>

                        <div class="desc">{{ $it['desc'] }}</div>

                        <div class="author">
                            <span class="ava">
                                @if(!empty($it['avatar']))
                                    <img src="{{ $it['avatar'] }}" alt="avatar">
                                @else
                                    <img src="{{ asset('images/avatar.jpg') }}" alt="avatar">
                                @endif
                            </span>
                            <span>By {{ $it['author'] }}</span>
                        </div>

                        <a class="btn-detail" href="{{ $it['url'] }}">View Detail</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="pager">
            <a class="pg" href="#">Previous</a>
            <a class="pg active" href="#">1</a>
            <a class="pg" href="#">2</a>
            <a class="pg" href="#">3</a>
            <a class="pg" href="#">Next</a>
        </div>

    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-logo">
                <img src="{{ asset('images/logo-footer.png') }}" alt="Lokana Logo">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam.
                </p>
            </div>

            <div>
                <div class="footer-title">Explore</div>
                <div class="footer-links">
                    <a href="#">All MSME</a>
                    <a href="#">Meet Artisan</a>
                    <a href="#">Stories & Articles</a>
                    <a href="#">About Us</a>
                </div>
            </div>

            <div>
                <div class="footer-title">Quick Links</div>
                <div class="footer-links">
                    <a href="#">About Us</a>
                    <a href="#">Explore MSME</a>
                    <a href="#">Article</a>
                    <a href="{{ route('faq.page') }}">FAQ</a>
                </div>
            </div>

            <div>
                <div class="footer-title">Contact</div>
                <div class="footer-links">
                    <a href="#">St. Gadung No. 123 Denpasar</a>
                    <a href="#">+62 361 231-213</a>
                    <a href="#">lokana@gmail.com</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            © 2026 Lokana. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
