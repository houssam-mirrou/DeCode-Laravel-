@extends('layout')

@section('title', 'My Students')

@section('content')
    <div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
        
        <aside class="w-72 bg-white border-r border-slate-200 hidden md:flex flex-col z-20 shadow-sm">
            <div class="h-20 flex items-center px-8 border-b border-slate-100">
                <h1 class="text-xl font-bold text-slate-800 tracking-wide">DECODE <span
                        class="text-xs text-indigo-500 font-bold ml-1 uppercase">Teacher</span></h1>
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
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Evaluations</span>
                </a>
                
                <a href="/teacher/students"
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="users" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">Students & Progress</span>
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
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Class Roster</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Managing <span class="font-bold text-indigo-600">{{ count($students) }}</span> active students</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative hidden sm:block">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" placeholder="Search students..." class="pl-9 pr-4 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all w-64">
                    </div>

                    <button onclick="openModal()"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl flex items-center gap-2 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Add Student
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($students as $student)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-300 group relative overflow-hidden">
                            
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                            <div class="flex items-start justify-between mb-6">
                                <div class="flex gap-4">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-600 font-bold text-lg shadow-inner">
                                        {{ $student->getInitials() }}
                                    </div>

                                    <div>
                                        <h3 class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">
                                            {{ $student->firstName }} {{ $student->lastName }}
                                        </h3>
                                        <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-1">
                                            <i data-lucide="mail" class="w-3 h-3"></i> {{ $student->email }}
                                        </p>
                                    </div>
                                </div>

                                <button class="text-slate-300 hover:text-slate-600 p-1 rounded-full hover:bg-slate-50 transition-colors">
                                    <i data-lucide="more-vertical" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-6">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Project Completion</span>
                                    <span class="text-sm font-bold text-indigo-600">
                                        {{ $student->validatedBriefs }} <span class="text-slate-400 text-[10px] font-normal">/ {{ $student->totalBriefs ?? '∞' }}</span>
                                    </span>
                                </div>

                                {{-- Calculate percentage (capped at 100%) --}}
                                @php $percent = min(100, ($student->validatedBriefs / max(1, $student->totalBriefs)) * 100); @endphp

                                <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-1.5 rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-sm">
                                    View Profile
                                </button>
                                <button class="flex-1 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-all shadow-sm">
                                    Statistics
                                </button>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white border border-dashed border-slate-200 rounded-2xl">
                            <div class="inline-flex p-4 bg-slate-50 rounded-full text-slate-300 mb-4">
                                <i data-lucide="users" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700">No students found</h3>
                            <p class="text-slate-400 text-sm mt-1">This class doesn't have any students enrolled yet.</p>
                            <button onclick="openModal()" class="mt-4 text-indigo-600 text-sm font-bold hover:underline">Add your first student</button>
                        </div>
                    @endforelse

                </div>
            </main>
        </div>
    </div>

    <div id="addStudentModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">

                    <button onclick="closeModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg p-1 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>

                    <div class="px-8 pb-8 pt-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <i data-lucide="user-plus" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-xl font-bold leading-6 text-slate-900" id="modal-title">Add Student</h3>
                        </div>
                        <p class="text-sm text-slate-500 mb-6 pl-11">Register a new student individually or import via CSV.</p>

                        <div class="flex p-1 space-x-1 bg-slate-100 rounded-xl mb-6">
                            <button onclick="switchTab('manual')" id="tab-manual"
                                class="flex-1 py-2 text-sm font-bold rounded-lg shadow bg-white text-indigo-600 transition-all">
                                Manual Entry
                            </button>
                            <button onclick="switchTab('import')" id="tab-import"
                                class="flex-1 py-2 text-sm font-medium rounded-lg text-slate-500 hover:text-slate-700 transition-all">
                                Import CSV
                            </button>
                        </div>

                        <form id="form-manual" action="/teacher/students/add" method="POST" class="space-y-5 animate-in fade-in slide-in-from-bottom-2">
                            <input type="hidden" name="type" value="manual">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5 ml-1">First Name</label>
                                    <input type="text" name="first_name" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5 ml-1">Last Name</label>
                                    <input type="text" name="last_name" required
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5 ml-1">Email Address</label>
                                <div class="relative">
                                    <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <input type="email" name="email" required
                                        class="block w-full pl-10 rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                                </div>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-xl flex items-start gap-3 border border-blue-100">
                                <i data-lucide="info" class="w-5 h-5 text-blue-500 mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-bold text-blue-700">Default Credentials</p>
                                    <p class="text-xs text-blue-600 mt-0.5">The temporary password will be <strong>Student123!</strong></p>
                                </div>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-indigo-500 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                    Create Account
                                </button>
                            </div>
                        </form>

                        <form id="form-import" action="/teacher/students/add" method="POST"
                            enctype="multipart/form-data" class="space-y-6 hidden animate-in fade-in slide-in-from-bottom-2">
                            <input type="hidden" name="type" value="import">

                            <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 px-6 py-10 hover:bg-slate-50 hover:border-indigo-300 transition-all group cursor-pointer relative">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                        <i data-lucide="upload-cloud" class="h-6 w-6 text-indigo-500"></i>
                                    </div>
                                    <div class="mt-2 text-sm leading-6 text-slate-600">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>Click to upload</span>
                                            <input id="file-upload" name="import_file" type="file"
                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                class="sr-only" onchange="showFileName(this)">
                                        </label>
                                        <span class="pl-1">or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1">CSV or Excel up to 5MB</p>
                                    <p id="file-name" class="text-sm font-bold text-slate-800 mt-4 h-5"></p>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Required Columns (Header optional)</p>
                                <div class="flex gap-2 font-mono text-xs text-slate-600">
                                    <span class="bg-white px-2 py-1 rounded border border-slate-200">First Name</span>
                                    <span class="bg-white px-2 py-1 rounded border border-slate-200">Last Name</span>
                                    <span class="bg-white px-2 py-1 rounded border border-slate-200">Email</span>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-2">
                                <a href="/assets/template_students.xlsx" download
                                    class="inline-flex justify-center rounded-xl bg-white border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600 shadow-sm hover:bg-slate-50 hover:text-slate-800 transition-all">
                                    Download Template
                                </a>
                                <button type="submit"
                                    class="inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-indigo-500 hover:shadow-lg transition-all">
                                    Import File
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function openModal() {
            document.getElementById('addStudentModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addStudentModal').classList.add('hidden');
        }

        function switchTab(tab) {
            // Toggle Buttons styles
            const btnManual = document.getElementById('tab-manual');
            const btnImport = document.getElementById('tab-import');
            
            // Toggle Forms visibility
            const formManual = document.getElementById('form-manual');
            const formImport = document.getElementById('form-import');

            // Reset base classes
            const activeClass = "bg-white text-indigo-600 shadow";
            const inactiveClass = "text-slate-500 hover:text-slate-700";

            if (tab === 'manual') {
                btnManual.className = `flex-1 py-2 text-sm font-bold rounded-lg transition-all ${activeClass}`;
                btnImport.className = `flex-1 py-2 text-sm font-medium rounded-lg transition-all ${inactiveClass}`;

                formManual.classList.remove('hidden');
                formImport.classList.add('hidden');
            } else {
                btnImport.className = `flex-1 py-2 text-sm font-bold rounded-lg transition-all ${activeClass}`;
                btnManual.className = `flex-1 py-2 text-sm font-medium rounded-lg transition-all ${inactiveClass}`;

                formImport.classList.remove('hidden');
                formManual.classList.add('hidden');
            }
        }

        function showFileName(input) {
            const name = input.files[0]?.name;
            const display = document.getElementById('file-name');
            if(name) {
                display.innerText = name;
                display.classList.add('text-indigo-600');
            } else {
                display.innerText = '';
            }
        }
    </script>
@endsection