	<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\HomeController;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');})->name('dashboard');

Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('/dashboard/get', [HomeController::class, 'get'])->name('home.populate');
Route::get('/labels/create', [LabelController::class, 'create'])->name('labels.create.page');
Route::get('/labels/get/', [LabelController::class, 'getNew'])->name('labels.get');
Route::get('/labels/team/{team}/get/', [LabelController::class, 'getTeam'])->name('labels.team');
Route::get('/labels/team/get/{team}', [LabelController::class, 'getNewTeam'])->name('team.label.get');
Route::get('/labels/team/{team}/get/{label}', [LabelController::class, 'team_obtain'])->name('label.get');
Route::get('/labels/get-all', [LabelController::class, 'get'])->name('label.get.all');
Route::post('/labels/create/new', [LabelController::class, 'newLabel'])->name('labels.create');
Route::get('/labels/user/get', [LabelController::class, 'label_user'])->name('labels.user.get');
Route::get('/labels/user/get/{id}', [LabelController::class, 'obtain'])->name('label.get');
Route::get('/labels/user/detach/{id}', [LabelController::class, 'label_detach'])->name('labels.user.delete');
Route::get('/labels/team/{team}/detach/{id}', [LabelController::class, 'label_team_detach'])->name('labels.team.delete');
Route::post('/labels/delete/{label}/{user}', [LabelController::class, 'deleteLabel'])->name('labels.delete');
Route::get('/labels/create/success', [LabelController::class, 'success'])->name('labels.success');
Route::get('/teams/show/{id}', [TeamController::class, 'show'])->name('myteams.show');
Route::get('/teams/profile/{id}', [TeamController::class, 'profile'])->name('teams.profile');
Route::post('/team/{team}/add/user/{email}/role/{role}', [TeamController::class, 'add'])->name('teams.user.add');
Route::get('/team/{team}/members/get/', [TeamController::class, 'getMembers'])->name('members.team');
Route::get('/team/{team}/leader/get/', [TeamController::class, 'getLeader'])->name('members.team');
Route::get('/roles/get/{role}', [RoleController::class, 'get'])->name('roles.get');
Route::get('/team/{team}/submit', [TeamController::class, 'submit'])->name('user.submit');
Route::get('/user/bio/get', [UserController::class, 'get_bio'])->name('user.bio.get');
Route::post('/user/update/{data}', [UserController::class, 'update_bio'])->name('user.update');
Route::get('/submitted', function(){
    return view('teams.submitted');
}); 

Route::get('/logout', function(){
    return redirect(route('dashboard'));
})->name('my_logout');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest'])
            ->name('login');



Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
$enableViews = config('fortify.views', true);

// Authentication...
if ($enableViews) {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest'])
        ->name('login');
}

$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest',
        $limiter ? 'throttle:'.$limiter : null,
    ]));

// Password Reset...
if (Features::enabled(Features::resetPasswords())) {
    if ($enableViews) {
        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
            ->middleware(['guest'])
            ->name('password.request');

        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
            ->middleware(['guest'])
            ->name('password.reset');
    }

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.update');
}

// Registration...
if (Features::enabled(Features::registration())) {
    if ($enableViews) {
        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->middleware(['guest'])
            ->name('register');
    }

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware(['guest']);
}

// Email Verification...
if (Features::enabled(Features::emailVerification())) {
    if ($enableViews) {
        Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
            ->middleware(['auth'])
            ->name('verification.notice');
    }

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
}

// Profile Information...
if (Features::enabled(Features::updateProfileInformation())) {
    Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
        ->middleware(['auth'])
        ->name('user-profile-information.update');
}

// Passwords...
if (Features::enabled(Features::updatePasswords())) {
    Route::put('/user/password', [PasswordController::class, 'update'])
        ->middleware(['auth'])
        ->name('user-password.update');
}

// Password Confirmation...
if ($enableViews) {
    Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware(['auth'])
        ->name('password.confirm');
}

Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
    ->middleware(['auth'])
    ->name('password.confirmation');

Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware(['auth']);

// Two Factor Authentication...
if (Features::enabled(Features::twoFactorAuthentication())) {
    if ($enableViews) {
        Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
            ->middleware(['guest'])
            ->name('two-factor.login');
    }

    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest',
            $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
        ]));

    $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
        ? ['auth', 'password.confirm']
        : ['auth'];

    Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
        ->middleware($twoFactorMiddleware);

    Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
        ->middleware($twoFactorMiddleware);

    Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
        ->middleware($twoFactorMiddleware);

    Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
        ->middleware($twoFactorMiddleware);

    Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
        ->middleware($twoFactorMiddleware);
}
});
