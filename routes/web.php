<?php

use App\Models\RequestType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ReportController;;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RequestSLAController;
use App\Http\Controllers\UserClientController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\RequestVolumeController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\ClientActivityController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardActivityController;

// LOGIN
Auth::routes(['register' => false]);


Route::get('/', function () {
    return redirect()->guest('/login');
});

// SSO
// Route::group(['middleware' => ['web', 'guest']], function(){
//     Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('csp');
//     Route::get('connect', [AuthController::class, 'connect'])->name('connect');
// });

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('unauthorized', function () {
    return view('errors.401');
})->name('unauthorized');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

/**
 *
 * REDIS CACHE CLEAR
 */
Route::GET('redis/clear-cache', function () {
    Redis::flushdb();
    echo 'redis cache cleared successfully!';
});

// 2FA
// Route::GET('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
// Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

// 2FA
Route::GET('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
Route::GET('verify', [TwoFactorController::class, 'index'])->name('verify.index');;
Route::POST('verify', [TwoFactorController::class, 'store'])->name('verify.store');;

// FORGOT PASSWORD
Route::GET('forgot-password', [ForgotPasswordController::class,'forgotPassword'])->name('forgot-password');
Route::POST('forgot-password', [ForgotPasswordController::class,'submitForgotPassword'])->name('forgot.password.submit');
Route::GET('forgot-password-verify/{request_key}', [ForgotPasswordController::class,'verifyForgotPassword'])->name('forgot.password.verify');
Route::GET('successful-reset/{userId}/{password}/{request_key}', [ForgotPasswordController::class,'successfulForgotPassword'])->name('successful.verify.forgot.password');

/**
 *  START OF AUTHORIZE & ACTIVE USERS
 */
Auth::routes();
Route::group(['middleware' => ['auth','twofactor','web','active.user']],function () {
    Route::get('home', [PageController::class, 'showHome'])->name('home');
    Route::get('index', [PageController::class, 'showHome'])->name('index');

    // VIEW JOB
    Route::get('/viewjob/{id}', [JobController::class, 'view'])->name('job.view');

    // MY JOBS - DEV ACCESS
    Route::get('/myjobs', [PageController::class, 'showMyJobs'])->name('myjobs.index');
    Route::group(['prefix' => 'myjob'],
    function ()
    {
        Route::get('/all', [JobController::class,'myJob'])->name('myjob.index');
        Route::get('/start/{id}', [JobController::class,'startJob'])->name('myjob.start');
        Route::post('/submitdetails', [JobController::class,'submitDetails'])->name('myjob.submit-details');
        Route::post('/sendforqc', [JobController::class,'sendforqc'])->name('myjob.send-for-qc');
    });

    // QUALITY CHECK - AUDITOR ACCESS
    Route::get('/qualitycheck', [PageController::class, 'showPendingQC'])->name('qualitycheck.index');
    Route::get('/qualitycheck/{id}', [JobController::class, 'viewQC'])->name('job.qc');
    Route::group(['prefix' => 'pendingqc'],
    function ()
    {
        Route::get('/all', [JobController::class,'qualityCheck'])->name('pendingqc.index');
        Route::get('/show/{id}', [JobController::class,'show'])->name('pendingqc.show');
        Route::get('/pick/{id}', [AuditLogController::class,'pickJob'])->name('pendingqc.pick');
    });

    /** START OF ADMIN, TL, MANAGER */

    // Route::group(['middleware' => ['tlom.admin'],], function ()
    //     {
            // JOBS
            Route::get('/jobs', [PageController::class, 'showJobs'])->name('jobs.index');
            Route::group(['prefix' => 'job'],
            function ()
            {
                Route::get('/all', [JobController::class,'index'])->name('job.index');
                Route::get('/create', [PageController::class,'addJob'])->name('job.create');
                Route::post('/store', [JobController::class,'store'])->name('job.store');
                Route::get('/show/{id}', [JobController::class,'show'])->name('job.show');
                Route::post('/update/{id}', [JobController::class,'update'])->name('job.update');
                Route::post('/delete/{id}', [JobController::class,'destroy'])->name('job.delete');
            });

            // PENDING JOBS - TL / MANAGER ACCESS
            Route::get('/pendingjobs', [PageController::class, 'showPendingJobs'])->name('pendingjobs.index');
            Route::group(['prefix' => 'pendingjob'],
            function ()
            {
                Route::get('/all', [JobController::class,'pendingjob'])->name('pendingjob.index');
                Route::get('/show/{id}', [JobController::class,'show'])->name('pendingjob.show');
            });

            // CLIENTS for ADMIN ONLY
            Route::get('/clients', [PageController::class, 'showClients'])->name('clients.index');
            Route::group(['prefix' => 'client'],
            function ()
            {
                Route::get('/all', [ClientController::class,'index'])->name('client.index');
                Route::post('/store', [ClientController::class,'store'])->name('client.store');
                Route::get('/show/{id}', [ClientController::class,'show'])->name('client.show');
                Route::post('/update/{id}', [ClientController::class,'update'])->name('client.update');
                Route::post('/delete/{id}', [ClientController::class,'destroy'])->name('client.delete');
            });

            // CLIENTS for TL / MANAGER
            Route::get('/configuration', [PageController::class, 'showConfiguration'])->name('configuration.index');
            Route::post('client/updateEmailConfig', [ClientController::class,'updateEmailConfig'])->name('client.updateEmailConfig');

            // REQUEST
            Route::group(['prefix' => 'request'],
            function ()
            {
                // TYPES
                Route::get('/types', [PageController::class, 'showRequestTypes'])->name('request-types.index');
                Route::group(['prefix' => 'type'],
                function ()
                {
                    Route::get('/all', [RequestTypeController::class,'index'])->name('request-type.index');
                    Route::post('/store', [RequestTypeController::class,'store'])->name('request-type.store');
                    Route::get('/show/{id}', [RequestTypeController::class,'show'])->name('request-type.show');
                    Route::post('/update/{id}', [RequestTypeController::class,'update'])->name('request-type.update');
                    Route::post('/delete/{id}', [RequestTypeController::class,'destroy'])->name('request-type.delete');
                });

                // VOLUMES
                Route::get('/volumes', [PageController::class, 'showRequestVolumes'])->name('request-volumes.index');
                Route::group(['prefix' => 'volume'],
                function ()
                {
                    Route::get('/all', [RequestVolumeController::class,'index'])->name('request-volume.index');
                    Route::post('/store', [RequestVolumeController::class,'store'])->name('request-volume.store');
                    Route::get('/show/{id}', [RequestVolumeController::class,'show'])->name('request-volume.show');
                    Route::post('/update/{id}', [RequestVolumeController::class,'update'])->name('request-volume.update');
                    Route::post('/delete/{id}', [RequestVolumeController::class,'destroy'])->name('request-volume.delete');
                });

                // SLAS
                Route::get('/slas', [PageController::class, 'showRequestSLAs'])->name('request-slas.index');
                Route::group(['prefix' => 'sla'],
                function ()
                {
                    Route::get('/all', [RequestSLAController::class,'index'])->name('request-sla.index');
                    Route::post('/store', [RequestSLAController::class,'store'])->name('request-sla.store');
                    Route::get('/show/{id}', [RequestSLAController::class,'show'])->name('request-sla.show');
                    Route::get('/get/{typeId}/{volumeId}', [RequestSLAController::class,'get'])->name('request-sla.get');
                    Route::post('/update/{id}', [RequestSLAController::class,'update'])->name('request-sla.update');
                    Route::post('/delete/{id}', [RequestSLAController::class,'destroy'])->name('request-sla.delete');
                });
            });

            // USERS
            Route::get('users', [PageController::class, 'showUsers'])->name('users.index');
            Route::group(['prefix' => 'user'],
            function ()
            {
                Route::get('/all', [UserController::class,'index'])->name('user.index');
                Route::post('/store', [UserController::class,'store'])->name('user.store');
                Route::get('/show/{id}', [UserController::class,'show'])->name('user.show');
                Route::post('/update/{id}', [UserController::class,'update'])->name('user.update');
                Route::post('/delete/{id}', [UserController::class,'destroy'])->name('user.delete');
            });
    //     }
    // );

    /** END OF ADMIN, TL, MANAGER */

});
/**
 * END OF AUTHORIZE & ACTIVE USERS
 *
 */

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
