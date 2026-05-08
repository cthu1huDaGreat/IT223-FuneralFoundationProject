<?php

use Illuminate\Support\Facades\Route;   
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('page.index');    
});


// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/register-user', [RegisterController::class, 'store'])->name('register.user'); 
Route::get('/dashboard', [ContributionController::class, 'dashboard'])->name('page.dashboard-member');
Route::post('/announcements/store', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
Route::get('/announcements/get', [App\Http\Controllers\AnnouncementController::class, 'getAnnouncements'])->name('announcements.get');
Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::post('/announcements/dismiss', [AnnouncementController::class, 'dismiss'])->name('announcements.dismiss');   
Route::post('/users/approve', [UserController::class, 'approveUser'])->name('users.approve');
Route::get('/members/count', [MemberController::class, 'getMembersCount'])->name('members.count');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/members/update', [MemberController::class, 'updateMember'])->name('members.update');

Route::get('/members/get', [MemberController::class, 'getMembers'])->name('members.get');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/announcements/get', [App\Http\Controllers\AnnouncementController::class, 'getAll'])->name('announcements.get');
Route::post('/announcements/update', [App\Http\Controllers\AnnouncementController::class, 'update'])->name('announcements.update');
Route::post('/announcements/delete', [App\Http\Controllers\AnnouncementController::class, 'delete'])->name('announcements.delete');
Route::post('/announcements/delete', [AnnouncementController::class, 'delete'])->name('announcements.delete');

// Member management routes
Route::get('/members', [MemberController::class, 'getMembers'])->name('members.get');
Route::get('/members/roles', [MemberController::class, 'getRoles'])->name('members.roles');
Route::post('/members/update-role', [MemberController::class, 'updateMemberRole'])->name('members.update-role');
Route::post('/members/delete', [MemberController::class, 'deleteMember'])->name('members.delete');
Route::post('/members/add', [MemberController::class, 'addMember'])->name('members.add');


Route::get('/users/pending', [UserController::class, 'getPendingRegistrations'])->name('users.pending');
Route::post('/users/approve', [UserController::class, 'approveUser'])->name('users.approve');
Route::post('/users/delete', [UserController::class, 'deleteUser'])->name('users.delete');
Route::post('/funeral-fund/add', [UserController::class, 'addToFuneralFund'])->name('funeral.fund.add');

// Profile routes
Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile.get');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

// Attendance Routes
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.get');
Route::get('/attendance/{id}/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');
Route::post('/attendance/update-status', [AttendanceController::class, 'updateStatus'])->name('attendance.updateStatus');
Route::post('/attendance/close', [AttendanceController::class, 'close'])->name('attendance.close');

// Attendance Routes
Route::get('/attendance/get', [AttendanceController::class, 'index'])->name('attendance.get');
Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/{id}/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');
Route::post('/attendance/update-status', [AttendanceController::class, 'updateStatus'])->name('attendance.updateStatus');
Route::post('/attendance/close', [AttendanceController::class, 'close'])->name('attendance.close');
Route::post('/attendance/archive', [AttendanceController::class, 'archive'])->name('attendance.archive');
Route::post('/attendance/delete', [AttendanceController::class, 'delete'])->name('attendance.delete');


Route::prefix('family')->group(function () {
    Route::get('/list', [FamilyController::class, 'index'])->name('family.list');
    Route::post('/store', [FamilyController::class, 'store'])->name('family.store');
    Route::post('/update', [FamilyController::class, 'update'])->name('family.update');
    Route::post('/delete', [FamilyController::class, 'delete'])->name('family.delete');
});
Route::get('page/dashboard-member', [DashboardController::class, 'index']);
// Dashboards
Route::get('/page/dashboard-member', function () {
    return view('page.dashboard-member');
})->name('page.dashboard-member');

Route::get('/page/dashboard-treasurer', function () {
    return view('page.dashboard-treasurer');
})->name('page.dashboard-treasurer');

Route::get('/page/member-contribution', function () {
    return view('page.member-contribution');
})->name('page.member-contribution');

Route::get('/page/member-funeral', function () {
    return view('page.member-funeral');
})->name('page.member-funeral');

Route::get('/page/member-settings', function () {
    return view('page.member-settings');
})->name('page.member-settings');

Route::get('/page/president-members', function () {
    return view('page.president-members');
})->name('page.president-members');

Route::get('/page/president-contribution', function () {
    return view('page.president-contribution');
})->name('page.president-contribution');

Route::get('/page/president-funeral', function () {
    return view('page.president-funeral');
})->name('page.president-funeral');

Route::get('/page/president-settings', function () {
    return view('page.president-settings');
})->name('page.president-settings');

Route::get('/page/treasurer-members', function () {
    return view('page.treasurer-members');
})->name('page.treasurer-members');

Route::get('/page/treasurer-contributions', function () {
    return view('page.treasurer-contributions');
})->name('page.treasurer-contributions');

Route::get('/page/treasurer-settings', function () {
    return view('page.treasurer-settings');
})->name('page.treasurer-settings');

Route::get('/page/treasurer-funeral', function () {
    return view('page.treasurer-funeral');
})->name('page.treasurer-funeral');

Route::get('/page/index', function () {
    return view('page.index');
})->name('page.index');

Route::post('/settings/change-password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
Route::get('/page/dashboard-president', [DashboardController::class, 'index'])->name('page.dashboard-president');
Route::get('/dashboard-president', [DashboardController::class, 'index']);