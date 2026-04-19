<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard | Bench-Z Fitness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(172, 23, 17, 0.22), transparent 22%),
                radial-gradient(circle at bottom right, rgba(172, 23, 17, 0.16), transparent 22%),
                linear-gradient(145deg, #2d2b28 0%, #241f1d 55%, #1a1816 100%);
        }

        .glass-panel {
            background: rgba(45, 43, 40, 0.82);
            border: 1px solid rgba(172, 23, 17, 0.22);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 60px rgba(12, 10, 9, 0.34);
        }

        [hidden] {
            display: none !important;
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    @php
        $planColors = [
            'bronze' => 'text-[#e9b2af]',
            'silver' => 'text-slate-200',
            'gold' => 'text-yellow-300',
            'platinum' => 'text-[#f0b7b4]',
        ];

        $statusClasses = [
            'active' => 'bg-[#ac1711]/12 text-[#f2c4c2]',
            'inactive' => 'bg-slate-500/10 text-slate-300',
            'suspended' => 'bg-red-500/10 text-red-200',
        ];

        $currentPlanName = $member->membershipPlan->name ?? 'No Plan Assigned';
        $currentPlanClass = $planColors[strtolower($currentPlanName)] ?? 'text-[#e9b2af]';
    @endphp

    <div class="mx-auto min-h-screen max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
        <div class="flex justify-end">
            <nav class="glass-panel rounded-[1.5rem] px-3 py-3">
                <button
                    type="button"
                    id="member-sections-toggle"
                    class="flex items-center justify-center gap-2 rounded-2xl bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:bg-[#ac1711]/25 hover:text-white"
                >
                    <i class="fa-solid fa-bars-staggered"></i>
                    <span>Sections</span>
                </button>
            </nav>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-[1.75rem] border border-[#ac1711]/25 bg-[#ac1711]/12 px-5 py-4 text-sm text-[#f3cecc]">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-6 rounded-[1.75rem] border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-100">
                {{ session('error') }}
            </div>
        @endif

        <section id="profile" class="mt-6 grid scroll-mt-28 grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="glass-panel rounded-[1.75rem] p-6 sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Profile</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-white sm:text-3xl">Your Member Profile</h2>
                    </div>
                    <a
                        href="/dashboard/profile"
                        class="rounded-full bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-slate-300 transition hover:bg-white/10"
                    >
                        Edit Profile
                    </a>
                </div>

                <div class="mt-6 flex items-start gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-[#ac1711] to-[#2d2b28] text-2xl font-extrabold text-white">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-bold text-white">{{ $member->name }}</p>
                        <p class="mt-1 break-all text-sm text-slate-300">{{ $member->email }}</p>
                        <p class="mt-2 text-xs uppercase tracking-[0.28em] text-slate-500">Member ID #{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Full Name</p>
                        <p class="mt-3 text-lg font-bold text-white">{{ $member->name }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Email Address</p>
                        <p class="mt-3 break-all text-lg font-bold text-white">{{ $member->email }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-[1.75rem] p-6 sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">QR Access</p>
                        <h3 class="mt-2 text-xl font-bold text-white">Digital Member Pass</h3>
                    </div>
                    <span class="rounded-full bg-[#ac1711]/12 px-3 py-1 text-xs font-semibold text-[#f2c4c2]">Scan Ready</span>
                </div>

                <div class="mt-6 rounded-[1.75rem] bg-white p-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data={{ $member->id }}" alt="Member QR Code" class="mx-auto h-52 w-52 max-w-full">
                </div>
                <p class="mt-4 text-center text-sm text-slate-300">Present this QR code when checking into the gym.</p>
            </div>
        </section>

        <section id="membership-details" class="glass-panel mt-6 scroll-mt-28 rounded-[1.75rem] p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Membership Status</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-white">Current Membership Details</h3>
                </div>
                <span class="rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] {{ $statusClasses[strtolower($member->membership_status ?? 'inactive')] ?? 'bg-slate-500/10 text-slate-300' }}">
                    {{ $member->membership_status ?? 'inactive' }}
                </span>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[1.75rem] border border-white/10 bg-gradient-to-br from-white/10 to-white/5 p-6 md:col-span-2 xl:row-span-2">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Current Plan</p>
                    <p class="mt-4 text-4xl font-extrabold {{ $currentPlanClass }}">{{ $currentPlanName }}</p>
                    <p class="mt-3 max-w-md text-sm leading-6 text-slate-300">
                        Your current membership tier is active in the system and shown here as your main gym access plan.
                    </p>
                </div>

                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Purchased</p>
                    <p class="mt-3 text-lg font-bold text-white">
                        {{ $member->membership_started_at ? $member->membership_started_at->format('F d, Y') : 'Not available' }}
                    </p>
                </div>

                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Days Remaining</p>
                    <p class="mt-3 text-3xl font-extrabold text-[#d8d1cb]">{{ $daysRemaining !== null ? $daysRemaining : 'N/A' }}</p>
                </div>

                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Days Attended</p>
                    <p class="mt-3 text-3xl font-extrabold text-[#f0b7b4]">{{ $daysAttended }}</p>
                </div>

                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Membership Status</p>
                    <p class="mt-3 text-lg font-bold text-white">{{ ucfirst($member->membership_status ?? 'inactive') }}</p>
                </div>
            </div>
        </section>

        <section id="membership-options" class="glass-panel mt-6 scroll-mt-28 rounded-[1.75rem] p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Membership Options</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-white">Available Membership Plans to Buy</h3>
                </div>
                <div class="rounded-2xl bg-white/5 px-4 py-2 text-sm text-slate-300">Proposal preview</div>
            </div>

            <div class="mt-6 -mx-1 overflow-x-auto pb-2">
                <div class="flex min-w-max gap-4 px-1">
                @forelse ($availablePlans as $plan)
                    @php
                        $planColorClass = $planColors[strtolower($plan->name)] ?? 'text-[#e9b2af]';
                        $isCurrentPlan = $member->membership_plan_id === $plan->id;
                    @endphp
                    <div class="w-[285px] flex-none rounded-[1.75rem] border border-white/10 bg-white/5 p-5 sm:w-[320px]">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Membership Tier</p>
                                <h4 class="mt-2 text-2xl font-extrabold {{ $planColorClass }}">{{ $plan->name }}</h4>
                            </div>
                            @if ($isCurrentPlan)
                                <span class="rounded-full bg-[#ac1711]/12 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-[#f2c4c2]">Current</span>
                            @endif
                        </div>

                        <div class="mt-5 space-y-3">
                            <div class="rounded-2xl border border-white/10 bg-[#1f1d1b]/55 px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Duration</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ $plan->duration_value }} {{ $plan->duration_unit }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-[#1f1d1b]/55 px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Price</p>
                                <p class="mt-2 text-lg font-semibold text-white">PHP {{ number_format((float) $plan->price, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-5">
                            @if ($isCurrentPlan)
                                <div class="rounded-2xl bg-[#ac1711]/12 px-4 py-3 text-center text-sm font-semibold uppercase tracking-[0.2em] text-[#f2c4c2]">
                                    This Is Your Current Plan
                                </div>
                            @else
                                <form action="/dashboard/membership-plans/{{ $plan->id }}/buy" method="POST">
                                    @csrf
                                    <label class="mb-3 flex items-start gap-2 rounded-xl border border-white/10 bg-[#1f1d1b]/55 px-3 py-2 text-xs text-slate-300">
                                        <input
                                            type="checkbox"
                                            name="confirm_membership_update"
                                            value="1"
                                            required
                                            class="mt-0.5 h-4 w-4 rounded border-white/20 bg-[#2d2b28] text-[#ac1711] focus:ring-[#ac1711]"
                                        >
                                        <span>Confirm plan update and simulate check-in on success.</span>
                                    </label>
                                    <button
                                        type="submit"
                                        class="w-full rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-3 text-sm font-bold uppercase tracking-[0.22em] text-white transition hover:scale-[1.01]"
                                    >
                                        Choose {{ $plan->name }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="w-full rounded-[1.75rem] border border-dashed border-white/15 bg-white/5 px-5 py-12 text-center text-slate-400">
                        No membership plans are available yet.
                    </div>
                @endforelse
                </div>
            </div>
        </section>

        <section id="session-history" class="glass-panel mt-6 scroll-mt-28 rounded-[1.75rem] p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Session History</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-white">Check-In History</h3>
                </div>
                <div class="rounded-2xl bg-white/5 px-4 py-2 text-sm text-slate-300">
                    Every time you checked into the system
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-white/10">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                        <thead class="bg-white/5 text-slate-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Time</th>
                                <th class="px-6 py-4 font-semibold text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($sessionHistory as $log)
                                <tr class="bg-[#1f1d1b]/55">
                                    <td class="px-6 py-4 font-semibold text-white">{{ $log->checked_in_at->format('g:i A') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-300">{{ $log->checked_in_at->format('F d, Y') }}</td>
                                </tr>
                            @empty
                                <tr class="bg-[#1f1d1b]/55">
                                    <td colspan="2" class="px-6 py-10 text-center text-slate-400">
                                        No session history available yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div id="member-sections-drawer" hidden class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm" data-close-sections-drawer></div>

        <aside class="absolute right-0 top-0 flex h-full w-[88%] max-w-sm flex-col border-l border-white/10 bg-slate-950/95 p-5 shadow-2xl shadow-black/40 backdrop-blur-xl">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Quick Navigation</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-white">Member Sections</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Open the part of your dashboard you want without extra scrolling.</p>
                </div>
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-200 transition hover:bg-white/10"
                    data-close-sections-drawer
                    aria-label="Close sections menu"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <nav class="mt-8 grid gap-3">
                <a href="/dashboard/profile" class="rounded-[1.5rem] bg-[#ac1711]/18 px-5 py-4 text-sm font-semibold text-[#f7d6d4] transition hover:bg-[#ac1711]/25">
                    Profile
                </a>
                <a href="#membership-details" class="member-section-link rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Membership Details
                </a>
                <a href="#membership-options" class="member-section-link rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Membership Options
                </a>
                <a href="#session-history" class="member-section-link rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Session History
                </a>
            </nav>

            <div class="mt-auto space-y-4">
                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Current Plan</p>
                    <p class="mt-3 text-2xl font-extrabold {{ $currentPlanClass }}">{{ $currentPlanName }}</p>
                    <p class="mt-2 text-sm text-slate-300">Use this side menu anytime while browsing your dashboard.</p>
                </div>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-[#ac1711]/25 hover:text-white">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <script>
        const sectionsToggle = document.getElementById('member-sections-toggle');
        const sectionsDrawer = document.getElementById('member-sections-drawer');
        const sectionLinks = document.querySelectorAll('.member-section-link');

        const openSectionsDrawer = () => {
            sectionsDrawer.hidden = false;
            document.body.classList.add('overflow-hidden');
        };

        const closeSectionsDrawer = () => {
            sectionsDrawer.hidden = true;
            document.body.classList.remove('overflow-hidden');
        };

        sectionsToggle.addEventListener('click', openSectionsDrawer);

        document.querySelectorAll('[data-close-sections-drawer]').forEach((element) => {
            element.addEventListener('click', closeSectionsDrawer);
        });

        sectionLinks.forEach((link) => {
            link.addEventListener('click', closeSectionsDrawer);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !sectionsDrawer.hidden) {
                closeSectionsDrawer();
            }
        });
    </script>
</body>
</html>
