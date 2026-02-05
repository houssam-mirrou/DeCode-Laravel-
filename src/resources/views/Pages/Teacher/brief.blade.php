@extends('layout')

@section('title', 'My Briefs - Decode')

@section('content')

    {{-- SIDEBAR WOULD GO HERE --}}

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-0">

        {{-- HEADER --}}
        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Briefs & Curriculum</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manage sprints and assign projects</p>
            </div>
            <button onclick="openBriefModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-4 h-4"></i> Create Brief
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
            <div class="max-w-6xl mx-auto space-y-8">

                {{-- ALERTS --}}
                @if (session('success'))
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        <ul class="list-disc pl-5 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- SPRINTS LOOP --}}
                @forelse($sprints as $sprint)

                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group/sprint hover:border-indigo-200 transition-colors">

                        {{-- Sprint Header --}}
                        <div
                            class="px-6 py-5 border-b border-slate-100 bg-white flex justify-between items-center sticky top-0 z-10">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shadow-sm">
                                    S{{ $loop->iteration }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">{{ $sprint->name }}</h3>
                                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mt-0.5">
                                        <div
                                            class="flex items-center gap-1 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                            <i data-lucide="calendar" class="w-3 h-3 text-indigo-500"></i>
                                            <span>{{ date('M d', strtotime($sprint->start_date)) }} —
                                                {{ date('M d', strtotime($sprint->end_date)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button onclick="openBriefModal({{ $sprint->id }})"
                                class="text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-lg hover:bg-indigo-100 hover:border-indigo-200 transition-all">
                                + Add Brief
                            </button>
                        </div>

                        {{-- Briefs List --}}
                        <div class="divide-y divide-slate-50 bg-slate-50/30">
                            {{-- Loop through the relationship directly --}}
                            @forelse($sprint->briefs as $brief)
                                @php
                                    // Access Pivot Data
                                    $briefCompetences = $brief->competences;

                                    // Map Levels for JS (DB String -> Form Int)
                                    $levelMap = ['IMITER' => 1, 'S_ADAPTER' => 2, 'TRANSPOSER' => 3];

                                    $compData = $briefCompetences
                                        ->map(function ($c) use ($levelMap) {
                                            $dbLevel = $c->pivot->level ?? 'IMITER';
                                            return [
                                                'id' => $c->id,
                                                'level' => $levelMap[$dbLevel] ?? 1,
                                            ];
                                        })
                                        ->toJson();
                                @endphp

                                <div
                                    class="p-5 hover:bg-white hover:shadow-sm transition-all flex items-center justify-between group/brief border-l-4 border-transparent hover:border-l-indigo-500">
                                    <div class="flex items-center gap-5">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover/brief:text-indigo-600 group-hover/brief:border-indigo-100 transition-colors shadow-sm">
                                            <i data-lucide="file-code" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4
                                                class="text-sm font-bold text-slate-800 group-hover/brief:text-indigo-700 transition-colors">
                                                {{ $brief->title }}
                                            </h4>

                                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                                {{-- Competencies Tags --}}
                                                @if ($briefCompetences->count() > 0)
                                                    <div class="flex gap-1.5">
                                                        @foreach ($briefCompetences as $comp)
                                                            <span
                                                                class="inline-flex items-center px-1.5 py-0.5 rounded-md border border-slate-200 bg-white text-[10px] font-mono text-slate-600 shadow-sm"
                                                                title="{{ $comp->libelle }}">
                                                                {{ $comp->code }}
                                                                {{-- Display Pivot Level --}}
                                                                <span
                                                                    class="ml-1 text-indigo-600 font-bold bg-indigo-50 px-1 rounded">
                                                                    {{ $comp->pivot->level ?? 'N/A' }}
                                                                </span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div
                                        class="flex items-center gap-2 opacity-0 group-hover/brief:opacity-100 transition-opacity">
                                        <div
                                            class="flex bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                                            <button onclick="openEditBriefModal(this)" data-id="{{ $brief->id }}"
                                                data-title="{{ $brief->title }}"
                                                data-description="{{ $brief->description }}"
                                                data-date="{{ $brief->date_remise }}" data-type="{{ $brief->type }}"
                                                data-sprint="{{ $sprint->id }}" data-competences="{{ $compData }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors border-r border-slate-100"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>

                                            <button
                                                onclick="openDeleteBriefModal({{ $brief->id }}, '{{ addslashes($brief->title) }}')"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 flex flex-col items-center justify-center text-center">
                                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i data-lucide="clipboard" class="w-6 h-6 text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500">No briefs in this sprint yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="bg-slate-50 p-6 rounded-full mb-6 border border-slate-100 shadow-sm">
                            <i data-lucide="layers" class="w-12 h-12 text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No Sprints Found</h3>
                        <p class="text-slate-500 mt-2 max-w-sm text-sm">Wait for an admin to define the pedagogical
                            structure.</p>
                    </div>
                @endforelse

            </div>
        </main>
    </div>
    </div>

    {{-- MODALS --}}

    {{-- 1. Create Modal --}}
    <div id="briefModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeBriefModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div
                class="pointer-events-auto relative w-full max-w-2xl max-h-[90vh] flex flex-col bg-white rounded-2xl shadow-2xl ring-1 ring-slate-900/5">

                <form action="/teacher/briefs" method="POST" class="flex flex-col h-full min-h-0">
                    @csrf
                    <div
                        class="flex-none flex items-center justify-between border-b border-slate-100 px-8 py-5 bg-white rounded-t-2xl">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 shadow-sm">
                                <i data-lucide="file-plus" class="h-6 w-6"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 leading-none">Create New Brief</h3>
                                <p class="text-xs font-medium text-slate-500 mt-1.5">Define scope, timeline & skills</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeBriefModal()"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-colors">
                            <i data-lucide="x" class="h-5 w-5"></i>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50 min-h-0">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Brief
                                    Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required
                                    placeholder="e.g. MVC Framework Implementation"
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all">
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Target
                                    Sprint <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="sprint_id" id="modal_sprint_select" required
                                        class="w-full appearance-none rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all">
                                        <option disabled selected>-- Select Sprint --</option>
                                        @foreach ($sprints as $sprint)
                                            <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
                                        @endforeach
                                    </select>
                                    <i data-lucide="chevron-down"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Type
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="type" required
                                        class="w-full appearance-none rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all">
                                        <option value="individuel">Individual Project</option>
                                        <option value="collectif">Group Project</option>
                                    </select>
                                    <i data-lucide="chevron-down"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Deadline
                                    <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="date_remise" required
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all text-slate-600">
                            </div>

                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Description
                                    <span class="text-red-500">*</span></label>
                                <textarea name="description" rows="3" required placeholder="Enter brief requirements..."
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        {{-- Competencies --}}
                        <div class="mt-8 mb-4 flex items-center gap-4">
                            <span class="h-px flex-1 bg-slate-200"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Map
                                Competencies</span>
                            <span class="h-px flex-1 bg-slate-200"></span>
                        </div>

                        <div class="space-y-3 pb-4">
                            @forelse ($competences ?? [] as $comp)
                                <div
                                    class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-indigo-300 hover:shadow-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/10">
                                    <div class="flex items-start gap-4">
                                        <div class="flex h-6 items-center">
                                            <input type="checkbox" id="comp_{{ $comp->id }}"
                                                name="competences[{{ $comp->id }}][checked]"
                                                class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                                onchange="toggleLevelSelect({{ $comp->id }})">
                                        </div>
                                        <div class="flex-1">
                                            <label for="comp_{{ $comp->id }}" class="cursor-pointer select-none">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="inline-flex items-center rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-xs font-mono font-bold text-slate-600">{{ $comp->code }}</span>
                                                    <span
                                                        class="text-sm font-bold text-slate-800">{{ $comp->libelle }}</span>
                                                </div>
                                            </label>

                                            <div id="level_select_{{ $comp->id }}"
                                                class="hidden mt-4 pl-1 animate-in slide-in-from-top-2 duration-200 fade-in">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ([1 => 'Imitation', 2 => 'Adaptation', 3 => 'Transposition'] as $lvl => $lbl)
                                                        <label class="cursor-pointer group/lvl">
                                                            <input type="radio"
                                                                name="competences[{{ $comp->id }}][level]"
                                                                value="{{ $lvl }}" class="peer sr-only"
                                                                {{ $lvl == 2 ? 'checked' : '' }}>
                                                            <div
                                                                class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-500 shadow-sm transition-all hover:border-indigo-400 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-md">
                                                                L{{ $lvl }} - {{ $lbl }}
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-sm text-slate-500">No competencies available.</div>
                            @endforelse
                        </div>
                    </div>

                    <div
                        class="flex-none border-t border-slate-100 bg-white px-8 py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl z-20">
                        <button type="button" onclick="closeBriefModal()"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-200 hover:bg-indigo-700">Publish
                            Brief</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. Edit Modal --}}
    <div id="editBriefModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditBriefModal()">
        </div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div
                class="pointer-events-auto relative w-full max-w-2xl max-h-[90vh] flex flex-col bg-white rounded-2xl shadow-2xl ring-1 ring-slate-900/5">

                <form id="editForm" action="" method="POST" class="flex flex-col h-full min-h-0">
                    @csrf
                    @method('PUT')

                    <div
                        class="flex-none flex items-center justify-between border-b border-slate-100 px-8 py-5 bg-white rounded-t-2xl">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100 shadow-sm">
                                <i data-lucide="pencil" class="h-6 w-6"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 leading-none">Edit Brief</h3>
                                <p class="text-xs font-medium text-slate-500 mt-1.5">Update details & competencies</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeEditBriefModal()"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-50 hover:text-slate-600">
                            <i data-lucide="x" class="h-5 w-5"></i>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50 min-h-0">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Brief
                                    Title</label>
                                <input type="text" name="title" id="edit_title" required
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all">
                            </div>
                            <div>
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Sprint</label>
                                <div class="relative">
                                    <select name="sprint_id" id="edit_sprint_id" required
                                        class="w-full appearance-none rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all">
                                        @foreach ($sprints as $sprint)
                                            <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
                                        @endforeach
                                    </select>
                                    <i data-lucide="chevron-down"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Type</label>
                                <div class="relative">
                                    <select name="type" id="edit_type" required
                                        class="w-full appearance-none rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all">
                                        <option value="individuel">Individual Project</option>
                                        <option value="collectif">Group Project</option>
                                    </select>
                                    <i data-lucide="chevron-down"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Deadline</label>
                                <input type="datetime-local" name="date_remise" id="edit_date_remise" required
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-600">
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Description</label>
                                <textarea name="description" id="edit_description" rows="3" required
                                    class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        {{-- Edit Competencies --}}
                        <div class="mt-8 mb-4 flex items-center gap-4">
                            <span class="h-px flex-1 bg-slate-200"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Update
                                Competencies</span>
                            <span class="h-px flex-1 bg-slate-200"></span>
                        </div>

                        <div class="space-y-3 pb-4">
                            @forelse ($competences ?? [] as $comp)
                                <div
                                    class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-blue-300 hover:shadow-md has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/10">
                                    <div class="flex items-start gap-4">
                                        <div class="flex h-6 items-center">
                                            <input type="checkbox" id="edit_comp_{{ $comp->id }}"
                                                name="competences[{{ $comp->id }}][checked]"
                                                class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                                onchange="toggleEditLevelSelect({{ $comp->id }})">
                                        </div>
                                        <div class="flex-1">
                                            <label for="edit_comp_{{ $comp->id }}"
                                                class="cursor-pointer select-none">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="inline-flex items-center rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-xs font-mono font-bold text-slate-600">{{ $comp->code }}</span>
                                                    <span
                                                        class="text-sm font-bold text-slate-800">{{ $comp->libelle }}</span>
                                                </div>
                                            </label>
                                            <div id="edit_level_select_{{ $comp->id }}" class="hidden mt-4 pl-1">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ([1 => 'Imitation', 2 => 'Adaptation', 3 => 'Transposition'] as $val => $label)
                                                        <label class="cursor-pointer">
                                                            <input type="radio"
                                                                id="edit_lvl_{{ $comp->id }}_{{ $val }}"
                                                                name="competences[{{ $comp->id }}][level]"
                                                                value="{{ $val }}" class="peer sr-only"
                                                                {{ $val === 2 ? 'checked' : '' }}>
                                                            <div
                                                                class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-500 shadow-sm transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white">
                                                                L{{ $val }} - {{ $label }}
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 text-center">No competencies found.</p>
                            @endforelse
                        </div>
                    </div>

                    <div
                        class="flex-none border-t border-slate-100 bg-white px-8 py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                        <button type="button" onclick="closeEditBriefModal()"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-200 hover:bg-blue-700">Update
                            Brief</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 3. Delete Modal --}}
    <div id="deleteBriefModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteBriefModal()">
        </div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div
                class="pointer-events-auto relative w-full max-w-md bg-white rounded-2xl shadow-2xl ring-1 ring-slate-900/5">
                <div class="p-8">
                    <div
                        class="flex items-center justify-center w-14 h-14 mx-auto bg-red-50 border border-red-100 rounded-full shadow-sm mb-6">
                        <i data-lucide="alert-triangle" class="w-7 h-7 text-red-600"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-slate-900">Delete Brief?</h3>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            Are you sure you want to delete <span id="delete_brief_title"
                                class="font-bold text-slate-800 bg-slate-50 px-1 rounded">this brief</span>? This action is
                            permanent and cannot be undone.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col-reverse gap-3 px-8 pb-8 sm:flex-row sm:justify-center">
                    <button type="button" onclick="closeDeleteBriefModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">Cancel</button>

                    {{-- Dynamic Action via JS --}}
                    <form id="deleteForm" action="" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl bg-red-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-red-200 hover:bg-red-700 transition-colors">Yes,
                            Delete It</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            lucide.createIcons();

            // --- Modals Toggles ---
            function openBriefModal(sprintId = null) {
                if (sprintId) {
                    const select = document.getElementById('modal_sprint_select');
                    if (select) select.value = sprintId;
                }
                document.getElementById('briefModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeBriefModal() {
                document.getElementById('briefModal').classList.add('hidden');
                document.body.style.overflow = '';
            }

            function toggleLevelSelect(id) {
                const checkbox = document.getElementById('comp_' + id);
                const selector = document.getElementById('level_select_' + id);
                if (checkbox.checked) selector.classList.remove('hidden');
                else selector.classList.add('hidden');
            }

            function toggleEditLevelSelect(id) {
                const checkbox = document.getElementById('edit_comp_' + id);
                const selector = document.getElementById('edit_level_select_' + id);
                if (checkbox.checked) selector.classList.remove('hidden');
                else selector.classList.add('hidden');
            }

            // --- DELETE MODAL ---
            function openDeleteBriefModal(id, title = "this brief") {
                document.getElementById('delete_brief_title').textContent = title;
                document.getElementById('deleteForm').action = '/teacher/briefs/' + id;
                document.getElementById('deleteBriefModal').classList.remove('hidden');
            }

            function closeDeleteBriefModal() {
                document.getElementById('deleteBriefModal').classList.add('hidden');
            }

            // --- EDIT MODAL ---
            function openEditBriefModal(button) {
                const id = button.dataset.id;

                // 1. Set Form Action
                document.getElementById('editForm').action = '/teacher/briefs/' + id;

                // 2. Fill Basic Fields
                document.getElementById('edit_title').value = button.dataset.title;
                document.getElementById('edit_description').value = button.dataset.description;
                document.getElementById('edit_date_remise').value = button.dataset.date;
                document.getElementById('edit_sprint_id').value = button.dataset.sprint;
                document.getElementById('edit_type').value = button.dataset.type;

                // 3. Reset & Fill Competencies
                const allCheckboxes = document.querySelectorAll('[id^="edit_comp_"]');

                // Hide all levels first
                allCheckboxes.forEach(cb => {
                    cb.checked = false;
                    const compId = cb.id.replace('edit_comp_', '');
                    document.getElementById('edit_level_select_' + compId).classList.add('hidden');
                });

                // Check specific ones
                if (button.dataset.competences) {
                    const competences = JSON.parse(button.dataset.competences);
                    competences.forEach(comp => {
                        const checkbox = document.getElementById('edit_comp_' + comp.id);
                        if (checkbox) {
                            checkbox.checked = true;
                            document.getElementById('edit_level_select_' + comp.id).classList.remove('hidden');

                            // Select correct radio button for level
                            const levelVal = comp.level;
                            const radio = document.getElementById(`edit_lvl_${comp.id}_${levelVal}`);
                            if (radio) radio.checked = true;
                        }
                    });
                }

                document.getElementById('editBriefModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeEditBriefModal() {
                document.getElementById('editBriefModal').classList.add('hidden');
                document.body.style.overflow = '';
            }
        </script>
    @endsection
