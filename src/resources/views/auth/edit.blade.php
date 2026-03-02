@extends('layouts.main')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #ffffff, #f5f3ff);
        }

        /* CARD */
        .glass-card {
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .08);
        }

        /* INPUT */
        .input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            outline: none;
            transition: .3s;
            background: white;
        }

        .input:focus:enabled {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .2);
        }

        .input:disabled {
            background: #f3f4f6;
            cursor: not-allowed;
            opacity: 0.8;
        }

        /* BUTTON */
        .btn-main {
            background: linear-gradient(135deg, #6366f1, #9333ea);
            transition: .3s;
        }

        .btn-main:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 25px rgba(99, 102, 241, .3);
        }

        /* IMAGE SIDE */
        .signup-image {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
        }

        /* animation */
        .float {
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .error-text {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            margin-left: 0.5rem;
        }
    </style>
@endpush


@section('content')

    <section class="min-h-screen flex items-center justify-center px-6 py-10">

        <div class="max-w-7xl w-full grid lg:grid-cols-2 overflow-hidden glass-card">

            <!-- ================= LEFT IMAGE ================= -->
            <div class="signup-image hidden lg:flex flex-col justify-center items-center text-white p-12 space-y-6">

                <img src="{{ asset('image/money.png') }}" class="w-3/4 float" alt="complete profile">

                <h2 class="text-4xl font-bold text-center">
                    Edit Your Profile
                </h2>

                <p class="text-center opacity-90 max-w-md">
                    Make the necessary changes to keep your colocation details up to date
                    and ensure smooth management of your shared piggy bank.
                </p>

            </div>

            <!-- ================= FORM ================= -->
            <div class="p-8 md:p-12">

                <div class="text-center mb-8">

                    <i class="fas fa-user-edit text-4xl text-indigo-600 mb-3"></i>

                    <h1 class="text-3xl font-bold">
                        Edit Profile
                    </h1>

                    <p class="text-gray-500">
                        Fill in the remaining details to continue
                    </p>

                </div>

                @if ($errors->any())
                    <div id="error-message" class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                            <ul class="text-sm flex flex-col" id="error-text">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="w-full mb-6 flex justify-center items-center">
                    <div id="profiles"
                        class="w-20 h-20 rounded-full flex items-center justify-center bg-indigo-600 text-3xl text-white font-bold">
                        {{ $user->firstname && $user->lastname ? strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) : 'U' }}
                    </div>
                    <img id="profilei" class="w-20 h-20 rounded-full hidden object-cover"
                        onerror="if(this.src !== '{{ asset('image/shopping.png') }}') this.src='{{ asset('image/shopping.png') }}'">
                </div>

                <form method="POST" action="/edit" class="grid md:grid-cols-2 gap-5">
                    @csrf

                    <input value="{{ old('firstname', $user->firstname ?? '') }}" id="first" name="firstname"
                        placeholder="First Name" class="input @error('firstname') border-red-500 @enderror">
                    @error('firstname')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ old('lastname', $user->lastname ?? '') }}" id="last" name="lastname"
                        placeholder="Last Name" class="input @error('lastname') border-red-500 @enderror">
                    @error('lastname')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ old('profile_image', $user->profile_image ?? '') }}" id="profile_image"
                        name="profile_image" placeholder="Profile Image URL (Optional)"
                        class="input md:col-span-2 @error('profile_image') border-red-500 @enderror">
                    @error('profile_image')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <select name="gender" class="input @error('gender') border-red-500 @enderror">
                        <option value="">Gender</option>
                        <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>
                            Female</option>
                    </select>
                    @error('gender')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ old('cin', $user->cin ?? '') }}" name="cin" placeholder="CIN"
                        class="input @error('cin') border-red-500 @enderror">
                    @error('cin')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <select id="country" name="country" class="input @error('country') border-red-500 @enderror">
                        <option value="{{ old('country', $user->country ?? '') }}">Select Country</option>
                    </select>
                    @error('country')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <select id="city" name="city" class="input @error('city') border-red-500 @enderror">
                        <option value="{{ old('city', $user->city ?? '') }}">Select City</option>
                    </select>
                    @error('city')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ old('birth_date', $user->birth_date ?? '') }}" type="date" name="birth_date"
                        class="input @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <select name="type_occupation" class="input @error('type_occupation') border-red-500 @enderror">
                        <option value="">Occupation Type</option>
                        <option value="work"
                            {{ old('type_occupation', $user->type_occupation ?? '') == 'work' ? 'selected' : '' }}>Work
                        </option>
                        <option value="student"
                            {{ old('type_occupation', $user->type_occupation ?? '') == 'student' ? 'selected' : '' }}>
                            Student</option>
                        <option value="other"
                            {{ old('type_occupation', $user->type_occupation ?? '') == 'other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('type_occupation')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ old('occupation', $user->occupation ?? '') }}" name="occupation"
                        placeholder="Occupation" class="input md:col-span-2 @error('occupation') border-red-500 @enderror">
                    @error('occupation')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <input value="{{ $user->email }}" type="email" name="email" placeholder="Email" disabled
                        class="input bg-gray-100">

                    <input value="{{ old('phone', $user->phone ?? '') }}" name="phone" placeholder="Phone"
                        class="input @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="error-text md:col-span-2 -mt-2">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn-main text-white py-3 rounded-xl font-semibold md:col-span-2">
                        <i class="fas fa-save mr-2"></i>
                        Complete Profile
                    </button>

                </form>

            </div>

        </div>

    </section>

@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script>
        // GSAP animation for form entrance
        gsap.from('.glass-card', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out'
        });

        gsap.from('.signup-image', {
            opacity: 0,
            x: -50,
            duration: 1,
            delay: 0.2
        });

        // Country and city data fetching
        async function getdata() {
            try {
                const res = await fetch("https://countriesnow.space/api/v0.1/countries");
                const datas = await res.json();

                // Get the currently selected country from old input or user data
                const selectedCountry = "{{ old('country', $user->country ?? '') }}";

                datas.data.forEach(element => {
                    const selected = (element.iso2 === selectedCountry) ? 'selected' : '';
                    document.querySelector('#country').insertAdjacentHTML('beforeend',
                        `<option value="${element.iso2}" ${selected}>${element.country}</option>`);
                });

                // If there's a selected country, load its cities
                if (selectedCountry) {
                    getcity(selectedCountry);
                }
            } catch (error) {
                console.error('Error loading countries:', error);
            }
        }

        async function getcity(countryCode) {
            try {
                const res = await fetch("https://countriesnow.space/api/v0.1/countries");
                const datas = await res.json();

                datas.data.forEach(coun => {
                    if (coun.iso2 == countryCode) {
                        document.querySelector('#city').innerHTML = '<option value="">Select City</option>';

                        // Get the currently selected city from old input or user data
                        const selectedCity = "{{ old('city', $user->city ?? '') }}";

                        for (let i = 0; i < coun.cities.length; i++) {
                            const selected = (coun.cities[i] === selectedCity) ? 'selected' : '';
                            document.querySelector('#city').insertAdjacentHTML('beforeend',
                                `<option value="${coun.cities[i]}" ${selected}>${coun.cities[i]}</option>`);
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading cities:', error);
            }
        }

        // Load countries on page load
        getdata();

        // When country changes, load cities
        document.querySelector('#country').addEventListener("change", function() {
            const countryCode = document.querySelector('#country').value;
            if (countryCode) {
                getcity(countryCode);
            } else {
                document.querySelector('#city').innerHTML = '<option value="">Select City</option>';
            }
        });

        // Profile image preview
        let profile = document.querySelector('#profiles');
        let profileimg = document.querySelector('#profilei');
        let profile_image = document.querySelector('#profile_image');
        let first = document.querySelector('#first');
        let last = document.querySelector('#last');

        // Initialize initials
        function updateInitials() {
            const firstVal = first.value.trim();
            const lastVal = last.value.trim();

            if (firstVal.length > 0 && lastVal.length > 0) {
                profile.innerHTML = firstVal[0].toUpperCase() + lastVal[0].toUpperCase();
            } else if (firstVal.length > 0) {
                profile.innerHTML = firstVal[0].toUpperCase();
            } else if (lastVal.length > 0) {
                profile.innerHTML = lastVal[0].toUpperCase();
            } else {
                profile.innerHTML = 'U';
            }
        }

        // Update initials on input
        first.oninput = updateInitials;
        last.oninput = updateInitials;

        // Check if there's already a profile image URL
        if (profile_image.value.length > 0) {
            profile.style.display = 'none';
            profileimg.style.display = 'flex';
            profileimg.src = profile_image.value;
        }

        // Handle profile image URL input
        profile_image.addEventListener("input", function() {
            if (profile_image.value.length > 0) {
                profile.style.display = 'none';
                profileimg.style.display = 'flex';
                profileimg.src = profile_image.value;

                // Handle image loading error
                profileimg.onerror = function() {
                    this.src = '{{ asset('image/shopping.png') }}';
                };
            } else {
                profile.style.display = 'flex';
                profileimg.style.display = 'none';
            }
        });
    </script>
@endpush
