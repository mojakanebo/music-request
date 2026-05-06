<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Dashboard - Music Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.5);
            --bg-deep: #020617;
            --bg-surface: rgba(15, 23, 42, 0.7);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg-deep);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .blob {
            position: fixed;
            width: 600px;
            height: 600px;
            background: var(--accent);
            filter: blur(150px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.1;
            top: 20%;
            left: 20%;
        }

        nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: #ef4444;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .card {
            background: var(--bg-surface);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        h2.section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: white;
        }

        .form-group { margin-bottom: 20px; position: relative; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; }
        .form-control {
            width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border);
            border-radius: 12px; padding: 14px 16px; color: white; font-family: inherit; font-size: 15px; transition: all 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 4px var(--accent-glow); }

        .btn-action {
            width: 100%; background: var(--accent); color: white; border: none; border-radius: 12px;
            padding: 16px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.3s;
        }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px var(--accent-glow); filter: brightness(1.1); }
        .btn-disabled {
            background: #475569; cursor: not-allowed; opacity: 0.7;
        }
        .btn-disabled:hover { transform: none; box-shadow: none; filter: none; }

        .track-card {
            background: rgba(255, 255, 255, 0.03); border: 1px solid var(--glass-border);
            border-radius: 16px; padding: 16px 20px; margin-bottom: 16px; display: flex; align-items: center; gap: 15px;
        }

        /* Notifications */
        .toast { position: fixed; top: 30px; right: 30px; padding: 16px 24px; border-radius: 16px; backdrop-filter: blur(10px); z-index: 1000; border: 1px solid var(--glass-border); box-shadow: 0 10px 25px rgba(0,0,0,0.3); animation: slideIn 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28); }
        .toast-success { background: rgba(16, 185, 129, 0.2); color: #10b981; border-color: rgba(16, 185, 129, 0.3); }
        .toast-error { background: rgba(239, 68, 68, 0.2); color: #ef4444; border-color: rgba(239, 68, 68, 0.3); }
        @keyframes slideIn { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Autocomplete */
        .suggestions-dropdown {
            position: absolute; top: 100%; left: 0; right: 0; background: #1e293b; border: 1px solid var(--glass-border);
            border-radius: 12px; margin-top: 8px; max-height: 300px; overflow-y: auto; z-index: 100; display: none;
        }
        .suggestion-item { padding: 12px 15px; display: flex; align-items: center; gap: 12px; cursor: pointer; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .suggestion-item:hover { background: rgba(16, 185, 129, 0.1); }
        .suggestion-item img { width: 40px; height: 40px; border-radius: 8px; }
        .suggestion-info { display: flex; flex-direction: column; }
        .suggestion-title { font-size: 14px; font-weight: 600; }
        .suggestion-artist { font-size: 12px; color: var(--text-secondary); }

        @media (max-width: 900px) {
            .container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="blob"></div>

    @if(session('success'))
        <div class="toast toast-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="toast toast-error">{{ session('error') }}</div>
    @endif

    <nav>
        <div class="logo">Music Request</div>
        <div class="user-menu">
            <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
            <a href="{{ route('logout') }}" class="btn-logout" style="text-decoration: none; display: inline-block;">Logout</a>
        </div>
    </nav>

    <div class="container">
        <aside class="card">
            <h2 class="section-title">Request Lagu Baru</h2>
            
            @if($hasRequestedToday)
                <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); padding: 20px; border-radius: 12px; text-align: center; margin-bottom: 20px;">
                    <div style="font-size: 32px; margin-bottom: 10px;">🕒</div>
                    <div style="color: #f59e0b; font-weight: 600; margin-bottom: 5px;">Batas Personal Tercapai</div>
                    <p style="color: var(--text-secondary); font-size: 14px;">Anda sudah melakukan request hari ini. Silakan kembali besok untuk request lagu lainnya!</p>
                </div>
                <button class="btn-action btn-disabled" disabled>Kirim Sekarang</button>
            @elseif($isGlobalLimitReached)
                <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 20px; border-radius: 12px; text-align: center; margin-bottom: 20px;">
                    <div style="font-size: 32px; margin-bottom: 10px;">🛑</div>
                    <div style="color: #ef4444; font-weight: 600; margin-bottom: 5px;">Kuota Hari Ini Penuh</div>
                    <p style="color: var(--text-secondary); font-size: 14px;">Maaf, kuota sekolah untuk hari ini (maksimal 3 request) sudah terisi penuh oleh siswa lain. Coba lagi besok pagi!</p>
                </div>
                <button class="btn-action btn-disabled" disabled>Kirim Sekarang</button>
            @else
                <form method="POST" action="{{ route('siswa.request.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Cari Lagu</label>
                        <input type="text" id="judulLaguInput" name="judul_lagu" class="form-control" placeholder="Ketik judul lagu / penyanyi..." required>
                        <input type="hidden" id="albumArtInput" name="album_art">
                        <div id="itunesSuggestions" class="suggestions-dropdown"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Pengirim</label>
                        <input type="text" name="nama_pengirim" class="form-control" value="{{ Auth::user()->name }}" placeholder="Nama kamu..." required>
                    </div>
                    <button type="submit" class="btn-action">Kirim Request</button>
                </form>
            @endif
        </aside>

        <main class="card">
            <h2 class="section-title">Riwayat Request Kamu</h2>
            
            <div style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                @forelse($myRequests as $lagu)
                <div class="track-card">
                    <img src="{{ $lagu->album_art ?? 'https://via.placeholder.com/50x50?text=♫' }}" 
                         style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;" alt="Art">
                    <div>
                        <div style="font-weight: 600; font-size: 16px;">{{ $lagu->judul_lagu }}</div>
                        <div style="font-size: 13px; color: var(--text-secondary); margin-top: 4px;">
                            Dikirim {{ $lagu->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                    Belum ada riwayat request.
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <script>
        const input = document.getElementById('judulLaguInput');
        if(input) {
            const suggestions = document.getElementById('itunesSuggestions');
            const albumArtInput = document.getElementById('albumArtInput');
            let debounceTimer;

            input.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                const query = input.value.trim();
                
                if (query.length < 2) {
                    suggestions.style.display = 'none';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`https://itunes.apple.com/search?term=${encodeURIComponent(query)}&media=music&limit=5`)
                        .then(res => res.json())
                        .then(data => {
                            suggestions.innerHTML = '';
                            if (data.results.length > 0) {
                                data.results.forEach(song => {
                                    const div = document.createElement('div');
                                    div.className = 'suggestion-item';
                                    div.onclick = () => selectSong(song.trackName, song.artistName, song.artworkUrl100);
                                    div.innerHTML = `
                                        <img src="${song.artworkUrl60}" alt="Art">
                                        <div class="suggestion-info">
                                            <span class="suggestion-title">${song.trackName}</span>
                                            <span class="suggestion-artist">${song.artistName}</span>
                                        </div>
                                    `;
                                    suggestions.appendChild(div);
                                });
                                suggestions.style.display = 'block';
                            } else {
                                suggestions.style.display = 'none';
                            }
                        });
                }, 300);
            });

            window.selectSong = (track, artist, art) => {
                input.value = `${track} - ${artist}`;
                albumArtInput.value = art;
                suggestions.style.display = 'none';
            };

            document.addEventListener('click', (e) => {
                if (!suggestions.contains(e.target) && e.target !== input) {
                    suggestions.style.display = 'none';
                }
            });
        }

        // Hide toast notification after 3 seconds
        setTimeout(function() {
            let toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 500);
            });
        }, 3000);
    </script>
</body>
</html>
