@extends('layout')

@section('title', 'Evaluate: ' . $dto->fullName)

@section('content')
    <div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
        
        <aside class="w-72 bg-white border-r border-slate-200 hidden md:flex flex-col z-20 shadow-sm">
            <div class="h-20 flex items-center px-8 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <i data-lucide="graduation-cap" class="w-6 h-6 text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-wide">DECODE <span
                            class="text-xs text-indigo-500 font-bold ml-1 uppercase">Teacher</span></h1>
                </div>
            </div>
            <nav class="flex-1 px-4 py-8 space-y-2">
                <a href="/"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                <a href="/teacher/briefs"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="file-code" class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">My Briefs</span>
                </a>
                <a href="/teacher/evaluations"
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">Evaluations</span>
                </a>
                <a href="/teacher/students"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="users" class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Students & Progress</span>
                </a>
            </nav>
            
            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        TC
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">Teacher</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wide font-semibold">Logged In</p>
                    </div>
                    <form action="/logout" method="POST">
                        <button type="submit" class="text-slate-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded-lg transition-all" title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
                <div class="flex items-center gap-6">
                    <a href="/teacher/briefs" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-xl transition-all shadow-sm group">
                        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform"></i>
                    </a>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ $dto->fullName }}</h2>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mt-0.5">
                            <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100">Student</span>
                            <span class="text-slate-300">•</span>
                            <span>Project: <span class="text-slate-700 font-bold">{{ $dto->briefTitle }}</span></span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400 font-medium">
                        Submission: {{ date('M d, H:i', strtotime($dto->dateSubmitted)) }}
                    </span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <div class="space-y-6">
                        
                        <div class="bg-slate-900 rounded-2xl shadow-lg overflow-hidden border border-slate-800">
                            <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-950/50">
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i data-lucide="github" class="w-4 h-4"></i> Repository
                                </h3>
                                <span class="text-[10px] bg-slate-800 text-slate-300 px-2 py-1 rounded border border-slate-700 font-mono">Public</span>
                            </div>
                            
                            <div class="p-6">
                                @if ($dto->repoLink)
                                    <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-slate-800/50 border border-slate-700 mb-6 group hover:border-indigo-500/50 transition-colors">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="p-2 bg-slate-800 rounded-lg text-indigo-400">
                                                <i data-lucide="folder-git-2" class="w-5 h-5"></i>
                                            </div>
                                            <a href="{{ $dto->repoLink }}" target="_blank"
                                                class="text-indigo-400 font-mono text-sm hover:underline hover:text-indigo-300 truncate transition-colors">
                                                {{ $dto->repoLink }}
                                            </a>
                                        </div>
                                        <a href="{{ $dto->repoLink }}" target="_blank" class="text-slate-500 hover:text-white transition-colors">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-xs font-bold text-slate-500 uppercase">Student Comments</p>
                                        <div class="text-sm text-slate-300 leading-relaxed italic bg-slate-800/30 p-4 rounded-lg border border-slate-800/50 relative">
                                            <i data-lucide="quote" class="w-4 h-4 text-slate-700 absolute top-2 right-2"></i>
                                            "{{ $dto->studentComment ?? 'No additional comments provided.' }}"
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-8 text-slate-600">
                                        <i data-lucide="alert-circle" class="w-8 h-8 mb-2 text-red-500"></i>
                                        <p class="text-sm font-medium text-slate-400">No repository submitted.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-1 h-4 bg-indigo-500 rounded-full"></span> Brief Context
                            </h3>
                            <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                                {!! nl2br($dto->briefDescription) !!}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/50 flex flex-col h-fit sticky top-24">
                        <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50 rounded-t-2xl flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                    Evaluation
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">Assess competencies and provide feedback</p>
                            </div>
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <i data-lucide="pen-tool" class="w-5 h-5"></i>
                            </div>
                        </div>

                        <form action="/teacher/evaluate/submit" method="POST" class="flex-1 flex flex-col">
                            <input type="hidden" name="student_id" value="{{ $dto->studentId }}">
                            <input type="hidden" name="brief_id" value="{{ $dto->briefId }}">
                            <input type="hidden" name="evaluation_id" value="{{ $dto->evaluationId }}">

                            <div class="p-8 space-y-8 flex-1">
                                
                                <div class="space-y-6">
                                    @foreach ($dto->competences as $comp)
                                        <div class="relative">
                                            <div class="flex justify-between items-end mb-3">
                                                <div class="flex items-center gap-3">
                                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 text-xs font-bold text-slate-600 font-mono shadow-sm">
                                                        {{ $comp->code }}
                                                    </span>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-800">{{ $comp->libelle }}</p>
                                                    </div>
                                                </div>
                                                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                                    Target: Level {{ $comp->targetLevel }}
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-3 gap-3">
                                                @foreach (['IMITER' => 'Level 1', 'S_ADAPTER' => 'Level 2', 'TRANSPOSER' => 'Level 3'] as $value => $label)
                                                    <label class="cursor-pointer group">
                                                        <input type="radio" name="competences[{{ $comp->id }}]" {{isset($dto->evaluationId) ? 'disabled' : ''}}
                                                            value="{{ $value }}" class="peer sr-only"
                                                            {{ $comp->acquiredLevel === $value ? 'checked' : '' }} required>

                                                        <div class="text-center py-2.5 rounded-lg border-2 border-slate-100 bg-white text-xs font-bold text-slate-400 transition-all hover:border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-md">
                                                            {{ $label }}
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if(!$loop->last) <hr class="border-slate-100"> @endif
                                    @endforeach
                                </div>

                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 focus-within:border-indigo-300 focus-within:ring-4 focus-within:ring-indigo-100 transition-all">
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Teacher's Feedback</label>
                                    <textarea name="comment" rows="4" {{isset($dto->evaluationId) ? 'disabled' : ''}}
                                        class="w-full bg-transparent border-none p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0 resize-none"
                                        placeholder="Write constructive feedback for the student...">{{ $dto->teacherComment }}</textarea>
                                </div>
                            </div>

                            <div class="bg-slate-50 border-t border-slate-200 p-8 rounded-b-2xl">
                                <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i data-lucide="gavel" class="w-4 h-4 text-slate-400"></i> Final Verdict
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Complexity Level</label>
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach(['IMITER', 'S_ADAPTER', 'TRANSPOSER'] as $lvl)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="level" value="{{ $lvl }}" class="peer sr-only"
                                                        {{ ($dto->evaluationLevel ?? '') == $lvl ? 'checked' : '' }} required>
                                                    <div class="text-center py-2 rounded-lg border border-slate-200 bg-white text-[10px] font-bold text-slate-500 hover:border-slate-400 peer-checked:bg-slate-800 peer-checked:text-white peer-checked:border-slate-800 transition-all">
                                                        {{ ucfirst(strtolower(str_replace('S_', '', $lvl))) }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Validation Status</label>
                                        <div class="flex gap-2">
                                            <label class="flex-1 cursor-pointer">
                                                <input type="radio" name="review" value="bad" class="peer sr-only" {{ $dto->reviewStatus === 'bad' ? 'checked' : '' }} required>
                                                <div class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-red-200 peer-checked:bg-red-50 peer-checked:text-red-600 peer-checked:border-red-200 transition-all">
                                                    Bad
                                                </div>
                                            </label>
                                            <label class="flex-1 cursor-pointer">
                                                <input type="radio" name="review" value="good" class="peer sr-only" {{ $dto->reviewStatus === 'good' ? 'checked' : '' }}>
                                                <div class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-emerald-200 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200 transition-all">
                                                    Good
                                                </div>
                                            </label>
                                            <label class="flex-1 cursor-pointer">
                                                <input type="radio" name="review" value="excellent" class="peer sr-only" {{ $dto->reviewStatus === 'excellent' ? 'checked' : '' }}>
                                                <div class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-indigo-200 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 peer-checked:border-indigo-200 transition-all">
                                                    Excel
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" {{isset($dto->evaluationId) ? 'disabled' : ''}}
                                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                    <i data-lucide="save" class="w-4 h-4"></i> 
                                    {{ isset($dto->evaluationId) ? 'Evaluation Locked' : 'Save & Publish Evaluation' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
@endsection