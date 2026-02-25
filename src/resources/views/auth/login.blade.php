@extends('layouts.main')

@push('styles')
<style>

.login-bg{
background: linear-gradient(135deg,#eef2ff,#ffffff,#f5f3ff);
}

.glass-card{
backdrop-filter: blur(15px);
background: rgba(255,255,255,0.85);
}

.divider{
display:flex;
align-items:center;
text-align:center;
}

.divider::before,
.divider::after{
content:'';
flex:1;
border-bottom:1px solid #ddd;
}

.divider:not(:empty)::before{
margin-right:.75em;
}

.divider:not(:empty)::after{
margin-left:.75em;
}

</style>
@endpush


@section('content')

<section class="login-bg min-h-screen flex items-center justify-center px-6">

<div class="max-w-6xl w-full grid md:grid-cols-2 shadow-2xl rounded-3xl overflow-hidden">

<!-- ================= LOGIN VISUAL ================= -->
<div class="hidden md:flex items-center justify-center bg-indigo-600 p-10">

<div class="flex flex-col justify-center items-center text-center text-white space-y-6 login-image">

<img
src="{{ asset('image/piggy.png') }}"
class="w-3/4"
alt="user login">

<h2 class="text-3xl font-bold">
Access Your EasyColoc Space
</h2>

<p class="opacity-90">
Login to manage expenses,
track payments and keep your
colocation finances organized.
</p>

</div>

</div>


<!-- ================= FORM ================= -->
<div class="p-10 md:p-14 glass-card login-form">

<div class="text-center mb-8">

<i class="fas fa-piggy-bank text-4xl text-indigo-600 mb-4"></i>

<h1 class="text-3xl font-bold">
Welcome Back
</h1>

<p class="text-gray-500">
Login to continue
</p>

</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
@csrf

<!-- EMAIL -->
<div>
<label class="font-semibold">
<i class="fas fa-envelope mr-2 text-indigo-500"></i>
Email
</label>

<input
type="email"
name="email"
required
class="w-full mt-2 px-4 py-3 rounded-xl border
focus:ring-2 focus:ring-indigo-400 outline-none">
</div>


<!-- PASSWORD -->
<div>
<label class="font-semibold">
<i class="fas fa-lock mr-2 text-indigo-500"></i>
Password
</label>

<input
type="password"
name="password"
required
class="w-full mt-2 px-4 py-3 rounded-xl border
focus:ring-2 focus:ring-indigo-400 outline-none">
</div>


<div class="flex justify-between text-sm">

<label class="flex gap-2">
<input type="checkbox" name="remember">
Remember me
</label>

<a href="#" class="text-indigo-600 hover:underline">
Forgot password?
</a>

</div>


<button
type="submit"
class="w-full py-3 bg-indigo-600 text-white
rounded-xl font-semibold shadow-lg
hover:bg-indigo-500 transition">

Login
</button>

<div class="divider text-gray-400 mb-6">
OR
</div>

<!-- GOOGLE LOGIN -->
<a href="/auth/google"
class="flex items-center justify-center gap-3 w-full
border py-3 rounded-xl mb-6
hover:bg-gray-50 transition shadow">

<img
src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png"
class="w-6 h-6">

<span class="font-semibold">
Continue with Google
</span>

</a>


<p class="text-center text-gray-600">
Don't have an account ?
<a href="{{ route('signup') }}"
class="text-indigo-600 font-semibold hover:underline">
Sign Up
</a>
</p>

</form>

</div>

</div>

</section>

@endsection
