@extends('layouts.main')

@push('styles')
<style>

body{
background: linear-gradient(135deg,#eef2ff,#ffffff,#f5f3ff);
}

/* CARD */
.glass-card{
background: rgba(255,255,255,.9);
backdrop-filter: blur(14px);
border-radius: 24px;
box-shadow: 0 25px 60px rgba(0,0,0,.08);
}

/* INPUT */
.input{
width:100%;
padding:12px 16px;
border-radius:12px;
border:1px solid #e5e7eb;
outline:none;
transition:.3s;
background:white;
}

.input:focus{
border-color:#6366f1;
box-shadow:0 0 0 3px rgba(99,102,241,.2);
}

/* BUTTON */
.btn-main{
background: linear-gradient(135deg,#6366f1,#9333ea);
transition:.3s;
}

.btn-main:hover{
transform:scale(1.03);
box-shadow:0 15px 25px rgba(99,102,241,.3);
}

/* IMAGE SIDE */
.signup-image{
background:linear-gradient(135deg,#6366f1,#7c3aed);
}

/* animation */
.float{
animation: float 5s ease-in-out infinite;
}

</style>
@endpush


@section('content')

<section class="min-h-screen flex items-center justify-center px-6 py-10">

<div class="max-w-7xl w-full grid lg:grid-cols-2 overflow-hidden glass-card">

<!-- ================= LEFT IMAGE ================= -->
<div class="signup-image hidden lg:flex flex-col justify-center items-center text-white p-12 space-y-6">

<img
src="{{ asset('image/online.png') }}"
class="w-3/4"
alt="user login">

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
<a href="#"
class="flex items-center justify-center gap-3 border rounded-xl py-3 mb-8 hover:bg-gray-50 transition">

<img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" class="w-6">

Sign up with Google

</a>


<form method="POST" action="{{ route('signup') }}"
class="grid md:grid-cols-2 gap-5">

@csrf

<input name="firstname" placeholder="First Name" required class="input">
<input name="lastname" placeholder="Last Name" required class="input">

<input name="profile_image" placeholder="Profile Image URL" class="input md:col-span-2">

<select name="gender" required class="input">
<option value="">Gender</option>
<option>Male</option>
<option>Female</option>
</select>

<input name="cin" placeholder="CIN" required class="input">

<input name="country" placeholder="Country" required class="input">
<input name="city" placeholder="City" required class="input">

<input type="date" name="birth_date" required class="input">

<select name="type_occupation" required class="input">
<option value="">Occupation Type</option>
<option value="work">Work</option>
<option value="study">Study</option>
</select>

<input name="occupation"
placeholder="Occupation"
class="input md:col-span-2"
required>

<input type="email" name="email"
placeholder="Email"
required class="input">

<input name="phone"
placeholder="Phone"
required class="input">

<input type="password"
name="password"
placeholder="Password"
required class="input">

<input type="password"
name="password_confirmation"
placeholder="Confirm Password"
required class="input">


<button type="submit"
class="btn-main text-white py-3 rounded-xl font-semibold md:col-span-2">

Create Account 🚀

</button>

<p class="text-center text-gray-600 md:col-span-2">
Already have an account ?
<a href="{{ route('login') }}"
class="text-indigo-600 font-semibold hover:underline">
Login
</a>
</p>

</form>

</div>

</div>

</section>

@endsection



@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script>


</script>

@endpush