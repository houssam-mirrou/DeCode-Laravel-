@extends('layout')

@section('title', 'My Evaluations')

@section('content')
    <div class="flex h-screen bg-slate-50 overflow-hidden font-sans">

        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-20 shadow-sm">
            <div class="h-20 flex items-center px-8 border-b border-slate-100">
                <h1 class="text-xl font-bold text-indigo-600 tracking-wide">DECODE <span
                        class="text-xs text-slate-400 font-bold ml-1 uppercase">Student</span></h1>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2">
                <a href="/student/dashboard"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="layout-dashboard"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <a href="/student/briefs"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="folder-git-2"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">My Projects</span>
                </a>

                <a href="/student/evaluations"
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="clipboard-check" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">My Evaluations</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                    <div
                        class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-700 font-bold text-sm shadow-sm">
                        {{ substr($current_user->get_first_name() ?? 'S', 0, 1) . substr($current_user->get_last_name() ?? 'S', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">
                            {{ $current_user->get_first_name() . ' ' . $current_user->get_last_name() ?? 'Student' }}
                        </p>
                        <p class="text-[10px] text-slate-400 truncate uppercase tracking-wide font-semibold">Web Development
                        </p>
                    </div>
                    <form action="/logout" method="POST">
                        <button type="submit"
                            class="text-slate-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded-lg transition-all"
                            title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

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
                        Total Evaluated: {{ count($evaluations) }}
                    </span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
                <div class="max-w-5xl mx-auto space-y-8">

                    @forelse($evaluations as $eval)
                        <div
                            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:shadow-lg hover:border-indigo-200 transition-all duration-300">

                            <div
                                class="px-8 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                        <i data-lucide="file-check" class="w-5 h-5 text-indigo-500"></i>
                                        {{ $eval->briefTitle }}
                                    </h2>
                                    <div class="flex items-center gap-2 text-xs text-slate-500 mt-1">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        <span>Graded on {{ date('M d, Y', strtotime($eval->gradedDate)) }}</span>
                                    </div>
                                </div>

                                <span
                                    class="px-4 py-1.5 rounded-full text-xs font-bold border uppercase tracking-wide shadow-sm {{ $eval->getStatusColor() }}">
                                    {{ $eval->status }}
                                </span>
                            </div>

                            <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-10">

                                <div class="lg:col-span-1">
                                    <h3
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <i data-lucide="message-square" class="w-3 h-3"></i> Feedback
                                    </h3>

                                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 relative group">
                                        <i data-lucide="quote"
                                            class="w-8 h-8 text-indigo-100 absolute -top-3 -left-2 fill-indigo-50"></i>
                                        <p class="text-sm text-slate-600 italic leading-relaxed relative z-10">
                                            "{{ $eval->teacherComment ?? 'No additional comments provided.' }}"
                                        </p>
                                        <div class="mt-4 flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                                                TC</div>
                                            <span class="text-xs font-bold text-slate-400">Teacher</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:col-span-2">
                                    <h3
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <i data-lucide="bar-chart-2" class="w-3 h-3"></i> Competency Breakdown
                                    </h3>

                                    @if (count($eval->skills) > 0)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach ($eval->skills as $skill)
                                                <div
                                                    class="flex items-center justify-between p-3.5 border border-slate-100 rounded-xl bg-white shadow-[0_2px_8px_-2px_rgba(0,0,0,0.02)] hover:border-indigo-100 hover:shadow-md transition-all group">
                                                    <div class="flex items-center gap-3 overflow-hidden">
                                                        <div
                                                            class="w-1.5 h-8 rounded-full bg-slate-200 group-hover:bg-indigo-500 transition-colors">
                                                        </div>
                                                        <span class="text-sm font-bold text-slate-700 truncate"
                                                            title="{{ $skill['name'] }}">
                                                            {{ $skill['name'] }}
                                                        </span>
                                                    </div>

                                                    @php
                                                        $lvlColor = match ($skill['level']) {
                                                            'TRANSPOSER'
                                                                => 'text-purple-700 bg-purple-50 border-purple-100 ring-purple-500/20',
                                                            'S_ADAPTER'
                                                                => 'text-indigo-700 bg-indigo-50 border-indigo-100 ring-indigo-500/20',
                                                            'IMITER'
                                                                => 'text-slate-600 bg-slate-100 border-slate-200 ring-slate-500/20',
                                                            default => 'text-gray-500',
                                                        };
                                                        $lvlText = ucfirst(
                                                            strtolower(str_replace(['S_', '_'], '', $skill['level'])),
                                                        );
                                                    @endphp

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
    </div>
    <script>
        lucide.createIcons();
    </script>
@endsection
