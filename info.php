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
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('delete_generic')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('generic', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'Name Deleted Successful';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
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
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
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
    <title>Lung Cancer Database | Info</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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

        <?php } elseif ($_GET['id'] == 3) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    <?php
                                    if ($user->data()->power == 1) {
                                        if ($_GET['sid'] != null) {
                                            // $pagNum = 0;
                                            // if ($_GET['status'] == 1) {
                                            //     $pagNum = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 2) {
                                            //     $pagNum = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 3) {
                                            //     $pagNum = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 4) {
                                            //     $pagNum = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 5) {
                                            //     $pagNum = $override->countData('clients', 'status', 1, 'site_id', $_GET['site_id']);
                                            // } elseif ($_GET['status'] == 6) {
                                            //     $pagNum = $override->countData2('clients', 'status', 1, 'screened', 0, 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 7) {
                                            //     $pagNum = $override->getCount('clients', 'site_id', $_GET['sid']);
                                            // } elseif ($_GET['status'] == 8) {
                                            //     $pagNum = $override->countData('clients', 'status', 0, 'site_id', $_GET['sid']);
                                            // }
                                            // $pages = ceil($pagNum / $numRec);
                                            // if (!$_GET['page'] || $_GET['page'] == 1) {
                                            //     $page = 0;
                                            // } else {
                                            //     $page = ($_GET['page'] * $numRec) - $numRec;
                                            // }

                                            // if ($_GET['status'] == 1) {
                                            //     $clients = $override->getWithLimit4('clients', 'status', 1, 'screened', 1, 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 2) {
                                            //     $clients = $override->getWithLimit4('clients', 'status', 1, 'eligible', 1, 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 3) {
                                            //     $clients = $override->getWithLimit4('clients', 'status', 1, 'enrolled', 1, 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 4) {
                                            //     $clients = $override->getWithLimit4('clients', 'status', 1, 'end_study', 1, 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 5) {
                                            //     $clients = $override->getWithLimit1('clients', 'status', 1, 'site_id', $_GET['site_id'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 6) {
                                            //     $clients = $override->getWithLimit4('clients', 'status', 1, 'screened', 0, 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 7) {
                                            //     $clients = $override->getWithLimit('clients', 'site_id', $_GET['sid'], $page, $numRec);
                                            // } elseif ($_GET['status'] == 8) {
                                            //     $clients = $override->getWithLimit1('clients', 'status', 0, 'site_id', $_GET['sid'], $page, $numRec);
                                            // }
                                        } else {
                                            $pagNum = 0;
                                            if ($_GET['status'] == 1) {
                                                $pagNum = $override->getCount1('clients', 'status', 1, 'screened', 1);
                                            } elseif ($_GET['status'] == 2) {
                                                $pagNum = $override->getCount1('clients', 'status', 1, 'eligible', 1);
                                            } elseif ($_GET['status'] == 3) {
                                                $pagNum = $override->getCount1('clients', 'status', 1, 'enrolled', 1);
                                            } elseif ($_GET['status'] == 4) {
                                                $pagNum = $override->getCount1('clients', 'status', 1, 'end_study', 1);
                                            } elseif ($_GET['status'] == 5) {
                                                $pagNum = $override->getCount('clients', 'status', 1);
                                            } elseif ($_GET['status'] == 6) {
                                                $pagNum = $override->getCount1('clients', 'status', 1, 'screened', 0);
                                            } elseif ($_GET['status'] == 7) {
                                                $clients = $override->getNo('clients');
                                            } elseif ($_GET['status'] == 8) {
                                                $pagNum = $override->getCount('clients', 'status', 0);
                                            }
                                            $pages = ceil($pagNum / $numRec);
                                            if (!$_GET['page'] || $_GET['page'] == 1) {
                                                $page = 0;
                                            } else {
                                                $page = ($_GET['page'] * $numRec) - $numRec;
                                            }

                                            if ($_GET['status'] == 1) {
                                                $clients = $override->getDataDesc2('clients', 'status', 1, 'screened', 1, 'id');
                                            } elseif ($_GET['status'] == 2) {
                                                $clients = $override->getDataDesc2('clients', 'status', 1, 'eligible', 1, 'id');
                                            } elseif ($_GET['status'] == 3) {
                                                $clients = $override->getDataDesc2('clients', 'status', 1, 'enrolled', 1, 'id');
                                            } elseif ($_GET['status'] == 4) {
                                                $clients = $override->getDataDesc2('clients', 'status', 1, 'end_study', 1, 'id');
                                            } elseif ($_GET['status'] == 5) {
                                                $clients = $override->getDataDesc1('clients', 'status', 1, 'id');
                                            } elseif ($_GET['status'] == 6) {
                                                $clients = $override->getDataDesc2('clients', 'status', 1, 'screened', 0, 'id');
                                            } elseif ($_GET['status'] == 7) {
                                                $clients = $override->getDataDesc('clients', 'id');
                                            } elseif ($_GET['status'] == 8) {
                                                $clients = $override->getDataDesc1('clients', 'status', 0, 'id');
                                            }
                                        }
                                    } else {

                                        $pagNum = 0;
                                        if ($_GET['status'] == 1) {
                                            $pagNum = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 2) {
                                            $pagNum = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 3) {
                                            $pagNum = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 4) {
                                            $pagNum = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 5) {
                                            $pagNum = $override->countData('clients', 'status', 1, 'site_id', $_GET['site_id']);
                                        } elseif ($_GET['status'] == 6) {
                                            $pagNum = $override->countData2('clients', 'status', 1, 'screened', 0, 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 7) {
                                            $pagNum = $override->getCount('clients', 'site_id', $user->data()->site_id);
                                        } elseif ($_GET['status'] == 8) {
                                            $pagNum = $override->countData('clients', 'status', 0, 'site_id', $user->data()->site_id);
                                        }

                                        $pages = ceil($pagNum / $numRec);
                                        if (!$_GET['page'] || $_GET['page'] == 1) {
                                            $page = 0;
                                        } else {
                                            $page = ($_GET['page'] * $numRec) - $numRec;
                                        }

                                        if ($_GET['status'] == 1) {
                                            $clients = $override->getWithLimit4('clients', 'status', 1, 'screened', 1, 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 2) {
                                            $clients = $override->getWithLimit4('clients', 'status', 1, 'eligible', 1, 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 3) {
                                            $clients = $override->getWithLimit4('clients', 'status', 1, 'enrolled', 1, 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 4) {
                                            $clients = $override->getWithLimit4('clients', 'status', 1, 'end_study', 1, 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 5) {
                                            $clients = $override->getWithLimit1('clients', 'status', 1, 'site_id', $_GET['site_id'], $page, $numRec);
                                        } elseif ($_GET['status'] == 6) {
                                            $clients = $override->getWithLimit4('clients', 'status', 1, 'screened', 0, 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 7) {
                                            $clients = $override->getWithLimit('clients', 'site_id', $user->data()->site_id, $page, $numRec);
                                        } elseif ($_GET['status'] == 8) {
                                            $clients = $override->getWithLimit1('clients', 'status', 0, 'site_id', $user->data()->site_id, $page, $numRec);
                                        }
                                    } ?>
                                    <?php
                                    if ($_GET['status'] == 1) {
                                        echo $title = 'Screening';
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 2) {
                                        echo $title = 'Eligibility';
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 3) {
                                        echo  $title = 'Enrollment';
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 4) {
                                        echo $title = 'Termination';
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 5) {
                                        echo  $title = 'Registration';
                                    ?>
                                    <?php
                                    } ?>
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                    <li class="breadcrumb-item active"><?= $title; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        <?php
                                                        if ($_GET['status'] == 1) { ?>
                                                            <h3 class="card-title">List of Screened Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 2) { ?>
                                                            <h3 class="card-title">List of Eligible Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 3) { ?>
                                                            <h3 class="card-title">List of Enrolled Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 4) { ?>
                                                            <h3 class="card-title">List of Terminated Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 5) { ?>
                                                            <h3 class="card-title">List of Registered Clients</h3>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item"><a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item"><a href="add.php?id=4">
                                                                Add new Client > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Study Id</th>
                                                    <th>Age</th>
                                                    <th>Sex</th>
                                                    <th>Interview Type</th>
                                                    <th>Site</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $kap = 0;
                                                $screening = 0;
                                                $health_care = 0;
                                                if ($_GET['interview'] == 1) {
                                                    $interview = 'kap';
                                                } elseif ($_GET['interview'] == 2) {
                                                    $interview = 'screening';
                                                } elseif ($_GET['interview'] == 3) {
                                                    $interview = 'health_care';
                                                }
                                                $x = 1;
                                                foreach ($clients as $value) {
                                                    $yes_no = $override->get('yes_no', 'status', 1)[0];
                                                    $kap = $override->getNews('kap', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $history = $override->getNews('history', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $results = $override->getNews('results', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $classification = $override->getNews('classification', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $economic = $override->getNews('economic', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $sites = $override->getNews('sites', 'status', 1, 'id', $value['site_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $value['firstname'] . '  ' . $value['middlename'] . ' ' . $value['lastname']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['study_id']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['age']; ?>
                                                        </td>
                                                        <?php if ($value['sex'] == 1) { ?>
                                                            <td class="table-user">
                                                                Male
                                                            </td>
                                                        <?php } elseif ($value['sex'] == 2) { ?>
                                                            <td class="table-user">
                                                                Female
                                                            </td>
                                                        <?php } ?>
                                                        <?php if ($value['interview_type'] == 1) { ?>
                                                            <td class="table-user">
                                                                Kap & Screening
                                                            </td>
                                                        <?php } elseif ($value['interview_type'] == 2) { ?>
                                                            <td class="table-user">
                                                                Health Care Worker
                                                            </td>
                                                        <?php } else { ?>
                                                            <td class="table-user">
                                                                None
                                                            </td>
                                                        <?php } ?>

                                                        <td class="table-user">
                                                            <?= $sites['name']; ?>
                                                        </td>
                                                        <?php if ($value['age'] >= 18) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Eligible for KAP <?php if ($value['age'] >= 45 & $value['age'] <= 80) {  ?> & History Screening <?php } ?>
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-danger"> <i class="ri-edit-box-line"></i>Not Eligible</a>
                                                            </td>
                                                        <?php } ?>
                                                        <td class="text-center">
                                                            <a href="add.php?id=4&cid=<?= $value['id'] ?>&status=<?= $_GET['status'] ?>" class="btn btn-info"> <i class="ri-edit-box-line"></i>Update</a>
                                                            <?php if ($value['age'] >= 18) { ?>
                                                                <a href="info.php?id=4&cid=<?= $value['id'] ?>&status=<?= $_GET['status'] ?>" class="btn btn-warning"> <i class="ri-edit-box-line"></i>Add CRF's</a>
                                                            <?php   } ?>
                                                        </td>
                                                    </tr>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Study Id</th>
                                                    <th>Age</th>
                                                    <th>Sex</th>
                                                    <th>Interview Type</th>
                                                    <th>Site</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
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
                                <h1>Participant Schedules</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Participant Schedules</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <?php
                                        $patient = $override->get('clients', 'id', $_GET['cid'])[0];
                                        // $visits_status = $override->firstRow1('visit', 'status', 'id', 'patient_id', $_GET['cid'], 'visit_code', 'EV')[0]['status'];

                                        $patient = $override->get('clients', 'id', $_GET['cid'])[0];
                                        $cat = '';

                                        if ($patient['interview_type'] == 1) {
                                            $cat = 'Kap & Screening';
                                        } elseif ($patient['interview_type'] == 2) {
                                            $cat = 'Health Care Worker';
                                        } else {
                                            $cat = 'Not Screened';
                                        }


                                        if ($patient['sex'] == 1) {
                                            $gender = 'Male';
                                        } elseif ($patient['sex'] == 2) {
                                            $gender = 'Female';
                                        }

                                        $name = 'Name: ' . $patient['firstname'] . ' ' . $patient['lastname'] . ' Age: ' . $patient['age'] . ' Gender: ' . $gender . ' Type: ' . $cat;

                                        ?>


                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <h1>Study ID: <?= $patient['study_id'] ?><h4><?= $name ?></h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <ol class="breadcrumb float-sm-right">
                                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status'] ?>">
                                                            < Back</a>
                                                    </li>
                                                    <li class="breadcrumb-item">
                                                            <a href="index1.php">Go Home</a>
                                                        </a>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Client ID</th>
                                                    <th>Visit Day</th>
                                                    <th>Expected Date</th>
                                                    <th>Visit Date</th>
                                                    <th>SITE</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x = 1;
                                                foreach ($override->get('visit', 'patient_id', $_GET['cid']) as $visit) {
                                                    $clients = $override->get('clients', 'id', $_GET['cid'])[0];
                                                    $site = $override->get('sites', 'id', $visit['site_id'])[0];
                                                    $kap = $override->get('kap', 'patient_id', $_GET['cid']);
                                                    $history = $override->get('history', 'patient_id', $_GET['cid']);
                                                    $results = $override->get('results', 'patient_id', $_GET['cid']);
                                                    $classification = $override->get('classification', 'patient_id', $_GET['cid']);
                                                    $economic = $override->get('economic', 'patient_id', $_GET['cid']);
                                                    $outcome = $override->get('outcome', 'patient_id', $_GET['cid']);
                                                    // $kap = $override->get3('kap', 'patient_id', $_GET['cid'], 'seq_no', $visit['seq_no'], 'visit_code', $visit['visit_code']);
                                                    // $vital = $override->get3('vital', 'patient_id', $_GET['cid'], 'seq_no', $visit['seq_no'], 'visit_code', $visit['visit_code']);                                                   
                                                ?>
                                                    <tr>
                                                        <td><?= $clients['study_id'] ?></td>
                                                        <td> <?= $visit['visit_name'] ?></td>
                                                        <td> <?= $visit['expected_date'] ?></td>
                                                        <td> <?= $visit['visit_date'] ?> </td>
                                                        <td> <?= $site['name'] ?> </td>
                                                        <td>
                                                            <?php if ($visit['visit_status'] == 1) { ?>
                                                                <a href="#editVisit<?= $visit['id'] ?>" role="button" class="btn btn-success" data-toggle="modal">
                                                                    Done <?php if ($clients['eligible'] == 1) {  ?> & ELigible for Tests <?php } else { ?>& <p style="color:#FF0000" ;>Not ELigible for Tests</p> <?php } ?>
                                                                </a>
                                                            <?php } elseif ($visit['visit_status'] == 0) { ?>
                                                                <a href="#editVisit<?= $visit['id'] ?>" role="button" class="btn btn-warning" data-toggle="modal">
                                                                    Pending <?php if ($clients['eligible'] == 1) {  ?> & ELigible for Tests <?php } else { ?>& <p style="color:#FF0000" ;>> Not ELigible for Tests </p><?php } ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>

                                                        <td>
                                                            <?php if ($visit['visit_status'] == 1) { ?>
                                                                <?php if ($visit['sequence'] == 0) { ?>
                                                                    <?php if ($kap) { ?>
                                                                        <a href="add.php?id=5&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update KAP </a>&nbsp;&nbsp;
                                                                    <?php } else { ?>
                                                                        <a href="add.php?id=5&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add KAP </a>
                                                                    <?php } ?>

                                                                    <?php if ($clients['age'] >= 45 && $clients['age'] <= 80) { ?>
                                                                        <?php if ($history) { ?>
                                                                            <a href="add.php?id=6&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update History </a>&nbsp;&nbsp;
                                                                        <?php } else { ?>
                                                                            <a href="add.php?id=6&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add History </a>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>



                                                            <?php if ($visit['visit_status'] == 1) { ?>
                                                                <?php if ($visit['sequence'] == 1) { ?>
                                                                    <?php if ($clients['age'] >= 45 && $clients['age'] <= 80) { ?>
                                                                        <?php if ($history[0]['eligible'] == 1) { ?>
                                                                            <?php if ($results) { ?>
                                                                                <a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Results </a>&nbsp;&nbsp;
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Results </a>
                                                                            <?php } ?>

                                                                            <?php if ($classification) { ?>
                                                                                <a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Classification </a>&nbsp;&nbsp;
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Classification </a>
                                                                            <?php } ?>

                                                                            <?php if ($outcome) { ?>
                                                                                <a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Outcome </a>&nbsp;&nbsp;
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Outcome </a>
                                                                            <?php } ?>

                                                                            <?php if ($economic) { ?>
                                                                                <a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Economic </a>&nbsp;&nbsp;
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Economic </a>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>




                                                            <?php if ($visit['visit_status'] == 1) { ?>
                                                                <?php if ($visit['sequence'] == 2) { ?>
                                                                    <?php if ($clients['age'] >= 45 && $clients['age'] <= 80) { ?>
                                                                        <?php if ($history[0]['eligible'] == 1) { ?>
                                                                            <?php if ($results) { ?>
                                                                                <a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Results </a>
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Results </a>
                                                                            <?php } ?>


                                                                            <?php if ($classification) { ?>
                                                                                <a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Classification </a>
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Classification </a>
                                                                            <?php } ?>

                                                                            <?php if ($outcome) { ?>
                                                                                <a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Outcome </a>
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Outcome </a>
                                                                            <?php } ?>

                                                                            <?php if ($economic) { ?>
                                                                                <a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-info"> Update Economic </a>
                                                                            <?php } else { ?>
                                                                                <a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&sequence=<?= $visit['sequence'] ?>&visit_code=<?= $visit['visit_code'] ?>&study_id=<?= $visit['study_id'] ?>&status=<?= $_GET['status'] ?>" role=" button" class="btn btn-warning"> Add Economic </a>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>


                                                            <?php if (($visit['visit_code'] == 'FV' || $visit['visit_code'] == 'TV' || $visit['visit_code'] == 'UV')) { ?>

                                                                <?php if ($visit['status'] == 1 && ($visit['visit_code'] == 'EV' || $visit['visit_code'] == 'FV' || $visit['visit_code'] == 'TV' || $visit['visit_code'] == 'UV')) { ?>

                                                                    <?php if ($vital && $symptoms && $results && $hospitalization && $treatment_plan && $dgns_complctns_comorbdts && $risks && $hospitalization_details  && $lab_details) { ?>

                                                                        <a href="info.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $visit['id'] ?>&vcode=<?= $visit['visit_code'] ?>&seq=<?= $visit['seq_no'] ?>&sid=<?= $visit['study_id'] ?>&vday=<?= $visit['visit_day'] ?>&status=<?= $_GET['status'] ?>" role="button" class="btn btn-info"> Edit Study Forms </a>


                                                                    <?php } else { ?>
                                                                        <a href="info.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $visit['id'] ?>&vcode=<?= $visit['visit_code'] ?>&seq=<?= $visit['seq_no'] ?>&sid=<?= $visit['study_id'] ?>&vday=<?= $visit['visit_day'] ?>&status=<?= $_GET['status'] ?>" role="button" class="btn btn-warning"> Fill Study Forms </a>

                                                            <?php }
                                                                }
                                                            } ?>

                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="editVisit<?= $visit['id'] ?>">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Update visit Status</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Visit Date</label>
                                                                                        <input value="<?php if ($visit['status'] != 0) {
                                                                                                            echo $visit['visit_date'];
                                                                                                        } ?>" class="form-control" type="date" name="visit_date" id="visit_date" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="mb-2">
                                                                                    <label for="income_household" class="form-label">Visit Status</label>
                                                                                    <select class="form-control" id="visit_status" name="visit_status" style="width: 100%;" required>
                                                                                        <option value="<?= $visit['visit_status'] ?>"><?php if ($visit) {
                                                                                                                                            if ($visit['visit_status'] == 1) {
                                                                                                                                                echo 'Attended';
                                                                                                                                            } elseif ($visit['visit_status'] == 2) {
                                                                                                                                                echo 'Missed';
                                                                                                                                            }
                                                                                                                                        } else {
                                                                                                                                            echo 'Select';
                                                                                                                                        } ?>
                                                                                        </option>
                                                                                        <option value="1">Attended</option>
                                                                                        <option value="2">Missed</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-12">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Notes / Remarks /Comments</label>
                                                                                        <textarea class="form-control" name="comments" rows="3"><?php if ($visit['comments']) {
                                                                                                                                                    echo $visit['comments'];
                                                                                                                                                } ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dr"><span></span></div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <input type="hidden" name="id" value="<?= $visit['id'] ?>">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <input type="submit" name="add_visit" class="btn btn-primary" value="Save changes">
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Patient ID</th>
                                                    <th>Visit Day</th>
                                                    <th>Expected Date</th>
                                                    <th>Visit Date</th>
                                                    <th>SITE</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
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
        <?php } elseif ($_GET['id'] == 6) { ?>
        <?php } elseif ($_GET['id'] == 7) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Participants Study CRF's</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                    <li class="breadcrumb-item active">Participants Study CRF's</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <?php
                                        $patient = $override->get('clients', 'id', $_GET['cid'])[0];
                                        $visits_status = $override->firstRow1('visit', 'status', 'id', 'client_id', $_GET['cid'], 'visit_code', 'EV')[0]['status'];

                                        // $patient = $override->get('clients', 'id', $_GET['cid'])[0];
                                        $category = $override->get('main_diagnosis', 'patient_id', $_GET['cid'])[0];
                                        $cat = '';

                                        if ($category['cardiac'] == 1) {
                                            $cat = 'Cardiac';
                                        } elseif ($category['diabetes'] == 1) {
                                            $cat = 'Diabetes';
                                        } elseif ($category['sickle_cell'] == 1) {
                                            $cat = 'Sickle cell';
                                        } else {
                                            $cat = 'Not Diagnosed';
                                        }


                                        if ($patient['gender'] == 1) {
                                            $gender = 'Male';
                                        } elseif ($patient['gender'] == 2) {
                                            $gender = 'Female';
                                        }

                                        $name = 'Name: ' . $patient['firstname'] . ' ' . $patient['lastname'] . ' Age: ' . $patient['age'] . ' Gender: ' . $gender . ' Type: ' . $cat;

                                        ?>

                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <h1>Study ID: <?= $patient['study_id'] ?><h4><?= $name ?></h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <ol class="breadcrumb float-sm-right">
                                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid'] ?>&status=<?= $_GET['status'] ?>">
                                                            < Back</a>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>CRF</th>
                                                    <th>Records</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <?php if ($_GET['seq'] == 1) { ?>

                                                <tr>
                                                    <td>1</td>
                                                    <td>Demographic</td>
                                                    <td>
                                                        <!-- <i class="nav-icon fas fa-th"></i> -->
                                                        <span class="badge badge-info right">
                                                            <?= $override->countData('demographic', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($override->get3('demographic', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>
                                                        <td><a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                    <?php } else { ?>
                                                        <td><a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                    <?php } ?>
                                                </tr>

                                            <?php }  ?>

                                            <tr>
                                                <td>2</td>
                                                <td>Vitals</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('vital', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('vital', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>
                                                    <td><a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=8&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>
                                            </tr>

                                            <?php if ($_GET['seq'] == 1) { ?>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Pateint Category</td>
                                                    <td>
                                                        <!-- <i class="nav-icon fas fa-th"></i> -->
                                                        <span class="badge badge-info right">
                                                            <?= $override->countData('main_diagnosis', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($override->get3('main_diagnosis', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>
                                                        <td><a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                    <?php } else { ?>
                                                        <td><a href="add.php?id=9&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                    <?php } ?>
                                                </tr>

                                            <?php }  ?>


                                            <?php if ($_GET['seq'] == 1) { ?>

                                                <tr>
                                                    <td>3</td>
                                                    <td>Patient Hitory & Family History & Complication</td>
                                                    <td>
                                                        <!-- <i class="nav-icon fas fa-th"></i> -->
                                                        <span class="badge badge-info right">
                                                            <?= $override->countData('history', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($override->get3('history', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                        <td><a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                    <?php } else { ?>
                                                        <td><a href="add.php?id=10&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                    <?php } ?>
                                                </tr>

                                            <?php }  ?>


                                            <tr>
                                                <td>4</td>
                                                <td>History, Symtom & Exam</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('symptoms', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('symptoms', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=11&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=11&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>
                                            </tr>


                                            <?php if ($_GET['seq'] == 1) { ?>

                                                <?php if ($override->get2('main_diagnosis', 'patient_id', $_GET['cid'], 'cardiac', 1)) { ?>

                                                    <tr>
                                                        <td>5</td>
                                                        <td>Main diagnosis 1 ( Cardiac )</td>
                                                        <td>
                                                            <!-- <i class="nav-icon fas fa-th"></i> -->
                                                            <span class="badge badge-info right">
                                                                <?= $override->countData('cardiac', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                            </span>
                                                        </td>
                                                        <?php if ($override->get3('cardiac', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                            <td><a href="add.php?id=12&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                        <?php } else { ?>
                                                            <td><a href="add.php?id=12&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>


                                                <?php if ($override->get2('main_diagnosis', 'patient_id', $_GET['cid'], 'diabetes', 1)) { ?>

                                                    <tr>
                                                        <td>5</td>
                                                        <td>Main diagnosis 2 ( Diabetes )</td>
                                                        <td>
                                                            <!-- <i class="nav-icon fas fa-th"></i> -->
                                                            <span class="badge badge-info right">
                                                                <?= $override->countData('diabetic', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                            </span>
                                                        </td>
                                                        <?php if ($override->get3('diabetic', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                            <td><a href="add.php?id=13&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                        <?php } else { ?>
                                                            <td><a href="add.php?id=13&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>


                                                <?php if ($override->get2('main_diagnosis', 'patient_id', $_GET['cid'], 'sickle_cell', 1)) { ?>


                                                    <tr>
                                                        <td>5</td>
                                                        <td>Main diagnosis 3 ( Sickle Cell )</td>
                                                        <td>
                                                            <!-- <i class="nav-icon fas fa-th"></i> -->
                                                            <span class="badge badge-info right">
                                                                <?= $override->countData('sickle_cell', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                            </span>
                                                        </td>
                                                        <?php if ($override->get3('sickle_cell', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                            <td><a href="add.php?id=14&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                        <?php } else { ?>
                                                            <td><a href="add.php?id=14&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                        <?php } ?>
                                                    </tr>

                                                <?php } ?>

                                            <?php }  ?>


                                            <?php
                                            //  if ($override->get2('main_diagnosis', 'patient_id', $_GET['cid'], 'cardiac', 1) || $override->get2('main_diagnosis', 'patient_id', $_GET['cid'], 'sickle_cell', 1)) { 
                                            ?>
                                            <tr>
                                                <td>6</td>
                                                <?php if ($_GET['seq'] == 1) { ?>
                                                    <td>Results at enrollment</td>
                                                <?php } else { ?>
                                                    <td>Results at Follow Up</td>
                                                <?php } ?>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('results', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>

                                                <?php if ($override->get3('results', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=15&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=15&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>

                                            <?php
                                            //  }
                                            ?>

                                            <tr>
                                                <td>7</td>
                                                <td>Hospitalization</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('hospitalization', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('hospitalization', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=16&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=16&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>Hospitalization Details</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('hospitalization_details', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('hospitalization_details', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=17&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=17&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>

                                            <tr>
                                                <td>9</td>
                                                <td>Treatment Plan</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('treatment_plan', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('treatment_plan', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=18&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=18&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>

                                            <tr>
                                                <td>10</td>
                                                <td>Diagnosis, Complications, & Comorbidities</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('dgns_complctns_comorbdts', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('dgns_complctns_comorbdts', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=19&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=19&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>

                                            <tr>
                                                <td>11</td>
                                                <td>RISK</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('risks', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('risks', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=20&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=20&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>



                                            <tr>
                                                <td>12</td>
                                                <td>Lab Details</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('lab_details', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('lab_details', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=21&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=21&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>
                                            <?php if ($_GET['seq'] == 1) { ?>

                                                <tr>
                                                    <td>13</td>
                                                    <td>Socioeconomic Status</td>
                                                    <td>
                                                        <!-- <i class="nav-icon fas fa-th"></i> -->
                                                        <span class="badge badge-info right">
                                                            <?= $override->countData('social_economic', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($override->get3('social_economic', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                        <td><a href="add.php?id=22&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                    <?php } else { ?>
                                                        <td><a href="add.php?id=22&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                    <?php } ?>

                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td>14</td>
                                                <td>Next Visit Summary</td>
                                                <td>
                                                    <!-- <i class="nav-icon fas fa-th"></i> -->
                                                    <span class="badge badge-info right">
                                                        <?= $override->countData('lab_details', 'status', 1, 'site_id', $user->data()->site_id) ?>
                                                    </span>
                                                </td>
                                                <?php if ($override->get3('lab_details', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>

                                                    <td><a href="add.php?id=22&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                                <?php } else { ?>
                                                    <td><a href="add.php?id=22&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                                <?php } ?>

                                            </tr>
                                            </tbody>
                                            <tfoot>
                                                <th>#</th>
                                                <th>CRF</th>
                                                <th>Records</th>
                                                <th>Action</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
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

        <?php } elseif ($_GET['id'] == 9) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    <?php
                                    if ($_GET['status'] == 1) {
                                        echo $title = 'Screening';
                                        $data = $override->getNews('kap', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 2) {
                                        echo $title = 'Eligibility';
                                        $data = $override->getNews('history', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 3) {
                                        echo  $title = 'Enrollment';
                                        $data = $override->getNews('results', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 4) {
                                        echo $title = 'Termination';
                                        $data = $override->getNews('classification', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 5) {
                                        echo  $title = 'Registration';
                                        $data = $override->getNews('outcome', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } elseif ($_GET['status'] == 5) {
                                        echo  $title = 'Registration';
                                        $data = $override->getNews('economic', 'status', 1, 'site_id', $user->data()->site_id);
                                    ?>
                                    <?php
                                    } ?>
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                    <li class="breadcrumb-item active"><?= $title; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        <?php
                                                        if ($_GET['status'] == 1) { ?>
                                                            <h3 class="card-title">List of Screened Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 2) { ?>
                                                            <h3 class="card-title">List of Eligible Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 3) { ?>
                                                            <h3 class="card-title">List of Enrolled Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 4) { ?>
                                                            <h3 class="card-title">List of Terminated Clients</h3>
                                                        <?php
                                                        } elseif ($_GET['status'] == 5) { ?>
                                                            <h3 class="card-title">List of Registered Clients</h3>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item"><a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item"><a href="add.php?id=4">
                                                                Add new Client > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Study Id</th>
                                                    <th>Age</th>
                                                    <th>Sex</th>
                                                    <th>Interview Type</th>
                                                    <th>Site</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $kap = 0;
                                                $screening = 0;
                                                $health_care = 0;
                                                if ($_GET['interview'] == 1) {
                                                    $interview = 'kap';
                                                } elseif ($_GET['interview'] == 2) {
                                                    $interview = 'screening';
                                                } elseif ($_GET['interview'] == 3) {
                                                    $interview = 'health_care';
                                                }
                                                $x = 1;
                                                foreach ($data as $value) {
                                                    $yes_no = $override->get('yes_no', 'status', 1)[0];
                                                    $kap = $override->getNews('kap', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $history = $override->getNews('history', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $results = $override->getNews('results', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $classification = $override->getNews('classification', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $economic = $override->getNews('economic', 'status', 1, 'patient_id', $value['id'])[0];
                                                    $sites = $override->getNews('sites', 'status', 1, 'id', $value['site_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $value['firstname'] . '  ' . $value['middlename'] . ' ' . $value['lastname']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['study_id']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['age']; ?>
                                                        </td>
                                                        <?php if ($value['sex'] == 1) { ?>
                                                            <td class="table-user">
                                                                Male
                                                            </td>
                                                        <?php } elseif ($value['sex'] == 2) { ?>
                                                            <td class="table-user">
                                                                Female
                                                            </td>
                                                        <?php } ?>
                                                        <?php if ($value['interview_type'] == 1) { ?>
                                                            <td class="table-user">
                                                                Kap & Screening
                                                            </td>
                                                        <?php } elseif ($value['interview_type'] == 2) { ?>
                                                            <td class="table-user">
                                                                Health Care Worker
                                                            </td>
                                                        <?php } else { ?>
                                                            <td class="table-user">
                                                                None
                                                            </td>
                                                        <?php } ?>

                                                        <td class="table-user">
                                                            <?= $sites['name']; ?>
                                                        </td>
                                                        <?php if ($value['age'] >= 18) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success"> <i class="ri-edit-box-line"></i>Eligible for KAP</a>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-danger"> <i class="ri-edit-box-line"></i>Not Eligible for KAP</a>
                                                            </td>
                                                        <?php } ?>
                                                        <td class="text-center">
                                                            <a href="add.php?id=4&cid=<?= $value['id'] ?>&status=<?= $_GET['status'] ?>" class="btn btn-info"> <i class="ri-edit-box-line"></i>Update</a>
                                                            <?php if ($value['age'] >= 18) { ?>
                                                                <a href="info.php?id=4&cid=<?= $value['id'] ?>&status=<?= $_GET['status'] ?>" class="btn btn-warning"> <i class="ri-edit-box-line"></i>Add CRF's</a>
                                                            <?php   } ?>
                                                        </td>
                                                    </tr>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Study Id</th>
                                                    <th>Age</th>
                                                    <th>Sex</th>
                                                    <th>Interview Type</th>
                                                    <th>Site</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
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
        <?php } elseif ($_GET['id'] == 11) { ?>
        <?php } elseif ($_GET['id'] == 12) { ?>
        <?php } elseif ($_GET['id'] == 13) { ?>
        <?php } elseif ($_GET['id'] == 14) { ?>
        <?php } elseif ($_GET['id'] == 15) { ?>

        <?php  } ?>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        <?php if ($user->data()->pswd == 0) { ?>
            $(window).on('load', function() {
                $("#change_password_n").modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            });
        <?php } ?>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        $(document).ready(function() {
            $("#myInput11").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#inventory_report1 tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#medication_list tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function checkQuestionValue1(currentQuestion, elementToHide) {
            var currentQuestionInput = document.getElementById(currentQuestion);
            var elementToHide = document.getElementById(elementToHide);

            var questionValue = currentQuestionInput.value;

            if (questionValue === "1") {
                elementToHide.classList.remove("hidden");
            } else {
                elementToHide.classList.add("hidden");
            }
        }

        function checkQuestionValue96(currentQuestion, elementToHide) {
            var currentQuestionInput = document.getElementById(currentQuestion);
            var elementToHide = document.getElementById(elementToHide);

            var questionValue = currentQuestionInput.value;

            if (questionValue === "96") {
                elementToHide.classList.remove("hidden");
            } else {
                elementToHide.classList.add("hidden");
            }
        }

        function checkQuestionValue45(currentQuestion, elementToHide1, elementToHide2) {
            var currentQuestionInput = document.getElementById(currentQuestion);
            var elementToHide1 = document.getElementById(elementToHide1);
            var elementToHide2 = document.getElementById(elementToHide2);

            var questionValue = currentQuestionInput.value;

            if (questionValue === "4") {
                elementToHide1.classList.remove("hidden");
            } else if (questionValue === "5") {
                elementToHide2.classList.remove("hidden");

            } else {
                elementToHide1.classList.add("hidden");
                elementToHide2.classList.add("hidden");

            }
        }

        function toggleQuestionVisibility(currentQuestionId, nextQuestionId) {
            var currentQuestion = document.getElementById(currentQuestionId);
            var nextQuestion = document.getElementById(nextQuestionId);

            // Check if the current question has a value
            if (currentQuestion.value) {
                nextQuestion.classList.remove("hidden"); // Show the next question
            } else {
                nextQuestion.classList.add("hidden"); // Hide the next question
            }
        }


        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        // var countries = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Anguilla", "Antigua & Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia & Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central Arfrican Republic", "Chad", "Chile", "China", "Colombia", "Congo", "Cook Islands", "Costa Rica", "Cote D Ivoire", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Polynesia", "French West Indies", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauro", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Pierre & Miquelon", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "St Kitts & Nevis", "St Lucia", "St Vincent", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor L'Este", "Togo", "Tonga", "Trinidad & Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks & Caicos", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Virgin Islands (US)", "Yemen", "Zambia", "Zimbabwe"];
        // var getUid = $(this).val();
        fetch('fetch_medications.php')
            .then(response => response.json())
            .then(data => {
                // Process the data received from the PHP script
                // console.log(data);
                autocomplete(document.getElementById("medication_name"), data);
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error('Error:', error);
            });

        fetch('fetching_brand.php')
            .then(response => response.json())
            .then(data => {
                // Process the data received from the PHP script
                // console.log(data);
                autocomplete(document.getElementById("brand_id2"), data);
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error('Error:', error);
            });


        fetch('fetching_batch.php')
            .then(response => response.json())
            .then(data => {
                // Process the data received from the PHP script
                // console.log(data);
                autocomplete(document.getElementById("batch_no"), data);
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error('Error:', error);
            });

        fetch('fetching_manufacturer.php')
            .then(response => response.json())
            .then(data => {
                // Process the data received from the PHP script
                // console.log(data);
                autocomplete(document.getElementById("manufacturer"), data);
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error('Error:', error);
            });

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        // autocomplete(document.getElementById("myInput"), countries);
    </script>
</body>

</html>