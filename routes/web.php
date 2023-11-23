<?php

use App\Http\Controllers\AdminBloodRequestController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return redirect()->route('blood-requests.get-all', ['id' => auth()->user()->id]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // user profiel routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'remove'])->name('profile.remove.avatar');

    // blood request routes
    // create blood request
    Route::get('/blood-requests/create', [BloodRequestController::class, 'create'])->name('blood-requests.create');
    Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');
    Route::get('/blood-requests/{id}/edit', [BloodRequestController::class, 'edit'])->name('blood-requests.edit');
    Route::put('/blood-requests/{id}', [BloodRequestController::class, 'update'])->name('blood-requests.update');
    Route::post('/blood-request/{id}/delete', [BloodRequestController::class, 'destroy'])->name('blood-requests.destroy');
    Route::get('/blood-requests/{id}/all', [BloodRequestController::class, 'user_requests'])->name('blood-requests.get-all');
    // get requests where blood group and city matches with user
    Route::get('/blood-requests/{id}/new', [BloodRequestController::class, 'new'])->name('blood-requests.new');
    // fulfill requests
    Route::get('/blood-request/{id}/fulfill', [BloodRequestController::class, 'fulfill'])->name('blood-request.fulfill');
    Route::get('/blood-requests/{id}/donations', [BloodRequestController::class, 'fulfilled'])->name('blood-request.donations');
    // accept blood request
    Route::get('/blood-request/{id}/accept', [BloodRequestController::class, 'accept'])->name('blood-request.accept');
    Route::get('/blood-request/{id}/accepted', [BloodRequestController::class, 'donor_accepted'])->name('blood-requests.accepted');
    Route::get('/blood-request/{id}/decline', [BloodRequestController::class, 'decline'])->name('blood-request.decline');
    // get accepted requests

    Route::get('/blood-requests/need-approval', [BloodRequestController::class, 'need_approval'])->name('blood-request.need.approval');    
    Route::get('/blood-request/{id}/approve', [BloodRequestController::class, 'i_approve'])->name('blood-requests.iapprove');
    Route::get('/blood-request/approved', [BloodRequestController::class, 'approved'])->name('blood-requests.approved');
});


// Route::get('/chat', [ChatController::class, 'index'])->middleware('auth')->name('chat.index');
// Route::get('/chat/messages/{recipient}', [ChatController::class, 'getMessages'])->middleware('auth');
// Route::post('/chat/send/{recipient}', [ChatController::class, 'sendMessage'])->middleware('auth');

require __DIR__ . '/auth.php';
