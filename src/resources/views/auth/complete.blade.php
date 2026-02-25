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

.input:focus:enabled{
  border-color:#6366f1;
  box-shadow:0 0 0 3px rgba(99,102,241,.2);
}

.input:disabled{
  background:#f3f4f6;
  cursor:not-allowed;
  opacity:0.8;
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
src="{{ asset('image/profile-complete.png') }}"
class="w-3/4"
alt="complete profile">

<h2 class="text-4xl font-bold text-center">
Complete Your Profile
</h2>

<p class="text-center opacity-90 max-w-md">
Almost there! Just a few more details to start your colocation journey
and manage your shared piggy bank effortlessly.
</p>

</div>

<!-- ================= FORM ================= -->
<div class="p-8 md:p-12">

<div class="text-center mb-8">

<i class="fas fa-user-edit text-4xl text-indigo-600 mb-3"></i>

<h1 class="text-3xl font-bold">
Complete Profile
</h1>

<p class="text-gray-500">
Fill in the remaining details to continue
</p>

</div>

<form method="POST" action="{{ route('complete-profile') }}"
class="grid md:grid-cols-2 gap-5">

@csrf

{{-- Email (from Google) --}}
<input type="email" name="email" placeholder="Email"
value="{{ $user->email ?? '' }}" class="input md:col-span-2 google-field" disabled>

{{-- Firstname (from Google) --}}
<input name="firstname" placeholder="First Name"
value="{{ old('firstname', $user->firstname ?? '') }}" class="input google-field">

{{-- Lastname (from Google) --}}
<input name="lastname" placeholder="Last Name"
value="{{ old('lastname', $user->lastname ?? '') }}" class="input google-field">

{{-- Profile Image URL (from Google) --}}
<input name="profile_image" placeholder="Profile Image URL"
value="{{ old('profile_image', $user->profile_image ?? '') }}" class="input md:col-span-2 google-field">

{{-- CIN --}}
<input name="cin" placeholder="CIN" required
value="{{ old('cin', $user->cin ?? '') }}" class="input">

{{-- Country --}}
<input name="country" placeholder="Country" required
value="{{ old('country', $user->country ?? '') }}" class="input">

{{-- City --}}
<input name="city" placeholder="City" required
value="{{ old('city', $user->city ?? '') }}" class="input">

{{-- Birth Date --}}
<input type="date" name="birth_date" required
value="{{ old('birth_date', $user->birth_date ?? '') }}" class="input">

{{-- Occupation Type --}}
<select name="type_occupation" required class="input">
<option value="">Occupation Type</option>
<option value="work" {{ (old('type_occupation',$user->type_occupation ?? '')=='work') ? 'selected':'' }}>Work</option>
<option value="study" {{ (old('type_occupation',$user->type_occupation ?? '')=='study') ? 'selected':'' }}>Study</option>
</select>

{{-- Occupation --}}
<input name="occupation" placeholder="Occupation"
class="input"
required value="{{ old('occupation', $user->occupation ?? '') }}">

<button type="submit"
class="btn-main text-white py-3 rounded-xl font-semibold md:col-span-2">
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
// // Animate Google fields
// gsap.from('.google-field', {
//   opacity:0,
//   x:-50,
//   duration:0.8,
//   stagger:0.2,
//   ease:"power3.out"
// });

// // Animate normal inputs
// gsap.from('.input:not(.google-field)', {
//   opacity:0,
//   y:30,
//   duration:0.8,
//   stagger:0.1,
//   delay:0.5,
//   ease:"power3.out"
// });

// // Animate button
// gsap.from('.btn-main', {
//   opacity:0,
//   scale:0.8,
//   duration:0.6,
//   delay:1.2,
//   ease:"back.out(1.7)"
// });
</script>

@endpush