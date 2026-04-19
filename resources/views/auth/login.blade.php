<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bench-Z Fitness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(172, 23, 17, 0.22), transparent 24%),
                radial-gradient(circle at bottom right, rgba(172, 23, 17, 0.16), transparent 22%),
                linear-gradient(145deg, #2d2b28 0%, #241f1d 52%, #1a1816 100%);
        }

        .glass-panel {
            background: rgba(45, 43, 40, 0.78);
            border: 1px solid rgba(172, 23, 17, 0.22);
            backdrop-filter: blur(20px);
            box-shadow: 0 22px 70px rgba(12, 10, 9, 0.4);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    <div class="grid min-h-screen lg:grid-cols-[1.1fr_0.9fr]">
        <section class="relative hidden overflow-hidden lg:flex">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-slate-950/65"></div>
            <div class="absolute -left-12 top-10 h-60 w-60 rounded-full bg-[#ac1711]/25 blur-3xl"></div>
            <div class="absolute bottom-8 right-8 h-72 w-72 rounded-full bg-[#ac1711]/10 blur-3xl"></div>

            <div class="relative z-10 flex h-full w-full flex-col justify-between p-10 xl:p-14">
                <div>
                    <p class="text-xs uppercase tracking-[0.45em] text-[#ac1711]/85">Bench-Z Fitness</p>
                    <h1 class="mt-5 max-w-xl text-5xl font-extrabold leading-tight text-white xl:text-6xl">
                        One bold dashboard for your gym operations.
                    </h1>
                    <p class="mt-5 max-w-lg text-base leading-7 text-slate-200/85">
                        Log in to manage members, review attendance patterns, and keep the Bench-Z experience sharp every day.
                    </p>
                </div>

                <div class="grid max-w-2xl grid-cols-3 gap-4">
                    <div class="glass-panel rounded-3xl p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Members</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">100+</p>
                        <p class="mt-2 text-sm text-slate-300">Growing community</p>
                    </div>
                    <div class="glass-panel rounded-3xl p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Revenue</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">PHP 30K</p>
                        <p class="mt-2 text-sm text-slate-300">Monthly snapshot</p>
                    </div>
                    <div class="glass-panel rounded-3xl p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Attendance</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">20</p>
                        <p class="mt-2 text-sm text-slate-300">Today's check-ins</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="flex items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
            <div class="w-full max-w-xl">
                <div class="mb-8 lg:hidden">
                    <p class="text-xs uppercase tracking-[0.4em] text-[#ac1711]/85">Bench-Z Fitness</p>
                    <h1 class="mt-4 text-4xl font-extrabold text-white">Welcome back</h1>
                    <p class="mt-3 text-sm leading-6 text-slate-300">
                        Sign in to access your Bench-Z portal and continue managing your gym experience.
                    </p>
                </div>

                <div class="glass-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-[#ac1711]/85">Member Access</p>
                            <h2 class="mt-3 text-3xl font-extrabold text-white">Sign In</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-300">
                                Use your account credentials to open the dashboard.
                            </p>
                        </div>
                        <div class="rounded-2xl bg-[#ac1711]/18 px-3 py-2 text-xs font-semibold text-[#f7d6d4]">
                            Secure login
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mt-6 rounded-2xl border border-[#ac1711]/25 bg-[#ac1711]/12 px-4 py-3 text-sm text-[#f3cecc]">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Email Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none"
                                placeholder="admin@benchz.com"
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
                                placeholder="Enter your password"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]"
                        >
                            Sign In
                        </button>
                    </form>

                    <div class="mt-8 flex flex-col gap-4 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-slate-400">
                            New here? <a href="{{ route('register') }}" class="font-semibold text-white hover:text-[#e9b2af]">Create an account</a>
                        </p>
                        <a href="{{ route('admin.login') }}" class="text-xs uppercase tracking-[0.28em] text-slate-400 hover:text-[#e9b2af]">Admin Login</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
