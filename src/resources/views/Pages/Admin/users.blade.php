@extends('layout')

@section('title', 'Users & Roles - Decode')

@section('content')


    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header
            class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">User Management</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manage access, roles, and class assignments</p>
            </div>

            <button onclick="openCreateModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Add User
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">

            {{-- FLASH MESSAGES --}}
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

            {{-- FILTERS --}}
            <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-slate-200 w-fit mb-8 shadow-sm">
                @php $currentRole = request()->query('role', 'all'); @endphp

                <a href="/admin/users"
                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $currentRole == 'all' ? 'bg-slate-100 text-slate-800 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    All Users
                </a>
                <div class="w-px h-4 bg-slate-200 mx-1"></div>
                <a href="/admin/users?role=teacher"
                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $currentRole == 'teacher' ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    Teachers
                </a>
                <a href="/admin/users?role=student"
                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $currentRole == 'student' ? 'bg-emerald-50 text-emerald-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    Students
                </a>
                <a href="/admin/users?role=admin"
                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $currentRole == 'admin' ? 'bg-purple-50 text-purple-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    Admins
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50/80 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-8 py-5">User Identity</th>
                                <th class="px-8 py-5">Role</th>
                                <th class="px-8 py-5">Assignment</th>
                                <th class="px-8 py-5">Contact</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($users as $u)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    {{-- Identity --}}
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            @php
                                                $avatarColor = match ($u->role) {
                                                    'admin' => 'bg-purple-100 text-purple-600',
                                                    'teacher' => 'bg-blue-100 text-blue-600',
                                                    default => 'bg-emerald-100 text-emerald-600',
                                                };
                                            @endphp
                                            <div
                                                class="h-10 w-10 rounded-full {{ $avatarColor }} flex items-center justify-center text-xs font-bold shrink-0 border border-white shadow-sm ring-1 ring-slate-100">
                                                {{ substr($u->first_name, 0, 1) . substr($u->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">{{ $u->first_name }}
                                                    {{ $u->last_name }}</div>
                                                <div class="text-[10px] text-slate-400 font-medium">Joined
                                                    {{ $u->created_at ? $u->created_at->format('M Y') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-8 py-5">
                                        @if ($u->role === 'admin')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                                <i data-lucide="shield" class="w-3 h-3"></i> Admin
                                            </span>
                                        @elseif($u->role === 'teacher')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                <i data-lucide="presentation" class="w-3 h-3"></i> Teacher
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <i data-lucide="graduation-cap" class="w-3 h-3"></i> Student
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Assignment --}}
                                    <td class="px-8 py-5">
                                        @if ($u->role === 'student')
                                            @if ($u->student_class)
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                    <span
                                                        class="text-sm font-medium text-slate-700">{{ $u->student_class->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs font-medium text-slate-400 italic">No Class
                                                    Assigned</span>
                                            @endif
                                        @elseif ($u->role === 'teacher')
                                            @if ($u->teaching_classes->count() > 0)
                                                <span class="text-xs font-medium text-slate-400 italic">{{$u->teaching_classes->pluck('name')->join(', ')}}</span>
                                            @else
                                                <span class="text-xs font-medium text-slate-400 italic">Faculty
                                                    Member</span>
                                            @endif
                                        @else
                                            <span class="text-xs font-medium text-slate-400 italic">System Access</span>
                                        @endif
                                    </td>

                                    {{-- Contact --}}
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                            {{ $u->email }}
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-8 py-5 text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-all duration-200">
                                            <button onclick="openEditModal(this)" data-id="{{ $u->id }}"
                                                data-fname="{{ $u->first_name }}" data-lname="{{ $u->last_name }}"
                                                data-email="{{ $u->email }}" data-role="{{ $u->role }}"
                                                data-class="{{ $u->class_id }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="Edit User">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button onclick="openDeleteModal({{ $u->id }})"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete User">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <i data-lucide="user-x" class="w-8 h-8 text-slate-300"></i>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg">No users found</h3>
                                            <p class="text-slate-500 text-sm mt-1">Try adjusting the filters or add a new
                                                user.</p>
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
                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                    <form action="/admin/users" method="POST">
                        @csrf
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                    <i data-lucide="user-plus" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Add New User</h3>
                                    <p class="text-xs text-slate-500">Create account credentials</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">First
                                        Name</label>
                                    <input type="text" name="first_name" required placeholder="John"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Last
                                        Name</label>
                                    <input type="text" name="last_name" required placeholder="Doe"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Email
                                        Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i data-lucide="mail" class="h-4 w-4 text-slate-400"></i>
                                        </div>
                                        <input type="email" name="email" required placeholder="john@decode.com"
                                            class="block w-full pl-10 rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i data-lucide="lock" class="h-4 w-4 text-slate-400"></i>
                                        </div>
                                        <input type="password" name="password" required placeholder="••••••••"
                                            class="block w-full pl-10 rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Role</label>
                                    <select name="role" id="create_role_select" onchange="toggleClassSelect('create')"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all appearance-none">
                                        <option value="student">Student</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div id="create_class_container" class="animate-fadeIn">
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Assign
                                        Class</label>
                                    <select name="class_id"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all appearance-none">
                                        <option value="">-- Select Class --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition-all sm:w-auto">Create
                                User</button>
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
                                    <h3 class="text-lg font-bold text-slate-900">Edit User</h3>
                                    <p class="text-xs text-slate-500">Update account details</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">First
                                        Name</label>
                                    <input type="text" name="first_name" id="edit_fname" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Last
                                        Name</label>
                                    <input type="text" name="last_name" id="edit_lname" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Email</label>
                                    <input type="email" name="email" id="edit_email" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Role</label>
                                    <select name="role" id="edit_role_select" onchange="toggleClassSelect('edit')"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                        <option value="student">Student</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div id="edit_class_container">
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5 ml-1">Assign
                                        Class</label>
                                    <select name="class_id" id="edit_class_select"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                        <option value="">-- No Class --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="bg-amber-50 p-3 rounded-xl border border-amber-100 flex items-start gap-3">
                                    <i data-lucide="key" class="w-4 h-4 text-amber-500 mt-0.5"></i>
                                    <div class="flex-1">
                                        <p class="text-[10px] font-bold text-amber-700 uppercase mb-1">Change Password</p>
                                        <input type="password" name="password" placeholder="Leave blank to keep current"
                                            class="block w-full rounded-lg border-amber-200 bg-white p-2 text-sm focus:border-amber-500 focus:ring-amber-500 shadow-sm transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/80 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-all sm:w-auto">Update
                                User</button>
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
                                <h3 class="text-lg font-bold leading-6 text-slate-900">Delete User Account</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 leading-relaxed">
                                        Are you sure? This action will remove all their data, evaluations, and submissions.
                                        <strong class="text-red-600">This cannot be undone.</strong>
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
                                Account</button>
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

        function toggleModal(id, show) {
            const el = document.getElementById(id);
            if (show) el.classList.remove('hidden');
            else el.classList.add('hidden');
        }

        // Dropdown Logic
        function toggleClassSelect(mode) {
            const roleSelect = document.getElementById(mode + '_role_select');
            const classContainer = document.getElementById(mode + '_class_container');

            if (roleSelect.value === 'student') {
                classContainer.classList.remove('hidden');
            } else {
                classContainer.classList.add('hidden');
            }
        }

        // Create
        function openCreateModal() {
            toggleModal('createModal', true);
            toggleClassSelect('create');
        }

        function closeCreateModal() {
            toggleModal('createModal', false);
        }

        // Edit
        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const fname = button.getAttribute('data-fname');
            const lname = button.getAttribute('data-lname');
            const email = button.getAttribute('data-email');
            const role = button.getAttribute('data-role');
            const classId = button.getAttribute('data-class');

            document.getElementById('edit_fname').value = fname;
            document.getElementById('edit_lname').value = lname;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role_select').value = role;

            const classSelect = document.getElementById('edit_class_select');
            classSelect.value = classId || "";

            document.getElementById('editForm').action = '/admin/users/' + id;

            toggleClassSelect('edit');
            toggleModal('editModal', true);
        }

        function closeEditModal() {
            toggleModal('editModal', false);
        }

        // Delete
        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = '/admin/users/' + id;
            toggleModal('deleteModal', true);
        }

        function closeDeleteModal() {
            toggleModal('deleteModal', false);
        }
    </script>
@endsection
