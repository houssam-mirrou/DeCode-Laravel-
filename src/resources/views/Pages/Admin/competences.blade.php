@extends('layout')

@section('title', 'Competencies - Decode')

@section('content')


    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Competencies Repository</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manage learning objectives and standard codes</p>
            </div>

            <button onclick="openCreateModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Competency
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
                                <th class="px-8 py-5 w-32">Code</th>
                                <th class="px-8 py-5">Label</th>
                                <th class="px-8 py-5">Description</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($competences as $c)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    {{-- Code --}}
                                    <td class="px-8 py-5">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-600 border border-slate-200 group-hover:border-indigo-200 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                            {{ $c->code }}
                                        </span>
                                    </td>

                                    {{-- Libelle --}}
                                    <td class="px-8 py-5">
                                        <span class="font-bold text-slate-800 text-sm">{{ $c->libelle }}</span>
                                    </td>

                                    {{-- Description --}}
                                    <td class="px-8 py-5">
                                        <p class="text-sm text-slate-500 leading-relaxed max-w-lg line-clamp-2"
                                            title="{{ $c->description }}">
                                            {{ $c->description }}
                                        </p>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-8 py-5 text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-all duration-200">
                                            <button onclick="openEditModal(this)" data-id="{{ $c->id }}"
                                                data-code="{{ $c->code }}" data-libelle="{{ $c->libelle }}"
                                                data-description="{{ $c->description }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>

                                            <button onclick="openDeleteModal({{ $c->id }})"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100"
                                                title="Delete">
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
                                                <i data-lucide="award" class="w-8 h-8 text-slate-300"></i>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg">No competencies found</h3>
                                            <p class="text-slate-500 text-sm mt-1">Start building your repository by
                                                adding a new one.</p>
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


    {{-- MODALS --}}

    {{-- 1. Create Modal --}}
    <div id="createModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCreateModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    <form action="/admin/competences" method="POST">
                        @csrf
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">New Competency</h3>
                                    <p class="text-xs text-slate-500">Define code and description</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1">
                                        <label
                                            class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Code</label>
                                        <input type="text" name="code" required placeholder="C1"
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all font-mono">
                                    </div>
                                    <div class="col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Label</label>
                                        <input type="text" name="libelle" required placeholder="Project Management"
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Description</label>
                                    <textarea name="description" rows="4" placeholder="Detailed explanation..."
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition-all sm:w-auto">Save
                                Competency</button>
                            <button type="button" onclick="closeCreateModal()"
                                class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Edit Modal --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                    <i data-lucide="pencil" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Edit Competency</h3>
                                    <p class="text-xs text-slate-500">Update definition</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1">
                                        <label
                                            class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Code</label>
                                        <input type="text" name="code" id="edit_code" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all font-mono">
                                    </div>
                                    <div class="col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Label</label>
                                        <input type="text" name="libelle" id="edit_libelle" required
                                            class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Description</label>
                                    <textarea name="description" id="edit_description" rows="4"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-all sm:w-auto">Update
                                Changes</button>
                            <button type="button" onclick="closeEditModal()"
                                class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
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
                                <h3 class="text-lg font-bold leading-6 text-slate-900">Delete Competency</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 leading-relaxed">
                                        Are you sure? This cannot be undone and might affect associated briefs.
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
                                Competency</button>
                        </form>
                        <button type="button" onclick="closeDeleteModal()"
                            class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all sm:w-auto">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Helper to toggle visibility
        function toggleModal(id, show) {
            const el = document.getElementById(id);
            if (show) el.classList.remove('hidden');
            else el.classList.add('hidden');
        }

        // Create
        function openCreateModal() {
            toggleModal('createModal', true);
        }

        function closeCreateModal() {
            toggleModal('createModal', false);
        }

        // Edit
        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const code = button.getAttribute('data-code');
            const libelle = button.getAttribute('data-libelle');
            const description = button.getAttribute('data-description');

            // Fill inputs
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_libelle').value = libelle;
            document.getElementById('edit_description').value = description;

            // Set Dynamic Action
            document.getElementById('editForm').action = '/admin/competences/' + id;

            toggleModal('editModal', true);
        }

        function closeEditModal() {
            toggleModal('editModal', false);
        }

        // Delete
        function openDeleteModal(id) {
            // Set Dynamic Action
            document.getElementById('deleteForm').action = '/admin/competences/' + id;
            toggleModal('deleteModal', true);
        }

        function closeDeleteModal() {
            toggleModal('deleteModal', false);
        }
    </script>

@endsection
