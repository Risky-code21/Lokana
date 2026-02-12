{{-- resources/views/pages/about-us-page.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - About Us</title>

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

        /* ===================== HERO TOP (SAMA KAYAK SEBELUMNYA) ===================== */
        .hero{
            position: relative;
            min-height: 430px;
            padding: 120px 0 44px; /* ruang navbar + konten */
            overflow:hidden;
            color:#fff;
        }
        .hero-bg{
            position:absolute; inset:0;
            z-index:0;
        }
        .hero-bg img{
            width:100%;
            height:100%;
            object-fit: cover;
            filter: saturate(1.02) contrast(1.02);
        }
        .hero-bg::after{
            content:"";
            position:absolute; inset:0;
            background:
                linear-gradient(180deg, rgba(44,30,24,.62) 0%, rgba(44,30,24,.56) 55%, rgba(44,30,24,.18) 100%);
        }
        .hero::after{
            content:"";
            position:absolute; inset:auto 0 0 0;
            height: 120px;
            background: linear-gradient(180deg, rgba(239,230,219,0) 0%, rgba(239,230,219,1) 100%);
            z-index:1;
        }

        /* ===================== NAVBAR (PERSIS PREVIOUS) ===================== */
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

        /* button landing */
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

        .btn-solid{
            background: #fff;
            color: var(--brown-2) !important;
            border-color: rgba(255,255,255,.25);
        }
        .btn-solid:hover{
            background: rgba(255,255,255,.92);
            transform: translateY(-1px);
        }

        /* ===================== HERO CONTENT ===================== */
        .hero-content{
            position: relative;
            z-index: 2;
            text-align:center;
        }
        .hero-title{
            font-family:"Playfair Display", serif;
            font-size: 34px;
            font-weight: 800;
            line-height: 1.15;
            margin: 0 auto 10px;
            max-width: 40ch;
            color: rgba(255,255,255,.98);
        }
        .hero-desc{
            margin: 0 auto;
            max-width: 92ch;
            font-size: 12.8px;
            line-height: 1.75;
            color: rgba(255,255,255,.86);
        }

        .hero-illus{
            margin: 18px auto 0;
            width: min(520px, 100%);
            filter: drop-shadow(0 14px 30px rgba(0,0,0,.18));
        }

        /* ✅ tombol panah bawah (scroll cepat) */
        .scroll-down{
            position: absolute;
            left: 50%;
            bottom: 18px;
            transform: translateX(-50%);
            z-index: 3;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: rgba(107,75,62,.95);
            border: 1px solid rgba(255,255,255,.25);
            box-shadow: 0 12px 22px rgba(0,0,0,.18);
            transition: transform .18s ease, filter .18s ease, background .18s ease;
        }
        .scroll-down:hover{
            background: rgba(75,51,43,.95);
            transform: translateX(-50%) translateY(-2px);
        }
        .scroll-down span{
            font-size: 18px;
            line-height: 1;
            color: #fff;
            transform: translateY(1px);
        }

        /* ===================== PAGE ===================== */
        .page{ padding: 22px 0 64px; }

        /* pill section label (Our mission / Our impact / Our vision) */
        .pill{
            display:inline-flex;
            align-items:center;
            height: 28px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
            background: rgba(178,138,98,.25);
            border: 1px solid rgba(75,51,43,.18);
            color: rgba(75,51,43,.92);
        }

        .section-head{
            text-align:center;
            margin: 6px auto 14px;
        }
        .section-head h2{
            margin: 10px auto 0;
            font-family:"Playfair Display", serif;
            font-size: 28px;
            font-weight: 800;
            color: rgba(43,38,33,.92);
            max-width: 44ch;
            line-height: 1.18;
        }

        /* ===================== BAND (MISSION) ===================== */
        .band{
            background: rgba(246,240,232,.92);
            border-top: 1px solid rgba(75,51,43,.10);
            border-bottom: 1px solid rgba(75,51,43,.10);
            padding: 44px 0 52px; /* lebih lega seperti desain */
        }

        /* heading mission lebih besar */
        .band .section-head{ margin-bottom: 22px; }
        .band .section-head h2{
            font-size: 34px;
            max-width: 38ch;
            line-height: 1.12;
        }

        /* grid: kiri besar, kanan stack */
        .grid-2{
            display:grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 26px;
            align-items:start;
        }

        .img-card{
            background:#fff;
            border: 1px solid rgba(75,51,43,.12);
            border-radius: 26px;
            box-shadow: 0 18px 34px rgba(0,0,0,.08);
            overflow:hidden;
        }

        /* frame khusus supaya tinggi pas */
        .img-frame{
            position: relative;
            width:100%;
            background: #ECE6DF;
        }
        .img-frame.big{ height: 360px; }   /* kiri besar */
        .img-frame.small{ height: 230px; } /* kanan bawah */

        .img-frame img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }

        /* placeholder */
        .img-ph{
            position:absolute;
            inset:0;
            display:flex;
            align-items:center;
            justify-content:center;
            pointer-events:none;
            font-weight: 900;
            letter-spacing:.6px;
            font-size: 12px;
            color: rgba(75,51,43,.55);
        }
        .img-ph::before{
            content:"IMAGE";
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(75,51,43,.12);
        }

        .stack{
            display:grid;
            gap: 16px;
        }

        /* card mission kanan lebih */
        .card{
            background:#fff;
            border-radius: 26px;
            border: 1px solid rgba(75,51,43,.12);
            box-shadow: 0 18px 34px rgba(0,0,0,.08);
            padding: 18px 20px;
        }

        /* tag mission lebih mirip pill */
        .tag{
            display:inline-flex;
            align-items:center;
            height: 26px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
            background: rgba(178,138,98,.22);
            border: 1px solid rgba(75,51,43,.14);
            color: rgba(75,51,43,.92);
            margin-bottom: 10px;
        }

        .ctitle{
            font-family:"Playfair Display", serif;
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px;
            color: rgba(43,38,33,.92);
        }
        .cdesc{
            margin:0;
            font-size: 12.8px;
            line-height: 1.75;
            color: rgba(43,38,33,.70);
        }

        /* ===================== IMPACT + CAROUSEL LOOK ===================== */
        .impact{
            padding: 34px 0 16px;
        }

        .impact-top{
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 10px;
        }

        .stats{
            display:flex;
            gap: 34px;
            align-items:flex-end;
            flex-wrap:wrap;
        }
        .stat .num{
            font-size: 34px;
            font-weight: 900;
            color: rgba(43,38,33,.92);
            line-height: 1;
        }
        .stat .lbl{
            margin-top: 6px;
            font-size: 11.5px;
            color: rgba(43,38,33,.70);
            font-weight: 800;
        }

        /* tombol panah kanan-kiri seperti design (visual) */
        .nav-arrows{
            display:flex;
            gap: 10px;
            align-items:center;
        }
        .arrow-btn{
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(75,51,43,.18);
            box-shadow: 0 10px 18px rgba(0,0,0,.06);
            display:flex;
            align-items:center;
            justify-content:center;
            color: rgba(75,51,43,.85);
            font-weight: 900;
            transition: transform .18s ease, background .18s ease;
            user-select:none;
        }
        .arrow-btn:hover{
            transform: translateY(-1px);
            background:#fff;
        }

        .impact-grid{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            align-items:stretch;
            margin-top: 12px;
        }

        /* kartu UMKM di impact — dibuat mirip style explore */
        .umkm-card{
            background:#fff;
            border-radius: 18px;
            border: 1px solid rgba(75,51,43,.14);
            box-shadow: 0 10px 18px rgba(0,0,0,.08);
            overflow:hidden;
            display:flex;
            flex-direction:column;
        }
        .umkm-img{
            padding: 14px 14px 0;
        }
        .umkm-img img{
            width:100%;
            height: 120px;
            object-fit: cover;
            border-radius: 16px;
        }
        .umkm-b{
            padding: 12px 14px 14px;
            display:flex;
            flex-direction:column;
            gap: 8px;
            min-height: 156px;
        }
        .umkm-pill{
            width: max-content;
            height: 20px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(39,32,28,.70);
            border: 1px solid rgba(255,255,255,.18);
            color:#fff;
            font-size: 10px;
            font-weight: 900;
            display:flex;
            align-items:center;
        }
        .umkm-title{
            font-family:"Playfair Display", serif;
            font-weight: 800;
            font-size: 14px;
            margin: 0;
        }
        .umkm-meta{
            font-size: 11px;
            color: rgba(43,38,33,.68);
            display:flex;
            justify-content: space-between;
            align-items:center;
            gap: 10px;
        }
        .umkm-btn{
            margin-top: auto;
            width: 100%;
            height: 36px;
            border-radius: 10px;
            background: var(--brown);
            color:#fff !important;
            font-weight: 900;
            font-size: 11px;
            display:flex;
            align-items:center;
            justify-content:center;
            transition: background .18s ease, transform .18s ease;
        }
        .umkm-btn:hover{ background: var(--brown-2); transform: translateY(-1px); }

        /* testimonials row */
        .testi-wrap{
            margin-top: 18px;
            padding: 12px 0 0;
        }
        .testi-title{
            font-family:"Playfair Display", serif;
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 12px;
            color: rgba(43,38,33,.92);
        }
        .testi-grid{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        .testi{
            background:#fff;
            border-radius: 18px;
            border: 1px solid rgba(75,51,43,.14);
            box-shadow: 0 10px 18px rgba(0,0,0,.06);
            padding: 14px;
        }
        .testi-top{
            display:flex;
            align-items:center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .ava{
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
        .tname{ font-weight: 900; font-size: 12px; }
        .ttext{
            margin:0;
            font-size: 12px;
            line-height: 1.75;
            color: rgba(43,38,33,.72);
        }

        /* ===================== VALUES ===================== */
        .values{
            background: rgba(246,240,232,.92);
            border-top: 1px solid rgba(75,51,43,.10);
            border-bottom: 1px solid rgba(75,51,43,.10);
            padding: 34px 0;
            margin-top: 22px;
        }
        .values h2{
            margin: 10px 0 10px;
            font-family:"Playfair Display", serif;
            font-size: 26px;
            font-weight: 800;
            text-align:center;
            color: rgba(43,38,33,.92);
        }
        .values .sub{
            text-align:center;
            margin: 0 auto 16px;
            max-width: 70ch;
            font-size: 12.5px;
            line-height: 1.7;
            color: rgba(43,38,33,.70);
        }
        .value-list{
            width: min(100%, 860px);
            margin: 0 auto;
            display:grid;
            gap: 12px;
        }
        .vitem{
            background:#fff;
            border-radius: 14px;
            border: 1px solid rgba(75,51,43,.14);
            padding: 12px 14px;
            display:flex;
            gap: 12px;
            align-items:flex-start;
        }
        .vicon{
            width: 34px; height: 34px;
            border-radius: 12px;
            background: rgba(107,75,62,.12);
            border: 1px solid rgba(107,75,62,.18);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight: 900;
            color: rgba(75,51,43,.92);
            flex: 0 0 auto;
        }
        .vtxt h4{
            margin:0 0 4px;
            font-weight: 900;
            font-size: 12px;
            color: rgba(43,38,33,.92);
        }
        .vtxt p{
            margin:0;
            font-size: 12px;
            line-height: 1.7;
            color: rgba(43,38,33,.70);
        }

        /* ===================== TEAM (lebih mirip kartu besar + tombol panjang) ===================== */
        .team{
    padding: 30px 0 8px;
}
.team h2{
    margin:0 0 14px;
    font-family:"Playfair Display", serif;
    font-size: 26px;
    font-weight: 800;
    text-align:center;
    color: rgba(43,38,33,.92);
}
.team-grid{
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    align-items: stretch;
}

/* ✅ Ardi tetap di tengah, tapi ukuran LEBAR-nya sama seperti kartu lain (1 kolom) */
.team-grid .member:nth-child(5),
.team-grid .member:last-child:nth-child(odd){
    grid-column: 1 / -1; /* tetap jadi baris sendiri */
    width: 100%;
    max-width: calc((100% - 16px) / 2); /* ✅ sama dengan lebar 1 kolom */
    margin: 0 auto; /* center */
}

/* ✅ gambar Ardi tetap proporsional (nggak kepanjangan) */
.team-grid .member:nth-child(5) .mimg,
.team-grid .member:last-child:nth-child(odd) .mimg{
    height: 250px; /* samain dengan member lain biar konsisten */
}

/* ====== Card ====== */
.member{
    background:#fff;
    border-radius: 18px;
    border: 1px solid rgba(75,51,43,.14);
    box-shadow: 0 10px 18px rgba(0,0,0,.06);
    overflow:hidden;
    padding: 14px;
}

.mimg{
    border-radius: 16px;
    overflow:hidden;
    border: 1px solid rgba(0,0,0,.06);
    height: 250px;
    background:#eee;
}
.mimg img{
    width:100%;
    height:100%;
    object-fit: cover;
}

.mtags{
    display:flex;
    gap: 8px;
    flex-wrap:wrap;
    margin: 12px 0 8px;
}
.mtag{
    height: 22px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 900;
    background: rgba(178,138,98,.25);
    border: 1px solid rgba(75,51,43,.16);
    color: rgba(75,51,43,.92);
    display:flex;
    align-items:center;
}
.mname{
    font-weight: 900;
    font-size: 13px;
    margin: 0 0 6px;
}
.mrole{
    font-size: 12px;
    color: rgba(43,38,33,.68);
    margin: 0 0 10px;
    min-height: 18px;
}

.mbtn{
    width:100%;
    height: 38px;
    border-radius: 10px;
    background: var(--brown);
    color:#fff !important;
    font-weight: 900;
    font-size: 11px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition: background .18s ease, transform .18s ease;
    margin-top: 10px;
}
.mbtn:hover{ background: var(--brown-2); transform: translateY(-1px); }

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

            .grid-2{ grid-template-columns: 1fr; }
            .impact-grid{ grid-template-columns: repeat(2, 1fr); }
            .testi-grid{ grid-template-columns: 1fr; }
            .team-grid{ grid-template-columns: 1fr; }
            .footer-inner{ grid-template-columns: 1fr 1fr; }

            .hero{ min-height: 380px; padding-top: 110px; }
            .hero-title{ font-size: 30px; }

            /* mission responsive */
            .band .section-head h2{ font-size: 30px; }
            .img-frame.big{ height: 320px; }
            .img-frame.small{ height: 220px; }
        }
        @media (max-width: 640px){
            .impact-grid{ grid-template-columns: 1fr; }
            .footer-inner{ grid-template-columns: 1fr; }

            .img-frame.big{ height: 260px; }
        }
    </style>
</head>

<body>

@php
    // fallback data biar halaman tetap jadi walau route belum kirim
    $about = $about ?? [
        'hero_title' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'hero_desc'  => "Lokana helps connect local artisans and MSMEs to broader audiences through meaningful stories, culture, and products.",
        'hero_image' => asset('images/about-hero.png'),

        'mission_title' => 'Our mission',
        'mission_heading' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'mission_left_image' => asset('images/about-mission-1.jpg'),
        'mission_right_image' => asset('images/about-mission-2.jpg'),
        'mission_cards' => [
            ['tag'=>'Our mission', 'title'=>'Revitalizing Tradition for the Modern Era.', 'desc'=>'We help cultural products remain relevant through design, storytelling, and digital access.'],
            ['tag'=>'Our mission', 'title'=>'Bridging Local Artisans to the Global Stage', 'desc'=>'We bring exposure to Balinese MSMEs so their works can be recognized widely.'],
        ],

        'stats_title' => 'Our impact',
        'stats_heading' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'stat_1' => ['num'=>'500+', 'label'=>'MSMEs are helped'],
        'stat_2' => ['num'=>'1000+', 'label'=>'visitors feel happy'],

        'impact_cards' => collect(range(1,4))->map(fn($i)=>[
            'image' => asset("images/explore-$i.jpg"),
            'badge' => 'HandCraft',
            'title' => $i===2 ? "Bali’s Arjuna’s mask" : "Bali’s Statue Carving",
            'rating'=> '4.9',
            'author'=> 'Pande Sujana',
            'url'   => '#',
        ])->toArray(),

        'testi_title' => '1000+ visitors feel happy',
        'testimonials' => [
            ['initials'=>'MA','name'=>'Made Ari','text'=>'The platform is amazing. It helps me discover authentic Balinese crafts and stories in one place.'],
            ['initials'=>'KA','name'=>'Kadek Ayu','text'=>'Beautiful design and meaningful stories. I love how it connects culture with modern needs.'],
            ['initials'=>'BP','name'=>'Bagus Putra','text'=>'As an artisan, I feel supported. My work gets exposure and customers understand my story.'],
        ],

        'values_title' => 'Our vision',
        'values_heading' => 'What Drives Us.',
        'values' => [
            ['title'=>'Quality', 'desc'=>'We prioritize authenticity and craftsmanship in every product and story.'],
            ['title'=>'Quality', 'desc'=>'We ensure every MSME receives fair exposure and sustainable growth.'],
            ['title'=>'Quality', 'desc'=>'We connect culture with modern audiences in a respectful way.'],
            ['title'=>'Quality', 'desc'=>'We focus on community impact for artisans and local families.'],
        ],

        'team_title' => 'Our team',
        'team' => [
            ['name'=>'Risky', 'role'=>'Project Manager', 'tag1'=>'Project Manager', 'tag2'=>'Team member', 'image'=>asset('images/team-1.jpg')],
            ['name'=>'Surya', 'role'=>'UI/UX Designer', 'tag1'=>'UI/UX Designer', 'tag2'=>'Team member', 'image'=>asset('images/team-2.jpg')],
            ['name'=>'Pamji', 'role'=>'Frontend Dev', 'tag1'=>'Frontend Dev', 'tag2'=>'Team member', 'image'=>asset('images/team-3.jpg')],
            ['name'=>'Gung Jaya', 'role'=>'Backend Dev', 'tag1'=>'Backend Dev', 'tag2'=>'Team member', 'image'=>asset('images/team-4.jpg')],
        ],
    ];
@endphp

<section class="hero" id="top">
    <div class="hero-bg" aria-hidden="true">
        {{-- IMAGE FORMAT --}}
        <img src="{{ asset('images/hero-bali.jpg') }}" alt="Hero Background">
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
                    <a class="active" href="{{ route('about.us') }}">About Us</a>
                    <a href="{{ route('faq.page') }}">FAQ</a>
                </nav>

                <div class="nav-cta">
                    <a class="btn btn-ghost" href="{{ route('register.index') }}">Sign up</a>
                    <a class="btn btn-solid" href="{{ route('login.index') }}">Sign in</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container hero-content">
        <h1 class="hero-title">{{ $about['hero_title'] }}</h1>
        <p class="hero-desc">{{ $about['hero_desc'] }}</p>

        <div class="hero-illus">
            {{-- IMAGE FORMAT --}}
            <img src="{{ $about['hero_image'] }}" alt="image icon">
        </div>
    </div>

    {{-- ✅ tombol panah bawah --}}
    <a class="scroll-down" href="#mission" aria-label="Scroll to Mission">
        <span>↓</span>
    </a>
</section>

<main class="page">

    {{-- MISSION BAND --}}
    <section class="band" id="mission">
        <div class="container">
            <div class="section-head">
                <span class="pill">{{ $about['mission_title'] ?? 'Our mission' }}</span>
                <h2>{{ $about['mission_heading'] ?? '' }}</h2>
            </div>

            <div class="grid-2">
                {{-- LEFT BIG IMAGE (lebih mirip design) --}}
                <div class="img-card">
                    <div class="img-frame big">
                        <div class="img-ph" aria-hidden="true"></div>

                        {{-- IMAGE FORMAT --}}
                        <img
                            src="{{ $about['mission_left_image'] }}"
                            alt=""
                            onerror="this.style.display='none';"
                        >
                    </div>
                </div>

                <div class="stack">
                    @foreach(($about['mission_cards'] ?? []) as $c)
                        <div class="card">
                            <div class="tag">{{ $c['tag'] }}</div>
                            <h3 class="ctitle">{{ $c['title'] }}</h3>
                            <p class="cdesc">{{ $c['desc'] }}</p>
                        </div>
                    @endforeach

                    {{-- RIGHT BOTTOM IMAGE (lebih mirip design) --}}
                    <div class="img-card">
                        <div class="img-frame small">
                            <div class="img-ph" aria-hidden="true"></div>

                            {{-- IMAGE FORMAT --}}
                            <img
                                src="{{ $about['mission_right_image'] }}"
                                alt=""
                                onerror="this.style.display='none';"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- IMPACT --}}
    <section class="impact" id="impact">
        <div class="container">
            <div class="section-head" style="margin-bottom:10px;">
                <span class="pill">{{ $about['stats_title'] ?? 'Our impact' }}</span>
                <h2>{{ $about['stats_heading'] ?? '' }}</h2>
            </div>

            <div class="impact-top">
                <div class="stats">
                    <div class="stat">
                        <div class="num">{{ $about['stat_1']['num'] ?? '500+' }}</div>
                        <div class="lbl">{{ $about['stat_1']['label'] ?? '' }}</div>
                    </div>
                    <div class="stat">
                        <div class="num">{{ $about['stat_2']['num'] ?? '1000+' }}</div>
                        <div class="lbl">{{ $about['stat_2']['label'] ?? '' }}</div>
                    </div>
                </div>

                {{-- tombol panah kanan-kiri (visual mirip design) --}}
                <div class="nav-arrows" aria-hidden="true">
                    <div class="arrow-btn">‹</div>
                    <div class="arrow-btn">›</div>
                </div>
            </div>

            <div class="impact-grid">
                @foreach(($about['impact_cards'] ?? []) as $it)
                    <article class="umkm-card">
                        <div class="umkm-img">
                            {{-- IMAGE FORMAT --}}
                            <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}">
                        </div>
                        <div class="umkm-b">
                            <div class="umkm-pill">{{ $it['badge'] }}</div>
                            <p class="umkm-title">{{ $it['title'] }}</p>
                            <div class="umkm-meta">
                                <span>★ {{ $it['rating'] }}</span>
                                <span>By {{ $it['author'] }}</span>
                            </div>
                            <a class="umkm-btn" href="{{ $it['url'] }}">View Detail</a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Testimonials --}}
            <div class="testi-wrap">
                <h2 class="testi-title">{{ $about['testi_title'] ?? 'Testimonials' }}</h2>
                <div class="testi-grid">
                    @foreach(($about['testimonials'] ?? []) as $t)
                        <div class="testi">
                            <div class="testi-top">
                                <div class="ava">{{ $t['initials'] ?? 'U' }}</div>
                                <div>
                                    <div class="tname">{{ $t['name'] ?? 'User' }}</div>
                                    <div style="font-size:11px; color:rgba(43,38,33,.60);">Testimonial</div>
                                </div>
                            </div>
                            <p class="ttext">{{ $t['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- VALUES --}}
    <section class="values" id="vision">
        <div class="container">
            <div class="section-head">
                <span class="pill">{{ $about['values_title'] ?? 'Our vision' }}</span>
                <h2>{{ $about['values_heading'] ?? 'What Drives Us.' }}</h2>
            </div>
            <p class="sub">We focus on culture, quality, and community impact—helping Balinese artisans grow sustainably.</p>

            <div class="value-list">
                @foreach(($about['values'] ?? []) as $v)
                    <div class="vitem">
                        <div class="vicon">✦</div>
                        <div class="vtxt">
                            <h4>{{ $v['title'] }}</h4>
                            <p>{{ $v['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TEAM --}}
    <section class="team" id="team">
        <div class="container">
            <h2>{{ $about['team_title'] ?? 'Our team' }}</h2>

            <div class="team-grid">
                @foreach(($about['team'] ?? []) as $m)
                    <article class="member">
                        <div class="mimg">
                            {{-- IMAGE FORMAT --}}
                            <img src="{{ $m['image'] }}" alt="{{ $m['name'] }}">
                        </div>

                        <div class="mtags">
                            <span class="mtag">{{ $m['tag1'] ?? ($m['role'] ?? 'Role') }}</span>
                            <span class="mtag">{{ $m['tag2'] ?? 'Team member' }}</span>
                        </div>

                        <p class="mname">{{ $m['name'] }}</p>
                        <p class="mrole">{{ $m['role'] }}</p>

                        <a class="mbtn" href="#">Get in touch</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

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
                    <a href="{{ route('about.us') }}">About Us</a>
                </div>
            </div>

            <div>
                <div class="footer-title">Quick Links</div>
                <div class="footer-links">
                    <a href="{{ route('about.us') }}">About Us</a>
                    <a href="{{ route('explore.umkm') }}">Explore UMKM</a>
                    <a href="{{ route('landing-page') }}#articles">Article</a>
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
