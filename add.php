<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 10;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_user')) {
            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);
            if ($staff) {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'phone_number' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'email_address' => array(
                        'unique' => 'user'
                    ),
                ));
            }
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 1;
                        break;
                    case 3:
                        $accessLevel = 2;
                        break;
                    case 4:
                        $accessLevel = 3;
                        break;
                    case 5:
                        $accessLevel = 3;
                        break;
                }
                try {

                    // $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

                    if ($staff) {
                        $user->updateRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'site_id' => Input::get('site_id'),
                        ), $_GET['staff_id']);

                        $successMessage = 'Account Updated Successful';
                    } else {
                        $user->createRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'create_on' => date('Y-m-d'),
                            'last_login' => '',
                            'status' => 1,
                            'user_id' => $user->data()->id,
                            'site_id' => Input::get('site_id'),
                            'count' => 0,
                            'pswd' => 0,
                        ));
                        $successMessage = 'Account Created Successful';
                    }

                    Redirect::to('info.php?id=1&status=1');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('position', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Position Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id']);
                    if ($site) {
                        $user->updateRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $site[0]['id']);
                        $successMessage = 'Site Successful Updated';
                    } else {
                        $user->createRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));
                        $successMessage = 'Site Successful Added';
                    }

                    // $user->visit_delete1($_GET['site_id'], Input::get('visit_date'), $_GET['site_id'], $user->data()->id, $_GET['site_id'], $eligible, $sequence, $visit_code, $visit_name);

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_client')) {
            $validate = $validate->check($_POST, array(
                'date_registered' => array(
                    'required' => true,
                ),
                'firstname' => array(
                    'required' => true,
                ),
                'middlename' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
                'sex' => array(
                    'required' => true,
                ),
                'site' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {
                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $years = $user->dateDiffYears(Input::get('date_registered'), Input::get('dob'));

                    if ($clients) {
                        $user->updateRecord('clients', array(
                            'sequence' => -2,
                            'visit_code' => 'RV',
                            'visit_name' => 'Registration Visit',
                            'date_registered' => Input::get('date_registered'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => Input::get('age'),
                            'years' => $years,
                            'ctc_id' => Input::get('ctc_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => 0,
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'pay_services' => Input::get('pay_services'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'respondent' => Input::get('respondent'),
                            'comments' => Input::get('comments'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', -2);

                        if ($visit) {
                            $user->updateRecord('visit', array(
                                'sequence' => -2,
                                'visit_code' => 'RV',
                                'visit_name' => 'Registration Visit',
                                'respondent' => Input::get('respondent'),
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('date_registered'),
                                'visit_date' => Input::get('date_registered'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => Input::get('site'),
                                'table_id' => $clients[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => Input::get('site'),
                            ), $visit[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'sequence' => -2,
                                'visit_code' => 'RV',
                                'visit_name' => 'Registration Visit',
                                'respondent' => Input::get('respondent'),
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('date_registered'),
                                'visit_date' => Input::get('date_registered'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => Input::get('site'),
                                'table_id' => $clients[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => Input::get('site'),
                            ));
                        }

                        $successMessage = 'Client Updated Successful';
                    } else {

                        $std_id = $override->getNews('study_id', 'site_id', Input::get('site'), 'status', 0)[0];

                        $user->createRecord('clients', array(
                            'sequence' => -2,
                            'visit_code' => 'RV',
                            'visit_name' => 'Registration Visit',
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => $std_id['study_id'],
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => Input::get('age'),
                            'years' => $years,
                            'ctc_id' => Input::get('ctc_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => 0,
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'pay_services' => Input::get('pay_services'),
                            'comments' => Input::get('comments'),
                            'respondent' => Input::get('respondent'),
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => Input::get('site'),
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => -2,
                            'visit_code' => 'RV',
                            'visit_name' => 'Registration Visit',
                            'respondent' => Input::get('respondent'),
                            'study_id' => $std_id['study_id'],
                            'pid' => $std_id['study_id'],
                            'expected_date' => Input::get('date_registered'),
                            'visit_date' => Input::get('date_registered'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => Input::get('site'),
                            'table_id' => $last_row['id'],
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => Input::get('site'),
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_tb')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'patient_status' => array(
                    'required' => true,
                ),
                'work_place' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('individual', 'status', 1, 'patient_id', $_GET['cid']);
                $rbg_done = 0;
                $enrolled = 0;
                $end_study = 0;
                if (Input::get('rbg_done')) {
                    $rbg_done = Input::get('rbg_done');
                }

                if ($individual) {

                    $user->updateRecord('individual', array(
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'TB Patients (TB CLINIC) Successful Updated';
                } else {
                    $user->createRecord('individual', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'TB Patients (TB CLINIC) Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients['id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_hiv')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'patient_status' => array(
                    'required' => true,
                ),
                'work_place' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('individual', 'status', 1, 'patient_id', $_GET['cid']);
                $rbg_done = 0;
                $enrolled = 0;
                $end_study = 0;
                if (Input::get('rbg_done')) {
                    $rbg_done = Input::get('rbg_done');
                }

                if ($individual) {

                    $user->updateRecord('individual', array(
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'TB Patients (TB CLINIC) Successful Updated';
                } else {
                    $user->createRecord('individual', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'TB Patients (TB CLINIC) Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients['id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_diabetic')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'patient_status' => array(
                    'required' => true,
                ),
                'work_place' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('individual', 'status', 1, 'patient_id', $_GET['cid']);
                $rbg_done = 0;
                $enrolled = 0;
                $end_study = 0;
                if (Input::get('rbg_done')) {
                    $rbg_done = Input::get('rbg_done');
                }

                if ($individual) {

                    $user->updateRecord('individual', array(
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'TB Patients (TB CLINIC) Successful Updated';
                } else {
                    $user->createRecord('individual', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'patient_status' => Input::get('patient_status'),
                        'work_place' => Input::get('work_place'),
                        'work_place_other' => Input::get('work_place_other'),
                        'referred_by' => Input::get('referred_by'),
                        'referred_other' => Input::get('referred_other'),
                        'dot_options' => Input::get('dot_options'),
                        'classification' => Input::get('classification'),
                        'sputum_smear' => Input::get('sputum_smear'),
                        'sputum_gene_xpert' => Input::get('sputum_gene_xpert'),
                        'started_tb' => Input::get('started_tb'),
                        'ctc_date' => Input::get('ctc_date'),
                        'hiv_status' => Input::get('hiv_status'),
                        'diabetic_status' => Input::get('diabetic_status'),
                        'rbg_done' => $rbg_done,
                        'vaccinations_status' => Input::get('vaccinations_status'),
                        'vaccination_date' => Input::get('vaccination_date'),
                        'tuberculosis_outcome' => Input::get('tuberculosis_outcome'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'TB Patients (TB CLINIC) Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients['id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_screening')) {
            $validate = $validate->check($_POST, array(
                'screening_date' => array(
                    'required' => true,
                ),
                'above18' => array(
                    'required' => true,
                ),
                'new_tb' => array(
                    'required' => true,
                ),
                'conset' => array(
                    'required' => true,
                ),
                'start_anti_b' => array(
                    'required' => true,
                ),
                'diabetes_type1' => array(
                    'required' => true,
                ),
                'extrapulmonary_tb' => array(
                    'required' => true,
                ),
                'mdr_xdr' => array(
                    'required' => true,
                ),
                'stay' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                $screening = $override->get3('screening', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', -1);
                $eligible = 0;

                if ((Input::get('above18') == 1 && Input::get('new_tb') == 1 && Input::get('conset') == 1 && Input::get('start_anti_b') == 1  && Input::get('diabetes_type1') == 2 && Input::get('extrapulmonary_tb') == 2 && Input::get('mdr_xdr') == 2 && Input::get('stay') == 2)) {
                    $eligible = 1;
                } else {
                    $eligible = 2;
                }

                if (Input::get('screening_date') < $clients[0]['date_registered']) {
                    $errorMessage = 'Screaning Date Can not be less than Registration date';
                } elseif (Input::get('conset') == 2 && !empty(trim(Input::get('conset_date')))) {
                    $errorMessage = 'Please Remove Screening date before Submit again';
                } elseif (Input::get('new_tb') == 2 && !empty(trim(Input::get('new_tb_date')))) {
                    $errorMessage = 'Please Remove Diagnosed TB date before Submit again';
                } elseif (Input::get('start_anti_b') == 2 && !empty(trim(Input::get('start_anti_b_date')))) {
                    $errorMessage = 'Please Remove Started Anti-TB date before Submit again';
                } else {

                    if ($screening) {
                        $user->updateRecord('screening', array(
                            'sequence' => -1,
                            'visit_code' => 'Sv',
                            'visit_name' => 'Screening Visit',
                            'screening_date' => Input::get('screening_date'),
                            'above18' => Input::get('above18'),
                            'new_tb' => Input::get('new_tb'),
                            'new_tb_date' => Input::get('new_tb_date'),
                            'conset' => Input::get('conset'),
                            'conset_date' => Input::get('conset_date'),
                            'start_anti_b' => Input::get('start_anti_b'),
                            'start_anti_b_date' => Input::get('start_anti_b_date'),
                            'diabetes_type1' => Input::get('diabetes_type1'),
                            'extrapulmonary_tb' => Input::get('extrapulmonary_tb'),
                            'mdr_xdr' => Input::get('mdr_xdr'),
                            'stay' => Input::get('stay'),
                            'comments' => Input::get('comments'),
                            'eligible' => $eligible,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $screening[0]['id']);

                        $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', -1);

                        if ($visit) {
                            $user->updateRecord('visit', array(
                                'sequence' => -1,
                                'visit_code' => 'Sv',
                                'visit_name' => 'Screening Visit',
                                'respondent' => $clients[0]['respondent'],
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('screening_date'),
                                'visit_date' => Input::get('screening_date'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => $clients[0]['site_id'],
                                'table_id' => $screening[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients[0]['site_id'],
                            ), $visit[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'sequence' => -1,
                                'visit_code' => 'Sv',
                                'visit_name' => 'Screening Visit',
                                'respondent' => $clients[0]['respondent'],
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('screening_date'),
                                'visit_date' => Input::get('screening_date'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => $clients[0]['site_id'],
                                'table_id' => $screening[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients[0]['site_id'],
                            ));
                        }

                        $successMessage = 'Screening  Successful Updated';
                    } else {
                        $user->createRecord('screening', array(
                            'sequence' => -1,
                            'visit_code' => 'Sv',
                            'visit_name' => 'Screening Visit',
                            'pid' => $clients[0]['study_id'],
                            'study_id' => $clients[0]['study_id'],
                            'screening_date' => Input::get('screening_date'),
                            'above18' => Input::get('above18'),
                            'new_tb' => Input::get('new_tb'),
                            'new_tb_date' => Input::get('new_tb_date'),
                            'conset' => Input::get('conset'),
                            'conset_date' => Input::get('conset_date'),
                            'start_anti_b' => Input::get('start_anti_b'),
                            'start_anti_b_date' => Input::get('start_anti_b_date'),
                            'diabetes_type1' => Input::get('diabetes_type1'),
                            'extrapulmonary_tb' => Input::get('extrapulmonary_tb'),
                            'mdr_xdr' => Input::get('mdr_xdr'),
                            'stay' => Input::get('stay'),
                            'comments' => Input::get('comments'),
                            'eligible' => $eligible,
                            'status' => 1,
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ));

                        $last_row = $override->lastRow('screening', 'id')[0];

                        $user->createRecord('visit', array(
                            'sequence' => -1,
                            'visit_code' => 'Sv',
                            'visit_name' => 'Screening Visit',
                            'respondent' => $clients[0]['respondent'],
                            'study_id' => $clients[0]['study_id'],
                            'pid' => $clients[0]['study_id'],
                            'expected_date' => Input::get('screening_date'),
                            'visit_date' => Input::get('screening_date'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => $clients[0]['site_id'],
                            'table_id' => $last_row['id'],
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ));

                        $successMessage = 'Screening  Successful Added';
                    }

                    $user->updateRecord('clients', array(
                        'screened' => 1,
                        'eligible' => $eligible,
                    ), $clients[0]['id']);

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_enrollment')) {
            $validate = $validate->check($_POST, array(
                'enrollment_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);
                $screening = $override->get3('screening', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', -1);
                $enrollment = $override->get3('enrollment', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', 0);
                if ($enrollment) {
                    $user->updateRecord('enrollment', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'screening_id' => $screening[0]['id'],
                        'pid' => $clients[0]['study_id'],
                        'study_id' => $clients[0]['study_id'],
                        'enrollment_date' => Input::get('enrollment_date'),
                        'comments' => Input::get('comments'),
                        'patient_id' => $clients[0]['id'],
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ), $enrollment[0]['id']);

                    $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', 0);

                    if ($visit) {
                        $user->updateRecord('visit', array(
                            'sequence' => 0,
                            'visit_code' => 'EV',
                            'visit_name' => 'Enrolment Visit',
                            'respondent' => $clients[0]['respondent'],
                            'study_id' => $clients[0]['study_id'],
                            'pid' => $clients[0]['study_id'],
                            'expected_date' => Input::get('enrollment_date'),
                            'visit_date' => Input::get('enrollment_date'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => $clients[0]['site_id'],
                            'table_id' => $enrollment[0]['id'],
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ), $visit[0]['id']);
                    } else {
                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'visit_code' => 'EV',
                            'visit_name' => 'Enrolment Visit',
                            'respondent' => $clients[0]['respondent'],
                            'study_id' => $clients[0]['study_id'],
                            'pid' => $clients[0]['study_id'],
                            'expected_date' => Input::get('enrollment_date'),
                            'visit_date' => Input::get('enrollment_date'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => $clients[0]['site_id'],
                            'table_id' => $enrollment[0]['id'],
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ));
                    }

                    $successMessage = 'Enrollment  Successful Updated';
                } else {
                    $user->createRecord('enrollment', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'screening_id' => $screening[0]['id'],
                        'pid' => $clients[0]['study_id'],
                        'study_id' => $clients[0]['study_id'],
                        'enrollment_date' => Input::get('enrollment_date'),
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'patient_id' => $clients[0]['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ));

                    $user->createRecord('visit', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'respondent' => $clients[0]['respondent'],
                        'study_id' => $clients[0]['study_id'],
                        'pid' => $clients[0]['study_id'],
                        'expected_date' => Input::get('enrollment_date'),
                        'visit_date' => Input::get('enrollment_date'),
                        'visit_status' => 1,
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'facility_id' => $clients[0]['site_id'],
                        'table_id' => $enrollment[0]['id'],
                        'patient_id' => $clients[0]['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ));

                    $successMessage = 'Enrollment  Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients[0]['id']);

                // $user->visit_delete1($clients['id'], Input::get('enrollment_date'), $clients['study_id'], $user->data()->id, $clients['site_id'], $eligible, 0, $visit_code, $visit_name, $clients['respondent'], 1, $clients['site_id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_facility')) {
            $validate = $validate->check($_POST, array(
                'extraction_date' => array(
                    'required' => true,
                ),
                'month_name' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {

                $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];

                $facility0 = $override->get3('facility', 'status', 1, 'site_id', $_GET['site_id'], 'sequence', $_GET['sequence']);
                $sequence = '';
                $visit_code = '';
                $visit_name = '';


                // $last_visit = $override->getlastRow1('visit', 'patient_id', $clients['id'], 'sequence', $_GET['sequence'], 'id')[0];

                // $sequence = intval($_GET['sequence']) + 1;

                // if ($sequence) {
                //     $visit_code = 'M' . $sequence;
                //     $visit_name = 'Month ' . $sequence;
                // }

                if ($facility0) {
                    $user->updateRecord('facility', array(
                        'extraction_date' => Input::get('extraction_date'),
                        'appointments' => Input::get('appointments'),
                        'month_name' => Input::get('month_name'),
                        'patients_tested' => Input::get('patients_tested'),
                        'results_soft_copy' => Input::get('results_soft_copy'),
                        'results_hard_copy' => Input::get('results_hard_copy'),
                        'ltf' => Input::get('ltf'),
                        'transferred_out' => Input::get('transferred_out'),
                        'admitted' => Input::get('admitted'),
                        'death' => Input::get('death'),
                        'inability_transport' => Input::get('inability_transport'),
                        'lack_accompany' => Input::get('lack_accompany'),
                        'incompatibility_time' => Input::get('incompatibility_time'),
                        'tosa' => Input::get('tosa'),
                        'mourning' => Input::get('mourning'),
                        'forgot' => Input::get('forgot'),
                        'unknown' => Input::get('unknown'),
                        'extra_pills' => Input::get('extra_pills'),
                        'others' => Input::get('others'),
                        'comments' => Input::get('comments'),
                        'facility_completed' => Input::get('facility_completed'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $facility0[0]['id']);

                    $successMessage = 'Facility  Successful Updated';
                } else {

                    $user->createRecord('facility', array(
                        'sequence' => $_GET['sequence'],
                        'vid' => $_GET['vid'],
                        'visit_date' => Input::get('extraction_date'),
                        'expected_date' => Input::get('extraction_date'),
                        'extraction_date' => Input::get('extraction_date'),
                        'visit_code' => $_GET['visit_code'],
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => Input::get('appointments'),
                        'month_name' => Input::get('month_name'),
                        'patients_tested' => Input::get('patients_tested'),
                        'results_soft_copy' => Input::get('results_soft_copy'),
                        'results_hard_copy' => Input::get('results_hard_copy'),
                        'ltf' => Input::get('ltf'),
                        'transferred_out' => Input::get('transferred_out'),
                        'admitted' => Input::get('admitted'),
                        'death' => Input::get('death'),
                        'inability_transport' => Input::get('inability_transport'),
                        'lack_accompany' => Input::get('lack_accompany'),
                        'incompatibility_time' => Input::get('incompatibility_time'),
                        'tosa' => Input::get('tosa'),
                        'mourning' => Input::get('mourning'),
                        'forgot' => Input::get('forgot'),
                        'unknown' => Input::get('unknown'),
                        'extra_pills' => Input::get('extra_pills'),
                        'others' => Input::get('others'),
                        'comments' => Input::get('comments'),
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => Input::get('facility_completed'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'visit_status' => 1,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));


                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 1,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M1',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 2,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M2',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 3,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M3',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 4,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M4',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 5,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M5',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 6,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M6',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 7,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M7',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 8,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M8',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 9,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M9',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 10,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M10',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 11,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M11',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $last_row = $override->lastRow('facility', 'id')[0];

                    $expected_date = date('Y-m-d', strtotime('+1 month', strtotime($last_row['expected_date'])));

                    $user->createRecord('facility', array(
                        'sequence' => 12,
                        'vid' => $_GET['vid'],
                        'expected_date' => $expected_date,
                        'extraction_date' => '',
                        'visit_code' => 'M12',
                        'facility_id' => Input::get('facility_id'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => 0,
                        'month_name' => 0,
                        'patients_tested' => 0,
                        'results_soft_copy' => 0,
                        'results_hard_copy' => 0,
                        'ltf' => 0,
                        'transferred_out' => 0,
                        'admitted' => 0,
                        'death' => 0,
                        'inability_transport' => 0,
                        'lack_accompany' => 0,
                        'incompatibility_time' => 0,
                        'tosa' => 0,
                        'mourning' => 0,
                        'forgot' => 0,
                        'unknown' => 0,
                        'extra_pills' => 0,
                        'others' => 0,
                        'comments' => '',
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => 0,
                        'date_completed' => '',
                        'status' => 1,
                        'visit_status' => 0,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));

                    $successMessage = 'Facility  Successful Added';
                }

                // $user->visit_schedule($_GET['site_id'], Input::get('visit_date'), $_GET['site_id'], $user->data()->id, $_GET['site_id'], $eligible, $sequence, $visit_code, $visit_name);


                // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_facility_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_region')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $regions = $override->get('regions', 'id', $_GET['region_id']);
                    if ($regions) {
                        $user->updateRecord('regions', array(
                            'name' => Input::get('name'),
                        ), $_GET['region_id']);
                        $successMessage = 'Region Successful Updated';
                    } else {
                        $user->createRecord('regions', array(
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Region Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_district')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $districts = $override->get('districts', 'id', $_GET['district_id']);
                    if ($districts) {
                        $user->updateRecord('districts', array(
                            'region_id' => $_GET['region_id'],
                            'name' => Input::get('name'),
                        ), $_GET['district_id']);
                        $successMessage = 'District Successful Updated';
                    } else {
                        $user->createRecord('districts', array(
                            'region_id' => Input::get('region_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'District Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_ward')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'district_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $wards = $override->get('wards', 'id', $_GET['ward_id']);
                    if ($wards) {
                        $user->updateRecord('wards', array(
                            'region_id' => $_GET['region_id'],
                            'district_id' => $_GET['district_id'],
                            'name' => Input::get('name'),
                        ), $_GET['ward_id']);
                        $successMessage = 'Ward Successful Updated';
                    } else {
                        $user->createRecord('wards', array(
                            'region_id' => Input::get('region_id'),
                            'district_id' => Input::get('district_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Ward Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
    }
} else {
    Redirect::to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comorbidities Database | Add Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        #medication_table {
            border-collapse: collapse;
        }

        #medication_table th,
        #medication_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #medication_table {
            border-collapse: collapse;
        }

        #medication_list th,
        #medication_list td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_list th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .remove-row {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .remove-row:hover {
            background-color: #da190b;
        }

        .edit-row {
            background-color: #3FF22F;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-row:hover {
            background-color: #da190b;
        }

        #hospitalization_details_table {
            border-collapse: collapse;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #sickle_cell_table {
            border-collapse: collapse;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php } elseif ($pageError) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?php foreach ($pageError as $error) {
                    echo $error . ' , ';
                } ?>
            </div>
        <?php } elseif ($successMessage) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php } ?>

        <?php if ($_GET['id'] == 1 && ($user->data()->position == 1 || $user->data()->position == 2)) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Staff</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            < Back </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            Go to staff list >
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Staff</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id'])[0];
                            $site = $override->get('sites', 'id', $staff['site_id'])[0];
                            $position = $override->get('position', 'id', $staff['position'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" value="<?php if ($staff['firstname']) {
                                                                                                                                                print_r($staff['firstname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" value="<?php if ($staff['middlename']) {
                                                                                                                                                    print_r($staff['middlename']);
                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" value="<?php if ($staff['lastname']) {
                                                                                                                                                print_r($staff['lastname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>User Name</label>
                                                            <input class="form-control" type="text" name="username" id="username" value="<?php if ($staff['username']) {
                                                                                                                                                print_r($staff['username']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Contacts</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number" id="phone_number" value="<?php if ($staff['phone_number']) {
                                                                                                                                                                                                            print_r($staff['phone_number']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number 2</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number2" id="phone_number2" value="<?php if ($staff['phone_number2']) {
                                                                                                                                                                                                            print_r($staff['phone_number2']);
                                                                                                                                                                                                        }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>E-mail Address</label>
                                                            <input class="form-control" type="email" name="email_address" id="email_address" value="<?php if ($staff['email_address']) {
                                                                                                                                                        print_r($staff['email_address']);
                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $staff['sex'] ?>"><?php if ($staff['sex']) {
                                                                                                            if ($staff['sex'] == 1) {
                                                                                                                echo 'Male';
                                                                                                            } elseif ($staff['sex'] == 2) {
                                                                                                                echo 'Female';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?></option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Location And Access Levels</h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Site</label>
                                                            <select class="form-control" name="site_id" style="width: 100%;" required>
                                                                <option value="<?= $site['id'] ?>"><?php if ($staff['site_id']) {
                                                                                                        print_r($site['name']);
                                                                                                    } else {
                                                                                                        echo 'Select';
                                                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->getData('sites') as $site) { ?>
                                                                    <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Position</label>
                                                            <select class="form-control" name="position" style="width: 100%;" required>
                                                                <option value="<?= $position['id'] ?>"><?php if ($staff['position']) {
                                                                                                            print_r($position['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('position', 'status', 1) as $position) { ?>
                                                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Access Level</label>
                                                            <input class="form-control" type="number" min="0" max="3" name="accessLevel" id="accessLevel" value="<?php if ($staff['accessLevel']) {
                                                                                                                                                                        print_r($staff['accessLevel']);
                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Power</label>
                                                            <input class="form-control" type="number" min="0" max="2" name="power" id="power" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=1" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_user" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 2) { ?>
        <?php } elseif ($_GET['id'] == 3) { ?>
            <?php
            $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            $regions = $override->get('regions', 'id', $_GET['region_id']);
            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
            $wards = $override->get('wards', 'id', $_GET['ward_id']);
            // print_r($regions)
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($sites) { ?>
                                    <h1>Add New Site</h1>
                                <?php } else { ?>
                                    <h1>Update Site</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($sites) { ?>
                                        <li class="breadcrumb-item active">Add New Site</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Site</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Name & Date</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="entry_date" class="form-label">Date of Entry</label>
                                                        <input type="date" value="<?php if ($sites['entry_date']) {
                                                                                        print_r($sites['entry_date']);
                                                                                    } ?>" id="entry_date" name="entry_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($sites['name']) {
                                                                                        print_r($sites['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter here name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ARMS, LEVEL , TYPE & CATEGORY</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="arm" class="form-label">Arm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_arm', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="arm" id="arm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['arm'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="level" class="form-label">Level</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_level', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="level" id="level<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['level'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="type" class="form-label">Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="type" id="type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['type'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="category" class="form-label">Category</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_category', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="category" id="category<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['category'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="category" class="form-label">Respondent Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('respondent_type', 'status', 1, 'respondent', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="respondent" id="respondent<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['respondent'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Adress</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($sites['region']) {
                                                                                                            print_r($regions[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($sites['district']) {
                                                                                                            print_r($districts[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($sites['ward']) {
                                                                                                        print_r($wards[0]['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $sites['id'] ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="site_id" value="<?= $sites['id'] ?>">
                                            <input type="submit" name="add_site" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 4) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Client</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            <?php if ($_GET['status'] == 1) { ?>
                                                Go to screening list >
                                            <?php } elseif ($_GET['status'] == 2) { ?>
                                                Go to eligible list >
                                            <?php } elseif ($_GET['status'] == 3) { ?>
                                                Go to enrollment list >
                                            <?php } elseif ($_GET['status'] == 4) { ?>
                                                Go to terminated / end study list >
                                            <?php } elseif ($_GET['status'] == 5) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 6) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 7) { ?>
                                                Go to registered list >
                                            <?php } ?>
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Client</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                            $relation = $override->get('relation', 'id', $clients['relation_patient'])[0];
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            $household = $override->get('household', 'id', $clients['head_household'])[0];

                            $regions = $override->get('regions', 'id', $clients['region'])[0];
                            $districts = $override->get('districts', 'id', $clients['district'])[0];
                            $wards = $override->get('wards', 'id', $clients['ward'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['firstname']) {
                                                                                                                                                                                                        print_r($clients['firstname']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['middlename']) {
                                                                                                                                                                                                        print_r($clients['middlename']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['lastname']) {
                                                                                                                                                                                                    print_r($clients['lastname']);
                                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Registration Date:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_registered" id="date_registered" value="<?php if ($clients['date_registered']) {
                                                                                                                                                                                        print_r($clients['date_registered']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>CTC ID </label>
                                                            <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="ctc_id" id="ctc_id" placeholder="Type CTC ID..." value="<?php if ($clients['ctc_id']) {
                                                                                                                                                                                                                                        print_r($clients['ctc_id']);
                                                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of birth:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="dob" id="dob" style="width: 100%;" value="<?php if ($clients['dob']) {
                                                                                                                                                                                    print_r($clients['dob']);
                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input class="form-control" type="number" min=0 max="99" name="age" id="age" value="<?php if ($clients['age']) {
                                                                                                                                                    print_r($clients['age']);
                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>SEX</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="1" <?php if ($clients['sex'] == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="2" <?php if ($clients['sex'] == 2) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                                                                            print_r($clients['patient_phone']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone2" id="patient_phone2" value="<?php if ($clients['patient_phone2']) {
                                                                                                                                                                                                                print_r($clients['patient_phone2']);
                                                                                                                                                                                                            }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>




                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Patient Adress</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($clients['region']) {
                                                                                                            print_r($regions['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($clients['district']) {
                                                                                                            print_r($districts['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($clients['ward']) {
                                                                                                        print_r($wards['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Residence street</label>
                                                            <input class="form-control" type="text" name="street" id="street" value="<?php if ($clients['street']) {
                                                                                                                                            print_r($clients['street']);
                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Physical Address ( Location )</label>
                                                            <textarea class="form-control" id="location" placeholder="Type physical address here" name="location" rows="3" style="width: 100%;" required>
                                                                    <?php if ($clients['location']) {
                                                                        print_r($clients['location']);
                                                                    }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>House number, if any</label>
                                                            <input class="form-control" type="text" name="house_number" id="house_number" value="<?php if ($clients['house_number']) {
                                                                                                                                                        print_r($clients['house_number']);
                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">treatment supporter or next of kin details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>First Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_fname" id="supporter_fname" value="<?php if ($clients['supporter_fname']) {
                                                                                                                                                            print_r($clients['supporter_fname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Middle Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_mname" id="supporter_mname" value="<?php if ($clients['supporter_mname']) {
                                                                                                                                                            print_r($clients['supporter_mname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Last Name (Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_lname" id="supporter_lname" value="<?php if ($clients['supporter_lname']) {
                                                                                                                                                            print_r($clients['supporter_lname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number(Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone" id="supporter_phone" value="<?php if ($clients['supporter_phone']) {
                                                                                                                                                                                                                print_r($clients['supporter_phone']);
                                                                                                                                                                                                            }  ?>" required />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number 2 (Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone2" id="supporter_phone2" value="<?php if ($clients['supporter_phone2']) {
                                                                                                                                                                                                                    print_r($clients['supporter_phone2']);
                                                                                                                                                                                                                }  ?>" />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Relation to patient(Supporter)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('relation', 'status', 1) as $relation) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="relation_patient" id="relation_patient<?= $relation['id']; ?>" value="<?= $relation['id']; ?>" <?php if ($clients['relation_patient'] == $relation['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $relation['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label id="relation_patient_other_label">Other relation patient</label>
                                                            <textarea class="form-control" name="relation_patient_other" id="relation_patient_other" rows="3" placeholder="Type other relation here...">
                                                                <?php if ($clients['relation_patient_other']) {
                                                                    print_r($clients['relation_patient_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Level of educations</label>
                                                            <select id="education" name="education" class="form-control" required>
                                                                <option value="<?= $education['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($education['name']);
                                                                                                        } else {
                                                                                                            echo 'Select education';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('education', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Occupation</label>
                                                            <select id="occupation" name="occupation" class="form-control" required>
                                                                <option value="<?= $occupation['id'] ?>"><?php if ($clients) {
                                                                                                                print_r($occupation['name']);
                                                                                                            } else {
                                                                                                                echo 'Select Occupation';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('occupation', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">health insurance</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Do you own health insurance?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance1" value="1" <?php if ($clients['health_insurance'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance2" value="2" <?php if ($clients['health_insurance'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="pay_services">
                                                    <label>If no, how do you pay for your health care services</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('payments', 'status', 1) as $payment) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="pay_services" id="pay_services<?= $payment['id']; ?>" value="<?= $payment['id']; ?>" <?php if ($clients['pay_services'] == $payment['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $payment['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name">
                                                    <label>Name of insurance:</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('insurance', 'status', 1) as $insurance) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="insurance_name" id="insurance_name<?= $insurance['id']; ?>" value="<?= $insurance['id']; ?>" <?php if ($clients['insurance_name'] == $insurance['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $insurance['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name_other">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other Name of insurance:</label>
                                                            <textarea class="form-control" name="insurance_name_other" rows="3" placeholder="Type other insurance here...">
                                                                <?php if ($clients['insurance_name_other']) {
                                                                    print_r($clients['insurance_name_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Type of Interview</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                    <div class="col-md-3">
                                                        <div class="card card-warning">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Site Name</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-md-6">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Type</label>
                                                            <select id="respondent" name="respondent" class="form-control" required>
                                                                <option value="<?= $clients['respondent'] ?>"><?php if ($clients['respondent']) {
                                                                                                                    print_r($override->getNews('respondent_type', 'status', 1, 'id', $clients['respondent'])[0]['name']);
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                                </option>
                                                                <?php foreach ($override->getNews('respondent_type', 'status', 1, 'respondent', 1) as $value) { ?>
                                                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                    <div class="col-sm-3" id="insurance_name">
                                                        <label>Name Of Site:</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="site" id="site<?= $site['id']; ?>" value="<?= $site['id']; ?>" <?php if ($clients['site_id'] == $site['id']) {
                                                                                                                                                                                                echo 'checked' . ' ' . 'required';
                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $site['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($clients['comments']) {
                                                                                                                                                            print_r($clients['comments']);
                                                                                                                                                        }  ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=3&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_client" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 5) { ?>
            <?php
            $individual = $override->get3('individual', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add New Swahili Quantitative tool TB Comorbidity</h1>
                                <?php } else { ?>
                                    <h1>Update Swahili Quantitative tool TB Comorbidity</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$individual) { ?>
                                        <li class="breadcrumb-item active">Add New Quantitative Tool</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Quantitative Tool</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Taarifa za mshiriki</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="tarehe_mahojiano" class="form-label">Tarehe ya Mahojiano:</label>
                                                        <input type="date" value="<?php if ($individual['tarehe_mahojiano']) {
                                                                                        print_r($individual['tarehe_mahojiano']);
                                                                                    } ?>" id="tarehe_mahojiano" name="tarehe_mahojiano" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="tb_kugundulika">
                                                    <label for="tb_kugundulika" class="form-label">6. TB iligundulika kwa njia gani</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_methods', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_kugundulika" id="tb_kugundulika<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tb_kugundulika'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="tb_tarehe" class="form-label">6(a) Tarehe TB iliyogundulika: </label>
                                                        <input type="date" value="<?php if ($individual['tb_tarehe']) {
                                                                                        print_r($individual['tb_tarehe']);
                                                                                    } ?>" id="tb_tarehe" name="tb_tarehe" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="tb_dawa">
                                                    <label for="tb_dawa" class="form-label">7. Ameanza dawa za TB</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_dawa" id="tb_dawa<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tb_dawa'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="tb_dawa_tarehe" class="form-label">7(b) Tarehe ya kuanza dawa za TB:</label>
                                                        <input type="date" value="<?php if ($individual['tb_dawa_tarehe']) {
                                                                                        print_r($individual['tb_dawa_tarehe']);
                                                                                    } ?>" id="tb_dawa_tarehe" name="tb_dawa_tarehe" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sasa nitakuuliza maswali yanayohusiana na tabia/mazoea mbalimbali yanayohusu afya. Tuanze na sigara/tumbaku.</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">8. Je, kwa sasa unavuta aina yoyote ya tumbaku kama vile sigara, kiko, sigara ya kusokota n.k? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">9. Kama ndiyo, Kwa sasa unavuta sigara au tumbaku kila siku? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">10. Ulikuwa na umri gani ulipoanza kuvuta sigara kwa mara ya kwanza? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">11. Kwa kipindi cha mieazi 12 iliyopita,ulijaribu kuacha kuvuta sigara? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">12. Hapo zamani, ulishawahi kuvuta aina yoyote ya tumbaku?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">13. Kwa sasa unatumia aina yoyote ya tumbaku isiyo ya kuvuta kama vile ugoro, ‘kuber’ n.k.? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">14. Kama ndiyo, Kwa sasa, unatumia tumbaku isiyo ya kuvuta kila siku? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">15. Kama ndiyo , Kwa wastani, ni mara ngapi kwa siku/wiki unatumia ;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label for="started_tb" class="form-label">15(a). Taja</label>
                                                        <input type="text" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">16. Uliishawahi kutumia tumbaku isiyo ya kuvuta kama vile ugoro, ‘kuber’ n.k. </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">17. Kama ndiyo, Uliishawahi kutumia tumbaku isiyo ya kuvuta kama vile ugoro, ‘kuber’ n.k kila siku? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">18. Ndani ya siku 30 zilizopita kuna mtu yeyote alievuta tumbaku ndani ya nyumba yako? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">19. Ndani ya siku 30 zilizopita, kuna mtu yeyote amevuta sigara kwenye eneo ambalo si la wazi katika sehemu yako ya kazi? DADISI ZAIDI </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Utumiaji wa Pombe / Vileo: Maswali yafuatayo yanauliza kuhusu utumiaji wa Pombe/Vileo</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">20. Je, umewahi kutumia kinywaji chenye kilevi (kama vile bia, mvinyo, pombe kali au pombe ya kienyeji)?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">21. Je umekunywa kinywaji chenye kilevi ndani ya miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">22. Kama Hapana Swali 20, Umeacha kunywa pombe kwa sababu za kiafya, kama vile athari mbaya kuhusu afya yako au ushauri kutoka kwa daktari/mfanyakazi wa afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">23. Umetumia kinywaji chenye kilevi (kama vile bia, mvinyo, pombe kali au pombe ya kienyeji) katika siku 30 zilizopita? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">24. Katika siku 30 zilizopita, ni mara ngapi umekunywa vinywaji 6 au Zaidi vyenye kilevi (standard drink) kwenye mkupuo mmoja? (1 Beer=1 Glass of Wine= 1 Shot of Spirit)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">25. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi umeshindwa kujizuia kunywa pombe mara baada ya kuanza kunywa? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">26. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi ulishindwa kufanya ulichotarajiwa kwa sababu ya pombe?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">27. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi ulihitaji pombe asubuhi ili uweze kuendelea na ratiba za siku baada ya kunywa pombe nyingi (kuzimua)?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">28. Kwa kipindi cha miezi 12 iliyopita, umewahi kuwa na tatizo la kifamilia au na mwenza wako kutokana na mtu mwingine kunywa pombe?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">LISHE: Maswali yafuatayo yanauliza kuhusu matunda na mbogamboga ambazo unakula mara kwa mara.</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">29. Kwa kawaida ni siku ngapi ndani ya wiki moja unakula matunda? (TUMIA SHOWCARD) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">30. Unakula matunda kiasi gani katika moja ya siku hizo? ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">31. Kwa kawaida ni siku ngapi ndani ya wiki moja unakula mboga za majani? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">32. Unakula kiasi gani cha mboga za majani katika moja ya siku hizo? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Dietary Salt
                                                        <br>
                                                        <br>

                                                        Kwa maswali yanayofuata, tungependa kupata uzoefu wako juu ya matumizi ya chumvi kwenye chakula chako. Chumvi kwenye chakula ni pamoja na chumvi ya mezani, chumvi isiyosafishwa kama chumvi ya bahari, chumvi iliyo na madini joto, chumvi ya poda, na chumvi iliyowekwa kwenye mchuzi mfano mchuzi wa samaki
                                                    </h3>
                                                </div>
                                            </div>


                                            <hr>


                                            <div class="row">

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">33. Je! Ni mara ngapi unaongeza chumvi au mchuzi wa chumvi kama vile siki, chachandu, Soya Sauce, chachandu au achali, ajinomoto kwenye chakula chako kabla ya kula au unapokula? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">34. Ni mara ngapi unakula chakula kilichosindikwa na chumvi nyingi?
                                                        (Ninamaanisha vyakula ambavyo vimebadilishwa kutoka kwa hali yake ya asili, kama vile vitafunio vyenye chumvi, vyakula vya chumvi vilivyosindikwa)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">35. Je, unafikiri matumizi yako ya chumvi kwenye chakula, siki, soya sauce, achali au chachandu ni makubwa kiasi gani? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">36. Je! Unafikiri ni muhimu kiasi gani kwako kupunguza kiasi cha chumvi unachotumia kwenye mlo wako? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">37. Je! Unafikiri kuwa matumizi ya chumvi nyingi kwenye chakula yanaweza yakasababisha matatizo ya kiafya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Mazoezi ya Viungo
                                                        <br>
                                                        <br>
                                                        Sasa nitaendelea kukuuliza kuhusu muda unaotumia kufanya shughuli mbalimbali zinazohusu mazoezi ya viungo katika wiki moja ya kawaida. Tafadhali ujibu maswali haya hata kama unadhani wewe si mtu wa kufanya mazoezi mara kwa mara.
                                                    </h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">

                                                <div class="col-4" id="started_tb1">
                                                    <label for="diabetic_status" class="form-label">38. Je, kazi yako inahusisha shughuli za kutumia nguvu ambazo zinaongeza kasi ya kupumua na mapigo ya moyo kama vile kubeba mizigo mizito, kumwaga zege, kupiga kokoto, kuchota maji, kusomba mazao, kilimo au kazi za ujenzi kwa angalau dakika 10 mfululizo?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">39. Katika wiki ya kawaida, ni kwa siku ngapi unafanya shughuli hizo za kutumia nguvu kiasi katika kazi yako?</label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-3" id="started_tb1">
                                                    <label for="diabetic_status" class="form-label">40. Una kawaida ya kutembea kwa miguu au kwa kutumia baiskeli kwa angalau dakika 10 mfululizo wakati unapokwenda na kurudi mahali fulani?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">41. Unatumia muda gani kutembea kwa miguu au kwa kutumia baiskeli katika siku ya kawaida?</label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-4" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">42. Katika wiki ya kawaida, ni siku ngapi unatembea kwa miguu au kwa kutumia baiskeli kwa angalau dakika 10 mfululizo wakati unapokwenda mahali fulani? </label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-5" id="started_tb1">
                                                    <label for="diabetic_status" class="form-label">43. Una kawaida ya kushiriki katika shughuli za michezo au mazoezi ambazo zinaongeza kwa kiasi kikubwa kasi ya kupumua au mapigo ya moyo kama vile kukimbia, kuruka kichura, kuinama na kuinuka, kuruka viunzi, kucheza mpira kwa angalau dakika 10 mfululizo? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">44. Katika wiki ya kawaida, unatumia siku ngapi kufanya shughuli hizo za michezo au mazoezi? </label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Clinical History</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">45. Je umeshawahi kuambiwa na daktari au mtoa huduma za afya kuwa una ongezeko la shinikizo la damu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">46. Je umeambiwa hivyo ndani ya miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">47. Katika wiki mbili zilizopita, umetumia vidonge kwa ajili ya ongezeko la shinikizo la damu, au presha kama ilivyoshauriwa na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">48. Kwa sasa unatumia aina yoyote ya mitidawa kwa ajili ya ongezeko la shinikizo la damu, au presha?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">49. Umewahi kuambiwa na daktari au mtoa huduma za afya kuwa sukari yako imepanda au una ugonjwa wa kisukari?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">50. Je uliambiwa hivyo kwa mara ya kwanza katika kipindi cha miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">51. Katika wiki mbili zilizopita, umetumia dawa yoyote kwa ajili ya ugonjwa wa kisukari kama ulivyoandikiwa na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">52. Kwa sasa unatumia aina yoyote ya mitidawa kwa ajili ya kisukari?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">53. Umewahi kupimwa Lehemu (Ongezeko la Mafuta kwenye damu) na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">54. Je umwahi kuambiwa na daktari au mtoa huduma za afya kuwa kiwango chako cha Lehemu (Ongezeko la Mafuta kwenye damu) kiomeongezeka?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">55. Je kwa mara ya kwanza uliambiwa hivyo ndani ya miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">56. Je, katika wiki mbili zilizopita umetumia vidonge vyovyote kwa ajili ya ongezeko la Lehemu (Ongezeko la Mafuta kwenye damu) kama ulivyoandikiwa na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">57. Kwa sasa unatumia aina yoyote ya mitidawa kwa ajili ya ongezeko la Lehemu (Ongezeko la Mafuta kwenye damu?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <h2>Je kwa kipindi cha angalau majuma mawili, ni mara ngapi umesumbuliwa na hali zifuatazo:</h2>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">58. Ulikuwa na shauku kidogo au kukosa hamu ya kufanya vitu ambavyo kwa kawaida umekuwa ukivifanya na kuvifurahia </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">59. Uliona hisia kushuka/kupoteza shauku/kutokufurahia mambo ambayo umekuwa ukiyafurahia</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">60. Ulikuwa na shida ya usingizi zaidi ya ilivyokuwa kawaida (kwa mfano, kupata usingizi, kuendelea kuwa na usingizi) au kulala sana zaidi ya ilivyokawaida </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">61. Ulikuwa na nguvu kidogo kuliko ilivyokuwa kabla au kuchoka zaidi kuliko kawaida hata ukifanya shughuli ndogondogo </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">62. Hukutaka kula hata pale ambapo chakula kilikuwepo au ulikula zaidi kuliko ilivyokukuwa </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">63. Umehisi umejiangusha mwenyewe au kuwaangusha wengine </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">64. Umepata shida zaidi kuwa makini na kuendelea kuwa makini kwenye vitu, (mfano: kusikiliza redio, kuangalia luninga) kuliko ilivyo kawaida </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">65. Ulitembea/kujongea taratibu zaidi kuliko kawaida au kinyume chake, kukosa utulivu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">66. Swali linalofuata linaweza kuwa swali nyeti/ linalokugusa hisia zako. Umekuwa uliifikiria kuhusu kifo, kujiua au kujaribu kusitisha uhai wako </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">MEASUREMENTS AND INVESTIGATIONS</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">67. Urefu(cm)</label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">68. Uzito (kg)</label>
                                                        <input type="number" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">69. Hali ya HIV</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('hiv_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">69(a). Tarehe aliyopima;</label>
                                                        <input type="date" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-4" id="started_tb1">
                                                    <label for="diabetic_status" class="form-label">70. Hali ya Kisukari </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4" id="started_tb1">
                                                    <label for="rbg_done" class="form-label">71. Ameanza dawa za Kisukari </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rbg_done" id="rbg_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['rbg_done'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">71(a). Tarehe aliyoanza dawa:;</label>
                                                        <input type="date" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Follow-Up And Treatment Outcome (At Month 6)</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">72. Je, uchunguzi wa smear wa makohozi Mwishoni wa Mwezi wa Pili yamefanyika?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">73. If Ndiyo Qn 68, Majibu ya Smear</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">74. Je, uchunguzi wa smear wa makohozi Mwishoni wa Mwezi wa tano yamefanyika </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-2" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">76. Kama Ndiyo Qn 74, Majibu </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">77. Tarehe ya mwisho ya mshiriki:</label>
                                                        <input type="date" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-6" id="tuberculosis_outcome">
                                                    <label for="tuberculosis_outcome" class="form-label">78. Matokeo ya matumizi yad awa za TB (Tuberculosis Treatment Outcome )</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tuberculosis_treatment', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tuberculosis_outcome" id="tuberculosis_outcome<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tuberculosis_outcome'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name2']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="tb_outcome_date_cured" class="form-label">Tarehe ya kupona(Cured)</label>
                                                        <label for="tb_outcome_date_completed" class="form-label">Tarehe ya kumaliza matibabu (Completed treatment) </label>
                                                        <label for="tb_outcome_date_death" class="form-label">Tarehe ya kufariki (Died)</label>
                                                        <label for="tb_outcome_date_last_seen" class="form-label">Tarehe ya kupotea kwenye ufuatiliaji (Lost to follow up) / Date last seen (Last visit date) </label>
                                                        <input type="date" value="<?php if ($individual['tb_outcome_date']) {
                                                                                        print_r($individual['tb_outcome_date']);
                                                                                    } ?>" id="tb_outcome_date" name="tb_outcome_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="tb_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_complete" id="tb_complete<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tb_complete'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_tb" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 6) { ?>
            <?php
            $facility = $override->get3('facility', 'status', 1, 'sequence', $_GET['sequence'], 'site_id', $_GET['site_id'])[0];
            $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($facility) { ?>
                                    <h1>Add New Facility</h1>
                                <?php } else { ?>
                                    <h1>Update Facility</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($facility) { ?>
                                        <li class="breadcrumb-item active">Add New Facility</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Facility</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Section 1: Facility PIVLO-Test list details (to be completed monthly in clinic)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="extraction_date" class="form-label">Date of Extraction</label>
                                                        <input type="date" value="<?php if ($facility['extraction_date']) {
                                                                                        print_r($facility['extraction_date']);
                                                                                    } ?>" id="extraction_date" name="extraction_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="month_name" class="form-label">Month (Name)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('months', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="month_name" id="month_name<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['month_name'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="appointments" class="form-label">Total number of test appointment in a
                                                            month.</label>
                                                        <input type="number" value="<?php if ($facility['appointments']) {
                                                                                        print_r($facility['appointments']);
                                                                                    } ?>" id="appointments" name="appointments" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="patients_tested" class="form-label">Total patients got tested this month</label>
                                                        <input type="number" value="<?php if ($facility['patients_tested']) {
                                                                                        print_r($facility['patients_tested']);
                                                                                    } ?>" id="patients_tested" name="patients_tested" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="results_soft_copy" class="form-label">Total VL test results made available for
                                                            this month</label>
                                                        <input type="number" value="<?php if ($facility['results_soft_copy']) {
                                                                                        print_r($facility['results_soft_copy']);
                                                                                    } ?>" id="results_soft_copy" name="results_soft_copy" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>From Soft Copy ( Excel )</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="results_hard_copy" class="form-label">Total VL test results made available for
                                                            this month</label>
                                                        <input type="number" value="<?php if ($facility['results_hard_copy']) {
                                                                                        print_r($facility['results_hard_copy']);
                                                                                    } ?>" id="results_hard_copy" name="results_hard_copy" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>From Hard Copy</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Reason for those who were not tested.</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ltf" class="form-label">Loss to Follow Up </label>
                                                        <input type="number" value="<?php if ($facility['ltf']) {
                                                                                        print_r($facility['ltf']);
                                                                                    } ?>" id="ltf" name="ltf" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="transferred_out" class="form-label">TRANSFERRED OUT </label>
                                                        <input type="number" value="<?php if ($facility['transferred_out']) {
                                                                                        print_r($facility['transferred_out']);
                                                                                    } ?>" id="transferred_out" name="transferred_out" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="admitted" class="form-label">ADMITTED ELSE WHERE </label>
                                                        <input type="number" value="<?php if ($facility['admitted']) {
                                                                                        print_r($facility['admitted']);
                                                                                    } ?>" id="admitted" name="admitted" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="death" class="form-label">DEATH </label>
                                                        <input type="number" value="<?php if ($facility['death']) {
                                                                                        print_r($facility['death']);
                                                                                    } ?>" id="death" name="death" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="inability_transport" class="form-label">INABILITY TO PAY TRANSPORT COST</label>
                                                        <input type="number" value="<?php if ($facility['inability_transport']) {
                                                                                        print_r($facility['inability_transport']);
                                                                                    } ?>" id="inability_transport" name="inability_transport" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lack_accompany" class="form-label">LACK OF ACCOMPANY PERSON</label>
                                                        <input type="number" value="<?php if ($facility['lack_accompany']) {
                                                                                        print_r($facility['lack_accompany']);
                                                                                    } ?>" id="lack_accompany" name="lack_accompany" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="incompatibility_time" class="form-label">INCOMPATIBILITY OF TESTING TIME </label>
                                                        <input type="number" value="<?php if ($facility['incompatibility_time']) {
                                                                                        print_r($facility['incompatibility_time']);
                                                                                    } ?>" id="incompatibility_time" name="incompatibility_time" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="tosa" class="form-label">TRAVELLED OUSTSIDE STUDY AREA</label>
                                                        <input type="number" value="<?php if ($facility['tosa']) {
                                                                                        print_r($facility['tosa']);
                                                                                    } ?>" id="tosa" name="tosa" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="mourning" class="form-label">MOURNING</label>
                                                        <input type="number" value="<?php if ($facility['mourning']) {
                                                                                        print_r($facility['mourning']);
                                                                                    } ?>" id="mourning" name="mourning" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="forgot" class="form-label">FORGOT</label>
                                                        <input type="number" value="<?php if ($facility['forgot']) {
                                                                                        print_r($facility['forgot']);
                                                                                    } ?>" id="forgot" name="forgot" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="unknown" class="form-label">UNKNOWN</label>
                                                        <input type="number" value="<?php if ($facility['unknown']) {
                                                                                        print_r($facility['unknown']);
                                                                                    } ?>" id="unknown" name="unknown" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="extra_pills" class="form-label">PATIENT STILL HAVE ARV PILLS AT HOME</label>
                                                        <input type="number" value="<?php if ($facility['extra_pills']) {
                                                                                        print_r($facility['extra_pills']);
                                                                                    } ?>" id="extra_pills" name="extra_pills" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="others" class="form-label">OTHERS</label>
                                                        <input type="number" value="<?php if ($facility['others']) {
                                                                                        print_r($facility['others']);
                                                                                    } ?>" id="others" name="others" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="comments" class="form-label">Any Comments ( If Available ):</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter comments here">
                                                                                            <?php if ($facility['comments']) {
                                                                                                print_r($facility['comments']);
                                                                                            } ?>
                                                                                            </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="facility_completed">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="facility_completed" id="facility_completed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['facility_completed'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($facility['date_completed']) {
                                                                                        print_r($facility['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="facility_id" value="<?= $site['id'] ?>">
                                            <input type="hidden" name="facility_arm" value="<?= $site['arm'] ?>">
                                            <input type="hidden" name="facility_level" value="<?= $site['level'] ?>">
                                            <input type="hidden" name="facility_type" value="<?= $site['type'] ?>">
                                            <input type="submit" name="add_facility" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 7) { ?>
            <?php
            $screening = $override->get3('screening', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($screening) { ?>
                                    <h1>Add New Screening</h1>
                                <?php } else { ?>
                                    <h1>Update Screening</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Screening</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Screening</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Inclusion Criteria</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Screening</label>
                                                        <input type="date" value="<?php if ($screening['screening_date']) {
                                                                                        print_r($screening['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>


                                                <div class="col-sm-3">
                                                    <label for="date_status" class="form-label">18 years or above ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="above18" id="above18<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['above18'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="new_tb" class="form-label">Newly diagnosed TB patient</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="new_tb" id="new_tb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['new_tb'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3" id="new_tb_date1">
                                                    <div class="mb-2">
                                                        <label for="new_tb_date" class="form-label">Date of diagnosed TB</label>
                                                        <input type="date" value="<?php if ($screening['new_tb_date']) {
                                                                                        print_r($screening['new_tb_date']);
                                                                                    } ?>" id="new_tb_date" name="new_tb_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" id="conset_date1">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening['conset_date']) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="start_anti_b" class="form-label">Started Anti-TB</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="start_anti_b" id="start_anti_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['start_anti_b'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" id="start_anti_b_date1">
                                                    <div class="mb-3">
                                                        <label for="start_anti_b_date" class="form-label">Date Started Anti-TB</label>
                                                        <input type="date" value="<?php if ($screening['start_anti_b_date']) {
                                                                                        print_r($screening['start_anti_b_date']);
                                                                                    } ?>" id="start_anti_b_date" name="start_anti_b_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date art treatment" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Exclusion Criteria</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="diabetes_type1" class="form-label">Diabetes Type 1</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetes_type1" id="diabetes_type1<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['diabetes_type1'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                //  if ($override->get3('clients', 'status', 1, 'sex', 2, 'id', $_GET['cid'])) {
                                                ?>
                                                <div class="col-sm-3">
                                                    <label for="extrapulmonary_tb" class="form-label">Extrapulmonary TB</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="extrapulmonary_tb" id="extrapulmonary_tb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['extrapulmonary_tb'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                //  }
                                                ?>

                                                <div class="col-sm-3">
                                                    <label for="mdr_xdr" class="form-label">MDR and XDR patients</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mdr_xdr" id="mdr_xdr<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['mdr_xdr'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="stay" class="form-label">Expected to stay at study area for more than 12 months?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="stay" id="stay<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['stay'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter here" required>
                                                            <?php if ($screening['comments']) {
                                                                print_r($screening['comments']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_screening" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 8) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Region Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Region Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $regions = $override->get('regions', 'id', $_GET['region_id']); ?>
                            <!-- right column -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Region</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type region..." onkeyup="fetchData()" value="<?php if ($regions['0']['name']) {
                                                                                                                                                                                        print_r($regions['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="hidden" name="region_id" value="<?= $regions['0']['id'] ?>">
                                            <input type="submit" name="add_region" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Regions
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('regions', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $regions = $override->getWithLimit('regions', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($regions as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=24&region_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=24&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 9) { ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>District Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">District Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->get('districts', 'id', $_GET['district_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">District</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type district..." onkeyup="fetchData()" value="<?php if ($districts['0']['name']) {
                                                                                                                                                                                            print_r($districts['0']['name']);
                                                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_district" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Districts
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('districts', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $districts = $override->getWithLimit('districts', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($districts as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=25&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=25&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 10) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Wards Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Wards Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
                            $wards = $override->get('wards', 'id', $_GET['ward_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Ward</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="regions_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="districts_id" name="district_id" class="form-control" required <?php if ($_GET['district_id']) {
                                                                                                                                            echo 'disabled';
                                                                                                                                        } ?>>
                                                                <option value="<?= $districts[0]['id'] ?>"><?php if ($districts[0]['name']) {
                                                                                                                print_r($districts[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select District';
                                                                                                            } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type ward..." onkeyup="fetchData()" value="<?php if ($wards['0']['name']) {
                                                                                                                                                                                        print_r($wards['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_ward" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Wards
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('wards', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $ward = $override->getWithLimit('wards', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="search-results" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($ward as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                    $districts = $override->get('districts', 'id', $value['district_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $districts['name']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=26&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['district_id'] ?>&ward_id=<?= $value['id'] ?>" class="btn btn-info">Update</a> <br><br>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=26&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 11) { ?>
            <?php
            $individual = $override->get3('individual', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add New HIV Patients (CTC CLINIC)</h1>
                                <?php } else { ?>
                                    <h1>Update HIV Patients (CTC CLINIC)</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$individual) { ?>
                                        <li class="breadcrumb-item active">Add New HIV Patients (CTC CLINIC)</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update HIV Patients (CTC CLINIC)</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">HIV Patients (CTC CLINIC)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($individual['visit_date']) {
                                                                                        print_r($individual['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="patient_status">
                                                    <label for="patient_status" class="form-label">Patient Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('patient_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="patient_status" id="patient_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['patient_status'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="work_place">
                                                    <label for="work_place" class="form-label">Place of Work</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('work_place', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="work_place" id="work_place<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['work_place'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="work_place_other" class="form-label">If Other explain ?</label>
                                                            <input type="text" value="<?php if ($individual['work_place_other']) {
                                                                                            print_r($individual['work_place_other']);
                                                                                        } ?>" id="work_place_other" name="work_place_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="referred_by">
                                                    <label for="referred_by" class="form-label">Referred by ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('referred', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="referred_by" id="referred_by<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['referred_by'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="referred_other" class="form-label">If Other explain ?</label>
                                                            <input type="text" value="<?php if ($individual['referred_other']) {
                                                                                            print_r($individual['referred_other']);
                                                                                        } ?>" id="referred_other" name="referred_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="dot_options">
                                                    <label for="decision_making" class="form-label">DOT Option</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dot_options', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="dot_options" id="dot_options<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['dot_options'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="classification">
                                                    <label for="classification" class="form-label">Classification by site</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('classification', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="classification" id="classification<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['classification'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sputum_smear">
                                                    <label for="sputum_smear" class="form-label">Sputum test Smear Before treatment </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sputum_smear', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sputum_smear" id="sputum_smear<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['sputum_smear'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sputum_gene_xpert">
                                                    <label for="sputum_gene_xpert" class="form-label">Sputum Gene Xpert Before Treatment </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sputum_gene_xpert', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sputum_gene_xpert" id="sputum_gene_xpert<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['sputum_gene_xpert'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">TB</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">Date Started TB Treatmen</label>
                                                        <input type="date" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ctc_date" class="form-label">Date transferred to CTC</label>
                                                        <input type="date" value="<?php if ($individual['ctc_date']) {
                                                                                        print_r($individual['ctc_date']);
                                                                                    } ?>" id="ctc_date" name="ctc_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">HIV Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('hiv_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">Diabetic Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="rbg_done">
                                                    <label for="rbg_done" class="form-label">If No, RBG Done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rbg_done" id="rbg_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['rbg_done'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="vaccinations_status">
                                                    <label for="opportunistic" class="form-label">COVID-19 Vaccination Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('vaccinations_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="vaccinations_status" id="vaccinations_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['vaccinations_status'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="vaccination_date" class="form-label">If Vaccinated, Date Vaccinated</label>
                                                            <input type="date" value="<?php if ($individual['vaccination_date']) {
                                                                                            print_r($individual['vaccination_date']);
                                                                                        } ?>" id="vaccination_date" name="vaccination_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="tuberculosis_outcome">
                                                    <label for="tuberculosis_outcome" class="form-label">Tuberculosis Treatment Outcome </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tuberculosis_outcome" id="tuberculosis_outcome<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tuberculosis_outcome'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="tb_outcome_date_cured" class="form-label">Date Cured</label>
                                                            <label for="tb_outcome_date_completed" class="form-label">Date Treatment Completed </label>
                                                            <label for="tb_outcome_date_death" class="form-label">Date of Death</label>
                                                            <label for="tb_outcome_date_last_seen" class="form-label">Date last seen (Last visit date) </label>
                                                            <input type="date" value="<?php if ($individual['tb_outcome_date']) {
                                                                                            print_r($individual['tb_outcome_date']);
                                                                                        } ?>" id="tb_outcome_date" name="tb_outcome_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="tb_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_complete" id="tb_complete<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tb_complete'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_hiv" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 12) { ?>
            <?php
            $individual = $override->get3('individual', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add New Diabetic Patient (DIABETIC CLINIC)</h1>
                                <?php } else { ?>
                                    <h1>Update Diabetic Patient (DIABETIC CLINIC)</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$individual) { ?>
                                        <li class="breadcrumb-item active">Add New Diabetic Patient (DIABETIC CLINIC)</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Diabetic Patient (DIABETIC CLINIC)</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Diabetic Patient (DIABETIC CLINIC)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($individual['visit_date']) {
                                                                                        print_r($individual['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="patient_status">
                                                    <label for="patient_status" class="form-label">Patient Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('patient_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="patient_status" id="patient_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['patient_status'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="work_place">
                                                    <label for="work_place" class="form-label">Place of Work</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('work_place', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="work_place" id="work_place<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['work_place'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="work_place_other" class="form-label">If Other explain ?</label>
                                                            <input type="text" value="<?php if ($individual['work_place_other']) {
                                                                                            print_r($individual['work_place_other']);
                                                                                        } ?>" id="work_place_other" name="work_place_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="referred_by">
                                                    <label for="referred_by" class="form-label">Referred by ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('referred', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="referred_by" id="referred_by<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['referred_by'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="referred_other" class="form-label">If Other explain ?</label>
                                                            <input type="text" value="<?php if ($individual['referred_other']) {
                                                                                            print_r($individual['referred_other']);
                                                                                        } ?>" id="referred_other" name="referred_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="dot_options">
                                                    <label for="decision_making" class="form-label">DOT Option</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dot_options', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="dot_options" id="dot_options<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['dot_options'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="classification">
                                                    <label for="classification" class="form-label">Classification by site</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('classification', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="classification" id="classification<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['classification'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sputum_smear">
                                                    <label for="sputum_smear" class="form-label">Sputum test Smear Before treatment </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sputum_smear', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sputum_smear" id="sputum_smear<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['sputum_smear'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sputum_gene_xpert">
                                                    <label for="sputum_gene_xpert" class="form-label">Sputum Gene Xpert Before Treatment </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sputum_gene_xpert', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sputum_gene_xpert" id="sputum_gene_xpert<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['sputum_gene_xpert'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">TB</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-3" id="started_tb1">
                                                    <div class="mb-2">
                                                        <label for="started_tb" class="form-label">Date Started TB Treatmen</label>
                                                        <input type="date" value="<?php if ($individual['started_tb']) {
                                                                                        print_r($individual['started_tb']);
                                                                                    } ?>" id="started_tb" name="started_tb" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ctc_date" class="form-label">Date transferred to CTC</label>
                                                        <input type="date" value="<?php if ($individual['ctc_date']) {
                                                                                        print_r($individual['ctc_date']);
                                                                                    } ?>" id="ctc_date" name="ctc_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="hiv_status">
                                                    <label for="hiv_status" class="form-label">HIV Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('hiv_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['hiv_status'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="diabetic_status">
                                                    <label for="diabetic_status" class="form-label">Diabetic Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="diabetic_status" id="diabetic_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['diabetic_status'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="rbg_done">
                                                    <label for="rbg_done" class="form-label">If No, RBG Done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rbg_done" id="rbg_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['rbg_done'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="vaccinations_status">
                                                    <label for="opportunistic" class="form-label">COVID-19 Vaccination Status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('vaccinations_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="vaccinations_status" id="vaccinations_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['vaccinations_status'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="vaccination_date" class="form-label">If Vaccinated, Date Vaccinated</label>
                                                            <input type="date" value="<?php if ($individual['vaccination_date']) {
                                                                                            print_r($individual['vaccination_date']);
                                                                                        } ?>" id="vaccination_date" name="vaccination_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="tuberculosis_outcome">
                                                    <label for="tuberculosis_outcome" class="form-label">Tuberculosis Treatment Outcome </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tuberculosis_outcome" id="tuberculosis_outcome<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tuberculosis_outcome'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="tb_outcome_date_cured" class="form-label">Date Cured</label>
                                                            <label for="tb_outcome_date_completed" class="form-label">Date Treatment Completed </label>
                                                            <label for="tb_outcome_date_death" class="form-label">Date of Death</label>
                                                            <label for="tb_outcome_date_last_seen" class="form-label">Date last seen (Last visit date) </label>
                                                            <input type="date" value="<?php if ($individual['tb_outcome_date']) {
                                                                                            print_r($individual['tb_outcome_date']);
                                                                                        } ?>" id="tb_outcome_date" name="tb_outcome_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="tb_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_complete" id="tb_complete<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tb_complete'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_diabetic" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 13) { ?>

            <?php
            $screening = $override->get3('screening', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($screening) { ?>
                                    <h1>Add New Screening</h1>
                                <?php } else { ?>
                                    <h1>Update Screening</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Screening</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Screening</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Screeing Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Screening</label>
                                                        <input type="date" value="<?php if ($screening['screening_date']) {
                                                                                        print_r($screening['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter here" required>
                                                            <?php if ($screening['comments']) {
                                                                print_r($screening['comments']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_enrollment" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 14) { ?>

        <?php } elseif ($_GET['id'] == 15) { ?>

        <?php } elseif ($_GET['id'] == 16) { ?>


        <?php } elseif ($_GET['id'] == 17) { ?>

        <?php } elseif ($_GET['id'] == 18) { ?>

        <?php } elseif ($_GET['id'] == 19) { ?>

        <?php } elseif ($_GET['id'] == 20) { ?>

        <?php } elseif ($_GET['id'] == 21) { ?>

        <?php } elseif ($_GET['id'] == 22) { ?>

        <?php } elseif ($_GET['id'] == 23) { ?>
        <?php } elseif ($_GET['id'] == 24) { ?>
        <?php } elseif ($_GET['id'] == 25) { ?>
        <?php } elseif ($_GET['id'] == 26) { ?>
        <?php } elseif ($_GET['id'] == 27) { ?>
        <?php } elseif ($_GET['id'] == 28) { ?>

        <?php } ?>

        <?php include 'footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <!-- Page specific script -->


    <!-- clients Js -->
    <script src="myjs/add/clients/insurance.js"></script>
    <script src="myjs/add/clients/insurance_name.js"></script>
    <script src="myjs/add/clients/relation_patient.js"></script>
    <!-- <script src="myjs/add/clients/validate_hidden_with_values.js"></script>
    <script src="myjs/add/clients/validate_required_attribute.js"></script>
    <script src="myjs/add/clients/validate_required_radio_checkboxes.js"></script> -->

    <!-- SCREENING Js -->
    <script src="myjs/add/screening/conset.js"></script>
    <script src="myjs/add/screening/art.js"></script>



    <!-- HISTORY Js -->
    <script src="myjs/add/history/art_regimen.js"></script>
    <script src="myjs/add/history/tb.js"></script>
    <script src="myjs/add/history/first_line.js"></script>
    <script src="myjs/add/history/second_line.js"></script>
    <script src="myjs/add/history/third_line.js"></script>
    <script src="myjs/add/history"></script>

    <script src="myjs/add/checkbox1.js"></script>
    <script src="myjs/add/radio.js"></script>
    <script src="myjs/add/radios1.js"></script>
    <script src="myjs/add/radios2.js"></script>
    <script src="myjs/add/radios3.js"></script>
    <script src="myjs/add/radios4.js"></script>
    <script src="myjs/add/radios96.js"></script>





    <!-- economics format numbers Js -->
    <!-- <script src="myjs/add/economics/format_thousands/consultation.js"></script>
    <script src="myjs/add/economics/format_thousands/days.js"></script>
    <script src="myjs/add/economics/format_thousands/diagnostic.js"></script>
    <script src="myjs/add/economics/format_thousands/food_drinks.js"></script>
    <script src="myjs/add/economics/format_thousands/hours.js"></script>
    <script src="myjs/add/economics/format_thousands/medications.js"></script>
    <script src="myjs/add/economics/format_thousands/member_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/monthly_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/other_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/other_medical_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/support_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/transport.js"></script> -->





    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            $('#regions_id').change(function() {
                var region_id = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#districts_id').html(data);
                    }
                });
            });

            $('#region').change(function() {
                var region = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });

            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "process.php?content=district_id",
                    method: "GET",
                    data: {
                        district_id: district_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#ward').html(data);
                    }
                });
            });

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End


        // $("#packs_per_day, #packs_per_day").on("input", function() {
        //     setTimeout(function() {
        //         var weight = $("#packs_per_day").val();
        //         var height = $("#packs_per_day").val() / 100; // Convert cm to m
        //         var bmi = weight / (height * height);
        //         $("#packs_per_year").text(bmi.toFixed(2));
        //     }, 1);
        // });
    </script>

</body>

</html>