{{-- resources/views/developer.blade.php --}}
@extends('layouts.main')

@section('title', 'Developer Profile')

@push('styles')
    <style>
        .developer-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .developer-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 2rem;
            padding: 2.5rem;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .developer-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: 700;
            color: white;
            margin: 0 auto 1.5rem;
            border: 5px solid white;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
        }

        .developer-badge {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 1.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(79, 70, 229, 0.2);
            background: white;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #4f46e5;
            color: white;
            transform: scale(1.1);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: #10b981;
            color: white;
        }

        .status-admin {
            background: #4f46e5;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="developer-container">
        <div class="developer-card">

            {{-- Developer Avatar --}}
            <div class="developer-avatar">
                @if ($developer->profile_image)
                    <img src="{{ $developer->profile_image }}" alt="{{ $developer->firstname }}"
                        class="w-full h-full object-cover rounded-full">
                @else
                    {{ substr($developer->firstname ?? 'D', 0, 1) }}{{ substr($developer->lastname ?? 'V', 0, 1) }}
                @endif
            </div>

            {{-- Developer Name & Role --}}
            <h1 class="text-4xl font-bold text-center mb-2">{{ $developer->firstname }} {{ $developer->lastname }}</h1>

            <div class="flex justify-center gap-3 mb-6">
                @if ($developer->is_admin)
                    <span class="status-badge status-admin">Administrator</span>
                @endif
                <span class="status-badge status-active">Developer</span>
            </div>

            {{-- Bio / Description --}}
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-8">
                In the shadows of technology, I create what others fear to understand.<br>
                Code is more than logic — it is obsession, discipline, and devotion.<br>Every project carries a fragment of my
                mind, driven by a silent love for building something that endures.<br>
                From the deep, beyond the interface… I watch, learn, and record.<br>
                This is who I am — unstoppable. I dare anyone to try.
            </p>

            {{-- Developer Badge --}}
            <div class="text-center">
                <span class="developer-badge">
                    <i class="fas fa-code mr-2"></i>
                    Senior Full Stack Developer
                </span>
            </div>

            {{-- Information Grid --}}
            <div class="info-grid">
                {{-- Email --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope text-indigo-500"></i>
                        Email Address
                    </div>
                    <div class="info-value">
                        <a href="mailto:{{ $developer->email }}" class="hover:text-indigo-600">
                            {{ $developer->email }}
                        </a>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-phone text-indigo-500"></i>
                        Phone Number
                    </div>
                    <div class="info-value">
                        @if ($developer->phone)
                            <a href="tel:{{ $developer->phone }}" class="hover:text-indigo-600">
                                {{ $developer->phone }}
                            </a>
                        @else
                            <span class="text-gray-400">Not provided</span>
                        @endif
                    </div>
                </div>

                {{-- Location --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt text-indigo-500"></i>
                        Location
                    </div>
                    <div class="info-value">
                        @if ($developer->city || $developer->country)
                            {{ $developer->city ?? '' }}{{ $developer->city && $developer->country ? ', ' : '' }}{{ $developer->country ?? '' }}
                        @else
                            <span class="text-gray-400">Not specified</span>
                        @endif
                    </div>
                </div>

                {{-- Gender --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-venus-mars text-indigo-500"></i>
                        Gender
                    </div>
                    <div class="info-value">
                        @if ($developer->gender)
                            {{ ucfirst($developer->gender) }}
                        @else
                            <span class="text-gray-400">Not specified</span>
                        @endif
                    </div>
                </div>

                {{-- Birth Date --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-cake-candles text-indigo-500"></i>
                        Birth Date
                    </div>
                    <div class="info-value">
                        @if ($developer->birth_date)
                            {{ \Carbon\Carbon::parse($developer->birth_date)->format('d M Y') }}
                            ({{ \Carbon\Carbon::parse($developer->birth_date)->age }} years)
                        @else
                            <span class="text-gray-400">Not specified</span>
                        @endif
                    </div>
                </div>

                {{-- CIN --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-id-card text-indigo-500"></i>
                        My Tag
                    </div>
                    <div class="info-value">
                        HYK
                    </div>
                </div>

                {{-- Occupation Type --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-briefcase text-indigo-500"></i>
                        Occupation Type
                    </div>
                    <div class="info-value">
                        @if ($developer->type_occupation)
                            {{ ucfirst($developer->type_occupation) }}
                        @else
                            <span class="text-gray-400">Not specified</span>
                        @endif
                    </div>
                </div>

                {{-- Occupation --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-laptop-code text-indigo-500"></i>
                        Occupation
                    </div>
                    <div class="info-value">
                        @if ($developer->occupation)
                            {{ $developer->occupation }}
                        @else
                            <span class="text-gray-400">Not specified</span>
                        @endif
                    </div>
                </div>

                {{-- Member Since --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-calendar-alt text-indigo-500"></i>
                        Member Since
                    </div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($developer->created_at)->format('d M Y') }}
                    </div>
                </div>

                {{-- Last Updated --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-clock text-indigo-500"></i>
                        Last Updated
                    </div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($developer->updated_at)->diffForHumans() }}
                    </div>
                </div>

                {{-- Account Status --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-shield-alt text-indigo-500"></i>
                        Account Status
                    </div>
                    <div class="info-value">
                        <span class="text-green-600">Active</span>
                    </div>
                </div>

                {{-- Email Verification --}}
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope-circle-check text-indigo-500"></i>
                        Email Verified
                    </div>
                    <div class="info-value">
                        @if ($developer->email_verified_at)
                            {{ \Carbon\Carbon::parse($developer->email_verified_at)->format('d M Y') }}
                        @else
                            <span class="text-yellow-600">Not verified</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="social-links">
                <a href="https://github.com/yakhlafhoussam" target="_blank" class="social-link" title="GitHub">
                    <i class="fab fa-github"></i>
                </a>
                <a href="https://linkedin.com/in/houssam-yakhlaf-0b3677319" target="_blank" class="social-link" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="mailto:{{ $developer->email }}" class="social-link" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.instagram.com/houssam__yakhlaf" target="_blank" class="social-link" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            {{-- Back Button --}}
            <div class="text-center mt-8">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 text-gray-500 hover:text-indigo-600 transition">
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection
