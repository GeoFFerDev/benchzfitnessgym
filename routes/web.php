<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

// 1. This shows the Register Page (GET)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// 2. This handles the "Create Account" button click (POST)
Route::post('/register', function (Request $request) {
    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $defaultPlan = MembershipPlan::orderBy('price')->first();

    $planExpiry = $defaultPlan
        ? match ($defaultPlan->duration_unit) {
            'day', 'days' => now()->addDays((int) $defaultPlan->duration_value),
            'week', 'weeks' => now()->addWeeks((int) $defaultPlan->duration_value),
            'month', 'months' => now()->addMonths((int) $defaultPlan->duration_value),
            'year', 'years' => now()->addYears((int) $defaultPlan->duration_value),
            default => now()->addDays((int) $defaultPlan->duration_value),
        }
        : null;

    // Create the User in the database
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'membership_plan_id' => $defaultPlan?->id,
        'membership_status' => 'active',
        'plan_expires_at' => $planExpiry,
        'membership_started_at' => $defaultPlan ? now() : null,
    ]);

    // Redirect to login after success
    return redirect('/login')->with('success', 'Account created!');
});

// 3. This shows the Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::get('/admin/mfa', function (Request $request) {
    if (! $request->session()->has('pending_admin_mfa_user_id')) {
        return redirect()->route('admin.login');
    }

    return view('auth.admin-mfa', [
        'testingCode' => $request->session()->get('pending_admin_mfa_code'),
    ]);
})->name('admin.mfa');

// Only logged in users can see this
Route::get('/dashboard', function () {
    $member = auth()->user()->load([
        'membershipPlan',
        'attendanceLogs' => fn ($query) => $query->latest('checked_in_at'),
    ]);

    $availablePlans = MembershipPlan::orderBy('price')->get();
    $sessionHistory = $member->attendanceLogs->take(20);
    $daysAttended = $member->attendanceLogs
        ->groupBy(fn ($log) => $log->checked_in_at->toDateString())
        ->count();
    $daysRemaining = $member->plan_expires_at
        ? max(0, Carbon::now()->startOfDay()->diffInDays($member->plan_expires_at->copy()->startOfDay(), false))
        : null;

    return view('dashboard', [
        'member' => $member,
        'availablePlans' => $availablePlans,
        'sessionHistory' => $sessionHistory,
        'daysAttended' => $daysAttended,
        'daysRemaining' => $daysRemaining,
    ]);
})->middleware('auth');

Route::post('/dashboard/membership-plans/{plan}/buy', function (MembershipPlan $plan) {
    $member = auth()->user();

    if ($member->role !== 'member') {
        return redirect('/dashboard')->with('error', 'Only member accounts can update membership plans.');
    }

    request()->validate([
        'confirm_membership_update' => 'accepted',
    ], [
        'confirm_membership_update.accepted' => 'Please confirm your plan selection before continuing.',
    ]);

    $planExpiry = match ($plan->duration_unit) {
        'day', 'days' => now()->addDays((int) $plan->duration_value),
        'week', 'weeks' => now()->addWeeks((int) $plan->duration_value),
        'month', 'months' => now()->addMonths((int) $plan->duration_value),
        'year', 'years' => now()->addYears((int) $plan->duration_value),
        default => now()->addDays((int) $plan->duration_value),
    };

    $member->update([
        'membership_plan_id' => $plan->id,
        'membership_status' => 'active',
        'membership_started_at' => now(),
        'plan_expires_at' => $planExpiry,
    ]);

    AttendanceLog::create([
        'user_id' => $member->id,
        'checked_in_at' => now(),
    ]);

    return redirect('/dashboard')->with('success', 'Your membership plan is now set to ' . $plan->name . '. A temporary check-in was also logged.');
})->middleware('auth');

Route::get('/dashboard/profile', function () {
    $member = auth()->user()->load('membershipPlan');

    return view('member.profile', [
        'member' => $member,
    ]);
})->middleware('auth');

Route::post('/dashboard/profile', function (Request $request) {
    $member = auth()->user();

    if ($member->role !== 'member') {
        return redirect('/dashboard')->with('error', 'Only member accounts can update profile details here.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($member->id)],
    ]);

    $member->update($validated);

    return redirect('/dashboard/profile')->with('success', 'Your profile details were updated successfully.');
})->middleware('auth');

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if (auth()->user()->role === 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput(['email' => $credentials['email']])
                ->withErrors(['email' => 'Admin accounts must use the Admin Login with MFA.']);
        }

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/admin/login', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $admin = User::where('email', $validated['email'])
        ->where('role', 'admin')
        ->first();

    if (! $admin || ! Hash::check($validated['password'], $admin->password)) {
        return back()
            ->withInput(['email' => $validated['email']])
            ->withErrors(['email' => 'Invalid admin credentials.']);
    }

    $code = '112233';

    $request->session()->put([
        'pending_admin_mfa_user_id' => $admin->id,
        'pending_admin_mfa_code' => $code,
        'pending_admin_mfa_expires_at' => now()->addMinutes(10)->timestamp,
    ]);

    return redirect()
        ->route('admin.mfa')
        ->with('success', 'A test MFA code has been generated. Use ' . $code . ' to continue.');
})->name('admin.login.submit');

Route::post('/admin/mfa', function (Request $request) {
    $validated = $request->validate([
        'code' => 'required|digits:6',
    ]);

    $pendingAdminId = $request->session()->get('pending_admin_mfa_user_id');
    $pendingCode = $request->session()->get('pending_admin_mfa_code');
    $expiresAt = (int) $request->session()->get('pending_admin_mfa_expires_at');

    if (! $pendingAdminId || ! $pendingCode || now()->timestamp > $expiresAt) {
        $request->session()->forget([
            'pending_admin_mfa_user_id',
            'pending_admin_mfa_code',
            'pending_admin_mfa_expires_at',
        ]);

        return redirect()
            ->route('admin.login')
            ->withErrors(['email' => 'MFA session expired. Please log in again.']);
    }

    if ($validated['code'] !== $pendingCode) {
        return back()->withErrors(['code' => 'Invalid MFA code.']);
    }

    Auth::loginUsingId($pendingAdminId);
    $request->session()->regenerate();
    $request->session()->forget([
        'pending_admin_mfa_user_id',
        'pending_admin_mfa_code',
        'pending_admin_mfa_expires_at',
    ]);

    return redirect('/admin/panel');
});

Route::get('/admin/panel', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    $totalUsers = User::where('role', 'member')->count();
    $recentUsers = User::where('role', 'member')->latest()->take(5)->get();
    $displayMembers = max($totalUsers, 100);

    $bronzeMembers = (int) round($displayMembers * 0.50);
    $silverMembers = (int) round($displayMembers * 0.30);
    $goldMembers = max($displayMembers - $bronzeMembers - $silverMembers, 0);

    $membershipPopularity = [
        ['name' => 'Bronze', 'members' => $bronzeMembers, 'color' => '#b7791f'],
        ['name' => 'Silver', 'members' => $silverMembers, 'color' => '#94a3b8'],
        ['name' => 'Gold', 'members' => $goldMembers, 'color' => '#facc15'],
    ];

    $membershipRevenue = [
        ['name' => 'Bronze', 'amount' => $bronzeMembers * 200, 'color' => '#b7791f'],
        ['name' => 'Silver', 'amount' => $silverMembers * 300, 'color' => '#94a3b8'],
        ['name' => 'Gold', 'amount' => $goldMembers * 550, 'color' => '#facc15'],
    ];

    $monthlyRevenue = collect($membershipRevenue)->sum('amount');
    $todaysAttendance = max(20, (int) round($displayMembers * 0.20));

    $peakHours = [
        ['label' => '6 AM', 'value' => 8],
        ['label' => '8 AM', 'value' => 14],
        ['label' => '10 AM', 'value' => 11],
        ['label' => '12 PM', 'value' => 9],
        ['label' => '4 PM', 'value' => 13],
        ['label' => '6 PM', 'value' => 19],
        ['label' => '8 PM', 'value' => 16],
    ];

    $retentionMetrics = [
        ['label' => '30 Days', 'value' => 88],
        ['label' => '60 Days', 'value' => 80],
        ['label' => '90 Days', 'value' => 74],
        ['label' => '6 Months', 'value' => 68],
    ];

    return view('admin.panel', [
        'totalUsers' => $totalUsers,
        'displayMembers' => $displayMembers,
        'monthlyRevenue' => $monthlyRevenue,
        'todaysAttendance' => $todaysAttendance,
        'membershipPopularity' => $membershipPopularity,
        'membershipRevenue' => $membershipRevenue,
        'peakHours' => $peakHours,
        'retentionMetrics' => $retentionMetrics,
        'recentUsers' => $recentUsers,
    ]);
})->middleware('auth');

Route::get('/admin/membership-plans', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    $membershipPlans = MembershipPlan::orderBy('price')->get();

    return view('admin.membership-plans', [
        'membershipPlans' => $membershipPlans,
    ]);
})->middleware('auth');

Route::post('/admin/membership-plans', function (Request $request) {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:membership_plans,name',
        'duration_value' => 'required|integer|min:1|max:3650',
        'duration_unit' => 'required|string|in:day,days,week,weeks,month,months,year,years',
        'price' => 'required|numeric|min:0|max:999999.99',
    ]);

    MembershipPlan::create($validated);

    return redirect('/admin/membership-plans')->with('success', 'Membership plan added successfully.');
})->middleware('auth');

Route::get('/admin/members', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    $members = User::with('membershipPlan')
        ->where('role', 'member')
        ->latest()
        ->get()
        ->map(function (User $member) {
            $member->days_remaining = $member->plan_expires_at
                ? max(0, Carbon::now()->startOfDay()->diffInDays($member->plan_expires_at->copy()->startOfDay(), false))
                : null;

            return $member;
        });

    return view('admin.members', [
        'members' => $members,
    ]);
})->middleware('auth');

Route::post('/admin/members/{user}/status', function (Request $request, User $user) {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    if ($user->role !== 'member') {
        return redirect('/admin/members')->with('error', 'Only member accounts can be updated here.');
    }

    $validated = $request->validate([
        'membership_status' => 'required|string|in:active,inactive,suspended',
    ]);

    $user->update([
        'membership_status' => $validated['membership_status'],
    ]);

    return redirect('/admin/members')->with('success', $user->name . ' is now marked as ' . $validated['membership_status'] . '.');
})->middleware('auth');

Route::get('/admin/members/{user}/edit', function (User $user) {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    if ($user->role !== 'member') {
        return redirect('/admin/members')->with('error', 'Only member accounts can be edited here.');
    }

    $membershipPlans = MembershipPlan::orderBy('price')->get();

    return view('admin.edit-member', [
        'member' => $user->load('membershipPlan'),
        'membershipPlans' => $membershipPlans,
    ]);
})->middleware('auth');

Route::post('/admin/members/{user}/edit', function (Request $request, User $user) {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    if ($user->role !== 'member') {
        return redirect('/admin/members')->with('error', 'Only member accounts can be edited here.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        'membership_plan_id' => 'nullable|exists:membership_plans,id',
        'membership_status' => 'required|string|in:active,inactive,suspended',
        'plan_expires_at' => 'nullable|date',
    ]);

    $newPlanId = $validated['membership_plan_id'] ?? null;
    $membershipStartedAt = $user->membership_started_at;

    if ((string) $user->membership_plan_id !== (string) $newPlanId) {
        $membershipStartedAt = $newPlanId ? now() : null;
    } elseif ($newPlanId && ! $membershipStartedAt) {
        $membershipStartedAt = now();
    }

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'membership_plan_id' => $newPlanId,
        'membership_status' => $validated['membership_status'],
        'plan_expires_at' => ! empty($validated['plan_expires_at'])
            ? Carbon::parse($validated['plan_expires_at'])->endOfDay()
            : null,
        'membership_started_at' => $membershipStartedAt,
    ]);

    return redirect('/admin/members')->with('success', $user->name . '\'s details were updated successfully.');
})->middleware('auth');

Route::get('/admin/attendance-logs', function (Request $request) {
    if (auth()->user()->role !== 'admin') {
        return redirect('/dashboard');
    }

    $search = trim((string) $request->query('search', ''));

    $attendanceLogs = AttendanceLog::with('user')
        ->whereHas('user', function ($query) use ($search) {
            $query->where('role', 'member');

            if ($search !== '') {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        })
        ->latest('checked_in_at')
        ->get();

    $actualToday = AttendanceLog::whereDate('checked_in_at', Carbon::today())->count();
    $actualWeek = AttendanceLog::whereBetween('checked_in_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    $actualMonth = AttendanceLog::whereBetween('checked_in_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

    return view('admin.attendance-logs', [
        'attendanceLogs' => $attendanceLogs,
        'search' => $search,
        'todaysAttendance' => max($actualToday, 100),
        'weeksAttendance' => max($actualWeek, 300),
        'monthsAttendance' => max($actualMonth, 1000),
    ]);
})->middleware('auth');
