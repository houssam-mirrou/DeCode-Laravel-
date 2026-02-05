@extends('layout')

@section('title', $brief->title . ' - Project Details')

@section('content')
    {{-- HEADER --}}
    <div class="flex flex-col">
        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div class="flex items-center gap-6">
                <a href="{{ route('project.index') }}"
                    class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-xl transition-all shadow-sm group">
                    <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>

                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ $brief->title }}</h2>
                    <div class="flex items-center gap-3 text-xs mt-1">
                        {{-- Accessing Relationship: $brief->sprint --}}
                        <span class="font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                            {{ $brief->sprint->name ?? 'Unknown Sprint' }}
                        </span>
                        <span class="text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Due: {{ date('M d, Y', strtotime($brief->date_remise)) }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: Details --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Context / Description --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-6 opacity-5">
                            <i data-lucide="file-code" class="w-32 h-32"></i>
                        </div>

                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <span class="w-6 h-0.5 bg-indigo-500 rounded-full"></span> Context
                        </h3>

                        <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                            {!! nl2br(e($brief->description)) !!}
                        </div>
                    </div>

                    {{-- Competencies --}}
                    <div>
                        <div class="flex items-center justify-between mb-4 px-1">
                            <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                <i data-lucide="target" class="w-4 h-4 text-indigo-500"></i> Target Competencies
                            </h3>
                            <span
                                class="text-xs bg-white border border-slate-200 px-2.5 py-1 rounded-full text-slate-500 font-bold shadow-sm">
                                {{ $brief->competences->count() }} Skills
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($brief->competences as $comp)
                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shadow-sm group-hover:scale-110 transition-transform">
                                                {{ $comp->code }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-slate-800 line-clamp-1">
                                                    {{ $comp->libelle }}</h4>
                                                <p class="text-[10px] text-slate-400">Technical Skill</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Level</span>
                                            {{-- Access Pivot Data --}}
                                            <span
                                                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                                {{ $comp->pivot->level ?? '1' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-full p-8 text-center bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                                    <span class="text-sm">No specific competencies listed.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Actions & Status --}}
                <div class="space-y-6">
                    <div class="sticky top-24">

                        @php
                            // Logic based on relationships loaded in Controller
                            $myLivrable = $brief->livrables->first();
                            $myEvaluation = $brief->evaluations->first();

                            $status = 'todo';
                            if ($myEvaluation) {
                                $status = 'done';
                            } elseif ($myLivrable) {
                                $status = 'submitted';
                            }
                        @endphp

                        {{-- 1. EVALUATED STATE --}}
                        @if ($status == 'done')
                            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">
                                <div
                                    class="bg-gradient-to-b from-emerald-50 to-white p-8 text-center border-b border-emerald-50">
                                    <div
                                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-emerald-50">
                                        <i data-lucide="check-check" class="w-10 h-10 text-emerald-500"></i>
                                    </div>
                                    <h4 class="text-2xl font-bold text-emerald-800 tracking-tight">Evaluated</h4>
                                    <div
                                        class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wide border border-emerald-200">
                                        Status: {{ ucfirst($myEvaluation->review ?? 'Completed') }}
                                    </div>
                                </div>
                                <div class="p-6">
                                    <a href="#"
                                        class="flex items-center justify-center gap-2 w-full py-3 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                                        View Full Report <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>

                            {{-- 2. SUBMITTED STATE --}}
                        @elseif($status == 'submitted')
                            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
                                <div
                                    class="bg-gradient-to-b from-amber-50 to-white p-8 text-center border-b border-amber-50">
                                    <div
                                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-amber-50">
                                        <i data-lucide="hourglass" class="w-10 h-10 text-amber-500 animate-pulse"></i>
                                    </div>
                                    <h4 class="text-2xl font-bold text-slate-800 tracking-tight">Pending Review</h4>
                                    <p class="text-sm text-slate-500 mt-1">Submitted on
                                        {{ date('M d', strtotime($myLivrable->date_submitted)) }}</p>
                                </div>

                                <div class="p-6">
                                    <div
                                        class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm group hover:border-indigo-300 transition-colors">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase block mb-2">Repository
                                            Link</label>
                                        <a href="{{ $myLivrable->url }}" target="_blank"
                                            class="flex items-center gap-3 text-indigo-600">
                                            <div class="p-1.5 bg-indigo-50 rounded text-indigo-600">
                                                <i data-lucide="github" class="w-4 h-4"></i>
                                            </div>
                                            <span
                                                class="text-sm font-bold truncate underline decoration-indigo-200 hover:decoration-indigo-500 transition-all">
                                                {{ $myLivrable->url }}
                                            </span>
                                        </a>
                                    </div>

                                </div>
                            </div>

                            {{-- 3. TODO STATE (Submit Form) --}}
                        @else
                            <div
                                class="bg-white rounded-2xl border border-slate-200 shadow-lg shadow-indigo-500/10 overflow-hidden">
                                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="p-2 bg-indigo-600 rounded-lg shadow-md shadow-indigo-200">
                                            <i data-lucide="send" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <h4 class="text-lg font-bold text-slate-800">Submit Project</h4>
                                    </div>
                                    <p class="text-xs text-slate-500 pl-1">Ready to deliver? Paste your GitHub repository
                                        below.</p>
                                </div>

                                <form action="{{ route('project.store') }}" method="POST" class="p-6 space-y-5">
                                    @csrf
                                    <input type="hidden" name="brief_id" value="{{ $brief->id }}">

                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5 ml-1">GitHub
                                            Repository <span class="text-red-500">*</span></label>
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i data-lucide="link"
                                                    class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                                            </div>
                                            <input type="url" name="repo_link" required
                                                placeholder="https://github.com/username/repo"
                                                class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 bg-white text-sm placeholder:text-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 shadow-sm transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold uppercase text-slate-500 mb-1.5 ml-1">Comments
                                            (Optional)</label>
                                        <textarea name="comment" rows="3" placeholder="Any notes for the teacher..."
                                            class="block w-full px-3 py-2.5 rounded-xl border-slate-200 bg-white text-sm placeholder:text-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 shadow-sm transition-all resize-none"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                        <i data-lucide="rocket" class="w-4 h-4"></i> Submit Work
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </main>
    </div>


    <script>
        lucide.createIcons();
    </script>
@endsection
