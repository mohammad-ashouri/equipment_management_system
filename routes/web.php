<?php

use App\Http\Controllers\BookIntroductionController;
use App\Http\Controllers\Catalogs\AudioSubjectController;
use App\Http\Controllers\Catalogs\DocumentTypeController;
use App\Http\Controllers\Catalogs\MultimediaSubjectController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\PersonAdjectiveController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\Catalogs\SocialMediaPlatformController;
use App\Http\Controllers\Catalogs\SubjectAudienceController;
use App\Http\Controllers\Catalogs\SubjectFormatController;
use App\Http\Controllers\Catalogs\TeacherController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentaryController;
use App\Http\Controllers\DocumentClassController;
use App\Http\Controllers\InternationalDocumentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\MediaSubjectController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PictureAlbumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\Reports\DatabaseBackupController;
use App\Http\Controllers\ResearchSubjectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShortVideoController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SpecialCaseController;
use App\Http\Controllers\UserManager;
use App\Http\Middleware\CheckLoginMiddleware;
use App\Http\Middleware\MenuMiddleware;
use App\Http\Middleware\NTCPMiddleware;
use App\Http\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
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


//Login Routes
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::middleware(ThrottleRequests::class)->post('/login', [LoginController::class, 'login']);
Route::get('/captcha', [LoginController::class, 'getCaptcha'])->name('captcha');


//Panel Routes
Route::middleware(['auth', MenuMiddleware::class])->middleware(MenuMiddleware::class)->group(function () {
    Route::get('/dateandtime', [DashboardController::class, 'jalaliDateAndTime']);
    Route::get('/date', [DashboardController::class, 'jalaliDate']);
    Route::get('/Profile', [DashboardController::class, 'Profile'])->name('Profile');
    Route::post('/ChangePasswordInc', [DashboardController::class, 'ChangePasswordInc']);
    Route::post('/ChangeUserImage', [DashboardController::class, 'ChangeUserImage']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/Search', [SearchController::class, 'search'])->name('Search');

    Route::middleware(NTCPMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Search Route
        //User Manager
        Route::get('/UserManager', [UserManager::class, 'index'])->name('UserManager');
        Route::get('/GetUserInfo', [UserManager::class, 'getUserInfo'])->name('GetUserInfo');
        Route::Post('/NewUser', [UserManager::class, 'newUser'])->name('NewUser');
        Route::Post('/EditUser', [UserManager::class, 'editUser'])->name('EditUser');
        Route::Post('/ChangeUserActivationStatus', [UserManager::class, 'changeUserActivationStatus'])->name('ChangeUserActivationStatus');
        Route::Post('/ChangeUserNTCP', [UserManager::class, 'ChangeUserNTCP'])->name('ChangeUserNTCP');
        Route::Post('/ResetPassword', [UserManager::class, 'ResetPassword'])->name('ResetPassword');

        //Role Controller
        Route::resource('/Roles', RoleController::class);
        Route::resource('/Permissions', PermissionController::class);

        //Catalogs
        Route::resource('/DocumentTypes', DocumentTypeController::class);
        Route::resource('/AudiosSubjects', AudioSubjectController::class);
        Route::resource('/SubjectFormats', SubjectFormatController::class);
        Route::resource('/SubjectAudiences', SubjectAudienceController::class);
        Route::resource('/Teachers', TeacherController::class);
        Route::resource('/PersonAdjectives', PersonAdjectiveController::class);
        Route::resource('/MultimediaSubjects', MultimediaSubjectController::class);
        Route::resource('/SocialMediaPlatforms', SocialMediaPlatformController::class);

        //Posts
        Route::resource('/Posts', PostController::class);
        Route::delete('/Posts/destroyImage/{id}', [PostController::class, 'destroyImage']);
        Route::resource('/InternationalDocuments', InternationalDocumentController::class);
        Route::delete('/InternationalDocuments/destroyImage/{id}', [InternationalDocumentController::class, 'destroyImage']);
        Route::resource('/ResearchSubjects', ResearchSubjectController::class);
        Route::delete('/ResearchSubjects/destroyImage/{id}', [ResearchSubjectController::class, 'destroyImage']);
        Route::resource('/MediaSubjects', MediaSubjectController::class);
        Route::delete('/MediaSubjects/destroyImage/{id}', [MediaSubjectController::class, 'destroyImage']);
        Route::resource('/Professors', ProfessorController::class);
        Route::delete('/Professors/destroyImage/{id}', [ProfessorController::class, 'destroyImage']);
        Route::resource('/DocumentClasses', DocumentClassController::class);
        Route::resource('/Notes', NoteController::class);

        //Multimedia
        Route::resource('/Audios', AudioController::class);
        Route::resource('/ShortVideos', ShortVideoController::class);
        Route::resource('/PictureAlbum', PictureAlbumController::class);
        Route::resource('/Documentaries', DocumentaryController::class);
        Route::resource('/SocialMedia', SocialMediaController::class);
        Route::delete('/SocialMedia/destroyImage/{id}', [SocialMediaController::class, 'destroyImage']);
        Route::resource('/BookIntroductions', BookIntroductionController::class);
        Route::delete('/BookIntroductions/destroyImage/{id}', [BookIntroductionController::class, 'destroyImage']);
        Route::resource('/SpecialCases', SpecialCaseController::class);

        //Sliders
        Route::resource('/Sliders', SliderController::class);

        //Sliders
        Route::resource('/ContactUs', ContactUsController::class);
        Route::get('/getContactUsHeaders/{id}',[ContactUsController::class,'getContactUsHeadersInfo']);

        //Site Settings
        Route::resource('/SiteSettings', SiteSettingsController::class);


        //Reports
        Route::prefix('BackupDatabase')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index']);
            Route::post('/', [DatabaseBackupController::class, 'createBackup']);
        });
    });
});

