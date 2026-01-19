@if(request()->routeIs('filament.' . $panel . '.auth.login'))
    <style>
        /* Styling khusus Login Page */
        body {
            @if($panel == 'admin')
                /* Gradient Navy Blue untuk Admin */
                background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%) !important;
            @else
                /* Gradient Emerald Green untuk Mentor */
                background: linear-gradient(135deg, #064e3b 0%, #10b981 100%) !important;
            @endif min-height: 100vh;
        }

        /* Ubah style card login */
        .fi-simple-main {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Ubah warna logo/brand */
        .fi-simple-header-heading {
            color: #1e293b;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        /* Input fields styling */
        input {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
        }

        input:focus {
            border-color:
                @if($panel == 'admin')
                #3b82f6 @else #10b981 @endif !important;
            box-shadow: 0 0 0 3px
                @if($panel == 'admin')
                rgba(59, 130, 246, 0.1) @else rgba(16, 185, 129, 0.1) @endif !important;
        }

        /* Tombol Sign In */
        button[type="submit"] {
            @if($panel == 'admin')
                background: #1e3a8a !important;
            @else background: #059669 !important;
            @endif font-weight: 600;
        }

        button[type="submit"]:hover {
            opacity: 0.9;
        }
    </style>
@endif