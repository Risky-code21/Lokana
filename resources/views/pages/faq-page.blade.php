<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - FAQ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --ink: #2B2621;
            --muted:#6E6258;

            --sand:#B28A62;
            --brown:#6B4B3E;
            --brown-2:#4B332B;

            --pill:#E9E1D6;
            --pill-2:#E7DED2;

            --maxw: 1120px;
        }

        *{ box-sizing:border-box; }
        html{ scroll-behavior:smooth; }
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background:#fff;
            color: var(--ink);
        }

        /* matiin warna default link browser */
        a, a:visited{ color: inherit; text-decoration:none; }

        .container{
            width: min(100% - 56px, var(--maxw));
            margin: 0 auto;
        }

        /* ================= NAVBAR ================= */
        .nav{
            position: sticky;
            top: 0;
            z-index: 20;
            background:#fff;
            border-bottom: 1px solid rgba(0,0,0,.06);
        }
        .nav-inner{
            display:grid;
            grid-template-columns: 1fr auto 1fr;
            align-items:center;
            gap: 18px;
            padding: 16px 0;
        }

        .brand{
            display:flex;
            align-items:center;
        }
        .brand img{
            height: 28px;
            width: auto;
            display:block;
        }

        .nav-links{
            display:flex;
            justify-content:center;
            gap: 30px;
            font-size: 13px;
            font-weight: 500;
        }

        .nav-links a,
        .nav-links a:visited,
        .nav-links a:hover,
        .nav-links a:active{
            color: var(--ink);
            text-decoration:none;
        }

        .nav-links a{
            opacity:.85;
            position:relative;
            padding: 6px 2px;
            transition: opacity .18s ease;
        }
        .nav-links a:hover{ opacity:1; }

        .nav-links a::after{
            content:"";
            position:absolute;
            left:0; right:0;
            bottom:-8px;
            height: 2px;
            border-radius:999px;
            background: var(--brown);
            transform: scaleX(0);
            transform-origin:left;
            transition: transform .18s ease;
        }
        .nav-links a:hover::after,
        .nav-links a.active::after{ transform: scaleX(1); }
        .nav-links a.active{ opacity:1; }

        .nav-cta{
            display:flex;
            justify-content:flex-end;
            gap: 12px;
        }

        /* ================= BUTTONS ================= */
        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            height: 34px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 12px;
            cursor:pointer;
            transition: background .18s ease, transform .18s ease, border-color .18s ease, color .18s ease;
            white-space:nowrap;
        }
        .btn:hover{ transform: translateY(-1px); }
        .btn:active{ transform: translateY(0); }

        /* PAKSA TEXT PUTIH untuk link tombol (fix masalah hitam) */
        .btn,
        .btn:visited,
        .btn:hover,
        .btn:active{
            color: #fff !important;
            text-decoration: none !important;
        }

        /* Sign up */
        .btn-sand{
            background: var(--sand);
            border-color: rgba(0,0,0,.06);
        }
        .btn-sand:hover{ background: var(--brown); }
        .btn-sand:active{ background: var(--brown-2); }

        /* Sign in (juga putih) */
        .btn-outline{
            background: var(--brown);
            border-color: rgba(0,0,0,.06);
        }
        .btn-outline:hover{ background: var(--brown-2); }
        .btn-outline:active{ background: #2f1f1a; }

        /* ================= PAGE BODY ================= */
        .page{ padding: 30px 0 86px; }
        .faq-wrap{ width: min(100%, 900px); margin: 0 auto; }

        .section-title{
            display:flex;
            align-items:center;
            gap: 12px;
            margin: 30px 0 14px;
            font-family: "Playfair Display", serif;
            font-weight: 700;
            font-size: 22px;
            color: var(--ink);
        }
        .section-title .mini-ico{
            width: 20px; height:20px;
            border-radius: 999px;
            background: rgba(178,138,98,.35);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color: var(--brown);
            font-size: 13px;
            font-weight: 900;
            border: none;
            outline: none;
            box-shadow: none;
        }

        .acc{ display:flex; flex-direction:column; gap: 14px; }

        .item{
            background: var(--pill);
            border-radius: 16px;
            overflow:hidden;
            box-shadow: 0 2px 0 rgba(0,0,0,.03);
            border: 1px solid rgba(0,0,0,.06);
        }
        .item.open{
            border: 2px solid rgba(107,75,62,.75);
            background: var(--pill-2);
            box-shadow: 0 6px 16px rgba(0,0,0,.08);
        }

        .item-btn{
            width:100%;
            display:grid;
            grid-template-columns: 1fr auto;
            align-items:center;
            gap: 14px;
            padding: 18px 18px;
            background: transparent;
            border: 0;
            cursor:pointer;
            text-align:left;
        }

        .q{
            font-family: "Playfair Display", serif;
            font-size: 14px;
            color: rgba(43,38,33,.92);
        }

        .toggle{
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: rgba(107,75,62,.85);
            color: #fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight: 900;
            line-height: 1;
            user-select:none;
        }
        .item:not(.open) .toggle::before{ content:"+"; }
        .item.open .toggle::before{ content:"×"; }

        .answer{
            max-height: 0;
            overflow: hidden;
            transition: max-height .25s ease;
        }
        .answer-inner{
            padding: 0 18px 18px;
            color: rgba(43,38,33,.72);
            font-size: 12px;
            line-height: 1.7;
        }
        .item.open .answer{ max-height: 360px; }

        /* ================= CTA ================= */
        .cta{ margin: 76px auto 0; text-align:center; }
        .cta h2{
            font-family: "Playfair Display", serif;
            font-size: 36px;
            margin: 0 0 18px;
            font-weight: 700;
            color: var(--ink);
        }

        /* tombol WA: PAKSA PUTIH */
        .btn-wa{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            height: 34px;
            padding: 0 18px;
            border-radius: 6px;
            background: var(--brown);
            color:#fff !important;              /* <<< fix */
            font-weight: 700;
            font-size: 12px;
            transition: background .18s ease, transform .18s ease;
            text-decoration:none !important;    /* <<< fix */
        }
        .btn-wa:hover{ background: var(--brown-2); transform: translateY(-1px); }
        .btn-wa:active{ transform: translateY(0); }

        /* ================= FOOTER ================= */
        footer{
            background: #2F2F2F;
            color: rgba(255,255,255,.72);
            padding: 46px 0 18px;
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
            .container{ width: min(100% - 28px, var(--maxw)); }
            .nav-inner{ grid-template-columns: 1fr auto; }
            .nav-links{ display:none; }
            .footer-inner{ grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px){
            .footer-inner{ grid-template-columns: 1fr; }
            .cta h2{ font-size: 28px; }
        }
    </style>
</head>
<body>

<header class="nav">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('landing-page') }}" class="brand" aria-label="Lokana">
                <img src="{{ asset('images/logo.png') }}" alt="Lokana Logo">
            </a>

            <nav class="nav-links" aria-label="Main">
                <a href="{{ route('landing-page') }}#home">Home</a>
                <a href="{{ route('landing-page') }}#articles">Article</a>
                <a href="{{ route('landing-page') }}#explore">Explore</a>
                <a href="{{ route('landing-page') }}#about">About Us</a>
                <a class="active" href="{{ route('faq.page') }}">FAQ</a>
            </nav>

            <div class="nav-cta">
                <a class="btn btn-sand" href="{{ route('register.index') }}">Sign up</a>
                <a class="btn btn-outline" href="{{ route('login.index') }}">Sign in</a>
            </div>
        </div>
    </div>
</header>

<main class="page">
    <div class="container">
        <div class="faq-wrap">

            @php $secIndex = 0; @endphp
            @foreach($faqs as $section => $items)
                @php $secIndex++; @endphp

                <div class="section-title">
                    <span class="mini-ico">
                        {{ $secIndex === 1 ? '?' : ($secIndex === 2 ? '👜' : '☕') }}
                    </span>
                    <span>{{ $section }}</span>
                </div>

                <div class="acc" data-accordion>
                    @foreach($items as $i => $row)
                        <div class="item {{ ($secIndex===1 && $i===2) ? 'open' : '' }}">
                            <button class="item-btn" type="button">
                                <span class="q">{{ $row['q'] }}</span>
                                <span class="toggle" aria-hidden="true"></span>
                            </button>
                            <div class="answer">
                                <div class="answer-inner">
                                    {{ $row['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="cta">
                <h2>Still Have Question?</h2>
                <a class="btn-wa" href="#">Chat on whatsapp</a>
            </div>

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

<script>
  document.querySelectorAll('[data-accordion]').forEach(acc => {
    const items = Array.from(acc.querySelectorAll('.item'));
    items.forEach(item => {
      item.querySelector('.item-btn').addEventListener('click', () => {
        const isOpen = item.classList.contains('open');
        items.forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
      });
    });
  });
</script>

</body>
</html>
