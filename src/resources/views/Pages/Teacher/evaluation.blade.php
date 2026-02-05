@extends('layout')

@section('title', 'All Submissions')

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
                        <button type="submit" class="text-slate-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded-lg transition-all"
                            title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">
            
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Submissions Dashboard</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Review student code and assign grades</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500 shadow-sm">
                        Academic Year 2025-2026
                    </span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
                <div class="max-w-7xl mx-auto space-y-10">

                    @forelse($sprints as $sprintDTO)
                        <div class="space-y-6">
                            
                            <div class="flex items-end justify-between px-2">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                                            {{ $sprintDTO->sprint->get_name() }}
                                        </h2>
                                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mt-0.5">
                                            <i data-lucide="calendar" class="w-3 h-3 text-indigo-400"></i>
                                            {{ date('M d', strtotime($sprintDTO->sprint->get_start_date())) }} — {{ date('M d, Y', strtotime($sprintDTO->sprint->get_end_date())) }}
                                        </div>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold border border-slate-200">
                                    {{ count($sprintDTO->briefs) }} Projects
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-8">
                                @foreach ($sprintDTO->briefs as $briefDTO)
                                    <div class="bg-white border border-slate-200 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden transition-all hover:border-indigo-200">

                                        <div class="px-6 py-5 bg-white border-b border-slate-100 flex justify-between items-center">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm">
                                                    <i data-lucide="folder-git-2" class="w-6 h-6"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-slate-800 text-lg">
                                                        {{ $briefDTO->brief->get_title() }}
                                                    </h3>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                                            <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                                            Due: {{ date('M d', strtotime($briefDTO->brief->get_date_remise())) }}
                                                        </span>
                                                        <span class="text-xs text-slate-400">•</span>
                                                        <span class="text-xs text-slate-500 font-medium">{{ count($briefDTO->students) }} Assigned</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm text-slate-600">
                                                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-400 border-b border-slate-100">
                                                    <tr>
                                                        <th class="px-6 py-4 pl-8">Student Identity</th>
                                                        <th class="px-6 py-4">Status</th>
                                                        <th class="px-6 py-4">Repository</th>
                                                        <th class="px-6 py-4 text-right pr-8">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="divide-y divide-slate-50">
                                                    @foreach ($briefDTO->students as $studentDTO)
                                                        <tr class="hover:bg-indigo-50/30 transition-colors group">

                                                            <td class="px-6 py-4 pl-8">
                                                                <div class="flex items-center gap-3">
                                                                    <div class="h-9 w-9 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0 shadow-sm group-hover:border-indigo-200 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                                                        {{ substr($studentDTO->student->get_first_name(), 0, 1) }}{{ substr($studentDTO->student->get_last_name(), 0, 1) }}
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-bold text-slate-800">
                                                                            {{ $studentDTO->student->get_first_name() }}
                                                                            {{ $studentDTO->student->get_last_name() }}
                                                                        </div>
                                                                        <div class="text-[10px] text-slate-400 font-medium">
                                                                            {{ $studentDTO->student->get_email() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="px-6 py-4">
                                                                @if ($studentDTO->review_status)
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                                                        Validated
                                                                    </span>
                                                                @elseif ($studentDTO->livrable)
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">
                                                                        <i data-lucide="loader" class="w-3.5 h-3.5"></i>
                                                                        Pending
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                                        <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                                                        Missing
                                                                    </span>
                                                                @endif
                                                            </td>

                                                            <td class="px-6 py-4">
                                                                @if ($studentDTO->livrable)
                                                                    <div class="flex flex-col items-start gap-1">
                                                                        <a href="{{ $studentDTO->livrable->get_url() }}"
                                                                            target="_blank"
                                                                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-sm">
                                                                            <i data-lucide="github" class="w-3.5 h-3.5"></i>
                                                                            View Code
                                                                        </a>
                                                                        <span class="text-[10px] text-slate-400 pl-1">
                                                                            Sent: {{ date('M d, H:i', strtotime($studentDTO->livrable->get_date_submitted())) }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <span class="text-slate-400 text-xs italic flex items-center gap-1 opacity-50">
                                                                        <i data-lucide="minus" class="w-3 h-3"></i> No submission
                                                                    </span>
                                                                @endif
                                                            </td>

                                                            <td class="px-6 py-4 text-right pr-8">
                                                                @if (!$studentDTO->review_status && $studentDTO->livrable)
                                                                    <a href="/teacher/evaluate/{{ $briefDTO->brief->get_id() }}/student/{{ $studentDTO->student->get_id() }}"
                                                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                                                        <i data-lucide="pen-tool" class="w-3 h-3 mr-2"></i>
                                                                        Evaluate
                                                                    </a>
                                                                @elseif($studentDTO->review_status)
                                                                    <a href="/teacher/evaluate/{{ $briefDTO->brief->get_id() }}/student/{{ $studentDTO->student->get_id() }}" 
                                                                       class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-200 text-slate-400 text-xs font-bold rounded-lg hover:text-indigo-600 hover:border-indigo-200 transition-colors">
                                                                        <i data-lucide="eye" class="w-3 h-3 mr-2"></i> Reviewed
                                                                    </a>
                                                                @else
                                                                    <button disabled
                                                                        class="inline-flex items-center justify-center px-4 py-2 bg-slate-50 border border-slate-200 text-slate-300 text-xs font-bold rounded-lg cursor-not-allowed">
                                                                        Waiting...
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-24 bg-white border border-slate-200 rounded-2xl shadow-sm border-dashed">
                            <div class="p-6 bg-slate-50 rounded-full mb-4">
                                <i data-lucide="layers" class="w-10 h-10 text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">No Projects Found</h3>
                            <p class="text-slate-500 text-sm mt-1 max-w-sm text-center">There are no sprints or briefs assigned to this class yet. Start by creating a Sprint in the Briefs section.</p>
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