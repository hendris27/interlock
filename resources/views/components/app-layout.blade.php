<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} · CLL Interlock System</title>
    <style>
        :root {
            --ink: #10243d;
            --muted: #d4e7fa;
            --line: rgba(255, 255, 255, .32);
            --blue: #1677d2;
            --blue-dark: #082b57;
            --blue-soft: #eaf5ff;
            --green: #18794e;
            --green-soft: #eaf7f0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            margin: 0;
            min-height: 100dvh;
            background: linear-gradient(135deg, #071d3a 0%, #0b4f91 48%, #20a4d8 100%);
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page {
            width: 100%;
            min-height: 100dvh;
            padding: 0 3.5rem 2.25rem;
            position: relative;
            background: linear-gradient(150deg, rgba(6, 28, 58, .35), rgba(16, 123, 196, .16));
            box-shadow: 0 18px 50px rgba(0, 13, 35, .25);
        }

        .page::before,
        .page::after {
            content: '';
            position: absolute;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 50%;
            pointer-events: none;
        }

        .page::before {
            width: 30rem;
            height: 30rem;
            right: -13rem;
            top: -12rem;
            box-shadow: 0 0 0 3rem rgba(255, 255, 255, .035), 0 0 0 7rem rgba(255, 255, 255, .025);
        }

        .page::after {
            width: 18rem;
            height: 18rem;
            left: -10rem;
            bottom: -9rem;
        }

        .sidebar {
            position: absolute;
            z-index: 2;
            top: 0;
            bottom: 0;
            left: 0;
            width: 235px;
            padding: 2.2rem 1.25rem;
            background: rgba(2, 21, 48, .42);
            transition: left .28s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            margin: 0 0 4rem;
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .sidebar-brand span {
            display: grid;
            place-items: center;
            width: 2rem;
            height: 2rem;
            color: var(--blue-dark);
            background: #fff;
            border-radius: 6px;
        }

        .nav-label {
            margin: 0 0 1rem .8rem;
            color: #9ec8e9;
            font-size: .64rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .nav-list {
            display: grid;
            gap: .4rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .8rem;
            color: #d4e7fa;
            border-radius: 7px;
            font-size: .78rem;
            text-decoration: none;
            transition: color .2s ease, background .2s ease;
        }

        .nav-link::before {
            content: '';
            width: 7px;
            height: 7px;
            border: 1px solid currentColor;
            border-radius: 2px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .14);
        }

        .nav-link.active::before {
            background: #fff;
        }

        header {
            padding: 4.8rem 1rem 3.8rem;
            margin-left: 235px;
            text-align: center;
            position: relative;
            z-index: 1;
            transition: margin-left .28s ease;
        }

        .sidebar-toggle {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            display: grid;
            place-items: center;
            width: 2.3rem;
            height: 2.3rem;
            color: #fff;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 7px;
            cursor: pointer;
            font-size: 1.2rem;
            line-height: 1;
            transition: left .28s ease, right .28s ease, background .2s ease, transform .2s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, .24);
            transform: scale(1.04);
        }

        .sidebar-toggle:focus-visible {
            outline: 3px solid rgba(255, 255, 255, .45);
            outline-offset: 3px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .7rem;
            margin: 0;
            font-size: clamp(1.7rem, 3vw, 2.5rem);
            font-weight: 700;
            letter-spacing: .01em;
        }

        main {
            min-height: calc(100dvh - 12rem);
            margin-left: 235px;
            position: relative;
            z-index: 1;
            transition: margin-left .28s ease;
        }

        .page.sidebar-hidden .sidebar {
            left: -235px;
        }

        .page.sidebar-hidden header,
        .page.sidebar-hidden main {
            margin-left: 0;
        }

        .page.sidebar-hidden .sidebar-toggle {
            position: fixed;
            z-index: 5;
            top: 1.25rem;
            right: auto;
            left: 1rem;
        }

        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .notice,
        .errors {
            width: 100%;
            margin: 1rem auto;
            padding: .8rem 1rem;
            border: 1px solid;
            border-radius: 7px;
            font-size: .74rem;
            line-height: 1.4;
            text-align: center;
        }

        .notice {
            color: var(--green);
            background: var(--green-soft);
            border-color: rgba(168, 222, 193, .85);
        }

        .errors {
            color: #a22d35;
            background: #fff1f2;
            border-color: #e7b7bb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 7px;
            overflow: hidden;
            margin-top: 1.5rem;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            font-size: .82rem;
        }

        th {
            background: rgba(255, 255, 255, .06);
            font-weight: 700;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, .04);
        }

        a {
            color: var(--blue);
            text-decoration: none;
            transition: color .2s ease;
        }

        a:hover {
            color: #fff;
        }

        .btn,
        .btn-primary {
            display: inline-block;
            padding: .6rem 1.2rem;
            margin: 0.5rem 0.5rem 0.5rem 0;
            border: 0;
            border-radius: 7px;
            background: var(--blue);
            color: #fff;
            cursor: pointer;
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease, transform .2s ease;
        }

        .btn:hover,
        .btn-primary:hover {
            background: #13699a;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #c41e3a;
        }

        .btn-danger:hover {
            background: #a01830;
        }

        @media (max-width: 700px) {
            .page {
                padding: 0 1rem 1.5rem;
            }

            .sidebar {
                position: relative;
                width: auto;
                padding: 1rem;
                background: rgba(2, 21, 48, .34);
                border-bottom: 1px solid rgba(255, 255, 255, .14);
                transition: margin-left .28s ease;
            }

            .sidebar-brand {
                margin: 0 0 1rem;
            }

            .nav-label {
                display: none;
            }

            .nav-list {
                grid-template-columns: repeat(4, 1fr);
                gap: .3rem;
            }

            .nav-link {
                justify-content: center;
                padding: .65rem .3rem;
                font-size: .65rem;
                text-align: center;
            }

            .nav-link::before {
                display: none;
            }

            header {
                margin-left: 0;
                padding: 3rem .5rem 2.5rem;
            }

            .sidebar-toggle {
                position: fixed;
                z-index: 5;
                top: 1rem;
                left: 1rem;
                right: auto;
            }

            .page.sidebar-hidden .sidebar {
                left: 0;
                margin-left: -100%;
            }

            main {
                margin-left: 0;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="page">
        <aside class="sidebar" aria-label="Navigasi utama">
            <button class="sidebar-toggle" type="button" aria-label="Sembunyikan sidebar"
                aria-expanded="true">&#8249;</button>
            <div class="sidebar-brand"><span>I</span> Interlock</div>
            <p class="nav-label">Workspace</p>
            <nav>
                <ul class="nav-list">
                    <li><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Dashboard</a></li>
                    <li><a class="nav-link {{ request()->routeIs('master-data.*') ? 'active' : '' }}"
                            href="{{ route('master-data.index') }}">Master Data</a></li>
                    <li><a class="nav-link" href="#scan">Scan Komponen</a></li>
                    <li><a class="nav-link" href="#history">Riwayat Scan</a></li>
                    <li><a class="nav-link" href="#settings">Pengaturan</a></li>
                </ul>
            </nav>
        </aside>
        <header>
            <div class="brand">{{ $title ?? 'Dashboard' }}</div>
        </header>
        <main>
            <div class="content">
                @if ($errors->any())
                    <div class="errors" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
    <script>
        const page = document.querySelector('.page');
        const sidebarToggle = document.querySelector('.sidebar-toggle');

        sidebarToggle.addEventListener('click', () => {
            const isHidden = page.classList.toggle('sidebar-hidden');
            sidebarToggle.setAttribute('aria-expanded', String(!isHidden));
            sidebarToggle.setAttribute('aria-label', isHidden ? 'Tampilkan sidebar' : 'Sembunyikan sidebar');
            sidebarToggle.innerHTML = isHidden ? '&#8250;' : '&#8249;';
        });

        // SweetAlert untuk Success Message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#1677d2',
                confirmButtonText: 'OK'
            });
        @endif

        // SweetAlert untuk Error Message
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#1677d2',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
</body>

</html>
