@extends('layout')

@section('title', 'My Evaluations')

@section('content')



    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Performance Reports</h2>
                <p class="text-xs text-slate-500 mt-0.5">Feedback and skill validation history</p>
            </div>

            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500 shadow-sm">
                    Total Evaluated: {{ $evaluations->count() }}
                </span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-5xl mx-auto space-y-8">

                @forelse($evaluations as $eval)
                    @php
                        // Styling Logic based on 'review' column (bad/good/excellent)
                        $statusConfig = match ($eval->review) {
                            'excellent' => [
                                'text' => 'Excellent',
                                'class' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                            ],
                            'good' => [
                                'text' => 'Good',
                                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            ],
                            'bad' => ['text' => 'Needs Work', 'class' => 'bg-red-50 text-red-700 border-red-100'],
                            default => [
                                'text' => 'Pending',
                                'class' => 'bg-slate-50 text-slate-600 border-slate-100',
                            ],
                        };
                    @endphp

                    <div
                        class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:shadow-lg hover:border-indigo-200 transition-all duration-300">

                        {{-- Card Header --}}
                        <div
                            class="px-8 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                            <div>
                                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="file-check" class="w-5 h-5 text-indigo-500"></i>
                                    {{ $eval->briefs->title }}
                                </h2>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mt-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    <span>Graded on {{ date('M d, Y', strtotime($eval->date)) }}</span>
                                </div>
                            </div>

                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-bold border uppercase tracking-wide shadow-sm {{ $statusConfig['class'] }}">
                                {{ $statusConfig['text'] }}
                            </span>
                        </div>

                        <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-10">

                            {{-- Feedback Section --}}
                            <div class="lg:col-span-1">
                                <h3
                                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <i data-lucide="message-square" class="w-3 h-3"></i> Feedback
                                </h3>

                                <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 relative group">
                                    <i data-lucide="quote"
                                        class="w-8 h-8 text-indigo-100 absolute -top-3 -left-2 fill-indigo-50"></i>
                                    <p class="text-sm text-slate-600 italic leading-relaxed relative z-10">
                                        "{{ $eval->comments ?? 'No additional comments provided.' }}"
                                    </p>
                                    <div class="mt-4 flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                                            TC
                                        </div>
                                        <span class="text-xs font-bold text-slate-400">Teacher</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Competencies Section --}}
                            <div class="lg:col-span-2">
                                <h3
                                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <i data-lucide="bar-chart-2" class="w-3 h-3"></i> Competency Breakdown
                                </h3>

                                @if ($eval->competences->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach ($eval->competences as $comp)
                                            @php
                                                // Access Pivot Data
                                                $level = $comp->pivot->level ?? 'IMITER';

                                                $lvlColor = match ($level) {
                                                    'TRANSPOSER'
                                                        => 'text-purple-700 bg-purple-50 border-purple-100 ring-purple-500/20',
                                                    'S_ADAPTER'
                                                        => 'text-indigo-700 bg-indigo-50 border-indigo-100 ring-indigo-500/20',
                                                    'IMITER'
                                                        => 'text-slate-600 bg-slate-100 border-slate-200 ring-slate-500/20',
                                                    default => 'text-gray-500',
                                                };

                                                // Clean up text (S_ADAPTER -> Adapter)
                                                $lvlText = ucfirst(strtolower(str_replace(['S_', '_'], '', $level)));
                                            @endphp

                                            <div
                                                class="flex items-center justify-between p-3.5 border border-slate-100 rounded-xl bg-white shadow-[0_2px_8px_-2px_rgba(0,0,0,0.02)] hover:border-indigo-100 hover:shadow-md transition-all group">
                                                <div class="flex items-center gap-3 overflow-hidden">
                                                    <div
                                                        class="w-1.5 h-8 rounded-full bg-slate-200 group-hover:bg-indigo-500 transition-colors">
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="flex items-center gap-2">
                                                            <span
                                                                class="text-xs font-mono font-bold text-slate-400">{{ $comp->code }}</span>
                                                        </div>
                                                        <p class="text-sm font-bold text-slate-700 truncate"
                                                            title="{{ $comp->libelle }}">
                                                            {{ $comp->libelle }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <span
                                                    class="px-2.5 py-1 text-[10px] font-bold border rounded-lg shadow-sm ring-1 ring-inset {{ $lvlColor }}">
                                                    {{ $lvlText }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-6 border-2 border-dashed border-slate-100 rounded-xl text-center">
                                        <p class="text-sm text-slate-400 italic">No specific skills graded for this
                                            project.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-center py-24 bg-white border border-slate-200 rounded-2xl border-dashed">
                        <div class="p-6 bg-slate-50 rounded-full mb-4 shadow-sm">
                            <i data-lucide="clipboard-list" class="w-10 h-10 text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No Evaluations Yet</h3>
                        <p class="text-slate-500 mt-2 max-w-xs text-center">Once your teacher grades your submitted
                            briefs, the reports will appear here.</p>
                    </div>
                @endforelse

            </div>
        </main>

    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
