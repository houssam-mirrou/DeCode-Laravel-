@auth
    @if (Auth::user()->role === 'admin')
        <aside
            class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex border-r border-slate-800 shadow-xl z-20">
            <div class="h-20 flex items-center px-8 border-b border-slate-800/50 bg-slate-900">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <i data-lucide="command" class="w-5 h-5 text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-wide">DECODE <span
                            class="text-xs text-indigo-400 font-medium ml-1">ADMIN</span></h1>
                </div>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">

                <a href="/admin/dashboard"
                    class="flex items-center px-4 py-3 rounded-r-lg transition-all group {{ request()->is('admin/dashboard*') ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500' : 'hover:bg-slate-800/50 hover:text-white' }}">
                    <i data-lucide="layout-dashboard"
                        class="w-5 h-5 mr-3 {{ request()->is('admin/dashboard*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                    <span class="font-bold tracking-wide text-sm">Dashboard</span>
                </a>

                <div class="pt-6 pb-3 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Pedagogical Management
                </div>

                <a href="/admin/classes"
                    class="flex items-center px-4 py-3 rounded-r-lg transition-all group {{ request()->is('admin/classes*') ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500' : 'hover:bg-slate-800/50 hover:text-white' }}">
                    <i data-lucide="school"
                        class="w-5 h-5 mr-3 {{ request()->is('admin/classes*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                    <span class="font-medium text-sm">Classes</span>
                </a>

                <a href="/admin/competences"
                    class="flex items-center px-4 py-3 rounded-r-lg transition-all group {{ request()->is('admin/competences*') ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500' : 'hover:bg-slate-800/50 hover:text-white' }}">
                    <i data-lucide="award"
                        class="w-5 h-5 mr-3 {{ request()->is('admin/competences*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                    <span class="font-medium text-sm">Competencies</span>
                </a>

                <a href="/admin/sprints"
                    class="flex items-center px-4 py-3 hover:bg-slate-800/50 hover:text-white rounded-lg transition-all group">
                    <i data-lucide="zap"
                        class="w-5 h-5 mr-3 text-slate-500 group-hover:text-yellow-400 transition-colors"></i>
                    <span class="font-medium text-sm">Sprints & Briefs</span>
                </a>

                <div class="pt-6 pb-3 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    System & Users
                </div>

                <a href="/admin/users"
                    class="flex items-center px-4 py-3 hover:bg-slate-800/50 hover:text-white rounded-lg transition-all group">
                    <i data-lucide="users"
                        class="w-5 h-5 mr-3 text-slate-500 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="font-medium text-sm">Users & Roles</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-800/50 bg-slate-900/50">
                <div class="flex items-center gap-4 p-3 rounded-xl bg-slate-800/50 border border-slate-700/50">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg ring-2 ring-slate-700">
                        SA
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">Super Admin</p>
                        <p class="text-[10px] text-slate-400 truncate uppercase tracking-wider font-semibold">System Manager
                        </p>
                    </div>
                    <form action="/logout" method="POST">
                        @csrf <button type="submit"
                            class="text-slate-400 hover:text-red-400 p-2 rounded-lg hover:bg-slate-700/50 transition-colors"
                            title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    @endif
@endauth
@auth
    @if (Auth::user()->role === 'student')
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
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="folder-git-2"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">My Projects</span>
                </a>

                <a href="/student/evaluations"
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="clipboard-check" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">My Evaluations</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                    <div
                        class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-700 font-bold text-sm shadow-sm">
                        {{ substr(Auth::user()->first_name ?? 'S', 0, 1) . substr(Auth::user()->last_name ?? 'S', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Student' }}
                        </p>
                        <p class="text-[10px] text-slate-400 truncate uppercase tracking-wide font-semibold">Web Development
                        </p>
                    </div>
                    <form action="/logout" method="POST">
                        @csrf <button type="submit"
                            class="text-slate-400 hover:text-red-400 p-2 rounded-lg hover:bg-slate-700/50 transition-colors"
                            title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    @endif
@endauth
@auth
    @if (Auth::user()->role === 'teacher')
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
                    <i data-lucide="layout-dashboard"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <a href="/teacher/briefs"
                    class="flex items-center px-4 py-3 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600 rounded-r-xl transition-all shadow-sm">
                    <i data-lucide="file-code" class="w-5 h-5 mr-3 text-indigo-600"></i>
                    <span class="font-bold text-sm">My Briefs</span>
                </a>

                <a href="/teacher/evaluations"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="check-circle"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Evaluations</span>
                </a>
                <a href="/teacher/students"
                    class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all group">
                    <i data-lucide="users"
                        class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                    <span class="font-medium text-sm">Students & Progress</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        TC
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">Teacher</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wide font-semibold">Logged In</p>
                    </div>
                    <form action="/logout" method="POST">
                        @csrf <button type="submit"
                            class="text-slate-400 hover:text-red-400 p-2 rounded-lg hover:bg-slate-700/50 transition-colors"
                            title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    @endif
@endauth
