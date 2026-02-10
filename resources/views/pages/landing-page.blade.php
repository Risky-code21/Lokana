{{-- resources/views/landing-page.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - Landing Page</title>

    {{-- Font (mirip desain: heading serif, body sans) --}}
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

            --brown: #6B4B3E;     /* coklat muda */
            --brown-2: #4B332B;   /* coklat tua */
            --sand: #B28A62;

            --border: rgba(75,51,43,.14);
            --shadow: 0 10px 26px rgba(0,0,0,.08);

            --radius-xl: 22px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --maxw: 1120px;
        }

        *{ box-sizing: border-box; }
        html{ scroll-behavior:smooth; }
        body{
            margin:0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            color: var(--text);
            background: var(--bg);
        }
        a{ color: inherit; text-decoration: none; }
        img{ max-width:100%; display:block; }

        .container{
            width: min(100% - 32px, var(--maxw));
            margin-inline: auto;
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
        .brand .logo{
            width: 34px; height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            display:flex; align-items:center; justify-content:center;
            font-size: 12px;
        }

        .nav-links{
            display:flex;
            justify-content:center;
            gap: 22px;
            font-size: 13px;
            color: rgba(255,255,255,.88);
        }

        /* underline animasi + active */
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
        .nav-links a.active::after{
            transform: scaleX(1);
        }

        .nav-cta{
            display:flex;
            justify-content:flex-end;
            gap: 10px;
            align-items:center;
        }

        /* ===================== BUTTONS (hover + active) ===================== */
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
            transition: background .18s ease, color .18s ease, transform .18s ease, border-color .18s ease, filter .18s ease;
        }
        .btn:active{ transform: translateY(0); }

        .btn-ghost{
            background: rgba(255,255,255,.10);
            border-color: rgba(255,255,255,.22);
            color: #fff;
        }
        .btn-ghost:hover{
            background: rgba(255,255,255,.18);
            border-color: rgba(255,255,255,.30);
            transform: translateY(-1px);
        }
        .btn-ghost:active{
            background: rgba(255,255,255,.25);
        }

        .btn-solid{
            background: #fff;
            color: var(--brown-2);
            border-color: rgba(255,255,255,.25);
        }
        .btn-solid:hover{
            background: rgba(255,255,255,.92);
            transform: translateY(-1px);
        }
        .btn-solid:active{
            background: rgba(255,255,255,.85);
        }

        /* tombol coklat di card */
        .btn-small{
            width: 100%;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--brown);      /* muda */
            color: #fff;
            border: 1px solid rgba(0,0,0,.05);
            font-size: 12px;
            font-weight: 700;
            transition: background .18s ease, transform .18s ease, filter .18s ease;
        }
        .btn-small:hover{
            background: var(--brown-2);    /* tua */
            transform: translateY(-1px);
        }
        .btn-small:active{
            background: #36231D;           /* lebih tua saat klik */
            transform: translateY(0);
        }

        .btn-work{
            background: rgba(178,138,98,.22);
            color: #fff;
            border: 1px solid rgba(178,138,98,.35);
            padding: 10px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            transition: background .18s ease, transform .18s ease, border-color .18s ease;
        }
        .btn-work:hover{
            background: rgba(178,138,98,.35);
            border-color: rgba(178,138,98,.50);
            transform: translateY(-1px);
        }
        .btn-work:active{
            background: rgba(178,138,98,.55);
            transform: translateY(0);
        }

        .btn-outline{
            background: transparent;
            color: var(--brown-2);
            border: 1px solid rgba(75,51,43,.35);
            transition: background .18s ease, color .18s ease, transform .18s ease, border-color .18s ease;
        }
        .btn-outline:hover{
            background: var(--brown);
            color: #fff;
            border-color: var(--brown);
            transform: translateY(-1px);
        }
        .btn-outline:active{
            background: var(--brown-2);
            border-color: var(--brown-2);
            transform: translateY(0);
        }

        /* ===================== HERO ===================== */
        .hero{
            position: relative;
            min-height: 560px;
            padding: 120px 0 92px;
            overflow:hidden;
            color: #fff;
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
        .hero-content{
            position: relative;
            display:flex;
            flex-direction: column;
            align-items:center;
            text-align:center;
            gap: 18px;
        }
        .hero h1{
            margin:0;
            font-family: "Playfair Display", serif;
            font-size: clamp(30px, 4.2vw, 56px);
            line-height: 1.08;
            letter-spacing: .2px;
            max-width: 18ch;
        }
        .hero p{
            margin: 0;
            color: rgba(255,255,255,.88);
            max-width: 64ch;
            font-size: 13.5px;
            line-height: 1.7;
        }
        .hero-actions{
            display:flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content:center;
            margin-top: 6px;
        }
        .hero-actions .btn{
            padding: 11px 18px;
            font-size: 12.5px;
        }
        .hero-stats{
            display:flex;
            gap: 34px;
            flex-wrap: wrap;
            justify-content:center;
            margin-top: 12px;
            color: rgba(255,255,255,.92);
        }
        .stat{ min-width: 140px; }
        .stat .num{
            font-family: "Playfair Display", serif;
            font-size: 20px;
            font-weight: 700;
        }
        .stat .lbl{
            font-size: 11.5px;
            color: rgba(255,255,255,.82);
            margin-top: 6px;
        }

        /* ===================== SECTION ===================== */
        section{ padding: 64px 0; }
        .section-title{
            text-align:center;
            margin-bottom: 26px;
        }
        .section-title h2{
            margin: 0 0 8px;
            font-family: "Playfair Display", serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .section-title p{
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* ===================== GRID & CARDS ===================== */
        .grid-3{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .card{
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: 0 10px 24px rgba(0,0,0,.06);
            overflow:hidden;
        }

        .card-media{
            position: relative;
            height: 150px;
            margin: 14px 14px 0;
            border-radius: 16px;
            background: #ddd center/cover no-repeat;
            overflow:hidden;
        }
        .badge{
            position:absolute;
            top: 10px; left: 10px;
            display:inline-flex;
            align-items:center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            background: rgba(39,32,28,.70);
            color: rgba(255,255,255,.95);
            border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(6px);
        }

        .card-body{ padding: 12px 16px 16px; }
        .card-title{
            margin: 8px 0 8px;
            font-family: "Playfair Display", serif;
            font-weight: 700;
            letter-spacing:.2px;
        }
        .card-meta{
            display:flex;
            gap: 10px;
            align-items:center;
            justify-content: space-between;
            color: var(--muted);
            font-size: 11.5px;
        }
        .card-desc{
            margin:10px 0 0;
            color: var(--muted);
            font-size: 12.5px;
            line-height: 1.7;
            min-height: 44px;
        }

        .stars{
            display:flex;
            align-items:center;
            gap: 3px;
            font-size: 12px;
            margin-top: 10px;
            color: #C9A66B;
        }

        .card-actions{
            margin-top: 12px;
            display:flex;
            justify-content:center;
        }

        /* ===================== SELECTED WORKS ===================== */
        .works{ background: var(--bg-soft); }
        .work-card{
            background: #141312;
            color: #fff;
            border-radius: var(--radius-xl);
            overflow:hidden;
            border: 1px solid rgba(255,255,255,.10);
            box-shadow: 0 12px 28px rgba(0,0,0,.12);
            display:flex;
            flex-direction: column;
            min-height: 300px;
        }
        .work-media{
            height: 175px;
            background: #222 center/cover no-repeat;
            position: relative;
        }
        .work-media::after{
            content:"";
            position:absolute; inset:0;
            background: linear-gradient(180deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.78) 100%);
        }
        .work-body{
            padding: 14px 14px 16px;
            display:flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }
        .work-title{
            font-family: "Playfair Display", serif;
            font-weight: 700;
            margin: 0;
        }
        .work-desc{
            margin:0;
            color: rgba(255,255,255,.72);
            font-size: 12px;
            line-height: 1.6;
        }
        .work-footer{
            margin-top: auto;
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 10px;
        }
        .price{
            font-weight: 800;
            letter-spacing:.2px;
            font-size: 12.5px;
        }

        /* ===================== SUPPORT (stagger tiles) ===================== */
        .support{ background: var(--bg); }
        .support-inner{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            align-items: center;
        }
        .support h3{
            margin: 0 0 12px;
            font-family: "Playfair Display", serif;
            font-size: 30px;
            line-height: 1.12;
            letter-spacing: .2px;
        }
        .support p{
            margin: 0;
            color: var(--muted);
            line-height: 1.8;
            font-size: 13px;
            max-width: 60ch;
        }

        .tiles{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            align-content:start;
            grid-template-areas:
                "a b"
                "c b"
                "c d";
        }
        .tile{
            border-radius: 18px;
            padding: 18px;
            min-height: 118px;
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items:center;
            text-align:center;
            box-shadow: 0 10px 22px rgba(0,0,0,.08);
            border: 1px solid rgba(0,0,0,.05);
        }
        .tile.mid{ background: #A6805E; color: #fff; grid-area:a; min-height: 170px; }
        .tile.dark{ background: #5A3B31; color: #fff; grid-area:b; min-height: 240px; }
        .tile.star{ background: #6B4B3E; color:#fff; grid-area:c; min-height: 160px; }
        .tile.light{ background: #B8936E; color: #fff; grid-area:d; min-height: 170px; }

        .tile .t-num{
            font-family: "Playfair Display", serif;
            font-size: 22px;
            font-weight: 700;
        }
        .tile .t-lbl{
            font-size: 11.5px;
            opacity: .9;
            margin-top: 8px;
        }

        /* ===================== STORIES ===================== */
        .stories{ background: var(--bg-soft); }

        /* ===================== CTA ===================== */
        .cta{
            background: var(--bg);
            padding-bottom: 84px;
        }
        .cta-box{
            border-radius: var(--radius-xl);
            overflow:hidden;
            border: 1px solid var(--border);
            box-shadow: 0 12px 28px rgba(0,0,0,.10);
            background: #fff;
        }
        .cta-media{
            height: 260px;
            background: #222 center/cover no-repeat;
        }
        .cta-body{
            padding: 22px;
            text-align:center;
        }
        .cta-quote{
            margin: 0 0 16px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            max-width: 70ch;
            margin-inline:auto;
        }

        /* ===================== FOOTER ===================== */
        footer{
            background: #2A2420;
            color: rgba(255,255,255,.85);
            padding: 46px 0;
        }
        .footer-inner{
            display:grid;
            grid-template-columns: 1.3fr 1fr 1fr;
            gap: 22px;
            align-items:start;
        }
        .footer-title{
            font-weight: 800;
            color: #fff;
            margin: 0 0 10px;
            letter-spacing:.3px;
        }
        .footer p{
            margin: 0;
            color: rgba(255,255,255,.72);
            font-size: 12.5px;
            line-height: 1.8;
        }
        .footer-links{
            display:flex;
            flex-direction: column;
            gap: 8px;
            font-size: 12.5px;
        }
        .footer-links a{ color: rgba(255,255,255,.72); }
        .footer-links a:hover{ color: #fff; text-decoration: underline; text-underline-offset: 6px; }
        .copyright{
            margin-top: 26px;
            font-size: 11.5px;
            color: rgba(255,255,255,.55);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 980px){
            .nav-inner{ grid-template-columns: 1fr auto; }
            .nav-links{ display:none; }
            .grid-3{ grid-template-columns: repeat(2, 1fr); }
            .support-inner{ grid-template-columns: 1fr; }
        }
        @media (max-width: 640px){
            .grid-3{ grid-template-columns: 1fr; }
            .hero{ padding-top: 110px; min-height: 600px; }
            .hero-stats{ gap: 14px; }
            .footer-inner{ grid-template-columns: 1fr; }
            .tiles{ grid-template-areas: "a a" "b b" "c c" "d d"; }
            .tile{ min-height: 120px !important; }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<header class="nav">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand">
                <div class="logo">LO</div>
                <div>LOKANA</div>
            </a>

            <nav class="nav-links" aria-label="Main">
                <a href="#home">Home</a>
                <a href="#articles">Article</a>
                <a href="#explore">Explore</a>
                <a href="#about">About Us</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="nav-cta">
                <a class="btn btn-ghost" href="{{ route('register.index') }}">Sign up</a>
                <a class="btn btn-solid" href="{{ route('login.index') }}">Sign in</a>
            </div>
        </div>
    </div>
</header>

{{-- HERO --}}
<section id="home" class="hero">
    <div class="hero-bg" aria-hidden="true"></div>

    <div class="container">
        <div class="hero-content">
            <h1>Bali Artist Local Product MSMEs</h1>

            <p>
                Supporting Bali local economy by promoting authentic regional products through our MSME market &amp; platform.
            </p>

            <div class="hero-actions">
                <a href="#explore" class="btn btn-solid">Explore UMKM</a>
                <a href="#register" class="btn btn-ghost">Join as UMKM</a>
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <div class="num">{{ $stats['umkm'] ?? '100+' }}</div>
                    <div class="lbl">SME Owner</div>
                </div>
                <div class="stat">
                    <div class="num">{{ $stats['products'] ?? '500+' }}</div>
                    <div class="lbl">MSME Products</div>
                </div>
                <div class="stat">
                    <div class="num">{{ $stats['happy'] ?? '1000+' }}</div>
                    <div class="lbl">Happy Visitors</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- EXPLORE PRODUCTS --}}
<section id="explore">
    <div class="container">
        <div class="section-title">
            <h2>Explore MSME Products</h2>
            <p>We offer a variety of traditional Balinese products.</p>
        </div>

        <div class="grid-3">
            @foreach(($products ?? []) as $p)
                <article class="card">
                    <div class="card-media" style="background-image:url('{{ $p['image'] }}')">
                        <span class="badge">{{ $p['category'] ?? 'Product' }}</span>
                    </div>

                    <div class="card-body">
                        <div class="card-meta">
                            <span>{{ $p['seller'] ?? 'Pande Jagatama' }}</span>
                            <span>{{ $p['count'] ?? '37' }} product</span>
                        </div>

                        <div class="card-title">{{ $p['title'] ?? 'Bali Product' }}</div>

                        <p class="card-desc">
                            {{ $p['desc'] ?? 'A short description about the product and the local artisan behind it.' }}
                        </p>

                        <div class="stars" aria-label="rating">
                            ★ ★ ★ ★ ★ <span style="color:var(--muted); margin-left:8px;">{{ $p['rating'] ?? '5.0' }}</span>
                        </div>

                        <div class="card-actions">
                            <a class="btn btn-small" href="{{ $p['url'] ?? '#' }}">View Detail</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- SELECTED WORKS --}}
<section class="works">
    <div class="container">
        <div class="section-title">
            <h2>Selected Works</h2>
        </div>

        <div class="grid-3">
            @foreach(($works ?? []) as $w)
                <article class="work-card">
                    <div class="work-media" style="background-image:url('{{ $w['image'] }}')"></div>
                    <div class="work-body">
                        <div>
                            <p class="work-title">{{ $w['title'] ?? 'Arjuna Mask' }}</p>
                            <p class="work-desc">
                                {{ $w['desc'] ?? 'Handcrafted Balinese artwork made by local artisans with traditional technique.' }}
                            </p>
                        </div>

                        <div class="work-footer">
                            <div class="price">{{ $w['price'] ?? 'Rp. 300.000' }}</div>
                            <a class="btn-work" href="{{ $w['url'] ?? '#' }}">View Product Detail</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- SUPPORTING LOCAL PRODUCTS --}}
<section class="support" id="about">
    <div class="container">
        <div class="support-inner">
            <div>
                <h3>Supporting Local Products, Strengthening MSMEs.</h3>
                <p>
                    We are connecting local SMEs and customers. By showcasing authentic regional products,
                    we help MSMEs reach a wider market while preserving local culture and craftsmanship.
                </p>
            </div>

            <div class="tiles">
                <div class="tile mid">
                    <div class="t-num">{{ $stats['umkm'] ?? '100+' }}</div>
                    <div class="t-lbl">Total UMKM</div>
                </div>

                <div class="tile dark">
                    <div class="t-num">{{ $stats['products'] ?? '500+' }}</div>
                    <div class="t-lbl">MSME Products</div>
                </div>

                <div class="tile star">
                    <div class="t-num">★ {{ $stats['rating'] ?? '5' }}</div>
                    <div class="t-lbl">Rating</div>
                </div>

                <div class="tile light">
                    <div class="t-num">{{ $stats['happy'] ?? '1000+' }}</div>
                    <div class="t-lbl">Happy Visitors</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STORIES & INSIGHTS --}}
<section class="stories" id="articles">
    <div class="container">
        <div class="section-title">
            <h2>Stories and Insights</h2>
            <p>A collection of stories and insights about MSMEs and local products.</p>
        </div>

        <div class="grid-3">
            @foreach(($articles ?? []) as $a)
                <article class="card">
                    <div class="card-media" style="background-image:url('{{ $a['image'] }}')"></div>
                    <div class="card-body">
                        <div class="card-title">{{ $a['title'] ?? 'Article Name' }}</div>
                        <p class="card-desc">{{ $a['excerpt'] ?? 'Short excerpt of the article...' }}</p>

                        <div class="card-actions">
                            <a class="btn btn-small" href="{{ $a['url'] ?? '#' }}">Read More</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta" id="register">
    <div class="container">
        <div class="section-title">
            <h2>Expand Your MSME Market, Starting with Lokana</h2>
        </div>

        <div class="cta-box">
            <div class="cta-media" style="background-image:url('{{ asset('images/cta-market.jpg') }}')"></div>
            <div class="cta-body">
                <p class="cta-quote">
                    “From Local MSMEs to a Larger Market. Lokana is here to help your products gain more recognition.”
                </p>
                <a class="btn btn-outline" href="{{ route('register.index') }}">Come Register Now</a>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer id="faq" class="footer">
    <div class="container">
        <div class="footer-inner">
            <div>
                <div class="footer-title">LOKANA</div>
                <p>
                    Lokana is a platform to help local MSMEs reach a broader audience by showcasing authentic Balinese products.
                </p>
                <div class="copyright">
                    © {{ date('Y') }} Lokana. All rights reserved.
                </div>
            </div>

            <div>
                <div class="footer-title">Quick Links</div>
                <div class="footer-links">
                    <a href="#home">Home</a>
                    <a href="#explore">Explore</a>
                    <a href="#articles">Article</a>
                    <a href="#about">About Us</a>
                    <a href="#faq">FAQ</a>
                </div>
            </div>

            <div>
                <div class="footer-title">Contact</div>
                <div class="footer-links">
                    <a href="#">Instagram</a>
                    <a href="#">Facebook</a>
                    <a href="#">YouTube</a>
                    <a href="#">WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- Scrollspy (navbar underline active) --}}
<script>
  const navLinks = Array.from(document.querySelectorAll('.nav-links a'));
  const sections = navLinks
    .map(a => document.querySelector(a.getAttribute('href')))
    .filter(Boolean);

  function setActive(id){
    navLinks.forEach(a => a.classList.toggle('active', a.getAttribute('href') === '#' + id));
  }

  const io = new IntersectionObserver((entries) => {
    const visible = entries
      .filter(e => e.isIntersecting)
      .sort((a,b) => b.intersectionRatio - a.intersectionRatio)[0];

    if (visible) setActive(visible.target.id);
  }, { threshold: [0.25, 0.5, 0.75] });

  sections.forEach(sec => io.observe(sec));

  if (sections[0]) setActive(sections[0].id);
</script>

</body>
</html>
