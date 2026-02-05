@extends('layout')

@section('title', 'My Dashboard - Student')

@section('content')
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Student Overview</h2>
                <p class="text-xs text-slate-500 mt-0.5">Track your progress and upcoming deadlines</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500 shadow-sm">
                    {{ date('F j, Y') }}
                </span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-7xl mx-auto space-y-10">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                            <i data-lucide="zap" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Briefs</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $active_briefs_count ?? 0 }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm">
                            <i data-lucide="check-circle-2" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Completed</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $completed_briefs_count ?? 0 }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm">
                            <i data-lucide="calendar" class="w-7 h-7"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Current Sprint</p>
                            <p class="text-lg font-bold text-slate-800 truncate mt-1"
                                title="{{ $current_sprint_name ?? 'N/A' }}">
                                {{ $current_sprint_name ?? 'No Active Sprint' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Your Curriculum</h3>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>

                    @forelse($sprints ?? [] as $sprintGroup)
                        @php
                            $sprint = $sprintGroup['sprint'];
                            $briefsList = $sprintGroup['briefs'];
                        @endphp

                        <div
                            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8 group/sprint hover:border-indigo-200 transition-colors">
                            <div
                                class="px-6 py-5 border-b border-slate-100 bg-white flex justify-between items-center sticky top-0 z-10">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shadow-sm">
                                        S{{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-lg">{{ $sprint->get_name() }}</h3>
                                        <div class="text-xs font-medium text-slate-500 mt-0.5 flex items-center gap-2">
                                            <i data-lucide="clock" class="w-3 h-3 text-indigo-400"></i>
                                            Ends {{ date('M d, Y', strtotime($sprint->get_end_date())) }}
                                        </div>
                                    </div>
                                </div>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                    {{ count($briefsList) }} Projects
                                </span>
                            </div>

                            <div class="divide-y divide-slate-50 bg-slate-50/30">
                                @forelse($briefsList as $briefGroup)
                                    @php
                                        $brief = $briefGroup['brief'];
                                        $briefCompetences = $briefGroup['competences'];

                                        $is_validated =
                                            property_exists($brief, 'review_status') &&
                                            !empty($brief->get_review_status());
                                        $is_submitted = $brief->get_repo_link();

                                        $status = 'todo';
                                        if ($is_validated) {
                                            $status = 'done';
                                        } elseif ($is_submitted) {
                                            $status = 'submitted';
                                        }
                                    @endphp

                                    <div
                                        class="p-6 hover:bg-white hover:shadow-[0_4px_15px_-3px_rgba(0,0,0,0.05)] transition-all flex flex-col md:flex-row md:items-center justify-between gap-6 group/item border-l-4 border-transparent hover:border-l-indigo-500">

                                        <div class="flex items-start gap-5 flex-1">
                                            <div
                                                class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center border shadow-sm transition-colors
                                                    {{ $status == 'done'
                                                        ? 'bg-emerald-50 border-emerald-100 text-emerald-600'
                                                        : ($status == 'submitted'
                                                            ? 'bg-amber-50 border-amber-100 text-amber-600'
                                                            : 'bg-white border-slate-200 text-slate-400') }}">
                                                <i data-lucide="{{ $status == 'done' ? 'check-check' : ($status == 'submitted' ? 'hourglass' : 'code-2') }}"
                                                    class="w-6 h-6"></i>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap items-center gap-3 mb-1">
                                                    <h4
                                                        class="text-base font-bold text-slate-800 group-hover/item:text-indigo-700 transition-colors">
                                                        {{ $brief->get_title() }}
                                                    </h4>

                                                    @if ($status == 'submitted')
                                                        <span
                                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                            Pending Review
                                                        </span>
                                                    @elseif($status == 'done')
                                                        <span
                                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                            <i data-lucide="award" class="w-3 h-3"></i> Validated
                                                            ({{ ucfirst($brief->review_status ?? 'Good') }})
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                            To Do
                                                        </span>
                                                    @endif

                                                    <span
                                                        class="text-[10px] font-bold text-slate-400 border border-slate-200 px-1.5 py-0.5 rounded bg-white uppercase">
                                                        {{ $brief->type ?? 'Individual' }}
                                                    </span>
                                                </div>

                                                <p class="text-sm text-slate-500 mb-3 line-clamp-2 leading-relaxed">
                                                    {{ $brief->get_description() }}
                                                </p>

                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($briefCompetences as $comp)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-mono font-bold bg-white text-slate-600 border border-slate-200 shadow-sm"
                                                            title="{{ $comp->get_libelle() }}">
                                                            {{ $comp->get_code() }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 md:self-center self-end">
                                            @if ($status == 'submitted' || $status == 'done')
                                                <a href="{{ $brief->get_repo_link() }}" target="_blank"
                                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-bold hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-sm group/btn">
                                                    <i data-lucide="github" class="w-4 h-4"></i> View Code
                                                    <i data-lucide="external-link"
                                                        class="w-3 h-3 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                                                </a>
                                            @else
                                                <button
                                                    onclick="openSubmitModal({{ $brief->get_id() }}, '{{ addslashes($brief->get_title()) }}')"
                                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                                    <i data-lucide="send" class="w-4 h-4"></i> Submit Work
                                                </button>
                                            @endif
                                        </div>

                                    </div>
                                @empty
                                    <div class="py-12 flex flex-col items-center justify-center text-center">
                                        <div
                                            class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                            <i data-lucide="coffee" class="w-6 h-6 text-slate-300"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-500">No briefs assigned.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="py-24 text-center bg-white rounded-2xl border border-slate-200 border-dashed">
                            <div
                                class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                                <i data-lucide="layers" class="w-10 h-10 text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">All caught up!</h3>
                            <p class="text-slate-500 mt-2">No active sprints are currently assigned to your class.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </main>
    </div>
    </div>

    <div id="submitModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeSubmitModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div
                class="pointer-events-auto relative w-full max-w-md bg-white rounded-2xl shadow-2xl ring-1 ring-slate-900/5 overflow-hidden">

                <form action="/student/brief/submit" method="POST">
                    <input type="hidden" name="brief_id" id="submit_brief_id">

                    <div class="bg-slate-50 border-b border-slate-100 p-6 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-200">
                            <i data-lucide="github" class="h-6 w-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 leading-none">Submit Project</h3>
                            <p class="text-xs font-medium text-slate-500 mt-1 truncate max-w-[200px]"
                                id="submit_brief_title">Brief Title</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">
                                GitHub Repository URL <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="link"
                                        class="h-4 w-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="url" name="repo_link" required
                                    placeholder="https://github.com/username/repo"
                                    class="pl-10 w-full rounded-xl border-slate-200 bg-slate-50 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">
                                Comments (Optional)
                            </label>
                            <div class="relative group">
                                <textarea name="comment" rows="3" maxlength="255" placeholder="Add any notes about your submission..."
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all resize-none"></textarea>
                                <div class="absolute bottom-3 right-3 pointer-events-none">
                                    <i data-lucide="message-square" class="h-4 w-4 text-slate-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="closeSubmitModal()"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-200 hover:bg-indigo-700 transition-colors">
                            Submit Project
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <script>
            lucide.createIcons();

            function openSubmitModal(briefId, briefTitle) {
                document.getElementById('submit_brief_id').value = briefId;
                document.getElementById('submit_brief_title').textContent = briefTitle;
                document.getElementById('submitModal').classList.remove('hidden');
            }

            function closeSubmitModal() {
                document.getElementById('submitModal').classList.add('hidden');
            }
        </script>
    @endsection
