@extends('layout')

@section('title', 'Evaluate: ' . $student->first_name . ' ' . $student->last_name)

@section('content')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        {{-- HEADER --}}
        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div class="flex items-center gap-6">
                <a href="{{ route('evaluation.index') }}"
                    class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-xl transition-all shadow-sm group">
                    <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ $student->first_name }}
                        {{ $student->last_name }}</h2>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mt-0.5">
                        <span
                            class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100">Student</span>
                        <span class="text-slate-300">•</span>
                        <span>Project: <span class="text-slate-700 font-bold">{{ $brief->title }}</span></span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if ($livrable)
                    <span class="text-xs text-slate-400 font-medium">
                        Submitted: {{ date('M d, H:i', strtotime($livrable->date_submitted)) }}
                    </span>
                @else
                    <span class="text-xs text-red-400 font-bold">No Submission Yet</span>
                @endif
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- LEFT COLUMN: Context --}}
                <div class="space-y-6">

                    {{-- Repository Card --}}
                    <div class="bg-slate-900 rounded-2xl shadow-lg overflow-hidden border border-slate-800">
                        <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-950/50">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                <i data-lucide="github" class="w-4 h-4"></i> Repository
                            </h3>
                            <span
                                class="text-[10px] bg-slate-800 text-slate-300 px-2 py-1 rounded border border-slate-700 font-mono">Public</span>
                        </div>

                        <div class="p-6">
                            @if ($livrable)
                                <div
                                    class="flex items-center justify-between gap-4 p-4 rounded-xl bg-slate-800/50 border border-slate-700 mb-6 group hover:border-indigo-500/50 transition-colors">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="p-2 bg-slate-800 rounded-lg text-indigo-400">
                                            <i data-lucide="folder-git-2" class="w-5 h-5"></i>
                                        </div>
                                        <a href="{{ $livrable->url }}" target="_blank"
                                            class="text-indigo-400 font-mono text-sm hover:underline hover:text-indigo-300 truncate transition-colors">
                                            {{ $livrable->url }}
                                        </a>
                                    </div>
                                    <a href="{{ $livrable->url }}" target="_blank"
                                        class="text-slate-500 hover:text-white transition-colors">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </div>

                                <div class="space-y-2">
                                    <p class="text-xs font-bold text-slate-500 uppercase">Student Comments</p>
                                    <div
                                        class="text-sm text-slate-300 leading-relaxed italic bg-slate-800/30 p-4 rounded-lg border border-slate-800/50 relative">
                                        <i data-lucide="quote" class="w-4 h-4 text-slate-700 absolute top-2 right-2"></i>
                                        "{{ $livrable->comment ?? 'No additional comments provided.' }}"
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

                    {{-- Brief Description --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <span class="w-1 h-4 bg-indigo-500 rounded-full"></span> Brief Context
                        </h3>
                        <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                            {!! nl2br(e($brief->description)) !!}
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Evaluation Form --}}
                <div
                    class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/50 flex flex-col h-fit sticky top-24">
                    <div
                        class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50 rounded-t-2xl flex justify-between items-center">
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

                    {{-- FORM START --}}
                    <form action="{{ route('evaluation.store') }}" method="POST" class="flex-1 flex flex-col">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <input type="hidden" name="brief_id" value="{{ $brief->id }}">

                        <div class="p-8 space-y-8 flex-1">

                            <div class="space-y-6">
                                @foreach ($brief->competences as $comp)
                                    {{-- Check if previously graded --}}
                                    @php
                                        $evaluatedLevel = null;
                                        if ($evaluation) {
                                            // Find this competence in the evaluation pivot
                                            $gradedComp = $evaluation->competence_grades->find($comp->id);
                                            if ($gradedComp) {
                                                $evaluatedLevel = $gradedComp->pivot->level;
                                            }
                                        }
                                    @endphp

                                    <div class="relative">
                                        <div class="flex justify-between items-end mb-3">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 text-xs font-bold text-slate-600 font-mono shadow-sm">
                                                    {{ $comp->code }}
                                                </span>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">{{ $comp->libelle }}</p>
                                                </div>
                                            </div>
                                            {{-- Target Level from Brief Pivot --}}
                                            <span
                                                class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                                Target: Level {{ $comp->pivot->level ?? 1 }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-3 gap-3">
                                            @foreach (['IMITER' => 'Level 1', 'S_ADAPTER' => 'Level 2', 'TRANSPOSER' => 'Level 3'] as $value => $label)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="competences[{{ $comp->id }}]"
                                                        {{ isset($evaluation) ? 'disabled' : '' }}
                                                        value="{{ $value }}" class="peer sr-only"
                                                        {{ $evaluatedLevel === $value ? 'checked' : '' }} required>

                                                    <div
                                                        class="text-center py-2.5 rounded-lg border-2 border-slate-100 bg-white text-xs font-bold text-slate-400 transition-all hover:border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-md">
                                                        {{ $label }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <hr class="border-slate-100">
                                    @endif
                                @endforeach
                            </div>

                            <div
                                class="bg-slate-50 p-4 rounded-xl border border-slate-100 focus-within:border-indigo-300 focus-within:ring-4 focus-within:ring-indigo-100 transition-all">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Teacher's
                                    Feedback</label>
                                <textarea name="comments" rows="4" {{ isset($evaluation) ? 'disabled' : '' }}
                                    class="w-full bg-transparent border-none p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0 resize-none"
                                    placeholder="Write constructive feedback for the student...">{{ $evaluation->comments ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="bg-slate-50 border-t border-slate-200 p-8 rounded-b-2xl">
                            <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i data-lucide="gavel" class="w-4 h-4 text-slate-400"></i> Final Verdict
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Global Level --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Complexity
                                        Level</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach (['IMITER', 'S_ADAPTER', 'TRANSPOSER'] as $lvl)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="level" value="{{ $lvl }}"
                                                    class="peer sr-only" {{ isset($evaluation) ? 'disabled' : '' }}
                                                    {{ ($evaluation->level ?? '') == $lvl ? 'checked' : '' }} required>

                                                <div
                                                    class="text-center py-2 rounded-lg border border-slate-200 bg-white text-[10px] font-bold text-slate-500 hover:border-slate-400 peer-checked:bg-slate-800 peer-checked:text-white peer-checked:border-slate-800 transition-all">
                                                    {{ ucfirst(strtolower(str_replace('S_', '', $lvl))) }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Review Status --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Validation
                                        Status</label>
                                    <div class="flex gap-2">
                                        @php $status = $evaluation->review ?? ''; @endphp

                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="review" value="bad" class="peer sr-only"
                                                {{ $status === 'bad' ? 'checked' : '' }}
                                                {{ isset($evaluation) ? 'disabled' : '' }} required>
                                            <div
                                                class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-red-200 peer-checked:bg-red-50 peer-checked:text-red-600 peer-checked:border-red-200 transition-all">
                                                Bad</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="review" value="good" class="peer sr-only"
                                                {{ $status === 'good' ? 'checked' : '' }}
                                                {{ isset($evaluation) ? 'disabled' : '' }}>
                                            <div
                                                class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-emerald-200 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200 transition-all">
                                                Good</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="review" value="excellent" class="peer sr-only"
                                                {{ $status === 'excellent' ? 'checked' : '' }}
                                                {{ isset($evaluation) ? 'disabled' : '' }}>
                                            <div
                                                class="text-center py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-500 hover:border-indigo-200 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 peer-checked:border-indigo-200 transition-all">
                                                Excel</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" {{ isset($evaluation) ? 'disabled' : '' }}
                                class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                {{ isset($evaluation) ? 'Evaluation Locked' : 'Save & Publish Evaluation' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
