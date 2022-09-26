<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\AttachmentController;


    

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/redirectAuthenticatedUsers', [RedirectAuthenticatedUsersController::class, 'home'])->name('redirectAuthenticatedUsers');

    Route::group(['middleware' => ['checkRole:admin']],function(){
        Route::get('/adminDashboard', function () {
            return view('admin.adminDashboard');
        })->name('adminDashboard');

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
        Route::post('/project/catgory/create', [ProjectCategoryController::class, 'store'])->name('createProjectCategory');
        Route::get('/project/catgory/update/{id}', [ProjectCategoryController::class, 'edit'])->name('updateProjectCategoryForm');
        Route::PUT('/project/catgory/updated/{id}', [ProjectCategoryController::class, 'update'])->name('updateProjectCategory');
        Route::DELETE('/project/catgory/delete/{id}', [ProjectCategoryController::class, 'destroy'])->name('deleterProjectCategory');


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


    
});