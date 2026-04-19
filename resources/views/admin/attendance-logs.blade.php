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
            --panel: rgba(45, 43, 40, 0.86);
            --panel-border: rgba(172, 23, 17, 0.22);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(172, 23, 17, 0.28), transparent 28%),
                radial-gradient(circle at top right, rgba(172, 23, 17, 0.18), transparent 26%),
                linear-gradient(135deg, #2d2b28 0%, #241f1d 55%, #1a1816 100%);
        }

        .glass-panel {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            box-shadow: 0 18px 60px rgba(12, 10, 9, 0.36);
            backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    <div class="flex min-h-screen">
        <div id="admin-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/55 lg:hidden"></div>
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-white/10 bg-[#1f1d1b]/95 backdrop-blur-xl transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">
            <div class="p-8 border-b border-white/10">
                <p class="text-xs uppercase tracking-[0.4em] text-[#ac1711]/80">Bench-Z Fitness</p>
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
                <a href="/admin/attendance-logs" class="flex items-center gap-3 rounded-2xl border border-[#ac1711]/35 bg-[#ac1711]/18 px-4 py-3 text-sm font-semibold text-[#f7d6d4]">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Attendance Logs</span>
                </a>
            </nav>

            <div class="p-5 border-t border-white/10">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-white/5 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-[#ac1711]/25 hover:text-white">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <button id="admin-sidebar-toggle" type="button" class="mb-4 inline-flex items-center gap-2 rounded-xl border border-[#ac1711]/40 bg-[#1f1d1b]/90 px-4 py-2 text-sm font-semibold text-[#f7d6d4] lg:hidden">
                <i class="fa-solid fa-bars"></i>
                <span>Menu</span>
            </button>
            <div class="mx-auto max-w-7xl">
                <section class="glass-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-[#ac1711]/80">Admin Panel</p>
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Attendance Logs</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                Review gym attendance activity, search for a specific member, and see recent check-ins by date and time.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-[#ac1711]/25 bg-[#ac1711]/12 px-5 py-4 text-sm text-[#f3cecc]">
                            <p class="font-semibold">Search ready</p>
                            <p class="mt-1 text-[#f5dedd]/90">Use the search bar below to find a member's attendance logs quickly.</p>
                        </div>
                    </div>
                </section>

                <section class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-3">
                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-[#ac1711]/15 p-4 text-[#f0b7b4]">
                                <i class="fa-solid fa-calendar-day text-xl"></i>
                            </div>
                            <span class="rounded-full bg-[#ac1711]/12 px-3 py-1 text-xs font-semibold text-[#f2c4c2]">Today</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Today's attendance</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($todaysAttendance) }}</h3>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-[#2d2b28]/70 p-4 text-[#d8d1cb]">
                                <i class="fa-solid fa-calendar-week text-xl"></i>
                            </div>
                            <span class="rounded-full bg-[#2d2b28]/70 px-3 py-1 text-xs font-semibold text-[#e8e1db]">This week</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Weekly attendance</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($weeksAttendance) }}</h3>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-[#2d2b28]/70 p-4 text-[#d8d1cb]">
                                <i class="fa-solid fa-calendar-days text-xl"></i>
                            </div>
                            <span class="rounded-full bg-[#2d2b28]/70 px-3 py-1 text-xs font-semibold text-[#e8e1db]">This month</span>
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
                                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                                    placeholder="Search by name or email"
                                >
                                <button
                                    type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-5 py-3 text-sm font-semibold text-white"
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
                                        <tr class="bg-[#1f1d1b]/55">
                                            <td class="px-6 py-4 font-semibold text-white">{{ $log->user->name }}</td>
                                            <td class="px-6 py-4 text-slate-300">{{ $log->checked_in_at->format('g:i A') }}</td>
                                            <td class="px-6 py-4 text-right text-slate-400">{{ $log->checked_in_at->format('F d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-[#1f1d1b]/55">
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
    <script>
        (() => {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const toggle = document.getElementById('admin-sidebar-toggle');

            if (!sidebar || !overlay || !toggle) {
                return;
            }

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            toggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                    return;
                }

                closeSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    overlay.classList.add('hidden');
                }
            });
        })();
    </script>
</body>
</html>
