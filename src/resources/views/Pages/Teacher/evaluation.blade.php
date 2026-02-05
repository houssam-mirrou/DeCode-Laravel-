@extends('layout')

@section('title', 'Evaluation Dashboard')

@section('content')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Evaluations</h2>
                <p class="text-xs text-slate-500 mt-0.5">Review submissions and grade competencies</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500 shadow-sm">
                    {{ $students->count() }} Students
                </span>
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

                        {{-- Briefs Loop --}}
                        <div class="space-y-8">
                            @foreach ($sprint->briefs as $brief)
                                <div
                                    class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:border-indigo-200 transition-colors">

                                    {{-- Brief Info Bar --}}
                                    <div
                                        class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-white border border-slate-200 rounded-lg text-indigo-600">
                                                <i data-lucide="file-code" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800">{{ $brief->title }}</h4>
                                                <div class="flex items-center gap-3 mt-0.5">
                                                    <span class="text-xs text-slate-500">Deadline:
                                                        {{ date('M d, H:i', strtotime($brief->date_remise)) }}</span>

                                                    {{-- Quick Stats --}}
                                                    @php
                                                        $submittedCount = $brief->livrables->count();
                                                        $evaluatedCount = $brief->evaluations->count();
                                                    @endphp
                                                    <span
                                                        class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-100">
                                                        {{ $evaluatedCount }} / {{ $students->count() }} Graded
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Student Table --}}
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left text-sm text-slate-600">
                                            <thead
                                                class="bg-white text-xs uppercase font-bold text-slate-400 border-b border-slate-100">
                                                <tr>
                                                    <th class="px-6 py-3 pl-8 w-1/3">Student</th>
                                                    <th class="px-6 py-3">Status</th>
                                                    <th class="px-6 py-3">Submission</th>
                                                    <th class="px-6 py-3 text-right pr-8">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-50">
                                                @foreach ($students as $student)
                                                    @php
                                                        // Find relationships specifically for this student
                                                        $livrable = $brief->livrables
                                                            ->where('student_id', $student->id)
                                                            ->first();
                                                        $evaluation = $brief->evaluations
                                                            ->where('student_id', $student->id)
                                                            ->first();
                                                    @endphp

                                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                                        {{-- Student Name --}}
                                                        <td class="px-6 py-4 pl-8">
                                                            <div class="flex items-center gap-3">
                                                                <div
                                                                    class="h-8 w-8 rounded-full bg-slate-100 border border-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">
                                                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <div class="font-bold text-slate-700">
                                                                        {{ $student->first_name }}
                                                                        {{ $student->last_name }}</div>
                                                                    <div class="text-[10px] text-slate-400">
                                                                        {{ $student->email }}</div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        {{-- Status --}}
                                                        <td class="px-6 py-4">
                                                            @if ($evaluation)
                                                                <span
                                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                                    <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                                                                    Evaluated
                                                                </span>
                                                            @elseif($livrable)
                                                                <span
                                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">
                                                                    <i data-lucide="loader" class="w-3.5 h-3.5"></i> To
                                                                    Review
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i> Pending
                                                                </span>
                                                            @endif
                                                        </td>

                                                        {{-- Submission Link --}}
                                                        <td class="px-6 py-4">
                                                            @if ($livrable)
                                                                <div class="flex flex-col items-start gap-1">
                                                                    <a href="{{ $livrable->url }}" target="_blank"
                                                                        class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 hover:underline text-xs font-bold transition-all">
                                                                        <i data-lucide="github" class="w-3.5 h-3.5"></i>
                                                                        View Repo
                                                                    </a>
                                                                    <span class="text-[10px] text-slate-400">
                                                                        {{ date('M d, H:i', strtotime($livrable->date_submitted)) }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <span class="text-slate-300 text-xs italic">No link</span>
                                                            @endif
                                                        </td>

                                                        {{-- Action Button --}}
                                                        <td class="px-6 py-4 text-right pr-8">
                                                            @if ($evaluation)
                                                                {{-- View Existing --}}
                                                                <a href="{{ route('evaluation.show', $evaluation->id) }}"
                                                                    class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-200 text-slate-500 text-xs font-bold rounded-lg hover:border-indigo-300 hover:text-indigo-600 transition-all">
                                                                    View
                                                                </a>
                                                            @elseif($livrable)
                                                                {{-- Create New (Pass Brief + Student IDs) --}}
                                                                {{-- Ensure you have the custom route defined as discussed before --}}
                                                                <a href="{{ route('evaluation.create_custom', ['brief' => $brief->id, 'student' => $student->id]) }}"
                                                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg shadow-sm shadow-indigo-200 hover:bg-indigo-700 hover:shadow-md transition-all transform hover:-translate-y-0.5">
                                                                    Evaluate
                                                                </a>
                                                            @else
                                                                <button disabled
                                                                    class="opacity-50 cursor-not-allowed inline-flex items-center px-3 py-1.5 bg-slate-50 border border-slate-200 text-slate-300 text-xs font-bold rounded-lg">
                                                                    Evaluate
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
                    </section>
                @empty
                    <div class="py-24 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                        <i data-lucide="layers" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                        <h3 class="text-lg font-bold text-slate-800">No Sprints Found</h3>
                        <p class="text-slate-500 text-sm">Create a sprint to start tracking evaluations.</p>
                    </div>
                @endforelse

            </div>
        </main>
    </div>
    <script>
        lucide.createIcons();
    </script>
@endsection
