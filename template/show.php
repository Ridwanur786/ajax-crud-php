<?php 
require('../connect/dbCon.php');
//var_dump($_POST);


if(isset($_POST['delete_employee'])){
    $employee_id = $conn->real_escape_string($_POST['employee_id']);

    $query = "DELETE  FROM `employee` WHERE `ID`='$employee_id'";
    $query_run = $conn->query($query);

    if($query_run){
        //var_dump($_POST);
        $res = [
            'status' => 200,
            'message' => 'Employee Deleted Successfully'
        ];

        echo json_encode($res);

        return false;

    }else{
         $res = [
            'status' => 500,
            'message' => 'something went wrong'
        ];

        echo json_encode($res);

        return false;
    }
}

if(isset($_POST['save_employee'])){
   // var_dump($_POST['save_employee']);

    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $ctc = $conn->real_escape_string($_POST['ctc']);

   
    //   $exp = isset($_POST['experience']) && is_array($_POST['experience']) ? $_POST['experience']:
    //    $conn->real_escape_string(implode("," , $exp));
   // $experiences = $_POST['experience'];


     if(isset($_POST['experience']) && is_array($_POST['experience'])){
        foreach ($_POST['experience'] as $exp) {
       $exp = $conn->real_escape_string(implode(',',$_POST['experience']));
    }
    }
    
   // $experiences = $conn->real_escape_string(implode(',',$_POST['experience']));

    if($name ==NULL|| $dob ==NULL || $ctc==NULL || $exp ==NULL){

        $res = [
            'status' => 422,
            'message' => 'All field Required'
        ];

        echo json_encode($res);

        return false;

    }

    $query = "INSERT INTO `employee`(`name`,`dob`,`ctc`,`experience`) VALUES('$name','$dob','$ctc',' $exp')";
    //var_dump($query);
    $query_run = $conn->query($query);
    //$query_run->bind_param('s', $query);
    //$execute =$query_run->execute();
    if($query_run){
        //var_dump($_POST);
        $res = [
            'status' => 200,
            'message' => 'Employee Created Successfully'
        ];

        echo json_encode($res);

        return false;

    }else{
         $res = [
            'status' => 422,
            'message' => 'something went wrong'
        ];

        echo json_encode($res);

        return false;
    }
}


if(isset($_GET['employee_id'])){

   $employee_id = $conn->real_escape_string($_GET['employee_id']);
    $query= "SELECT * FROM `employee` WHERE `ID`='$employee_id'";
    $query_run = $conn->query($query);


    if(mysqli_num_rows($query_run) == 1){

        $employeeData = mysqli_fetch_array($query_run);
        // var_dump($employeeData);
        // die();
        $res = [
            'status' => 200,
            'message' => 'Employee data Updated Successfully',
            'data' => $employeeData
        ];

        echo json_encode($res);

        return false;
    }else{
        $res = [
            'status' => 404,
            'message' => 'id not found'
        ];

        echo json_encode($res);

        return false;
    }
}

if(isset($_POST['update_employee'])){
  

    $employee_id = $conn->real_escape_string($_POST['employee_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $ctc = $conn->real_escape_string($_POST['ctc']);

   // $experiences = $_POST['experience'];


    if(isset($_POST['experience']) && is_array($_POST['experience'])){
        foreach ($_POST['experience'] as $exp) {
       $exp = $conn->real_escape_string(implode(',',$_POST['experience']));
    }
    }

    if($name ==NULL|| $dob ==NULL || $ctc==NULL || $exp ==NULL){

        $res = [
            'status' => 422,
            'message' => 'All field Required'
        ];

        echo json_encode($res);

        return false;

    }

    $query = "UPDATE `employee` SET `name`='$name',`dob`='$dob',`ctc`='$ctc',`experience`='$exp' WHERE `ID`='$employee_id'";
    //var_dump($query);
    $query_run = $conn->query($query);
    //$query_run->bind_param('s', $query);
    //$execute =$query_run->execute();
    if($query_run){
        //var_dump($_POST);
        $res = [
            'status' => 200,
            'message' => 'Employee Updated Successfully'
        ];

        echo json_encode($res);

        return false;

    }else{
         $res = [
            'status' => 422,
            'message' => 'something went wrong while Updating Employee'
        ];

        echo json_encode($res);

        return false;
    }
}


?>