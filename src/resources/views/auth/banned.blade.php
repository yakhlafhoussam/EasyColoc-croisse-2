{{-- resources/views/banned.blade.php --}}
@extends('layouts.main')

@section('title', 'Account Banned')

@push('styles')
    <style>
        .banned-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, #fef2f2, #ffffff, #fff5f5);
        }

        .banned-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);
            border-radius: 2rem;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 60px rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.2);
            animation: slideUp 0.6s ease;
            text-align: center;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .banned-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.3);
        }

        .banned-icon i {
            font-size: 3.5rem;
            color: white;
        }

        .banned-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .banned-message {
            color: #4b5563;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .info-box {
            background: #fef2f2;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #fecaca;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #fecaca;
            text-align: left;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .info-value {
            font-weight: 600;
            color: #1f2937;
            font-size: 1rem;
        }

        .email-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 2px dashed #ef4444;
        }

        .email-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .email-link {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #ef4444;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .email-link:hover {
            background: #dc2626;
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        }

        .email-link i {
            font-size: 1.25rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-logout {
            background: white;
            color: #4b5563;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        .footer-text {
            margin-top: 2rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="banned-container">
        <div class="banned-card">
            
            {{-- Banned Icon --}}
            <div class="banned-icon">
                <i class="fas fa-ban"></i>
            </div>

            {{-- Title --}}
            <h1 class="banned-title">Account Banned</h1>
            
            {{-- Message --}}
            <p class="banned-message">
                Your account has been suspended from EasyColoc due to a violation of our terms of service.
            </p>

            {{-- Info Box --}}
            <div class="info-box">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Ban Date</div>
                        <div class="info-value">{{ now()->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Account</div>
                        <div class="info-value">{{ Auth::user()->email ?? 'User' }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Status</div>
                        <div class="info-value text-red-600 font-bold">Banned</div>
                    </div>
                </div>
            </div>

            {{-- Email Contact Section --}}
            <div class="email-section">
                <div class="email-title">
                    <i class="fas fa-envelope text-red-500"></i>
                    Contact Support
                </div>
                
                <a href="mailto:ykeasycoloc@gmail.com" class="email-link">
                    <i class="fas fa-paper-plane"></i>
                    ykeasycoloc@gmail.com
                </a>
                
                <p class="text-xs text-gray-400 mt-3">
                    Click to send an email. We'll respond as soon as possible.
                </p>
            </div>

            {{-- Logout Button --}}
            <div class="action-buttons">
                <a href="{{ route('logout') }}" 
                   class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>

            {{-- Footer Note --}}
            <p class="footer-text">
                <i class="fas fa-shield-alt mr-1"></i>
                If you believe this is a mistake, please email us.
            </p>
        </div>
    </div>

    <script>
        // GSAP Animation
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof gsap !== 'undefined') {
                gsap.from('.banned-card', {
                    opacity: 0,
                    y: 30,
                    duration: 0.8,
                    ease: 'power3.out'
                });
                
                gsap.from('.info-item', {
                    opacity: 0,
                    x: -20,
                    duration: 0.5,
                    stagger: 0.1,
                    delay: 0.3
                });
                
                gsap.from('.email-section', {
                    opacity: 0,
                    scale: 0.9,
                    duration: 0.5,
                    delay: 0.6
                });
            }
        });
    </script>
@endsection