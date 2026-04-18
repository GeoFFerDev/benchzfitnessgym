<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MFA | Bench-Z Fitness</title>
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
    <div class="mx-auto flex min-h-screen max-w-3xl items-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full rounded-[2rem] glass-panel p-8 sm:p-10">
            <p class="text-xs uppercase tracking-[0.4em] text-[#ac1711]/85">Bench-Z Fitness</p>
            <h1 class="mt-4 text-3xl font-extrabold text-white sm:text-4xl">Admin MFA Verification</h1>
            <p class="mt-3 text-sm text-slate-300">Enter the 6-digit MFA code to access the admin panel.</p>

            <div class="mt-5 rounded-2xl border border-[#ac1711]/25 bg-[#ac1711]/12 px-4 py-3 text-sm text-[#f3cecc]">
                <p class="font-semibold">Testing MFA code</p>
                <p class="mt-1">Use <span class="font-mono text-base">{{ $testingCode }}</span> within 10 minutes.</p>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.mfa') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label for="code" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">MFA Code</label>
                    <input id="code" type="text" name="code" inputmode="numeric" maxlength="6" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-white placeholder:text-slate-500 focus:border-[#ac1711] focus:outline-none" placeholder="112233">
                </div>
                <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-[#ac1711] via-[#8d140f] to-[#2d2b28] px-4 py-4 text-sm font-bold uppercase tracking-[0.25em] text-white transition hover:scale-[1.01]">
                    Verify and Sign In
                </button>
            </form>

            <a href="{{ route('admin.login') }}" class="mt-5 inline-block text-sm font-semibold text-slate-300 hover:text-[#e9b2af]">← Back to admin login</a>
        </div>
    </div>
</body>
</html>
