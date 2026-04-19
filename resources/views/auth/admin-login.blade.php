<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Bench-Z Fitness</title>
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
            background: rgba(45, 43, 40, 0.8);
            border: 1px solid rgba(172, 23, 17, 0.22);
            backdrop-filter: blur(20px);
            box-shadow: 0 22px 70px rgba(12, 10, 9, 0.4);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100">
    <div class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full rounded-[2rem] glass-panel p-8 sm:p-10">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-[#ac1711]/85">Bench-Z Fitness</p>
                    <h1 class="mt-4 text-3xl font-extrabold text-white sm:text-4xl">Admin Sign In</h1>
                    <p class="mt-3 text-sm text-slate-300">Continue to a two-step login flow with test MFA enabled.</p>
                </div>
                <a href="{{ route('login') }}" class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-200 transition hover:bg-[#ac1711]/20">Member Login</a>
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

            <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Admin Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none" placeholder="admin@benchz.com">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Password</label>
                    <input id="password" type="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none" placeholder="Enter admin password">
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]">
                    Continue to MFA
                </button>
            </form>
        </div>
    </div>
</body>
</html>
