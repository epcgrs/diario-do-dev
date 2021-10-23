<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
     return response()->json([
         'version' => env('APP_VERSION'),
         'author' => [
             'name' => 'Emmanuel P. Pires',
             'email' => 'contato@emmanuelpcg.com'
         ]
     ]);
});


/** ____________________________________________________________
 *
 *                  Rotas Namespace API
 * _____________________________________________________________
 */
Route::group(['namespace' => 'API'], function() {


    /** ____________________________________________________________
     *
     *                  Rotas Usuários
     * _____________________________________________________________
     */
    Route::prefix('users')->group(function() {
        Route::post('/register', 'UserController@store')->name('api.users.register');
        Route::post('/logout', 'UserController@logout')->name('api.users.logout');
        Route::post('/login', 'UserController@login')->name('api.users.login');
    });

    /** ____________________________________________________________
     *
     *                  Rotas Provider Auth
     * _____________________________________________________________
     */
    Route::prefix('github-provider')->group(function() {
        Route::get('redirect', 'SocialController@redirect')->name('api.users.github.redirect');
        Route::get('callback', 'SocialController@callback')->name('api.users.github.callback');
    });


    /** ____________________________________________________________
     *
     *                  Rotas Conteúdos
     * _____________________________________________________________
     */
    Route::prefix('contents')->group(function() {
        Route::get('home', 'ContentController@paginateMaster')->name('api.content.paginate.master');

        Route::post('new', 'ContentController@save')->name('api.content.paginate.master');
    });


    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::get('/user-info', function (Request $request) {
            return response()->json($request->user());
        });
    });

});
