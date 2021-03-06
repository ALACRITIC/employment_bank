<?php

Route::get('/', ['as'=>'home', 'uses' => 'WebfrontController@getHome']);

Route::post('api/fetch/district', 	['as' 	=> 'district.by.state', 'uses'	=> 'RestController@getDistricts']);
Route::get('test', ['as'=>'test', function () {
    return view('webfront.register');
}]);

//Admin Section
Route::get('admin/login', ['as' => 'admin.login', 'uses' => 'Auth\AdminAuthController@getLogin']);
Route::post('admin/login', ['as' => 'admin.login', 'uses' => 'Auth\AdminAuthController@postLogin']);
Route::get('admin/register', ['as' => 'admin.register', 'uses' => 'AdminHomeController@showRegister']);
Route::post('admin/register', ['as' => 'admin.register', 'uses' => 'AdminHomeController@doRegister']);

Route::group(['prefix'=>'admin'], function() {

    Route::get('/logout', array('as' => 'admin.logout', 'uses' => 'Auth\AdminAuthController@getLogout'));

    Route::group(['middleware'=>['auth.admin']], function() {

        Route::get('/dashboard', ['as'=>'admin.home', function () {
            return view('admin.layouts.default'); }]);
        Route::get('/candidates/applications/recieved', ['as'=>'admin.applications_recieved', 'uses' => 'AdminHomeController@applications_recieved']);
        Route::get('/candidates/view/i_card/{candidate_id}', ['as'=>'admin.view.i_card', 'uses' => 'RestController@viewIdentityCard']);
        Route::get('/candidates/view/profile/{candidate_id}', ['as'=>'admin.view.profile', 'uses' => 'RestController@viewCandidateProfile']);
        Route::get('/candidates/verify/profile/{candidate_id}', ['as'=>'admin.verify.profile', 'uses' => 'AdminHomeController@verifyCandidate']);
        Route::get('/candidates/applications/verified', ['as'=>'admin.applications_verified', 'uses' => 'AdminHomeController@applications_verified']);
        Route::get('/candidates/suspend/profile/{candidate_id}', ['as'=>'admin.suspend.profile', 'uses' => 'AdminHomeController@suspendCandidate']);
        Route::get('/candidates/applications/suspended', ['as'=>'admin.applications_suspended', 'uses' => 'AdminHomeController@applications_suspended']);

        //Employer Module on Admin Panel
        Route::get('/employers/list/all', ['as'=>'admin.employer_list_all', 'uses' => 'AdminHomeController@employerListAll']);
        Route::get('/employers/view/profile/{employer_id}', ['as'=>'admin.employer_view_profile', 'uses' => 'AdminHomeController@viewEmployerProfile']);

        Route::get('/employers/verify/{id}', ['as'=>'admin.employer_verify', 'uses' => 'AdminHomeController@verifyEmployer']);

        //Posted Job Module on Admin Panel
        Route::get('/job/list/all', ['as'=>'admin.job_list_all', 'uses' => 'AdminHomeController@jobListAll']);
        Route::get('/job/view/{id}', ['as'=>'admin.job_view', 'uses' => 'AdminHomeController@viewJob']);
        Route::get('/job/update_status/{id}', ['as'=>'admin.job_update_status', 'uses' => 'AdminHomeController@jobUpdateStatus']);
        Route::post('/job/update_status/{id}', ['as'=>'admin.job_update_status', 'uses' => 'AdminHomeController@jobUpdateStatus']);

        //Admin List view proposedon Admin Panel
        Route::get('/admins/accounts/view/{id}', ['as'=>'admin.admins_accounts.view', 'uses' => 'AdminHomeController@adminsAccounts']);

    });

});

Route::group(['middleware'=>['auth.admin']], function() {
	//Masterentries
	 Route::group(['prefix'=>'master', 'namespace'=>'Master'], function() {

    Route::resource('/industrytypes', 'IndustryTypeController', ['except' => ['show']]);
    Route::resource('/departmenttypes', 'DepartmentTypeController', ['except' => ['show']]);
    Route::resource('/exams', 'ExamController', ['except' => ['show']]);
    Route::resource('/boards', 'BoardController', ['except' => ['show']]);
    Route::resource('/subjects', 'SubjectsController', ['except' => ['show']]);
    Route::resource('/languages', 'LanguagesController', ['except' => ['show']]);
    Route::resource('/casts', 'CasteController', ['except' => ['show']]);
    Route::resource('/states', 'StateController', ['except' => ['show']]);
    Route::resource('/districts', 'DistrictController', ['except' => ['show']]);
    Route::resource('/proof_details', 'ProofDetailsController', ['except' => ['show']]);

	 });
});

//employer Section
Route::get('employer/login', ['as' => 'employer.login', 'uses' => 'Auth\EmployerAuthController@getLogin']);
Route::post('employer/login', ['as' => 'employer.login', 'uses' => 'Auth\EmployerAuthController@postLogin']);
Route::get('employer/register', ['as' => 'employer.register', 'uses' => 'EmployerHomeController@showRegister']);
Route::post('employer/register', ['as' => 'employer.register', 'uses' => 'EmployerHomeController@doRegister']);
Route::get('employer/activate_via_otp', ['as' => 'employer.activate.otp', 'uses' => 'Auth\EmployerAuthController@showActivate']);
Route::post('employer/activate_via_otp', ['as' => 'employer.activate.otp', 'uses' => 'Auth\EmployerAuthController@doActivate']);

Route::group(['prefix'=>'employer'], function() {

    Route::get('/logout', array('as' => 'employer.logout', 'uses' => 'Auth\EmployerAuthController@getLogout'));

    Route::group(['middleware'=>['auth.employer']], function() {

        Route::get('/job/create', ['as'=>'employer.create_job', 'uses' => 'EmployerHomeController@createJob']);
        Route::post('/job/create', ['as'=>'employer.create_job', 'uses' => 'EmployerHomeController@storeJob']);
        Route::get('/job/list', ['as'=>'employer.list_job', 'uses' => 'EmployerHomeController@listJobs']);
        Route::get('/job/view/{num}', ['as'=>'employer.view_job', 'uses' => 'EmployerHomeController@viewJob']);

        Route::get('/job/update_status/disabled/{num}', ['as'=>'employer.update_job_status_disabled', 'uses' => 'EmployerHomeController@updateJobStatus']);
        Route::get('/job/update_status/active/{num}', ['as'=>'employer.update_job_status_active', 'uses' => 'EmployerHomeController@updateJobStatus']);
        Route::get('/job/update_status/filled_up/{num}', ['as'=>'employer.update_job_status_filled_up', 'uses' => 'EmployerHomeController@updateJobStatus']);


        Route::get('/job/edit/{id}', ['as'=>'employer.edit_job', 'uses' => 'EmployerHomeController@editJob']);
        Route::put('/job/edit/{id}', ['as'=>'employer.update_job', 'uses' => 'EmployerHomeController@updateJob']);
        Route::delete('/job/delete/{id}', ['as'=>'employer.delete_job', 'uses' => 'EmployerHomeController@deleteJob']);

        Route::get('/documents_uploaded/list', ['as'=>'employer.documents_uploaded_index', 'uses' => 'EmployerHomeController@showDocumentLists']);
        Route::get('/documents_uploaded/form', ['as'=>'employer.documents_uploaded_form', 'uses' => 'EmployerHomeController@showDocumentUploadForm']);
        Route::post('/documents_uploaded/form', ['as'=>'employer.documents_uploaded_form', 'uses' => 'EmployerHomeController@doDocumentUploadForm']);
        Route::get('/documents_uploaded/view/{id}', ['as'=>'employer.documents_uploaded_view', 'uses' => 'EmployerHomeController@viewDocument']);
        Route::delete('/documents_uploaded/delete/{id}', ['as'=>'employer.documents_uploaded_delete', 'uses' => 'EmployerHomeController@deleteDocument']);
        
        
        Route::get('/dashboard', ['as'=>'employer.home', 'uses' => 'EmployerHomeController@showHome']);
        Route::get('/profile', ['as'=>'employer.profile', 'uses' => 'EmployerHomeController@showProfile']);
        Route::post('/profile', ['as'=>'employer.profile', 'uses' => 'EmployerHomeController@updateProfile']);
        //Route::get('/candidates/applications/recieved', ['as'=>'admin.applications_recieved', 'uses' => 'AdminHomeController@applications_recieved']);
    });

});

//Public webfront routes
Route::get('/register', ['as' => 'candidate.register', 'uses' => 'WebfrontController@showRegister']);
Route::post('/register', ['as' => 'candidate.store', 'uses' => 'WebfrontController@doRegister']);

//Candidate Section
Route::get('/login', ['as' => 'candidate.login', 'uses' => 'Auth\CandidateAuthController@getLogin']);
Route::post('/login', ['as' => 'candidate.login', 'uses' => 'Auth\CandidateAuthController@postLogin']);
Route::get('candidate/activate_via_otp', ['as' => 'candidate.activate.otp', 'uses' => 'Auth\CandidateAuthController@showActivate']);
Route::post('candidate/activate_via_otp', ['as' => 'candidate.activate.otp', 'uses' => 'Auth\CandidateAuthController@doActivate']);

Route::group(['middleware'=>['auth.candidate'], 'prefix'=>'candidate'], function() {

    Route::get('/logout', array('as' => 'candidate.logout', 'uses' => 'Auth\CandidateAuthController@getLogout'));
    Route::get('/home', ['as' => 'candidate.home', 'uses' => 'CandidateHomeController@showHome']);
    Route::get('/create_resume', ['as' => 'candidate.create.resume', 'uses' => 'CandidateHomeController@createResume']);
    Route::post('/create_resume', ['as' => 'candidate.store.resume', 'uses' => 'CandidateHomeController@storeResume']);
    Route::get('/edit_resume', ['as' => 'candidate.edit.resume', 'uses' => 'CandidateHomeController@editResume']);
    Route::post('/edit_resume', ['as' => 'candidate.update.resume', 'uses' => 'CandidateHomeController@updateResume']);
    
    Route::get('/create_edu_details', ['as' => 'candidate.create.edu_details', 'uses' => 'CandidateHomeController@createEdu_details']);
    Route::post('/create_edu_details', ['as' => 'candidate.store.edu_details', 'uses' => 'CandidateHomeController@storeEdu_details']);
    Route::get('/edit_edu_details', ['as' => 'candidate.edit.edu_details', 'uses' => 'CandidateHomeController@editEdu_details']);
    Route::post('/edit_edu_details', ['as' => 'candidate.update.edu_details', 'uses' => 'CandidateHomeController@updateEdu_details']);
    
    Route::get('/create_experience_details', ['as' => 'candidate.create.exp_details', 'uses' => 'CandidateHomeController@createExperience_details']);
    Route::post('/create_experience_details', ['as' => 'candidate.store.exp_details', 'uses' => 'CandidateHomeController@storeExperience_details']);
    
    Route::get('/edit_experience_details', ['as' => 'candidate.edit.exp_details', 'uses' => 'CandidateHomeController@editExperience_details']);
    Route::post('/edit_experience_details', ['as' => 'candidate.update.exp_details', 'uses' => 'CandidateHomeController@updateExperience_details']);
    
    Route::get('/create_language_details', ['as' => 'candidate.create.language_details', 'uses' => 'CandidateHomeController@createLanguage_details']);
    Route::post('/create_language_details', ['as' => 'candidate.store.language_details', 'uses' => 'CandidateHomeController@storeLanguage_details']);

    Route::get('/edit_language_details', ['as' => 'candidate.edit.language_details', 'uses' => 'CandidateHomeController@editLanguage_details']);
    Route::post('/edit_language_details', ['as' => 'candidate.update.language_details', 'uses' => 'CandidateHomeController@updateLanguage_details']);

    Route::get('/get_identitycard', ['as' => 'candidate.get.i_card', 'uses' => 'CandidateHomeController@get_identitycard']);
    Route::get('/files/{file}/preview', ['as' => 'candidate.image_preview', 'uses' => 'CandidateHomeController@image_preview']);
    Route::get('/files/{file}/{year}/{id}/{file_name}/preview', ['as' => 'candidate.file_preview', 'uses' => 'CandidateHomeController@file_preview']);

});

Route::controllers([
  //Public webfront routes
	//'ww' => 'WebfrontController'
]);
