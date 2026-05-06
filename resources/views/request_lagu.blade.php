<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Lagu - Modern Vibes</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-deep);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Abstract Background Elements */
        .blob {
            position: fixed;
            width: 500px;
            height: 500px;
            background: var(--accent);
            filter: blur(150px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.1;
            animation: move 20s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-10%, -10%); }
            to { transform: translate(20%, 20%); }
        }

        /* Main Container */
        .glass-container {
            width: 100vw;
            height: 100vh;
            background: var(--bg-surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: none;
            border-radius: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Header Section */
        .hero-header {
            padding: 40px;
            background: linear-gradient(to right, rgba(16, 185, 129, 0.2), transparent);
            border-bottom: 1px solid var(--glass-border);
            text-align: center;
        }

        .hero-header h1 {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(to right, #fff, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .hero-header p {
            color: var(--text-secondary);
            font-size: 16px;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 1px;
            background: var(--glass-border);
            flex: 1;
        }

        /* Form Area */
        .form-section {
            background: rgba(15, 23, 42, 0.4);
            padding: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 14px 16px;
            color: white;
            font-family: inherit;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .btn-action {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px var(--accent-glow);
            filter: brightness(1.1);
        }

        /* List Area */
        .list-section {
            background: transparent;
            padding: 40px;
            flex: 1;
            overflow-y: auto;
        }

        .track-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInTrack 0.5s ease-out forwards;
        }

        @keyframes slideInTrack {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .track-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.01);
        }

        .track-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .track-title {
            font-weight: 600;
            font-size: 16px;
        }

        .track-meta {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .meta-tag {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 8px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Notifications */
        .toast {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 16px 24px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 1000;
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            animation: slideIn 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28);
        }

        .toast-success { background: rgba(16, 185, 129, 0.2); color: #10b981; border-color: rgba(16, 185, 129, 0.3); }
        .toast-error { background: rgba(239, 68, 68, 0.2); color: #ef4444; border-color: rgba(239, 68, 68, 0.3); }

        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Custom Scrollbar */
        .list-section::-webkit-scrollbar { width: 6px; }
        .list-section::-webkit-scrollbar-track { background: transparent; }
        .list-section::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .list-section::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Responsive */
        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .glass-container {
                border-radius: 0;
                margin: -40px -20px;
                min-height: 100vh;
            }
            .hero-header h1 {
                font-size: 32px;
            }
        }

        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1e293b;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            margin-top: 8px;
            max-height: 350px;
            overflow-y: auto;
            z-index: 100;
            display: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .suggestion-item {
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .suggestion-item:last-child { border-bottom: none; }
        .suggestion-item:hover { background: rgba(139, 92, 246, 0.1); }

        .suggestion-item img {
            width: 45px;
            height: 45px;
            border-radius: 8px;
        }

        .suggestion-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .suggestion-title { font-size: 14px; font-weight: 600; color: white; }
        .suggestion-artist { font-size: 12px; color: var(--text-secondary); }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 var(--accent-glow); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(139, 92, 246, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(139, 92, 246, 0); }
        }
    </style>
</head>
<body>

    <div class="blob"></div>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="toast toast-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="toast toast-error">{{ session('error') }}</div>
    @endif

    <div class="glass-container">
        <header class="hero-header">
            <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1000px; margin: 0 auto; gap: 20px; flex-wrap: wrap;">
                <div style="text-align: left; flex: 1; min-width: 300px;">
                    <h1>Music Request</h1>
                    <p>Kontribusi musikmu untuk playlist sekolah hari ini!</p>
                </div>
                
                {{-- Quick Stats --}}
                <div style="display: flex; gap: 15px;">
                    <div style="background: rgba(255,255,255,0.05); padding: 15px 25px; border-radius: 16px; border: 1px solid var(--glass-border); text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: var(--accent);">{{ count($data) }}</div>
                        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Total Request</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.05); padding: 15px 25px; border-radius: 16px; border: 1px solid var(--glass-border); text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: #10b981;">Online</div>
                        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Sistem Status</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Now Playing Section (Featured) --}}
        @if(count($data) > 0)
        <div style="padding: 20px 40px; background: rgba(16, 185, 129, 0.05); border-bottom: 1px solid var(--glass-border);">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 60px; height: 60px; background: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite; position: relative; box-shadow: 0 0 20px var(--accent-glow);">
                        <img src="{{ $data[0]->album_art ?? 'https://via.placeholder.com/60x60?text=♫' }}" style="width: 100%; height: 100%; border-radius: 12px; object-fit: cover;" alt="Current">
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 4px;">Sedang Diproses</div>
                        <div style="font-size: 20px; font-weight: 800; color: white;">{{ $data[0]->judul_lagu }}</div>
                        <div style="font-size: 13px; color: var(--text-secondary);">Request oleh: <span style="color: white; font-weight: 600;">{{ $data[0]->nama_pengirim ?? 'Anonim' }}</span></div>
                    </div>
                </div>

                <form method="POST" action="/delete/{{ $data[0]->id }}" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-action confirm-done" style="margin: 0; padding: 12px 25px; width: auto; background: #10b981; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Selesai Diputar
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="content-grid">
            <aside class="form-section">
                <h2 class="section-title">Kirim Request</h2>
                <form method="POST" action="/store" id="requestForm" autocomplete="off">
                    @csrf
                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Judul Lagu</label>
                        <input type="text" id="judulLaguInput" name="judul_lagu" class="form-control" placeholder="Cari lagu di sini..." required>
                        <input type="hidden" id="albumArtInput" name="album_art">
                        
                        {{-- Autocomplete Dropdown --}}
                        <div id="itunesSuggestions" class="suggestions-dropdown"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Pengirim</label>
                        <input type="text" name="nama_pengirim" class="form-control" placeholder="Nama kamu..." required>
                    </div>
                    <button type="submit" class="btn-action">Kirim Sekarang</button>
                </form>
            </aside>

            <main class="list-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 class="section-title" style="margin: 0;">Daftar Tunggu</h2>
                </div>

                <div id="trackList">
                    @forelse($data as $lagu)
                    <div class="track-card">
                        <div style="display: flex; align-items: center; gap: 15px; flex: 1;">
                            <div style="font-size: 14px; font-weight: 800; color: var(--text-secondary); min-width: 25px; text-align: center;">
                                {{ $loop->iteration }}
                            </div>
                            <img src="{{ $lagu->album_art ?? 'https://via.placeholder.com/50x50?text=♫' }}" 
                                 style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover; background: #222;" 
                                 alt="Art">
                            <div class="track-info">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span class="track-title">{{ $lagu->judul_lagu }}</span>
                                    @if($loop->iteration == 2)
                                        <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.2); text-transform: uppercase;">Up Next</span>
                                    @endif
                                </div>
                                <div class="track-meta">
                                    <span class="meta-tag">{{ $lagu->nama_pengirim ?? 'Anonim' }}</span>
                                    <span>•</span>
                                    <span>{{ $lagu->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="/delete/{{ $lagu->id }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete confirm-delete" title="Hapus">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div id="emptyMessage" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                        Belum ada request lagu hari ini.
                    </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <script>
        const input = document.getElementById('judulLaguInput');
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

        // SweetAlert Confirmation
        document.querySelectorAll('.confirm-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus Request?',
                    text: "Lagu ini akan dihapus dari antrean.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#1e293b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1e293b',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        document.querySelectorAll('.confirm-done').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Selesai Diputar?',
                    text: "Lagu berikutnya akan naik ke antrean utama.",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#1e293b',
                    confirmButtonText: 'Ya, Selesai!',
                    cancelButtonText: 'Belum',
                    background: '#1e293b',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
</body>
</html>

    <style>
        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1e293b;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            margin-top: 8px;
            max-height: 350px;
            overflow-y: auto;
            z-index: 100;
            display: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .suggestion-item {
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .suggestion-item:last-child { border-bottom: none; }
        .suggestion-item:hover { background: rgba(16, 185, 129, 0.1); }

        .suggestion-item img {
            width: 45px;
            height: 45px;
            border-radius: 8px;
        }

        .suggestion-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .suggestion-title { font-size: 14px; font-weight: 600; color: white; }
        .suggestion-artist { font-size: 12px; color: var(--text-secondary); }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 var(--accent-glow); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</body>
</html>


