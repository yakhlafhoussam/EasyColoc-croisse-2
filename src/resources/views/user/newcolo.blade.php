@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-bold mb-6 text-center">Create New Colocation</h1>

    <div class="glass-card p-8 rounded-3xl shadow-xl">
        <form method="POST">
            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-1">Colocation Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="E.g., Coloc Luna">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Max Members --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-1">Max Members</label>
                <input type="number" name="max_members" value="{{ old('max_members') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="E.g., 5">
                @error('max_members')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Country --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-1">Country</label>
                <select id="country" name="country"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Country</option>
                </select>
                @error('country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- City --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-1">City</label>
                <select id="city" name="city"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select City</option>
                </select>
                @error('city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                <textarea name="desc" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Describe your colocation...">{{ old('desc') }}</textarea>
                @error('desc')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                Create Colocation
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function getdata() {
        const res = await fetch("https://countriesnow.space/api/v0.1/countries");
        const datas = await res.json();
        datas.data.forEach(element => {
            document.querySelector('#country').insertAdjacentHTML('beforeend',
                `<option value="${element.iso2}">${element.country}</option>`);
        });
    }

    async function getcity(id) {
        const res = await fetch("https://countriesnow.space/api/v0.1/countries");
        const datas = await res.json();
        datas.data.forEach(coun => {
            if (coun.iso2 == id) {
                const citySelect = document.querySelector('#city');
                citySelect.innerHTML = '<option value="">Select City</option>';
                coun.cities.forEach(city => {
                    citySelect.insertAdjacentHTML('beforeend', `<option value="${city}">${city}</option>`);
                });
            }
        });
    }

    getdata();

    document.querySelector('#country').addEventListener("change", function() {
        getcity(this.value);
    });
</script>
@endpush