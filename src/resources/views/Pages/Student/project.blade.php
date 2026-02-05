@extends('layout')

@section('title', 'All Projects - Student')

@section('content')
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Project Archive</h2>
                <p class="text-xs text-slate-500 mt-0.5">All sprints and assignments history</p>
            </div>

            <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200">
                <button
                    class="px-4 py-1.5 text-xs font-bold bg-white text-slate-800 shadow-sm rounded-lg border border-slate-100">All</button>
                <button
                    class="px-4 py-1.5 text-xs font-medium text-slate-500 hover:text-slate-700 transition-colors">Active</button>
                <button
                    class="px-4 py-1.5 text-xs font-medium text-slate-500 hover:text-slate-700 transition-colors">Completed</button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-7xl mx-auto space-y-12">

                @forelse($sprints as $sprint)
                    <section>
                        {{-- Sprint Header --}}
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shadow-sm">
                                S{{ $loop->iteration }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">{{ $sprint->name }}</h3>
                                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                                    <i data-lucide="calendar" class="w-3 h-3 text-indigo-400"></i>
                                    {{ date('M d', strtotime($sprint->start_date)) }} —
                                    {{ date('M d, Y', strtotime($sprint->end_date)) }}
                                </div>
                            </div>
                            <div class="h-px flex-1 bg-slate-200 ml-4"></div>
                        </div>

                        {{-- Briefs Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($sprint->briefs as $brief)
                                @php
                                    // 1. Get Relationships (Filtered by Controller)
                                    $myLivrable = $brief->livrables->first();
                                    $myEvaluation = $brief->evaluations->first();

                                    // 2. Determine Status
                                    $status = 'todo';
                                    if ($myEvaluation) {
                                        $status = 'done';
                                    } elseif ($myLivrable) {
                                        $status = 'submitted';
                                    }

                                    // 3. Styling Logic
                                    $statusConfig = match ($status) {
                                        'done' => [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-700',
                                            'border' => 'border-emerald-100',
                                            'icon' => 'award',
                                            'label' => 'Validated',
                                        ],
                                        'submitted' => [
                                            'bg' => 'bg-amber-50',
                                            'text' => 'text-amber-700',
                                            'border' => 'border-amber-100',
                                            'icon' => 'hourglass',
                                            'label' => 'Under Review',
                                        ],
                                        default => [
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-600',
                                            'border' => 'border-slate-100',
                                            'icon' => 'code-2',
                                            'label' => 'In Progress',
                                        ],
                                    };
                                @endphp

                                <a href="/student/briefs/{{ $brief->id }}"
                                    class="group block bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:border-indigo-200 transition-all duration-300 flex flex-col h-full relative overflow-hidden">

                                    {{-- Hover Gradient --}}
                                    <div
                                        class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>

                                    <div class="p-6 flex-1">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-12 h-12 rounded-2xl {{ $statusConfig['bg'] }} border {{ $statusConfig['border'] }} flex items-center justify-center {{ $statusConfig['text'] }} transition-colors">
                                                <i data-lucide="{{ $statusConfig['icon'] }}" class="w-6 h-6"></i>
                                            </div>
                                            <span
                                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </div>

                                        <h4
                                            class="font-bold text-slate-800 text-lg mb-2 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                            {{ $brief->title }}
                                        </h4>
                                        <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                            {{ $brief->description }}
                                        </p>
                                    </div>

                                    <div
                                        class="px-6 py-4 border-t border-slate-50 bg-slate-50/30 flex items-center justify-between group-hover:bg-indigo-50/30 transition-colors">
                                        <div
                                            class="flex items-center gap-2 text-xs font-medium text-slate-400 group-hover:text-indigo-400 transition-colors">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            <span>Due {{ date('M d', strtotime($brief->date_remise)) }}</span>
                                        </div>
                                        <div
                                            class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-300 group-hover:text-indigo-600 group-hover:border-indigo-200 shadow-sm transition-all transform group-hover:translate-x-1">
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div
                                    class="col-span-full py-12 flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                                    <i data-lucide="folder-open" class="w-10 h-10 text-slate-300 mb-3"></i>
                                    <p class="text-sm font-medium text-slate-500">No projects assigned in this sprint yet.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                @empty
                    <div
                        class="flex flex-col items-center justify-center py-24 bg-white border border-slate-200 rounded-2xl border-dashed">
                        <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mb-6 shadow-sm">
                            <i data-lucide="coffee" class="w-10 h-10 text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No Projects Found</h3>
                        <p class="text-slate-500 mt-2 max-w-xs text-center">Check back later when your teacher assigns new
                            sprints to the class.</p>
                    </div>
                @endforelse

            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
