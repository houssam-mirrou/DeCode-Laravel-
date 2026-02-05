@extends('layout')

@section('title', 'Sprints & Briefs - Decode')

@section('content')



    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Sprints & Briefs</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manage project timelines and assignments</p>
            </div>

            <button onclick="openCreateSprintModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Sprint
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">

            {{-- ALERTS --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <ul class="list-disc pl-5 text-sm font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($sprints as $sprint)
                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full group hover:shadow-lg hover:border-indigo-200 transition-all duration-300 overflow-hidden relative">

                        {{-- Card Header --}}
                        <div class="p-6 border-b border-slate-100 bg-white">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-slate-800 text-lg tracking-tight line-clamp-1"
                                    title="{{ $sprint->name }}">
                                    {{ $sprint->name }}
                                </h3>

                                <div class="flex items-center gap-1 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <button onclick="openEditSprintModal(this)" data-id="{{ $sprint->id }}"
                                        data-name="{{ $sprint->name }}" data-start="{{ $sprint->start_date }}"
                                        data-end="{{ $sprint->end_date }}" data-class-id="{{ $sprint->class_id }}"
                                        class="p-2 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>
                                    <button onclick="openDeleteSprintModal({{ $sprint->id }})"
                                        class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <div
                                    class="flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-indigo-500"></i>
                                    {{-- Assuming Date Accessors or standard formatting --}}
                                    <span>{{ date('M d', strtotime($sprint->start_date)) }} -
                                        {{ date('M d', strtotime($sprint->end_date)) }}</span>
                                </div>
                                <div
                                    class="flex items-center gap-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100">
                                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                    {{-- Relationship Check: school_class --}}
                                    <span>{{ $sprint->classes->name ?? 'Class #' . $sprint->class_id }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Body (Briefs) --}}
                        <div class="flex-1 p-6 bg-slate-50/50">
                            <div class="flex items-center justify-between mb-4">
                                <h4
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="folder-open" class="w-3 h-3"></i> Curriculum Content
                                </h4>
                                <span
                                    class="text-[10px] font-bold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-slate-200">
                                    {{ $sprint->briefs->count() }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                @forelse ($sprint->briefs as $brief)
                                    <a href="#"
                                        class="block p-3.5 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-300 transition-all group/brief">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 group-hover/brief:scale-110 transition-transform">
                                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p
                                                    class="text-sm font-bold text-slate-800 truncate group-hover/brief:text-indigo-700 transition-colors">
                                                    {{ $brief->title }}
                                                </p>
                                                <span class="text-[10px] text-slate-400 flex items-center gap-1 mt-0.5">
                                                    View Document <i data-lucide="external-link" class="w-3 h-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div
                                        class="flex flex-col items-center justify-center py-8 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50">
                                        <i data-lucide="file-question" class="w-5 h-5 text-slate-300 mb-1"></i>
                                        <p class="text-xs text-slate-400 font-medium">No briefs in this sprint</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="bg-slate-50 p-6 rounded-full mb-6 border border-slate-100 shadow-sm">
                            <i data-lucide="layers" class="w-12 h-12 text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No Sprints Found</h3>
                        <p class="text-slate-500 mt-2 max-w-sm text-sm">Get started by creating a sprint to organize
                            the class curriculum.</p>
                        <button onclick="openCreateSprintModal()"
                            class="mt-6 px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">
                            Create First Sprint
                        </button>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
    </div>


    {{-- MODALS --}}

    {{-- 1. Create Modal --}}
    <div id="createSprintModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCreateSprintModal()">
        </div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    <form action="/admin/sprints" method="POST">
                        @csrf
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                    <i data-lucide="timer" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">New Sprint</h3>
                                    <p class="text-xs text-slate-500">Define timeline and scope</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Sprint
                                        Name</label>
                                    <input type="text" name="name" required
                                        placeholder="e.g. Sprint 1: Frontend Basics"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Start
                                            Date</label>
                                        <input type="date" name="start_date" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all text-slate-600">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">End
                                            Date</label>
                                        <input type="date" name="end_date" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all text-slate-600">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Assign
                                        Class</label>
                                    <div class="relative">
                                        <select name="class_id" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all appearance-none">
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition-all sm:w-auto">Create
                                Sprint</button>
                            <button type="button" onclick="closeCreateSprintModal()"
                                class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Edit Modal --}}
    <div id="editSprintModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditSprintModal()">
        </div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                    <i data-lucide="pencil" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Edit Sprint</h3>
                                    <p class="text-xs text-slate-500">Update timeline and details</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Sprint
                                        Name</label>
                                    <input type="text" name="name" id="edit_sprint_name" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Start
                                            Date</label>
                                        <input type="date" name="start_date" id="edit_sprint_start" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all text-slate-600">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">End
                                            Date</label>
                                        <input type="date" name="end_date" id="edit_sprint_end" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all text-slate-600">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Assign
                                        Class</label>
                                    <div class="relative">
                                        <select name="class_id" id="edit_class_id" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all appearance-none">
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-all sm:w-auto">Update
                                Sprint</button>
                            <button type="button" onclick="closeEditSprintModal()"
                                class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Delete Modal --}}
    <div id="deleteSprintModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteSprintModal()">
        </div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-red-100 overflow-hidden">
                    <div class="bg-white px-6 pb-6 pt-6">
                        <div class="sm:flex sm:items-start gap-4">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0">
                                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-0 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-bold leading-6 text-slate-900">Delete Sprint</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 leading-relaxed">
                                        Are you sure? All associated briefs and student submissions will be permanently
                                        removed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <form id="deleteForm" action="" method="POST" class="inline-flex w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-700 transition-all sm:w-auto">Delete
                                Sprint</button>
                        </form>
                        <button type="button" onclick="closeDeleteSprintModal()"
                            class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            lucide.createIcons();

            function toggleModal(id, show) {
                const el = document.getElementById(id);
                if (show) el.classList.remove('hidden');
                else el.classList.add('hidden');
            }

            // Create
            function openCreateSprintModal() {
                toggleModal('createSprintModal', true);
            }

            function closeCreateSprintModal() {
                toggleModal('createSprintModal', false);
            }

            // Edit
            function openEditSprintModal(button) {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const start = button.getAttribute('data-start');
                const end = button.getAttribute('data-end');
                const classId = button.getAttribute('data-class-id');

                // Fill Fields
                document.getElementById('edit_sprint_name').value = name;
                document.getElementById('edit_sprint_start').value = start;
                document.getElementById('edit_sprint_end').value = end;
                document.getElementById('edit_class_id').value = classId;

                // Set Dynamic Action
                document.getElementById('editForm').action = '/admin/sprints/' + id;

                toggleModal('editSprintModal', true);
            }

            function closeEditSprintModal() {
                toggleModal('editSprintModal', false);
            }

            // Delete
            function openDeleteSprintModal(id) {
                document.getElementById('deleteForm').action = '/admin/sprints/' + id;
                toggleModal('deleteSprintModal', true);
            }

            function closeDeleteSprintModal() {
                toggleModal('deleteSprintModal', false);
            }
        </script>
    @endsection
