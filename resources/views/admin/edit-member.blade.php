<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member | Bench-Z Fitness</title>
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
                <p class="mt-2 text-sm text-slate-400">Update member profile details, plan assignment, status, and plan expiry.</p>
            </div>

            <nav class="flex-1 px-5 py-8 space-y-2">
                <a href="/admin/panel" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Analytics Overview</span>
                </a>
                <a href="/admin/members" class="flex items-center gap-3 rounded-2xl border border-[#ac1711]/35 bg-[#ac1711]/18 px-4 py-3 text-sm font-semibold text-[#f7d6d4]">
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
            <div class="mx-auto max-w-5xl">
                <section class="glass-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-[#ac1711]/80">Admin Panel</p>
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Edit Member Details</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                Update the relevant member details below, including their name, email, assigned plan, current status,
                                and the remaining plan expiry date used by the management system.
                            </p>
                        </div>

                        <a href="/admin/members" class="rounded-2xl bg-white/5 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">
                            Back to Members
                        </a>
                    </div>
                </section>

                @if ($errors->any())
                    <div class="mt-6 rounded-3xl border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-100">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="glass-panel mt-6 rounded-[1.75rem] p-6 sm:p-8">
                    <form action="/admin/members/{{ $member->id }}/edit" method="POST" class="grid gap-5 md:grid-cols-2">
                        @csrf

                        <div class="md:col-span-2">
                            <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Full Name</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $member->name) }}"
                                required
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Email Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $member->email) }}"
                                required
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            >
                        </div>

                        <div>
                            <label for="membership_plan_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Membership Plan</label>
                            <select
                                id="membership_plan_id"
                                name="membership_plan_id"
                                class="w-full rounded-2xl border border-white/10 bg-[#2d2b28]/80 px-4 py-4 text-white focus:border-[#ac1711] focus:outline-none"
                            >
                                <option value="">Unassigned</option>
                                @foreach ($membershipPlans as $plan)
                                    <option value="{{ $plan->id }}" @selected((string) old('membership_plan_id', $member->membership_plan_id) === (string) $plan->id)>
                                        {{ $plan->name }} - PHP {{ number_format((float) $plan->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="membership_status" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Status</label>
                            <select
                                id="membership_status"
                                name="membership_status"
                                required
                                class="w-full rounded-2xl border border-white/10 bg-[#2d2b28]/80 px-4 py-4 text-white focus:border-[#ac1711] focus:outline-none"
                            >
                                @foreach (['active', 'inactive', 'suspended'] as $status)
                                    <option value="{{ $status }}" @selected(old('membership_status', $member->membership_status) === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="plan_expires_at" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Plan Expiry Date</label>
                            <input
                                id="plan_expires_at"
                                type="date"
                                name="plan_expires_at"
                                value="{{ old('plan_expires_at', optional($member->plan_expires_at)->format('Y-m-d')) }}"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            >
                        </div>

                        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
                            <button
                                type="submit"
                                class="rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-6 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]"
                            >
                                Save Changes
                            </button>

                            <a
                                href="/admin/members"
                                class="rounded-2xl bg-white/5 px-6 py-4 text-center text-sm font-semibold uppercase tracking-[0.2em] text-slate-200 transition hover:bg-white/10"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
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
