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
            @endif
            min-height: 100vh;
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
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            font-size: 1rem !important;
            transition: all 0.2s ease !important;
        }

        input:hover {
            border-color: #d1d5db !important;
            background-color: #ffffff !important;
        }

        input:focus {
            border-color: @if($panel == 'admin') #3b82f6 @else #10b981 @endif !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 4px @if($panel == 'admin') rgba(59, 130, 246, 0.15) @else rgba(16, 185, 129, 0.15) @endif !important;
            outline: none !important;
        }

        input::placeholder {
            color: #9ca3af !important;
            font-weight: 400 !important;
        }

        /* Label styling */
        label {
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        /* Form wrapper */
        .fi-form-field {
            margin-bottom: 1.25rem !important;
        }

        .fi-form-field-wrapper {
            display: block !important;
        }

        /* Tombol Sign In */
        button[type="submit"] {
            @if($panel == 'admin')
                background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important;
                box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3) !important;
            @else
                background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
                box-shadow: 0 4px 15px rgba(4, 120, 87, 0.3) !important;
            @endif
            font-weight: 600 !important;
            font-size: 1rem !important;
            padding: 0.875rem 1.5rem !important;
            border-radius: 0.75rem !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
            color: white !important;
        }

        button[type="submit"]:hover {
            @if($panel == 'admin')
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
                box-shadow: 0 8px 20px rgba(30, 58, 138, 0.4) !important;
            @else
                background: linear-gradient(135deg, #047857 0%, #059669 100%) !important;
                box-shadow: 0 8px 20px rgba(4, 120, 87, 0.4) !important;
            @endif
            transform: translateY(-2px) !important;
        }

        button[type="submit"]:active {
            transform: translateY(0px) !important;
            opacity: 0.95 !important;
        }

        button[type="submit"]:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            transform: none !important;
        }
    </style>
@endif
