<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Music Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --accent: #8b5cf6;
            --accent-glow: rgba(139, 92, 246, 0.5);
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
        }

        .blob {
            position: fixed;
            width: 600px;
            height: 600px;
            background: var(--accent);
            filter: blur(150px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.15;
            top: -10%;
            right: -10%;
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
        }

        .card {
            background: var(--bg-surface);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .header-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--glass-border);
            padding: 25px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(139, 92, 246, 0.1);
            color: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-info h3 { font-size: 28px; font-weight: 800; }
        .stat-info p { font-size: 13px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        .track-card {
            background: rgba(255, 255, 255, 0.03); border: 1px solid var(--glass-border);
            border-radius: 16px; padding: 16px 20px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;
        }

        .track-info-wrap {
            display: flex; align-items: center; gap: 15px; flex: 1;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 10px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s; font-weight: 600; display: flex; align-items: center; gap: 8px;
        }
        .btn-delete:hover { background: #ef4444; color: white; }

        /* Notifications */
        .toast { position: fixed; top: 30px; right: 30px; padding: 16px 24px; border-radius: 16px; backdrop-filter: blur(10px); z-index: 1000; border: 1px solid var(--glass-border); box-shadow: 0 10px 25px rgba(0,0,0,0.3); animation: slideIn 0.4s; }
        .toast-success { background: rgba(16, 185, 129, 0.2); color: #10b981; border-color: rgba(16, 185, 129, 0.3); }
        @keyframes slideIn { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    </style>
</head>
<body>
    <div class="blob"></div>

    @if(session('success'))
        <div class="toast toast-success">{{ session('success') }}</div>
    @endif

    <nav>
        <div class="logo">Admin Portal</div>
        <div class="user-menu">
            <span>Welcome, <strong>Admin</strong></span>
            <a href="{{ route('logout') }}" class="btn-logout" style="text-decoration: none; display: inline-block;">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-icon">🎵</div>
                <div class="stat-info">
                    <h3>{{ count($requests) }}</h3>
                    <p>Total Antrean Lagu</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <h3>{{ $activeSiswaCount }}</h3>
                    <p>Siswa Sedang Online</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 25px;">Manajemen Antrean Lagu</h2>
            
            <div style="max-height: 600px; overflow-y: auto; padding-right: 10px;">
                @forelse($requests as $lagu)
                <div class="track-card">
                    <div class="track-info-wrap">
                        <div style="font-weight: 800; color: var(--text-secondary); width: 30px; text-align: center;">{{ $loop->iteration }}</div>
                        <img src="{{ $lagu->album_art ?? 'https://via.placeholder.com/50x50?text=♫' }}" 
                             style="width: 55px; height: 55px; border-radius: 12px; object-fit: cover;" alt="Art">
                        <div>
                            <div style="font-weight: 700; font-size: 16px; margin-bottom: 4px;">{{ $lagu->judul_lagu }}</div>
                            <div style="font-size: 13px; color: var(--text-secondary); display: flex; gap: 15px;">
                                <span><strong style="color: #cbd5e1;">Pengirim:</strong> {{ $lagu->nama_pengirim }}</span>
                                <span><strong style="color: #cbd5e1;">Waktu:</strong> {{ $lagu->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.request.destroy', $lagu->id) }}" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete confirm-delete">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            Selesai / Hapus
                        </button>
                    </form>
                </div>
                @empty
                <div style="text-align: center; padding: 60px; color: var(--text-secondary);">
                    <div style="font-size: 48px; margin-bottom: 15px;">🎧</div>
                    <p>Antrean kosong. Belum ada request lagu hari ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.confirm-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Selesaikan Request?',
                    text: "Lagu ini akan dihapus dari antrean.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#1e293b',
                    confirmButtonText: 'Ya, Selesai!',
                    cancelButtonText: 'Batal',
                    background: '#1e293b',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Hide toast notification after 3 seconds
        setTimeout(function() {
            let toast = document.querySelector('.toast');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>
