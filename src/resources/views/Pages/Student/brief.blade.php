@extends('layout')

@section('title', $brief['brief']->get_title() . ' - Project Details')

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
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="folder-git-2" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">My Projects</span>
                </a>

                <a href="/student/evaluations"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="clipboard-check"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-emerald-500 transition-colors"></i>
                    <span class="font-medium text-sm">My Evaluations</span>
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

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
                <div class="flex items-center gap-6">
                    <a href="/student/briefs"
                        class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-xl transition-all shadow-sm group">
                        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform"></i>
                    </a>

                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ $brief['brief']->get_title() }}</h2>
                        <div class="flex items-center gap-3 text-xs mt-1">
                            <span
                                class="font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">{{ $sprint->get_name() }}</span>
                            <span class="text-slate-400 flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                Due: {{ date('M d, Y', strtotime($brief['brief']->get_date_remise())) }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-8">

                        <div
                            class="bg-white rounded-2xl border border-slate-200 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-6 opacity-5">
                                <i data-lucide="file-code" class="w-32 h-32"></i>
                            </div>

                            <h3
                                class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-6 h-0.5 bg-indigo-500 rounded-full"></span> Context
                            </h3>

                            <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                                {!! nl2br($brief['brief']->get_description()) !!}
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-4 px-1">
                                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                    <i data-lucide="target" class="w-4 h-4 text-indigo-500"></i> Target Competencies
                                </h3>
                                <span
                                    class="text-xs bg-white border border-slate-200 px-2.5 py-1 rounded-full text-slate-500 font-bold shadow-sm">
                                    {{ count($brief['competences']) }} Skills
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($brief['competences'] as $comp)
                                    <div
                                        class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shadow-sm group-hover:scale-110 transition-transform">
                                                    {{ $comp->get_code() }}
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-1">
                                                        {{ $comp->get_libelle() }}</h4>
                                                    <p class="text-[10px] text-slate-400">Technical Skill</p>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase">Level</span>
                                                <span
                                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                                    {{ $comp->get_level() ?? '1' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="col-span-full p-8 text-center bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                                        <i data-lucide="shield-alert" class="w-6 h-6 mx-auto mb-2 opacity-50"></i>
                                        <span class="text-sm">No specific competencies listed.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="sticky top-24">

                            @php
                                $status = 'todo';
                                if ($brief['brief']->get_review_status()) {
                                    $status = 'done';
                                } elseif ($brief['brief']->get_repo_link()) {
                                    $status = 'submitted';
                                }
                            @endphp

                            @if ($status == 'done')
                                <div
                                    class="bg-white rounded-2xl border border-emerald-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                                    <div
                                        class="bg-gradient-to-b from-emerald-50 to-white p-8 text-center border-b border-emerald-50">
                                        <div class="relative inline-block mb-4">
                                            <div class="absolute inset-0 bg-emerald-200 rounded-full blur-xl opacity-50">
                                            </div>
                                            <div
                                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center relative shadow-sm border-4 border-emerald-50">
                                                <i data-lucide="check-check" class="w-10 h-10 text-emerald-500"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-2xl font-bold text-emerald-800 tracking-tight">Evaluated</h4>
                                        <div
                                            class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wide border border-emerald-200">
                                            Status: {{ $brief['brief']->get_review_status() }}
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 relative">
                                            <i data-lucide="quote"
                                                class="w-5 h-5 text-slate-300 absolute top-3 right-3"></i>
                                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Teacher Feedback</p>
                                            <p class="text-sm text-slate-600 italic leading-relaxed">
                                                "Check your full evaluation report for detailed competency breakdown and
                                                comments."
                                            </p>
                                        </div>
                                        <a href="/student/evaluations"
                                            class="mt-4 flex items-center justify-center gap-2 w-full py-3 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                                            View Full Report <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>
                            @elseif($status == 'submitted')
                                <div
                                    class="bg-white rounded-2xl border border-amber-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                                    <div
                                        class="bg-gradient-to-b from-amber-50 to-white p-8 text-center border-b border-amber-50">
                                        <div class="relative inline-block mb-4">
                                            <div class="absolute inset-0 bg-amber-200 rounded-full blur-xl opacity-50">
                                            </div>
                                            <div
                                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center relative shadow-sm border-4 border-amber-50">
                                                <i data-lucide="hourglass"
                                                    class="w-10 h-10 text-amber-500 animate-pulse"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-2xl font-bold text-slate-800 tracking-tight">Pending Review</h4>
                                        <p class="text-sm text-slate-500 mt-1">Submitted on {{ date('M d') }}</p>
                                    </div>

                                    <div class="p-6">
                                        <div
                                            class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm group hover:border-indigo-300 transition-colors">
                                            <label
                                                class="text-[10px] font-bold text-slate-400 uppercase block mb-2">Repository
                                                Link</label>
                                            <a href="{{ $brief['brief']->get_repo_link() }}" target="_blank"
                                                class="flex items-center gap-3 text-indigo-600">
                                                <div class="p-1.5 bg-indigo-50 rounded text-indigo-600">
                                                    <i data-lucide="github" class="w-4 h-4"></i>
                                                </div>
                                                <span
                                                    class="text-sm font-bold truncate underline decoration-indigo-200 hover:decoration-indigo-500 transition-all">
                                                    {{ $brief['brief']->get_repo_link() }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <p class="text-xs text-slate-400">You can no longer edit this submission.</p>
                                        </div>
                                    </div>
                                </div>
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
                                        <p class="text-xs text-slate-500 pl-1">Ready to deliver? Paste your GitHub
                                            repository below.</p>
                                    </div>

                                    <form action="/student/brief/submit" method="POST" class="p-6 space-y-5">
                                        <input type="hidden" name="brief_id" value="{{ $brief['brief']->get_id() }}">

                                        <div>
                                            <label
                                                class="block text-xs font-bold uppercase text-slate-500 mb-1.5 ml-1">GitHub
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
    </div>
    <script>
        lucide.createIcons();
    </script>
@endsection
