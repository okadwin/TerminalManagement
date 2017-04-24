<?php

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

Route::group(['middleware' => ['User','Permission']], function () {
    Route::get('Agent', 'AgentController@AgentIndex');
    Route::post('Agent', 'AgentController@AgentSelect');
    Route::get('AgentAdd', 'AgentController@AgentAddView');
    Route::post('AgentAdd', 'AgentController@AgentAdd');
    Route::get('AgentEdit/{id}', 'AgentController@AgentEdit')->name('AgentEdit');
    Route::post('AgentEdit/{id}', 'AgentController@AgentUpdate');
    Route::get('AgentExport', 'AgentController@AgentExport');

    Route::get('Shop', 'ShopController@ShopIndex');
    Route::post('Shop', 'ShopController@ShopSelect');
    Route::get('ShopEdit/{id}', 'ShopController@ShopEdit')->name('ShopEdit');
    Route::post('ShopEdit/{id}', 'ShopController@ShopUpdate');
    Route::get('ShopAdd', 'ShopController@ShopAddView');
    Route::post('ShopAdd', 'ShopController@ShopAdd');

    Route::get('TerminalTypeAPI/{Manufacture}','TerminalController@API');
    Route::any('TerminalType','TerminalController@Type');
    Route::get('TerminalTypeAdd','TerminalController@TypeAddView');
    Route::post('TerminalTypeAdd','TerminalController@TypeAdd');
    Route::get('TerminalTypeEdit/{id}','TerminalController@TypeEdit');
    Route::post('TerminalTypeEdit/{id}','TerminalController@TypeUpdate');
    //Route::post('TerminalType','TerminalController@TypeSelect');
    //Route::get('TerminalIn','TerminalController@TerminalIn');
    Route::post('TerminalInAdd','TerminalController@TerminalAdd');
    Route::any('TerminalIn','TerminalController@TerminalIn');
    Route::get('TerminalInEdit/{id}','TerminalController@TerminalInEdit');
    Route::post('TerminalInUpdate/{id}','TerminalController@TerminalInUpdate');
    Route::get('TerminalOut','TerminalController@TerminalOut');
    Route::post('TerminalOut','TerminalController@TerminalOutSelect');
    Route::post('TerminalOutAdd','TerminalController@TerminalOutAdd');
    Route::get('TerminalOutEdit/{id}','TerminalController@TerminalOutEdit');
    Route::post('TerminalOutUpdate/{id}','TerminalController@TerminalOutUpdate');
    Route::get('TerminalList','TerminalController@TerminalList');
    Route::post('TerminalList','TerminalController@TerminalListSelect');

    Route::get('ChannelAdd','ChannelController@AddView');
    Route::post('ChannelAdd','ChannelController@Add');
    Route::get('Channel','ChannelController@Index');
    Route::post('Channel','ChannelController@Select');
    Route::get('ChannelEdit/{id}','ChannelController@Edit');
    Route::post('ChannelEdit/{id}','ChannelController@Update');


    Route::get('User/Login','UserController@LoginView');
    Route::get('User','UserController@Index');
    Route::post('User','UserController@Select');
    Route::get('UserEdit/{id}','UserController@Edit');
    Route::post('UserEdit/{id}','UserController@Update');
    Route::get('UserAdd','UserController@AddView');
    Route::post('UserAdd','UserController@Add');
    Route::get('UserDelete/{id}','UserController@Delete');

    Route::get('TransactionInto','TransactionController@Into');
    Route::post('TransactionInto','TransactionController@Into');
    Route::get('TransactionList','TransactionController@TransactionList');
    Route::post('TransactionList','TransactionController@TransactionList');

    Route::get('ProfitYlz','ProfitController@Ylz');
    Route::post('ProfitYlz','ProfitController@Ylz');
    Route::get('ProfitAgent','ProfitController@Agent');
    Route::post('ProfitAgent','ProfitController@Agent');

    Route::get('ReportTerminal','ReportController@Terminal');
    Route::post('ReportTerminal','ReportController@Terminal');
    Route::get('ReportZero','ReportController@Zero');
    Route::post('ReportZero','ReportController@Zero');

    Route::get('/','IndexController@Index');
});



Route::get('API','TerminalController@API');
Route::get('User/Login','UserController@LoginView');
Route::get('User/Logout','UserController@Logout');
Route::post('User/Login','UserController@LoginCheck');


