<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Bench-Z Fitness</title>
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

        $currentPlanName = $member->membershipPlan->name ?? 'No Plan Assigned';
        $currentPlanClass = $planColors[strtolower($currentPlanName)] ?? 'text-[#e9b2af]';
    @endphp

    <div class="mx-auto min-h-screen max-w-5xl px-4 py-5 sm:px-6 lg:px-8">
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

        @if ($errors->any())
            <div class="mt-6 rounded-[1.75rem] border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-100">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="glass-panel mt-6 rounded-[1.75rem] p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Profile</p>
                    <h1 class="mt-2 text-3xl font-extrabold text-white">Edit Your Profile</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        Update your basic member information here without changing anything else on the dashboard.
                    </p>
                </div>
                <a
                    href="/dashboard"
                    class="rounded-2xl bg-white/5 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10"
                >
                    Back to Dashboard
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

            <form action="/dashboard/profile" method="POST" class="mt-8 grid gap-5">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $member->name) }}"
                        required
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                    >
                </div>

                <div>
                    <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $member->email) }}"
                        required
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                    >
                </div>

                <button
                    type="submit"
                    class="rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-4 text-sm font-bold uppercase tracking-[0.22em] text-white transition hover:scale-[1.01]"
                >
                    Save Profile
                </button>
            </form>
        </section>
    </div>

    <div id="member-sections-drawer" hidden class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm" data-close-sections-drawer></div>

        <aside class="absolute right-0 top-0 flex h-full w-[88%] max-w-sm flex-col border-l border-white/10 bg-slate-950/95 p-5 shadow-2xl shadow-black/40 backdrop-blur-xl">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Quick Navigation</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-white">Member Sections</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Jump back to the dashboard sections or stay here to edit your profile.</p>
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
                <a href="/dashboard#membership-details" class="rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Membership Details
                </a>
                <a href="/dashboard#membership-options" class="rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Membership Options
                </a>
                <a href="/dashboard#session-history" class="rounded-[1.5rem] bg-white/5 px-5 py-4 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                    Session History
                </a>
            </nav>

            <div class="mt-auto space-y-4">
                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Current Plan</p>
                    <p class="mt-3 text-2xl font-extrabold {{ $currentPlanClass }}">{{ $currentPlanName }}</p>
                    <p class="mt-2 text-sm text-slate-300">Your current membership plan stays visible here while editing your profile.</p>
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

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !sectionsDrawer.hidden) {
                closeSectionsDrawer();
            }
        });
    </script>
</body>
</html>
