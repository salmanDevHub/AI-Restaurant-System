<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class AuthController extends Controller {

    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [$field => $login, 'password' => $request->password];

        $user = User::where($field, $login)->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Account not found. Please register first.'])->withInput();
        }

        if ($user->is_blocked) {
            return back()->withErrors(['login' => 'Your account has been blocked. Contact support.'])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors(['login' => 'Your account is inactive.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Invalid password. Please try again.'])->withInput();
        }

        Auth::login($user, $request->remember);

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return redirect()->intended(route('user.home'))->with('success', 'Welcome back! 🎉');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone|min:10|max:15',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'email.unique' => 'This email is already registered. Try logging in.',
            'phone.unique' => 'This phone number is already registered.',
            'password.min' => 'Password must be at least 8 characters.',
            'terms.accepted' => 'Please accept the terms and conditions.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $this->formatPhone($request->phone),
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verification_token' => bin2hex(random_bytes(32)),
            'is_active' => true,
        ]);

        // Send welcome notification
        Notification::create([
            'user_id' => $user->id,
            'title' => '🎉 Welcome to FoodieHub!',
            'message' => "Hi {$user->name}! Welcome to FoodieHub. Use code WELCOME20 for 20% off your first order!",
            'type' => 'welcome',
            'data' => ['coupon' => 'WELCOME20'],
        ]);

        // Send OTP for phone verification
        $this->sendPhoneOtp($user);

        Auth::login($user);

        return redirect()->route('user.verify.phone')->with('success', 'Account created! Please verify your phone number.');
    }

    public function showPhoneVerify() {
        return view('auth.verify-phone');
    }

    public function verifyPhone(Request $request) {
        $request->validate(['otp' => 'required|string|size:6']);
        $user = Auth::user();

        if ($user->phone_otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if ($user->phone_otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        $user->update([
            'phone_verified' => true,
            'phone_otp' => null,
            'phone_otp_expires_at' => null,
        ]);

        return redirect()->route('user.home')->with('success', 'Phone verified! 📱 Welcome to FoodieHub!');
    }

    public function resendOtp() {
        $user = Auth::user();
        $this->sendPhoneOtp($user);
        return back()->with('success', 'New OTP sent to your phone.');
    }

    private function sendPhoneOtp(User $user): void {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'phone_otp' => $otp,
            'phone_otp_expires_at' => now()->addMinutes(10),
        ]);

        // TODO: Send via Twilio SMS
        // For development, log OTP
        \Log::info("OTP for {$user->phone}: {$otp}");
    }


    public function showAdminRegister() {
        return view('auth.admin-register');
    }

    public function adminRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|unique:users,phone|min:10|max:15',
            'password'   => 'required|string|min:8|confirmed',
            'admin_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->admin_code !== 'SHAHJAN_ADMIN_2024') {
            return back()->withErrors(['admin_code' => 'Invalid admin registration code. Contact system administrator.'])->withInput();
        }

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $this->formatPhone($request->phone),
            'password'       => Hash::make($request->password),
            'role'           => 'admin',
            'is_active'      => true,
            'email_verified' => true,
            'phone_verified' => true,
        ]);

        Auth::login($user);
        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin account created! Welcome, ' . $user->name . '!');
    }

        public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    private function formatPhone(string $phone): string {
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 10) return '0' . $phone;
        return $phone;
    }
}