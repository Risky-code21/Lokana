<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokana - Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg: #EFE6DB;
            --surface: #FFFFFF;
            --text: #2B2621;
            --muted: #6E6258;

            --brown: #6B4B3E;     /* coklat tua */
            --brown-2: #4B332B;   /* lebih tua */
            --sand: #B28A62;      /* coklat muda (Hire Me) */

            --border: rgba(0,0,0,.10);
            --shadow: 0 12px 28px rgba(0,0,0,.10);

            --radius-xl: 22px;
            --radius-lg: 16px;
            --radius-md: 12px;

            --maxw: 1120px;
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background: var(--bg);
            color: var(--text);
        }
        a{ color: inherit; text-decoration:none; }

        .container{
            width: min(100% - 40px, var(--maxw));
            margin: 26px auto 80px;
        }

        /* ========== CARD WRAPPER (mirip desain: border halus + shadow) ========== */
        .panel{
            background: var(--surface);
            border: 1px solid rgba(0,0,0,.08);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* ========== HEADER / COVER ========== */
        .profile-header{
            overflow:hidden;
        }
        .cover{
            height: 190px;
            background: #ddd center/cover no-repeat;
            position: relative;
        }
        .cover::after{
            content:"";
            position:absolute; inset:0;
            background: linear-gradient(180deg, rgba(0,0,0,.06) 0%, rgba(0,0,0,.22) 100%);
        }

        .cover-actions{
            position:absolute;
            right: 22px;
            top: 22px;
            z-index: 2;
        }

        /* Button style mengikuti desain */
        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 13px;
            cursor:pointer;
            transition: background .18s ease, transform .18s ease, border-color .18s ease, color .18s ease, box-shadow .18s ease;
            white-space:nowrap;
        }
        .btn:hover{ transform: translateY(-1px); }
        .btn:active{ transform: translateY(0); }

        /* Update Cover pill putih */
        .btn-white{
            background: rgba(255,255,255,.92);
            border-color: rgba(255,255,255,.75);
            color: var(--brown-2);
            border-radius: 999px;
            box-shadow: 0 10px 20px rgba(0,0,0,.10);
            gap: 10px;
        }
        .btn-white:hover{ background:#fff; }
        .btn-white:active{ background: rgba(255,255,255,.86); }

        /* Follow outline (putih, border) */
        .btn-outline{
            background: #fff;
            color: var(--text);
            border: 1px solid rgba(0,0,0,.14);
            min-width: 120px;
        }
        .btn-outline:hover{
            background: rgba(0,0,0,.02);
            border-color: rgba(0,0,0,.22);
        }

        /* Hire Me coklat muda */
        .btn-brown{
            background: var(--sand);
            color:#fff;
            border-color: rgba(0,0,0,.06);
            min-width: 140px;
        }
        .btn-brown:hover{ background: var(--brown); }
        .btn-brown:active{ background: var(--brown-2); }

        /* BODY HEADER (bagian putih) */
        .profile-body{
            padding: 22px 28px 26px;
            position: relative;
        }

        /* Avatar center + edit icon tepat seperti desain */
        .avatar-wrap{
            position:absolute;
            left: 50%;
            transform: translateX(-50%);
            top: -56px;
            display:flex;
            align-items:flex-end;
        }
        .avatar{
            width: 96px;
            height: 96px;
            border-radius: 999px;
            border: 7px solid var(--surface);
            background: #ddd center/cover no-repeat;
            box-shadow: 0 10px 22px rgba(0,0,0,.14);
        }
        .avatar-edit{
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 4px solid var(--surface);
            background: var(--sand);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 10px 20px rgba(0,0,0,.12);
            margin-left: -18px;
            margin-bottom: 6px;
            color:#fff;
            font-size: 14px;
            font-weight:900;
        }
        .avatar-edit:hover{ background: var(--brown); }
        .avatar-edit:active{ background: var(--brown-2); }

        /* Meta row (ikon kecil coklat, teks muted) */
        .meta-row{
            display:flex;
            justify-content:center;
            gap: 20px;
            flex-wrap:wrap;
            margin-top: 44px; /* ngasih space untuk avatar */
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
        }
        .meta{
            display:flex;
            align-items:center;
            gap: 8px;
        }
        .icon{
            width: 18px;
            height: 18px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color: var(--sand);
        }
        .icon svg{ width: 18px; height: 18px; fill: currentColor; }

        .name{
            text-align:center;
            font-weight: 800;
            margin: 12px 0 0;
            font-size: 18px;
        }

        /* bar + actions (posisi mirip desain) */
        .header-bottom{
            display:grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 18px;
            align-items:center;
            margin-top: 18px;
        }

        .completion{
            padding: 10px 0 0;
        }
        .completion-title{
            font-weight: 800;
            margin-bottom: 12px;
        }
        .bar-row{
            display:grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items:center;
        }
        .bar{
            height: 8px;                 /* lebih tipis, mirip desain */
            border-radius: 999px;
            background: rgba(0,0,0,.10);
            overflow:hidden;
        }
        .bar > div{
            height:100%;
            width: 50%;
            border-radius: 999px;
            background: var(--sand);
        }
        .pct{
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            min-width: 44px;
            text-align:right;
        }

        .actions{
            display:flex;
            justify-content:flex-end;
            gap: 12px;
            padding-top: 24px; /* naikkan sejajar dengan bar */
        }

        /* ========== FORM PANEL (padding & radius mirip desain) ========== */
        .section{
            margin-top: 22px;
            padding: 34px 34px 30px;
        }
        .section h3{
            margin: 0 0 18px;
            font-size: 18px;
            font-weight: 900;
        }

        .grid-2{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .grid-1{ display:grid; gap: 18px; }

        .input{
            width:100%;
            padding: 16px 18px;
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,.14);
            background: #fff;
            outline:none;
            font-size: 13.5px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .input:focus{
            border-color: rgba(178,138,98,.85);
            box-shadow: 0 0 0 4px rgba(178,138,98,.18);
        }
        textarea.input{
            min-height: 150px;  /* lebih tinggi seperti desain */
            resize: none;       /* desain terlihat fixed */
        }

        .divider{
            height: 1px;
            background: rgba(0,0,0,.08);
            margin: 28px 0;
        }

        /* Responsive */
        @media (max-width: 900px){
            .header-bottom{ grid-template-columns: 1fr; }
            .actions{ justify-content:center; padding-top: 8px; }
            .grid-2{ grid-template-columns: 1fr; }
            .section{ padding: 26px; }
            .cover-actions{ right: 14px; top: 14px; }
        }
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER PANEL --}}
    <div class="panel profile-header">
        <div class="cover" style="background-image:url('{{ $user['cover'] }}')">
            <div class="cover-actions">
                <a href="#" class="btn btn-white">
                    <span class="icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M9 4l1.5 2H20a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h3L9 4zm3 6a4 4 0 100 8 4 4 0 000-8z"/></svg>
                    </span>
                    Update Cover
                </a>
            </div>
        </div>

        <div class="profile-body">
            <div class="avatar-wrap">
                <div class="avatar" style="background-image:url('{{ $user['avatar'] }}')"></div>
                <a href="#" class="avatar-edit" title="Edit">✎</a>
            </div>

            <div class="meta-row">
                <div class="meta">
                    <span class="icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 10-5-5 5 5 0 005 5zm0 2c-4.42 0-8 2-8 4.5V21h16v-2.5C20 16 16.42 14 12 14z"/></svg>
                    </span>
                    {{ $user['role'] }}
                </div>

                <div class="meta">
                    <span class="icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1114.5 9 2.5 2.5 0 0112 11.5z"/></svg>
                    </span>
                    {{ $user['location'] }}
                </div>

                <div class="meta">
                    <span class="icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M7 2v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2h-2V2h-2v2H9V2H7zm12 8H5v10h14V10z"/></svg>
                    </span>
                    {{ $user['joined'] }}
                </div>
            </div>

            <div class="name">{{ $user['name'] }}</div>

            <div class="header-bottom">
                <div class="completion">
                    <div class="completion-title">Profile Completion</div>
                    <div class="bar-row">
                        <div class="bar">
                            <div style="width: {{ (int)($user['completion'] ?? 50) }}%;"></div>
                        </div>
                        <div class="pct">{{ (int)($user['completion'] ?? 50) }}%</div>
                    </div>
                </div>

                <div class="actions">
                    <a class="btn btn-outline" href="#">Follow</a>
                    <a class="btn btn-brown" href="#">Hire Me</a>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM PANEL --}}
    <div class="panel section">
        <h3>Edit Your Account Infomation</h3>

        <div class="grid-2">
            <input class="input" type="text" placeholder="First Name">
            <input class="input" type="text" placeholder="Last Name">
        </div>

        <div class="grid-2" style="margin-top:18px;">
            <input class="input" type="text" placeholder="Product">
            <input class="input" type="text" placeholder="Location">
        </div>

        <div class="grid-1" style="margin-top:18px;">
            <textarea class="input" placeholder="About You/Bio"></textarea>
        </div>

        <div class="divider"></div>

        <h3>Profesional Info</h3>

        <div class="grid-2">
            <input class="input" type="text" placeholder="First Name">
            <input class="input" type="text" placeholder="First Name">
        </div>

        <div class="grid-2" style="margin-top:18px;">
            <input class="input" type="text" placeholder="First Name">
            <input class="input" type="text" placeholder="First Name">
        </div>
    </div>

</div>

</body>
</html>
