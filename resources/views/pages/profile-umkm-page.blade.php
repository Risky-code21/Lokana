{{-- resources/views/pages/profile-umkm-page.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - Profile UMKM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            /* === sama persis landing-page === */
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

            --radius-xl: 22px;
            --radius-lg: 16px;
            --radius-md: 12px;

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

        img{ max-width:100%; display:block; }

        .container{
            width: min(100% - 32px, var(--maxw));
            margin-inline: auto;
        }

        /* ===================== HERO TOP (biar navbar putih seperti landing) ===================== */
        .hero{
            position: relative;
            min-height: 160px;
            padding: 92px 0 18px;
            overflow:hidden;
            color:#fff;
        }
        .hero-bg{
            position:absolute; inset:0;
            filter: saturate(1.02) contrast(1.02);
        }
        .hero-bg img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }
        .hero-bg::after{
            content:"";
            position:absolute; inset:0;
            background: linear-gradient(180deg, rgba(44,30,24,.62) 0%, rgba(44,30,24,.56) 55%, rgba(44,30,24,.18) 100%);
        }
        .hero::after{
            content:"";
            position:absolute; inset:auto 0 0 0;
            height: 90px;
            background: linear-gradient(180deg, rgba(239,230,219,0) 0%, rgba(239,230,219,1) 100%);
        }

        /* ===================== NAVBAR (landing style) ===================== */
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

        /* ===================== BUTTONS (landing) ===================== */
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

        .btn-brown{
            background: var(--brown);
            color:#fff !important;
            border: 1px solid rgba(0,0,0,.05);
        }
        .btn-brown:hover{
            background: var(--brown-2);
            transform: translateY(-1px);
        }
        .btn-brown:active{
            background: #36231D;
            transform: translateY(0);
        }

        /* ===================== PAGE ===================== */
        .page{ padding: 16px 0 64px; }

        .top{
            margin-top: -18px;
            padding-top: 18px;
        }

        .top-grid{
            display:grid;
            grid-template-columns: 1.25fr .9fr;
            gap: 18px;
            align-items:start;
        }

        .media-card{
            background: #fff;
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow:hidden;
        }
        .hero-img{
            height: 220px;
            background:#ddd;
        }
        .hero-img img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }

        .info-card{
            background: #fff;
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 16px;
        }

        .chip{
            display:inline-flex;
            align-items:center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            background: rgba(107,75,62,.10);
            border: 1px solid rgba(107,75,62,.18);
            color: rgba(75,51,43,.92);
        }

        .umkm-title{
            margin: 10px 0 6px;
            font-family: "Playfair Display", serif;
            font-weight: 700;
            font-size: 22px;
            letter-spacing:.2px;
        }

        .mini-meta{
            display:flex;
            gap: 10px;
            align-items:center;
            color: rgba(43,38,33,.70);
            font-size: 11.5px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .stars{
            display:flex;
            align-items:center;
            gap: 6px;
            font-size: 11.5px;
            color: rgba(43,38,33,.70);
        }
        .stars .s{ color:#C9A66B; }

        .author{
            display:flex;
            align-items:center;
            gap: 10px;
            margin: 10px 0 10px;
        }
        .author .ava{
            width: 34px; height: 34px;
            border-radius: 999px;
            overflow:hidden;
            border: 1px solid rgba(0,0,0,.08);
            background:#eee;
            flex: 0 0 auto;
        }
        .author .ava img{ width:100%; height:100%; object-fit:cover; }
        .author .who{
            font-size: 12px;
            font-weight: 700;
        }
        .author .sub{
            font-size: 11px;
            color: rgba(43,38,33,.62);
            margin-top: 2px;
        }

        .umkm-desc{
            margin: 10px 0 12px;
            font-size: 12px;
            line-height: 1.7;
            color: rgba(43,38,33,.70);
        }

        .loc{
            display:flex;
            align-items:center;
            gap: 8px;
            font-size: 11.5px;
            color: rgba(43,38,33,.70);
            margin: 10px 0 12px;
        }
        .loc .dot{
            width: 6px; height: 6px;
            border-radius: 999px;
            background: var(--sand);
            box-shadow: 0 0 0 4px rgba(178,138,98,.18);
        }

        .wa-btn{
            width: 100%;
            height: 42px;
            border-radius: 10px;
            background: var(--brown);
            color:#fff !important;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 12px;
            font-weight: 800;
            transition: background .18s ease, transform .18s ease;
        }
        .wa-btn:hover{ background: var(--brown-2); transform: translateY(-1px); }
        .wa-btn:active{ background: #36231D; transform: translateY(0); }

        /* ===================== SECTION CARD ===================== */
        .section{ margin-top: 18px; }

        .panel{
            background: #fff;
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .panel-title{
            margin: 0 0 10px;
            font-family: "Playfair Display", serif;
            font-size: 22px;
            font-weight: 700;
            color: rgba(43,38,33,.92);
        }

        .two-col{
            display:grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 18px;
            align-items:start;
        }

        .story p{
            margin: 0 0 12px;
            font-size: 12px;
            line-height: 1.75;
            color: rgba(43,38,33,.72);
        }
        .story-img{
            height: 160px;
            border-radius: 14px;
            border: 1px solid rgba(0,0,0,.06);
            margin: 10px 0 12px;
            overflow:hidden;
            background:#ddd;
        }
        .story-img img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }

        .side-card{
            background: var(--bg-soft);
            border: 1px solid rgba(75,51,43,.14);
            border-radius: 16px;
            padding: 14px;
        }
        .side-card h4{
            margin: 0 0 10px;
            font-family: "Playfair Display", serif;
            font-size: 14px;
            font-weight: 700;
            color: rgba(43,38,33,.88);
        }

        .kv{ display:grid; gap: 10px; }
        .kv .row{
            display:flex;
            flex-direction: column;
            gap: 4px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(75,51,43,.10);
        }
        .kv .row:last-child{ border-bottom:0; padding-bottom:0; }
        .kv .k{
            font-size: 10px;
            letter-spacing:.6px;
            font-weight: 800;
            color: rgba(110,98,88,.90);
        }
        .kv .v{
            font-size: 12px;
            font-weight: 700;
            color: rgba(43,38,33,.86);
        }

        .popular{ margin-top: 12px; }
        .pop-card{
            margin-top: 10px;
            border-radius: 16px;
            overflow:hidden;
            border: 1px solid rgba(0,0,0,.10);
            background: #111;
            position: relative;
            height: 190px;
        }
        .pop-card .pop-bg{
            position:absolute; inset:0;
            background:#222;
        }
        .pop-card .pop-bg img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
            filter: contrast(1.05) saturate(1.05);
        }
        .pop-card::after{
            content:"";
            position:absolute; inset:0;
            background: linear-gradient(180deg, rgba(0,0,0,.12) 0%, rgba(0,0,0,.82) 100%);
        }
        .pop-body{
            position: relative;
            z-index: 2;
            height: 100%;
            padding: 12px;
            display:flex;
            flex-direction: column;
            justify-content:flex-end;
            gap: 6px;
            color: #fff;
        }
        .pop-body .t{
            font-family: "Playfair Display", serif;
            font-size: 16px;
            font-weight: 700;
        }
        .pop-body .p{ font-size: 11px; color: rgba(255,255,255,.86); }
        .pop-body .price{ font-weight: 900; letter-spacing:.2px; font-size: 12px; }
        .pop-body .mini-btn{
            margin-top: 6px;
            height: 34px;
            border-radius: 10px;
            background: rgba(178,138,98,.22);
            border: 1px solid rgba(178,138,98,.35);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 11px;
            font-weight: 900;
            color:#fff;
            transition: background .18s ease, transform .18s ease, border-color .18s ease;
        }
        .pop-body .mini-btn:hover{
            background: rgba(178,138,98,.35);
            border-color: rgba(178,138,98,.50);
            transform: translateY(-1px);
        }

        /* ===================== FEATURED PRODUCTS ===================== */
        .section-h{
            margin: 18px 0 12px;
            font-family: "Playfair Display", serif;
            font-size: 22px;
            font-weight: 700;
            color: rgba(43,38,33,.92);
        }

        .grid-4{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .prod{
            border-radius: 16px;
            overflow:hidden;
            position: relative;
            height: 220px;
            background:#111;
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 10px 18px rgba(0,0,0,.08);
        }
        .prod .bg{
            position:absolute; inset:0;
            background:#222;
        }
        .prod .bg img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }
        .prod::after{
            content:"";
            position:absolute; inset:0;
            background: linear-gradient(180deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.86) 100%);
        }
        .prod .body{
            position: relative;
            z-index: 2;
            height: 100%;
            padding: 12px;
            display:flex;
            flex-direction: column;
            justify-content:flex-end;
            gap: 6px;
            color:#fff;
        }
        .prod .t{
            font-family:"Playfair Display", serif;
            font-weight: 700;
            font-size: 14px;
        }
        .prod .price{ font-weight: 900; font-size: 12px; }
        .prod .btn{
            margin-top: 6px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,.92);
            color: var(--brown-2) !important;
            font-weight: 900;
            font-size: 11px;
        }
        .prod .btn:hover{ background: #fff; transform: translateY(-1px); }

        /* ===================== MAP ===================== */
        .map{
            border-radius: var(--radius-xl);
            overflow:hidden;
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 10px 18px rgba(0,0,0,.08);
            background:#ddd;
            height: 240px;
        }
        .map iframe{ width:100%; height:100%; border:0; }

        /* ===================== RECOMMENDED ===================== */
        .grid-3{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .rec{
            background:#fff;
            border-radius: 18px;
            border: 1px solid rgba(75,51,43,.14);
            box-shadow: 0 10px 18px rgba(0,0,0,.08);
            overflow:hidden;
        }
        .rec .img{
            height: 140px;
            margin: 14px 14px 0;
            border-radius: 16px;
            overflow:hidden;
            background:#ddd;
        }
        .rec .img img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }
        .rec .b{ padding: 12px 14px 14px; }
        .rec .t{
            font-family:"Playfair Display", serif;
            font-weight: 700;
            font-size: 16px;
            margin: 0 0 8px;
        }
        .rec .d{
            font-size: 11.5px;
            line-height: 1.65;
            color: rgba(43,38,33,.68);
            min-height: 40px;
        }
        .rec .foot{
            margin-top: 10px;
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 10px;
            color: rgba(43,38,33,.64);
            font-size: 11px;
        }
        .rec .btn-small{
            width: 100%;
            margin-top: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--brown);
            color:#fff !important;
            text-align:center;
            font-weight: 800;
            font-size: 11.5px;
            transition: background .18s ease, transform .18s ease;
            display:inline-flex;
            align-items:center;
            justify-content:center;
        }
        .rec .btn-small:hover{ background: var(--brown-2); transform: translateY(-1px); }

        /* ===================== CUSTOMER REVIEW SUMMARY ===================== */
        .review-sum{
            display:grid;
            grid-template-columns: .45fr 1fr;
            gap: 18px;
            align-items:center;
        }

        .score{
            background: rgba(178,138,98,.35);
            border-radius: 14px;
            padding: 16px;
            border: 1px solid rgba(75,51,43,.14);
            display:flex;
            flex-direction: column;
            align-items:center;
            justify-content:center;
            text-align:center;
        }
        .score .num{
            font-family:"Playfair Display", serif;
            font-size: 28px;
            font-weight: 800;
            color: rgba(43,38,33,.92);
        }
        .score .stars{
            margin-top: 6px;
            justify-content:center;
            color:#C9A66B;
        }
        .score .small{
            margin-top: 8px;
            font-size: 11px;
            color: rgba(43,38,33,.68);
            font-weight: 700;
        }

        .bars{ display:grid; gap: 10px; }
        .bar{
            display:grid;
            grid-template-columns: 22px 1fr;
            gap: 10px;
            align-items:center;
        }
        .bar .lbl{
            font-size: 11px;
            font-weight: 800;
            color: rgba(43,38,33,.70);
            text-align:right;
        }
        .track{
            height: 3px;
            border-radius: 999px;
            background: rgba(107,75,62,.20);
            overflow:hidden;
        }
        .fill{
            height: 100%;
            background: rgba(107,75,62,.80);
            border-radius: 999px;
            width: 60%;
        }

        /* ===================== REVIEWS LIST ===================== */
        .reviews-head{
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 14px;
            padding: 0 2px;
        }
        .reviews-head h3{
            margin:0;
            font-family:"Playfair Display", serif;
            font-size: 18px;
            font-weight: 700;
        }

        .review-item{
            margin-top: 12px;
            background:#fff;
            border-radius: 18px;
            border: 1px solid rgba(75,51,43,.14);
            box-shadow: 0 10px 18px rgba(0,0,0,.06);
            padding: 14px;
        }

        .rev-top{
            display:flex;
            align-items:flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .rev-user{
            display:flex;
            align-items:center;
            gap: 10px;
        }
        .rev-ava{
            width: 34px; height: 34px;
            border-radius: 999px;
            background: rgba(178,138,98,.28);
            border: 1px solid rgba(75,51,43,.10);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight: 900;
            color: var(--brown-2);
            font-size: 12px;
        }
        .rev-name{ font-weight: 800; font-size: 12px; }
        .rev-time{ font-size: 10.5px; color: rgba(43,38,33,.55); margin-top: 2px; }
        .rev-stars{ color:#C9A66B; font-size: 11px; }

        .rev-text{
            margin-top: 10px;
            font-size: 12px;
            line-height: 1.75;
            color: rgba(43,38,33,.72);
        }

        .rev-grid{
            margin-top: 12px;
            display:grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 12px;
        }
        .rev-img{
            border-radius: 14px;
            overflow:hidden;
            border: 1px solid rgba(0,0,0,.08);
            background:#ddd;
            height: 150px;
        }
        .rev-img img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }
        .rev-img.small{ height: 150px; }

        .load-more{
            margin-top: 14px;
            width: 100%;
            height: 40px;
            border-radius: 10px;
            background: var(--brown);
            color:#fff;
            font-weight: 900;
            font-size: 11px;
            display:flex;
            align-items:center;
            justify-content:center;
            transition: background .18s ease, transform .18s ease;
        }
        .load-more:hover{ background: var(--brown-2); transform: translateY(-1px); }

        /* ===================== FOOTER (samain explore) ===================== */
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

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 980px){
            .nav-inner{ grid-template-columns: 1fr auto; }
            .nav-links{ display:none; }

            .top-grid{ grid-template-columns: 1fr; }
            .two-col{ grid-template-columns: 1fr; }
            .grid-4{ grid-template-columns: repeat(2, 1fr); }
            .grid-3{ grid-template-columns: 1fr; }

            .review-sum{ grid-template-columns: 1fr; }
            .rev-grid{ grid-template-columns: 1fr; }
            .footer-inner{ grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px){
            .grid-4{ grid-template-columns: 1fr; }
            .footer-inner{ grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

@php
    // ==== Dummy fallback biar langsung jadi meskipun variable belum dikirim dari route ====
    $umkm = $umkm ?? [
        'badge' => 'HandCraft',
        'name' => "Bali’s Craft",
        'product_count' => '38 Product',
        'rating' => '4.9',
        'reviews' => '59 reviews',
        'owner' => 'Pande Sujana',
        'owner_role' => 'MSME owner',
        'avatar' => asset('images/avatar.jpg'),
        'cover' => asset('images/article-1.jpg'),
        'desc' => "Balinese carving is a traditional art unique to Bali that features fine details and culturally valuable motifs, often inspired by nature, mythology, and Balinese Hindu beliefs.",
        'location' => 'Celuk, Bali',
        'whatsapp_url' => '#',
        'established' => '1952',
        'product_type' => 'Handcraft',
    ];

    $story = $story ?? [
        'p1' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        'p2' => "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        'img1' => asset('images/article-2.jpg'),
        'img2' => asset('images/article-3.jpg'),
        'p3' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.",
    ];

    $popularProduct = $popularProduct ?? [
        'title' => "Arjuna’s Mask",
        'price' => "Rp. 300.000",
        'image' => asset('images/product-1.jpg'),
        'url' => '#',
    ];

    $featuredProducts = $featuredProducts ?? collect(range(1,4))->map(fn($i)=>[
        'title'=>"Arjuna’s Mask",
        'price'=>"Rp. 300.000",
        'image'=>asset("images/product-$i.jpg"),
        'url'=>'#'
    ])->toArray();

    $recommended = $recommended ?? collect([
        ['title'=>"Bali’s Modern Food", 'image'=>asset('images/work-2.jpg'), 'desc'=>"A short story about local culinary craft and tradition.", 'author'=>"Pande Sujana", 'rating'=>"4.8", 'url'=>'#'],
        ['title'=>"Bali’s Traditional Craft", 'image'=>asset('images/work-1.jpg'), 'desc'=>"A short story about artisans and handmade products.", 'author'=>"Pande Sujana", 'rating'=>"4.9", 'url'=>'#'],
        ['title'=>"Bali’s Craft Center", 'image'=>asset('images/article-1.jpg'), 'desc'=>"A short story about MSME and cultural values.", 'author'=>"Pande Sujana", 'rating'=>"4.9", 'url'=>'#'],
    ])->toArray();

    $reviews = $reviews ?? [
        [
            'name'=>'Made Sentosa',
            'initials'=>'MS',
            'time'=>'2 days ago',
            'stars'=>5,
            'text'=>"an effort to connect Balinese artisans with the wider community through a digital platform, so that local works and products can be recognized, accessed, and appreciated by both national and international markets.",
            'img1'=>asset('images/cta-market.jpg'),
            'img2'=>asset('images/work-1.jpg'),
            'img3'=>asset('images/work-2.jpg'),
        ]
    ];

    $mapEmbed = $mapEmbed ?? 'https://www.google.com/maps?q=Celuk%20Bali&output=embed';
@endphp

<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        {{-- IMAGE FORMAT --}}
        <img src="{{ asset('images/hero-bali.jpg') }}" alt="Hero">
    </div>

    <header class="nav">
        <div class="container">
            <div class="nav-inner">
                <a href="{{ route('landing-page') }}" class="brand" aria-label="Lokana">
                    <img src="{{ asset('images/logo.png') }}" alt="Lokana Logo">
                </a>

                <nav class="nav-links" aria-label="Main">
                    <a href="{{ route('landing-page') }}#home">Home</a>
                    <a href="{{ route('landing-page') }}#articles">Article</a>
                    <a href="{{ route('explore.umkm') }}">Explore</a>
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
    <div class="container top">

        {{-- TOP: gambar kiri + kartu info kanan --}}
        <div class="top-grid">
            <div class="media-card">
                <div class="hero-img">
                    {{-- IMAGE FORMAT --}}
                    <img src="{{ $umkm['cover'] }}" alt="UMKM Cover">
                </div>
            </div>

            <aside class="info-card">
                <span class="chip">{{ $umkm['badge'] }}</span>

                <div class="umkm-title">{{ $umkm['name'] }}</div>

                <div class="mini-meta">
                    <span>{{ $umkm['product_count'] }}</span>
                    <span>•</span>
                    <div class="stars" aria-label="rating">
                        <span class="s">★</span>
                        <strong>{{ $umkm['rating'] }}</strong>
                        <span>({{ $umkm['reviews'] }})</span>
                    </div>
                </div>

                <div class="author">
                    <span class="ava">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $umkm['avatar'] }}" alt="Owner Avatar">
                    </span>
                    <div>
                        <div class="who">{{ $umkm['owner'] }}</div>
                        <div class="sub">{{ $umkm['owner_role'] }}</div>
                    </div>
                </div>

                <p class="umkm-desc">{{ $umkm['desc'] }}</p>

                <div class="loc">
                    <span class="dot"></span>
                    <span>{{ $umkm['location'] }}</span>
                </div>

                <a class="wa-btn" href="{{ $umkm['whatsapp_url'] }}">Contact via Whatsapp</a>
            </aside>
        </div>

        {{-- STORY + SIDE INFO --}}
        <div class="section">
            <div class="panel">
                <div class="two-col">
                    <div class="story">
                        <h2 class="panel-title">Story of The MSME</h2>

                        <p>{{ $story['p1'] }}</p>

                        <div class="story-img">
                            {{-- IMAGE FORMAT --}}
                            <img src="{{ $story['img1'] }}" alt="Story Image 1">
                        </div>

                        <p>{{ $story['p2'] }}</p>

                        <div class="story-img">
                            {{-- IMAGE FORMAT --}}
                            <img src="{{ $story['img2'] }}" alt="Story Image 2">
                        </div>

                        <p style="margin-bottom:0;">{{ $story['p3'] }}</p>
                    </div>

                    <div>
                        <div class="side-card">
                            <h4>Information</h4>

                            <div class="kv">
                                <div class="row">
                                    <div class="k">ESTABLISHED</div>
                                    <div class="v">{{ $umkm['established'] }}</div>
                                </div>
                                <div class="row">
                                    <div class="k">ARTISANS</div>
                                    <div class="v">{{ $umkm['owner'] }}</div>
                                </div>
                                <div class="row">
                                    <div class="k">PRODUCT</div>
                                    <div class="v">{{ $umkm['product_type'] }}</div>
                                </div>
                                <div class="row">
                                    <div class="k">UMKM LOCATION</div>
                                    <div class="v">{{ $umkm['location'] }}</div>
                                </div>
                            </div>

                            <div class="popular">
                                <h4 style="margin-top:14px;">Popular product</h4>

                                <div class="pop-card">
                                    <div class="pop-bg">
                                        {{-- IMAGE FORMAT --}}
                                        <img src="{{ $popularProduct['image'] }}" alt="Popular Product">
                                    </div>
                                    <div class="pop-body">
                                        <div class="t">{{ $popularProduct['title'] }}</div>
                                        <div class="p">Handcrafted Balinese artwork with cultural value.</div>
                                        <div class="price">{{ $popularProduct['price'] }}</div>
                                        <a class="mini-btn" href="{{ $popularProduct['url'] }}">view product detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FEATURED PRODUCTS --}}
        <h2 class="section-h">Featured Products</h2>
        <div class="grid-4">
            @foreach($featuredProducts as $fp)
                <article class="prod">
                    <div class="bg">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $fp['image'] }}" alt="{{ $fp['title'] }}">
                    </div>
                    <div class="body">
                        <div class="t">{{ $fp['title'] }}</div>
                        <div class="price">{{ $fp['price'] }}</div>
                        <a class="btn" href="{{ $fp['url'] }}">View Product Detail</a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- MAP --}}
        <h2 class="section-h">MSME Location</h2>
        <div class="map">
            <iframe src="{{ $mapEmbed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        {{-- RECOMMENDED --}}
        <h2 class="section-h">Recommended MSME for you</h2>
        <div class="grid-3">
            @foreach($recommended as $r)
                <article class="rec">
                    <div class="img">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $r['image'] }}" alt="{{ $r['title'] }}">
                    </div>
                    <div class="b">
                        <div class="t">{{ $r['title'] }}</div>
                        <div class="d">{{ $r['desc'] }}</div>

                        <div class="foot">
                            <span>★ {{ $r['rating'] }}</span>
                            <span>By {{ $r['author'] }}</span>
                        </div>

                        <a class="btn-small" href="{{ $r['url'] }}">View Detail</a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- CUSTOMER REVIEW SUMMARY --}}
        <h2 class="section-h">Customer review</h2>
        <div class="panel">
            <div class="review-sum">
                <div class="score">
                    <div class="num">4.9</div>
                    <div class="stars">★ ★ ★ ★ ★</div>
                    <div class="small">6.8k reviews</div>
                </div>

                <div class="bars">
                    <div class="bar">
                        <div class="lbl">5</div>
                        <div class="track"><div class="fill" style="width:92%"></div></div>
                    </div>
                    <div class="bar">
                        <div class="lbl">4</div>
                        <div class="track"><div class="fill" style="width:72%"></div></div>
                    </div>
                    <div class="bar">
                        <div class="lbl">3</div>
                        <div class="track"><div class="fill" style="width:40%"></div></div>
                    </div>
                    <div class="bar">
                        <div class="lbl">2</div>
                        <div class="track"><div class="fill" style="width:22%"></div></div>
                    </div>
                    <div class="bar">
                        <div class="lbl">1</div>
                        <div class="track"><div class="fill" style="width:10%"></div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- REVIEWS LIST --}}
        <div class="reviews-head">
            <h3>Reviews ({{ count($reviews) }})</h3>
        </div>

        @foreach($reviews as $rv)
            <article class="review-item">
                <div class="rev-top">
                    <div class="rev-user">
                        <div class="rev-ava">{{ $rv['initials'] ?? 'U' }}</div>
                        <div>
                            <div class="rev-name">{{ $rv['name'] }}</div>
                            <div class="rev-time">{{ $rv['time'] }}</div>
                        </div>
                    </div>
                    <div class="rev-stars">
                        {{ str_repeat('★', (int)($rv['stars'] ?? 5)) }}
                    </div>
                </div>

                <div class="rev-text">{{ $rv['text'] }}</div>

                <div class="rev-grid">
                    <div class="rev-img">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $rv['img1'] }}" alt="Review image 1">
                    </div>
                    <div class="rev-img small">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $rv['img2'] }}" alt="Review image 2">
                    </div>
                </div>

                <div class="rev-grid" style="grid-template-columns: 1fr;">
                    <div class="rev-img" style="height:170px;">
                        {{-- IMAGE FORMAT --}}
                        <img src="{{ $rv['img3'] }}" alt="Review image 3">
                    </div>
                </div>
            </article>
        @endforeach

        <a class="load-more" href="#">Load more</a>

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
                    <a href="#">All UMKM</a>
                    <a href="#">Meet Artisan</a>
                    <a href="#">Stories & Articles</a>
                    <a href="#">About Us</a>
                </div>
            </div>

            <div>
                <div class="footer-title">Quick Links</div>
                <div class="footer-links">
                    <a href="#">About Us</a>
                    <a href="{{ route('explore.umkm') }}">Explore UMKM</a>
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
