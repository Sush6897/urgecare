<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EnquiryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExotelController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalAuthController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\UserVisitController;

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

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/landing', [FrontendController::class, 'landing'])->name('landing');
Route::post('/load-more', [FrontendController::class, 'loadMore'])->name('load.more');

Route::get('/about-us',[FrontendController::class,'aboutus']);
Route::get('/faq', [FrontendController::class, 'faq']);
Route::get('/services',[FrontendController::class,'services']);
Route::get('/privacy-policy',[FrontendController::class,'privacyPolicy']);
Route::get('/terms-condition',[FrontendController::class, 'terms']);
Route::get('/partner-with-us', [FrontendController::class, 'partner']);
Route::get('/urgecare-services',[FrontendController::class, 'urgecare']);
Route::get('/login',[AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login/post',[AuthController::class, 'store'])->name('login.post');
Route::post('/forget',[AuthController:: class, 'forgotPassword'])->middleware('guest')->name('forgot.password');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('possword.update');

Route::get('/forget-password',[AuthController::class,'forgetPassword'])->middleware('guest')->name('forget.password');
Route::get('/dashboard',[AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/profile',[AuthController::class, 'profile'])->middleware('auth')->name('profile');
Route::post('/profile/update',[AuthController::class, 'profileUpdate'])->middleware('auth')->name('profile.update');
Route::post('password/update', [AuthController::class, 'updatePassword'])->middleware('auth')->name('password.update');

// Hospital Authentication Routes
Route::get('/hospital/login', [HospitalAuthController::class, 'showLoginForm'])->name('hospital.login');
Route::post('/hospital/login', [HospitalAuthController::class, 'login'])->name('hospital.login.submit');
Route::post('/hospital/logout', [HospitalAuthController::class, 'logout'])->name('hospital.logout');
Route::get('/hospital/dashboard', [HospitalAuthController::class, 'dashboard'])->middleware('auth:hospital')->name('hospital.dashboard');
Route::get('/hospital/enquiry', [HospitalAuthController::class, 'enquiry'])->middleware('auth:hospital')->name('hospital.enquiry');
Route::get('/hospital/profile', [HospitalAuthController::class, 'profile'])->middleware('auth:hospital')->name('hospital.profile');
Route::post('/hospital/profile/update', [HospitalAuthController::class, 'profileUpdate'])->middleware('auth:hospital')->name('hospital.profile.update');
Route::post('/hospital/password/change', [HospitalAuthController::class, 'changePassword'])->middleware('auth:hospital')->name('hospital.password.change');
Route::get('/hospital/forget-password', [HospitalAuthController::class, 'forgetPassword'])->name('hospital.forget.password');
Route::post('/hospital/forget-password', [HospitalAuthController::class, 'submitForgetPassword'])->name('hospital.forget.password.submit');
Route::get('/hospital/password/reset/{token}', [HospitalAuthController::class, 'showResetForm'])->name('hospital.password.reset');
Route::post('/hospital/password/reset', [HospitalAuthController::class, 'reset'])->name('hospital.password.update');

Route::resource('hospital', HospitalController::class)->middleware('auth');
Route::resource('setting', SettingController::class)->only(['index', 'create', 'store'])->middleware('auth');
Route::get('/hospitals/trash', [HospitalController::class, 'trash'])->middleware('auth')->name('hospital.trash');
Route::post('/hospitals/restore/{id}', [HospitalController::class, 'restore'])->middleware('auth')->name('hospital.restore');
Route::get('/fetch-coordinates', [HospitalController::class, 'fetchCoordinates'])->name('fetchCoordinates');
Route::get('/contact-us', [FrontendController::class, 'contactus']);
Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/enquiry/{id}/status',[EnquiryController::class, 'status'])->middleware('auth')->name('enquiry.status');
Route::delete('/enquiry/{id}/destroy',[EnquiryController::class, 'destroy'])->middleware('auth')->name('enquiry.destroy');
Route::get('/partners/index',[PartnerController::class, 'index'])->name('partners.create');
Route::get('/contact/index',[ContactController::class, 'index'])->name('contact.create');
Route::get('/set-coordinates', [FrontendController::class, 'setcoordinates'])->name('set.coordinates');
Route::delete('/contact/delete/{id}',[ContactController::class, 'destroy'])->middleware('auth')->name('contact.destroy');
Route::get('/emergency-ambulance',[FrontendController::class, 'nonEmergency'])->name('nonemergency');
Route::delete('/partner/delete/{id}',[PartnerController::class,'destroy'])->middleware('auth')->name('partner.destroy');
Route::get('/nearby-ambulance', [FrontendController::class, 'post'])->name('longitude');

Route::post('/call', [FrontendController::class, 'call'])->name('call');
Route::post('/exotel/initiate', [ExotelController::class, 'initiateCall'])->name('exotel.initiate');
Route::post('/exotel/callback', [ExotelController::class, 'handleCallback'])
    ->name('exotel.callback');
// Route::post('/exotel/flow', [FrontendController::class, 'exotelFlow'])->name('exotel.flow');
// Route::get('/exotel/dial-status', [FrontendController::class, 'dialStatus'])->name('dial.status');
// Route::post('/exotel/call-status', [FrontendController::class, 'handleCallStatus'])->name('exotel.callback');
Route::get('/enquiry',[EnquiryController::class, 'index'])->middleware('auth')->name('enquiry.index');
Route::resource('user-visits', UserVisitController::class)->only(['index', 'destroy'])->middleware('auth');

Route::post('/partners/{id}/status', [PartnerController::class, 'updateStatus'])->middleware('auth')->name('partners.status');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
