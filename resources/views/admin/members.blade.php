<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management System | Bench-Z Fitness</title>
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

        [hidden] {
            display: none !important;
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
                <p class="mt-2 text-sm text-slate-400">Track every registered member in one management table.</p>
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
            <div class="mx-auto max-w-7xl">
                <section class="glass-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-[#ac1711]/80">Admin Panel</p>
                            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Members Management System</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                                Review every member registered in the system with their email, assigned plan, membership status,
                                and the remaining days left on their current plan.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-[#ac1711]/25 bg-[#2d2b28]/75 px-5 py-4 text-sm text-[#f1e8e2]">
                            <p class="font-semibold">Registered members</p>
                            <p class="mt-1 text-[#f6eeea]/90">{{ $members->count() }} member accounts found.</p>
                        </div>
                    </div>
                </section>

                @if (session('success'))
                    <div class="mt-6 rounded-3xl border border-[#ac1711]/25 bg-[#ac1711]/12 px-5 py-4 text-sm text-[#f3cecc]">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-6 rounded-3xl border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                @php
                    $tierColors = [
                        'bronze' => 'text-[#e9b2af]',
                        'silver' => 'text-slate-300',
                        'gold' => 'text-[#f0b7b4]',
                        'platinum' => 'text-[#f0b7b4]',
                    ];

                    $statusClasses = [
                        'active' => 'bg-[#ac1711]/12 text-[#f2c4c2]',
                        'inactive' => 'bg-slate-500/10 text-slate-300',
                        'suspended' => 'bg-red-500/10 text-red-200',
                    ];

                    $statusButtonClasses = [
                        'active' => [
                            'active' => 'bg-[#ac1711]/25 text-[#f3cecc] ring-1 ring-[#ac1711]/45',
                            'default' => 'bg-[#ac1711]/12 text-[#f2c4c2] hover:bg-[#ac1711]/20',
                        ],
                        'inactive' => [
                            'active' => 'bg-slate-500/25 text-slate-100 ring-1 ring-slate-300/40',
                            'default' => 'bg-slate-500/10 text-slate-300 hover:bg-slate-500/20',
                        ],
                        'suspended' => [
                            'active' => 'bg-red-500/25 text-red-100 ring-1 ring-red-300/40',
                            'default' => 'bg-red-500/10 text-red-200 hover:bg-red-500/20',
                        ],
                    ];
                @endphp

                <section class="glass-panel mt-6 rounded-[1.75rem] p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Member Records</p>
                            <h3 class="mt-2 text-xl font-bold text-white">Registered Members Table</h3>
                        </div>
                        <div class="rounded-2xl bg-white/5 px-4 py-2 text-sm text-slate-300">
                            Name, email, plan, status, days remaining, action
                        </div>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-3xl border border-white/10">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                                <thead class="bg-white/5 text-slate-400">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Name</th>
                                        <th class="px-6 py-4 font-semibold">Email</th>
                                        <th class="px-6 py-4 font-semibold">Plan</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-right">Days Remaining</th>
                                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/10">
                                    @forelse ($members as $member)
                                        <tr class="bg-[#1f1d1b]/55">
                                            <td class="px-6 py-4 font-semibold text-white">{{ $member->name }}</td>
                                            <td class="px-6 py-4 text-slate-300">{{ $member->email }}</td>
                                            <td class="px-6 py-4">
                                                <span class="font-semibold {{ $tierColors[strtolower($member->membershipPlan->name ?? '')] ?? 'text-[#e9b2af]' }}">
                                                    {{ $member->membershipPlan->name ?? 'Unassigned' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide {{ $statusClasses[strtolower($member->membership_status)] ?? 'bg-slate-500/10 text-slate-300' }}">
                                                    {{ $member->membership_status ?? 'inactive' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right font-semibold text-slate-200">
                                                {{ $member->days_remaining !== null ? $member->days_remaining . ' days' : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button
                                                    type="button"
                                                    class="member-action-trigger inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-200 transition hover:bg-white/10"
                                                    data-member-id="{{ $member->id }}"
                                                    data-member-name="{{ $member->name }}"
                                                    data-member-status="{{ strtolower($member->membership_status ?? 'inactive') }}"
                                                    data-edit-url="/admin/members/{{ $member->id }}/edit"
                                                    aria-label="Open member actions"
                                                >
                                                    <span class="text-lg font-bold leading-none">...</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-[#1f1d1b]/55">
                                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                                No member accounts are registered yet.
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

    <div id="member-action-modal" hidden class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm" data-close-member-modal></div>

        <div class="glass-panel relative z-10 w-full max-w-md rounded-[2rem] p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Member Actions</p>
                    <h3 id="member-action-title" class="mt-2 text-2xl font-extrabold text-white">Member Name</h3>
                    <p class="mt-2 text-sm text-slate-300">Update the member's status or edit their relevant details.</p>
                </div>
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-200 transition hover:bg-white/10"
                    data-close-member-modal
                    aria-label="Close member actions"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <a
                id="member-edit-link"
                href="#"
                class="mt-6 block rounded-2xl bg-white/5 px-4 py-4 text-center text-sm font-semibold uppercase tracking-[0.2em] text-slate-100 transition hover:bg-white/10"
            >
                Edit Details
            </a>

            <div class="mt-6 border-t border-white/10 pt-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Set Activity</p>
                <div class="mt-4 grid gap-3">
                    @foreach (['active', 'inactive', 'suspended'] as $status)
                        <form id="member-status-form-{{ $status }}" action="#" method="POST">
                            @csrf
                            <input type="hidden" name="membership_status" value="{{ $status }}">
                            <button
                                type="submit"
                                id="member-status-button-{{ $status }}"
                                data-default-class="{{ $statusButtonClasses[$status]['default'] }}"
                                data-active-class="{{ $statusButtonClasses[$status]['active'] }}"
                                class="flex w-full items-center justify-between rounded-2xl px-4 py-4 text-left text-sm font-semibold transition {{ $statusButtonClasses[$status]['default'] }}"
                            >
                                <span>{{ ucfirst($status) }}</span>
                                <span class="member-status-current hidden text-[10px] uppercase tracking-[0.25em]">Current</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        const memberActionModal = document.getElementById('member-action-modal');
        const memberActionTitle = document.getElementById('member-action-title');
        const memberEditLink = document.getElementById('member-edit-link');
        const memberActionTriggers = document.querySelectorAll('.member-action-trigger');
        const memberStatusValues = ['active', 'inactive', 'suspended'];

        const openMemberModal = (trigger) => {
            const memberId = trigger.dataset.memberId;
            const memberName = trigger.dataset.memberName;
            const memberStatus = trigger.dataset.memberStatus;
            const editUrl = trigger.dataset.editUrl;

            memberActionTitle.textContent = memberName;
            memberEditLink.href = editUrl;

            memberStatusValues.forEach((status) => {
                const form = document.getElementById(`member-status-form-${status}`);
                const button = document.getElementById(`member-status-button-${status}`);
                const currentLabel = button.querySelector('.member-status-current');
                const defaultClass = button.dataset.defaultClass;
                const activeClass = button.dataset.activeClass;

                form.action = `/admin/members/${memberId}/status`;
                button.className = `flex w-full items-center justify-between rounded-2xl px-4 py-4 text-left text-sm font-semibold transition ${status === memberStatus ? activeClass : defaultClass}`;
                currentLabel.hidden = status !== memberStatus;
            });

            memberActionModal.hidden = false;
            document.body.classList.add('overflow-hidden');
        };

        const closeMemberModal = () => {
            memberActionModal.hidden = true;
            document.body.classList.remove('overflow-hidden');
        };

        memberActionTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => openMemberModal(trigger));
        });

        document.querySelectorAll('[data-close-member-modal]').forEach((element) => {
            element.addEventListener('click', closeMemberModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !memberActionModal.hidden) {
                closeMemberModal();
            }
        });
    </script>
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
