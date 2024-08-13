<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FailedJobController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\OauthAccessTokenController;
use App\Http\Controllers\OauthAuthCodeController;
use App\Http\Controllers\OauthClientController;
use App\Http\Controllers\OauthPersonalAccessClientController;
use App\Http\Controllers\OauthRefreshTokenController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PersonalAccessTokenController;
use App\Http\Controllers\RastreabilidadeController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use App\Http\Controllers\Api\V2\Auth\LoginController;
use App\Http\Controllers\Api\V2\Auth\LogoutController;
use App\Http\Controllers\Api\V2\Auth\RegisterController;
use App\Http\Controllers\Api\V2\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V2\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V2\MeController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v2')->middleware('json.api')->group(function () {
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->middleware('auth:api');
    Route::post('/register', RegisterController::class);
    Route::post('/password-forgot', ForgotPasswordController::class);
    Route::post('/password-reset', ResetPasswordController::class)->name('password.reset');
});

JsonApiRoute::server('v2')->prefix('v2')->resources(function (ResourceRegistrar $server) {
    $server->resource('users', JsonApiController::class);
    Route::get('me', [MeController::class, 'readProfile']);
    Route::patch('me', [MeController::class, 'updateProfile']);
});
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('estoques', EstoqueController::class);
Route::apiResource('failed_jobs', FailedJobController::class);
Route::apiResource('migrations', MigrationController::class);
Route::apiResource('oauth_access_tokens', OauthAccessTokenController::class);
Route::apiResource('oauth_auth_codes', OauthAuthCodeController::class);
Route::apiResource('oauth_clients', OauthClientController::class);
Route::apiResource('oauth_personal_access_clients', OauthPersonalAccessClientController::class);
Route::apiResource('oauth_refresh_tokens', OauthRefreshTokenController::class);
Route::apiResource('password_resets', PasswordResetController::class);
Route::apiResource('personal_access_tokens', PersonalAccessTokenController::class);
Route::apiResource('rastreabilidades', RastreabilidadeController::class);
Route::apiResource('users', UserController::class);
