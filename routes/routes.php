<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\WorkreportController;


    

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/redirectAuthenticatedUsers', [RedirectAuthenticatedUsersController::class, 'home'])->name('redirectAuthenticatedUsers');

    

    Route::group(['middleware' => ['checkRole:admin']],function(){
        Route::get('/adminDashboard', function () {
            return view('admin.adminDashboard');
        })->name('adminDashboard');

        Route::get('/adminProfile', [UserController::class, 'adminProfile'])->name('adminProfile');
        Route::PUT('/updateAdminProfile', [UserController::class, 'updateAdminProfile'])->name('updateAdminProfile');

        // User Routings

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/user/create', [UserController::class, 'create'])->name('createUserForm');
        Route::post('/user/create', [UserController::class, 'store'])->name('createUser');
        Route::post('/checkusername', [UserController::class, 'checkusername'])->name('checkusername');
        Route::get('/user/update/{id}', [UserController::class, 'edit'])->name('updateUserForm');
        Route::PUT('/user/update/{id}', [UserController::class, 'update'])->name('updateUser');
        Route::DELETE('/user/{id}', [UserController::class, 'destroy'])->name('deleterUser');
        Route::post('/activeUser', [UserController::class, 'activeUser'])->name('activeUser');

        // Project Category Routings

        Route::get('/projects/category', [ProjectCategoryController::class, 'index'])->name('projectCategory');
        Route::post('/project/caetgory/create', [ProjectCategoryController::class, 'store'])->name('createProjectCategory');
        Route::get('/project/category/update/{id}', [ProjectCategoryController::class, 'edit'])->name('updateProjectCategoryForm');
        Route::PUT('/project/category/updated/{id}', [ProjectCategoryController::class, 'update'])->name('updateProjectCategory');
        Route::DELETE('/project/category/delete/{id}', [ProjectCategoryController::class, 'destroy'])->name('deleterProjectCategory');


        // Project Routings

        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        // Route::get('/projects/(filter_query)', [ProjectController::class, 'project_filter'])->name('FilterProject');
        Route::get('/project/create', [ProjectController::class, 'create'])->name('createProjectForm');
        Route::post('/project/create', [ProjectController::class, 'store'])->name('createProject');
        Route::get('/project/update/{id}', [ProjectController::class, 'edit'])->name('updateProjectForm');
        Route::PUT('/project/update/{id}', [ProjectController::class, 'update'])->name('updateProject');
        Route::DELETE('/project/delete/{id}', [ProjectController::class, 'destroy'])->name('deleterProject');
        
        // Attachemnt Routing

        Route::post('/deleterAttachement', [AttachmentController::class, 'deleteattachement'])->name('deleterAttachement');
        
    });

    // User Role pages

    Route::group(['middleware' => ['checkRole:user']],function(){
        Route::get('/userDashboard', function () {
            return view('user.userDashboard');
        })->name('userDashboard');

        Route::get('/userProfile', [UserController::class, 'userProfile'])->name('userProfile');
        Route::PUT('/updateUserProfile', [UserController::class, 'updateUserProfile'])->name('updateUserProfile');

        // User Project Routing
        Route::get('/userprojects', [ProjectController::class, 'userprojects'])->name('userprojects');
        Route::get('/view-project/{id}', [ProjectController::class, 'show'])->name('viewprojects');

        // User Workreport
        Route::get('/workreport', [WorkreportController::class, 'UserWorkReport'])->name('workreport');
        Route::get('/workreport/create', [WorkreportController::class, 'create'])->name('WorkReportCreateForm');
        Route::post('/workreport/create', [WorkreportController::class, 'store'])->name('WorkReportCreate');
        Route::DELETE('/workreport/delete/{id}', [WorkreportController::class, 'destroy'])->name('DeleteWorkReport');
        
    });
});