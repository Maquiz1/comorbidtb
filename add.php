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
                'screening_date' => array(
                    'required' => true,
                ),
                'tb_id' => array(
                    'required' => true,
                ),
                'conset' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {
                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    if ((Input::get('conset') == 1 && Input::get('age18above') == 1)) {
                        $eligible = 1;
                    } else {
                        $eligible = 2;
                    }

                    if (Input::get('conset') == 2 && !empty(trim(Input::get('conset_date')))) {
                        $errorMessage = 'Please Remove Conset date before Submit again';
                    } else {
                        if ($clients) {
                            $user->updateRecord('clients', array(
                                'screening_date' => Input::get('screening_date'),
                                'tb_treatment' => Input::get('tb_treatment'),
                                'tb_treatment_other' => Input::get('tb_treatment_other'),
                                'conset' => Input::get('conset'),
                                'conset_date' => Input::get('conset_date'),
                                'hospital_id' => Input::get('hospital_id'),
                                'tb_id' => Input::get('tb_id'),
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'age18above' => Input::get('age18above'),
                                'mdr_xdr' => Input::get('mdr_xdr'),
                                'new_tb_patient' => Input::get('new_tb_patient'),
                                'extra_pulmonary' => Input::get('extra_pulmonary'),
                                'comments' => Input::get('comments'),
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients[0]['site_id'],
                                'eligible' => $eligible,
                            ), $_GET['cid']);

                            $user->visit_updates(1, $clients[0]['study_id'], Input::get('screening_date'), Input::get('comments'), $clients[0]['id'], $user->data()->id, $clients[0]['site_id'], $eligible);

                            $successMessage = 'Client Updated Successful';
                        } else {
                            $std_id = $override->getNews('study_id', 'site_id', $_GET['site_id'], 'status', 0)[0];

                            $user->createRecord('clients', array(
                                'screening_date' => Input::get('screening_date'),
                                'tb_treatment' => Input::get('tb_treatment'),
                                'tb_treatment_other' => Input::get('tb_treatment_other'),
                                'conset' => Input::get('conset'),
                                'conset_date' => Input::get('conset_date'),
                                'age18above' => Input::get('age18above'),
                                'mdr_xdr' => Input::get('mdr_xdr'),
                                'new_tb_patient' => Input::get('new_tb_patient'),
                                'extra_pulmonary' => Input::get('extra_pulmonary'),
                                'hospital_id' => Input::get('hospital_id'),
                                'tb_id' => Input::get('tb_id'),
                                'study_id' => $std_id['study_id'],
                                'pid' => $std_id['study_id'],
                                'comments' => Input::get('comments'),
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $_GET['site_id'],
                                'status' => 1,
                                'screened' => 1,
                                'eligible' => $eligible,
                                'enrolled' => 0,
                                'end_study' => 0,
                            ));

                            $last_row = $override->lastRow('clients', 'id')[0];

                            $user->updateRecord('study_id', array(
                                'status' => 1,
                                'client_id' => $last_row['id'],
                            ), $std_id['id']);

                            $user->visit_updates(1, $std_id['study_id'], Input::get('screening_date'), Input::get('comments'), $last_row['id'], $user->data()->id, $_GET['site_id'], $eligible);


                            $successMessage = 'Client  Added Successful';
                        }

                        Redirect::to('info.php?id=3&status=7');

                        // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_baseline')) {
            $validate = $validate->check($_POST, array(
                'tarehe_mahojiano' => array(
                    'required' => true,
                ),
                // 'tb_kugundulika' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->get3('comorbidtb_baseline', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);
                $age = $user->dateDiffYears($clients['screening_date'], Input::get('qn01'));

                $qn65 = implode(',', Input::get('qn65'));


                if ($individual) {

                    $user->updateRecord('comorbidtb_baseline', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $_GET['study_id'],
                        'study_id' => $_GET['study_id'],
                        'mkoa' => Input::get('mkoa'),
                        'wilaya' => Input::get('wilaya'),
                        'kituo' => $clients['site_id'],
                        'tarehe_mahojiano' => Input::get('tarehe_mahojiano'),
                        'qn01' => Input::get('qn01'),
                        'age' => $age,
                        'qn02' => Input::get('qn02'),
                        'qn03' => Input::get('qn03'),
                        'qn04' => Input::get('qn04'),
                        'qn05' => Input::get('qn05'),
                        'qn06' => Input::get('qn06'),
                        'qn06_date' => Input::get('qn06_date'),
                        'qn07' => Input::get('qn07'),
                        'qn07_date' => Input::get('qn07_date'),
                        'qn08' => Input::get('qn08'),
                        'qn09' => Input::get('qn09'),
                        'qn10' => Input::get('qn10'),
                        'qn10_miaka' => Input::get('qn10_miaka'),
                        'qn11' => Input::get('qn11'),
                        'qn12' => Input::get('qn12'),
                        'qn13' => Input::get('qn13'),
                        'qn14' => Input::get('qn14'),
                        'qn14_other' => Input::get('qn14_other'),
                        'qn15' => Input::get('qn15'),
                        'qn16' => Input::get('qn16'),
                        'qn17' => Input::get('qn17'),
                        'qn18' => Input::get('qn18'),
                        'qn19' => Input::get('qn19'),
                        'qn20' => Input::get('qn20'),
                        'qn21' => Input::get('qn21'),
                        'qn22' => Input::get('qn22'),
                        'qn23' => Input::get('qn23'),
                        'qn24' => Input::get('qn24'),
                        'qn25' => Input::get('qn25'),
                        'qn25_idadi' => Input::get('qn25_idadi'),
                        'qn26' => Input::get('qn26'),
                        'qn26_idadi' => Input::get('qn26_idadi'),
                        'qn27' => Input::get('qn27'),
                        'qn27_idadi' => Input::get('qn27_idadi'),
                        'qn28' => Input::get('qn28'),
                        'qn28_idadi' => Input::get('qn28_idadi'),
                        'qn29' => Input::get('qn29'),
                        'qn30' => Input::get('qn30'),
                        'qn31' => Input::get('qn31'),
                        'qn32' => Input::get('qn32'),
                        'qn33' => Input::get('qn33'),
                        'qn34' => Input::get('qn34'),
                        'qn35' => Input::get('qn35'),
                        'qn36' => Input::get('qn36'),
                        'qn37_saa' => Input::get('qn37_saa'),
                        'qn37_dakika' => Input::get('qn37_dakika'),
                        'qn38' => Input::get('qn38'),
                        'qn39' => Input::get('qn39'),
                        'qn40' => Input::get('qn40'),
                        'qn41' => Input::get('qn41'),
                        'qn42' => Input::get('qn42'),
                        'qn43' => Input::get('qn43'),
                        'qn44' => Input::get('qn44'),
                        'qn45' => Input::get('qn45'),
                        'qn46' => Input::get('qn46'),
                        'qn47' => Input::get('qn47'),
                        'qn48' => Input::get('qn48'),
                        'qn49' => Input::get('qn49'),
                        'qn50' => Input::get('qn50'),
                        'qn51' => Input::get('qn51'),
                        'qn52' => Input::get('qn52'),
                        'qn53' => Input::get('qn53'),
                        'qn54' => Input::get('qn54'),
                        'qn55' => Input::get('qn55'),
                        'qn56' => Input::get('qn56'),
                        'qn57' => Input::get('qn57'),
                        'qn58' => Input::get('qn58'),
                        'qn59' => Input::get('qn59'),
                        'qn60_diastolic_1' => Input::get('qn60_diastolic_1'),
                        'qn60_systolic_1' => Input::get('qn60_systolic_1'),
                        'qn60_diastolic_2' => Input::get('qn60_diastolic_2'),
                        'qn60_systolic_2' => Input::get('qn60_systolic_2'),
                        'qn60_diastolic_3' => Input::get('qn60_diastolic_3'),
                        'qn60_systolic_3' => Input::get('qn60_systolic_3'),
                        'qn61' => Input::get('qn61'),
                        'qn61_date' => Input::get('qn61_date'),
                        'qn62' => Input::get('qn62'),
                        'qn62_i' => Input::get('qn62_i'),
                        'qn63' => Input::get('qn63'),
                        'qn63_date' => Input::get('qn63_date'),
                        'qn63_kunywa' => Input::get('qn63_kunywa'),                        
                        'qn64' => Input::get('qn64'),
                        'qn65' => $qn65,
                        'qn65_other' => Input::get('qn65_other'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'Baseline Data Successful Updated';
                } else {
                    $user->createRecord('comorbidtb_baseline', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $_GET['study_id'],
                        'study_id' => $_GET['study_id'],
                        'mkoa' => Input::get('mkoa'),
                        'wilaya' => Input::get('wilaya'),
                        'kituo' => $clients['site_id'],
                        'tarehe_mahojiano' => Input::get('tarehe_mahojiano'),
                        'qn01' => Input::get('qn01'),
                        'age' => $age,
                        'qn02' => Input::get('qn02'),
                        'qn03' => Input::get('qn03'),
                        'qn04' => Input::get('qn04'),
                        'qn05' => Input::get('qn05'),
                        'qn06' => Input::get('qn06'),
                        'qn06_date' => Input::get('qn06_date'),
                        'qn07' => Input::get('qn07'),
                        'qn07_date' => Input::get('qn07_date'),
                        'qn08' => Input::get('qn08'),
                        'qn09' => Input::get('qn09'),
                        'qn10' => Input::get('qn10'),
                        'qn10_miaka' => Input::get('qn10_miaka'),
                        'qn11' => Input::get('qn11'),
                        'qn12' => Input::get('qn12'),
                        'qn13' => Input::get('qn13'),
                        'qn14' => Input::get('qn14'),
                        'qn14_other' => Input::get('qn14_other'),
                        'qn15' => Input::get('qn15'),
                        'qn16' => Input::get('qn16'),
                        'qn17' => Input::get('qn17'),
                        'qn18' => Input::get('qn18'),
                        'qn19' => Input::get('qn19'),
                        'qn20' => Input::get('qn20'),
                        'qn21' => Input::get('qn21'),
                        'qn22' => Input::get('qn22'),
                        'qn23' => Input::get('qn23'),
                        'qn24' => Input::get('qn24'),
                        'qn25' => Input::get('qn25'),
                        'qn25_idadi' => Input::get('qn25_idadi'),
                        'qn26' => Input::get('qn26'),
                        'qn26_idadi' => Input::get('qn26_idadi'),
                        'qn27' => Input::get('qn27'),
                        'qn27_idadi' => Input::get('qn27_idadi'),
                        'qn28' => Input::get('qn28'),
                        'qn28_idadi' => Input::get('qn28_idadi'),
                        'qn29' => Input::get('qn29'),
                        'qn30' => Input::get('qn30'),
                        'qn31' => Input::get('qn31'),
                        'qn32' => Input::get('qn32'),
                        'qn33' => Input::get('qn33'),
                        'qn34' => Input::get('qn34'),
                        'qn35' => Input::get('qn35'),
                        'qn36' => Input::get('qn36'),
                        'qn37_saa' => Input::get('qn37_saa'),
                        'qn37_dakika' => Input::get('qn37_dakika'),
                        'qn38' => Input::get('qn38'),
                        'qn39' => Input::get('qn39'),
                        'qn40' => Input::get('qn40'),
                        'qn41' => Input::get('qn41'),
                        'qn42' => Input::get('qn42'),
                        'qn43' => Input::get('qn43'),
                        'qn44' => Input::get('qn44'),
                        'qn45' => Input::get('qn45'),
                        'qn46' => Input::get('qn46'),
                        'qn47' => Input::get('qn47'),
                        'qn48' => Input::get('qn48'),
                        'qn49' => Input::get('qn49'),
                        'qn50' => Input::get('qn50'),
                        'qn51' => Input::get('qn51'),
                        'qn52' => Input::get('qn52'),
                        'qn53' => Input::get('qn53'),
                        'qn54' => Input::get('qn54'),
                        'qn55' => Input::get('qn55'),
                        'qn56' => Input::get('qn56'),
                        'qn57' => Input::get('qn57'),
                        'qn58' => Input::get('qn58'),
                        'qn59' => Input::get('qn59'),
                        'qn60_diastolic_1' => Input::get('qn60_diastolic_1'),
                        'qn60_systolic_1' => Input::get('qn60_systolic_1'),
                        'qn60_diastolic_2' => Input::get('qn60_diastolic_2'),
                        'qn60_systolic_2' => Input::get('qn60_systolic_2'),
                        'qn60_diastolic_3' => Input::get('qn60_diastolic_3'),
                        'qn60_systolic_3' => Input::get('qn60_systolic_3'),
                        'qn61' => Input::get('qn61'),
                        'qn61_date' => Input::get('qn61_date'),
                        'qn62' => Input::get('qn62'),
                        'qn62_i' => Input::get('qn62_i'),
                        'qn63' => Input::get('qn63'),
                        'qn63_date' => Input::get('qn63_date'),
                        'qn63_kunywa' => Input::get('qn63_kunywa'),                        
                        'qn64' => Input::get('qn64'),
                        'qn65' => $qn65,
                        'qn65_other' => Input::get('qn65_other'),
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

                    $successMessage = 'Baseline Data  Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients['id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_follow_up')) {
            $validate = $validate->check($_POST, array(
                'tarehe_mahojiano' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->get3('comorbidtb_follow_up', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($individual) {

                    $user->updateRecord('comorbidtb_follow_up', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $_GET['study_id'],
                        'study_id' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'tarehe_mahojiano' => Input::get('tarehe_mahojiano'),
                        'qn66' => Input::get('qn66'),
                        'qn67' => Input::get('qn67'),
                        'qn68' => Input::get('qn68'),
                        'qn69' => Input::get('qn69'),
                        'qn70' => Input::get('qn70'),
                        'qn71' => Input::get('qn71'),
                        'tb_outcome_date' => Input::get('tb_outcome_date'),
                        'tb_complete' => Input::get('tb_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'Follow Up Data Successful Updated';
                } else {
                    $user->createRecord('comorbidtb_follow_up', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $_GET['study_id'],
                        'study_id' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'tarehe_mahojiano' => Input::get('tarehe_mahojiano'),
                        'qn66' => Input::get('qn66'),
                        'qn67' => Input::get('qn67'),
                        'qn68' => Input::get('qn68'),
                        'qn69' => Input::get('qn69'),
                        'qn70' => Input::get('qn70'),
                        'qn71' => Input::get('qn71'),
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

                    $successMessage = 'Follow Up Data Successful Added';
                }

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
                            // $relation = $override->get('relation', 'id', $clients['relation_patient'])[0];
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            // $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            // $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            // $household = $override->get('household', 'id', $clients['head_household'])[0];

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
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Screning Date:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="screening_date" id="screening_date" value="<?php if ($clients['screening_date']) {
                                                                                                                                                                                        print_r($clients['screening_date']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>TB Clinic Number</label>
                                                            <input class="form-control" type="text" name="tb_id" id="tb_id" placeholder="Type here..." onkeyup="fetchData()" value="<?php if ($clients['tb_id']) {
                                                                                                                                                                                        print_r($clients['tb_id']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>HOSPITAL ID</label>
                                                            <input class="form-control" type="text" name="hospital_id" id="hospital_id" placeholder="Type here..." onkeyup="fetchData()" value="<?php if ($clients['hospital_id']) {
                                                                                                                                                                                                    print_r($clients['hospital_id']);
                                                                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Namba ya Mshiriki (PID)</label>
                                                            <input class="form-control" type="text" value="<?php if ($clients['study_id']) {
                                                                                                                print_r($clients['study_id']);
                                                                                                            }  ?>" readonly />
                                                            <!-- <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="ctc_id" id="ctc_id" placeholder="Type CTC ID..." value="" required /> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="new_tb_patient" class="form-label">New TB Patient?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="new_tb_patient" id="new_tb_patient<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['new_tb_patient'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="extra_pulmonary" class="form-label">Extra Pulmonary TB?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="extra_pulmonary" id="extra_pulmonary<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['extra_pulmonary'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="mdr_xdr" class="form-label">MDR / XDR Patient ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mdr_xdr" id="mdr_xdr<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['mdr_xdr'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="age18above" class="form-label">18 years and above ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="age18above" id="age18above<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['age18above'] == $value['id']) {
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
                                                <div class="col-sm-3">
                                                    <label for="conset" class="form-label">Type of TB Treatment Given?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_treatment', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_treatment" id="tb_treatment<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['tb_treatment'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="tb_treatment_other1">
                                                    <div class="mb-2">
                                                        <label for="tb_treatment_other" class="form-label">If Other Mention</label>
                                                        <input type="text" value="<?php if ($clients['tb_treatment_other']) {
                                                                                        print_r($clients['tb_treatment_other']);
                                                                                    } ?>" id="tb_treatment_other" name="tb_treatment_other" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="conset_date1">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($clients['conset_date']) {
                                                                                        print_r($clients['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
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
            $individual = $override->get3('comorbidtb_baseline', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
            $marital_status = $override->get('marital_status', 'id', $individual['qn04'])[0];
            $sex = $override->get('sex', 'id', $individual['qn02'])[0];
            $education = $override->get('education', 'id', $individual['qn03'])[0];
            $occupation = $override->get('occupation', 'id', $individual['qn05'])[0];
            $regions = $override->get('regions', 'id', $individual['mkoa'])[0];
            $districts = $override->get('districts', 'id', $individual['wilaya'])[0];
            // $wards = $override->get('wards', 'id', $individual['ward'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add New Baseline Data</h1>
                                <?php } else { ?>
                                    <h1>Update Baseline Data</h1>
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
                                        <li class="breadcrumb-item active">Add New Baseline Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Baseline Data</li>
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
                                        <h3 class="card-title">Baseline Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">

                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="tarehe_mahojiano" class="form-label">Tarehe ya Mahojiano:</label>
                                                        <input type="date" value="<?php if ($individual['tarehe_mahojiano']) {
                                                                                        print_r($individual['tarehe_mahojiano']);
                                                                                    } ?>" id="tarehe_mahojiano" name="tarehe_mahojiano" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Mkoa</label>
                                                            <select id="region" name="mkoa" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($individual['mkoa']) {
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
                                                            <label>Wilaya</label>
                                                            <select id="district" name="wilaya" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($individual['wilaya']) {
                                                                                                            print_r($districts['name']);
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

                                                <div class="col-sm-4" id="qn01">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>1. Tarehe ya Kuzaliwa:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="qn01" id="qn01" style="width: 100%;" value="<?php if ($individual['qn01']) {
                                                                                                                                                                                        print_r($individual['qn01']);
                                                                                                                                                                                    }  ?>" / required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="sex">
                                                    <label>2. Jinsia</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="qn02" id="qn02" value="1" <?php if ($individual['qn02'] == 1) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="qn02" id="qn02" value="2" <?php if ($individual['qn02'] == 2) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>3. Ni kiwango gani cha elimu cha juu zaidi ulichomaliza?</label>
                                                            <select id="qn03" name="qn03" class="form-control" required>
                                                                <option value="<?= $education['id'] ?>"><?php if ($individual['qn03']) {
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
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>4. Hali ya Ndoa</label>
                                                            <select id="qn04" name="qn04" class="form-control" required>
                                                                <option value="<?= $marital_status['id'] ?>"><?php if ($individual['qn04']) {
                                                                                                                    print_r($marital_status['name']);
                                                                                                                } else {
                                                                                                                    echo 'Select education';
                                                                                                                } ?>
                                                                </option>
                                                                <?php foreach ($override->get('marital_status', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>5. Ni ipi kati ya haya yafuatayo yanaelezea vizuri kazi ambayo umekuwa ukifanya katika miezi 12 iliyopita?</label>
                                                            <select id="qn05" name="qn05" class="form-control" required>
                                                                <option value="<?= $occupation['id'] ?>"><?php if ($individual['qn05']) {
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

                                                <div class="col-sm-4" id="qn05_other1">
                                                    <div class="mb-2">
                                                        <label for="qn05_other1" class="form-label">10. Ingiza miaka</label>
                                                        <input type="text" value="<?php if ($individual['qn05_other']) {
                                                                                        print_r($individual['qn05_other']);
                                                                                    } ?>" id="qn05_other" name="qn05_other" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-3" id="qn06">
                                                    <label for="qn06" class="form-label">6. TB iligundulika kwa njia gani</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_methods', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn06" id="qn06<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn06'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3" id="qn06_date_1">
                                                    <div class="mb-2">
                                                        <label for="qn06_date" class="form-label">6(a) Tarehe TB iliyogundulika: </label>
                                                        <input type="date" value="<?php if ($individual['qn06_date']) {
                                                                                        print_r($individual['qn06_date']);
                                                                                    } ?>" id="qn06_date" name="qn06_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn07">
                                                    <label for="qn07" class="form-label">7. Ameanza dawa za TB</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn07" id="qn07<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn07'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3" id="qn07_date_1">
                                                    <div class="mb-2">
                                                        <label for="qn07_date" class="form-label">7(b) Tarehe ya kuanza dawa za TB:</label>
                                                        <input type="date" value="<?php if ($individual['qn07_date']) {
                                                                                        print_r($individual['qn07_date']);
                                                                                    } ?>" id="qn07_date" name="qn07_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Baseline Form.</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="qn08">
                                                    <label for="qn08" class="form-label">8. Je, kwa sasa unatumia aina yoyote ya tumbaku kama vile sigara, kiko, sigara ya kusokota ,ugoro n.k? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn08" id="qn08<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn08'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="qn09">
                                                    <label for="tumbaku_kilasiku" class="form-label">9. Kama ndiyo, Kwa sasa unavuta sigara au kutumia tumbaku kila siku? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn09" id="qn09<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn09'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <button type="button" onclick="unsetRadio('qn09')">Unselect</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="qn10">
                                                    <label for="sigara_umri" class="form-label">10. Ulikuwa na umri gani ulipoanza kuvuta sigara / kutumia tumbaku kwa mara ya kwanza? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('miaka', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn10" id="qn10<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn10'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <button type="button" onclick="unsetRadio('qn10')">Unselect</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="qn10_miaka_1">
                                                    <div class="mb-2">
                                                        <label for="qn39" class="form-label">10. Ingiza miaka</label>
                                                        <input type="number" value="<?php if ($individual['qn10_miaka']) {
                                                                                        print_r($individual['qn10_miaka']);
                                                                                    } ?>" id="qn10_miaka" name="qn10_miaka" min="0" max="100" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="qn11">
                                                    <label for="kuacha_sigara" class="form-label">11. Kwa kipindi cha mieazi 12 iliyopita,ulijaribu kuacha kuvuta sigara / kutumia tumbaku? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn11" id="qn11<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn11'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn11')">Unselect</button>

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
                                                <div class="col-sm-3" id="qn17">
                                                    <label for="diabetic_status" class="form-label">17. Je, umewahi kutumia kinywaji chenye kilevi (kama vile bia, mvinyo, pombe kali au pombe ya kienyeji)?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn17" id="qn17<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn17'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <button type="button" onclick="unsetRadio('qn17')">Unselect</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn18">
                                                    <label for="qn21" class="form-label">18. Je umekunywa kinywaji chenye kilevi ndani ya miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn18" id="qn18<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn18'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <button type="button" onclick="unsetRadio('qn18')">Unselect</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn19">
                                                    <label for="qn22" class="form-label">19. Kama Hapana Swali 18, Umeacha kunywa pombe kwa sababu za kiafya, kama vile athari mbaya kuhusu afya yako au ushauri kutoka kwa daktari/mfanyakazi wa afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn19" id="qn19<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn19'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn19')">Unselect</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="qn20">
                                                    <label for="qn23" class="form-label">20. Umetumia kinywaji chenye kilevi (kama vile bia, mvinyo, pombe kali au pombe ya kienyeji) katika siku 30 zilizopita? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn20" id="qn20<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn20'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn20')">Unselect</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="qn21">
                                                    <label for="qn24" class="form-label">21. Katika siku 30 zilizopita, ni mara ngapi umekunywa vinywaji 6 au Zaidi vyenye kilevi (standard drink) kwenye mkupuo mmoja? (1 Beer=1 Glass of Wine= 1 Shot of Spirit)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn21" id="qn21<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn21'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn21')">Unselect</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn22">
                                                    <label for="qn22" class="form-label">22. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi umeshindwa kujizuia kunywa pombe mara baada ya kuanza kunywa? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pombe', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn22" id="qn22<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn22'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn22')">Unselect</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn23">
                                                    <label for="qn23" class="form-label">23. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi ulishindwa kufanya ulichotarajiwa kwa sababu ya pombe?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pombe', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn23" id="qn23<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn23'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn23')">Unselect</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn24">
                                                    <label for="qn24" class="form-label">24. Kwa kipindi cha miezi 12 iliyopita, ni mara ngapi ulihitaji pombe asubuhi ili uweze kuendelea na ratiba za siku baada ya kunywa pombe nyingi (kuzimua)?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pombe', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn24" id="qn24<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn24'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn24')">Unselect</button>

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
                                                <div class="col-sm-3" id="qn25">
                                                    <label for="qn25" class="form-label">25. Kwa kawaida ni siku ngapi ndani ya wiki moja unakula matunda? (TUMIA SHOWCARD) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('matunda_kiasi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn25" id="qn25<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn25'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <input type="number" value="<?php if ($individual['qn25_idadi']) {
                                                                                            print_r($individual['qn25_idadi']);
                                                                                        } ?>" id="qn25_idadi" name="qn25_idadi" min="0" max="7" class="form-control" placeholder="Ingiza Idadi Hapa" />

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn25')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn26">
                                                    <label for="qn26" class="form-label">26. Unakula matunda kiasi gani katika moja ya siku hizo? ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('kula_matunda', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn26" id="qn26<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn26'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <input type="number" value="<?php if ($individual['qn26_idadi']) {
                                                                                            print_r($individual['qn26_idadi']);
                                                                                        } ?>" id="qn26_idadi" name="qn26_idadi" min="0" max="10" class="form-control" placeholder="Ingiza Idadi Hapa" />

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn26')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn27">
                                                    <label for="qn31" class="form-label">27. Kwa kawaida ni siku ngapi ndani ya wiki moja unakula mboga za majani? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('matunda_kiasi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn27" id="qn27<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn27'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <input type="number" value="<?php if ($individual['qn27_idadi']) {
                                                                                            print_r($individual['qn27_idadi']);
                                                                                        } ?>" id="qn27_idadi" name="qn27_idadi" min="0" max="7" class="form-control" placeholder="Ingiza Idadi Hapa" />

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn27')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn28">
                                                    <label for="qn28" class="form-label">28. Unakula kiasi gani cha mboga za majani katika moja ya siku hizo? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('kula_matunda2', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn28" id="qn28<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn28'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <input type="number" value="<?php if ($individual['qn28_idadi']) {
                                                                                            print_r($individual['qn28_idadi']);
                                                                                        } ?>" id="qn28_idadi" name="qn28_idadi" min="0" max="10" class="form-control" placeholder="Ingiza Idadi Hapa" />

                                                        </div>
                                                    </div>
                                                    <button type="button" onclick="unsetRadio('qn28')">Unselect</button>

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
                                                <div class="col-sm-3" id="qn29">
                                                    <label for="diabetic_status" class="form-label">29. Je! Ni mara ngapi unaongeza chumvi au mchuzi wa chumvi kama vile siki, chachandu, Soya Sauce, chachandu au achali, ajinomoto kwenye chakula chako kabla ya kula au unapokula? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('kuongeza_chumvi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn29" id="qn29<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn29'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn29')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn30">
                                                    <label for="qn30" class="form-label">30. Ni mara ngapi unakula chakula kilichosindikwa na chumvi nyingi?
                                                        (Ninamaanisha vyakula ambavyo vimebadilishwa kutoka kwa hali yake ya asili, kama vile vitafunio vyenye chumvi, vyakula vya chumvi vilivyosindikwa)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('kuongeza_chumvi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn30" id="qn30<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn30'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn30')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="qn31">
                                                    <label for="qn31" class="form-label">31. Je, unafikiri matumizi yako ya chumvi kwenye chakula, siki, soya sauce, achali au chachandu ni makubwa kiasi gani? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('chumvi_matumizi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn31" id="qn31<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn31'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn31')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="qn32">
                                                    <label for="qn32" class="form-label">32. Je! Unafikiri ni muhimu kiasi gani kwako kupunguza kiasi cha chumvi unachotumia kwenye mlo wako? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('chumvi_umuhimu', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn32" id="qn32<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn32'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn32')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="qn33">
                                                    <label for="qn33" class="form-label">33. Je! Unafikiri kuwa matumizi ya chumvi nyingi kwenye chakula yanaweza yakasababisha matatizo ya kiafya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_don', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn33" id="qn33<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn33'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn33')">Unselect</button>

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
                                                <div class="col-sm-3" id="qn41">
                                                    <label for="qn41" class="form-label">41. Je umeshawahi kuambiwa na daktari au mtoa huduma za afya kuwa una ongezeko la shinikizo la damu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn41" id="qn41<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn41'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn41')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn42">
                                                    <label for="qn42" class="form-label">42. Je umeambiwa hivyo ndani ya miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn42" id="qn42<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn42'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn42')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn43">
                                                    <label for="qn43" class="form-label">43. Katika wiki mbili zilizopita, umetumia vidonge kwa ajili ya ongezeko la shinikizo la damu, au presha kama ilivyoshauriwa na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn43" id="qn43<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn43'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn43')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="qn44">
                                                    <label for="qn44" class="form-label">44. Kwa sasa unatumia aina yoyote ya mitidawa kwa ajili ya ongezeko la shinikizo la damu, au presha?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn44" id="qn44<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn44'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn44')">Unselect</button>

                                                    </div>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="qn45">
                                                    <label for="qn45" class="form-label">45. Umewahi kuambiwa na daktari au mtoa huduma za afya kuwa sukari yako imepanda au una ugonjwa wa kisukari?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn45" id="qn45<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn45'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn45')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="qn46">
                                                    <label for="qn46" class="form-label">46. Je uliambiwa hivyo kwa mara ya kwanza katika kipindi cha miezi 12 iliyopita?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn46" id="qn46<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn46'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn46')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn47">
                                                    <label for="qn47" class="form-label">47. Katika wiki mbili zilizopita, umetumia dawa yoyote kwa ajili ya ugonjwa wa kisukari kama ulivyoandikiwa na daktari au mtoa huduma za afya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn47" id="qn47<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn47'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn47')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn48">
                                                    <label for="qn48" class="form-label">48. Kwa sasa unatumia aina yoyote ya mitidawa kwa ajili ya kisukari?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn48" id="qn48<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn48'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn48')">Unselect</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>


                                            <h2>Je kwa kipindi cha angalau majuma mawili, ni mara ngapi umesumbuliwa na hali zifuatazo:</h2>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="qn49">
                                                    <label for="qn49" class="form-label">49. Ulikuwa na shauku kidogo au kukosa hamu ya kufanya vitu ambavyo kwa kawaida umekuwa ukivifanya na kuvifurahia </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn49" id="qn49<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn49'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn49')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="qn50">
                                                    <label for="qn50" class="form-label">50. Uliona hisia kushuka/kupoteza shauku/kutokufurahia mambo ambayo umekuwa ukiyafurahia</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn50" id="qn50<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn50'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn50')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn51">
                                                    <label for="qn51" class="form-label">51. Ulikuwa na shida ya usingizi zaidi ya ilivyokuwa kawaida (kwa mfano, kupata usingizi, kuendelea kuwa na usingizi) au kulala sana zaidi ya ilivyokawaida </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn51" id="qn51<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn51'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn51')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn52">
                                                    <label for="qn52" class="form-label">52. Ulikuwa na nguvu kidogo kuliko ilivyokuwa kabla au kuchoka zaidi kuliko kawaida hata ukifanya shughuli ndogondogo </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn52" id="qn52<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn52'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn52')">Unselect</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-2" id="qn53">
                                                    <label for="qn53" class="form-label">53. Hukutaka kula hata pale ambapo chakula kilikuwepo au ulikula zaidi kuliko ilivyokukuwa </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn53" id="qn53<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn53'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn53')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="qn54">
                                                    <label for="qn54" class="form-label">54. Umehisi umejiangusha mwenyewe au kuwaangusha wengine </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn54" id="qn54<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn54'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn54')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn55">
                                                    <label for="qn55" class="form-label">55. Umepata shida zaidi kuwa makini na kuendelea kuwa makini kwenye vitu, (mfano: kusikiliza redio, kuangalia luninga) kuliko ilivyo kawaida </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn55" id="qn55<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn55'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn55')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="qn56">
                                                    <label for="qn56" class="form-label">56. Ulitembea/kujongea taratibu zaidi kuliko kawaida au kinyume chake, kukosa utulivu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn56" id="qn56<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn56'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn56')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn57">
                                                    <label for="qn57" class="form-label">57. Swali linalofuata linaweza kuwa swali nyeti/ linalokugusa hisia zako. Umekuwa uliifikiria kuhusu kifo, kujiua au kujaribu kusitisha uhai wako </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('assessments_sijawahi', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn57" id="qn57<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn57'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn57')">Unselect</button>

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
                                                <div class="col-6" id="qn58_1">
                                                    <div class="mb-2">
                                                        <label for="qn58" class="form-label">58. Urefu(cm)</label>
                                                        <input type="number" value="<?php if ($individual['qn58']) {
                                                                                        print_r($individual['qn58']);
                                                                                    } ?>" id="qn58" name="qn58" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                                <div class="col-6" id="qn59_1">
                                                    <div class="mb-2">
                                                        <label for="qn59" class="form-label">59. Uzito (kg)</label>
                                                        <input type="number" value="<?php if ($individual['qn59']) {
                                                                                        print_r($individual['qn59']);
                                                                                    } ?>" id="qn59" name="qn59" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <h2>60. Blood Pressure (Allow 3 minutes of resting between the readings) </h2>
                                            <hr>

                                            <div class="row">
                                                <div class="col-4" id="qn60_1_1">
                                                    <div class="mb-2">
                                                        <label for="qn60_1" class="form-label">60. First reading(mmHg)</label>

                                                        <input type="number" value="<?php if ($individual['qn60_systolic_1']) {
                                                                                        print_r($individual['qn60_systolic_1']);
                                                                                    } ?>" id="qn60_systolic_1" name="qn60_systolic_1" step="any" class="form-control" placeholder="Enter Systolic" required />/
                                                        <input type="number" value="<?php if ($individual['qn60_diastolic_1']) {
                                                                                        print_r($individual['qn60_diastolic_1']);
                                                                                    } ?>" id="qn60_diastolic_1" name="qn60_diastolic_1" step="any" class="form-control" placeholder="Enter Diastolic" required />
                                                    </div>
                                                </div>

                                                <div class="col-4" id="qn60_2_1">
                                                    <div class="mb-2">
                                                        <label for="qn60_2" class="form-label">60. Second reading(mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['qn60_systolic_2']) {
                                                                                        print_r($individual['qn60_systolic_2']);
                                                                                    } ?>" id="qn60_systolic_2" name="qn60_systolic_2" step="any" class="form-control" placeholder="Enter Systolic" required />/
                                                        <input type="number" value="<?php if ($individual['qn60_diastolic_2']) {
                                                                                        print_r($individual['qn60_diastolic_2']);
                                                                                    } ?>" id="qn60_diastolic_2" name="qn60_diastolic_2" step="any" class="form-control" placeholder="Enter Diastolic" required />

                                                    </div>
                                                </div>

                                                <div class="col-4" id="qn60_3_1">
                                                    <div class="mb-2">
                                                        <label for="qn60_3" class="form-label">60. Third reading(mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['qn60_systolic_3']) {
                                                                                        print_r($individual['qn60_systolic_3']);
                                                                                    } ?>" id="qn60_systolic_3" name="qn60_systolic_3" step="any" class="form-control" placeholder="Enter Systolic" required />/
                                                        <input type="number" value="<?php if ($individual['qn60_diastolic_3']) {
                                                                                        print_r($individual['qn60_diastolic_3']);
                                                                                    } ?>" id="qn60_diastolic_3" name="qn60_diastolic_3" step="any" class="form-control" placeholder="Enter Diastolic" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="qn61">
                                                    <label for="qn61" class="form-label">61. Hali ya HIV</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('hiv_status', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn61" id="qn61<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn61'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn61')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-6" id="qn61_date_1">
                                                    <div class="mb-2">
                                                        <label for="qn61_date" class="form-label">61(a). Tarehe aliyopima;</label>
                                                        <input type="date" value="<?php if ($individual['qn61_date']) {
                                                                                        print_r($individual['qn61_date']);
                                                                                    } ?>" id="qn61_date" name="qn61_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-6" id="qn62">
                                                    <label for="qn70" class="form-label">62. Hali ya Kisukari </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn62" id="qn62<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn62'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn62')">Unselect</button>

                                                    </div>
                                                </div>
                                                <div class="col-6" id="qn62_i_1">
                                                    <div class="mb-2">
                                                        <label for="qn62_i" class="form-label">62(i). Fasting Blood Glucose (mmol/L);</label>
                                                        <input type="number" value="<?php if ($individual['qn62_i']) {
                                                                                        print_r($individual['qn62_i']);
                                                                                    } ?>" id="qn62_i" name="qn62_i" step="any" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-4" id="qn63">
                                                    <label for="qn63" class="form-label">63. Ameanza dawa za Kisukari </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn63" id="qn63<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn63'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn63')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-4" id="qn63_date1">
                                                    <div class="mb-2">
                                                        <label for="qn63_date" class="form-label">63(a). Tarehe aliyoanza dawa:;</label>
                                                        <input type="date" value="<?php if ($individual['qn63_date']) {
                                                                                        print_r($individual['qn63_date']);
                                                                                    } ?>" id="qn63_date" name="qn63_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-4" id="qn63_kunywa1">
                                                    <label for="qn63_kunywa" class="form-label">63. Amekunywa leo dawa za Kisukari </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn63_kunywa" id="qn63_kunywa<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn63_kunywa'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn63')">Unselect</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-4" id="qn64">
                                                    <label for="qn64" class="form-label">64.Je, Mshiriki ana ugonjwa mwingine wa muda mrefu zaidi ya TB? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn64" id="qn64<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn64'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn64')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-4" id="qn65">
                                                    <label for="qn65" class="form-label">65. Kama ndio? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('magonjwa', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="qn65[]" id="qn65<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $individual['qn65']) as $qn65) {
                                                                                                                                                                                                    if ($qn65 == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    }
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="qn65_other1">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>If Other Mention:</label>
                                                            <textarea class="form-control" name="qn65_other" id="qn65_other" rows="3" placeholder="Type other here..."><?php if ($individual['qn65_other']) {
                                                                                                                                                                            print_r($individual['qn65_other']);
                                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
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

                                                <div class="col-sm-3" id="tb_complete">
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
                                                <div class="col-3">
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
                                            <input type="submit" name="add_baseline" value="Submit" class="btn btn-primary">
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
            $individual = $override->get3('comorbidtb_follow_up', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add Follow Up Data</h1>
                                <?php } else { ?>
                                    <h1>Update Follow Up Data</h1>
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

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Follow-Up And Treatment Outcome (At Month 6)</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="tarehe_mahojiano" class="form-label">Tarehe ya Mahojiano:</label>
                                                        <input type="date" value="<?php if ($individual['tarehe_mahojiano']) {
                                                                                        print_r($individual['tarehe_mahojiano']);
                                                                                    } ?>" id="tarehe_mahojiano" name="tarehe_mahojiano" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="qn66" class="form-label">66. Je, uchunguzi wa smear wa makohozi Mwishoni wa Mwezi wa Pili yamefanyika?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn66" id="qn66<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn66'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="qn67">
                                                    <label for="qn67" class="form-label">67. If Ndiyo Qn 66, Majibu ya Smear</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn67" id="qn67<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn67'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <button type="button" onclick="unsetRadio('qn67')">Unselect</button>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-6" id="qn68">
                                                    <label for="qn68" class="form-label">68. Je, uchunguzi wa smear wa makohozi Mwishoni wa Mwezi wa tano yamefanyika </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn68" id="qn68<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn68'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="qn69">
                                                    <label for="qn69" class="form-label">69. Kama Ndiyo Qn 68, Majibu </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn69" id="qn69<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn69'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('qn69')">Unselect</button>

                                                    </div>
                                                </div>

                                                <div class="col-3" id="qn70_1">
                                                    <div class="mb-2">
                                                        <label for="qn70" class="form-label">70. Tarehe ya mwisho ya mshiriki:</label>
                                                        <input type="date" value="<?php if ($individual['qn70']) {
                                                                                        print_r($individual['qn70']);
                                                                                    } ?>" id="qn70" name="qn70" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-6" id="qn71">
                                                    <label for="qn71" class="form-label">71. Matokeo ya matumizi yad awa za TB (Tuberculosis Treatment Outcome )</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tuberculosis_treatment', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="qn71" id="qn71<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['qn71'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name2']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="tb_outcome_date_1">
                                                    <div class="mb-2">
                                                        <label for="tb_outcome_date_cured" id="tb_outcome_date_cured" class="form-label">Tarehe ya kupona(Cured)</label>
                                                        <label for="tb_outcome_date_completed" id="tb_outcome_date_completed" class="form-label">Tarehe ya kumaliza matibabu (Completed treatment) </label>
                                                        <label for="tb_outcome_date_death" id="tb_outcome_date_death" class="form-label">Tarehe ya kufariki (Died)</label>
                                                        <label for="tb_outcome_date_last_seen" id="tb_outcome_date_last_seen" class="form-label">Tarehe ya kupotea kwenye ufuatiliaji (Lost to follow up) / Date last seen (Last visit date) </label>
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
                                            <input type="submit" name="add_follow_up" value="Submit" class="btn btn-primary">
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


                                                <!-- <div class="col-sm-3">
                                                    <label for="date_status" class="form-label">18 years or above ?</label> -->
                                                <!-- radio -->
                                                <!-- <div class="row-form clearfix">
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
                                                </div> -->

                                                <!-- <div class="col-sm-3">
                                                    <label for="new_tb" class="form-label">Newly diagnosed TB patient</label>
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
                                                </div> -->

                                            </div>
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
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4" id="conset_date1">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening['conset_date']) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <!-- <div class="col-sm-3">
                                                    <label for="start_anti_b" class="form-label">Started Anti-TB</label>
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
                                            <hr> -->

                                                <!-- <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="diabetes_type1" class="form-label">Diabetes Type 1</label>
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
                                                </div> -->
                                                <?php
                                                //  if ($override->get3('clients', 'status', 1, 'sex', 2, 'id', $_GET['cid'])) {
                                                ?>
                                                <!-- <div class="col-sm-3">
                                                    <label for="extrapulmonary_tb" class="form-label">Extrapulmonary TB</label>
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
                                                </div> -->
                                                <?php
                                                //  }
                                                ?>

                                                <!-- <div class="col-sm-3">
                                                    <label for="mdr_xdr" class="form-label">MDR and XDR patients</label>
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
                                                <div class="col-sm-3"> -->
                                                <!-- <label for="stay" class="form-label">Expected to stay at study area for more than 12 months?</label>
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
                                                </div> -->
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
    <script src="myjs/add/screening/tb_treatment.js"></script>



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





    <!-- BASELINE -->
    <script src="myjs/add/baseline.js"></script>
    <script src="myjs/add/baseline_many.js"></script>
    <!-- <script src="myjs/add/baseline/qn10.js"></script> -->
    <script src="myjs/add/qn07.js"></script>
    <script src="myjs/add/qn08.js"></script>
    <script src="myjs/add/qn10.js"></script>
    <script src="myjs/add/qn17.js"></script>
    <script src="myjs/add/qn18.js"></script>
    <script src="myjs/add/qn25.js"></script>
    <script src="myjs/add/qn26.js"></script>
    <script src="myjs/add/qn27.js"></script>
    <script src="myjs/add/qn28.js"></script>
    <script src="myjs/add/qn41.js"></script>
    <script src="myjs/add/qn45.js"></script>
    <script src="myjs/add/qn61.js"></script>
    <script src="myjs/add/qn62.js"></script>
    <script src="myjs/add/qn63.js"></script>
    <script src="myjs/add/qn64.js"></script>
    <script src="myjs/add/qn65.js"></script>
    <script src="myjs/add/qn66.js"></script>
    <script src="myjs/add/qn67.js"></script>
    <script src="myjs/add/qn68.js"></script>
    <script src="myjs/add/qn69.js"></script>
    <script src="myjs/add/qn70.js"></script>
    <script src="myjs/add/qn71.js"></script>
    <script src="myjs/add/baseline"></script>
    <script src="myjs/add/baseline"></script>
    <script src="myjs/add/baseline"></script>
    <script src="myjs/add/baseline"></script>
    <script src="myjs/add/baseline"></script>
    <script src="myjs/add/baseline"></script>



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