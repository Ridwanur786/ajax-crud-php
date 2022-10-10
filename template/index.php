<?php
//include('../template/show.php');
require('../connect/dbCon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission using Ajax</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title text-center">All Employees Data</div>
                        <button class="btn btn-outline-dark btn-sm " data-bs-toggle="modal" data-bs-target="#ajaxModal">Add Employee</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm" id="employeeDatatable">
                            <table class="table table-bordered table-hover">
                                 <?php
                                $serial = 1;
                                $query = "SELECT * FROM `employee`";

                                $query_run = $conn->query($query);
                                if (mysqli_num_rows($query_run) > 0) { ?>

                                 <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>CTC</th>
                                    <th>experiences</th>
                                    <th>action</th>
                                </tr>

                                <?php 
                                    foreach ($query_run as  $value) {  ?>
                                        <tr>
                                            <td><?php echo $serial; ?></td>
                                            <td><?php echo $value['name']; ?></td>
                                            <td><?php echo $value['dob']; ?></td>
                                            <td><?php echo $value['ctc']; ?></td>
                                            <td><?php
                                                echo $value['experience'];
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm employeeEdit" value="<?php echo $value['ID']; ?>">EDIT</button>
                                                <button type="button" class="btn btn-outline-danger btn-sm deleteEmployee" value="<?php echo $value['ID']; ?>" >DELETE</button>
                                                <button type="button" class="btn btn-outline-info btn-sm viewEmployee" value="<?php echo $value['ID']; ?>">VIEW</button>
                                            </td>

                                        </tr>
                                <?php
                                $serial++;
                                    }
                                }else{

                                    echo "NO Record Found";
                                }

                                ?>


                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Employee Data Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="errorMessageUpdate">
                                <p class="alert alert-warning d-none"></p>
                            </div>
                            <form id="updateEmployee">
                                <div class="mb-3 row">
                                    <label for="hidden" class="col-sm-3 col-form-label d-none">ID</label>
                                    <div class="col-sm-9"> <input type="hidden" name="employee_id" id="employee_id" class="form-control form-control-sm"></div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9"><input type="text" name="name" id="Name" class="form-control form-control-sm"></div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date of Birth" class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <!-- <div class="col-sm-9"> -->
                                    <div class="col-sm-9">
                                        <div class="input-group date" id="datepicker2">
                                            <input type="text" name="dob" class="form-control form-control-sm">
                                            <span class="input-group-append">
                                                <span class="input-group-text bg-light d-block">
                                                    <i class="fa-regular fa-calendar-plus"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div class="mb-3 row">
                                    <label for="CTC" class="col-sm-3 col-form-label">CTC</label>
                                    <div class="col-sm-9"><input type="text" name="ctc" id="ctc" class="form-control form-control-sm"></div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="experience" class="col-sm-3 col-form-label">Experince</label>
                                    <div class="col-sm-9">
                                        <select name="experience[]" id="experiences2" class="js-select-multiple form-select form-control form-control-sm" multiple="multiple">
                                            <option value="HTML">HTML</option>
                                            <option value="JavaScript">JavaScript</option>
                                            <option value="PHP">PHP</option>
                                            <option value="LARAVEL">LARAVEL</option>
                                            <option value="WordPress">WordPress</option>
                                        </select>
                                    </div>


                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--ADD Modal -->
            <div class="modal fade" id="ajaxModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Employee Details Submission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="errorMessage">
                                <p class="alert alert-warning d-none"></p>
                            </div>
                            <form id="addEmployee">
                                <div class="mb-3 row">
                                    <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9"><input type="text" name="name" id="Name" class="form-control form-control-sm"></div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date of Birth" class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date" id="datepicker1">
                                            <input type="text" name="dob" class="form-control form-control-sm">
                                            <span class="input-group-append">
                                                <span class="input-group-text bg-light d-block">
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="CTC" class="col-sm-3 col-form-label">CTC</label>
                                    <div class="col-sm-9"><input type="text" name="ctc" id="ctc" class="form-control form-control-sm"></div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="experience" class="col-sm-3 col-form-label">Experince</label>
                                    <div class="col-sm-9">
                                        <select name="experience[]" id="experiences" class="js-select-multiple form-control" multiple="multiple">
                                            <option value="HTML">HTML</option>
                                            <option value="JavaScript">JavaScript</option>
                                            <option value="PHP">PHP</option>
                                            <option value="LARAVEL">LARAVEL</option>
                                            <option value="WordPress">WordPress</option>
                                        </select>
                                    </div>


                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Save data</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

               <!-- View Modal -->
            <div class="modal fade" id="viewModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Employee Data Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- <div id="errorMessageUpdate">
                                <p class="alert alert-warning d-none"></p>
                            </div> -->
                             <div class="mb-3 row">
                                    <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                   <div class="col-sm-9">
                                     <p id="view_name"> </p>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date of Birth" class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <!-- <div class="col-sm-9"> -->
                                    <div class="col-sm-9">
                                        <div class="col-sm-9">
                                     <p id="view_dob"> </p>
                                    </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div class="mb-3 row">
                                    <label for="CTC" class="col-sm-3 col-form-label">CTC</label>
                                    <div class="col-sm-9">
                                     <p id="view_ctc"> </p>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="experience" class="col-sm-3 col-form-label">Experince</label>
                                    <div class="col-sm-9">
                                     <p id="view_exp"> </p>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../resources/js/form.js"></script>
    <script type="text/javascript" src="../resources/js/select2.js"></script>
</body>

</html>