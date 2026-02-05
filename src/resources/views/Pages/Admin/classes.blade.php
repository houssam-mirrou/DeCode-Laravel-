@extends('layout')

@section('title', 'Classes Management - Decode')

@section('content')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Class Management</h2>
                <p class="text-xs text-slate-500 mt-0.5">Create academic groups and assign faculty</p>
            </div>

            <button onclick="openCreateModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Class
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">

            {{-- ALERTS SECTION --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc pl-5 text-sm font-medium opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50/80 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-8 py-5">Class Name</th>
                                <th class="px-8 py-5">School Year</th>
                                <th class="px-8 py-5">Assigned Teachers</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($classes as $c)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    {{-- Name --}}
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                                <i data-lucide="book-open" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <span
                                                    class="block font-bold text-slate-800 text-sm">{{ $c->name }}</span>
                                                <span class="text-xs text-slate-400">ID: #{{ $c->id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Year --}}
                                    <td class="px-8 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200 text-slate-600 shadow-sm">
                                            <i data-lucide="calendar" class="w-3 h-3 text-slate-400"></i>
                                            {{ $c->school_year }}
                                        </span>
                                    </td>

                                    {{-- Teachers --}}
                                    <td class="px-8 py-5">
                                        <div class="flex flex-wrap gap-2 items-center">
                                            @forelse($c->teachers as $t)
                                                <div
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-white border border-indigo-100 text-indigo-700 shadow-sm group/badge hover:border-indigo-200 transition-colors">
                                                    <div
                                                        class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-[9px] font-bold">
                                                        {{ substr($t->first_name, 0, 1) }}{{ substr($t->last_name, 0, 1) }}
                                                    </div>
                                                    <span>{{ $t->first_name }} {{ $t->last_name }}</span>

                                                    {{-- Remove Teacher Button --}}
                                                    <button type="button"
                                                        onclick="openRemoveTeacherModal({{ $c->id }}, {{ $t->id }}, '{{ $t->first_name }} {{ $t->last_name }}')"
                                                        class="ml-1 w-4 h-4 rounded-full flex items-center justify-center text-indigo-300 hover:text-red-500 hover:bg-red-50 opacity-0 group-hover/badge:opacity-100 transition-all focus:outline-none">
                                                        <i data-lucide="x" class="w-3 h-3"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-400 border border-slate-100 border-dashed">
                                                    <i data-lucide="help-circle" class="w-3 h-3"></i>
                                                    No Teacher Assigned
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-8 py-5 text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-all duration-200">
                                            <button
                                                onclick="openTeachersModal({{ $c->id }}, '{{ $c->name }}')"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition-colors mr-2 shadow-sm">
                                                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Assign
                                            </button>

                                            <button onclick="openEditModal(this)" data-id="{{ $c->id }}"
                                                data-name="{{ $c->name }}" data-year="{{ $c->school_year }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>

                                            <button onclick="openDeleteModal({{ $c->id }})"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <i data-lucide="school" class="w-8 h-8 text-slate-300"></i>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg">No classes found</h3>
                                            <p class="text-slate-500 text-sm mt-1">Get started by creating a new class
                                                above.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    </div>

    {{-- ================= MODALS ================= --}}

    {{-- 1. Create Modal --}}
    <div id="createModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    {{-- FIXED: Action points to /admin/classes --}}
                    <form action="/admin/classes" method="POST">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-6">Create New Class</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Class
                                        Name</label>
                                    <input type="text" name="name" required placeholder="e.g. DevFullStack 2026"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">School
                                        Year</label>
                                    <input type="text" name="school_year" required placeholder="e.g. 2025-2026"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-indigo-700">Create
                                Class</button>
                            <button type="button" onclick="closeCreateModal()"
                                class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Edit Modal --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    {{-- FIXED: ID added to target via JS, Action is empty initially --}}
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-6">Edit Class</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Class
                                        Name</label>
                                    <input type="text" name="name" id="edit_name" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">School
                                        Year</label>
                                    <input type="text" name="school_year" id="edit_year" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">Update
                                Changes</button>
                            <button type="button" onclick="closeEditModal()"
                                class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-red-100 overflow-hidden">
                    <div class="p-6 flex gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 text-red-600">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Delete Class</h3>
                            <p class="text-sm text-slate-500 mt-2">Are you sure? This will remove all associated sprints.
                                <strong class="text-red-600">This cannot be undone.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        {{-- FIXED: ID added to target via JS --}}
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">Delete
                                Class</button>
                        </form>
                        <button type="button" onclick="closeDeleteModal()"
                            class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Assign Teachers Modal --}}
    <div id="teachersModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeTeachersModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    {{-- Note: This URL must exist in your web.php --}}
                    <form action="/admin/classes/assign-teachers" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" id="teacher_class_id">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900">Assign Teachers</h3>
                            <p class="text-sm text-slate-500 mb-4">Select teachers for <span id="teacher_class_name"
                                    class="font-bold text-indigo-600"></span></p>

                            <div
                                class="max-h-60 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100 bg-slate-50 custom-scrollbar">
                                @if (isset($teachers) && count($teachers) > 0)
                                    @foreach ($teachers as $t)
                                        <div class="flex items-center py-3 px-4 hover:bg-white transition-colors">
                                            <div class="flex-1 flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">
                                                    {{ substr($t->first_name, 0, 1) }}{{ substr($t->last_name, 0, 1) }}
                                                </div>
                                                <label for="teacher_{{ $t->id }}"
                                                    class="font-bold text-slate-700 text-sm cursor-pointer">{{ $t->first_name }}
                                                    {{ $t->last_name }}</label>
                                            </div>
                                            <input id="teacher_{{ $t->id }}" name="teachers[]"
                                                value="{{ $t->id }}" type="checkbox"
                                                class="h-5 w-5 rounded text-indigo-600 border-slate-300 focus:ring-indigo-600">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-8 text-center text-sm text-slate-500">No teachers found.</div>
                                @endif
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-indigo-700">Save
                                Assignments</button>
                            <button type="button" onclick="closeTeachersModal()"
                                class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. Remove Teacher Modal (Single) --}}
    <div id="removeTeacherModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRemoveTeacherModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-amber-100 overflow-hidden">
                    <div class="p-6 text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4 text-amber-600">
                            <i data-lucide="user-minus" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Remove Teacher?</h3>
                        <p class="text-sm text-slate-500 mt-2">Remove <span id="remove_teacher_name"
                                class="font-bold text-slate-800"></span> from this class?</p>
                    </div>
                    <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        {{-- Note: This URL must exist in your web.php --}}
                        <form action="/admin/classes/remove-teacher" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="class_id" id="remove_class_id">
                            <input type="hidden" name="teacher_id" id="remove_teacher_id">
                            <button type="submit"
                                class="rounded-xl bg-amber-600 px-4 py-2 text-sm font-bold text-white hover:bg-amber-700">Confirm</button>
                        </form>
                        <button type="button" onclick="closeRemoveTeacherModal()"
                            class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            lucide.createIcons();

            // --- HELPER TO CLOSE ANY MODAL ---
            function toggleModal(id, show) {
                const el = document.getElementById(id);
                if (show) el.classList.remove('hidden');
                else el.classList.add('hidden');
            }

            // --- CREATE MODAL ---
            function openCreateModal() {
                toggleModal('createModal', true);
            }

            function closeCreateModal() {
                toggleModal('createModal', false);
            }

            // --- EDIT MODAL (DYNAMIC URL) ---
            function openEditModal(button) {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const year = button.getAttribute('data-year');

                // 1. Inject Data
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_year').value = year;

                // 2. Set Dynamic Action URL for Resource Controller
                document.getElementById('editForm').action = '/admin/classes/' + id;

                toggleModal('editModal', true);
            }

            function closeEditModal() {
                toggleModal('editModal', false);
            }

            // --- DELETE MODAL (DYNAMIC URL) ---
            function openDeleteModal(id) {
                // Set Dynamic Action URL for Resource Controller
                document.getElementById('deleteForm').action = '/admin/classes/' + id;
                toggleModal('deleteModal', true);
            }

            function closeDeleteModal() {
                toggleModal('deleteModal', false);
            }

            // --- ASSIGN TEACHERS MODAL ---
            function openTeachersModal(id, name) {
                document.getElementById('teacher_class_id').value = id;
                document.getElementById('teacher_class_name').innerText = name;
                toggleModal('teachersModal', true);
            }

            function closeTeachersModal() {
                toggleModal('teachersModal', false);
            }

            // --- REMOVE SINGLE TEACHER MODAL ---
            function openRemoveTeacherModal(classId, teacherId, teacherName) {
                document.getElementById('remove_class_id').value = classId;
                document.getElementById('remove_teacher_id').value = teacherId;
                document.getElementById('remove_teacher_name').innerText = teacherName;
                toggleModal('removeTeacherModal', true);
            }

            function closeRemoveTeacherModal() {
                toggleModal('removeTeacherModal', false);
            }
        </script>
    @endsection
