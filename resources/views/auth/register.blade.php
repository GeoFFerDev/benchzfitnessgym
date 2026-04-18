<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Bench-Z Fitness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(172, 23, 17, 0.2), transparent 24%),
                radial-gradient(circle at bottom right, rgba(172, 23, 17, 0.16), transparent 20%),
                linear-gradient(155deg, #2d2b28 0%, #241f1d 55%, #1a1816 100%);
        }

        .glass-panel {
            background: rgba(45, 43, 40, 0.8);
            border: 1px solid rgba(172, 23, 17, 0.22);
            backdrop-filter: blur(18px);
            box-shadow: 0 22px 70px rgba(12, 10, 9, 0.38);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    <div class="mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:flex-row lg:items-center lg:gap-10 lg:px-8">
        <section class="w-full py-8 lg:w-[46%] lg:py-0">
            <p class="text-xs uppercase tracking-[0.45em] text-[#ac1711]/85">Bench-Z Fitness</p>
            <h1 class="mt-5 text-4xl font-extrabold leading-tight text-white sm:text-5xl">
                Start your Bench-Z membership with a sharper, modern signup flow.
            </h1>
            <p class="mt-5 max-w-xl text-sm leading-7 text-slate-300 sm:text-base">
                Create your member profile, unlock your dashboard, and step into a cleaner gym experience built around progress and retention.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="glass-panel rounded-3xl p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Access</p>
                    <p class="mt-3 text-lg font-bold text-white">Digital pass</p>
                    <p class="mt-2 text-sm text-slate-300">Ready for member entry</p>
                </div>
                <div class="glass-panel rounded-3xl p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tracking</p>
                    <p class="mt-3 text-lg font-bold text-white">Visits</p>
                    <p class="mt-2 text-sm text-slate-300">See your check-ins later</p>
                </div>
                <div class="glass-panel rounded-3xl p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Growth</p>
                    <p class="mt-3 text-lg font-bold text-white">Retention</p>
                    <p class="mt-2 text-sm text-slate-300">Built for long-term members</p>
                </div>
            </div>
        </section>

        <section class="w-full lg:w-[54%]">
            <div class="glass-panel rounded-[2rem] p-6 sm:p-8 lg:p-10">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-[#ac1711]/85">Create Account</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-white">Join Bench-Z Fitness</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-300">
                            Fill in your details below to create your member profile.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-[#ac1711]/12 px-3 py-2 text-xs font-semibold text-[#f3cecc]">
                        New member
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/register" method="POST" class="mt-8 grid gap-5 md:grid-cols-2">
                    @csrf

                    <div class="md:col-span-2">
                        <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Full Name</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            placeholder="Juan Dela Cruz"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            placeholder="member@benchz.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            placeholder="Create a strong password"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                            placeholder="Repeat your password"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]"
                        >
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-8 flex flex-col gap-4 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-400">
                        Already have an account? <a href="/login" class="font-semibold text-white hover:text-[#e9b2af]">Sign in</a>
                    </p>
                    <p class="text-xs uppercase tracking-[0.28em] text-slate-500">Bench-Z Member Portal</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
