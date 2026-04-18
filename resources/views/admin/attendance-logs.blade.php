<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs | Bench-Z Fitness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --panel: rgba(15, 23, 42, 0.86);
            --panel-border: rgba(148, 163, 184, 0.18);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(190, 24, 93, 0.28), transparent 28%),
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 26%),
                linear-gradient(135deg, #020617 0%, #0f172a 55%, #111827 100%);
        }

        .glass-panel {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            box-shadow: 0 18px 60px rgba(2, 6, 23, 0.36);
            backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    <div class="flex min-h-screen">
        <aside class="hidden lg:flex w-72 flex-col border-r border-white/10 bg-slate-950/60 backdrop-blur-xl">
            <div class="p-8 border-b border-white/10">
                <p class="text-xs uppercase tracking-[0.4em] text-rose-300/70">Bench-Z Fitness</p>
                <h1 class="mt-3 text-3xl font-extrabold tracking-tight">Admin HQ</h1>
                <p class="mt-2 text-sm text-slate-400">Monitor gym check-ins and search member attendance records.</p>
            </div>

            <nav class="flex-1 px-5 py-8 space-y-2">
                <a href="/admin/panel" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Analytics Overview</span>
                </a>
                <a href="/admin/members" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <i class="fa-solid fa-users"></i>
                    <span>Members</span>
                </a>
                <a href="/admin/membership-plans" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Membership Plans</span>
                </a>
                <a href="/admin/attendance-logs" class="flex items-center gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm font-semibold text-rose-100">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Attendance Logs</span>
                </a>
            </nav>

            <div class="p-5 border-t border-white/10">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-white/5 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-rose-500/15 hover:text-white">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <section class="glass-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-rose-200/70">Admin Panel</p>
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Attendance Logs</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                Review gym attendance activity, search for a specific member, and see recent check-ins by date and time.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-cyan-400/20 bg-cyan-400/10 px-5 py-4 text-sm text-cyan-100">
                            <p class="font-semibold">Search ready</p>
                            <p class="mt-1 text-cyan-50/85">Use the search bar below to find a member's attendance logs quickly.</p>
                        </div>
                    </div>
                </section>

                <section class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-3">
                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-emerald-500/15 p-4 text-emerald-300">
                                <i class="fa-solid fa-calendar-day text-xl"></i>
                            </div>
                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">Today</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Today's attendance</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($todaysAttendance) }}</h3>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-blue-500/15 p-4 text-blue-300">
                                <i class="fa-solid fa-calendar-week text-xl"></i>
                            </div>
                            <span class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-200">This week</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Weekly attendance</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($weeksAttendance) }}</h3>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-amber-500/15 p-4 text-amber-300">
                                <i class="fa-solid fa-calendar-days text-xl"></i>
                            </div>
                            <span class="rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">This month</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Monthly attendance</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($monthsAttendance) }}</h3>
                    </div>
                </section>

                <section class="glass-panel mt-6 rounded-[1.75rem] p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Attendance Table</p>
                            <h3 class="mt-2 text-xl font-bold text-white">Member Check-In Logs</h3>
                        </div>

                        <form method="GET" action="/admin/attendance-logs" class="w-full max-w-md">
                            <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Search Member</label>
                            <div class="flex gap-3">
                                <input
                                    id="search"
                                    type="text"
                                    name="search"
                                    value="{{ $search }}"
                                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-500 focus:border-rose-300 focus:outline-none"
                                    placeholder="Search by name or email"
                                >
                                <button
                                    type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-rose-700 via-rose-600 to-amber-500 px-5 py-3 text-sm font-semibold text-white"
                                >
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-3xl border border-white/10">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                                <thead class="bg-white/5 text-slate-400">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Name</th>
                                        <th class="px-6 py-4 font-semibold">Checked In</th>
                                        <th class="px-6 py-4 font-semibold text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/10">
                                    @forelse ($attendanceLogs as $log)
                                        <tr class="bg-slate-950/20">
                                            <td class="px-6 py-4 font-semibold text-white">{{ $log->user->name }}</td>
                                            <td class="px-6 py-4 text-slate-300">{{ $log->checked_in_at->format('g:i A') }}</td>
                                            <td class="px-6 py-4 text-right text-slate-400">{{ $log->checked_in_at->format('F d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-slate-950/20">
                                            <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                                No attendance logs found for the current search.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
