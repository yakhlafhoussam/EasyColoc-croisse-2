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

        .input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .2);
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
    </style>
@endpush


@section('content')
    <section class="min-h-screen flex items-center justify-center px-6 py-10">

        <div class="max-w-7xl w-full grid lg:grid-cols-2 overflow-hidden glass-card">

            <!-- ================= LEFT IMAGE ================= -->
            <div class="signup-image hidden lg:flex flex-col justify-center items-center text-white p-12 space-y-6">

                <img src="{{ asset('image/online.png') }}" class="w-3/4" alt="user login">

                <h2 class="text-4xl font-bold text-center">
                    Start Your EasyColoc Journey
                </h2>

                <p class="text-center opacity-90 max-w-md">
                    Create your shared piggy bank, invite roommates,
                    track expenses and keep your colocation peaceful.
                </p>

            </div>


            <!-- ================= FORM ================= -->
            <div class="p-8 md:p-12">

                <div class="text-center mb-8">

                    <i class="fas fa-user-plus text-4xl text-indigo-600 mb-3"></i>

                    <h1 class="text-3xl font-bold">
                        Create Account
                    </h1>

                    <p class="text-gray-500">
                        Join EasyColoc in seconds
                    </p>

                </div>


                <!-- GOOGLE -->
                <a href="/auth/google"
                    class="flex items-center justify-center gap-3 border rounded-xl py-3 mb-8 hover:bg-gray-50 transition">

                    <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" class="w-6">

                    Sign up with Google

                </a>

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

                <div class="w-full mb-2 flex justify-center items-center">
                    <div id="profiles"
                        class="w-20 h-20 rounded-full flex items-center justify-center bg-indigo-600 text-3xl text-white font-bold">
                    </div>
                    <img id="profilei" class="w-20 h-20 rounded-full hidden"
                        onerror="if(this.src !== '{{ asset('image/shopping.png') }}') this.src='{{ asset('image/shopping.png') }}'">
                </div>

                <form method="POST" action="{{ route('signup') }}" class="grid md:grid-cols-2 gap-5">
                    @csrf

                    <input value="{{ old('firstname') }}" id="first" name="firstname" placeholder="First Name" class="input">
                    <input value="{{ old('lastname') }}" id="last" name="lastname" placeholder="Last Name" class="input">

                    <input value="{{ old('profile_image') }}" id="profile_image" name="profile_image" placeholder="Profile Image URL (Optionel)"
                        class="input md:col-span-2">

                    <select value="{{ old('gender') }}" name="gender" class="input">
                        <option value="">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <input value="{{ old('cin') }}" name="cin" placeholder="CIN" class="input">
                    <select value="{{ old('country') }}" id="country" name="country" class="input">
                        <option value="">Select Country</option>

                    </select>

                    <select value="{{ old('city') }}" id="city" name="city" class="input">
                        <option value="">Select City</option>

                    </select>

                    <input value="{{ old('birth_date') }}" type="date" name="birth_date" class="input">

                    <select value="{{ old('type_occupation') }}" name="type_occupation" class="input">
                        <option value="">Occupation Type</option>
                        <option value="work">Work</option>
                        <option value="student">Study</option>
                        <option value="other">Other</option>
                    </select>

                    <input value="{{ old('occupation') }}" name="occupation" placeholder="Occupation" class="input md:col-span-2">

                    <input value="{{ old('email') }}" type="email" name="email" placeholder="Email" class="input">

                    <input value="{{ old('phone') }}" name="phone" placeholder="Phone" class="input">

                    <input type="password" name="password" placeholder="Password" class="input">

                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="input">


                    <button type="submit" class="btn-main text-white py-3 rounded-xl font-semibold md:col-span-2">

                        Create Account

                    </button>

                    <p class="text-center text-gray-600 md:col-span-2">
                        Already have an account ?
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">
                            Login
                        </a>
                    </p>

                </form>

            </div>

        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </section>
@endsection



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script>
        async function getdata() {
            const res = await fetch("https://countriesnow.space/api/v0.1/countries");
            datas = await res.json();
            console.log(datas);
            datas.data.forEach(element => {
                document.querySelector('#country').insertAdjacentHTML('beforeend',
                    `<option value="${element.iso2}">${element.country}</option>`);
                console.log(element.country);
            });
        }

        async function getcity(id) {
            const res = await fetch("https://countriesnow.space/api/v0.1/countries");
            datas = await res.json();
            datas.data.forEach(coun => {
                if (coun.iso2 == id) {
                    document.querySelector('#city').innerHTML = '<option value="">Select City</option>';
                    for (let hyk = 0; hyk < coun.cities.length; hyk++) {
                        document.querySelector('#city').insertAdjacentHTML('beforeend',
                            `<option value="${coun.cities[hyk]}">${coun.cities[hyk]}</option>`);
                    }
                }
            });
        }

        getdata();

        document.querySelector('#country').addEventListener("change", function() {
            console.log(document.querySelector('#country').value);
            getcity(document.querySelector('#country').value)
        });

        let profile = document.querySelector('#profiles');
        let profileimg = document.querySelector('#profilei');
        let profile_image = document.querySelector('#profile_image');
        let first = document.querySelector('#first');
        let last = document.querySelector('#last');
        first.oninput = function() {
            profile.innerHTML = first.value[0].toUpperCase() + last.value[0].toUpperCase();
        };
        last.oninput = function() {
            profile.innerHTML = first.value[0].toUpperCase() + last.value[0].toUpperCase();
        };
        profile_image.addEventListener("input", function() {
            if (profile_image.value.length > 0) {
                profile.style.display = 'none';
                profileimg.style.display = 'flex';
                profileimg.src = profile_image.value;
            } else {
                profile.style.display = 'flex';
                profileimg.style.display = 'none';
            }
        });
    </script>
@endpush
