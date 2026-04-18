<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plan Management | Bench-Z Fitness</title>
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
                <p class="mt-2 text-sm text-slate-400">Configure membership tiers and pricing.</p>
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
                <a href="/admin/membership-plans" class="flex items-center gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm font-semibold text-rose-100">
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
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Membership Plan Management</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                Manage plan tiers, durations, and prices. Default plans start with Bronze, Silver, and Gold,
                                and you can add more tiers like Platinum with yearly pricing.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-cyan-400/20 bg-cyan-400/10 px-5 py-4 text-sm text-cyan-100">
                            <p class="font-semibold">Plan count</p>
                            <p class="mt-1 text-cyan-50/85">{{ $membershipPlans->count() }} active membership plans available.</p>
                        </div>
                    </div>
                </section>

                @if (session('success'))
                    <div class="mt-6 rounded-3xl border border-emerald-400/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-3xl border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-100">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Available Tiers</p>
                                <h3 class="mt-2 text-xl font-bold text-white">Current Membership Plans</h3>
                            </div>
                            <div class="rounded-2xl bg-white/5 px-4 py-2 text-sm text-slate-300">
                                Sorted by price
                            </div>
                        </div>

                        @php
                            $tierColors = [
                                'bronze' => 'text-amber-600',
                                'silver' => 'text-slate-300',
                                'gold' => 'text-yellow-300',
                                'platinum' => 'text-cyan-300',
                            ];
                        @endphp

                        <div class="mt-6 space-y-4">
                            @forelse ($membershipPlans as $plan)
                                <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tier Name</p>
                                            <h4 class="mt-2 text-2xl font-extrabold {{ $tierColors[strtolower($plan->name)] ?? 'text-rose-200' }}">{{ $plan->name }}</h4>
                                        </div>
                                        <div class="rounded-2xl bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-100">
                                            PHP {{ number_format((float) $plan->price, 2) }}
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="rounded-2xl border border-white/10 bg-slate-950/20 px-4 py-3">
                                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Duration</p>
                                            <p class="mt-2 text-lg font-semibold text-slate-100">
                                                {{ $plan->duration_value }} {{ $plan->duration_unit }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[1.5rem] border border-dashed border-white/15 bg-white/5 px-5 py-12 text-center text-slate-400">
                                    No membership plans yet. Add your first tier using the form on this page.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="glass-panel rounded-[1.75rem] p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Add Plan</p>
                                <h3 class="mt-2 text-xl font-bold text-white">Create New Tier</h3>
                                <p class="mt-2 text-sm text-slate-400">Example: Platinum, 1 year, PHP 3,000.00</p>
                            </div>
                            <div class="rounded-2xl bg-amber-500/10 px-3 py-2 text-xs font-semibold text-amber-100">
                                Admin only
                            </div>
                        </div>

                        <form action="/admin/membership-plans" method="POST" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Plan Name</label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-rose-300 focus:outline-none"
                                    placeholder="Platinum"
                                >
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="duration_value" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Duration Value</label>
                                    <input
                                        id="duration_value"
                                        type="number"
                                        min="1"
                                        name="duration_value"
                                        value="{{ old('duration_value') }}"
                                        required
                                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-rose-300 focus:outline-none"
                                        placeholder="1"
                                    >
                                </div>

                                <div>
                                    <label for="duration_unit" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Duration Unit</label>
                                    <select
                                        id="duration_unit"
                                        name="duration_unit"
                                        required
                                        class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-4 text-white focus:border-rose-300 focus:outline-none"
                                    >
                                        <option value="">Select unit</option>
                                        @foreach (['day', 'days', 'week', 'weeks', 'month', 'months', 'year', 'years'] as $unit)
                                            <option value="{{ $unit }}" @selected(old('duration_unit') === $unit)>{{ ucfirst($unit) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="price" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Price (PHP)</label>
                                <input
                                    id="price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="price"
                                    value="{{ old('price') }}"
                                    required
                                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-rose-300 focus:outline-none"
                                    placeholder="3000"
                                >
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-gradient-to-r from-rose-700 via-rose-600 to-amber-500 px-4 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]"
                            >
                                Add Plan
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
