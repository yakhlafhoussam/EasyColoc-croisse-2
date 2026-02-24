@extends('layouts.main')

@push('styles')
<style>
    * { font-family: 'Inter', sans-serif; }
    body { background: #f7fafd; }
    .gradient-bg { background: radial-gradient(circle at 30% 30%, rgba(125, 160, 255, 0.2) 0%, transparent 40%), radial-gradient(circle at 80% 70%, rgba(200, 160, 255, 0.15) 0%, transparent 45%), linear-gradient(145deg, #f1f6fe 0%, #fff7f0 100%); }
    .glass-card { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.6); }
    .hover-float { transition: all 0.25s ease; }
    .hover-float:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 25px 30px -15px rgba(79, 114, 202, 0.3); }
    .piggy-float { animation: float 5s infinite ease-in-out; }
    @keyframes float { 0% { transform: translateY(0px) rotate(-0.5deg); } 50% { transform: translateY(-12px) rotate(1deg); } 100% { transform: translateY(0px) rotate(-0.5deg); } }
    /* .coin-spin { animation: infinite linear; } */
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .hover-float { transition: all 0.25s ease; }
    .glass-card { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.6); }
    .piggy-float { filter: drop-shadow(0 20px 15px rgba(245,158,11,0.25)); }
  </style>
@endpush


@section('content')

<!-- ========== HERO SECTION ========== (large, piggy bank + roommates) -->
<section class="relative max-w-[1600px] mx-auto px-6 md:px-10 pt-8 pb-28 md:pb-36 overflow-hidden">
  <!-- floating soft elements -->
  <i class="fas fa-house-user absolute text-7xl text-blue-300/15 right-[8%] bottom-[15%] piggy-float"></i>

  <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-20 relative">
    <!-- LEFT: main headline (with key functional messages) -->
    <div class="flex-1 text-center lg:text-left space-y-8">
      <span class="inline-block px-5 py-2 bg-indigo-100/80 backdrop-blur-sm text-indigo-700 rounded-full text-sm font-semibold border border-indigo-200/50 shadow-sm">
        ⚡ Shared piggy bank · official colocation finance
      </span>
      <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight">
        <span class="bg-gradient-to-r from-indigo-800 via-blue-700 to-purple-800 bg-clip-text text-transparent">Who owes who?</span><br>
        <span class="text-gray-900">Zero stress, clear debts.</span>
      </h1>
      <p class="hero-subtitle text-xl md:text-2xl text-gray-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
        Track shared expenses, split automatically, build reputation — 
        <span class="font-semibold text-indigo-600">one piggy bank for your colocation.</span>
      </p>
      <!-- core functional keywords (tags) -->
      <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
        <span class="bg-white/60 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium text-indigo-700 border border-indigo-200"><i class="fas fa-scale-balanced mr-1"></i> Smart debts</span>
        <span class="bg-white/60 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium text-purple-700 border border-purple-200"><i class="fas fa-envelope-open mr-1"></i> Invitations</span>
        <span class="bg-white/60 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium text-amber-700 border border-amber-200"><i class="fas fa-star mr-1"></i> Reputation</span>
        <span class="bg-white/60 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium text-blue-700 border border-blue-200"><i class="fas fa-users mr-1"></i> Roommate mgmt</span>
      </div>
      <!-- guest action buttons (large) -->
      <div class="hero-buttons flex flex-wrap gap-5 justify-center lg:justify-start pt-4">
        <a href="#" class="px-8 py-4 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-800 font-semibold rounded-2xl shadow-lg hover:bg-white hover:border-indigo-200 transition-all duration-300 flex items-center gap-3 text-xl">
          <i class="fas fa-right-to-bracket text-indigo-500"></i> Log in
        </a>
      </div>
    </div>

    <!-- RIGHT: piggy bank + member illustrations (creative) -->
    <div class="flex-1 relative flex justify-center items-center min-h-[380px]">
      <!-- main piggy icon (big) -->
      <div class="relative piggy-float z-10">
        <div class="absolute inset-0 bg-amber-300/30 blur-3xl rounded-full -z-5"></div>
        <i class="fas fa-piggy-bank text-[13rem] text-amber-400 drop-shadow-2xl"></i>
        <!-- coins around -->
        <i class="fas fa-coins absolute text-7xl text-yellow-500 -bottom-6 -right-8 rotate-12 drop-shadow-2xl"></i>
        <i class="fas fa-coins absolute text-6xl text-yellow-600 -top-5 -left-7 -rotate-12 drop-shadow-xl"></i>
      </div>
      <!-- floating member icons (roommates) -->
      <div class="absolute top-0 left-0 bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-xl border border-white/70">
        <i class="fas fa-user-circle text-5xl text-indigo-400"></i>
      </div>
      <div class="absolute bottom-12 right-0 bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-xl border border-white/70">
        <i class="fas fa-user-astronaut text-5xl text-purple-400"></i>
      </div>
      <div class="absolute top-1/2 -left-6 bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-xl border border-white/70">
        <i class="fas fa-face-smile text-4xl text-amber-500"></i>
      </div>
      <!-- tiny reputation stars -->
      <i class="fas fa-star absolute text-yellow-400 text-sm top-[25%] right-[15%]"></i>
      <i class="fas fa-star absolute text-yellow-400 text-xs bottom-[35%] left-[10%]"></i>
    </div>
  </div>
</section>

<!-- ========== FEATURES SECTION (core functionalities from cahier) ========== -->
<section class="py-20 px-6 md:px-10 max-w-[1700px] mx-auto">
  <div class="text-center mb-16">
    <span class="text-indigo-600 font-semibold tracking-wider text-sm uppercase bg-indigo-50 px-4 py-1.5 rounded-full">Everything in one piggy bank</span>
    <h2 class="text-4xl md:text-5xl font-bold mt-6 mb-4">Designed for colocation peace</h2>
    <p class="text-xl text-gray-500 max-w-2xl mx-auto">Expenses, debts, reputation, invitations — all automated.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-cards">
    <!-- 1. Expense tracking + categories -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-blue-100 to-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-blue-600 shadow-md">
        <i class="fas fa-receipt"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Expense tracking</h3>
      <p class="text-gray-500 text-lg">Add expenses with category, date, payer — split equally or custom. Monthly filter included.</p>
    </div>
    <!-- 2. Smart debt calculation (balances + qui doit quoi) -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-indigo-600 shadow-md">
        <i class="fas fa-scale-balanced"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Smart debt calculation</h3>
      <p class="text-gray-500 text-lg">Individual balances, simplified debts, and "who owes who" view. Mark as paid instantly.</p>
    </div>
    <!-- 3. Roommate management (members, roles) -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-purple-100 to-purple-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-purple-600 shadow-md">
        <i class="fas fa-users"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Roommate management</h3>
      <p class="text-gray-500 text-lg">Members, roles (Owner, Member), reputation scores, and one active coloc per user.</p>
    </div>
    <!-- 4. Invitations system (token/email) -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-green-100 to-green-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-green-600 shadow-md">
        <i class="fas fa-envelope-open"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Invitations system</h3>
      <p class="text-gray-500 text-lg">Invite by email/token, accept/refuse. Owner controls membership.</p>
    </div>
    <!-- 5. Reputation system (+1 / -1) -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-amber-100 to-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-amber-600 shadow-md">
        <i class="fas fa-star"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Reputation system</h3>
      <p class="text-gray-500 text-lg">Leave without debt → +1 ; leave with debt → -1. Owner adjustments handled.</p>
    </div>
    <!-- 6. Global admin & moderation -->
    <div class="feature-card glass-card p-8 rounded-3xl shadow-xl hover-float border border-white/60">
      <div class="bg-gradient-to-br from-rose-100 to-rose-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-3xl text-rose-600 shadow-md">
        <i class="fas fa-chart-pie"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3">Global admin</h3>
      <p class="text-gray-500 text-lg">Global stats, ban/unban users. First user becomes admin automatically.</p>
    </div>
  </div>
</section>

<!-- ========== HOW IT WORKS (step by step, aligned with user stories) ========== -->
<section class="py-20 px-6 md:px-10 bg-gradient-to-r from-indigo-50 via-purple-50 to-blue-50 rounded-t-[4rem] rounded-b-[4rem] max-w-[1700px] mx-auto">
  <h2 class="text-4xl md:text-5xl font-bold text-center mb-4">How EasyColoc works</h2>
  <p class="text-center text-xl text-gray-500 max-w-2xl mx-auto mb-16">From invitation to settlement — three simple flows.</p>
  <div class="flex flex-col md:flex-row gap-8 justify-center items-stretch">
    <!-- step 1: create/invite -->
    <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl flex-1 text-center shadow-xl border border-white/60">
      <span class="bg-indigo-200 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold text-indigo-800 mx-auto mb-5">1</span>
      <i class="fas fa-envelope-open-text text-5xl text-indigo-500 mb-4"></i>
      <h3 class="font-bold text-2xl mb-3">Owner invites</h3>
      <p class="text-gray-500">Create coloc, send token/email. Member accepts → joins (if no other active coloc).</p>
    </div>
    <!-- step 2: add expense / split -->
    <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl flex-1 text-center shadow-xl border border-white/60">
      <span class="bg-purple-200 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold text-purple-800 mx-auto mb-5">2</span>
      <i class="fas fa-calculator text-5xl text-purple-500 mb-4"></i>
      <h3 class="font-bold text-2xl mb-3">Track & split</h3>
      <p class="text-gray-500">Add expense (title, amount, category, payer). Balances update automatically.</p>
    </div>
    <!-- step 3: settle & reputation -->
    <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl flex-1 text-center shadow-xl border border-white/60">
      <span class="bg-amber-200 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold text-amber-800 mx-auto mb-5">3</span>
      <i class="fas fa-hand-holding-heart text-5xl text-amber-500 mb-4"></i>
      <h3 class="font-bold text-2xl mb-3">Settle & reputation</h3>
      <p class="text-gray-500">Mark as paid, leave with/without debt → reputation changes. Owner removal logic.</p>
    </div>
  </div>
  <!-- extra rule note: one active coloc per user -->
  <p class="text-center text-sm text-indigo-500 mt-10 bg-white/50 inline-block px-6 py-2 rounded-full mx-auto"><i class="fas fa-info-circle mr-1"></i> Each user can be in only one active colocation</p>
</section>

<!-- ========== WHY CHOOSE EASYCOLOC (benefits based on spec) ========== -->
<section class="py-20 px-6 md:px-10 max-w-[1700px] mx-auto">
  <div class="grid md:grid-cols-2 gap-16 items-center">
    <div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6">No more manual calculations</h2>
      <ul class="space-y-5 text-lg text-gray-700">
        <li class="flex gap-3"><i class="fas fa-check-circle text-green-500 text-2xl"></i> <span><strong>Automatic balances</strong> – total paid, share, balance for each member.</span></li>
        <li class="flex gap-3"><i class="fas fa-check-circle text-green-500 text-2xl"></i> <span><strong>Reputation system</strong> – +1 for leaving without debt, -1 otherwise.</span></li>
        <li class="flex gap-3"><i class="fas fa-check-circle text-green-500 text-2xl"></i> <span><strong>Owner / Admin powers</strong> – remove members, cancel coloc, manage categories.</span></li>
        <li class="flex gap-3"><i class="fas fa-check-circle text-green-500 text-2xl"></i> <span><strong>Global admin</strong> – ban/unban, stats on users, colocations, expenses.</span></li>
        <li class="flex gap-3"><i class="fas fa-check-circle text-green-500 text-2xl"></i> <span><strong>Filter expenses by month</strong> – default all months.</span></li>
      </ul>
    </div>
    <div class="flex justify-center">
      <img src="https://medias.student-factory.com/_medias-student-prod_/efacc2f9-4017-4d2e-9091-25ff7d23e454/Coloc-etudiants-1.jpeg?w=3840&q=75" alt="roommates paying" class="rounded-3xl shadow-2xl border-8 border-white/60">
    </div>
  </div>
</section>

@endsection


@push('scripts')

<!-- GSAP animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
  gsap.registerPlugin(ScrollTrigger);
  
  // Hero entrance
  gsap.from('.hero-title', { opacity: 1, y: 50, duration: 1, ease: 'power3.out' });
  gsap.from('.hero-subtitle', { opacity: 1, y: 30, duration: 1, delay: 0.2, ease: 'power3.out' });
  gsap.from('.hero-buttons a', { opacity: 1, scale: 0.8, duration: 0.6, delay: 0.4, stagger: 0.15, ease: 'back.out(1.7)' });
  gsap.from('.piggy-float', { opacity: 1, x: 80, duration: 1.2, delay: 0.1, ease: 'power3.out' });
  gsap.from('.absolute.top-0.left-0', { opacity: 1, x: -40, y: -20, duration: 1, delay: 0.6 });
  gsap.from('.absolute.bottom-12.right-0', { opacity: 1, x: 40, y: 20, duration: 1, delay: 0.8 });

  // Feature cards stagger on scroll
  gsap.from('.feature-card', {
    opacity: 1,
    y: 50,
    duration: 0.8,
    stagger: 0.15,
    ease: 'power2.out',
    scrollTrigger: { trigger: '.stagger-cards', start: 'top 80%' }
  });

  // Steps animation
  gsap.from('.bg-white\\/70', {
    opacity: 1,
    y: 40,
    duration: 0.7,
    stagger: 0.2,
    scrollTrigger: { trigger: '.bg-white\\/70', start: 'top 85%' }
  });

  // CTA zoom
  gsap.from('.bg-gradient-to-br.from-indigo-600', {
    opacity: 1,
    scale: 0.9,
    duration: 1,
    scrollTrigger: { trigger: '.bg-gradient-to-br.from-indigo-600', start: 'top 85%' }
  });
</script>

@endpush