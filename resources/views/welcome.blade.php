@extends('layouts.app')

@section('title' , 'Home Page')

@section('content')

<div class="bg-white min-h-screen">
   <header class="relative overflow-hidden bg-slate-50 py-16 sm:py-32">
        <div class="absolute inset-0 opacity-10 [mask-image:linear-gradient(to_bottom,white,transparent)]" style="background-image: radial-gradient(#1c7ed6 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-blue-100 text-[#1c7ed6] mb-8">
                ✨ New 2026 Revision Bundles Now Available
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-7xl">
                The Smartest Way to <br/>
                <span class="text-[#1c7ed6]">Ace Your Exams</span>
            </h1>
            <p class="mt-8 text-lg leading-8 text-slate-600 max-w-2xl mx-auto">
                Join 10,000+ students using Protrixx Learn to access verified past papers, marking schemes, and expert study notes. Everything you need to succeed, delivered instantly.
            </p>
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#browse" class="w-full sm:w-auto rounded-xl bg-[#1c7ed6] px-8 py-4 text-lg font-bold text-white shadow-xl shadow-[#1c7ed6]/30 hover:bg-[#1669b3] transition-all transform hover:-translate-y-1">
                    Start Learning Now
                </a>
                <a href="#" class="text-slate-600 font-bold hover:text-slate-900">View Free Samples →</a>
            </div>
        </div>
    </header>

    <section class="py-12 bg-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 text-center border-y border-slate-100 py-10">
                <div><p class="text-3xl font-bold text-[#1c7ed6]">5k+</p><p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Papers</p></div>
                <div><p class="text-3xl font-bold text-[#1c7ed6]">12k+</p><p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Students</p></div>
                <div><p class="text-3xl font-bold text-[#1c7ed6]">100%</p><p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Verified</p></div>
                <div><p class="text-3xl font-bold text-[#1c7ed6]">Instant</p><p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Download</p></div>
            </div>
        </div>
    </section>

    <section id="browse" class="py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Browse by Category</h2>
                <p class="text-slate-500 mt-2">Everything from Primary to Professional qualifications.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="p-8 bg-white border border-slate-100 rounded-3xl hover:border-[#1c7ed6] hover:shadow-2xl hover:shadow-blue-100 transition-all cursor-pointer group">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#1c7ed6] transition-colors text-[#1c7ed6] group-hover:text-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="text-xl font-bold">National Exams</h3>
                    <p class="text-slate-500 mt-2 text-sm">Official papers from 2015-2025 across all subjects.</p>
                </div>
                <div class="p-8 bg-white border border-slate-100 rounded-3xl hover:border-[#1c7ed6] hover:shadow-2xl hover:shadow-blue-100 transition-all cursor-pointer group">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#1c7ed6] transition-colors text-[#1c7ed6] group-hover:text-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold">Premium Notes</h3>
                    <p class="text-slate-500 mt-2 text-sm">Concise, high-yield revision notes tailored for final exams.</p>
                </div>
                <div class="p-8 bg-white border border-slate-100 rounded-3xl hover:border-[#1c7ed6] hover:shadow-2xl hover:shadow-blue-100 transition-all cursor-pointer group">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#1c7ed6] transition-colors text-[#1c7ed6] group-hover:text-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold">Mock Exams</h3>
                    <p class="text-slate-500 mt-2 text-sm">Practice papers from leading institutions nationwide.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold">Popular This Week</h2>
                    <p class="text-slate-500">Most downloaded resources by other students.</p>
                </div>
                <a href="#" class="hidden sm:block font-bold text-[#1c7ed6]">View All →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 group hover:shadow-lg transition-all">
                    <div class="aspect-square bg-slate-100 rounded-xl mb-4 flex items-center justify-center">
                        <svg class="h-16 w-16 text-slate-300 group-hover:text-[#1c7ed6] transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold text-[#1c7ed6] mb-2 uppercase tracking-wide">
                        <span>Biology</span>
                        <span class="text-slate-900">$3.00</span>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-4 line-clamp-1">2024 Biology Paper 1 + MS</h4>
                    <button class="w-full bg-slate-900 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-[#1c7ed6] transition-colors">Quick Purchase</button>
                </div>
                </div>
        </div>
    </section>

@endsection
