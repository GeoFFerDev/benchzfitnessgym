<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics | Bench-Z Fitness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --accent: #7f1d1d;
            --accent-soft: #be123c;
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
                <p class="mt-2 text-sm text-slate-400">Membership and gym activity analytics.</p>
            </div>

            <nav class="flex-1 px-5 py-8 space-y-2">
                <a href="/admin/panel" class="flex items-center gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm font-semibold text-rose-100">
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
                <a href="/admin/attendance-logs" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-400 transition hover:bg-white/5 hover:text-white">
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
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Gym Analytics Dashboard</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                View total members, monthly revenue, today's attendance, peak gym hours, plan popularity,
                                revenue by membership tier, and retention performance in one place.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-100">
                            <p class="font-semibold">Dashboard snapshot</p>
                            <p class="mt-1 text-emerald-50/80">
                                {{ $totalUsers > 0 ? 'Using live member records from the database with dashboard-ready analytics cards and charts.' : 'Showing dashboard-ready analytics with demo values until more attendance and payment data is added.' }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-3">
                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-blue-500/15 p-4 text-blue-300">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                            <span class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-200">Total members</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Registered members</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($displayMembers) }}</h3>
                        <p class="mt-2 text-sm text-slate-400">Current member base visible in the admin panel.</p>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-emerald-500/15 p-4 text-emerald-300">
                                <i class="fa-solid fa-wallet text-xl"></i>
                            </div>
                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">Monthly revenue</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Estimated membership revenue</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">PHP {{ number_format($monthlyRevenue) }}</h3>
                        <p class="mt-2 text-sm text-slate-400">Combined Bronze, Silver, and Gold plan income.</p>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between">
                            <div class="rounded-2xl bg-amber-500/15 p-4 text-amber-300">
                                <i class="fa-solid fa-door-open text-xl"></i>
                            </div>
                            <span class="rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">Today's attendance</span>
                        </div>
                        <p class="mt-6 text-sm text-slate-400">Projected gym check-ins today</p>
                        <h3 class="mt-2 text-4xl font-extrabold text-white">{{ number_format($todaysAttendance) }}</h3>
                        <p class="mt-2 text-sm text-slate-400">Attendance summary for the current day.</p>
                    </div>
                </section>

                <section class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-2">
                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Traffic Pattern</p>
                                <h3 class="mt-2 text-xl font-bold text-white">Peak Hours</h3>
                                <p class="mt-2 text-sm text-slate-400">Track the busiest hours inside the gym.</p>
                            </div>
                            <div class="rounded-2xl bg-rose-500/10 px-3 py-2 text-xs font-semibold text-rose-200">Live focus</div>
                        </div>
                        <div class="mt-6 h-80">
                            <canvas id="peakHoursChart"></canvas>
                        </div>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Plan Mix</p>
                                <h3 class="mt-2 text-xl font-bold text-white">Membership Popularity</h3>
                                <p class="mt-2 text-sm text-slate-400">See which membership tier attracts the most members.</p>
                            </div>
                            <div class="grid grid-cols-1 gap-3 text-sm text-slate-300">
                                @foreach ($membershipPopularity as $plan)
                                    <div class="flex items-center justify-between gap-6 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                        <span class="font-semibold">{{ $plan['name'] }}</span>
                                        <span>{{ number_format($plan['members']) }} members</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-6 h-80">
                            <canvas id="popularityChart"></canvas>
                        </div>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Income Split</p>
                            <h3 class="mt-2 text-xl font-bold text-white">Membership Revenue</h3>
                            <p class="mt-2 text-sm text-slate-400">Compare monthly revenue by Bronze, Silver, and Gold plans.</p>
                        </div>
                        <div class="mt-6 h-80">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Retention Health</p>
                            <h3 class="mt-2 text-xl font-bold text-white">Retention Metrics</h3>
                            <p class="mt-2 text-sm text-slate-400">Measure how long members continue their subscriptions.</p>
                        </div>
                        <div class="mt-6 h-80">
                            <canvas id="retentionChart"></canvas>
                        </div>
                    </div>
                </section>

                <section class="glass-panel mt-6 rounded-[1.75rem] p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Recent Activity</p>
                            <h3 class="mt-2 text-xl font-bold text-white">Recent Member Registrations</h3>
                        </div>
                        <div class="rounded-2xl bg-white/5 px-4 py-2 text-sm text-slate-300">
                            Showing latest {{ max($recentUsers->count(), 1) }} records
                        </div>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-3xl border border-white/10">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                                <thead class="bg-white/5 text-slate-400">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Member</th>
                                        <th class="px-6 py-4 font-semibold">Email</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-right">Joined</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/10">
                                    @forelse ($recentUsers as $user)
                                        <tr class="bg-slate-950/20">
                                            <td class="px-6 py-4 font-semibold text-white">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-slate-300">{{ $user->email }}</td>
                                            <td class="px-6 py-4">
                                                <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-200">
                                                    Active
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right text-slate-400">{{ $user->created_at?->format('F d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-slate-950/20">
                                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                                No member registrations yet. The analytics cards and charts above are ready for future data.
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
        Chart.defaults.color = '#cbd5e1';
        Chart.defaults.borderColor = 'rgba(148, 163, 184, 0.18)';
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        const peakHours = @json($peakHours);
        const membershipPopularity = @json($membershipPopularity);
        const membershipRevenue = @json($membershipRevenue);
        const retentionMetrics = @json($retentionMetrics);

        new Chart(document.getElementById('peakHoursChart'), {
            type: 'line',
            data: {
                labels: peakHours.map(item => item.label),
                datasets: [{
                    label: 'Attendance',
                    data: peakHours.map(item => item.value),
                    borderColor: '#fb7185',
                    backgroundColor: 'rgba(251, 113, 133, 0.18)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointHoverRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('popularityChart'), {
            type: 'doughnut',
            data: {
                labels: membershipPopularity.map(item => item.name),
                datasets: [{
                    data: membershipPopularity.map(item => item.members),
                    backgroundColor: membershipPopularity.map(item => item.color),
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: membershipRevenue.map(item => item.name),
                datasets: [{
                    label: 'Revenue (PHP)',
                    data: membershipRevenue.map(item => item.amount),
                    backgroundColor: membershipRevenue.map(item => item.color),
                    borderRadius: 14,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => ` PHP ${Number(context.raw).toLocaleString()}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => `PHP ${Number(value).toLocaleString()}`
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('retentionChart'), {
            type: 'bar',
            data: {
                labels: retentionMetrics.map(item => item.label),
                datasets: [{
                    label: 'Retention %',
                    data: retentionMetrics.map(item => item.value),
                    backgroundColor: ['#22c55e', '#38bdf8', '#f59e0b', '#a78bfa'],
                    borderRadius: 14,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => ` ${context.raw}% retained`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: (value) => `${value}%`
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
