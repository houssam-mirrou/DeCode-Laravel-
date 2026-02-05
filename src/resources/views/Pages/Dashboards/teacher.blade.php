@extends('layout')

@section('title', 'Teacher Dashboard - Decode')

@section('content')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Class Overview</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">DevFullStack-2025</span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                    <i data-lucide="calendar" class="w-3 h-3"></i> Sprint 3: Advanced Backend
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
                <button class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    <i data-lucide="pen-tool" class="w-4 h-4"></i>
                    Start Evaluation
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 scroll-smooth">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Reviews</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-extrabold text-slate-800">5</h3>
                                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded mb-1">Urgent</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">Student submissions waiting</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-500 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="hourglass" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 h-1 mt-4 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full" style="width: 40%"></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Brief</p>
                            <h3 class="text-lg font-bold text-slate-800 mt-2 truncate">PHP Sessions</h3>
                            <p class="text-xs text-indigo-600 font-medium mt-1 flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i> Due in 2 days
                            </p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex -space-x-2">
                        <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white text-[8px] flex items-center justify-center font-bold text-slate-600">JP</div>
                        <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white text-[8px] flex items-center justify-center font-bold text-slate-600">AM</div>
                        <div class="w-6 h-6 rounded-full bg-slate-50 border-2 border-white text-[8px] flex items-center justify-center text-slate-400 font-bold">+12</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Class Mastery</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-extrabold text-slate-800">82%</h3>
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded mb-1 flex items-center gap-0.5">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> +4%
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">Competency validation rate</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-500 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 h-1 mt-4 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 82%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Recent Submissions</h3>
                            <p class="text-xs text-slate-500">Students awaiting feedback</p>
                        </div>
                        <button class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                            View All History
                        </button>
                    </div>

                    <div class="divide-y divide-slate-50">
                        <div class="p-5 hover:bg-slate-50/80 transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-700 font-bold text-sm shadow-sm">
                                        HS
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 bg-white p-0.5 rounded-full">
                                        <div class="w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Houssam S.</p>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Laravel Basics: CRUD Operations</p>
                                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Submitted 2 hours ago
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="#" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-white rounded-lg border border-transparent hover:border-slate-200 transition-all" title="View Code">
                                    <i data-lucide="github" class="w-4 h-4"></i>
                                </a>
                                <button class="flex items-center gap-1.5 px-4 py-2 bg-white border border-indigo-200 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition-all shadow-sm">
                                    <i data-lucide="check-square" class="w-3.5 h-3.5"></i> Evaluate
                                </button>
                            </div>
                        </div>

                        <div class="p-5 hover:bg-slate-50/80 transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-700 font-bold text-sm shadow-sm">
                                    JD
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">John Doe</p>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">PHP Native: Algorithm Logic</p>
                                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Submitted 5 hours ago
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="#" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-white rounded-lg border border-transparent hover:border-slate-200 transition-all">
                                    <i data-lucide="github" class="w-4 h-4"></i>
                                </a>
                                <button class="flex items-center gap-1.5 px-4 py-2 bg-white border border-indigo-200 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition-all shadow-sm">
                                    <i data-lucide="check-square" class="w-3.5 h-3.5"></i> Evaluate
                                </button>
                            </div>
                        </div>

                        <div class="p-5 hover:bg-slate-50/80 transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center text-pink-700 font-bold text-sm shadow-sm">
                                    AL
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Ada Lovelace</p>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Algorithm Logic: Sorting</p>
                                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Submitted 1 day ago
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="#" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-white rounded-lg border border-transparent hover:border-slate-200 transition-all">
                                    <i data-lucide="github" class="w-4 h-4"></i>
                                </a>
                                <button class="flex items-center gap-1.5 px-4 py-2 bg-white border border-indigo-200 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition-all shadow-sm">
                                    <i data-lucide="check-square" class="w-3.5 h-3.5"></i> Evaluate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 text-lg">Sprint Goals</h3>
                        <button class="p-1 text-slate-400 hover:text-indigo-600 transition-colors">
                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="space-y-6 flex-1">
                        <div class="group">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="font-bold text-slate-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                    C1. Maquetter UI/UX
                                </span>
                                <span class="font-bold text-slate-500">85%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000 group-hover:bg-indigo-600" style="width: 85%"></div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="font-bold text-slate-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                    C2. SQL Databases
                                </span>
                                <span class="font-bold text-slate-500">60%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-yellow-500 h-full rounded-full transition-all duration-1000 group-hover:bg-yellow-600" style="width: 60%"></div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="font-bold text-slate-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                    C3. PHP Backend
                                </span>
                                <span class="font-bold text-slate-500">40%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-orange-500 h-full rounded-full transition-all duration-1000 group-hover:bg-orange-600" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-6 py-3 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all flex items-center justify-center gap-2">
                        View Competency Matrix <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

            </div>
        </main>
    </div>


<script>
    lucide.createIcons();
</script>
@endsection
