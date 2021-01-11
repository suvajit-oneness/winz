<?php
define('DB_USERNAME', 'demo9dtx_winzusr');
define('DB_PASSWORD', 'gkR}c=ntM5Pv');
define('DB_HOST', 'localhost');
define('DB_NAME', 'demo9dtx_winz-v2');

header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

if (function_exists($action)) {
    $action();
}

function conn(){
  $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check for database connection error
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // returing connection resource
    return $conn;
}

function fetch_courses(){
    $sql = "select * from courses";
    $result = mysqli_query(conn(), $sql);

    $courses = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $row['teacher'] = fetch_course_teacher($row['id']);

            array_push($courses, $row);
        }
    }

    die(json_encode(array("error"=>false,"courses"=>$courses)));
}

function fetch_home_contents(){
    $sql = "select * from home_contents";
    $result = mysqli_query(conn(), $sql);

    $home_contents = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($home_contents, $row);
        }
    }

    die(json_encode(array("error"=>false,"home_contents"=>$home_contents)));
}

function fetch_teachers(){
    $sql = "select * from teachers";
    $result = mysqli_query(conn(), $sql);

    $teachers = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($teachers, $row);
        }
    }

    die(json_encode(array("error"=>false,"teachers"=>$teachers)));
}

function fetch_course_details(){
    $course_id = $_GET['course_id'];

    $sql = "select * from courses where id='$course_id'";
    $result = mysqli_query(conn(), $sql);

    $course = array();
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);

        $course = $row;
        $course['teacher'] = fetch_course_teacher($row['id']);
        $course['course_features'] = fetch_course_features($row['id']);
        $course['course_lectures'] = fetch_course_lectures($row['id']);
    }

    $related_courses = fetch_related_courses($course_id);

    die(json_encode(array("error"=>false,"course"=>$course,"related_courses"=>$related_courses)));
}

function fetch_course_teacher($course_id){
    $sql = "select * from teachers where id in (select teacher_id from teacher_courses where course_id='$course_id')";
    $result = mysqli_query(conn(), $sql);

    $teacher = array();

    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);

        $teacher = $row;
    }

    return $teacher;
}

function fetch_course_features($course_id){
    $sql = "select * from course_features where course_id='$course_id'";
    $result = mysqli_query(conn(), $sql);

    $course_features = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($course_features, $row);
        }
    }

    return $course_features;
}

function fetch_course_lectures($course_id){
    $sql = "select * from course_lectures where course_id='$course_id'";
    $result = mysqli_query(conn(), $sql);

    $course_lectures = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($course_lectures, $row);
        }
    }

    return $course_lectures;
}

function fetch_related_courses($course_id){
    $sql = "select * from courses where id!='$course_id' order by id desc limit 10";
    $result = mysqli_query(conn(), $sql);

    $related_courses = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $row['teacher'] = fetch_course_teacher($row['id']);

            array_push($related_courses, $row);
        }
    }

    return $related_courses;
}

function fetch_teacher_details(){
    $teacher_id = $_GET['teacher_id'];

    $sql = "select * from teachers where id='$teacher_id'";
    $result = mysqli_query(conn(), $sql);

    $teacher = array();
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);

        $teacher = $row;
    }

    $courses = fetch_teacher_courses($teacher_id);

    die(json_encode(array("error"=>false,"teacher"=>$teacher,"courses"=>$courses)));
}

function fetch_teacher_courses($teacher_id){
    $sql = "select * from courses where id in (select course_id from teacher_courses where teacher_id='$teacher_id')";
    $result = mysqli_query(conn(), $sql);

    $courses = array();

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($courses, $row);
        }
    }

    return $courses;
}

function login(){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $bycryptPass = md5($password);

    $sql = "select * from users where email='$email' and password='$bycryptPass'";
    $result = mysqli_query(conn(), $sql);

    $user = array();
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);

        $user = $row;

        die(json_encode(array("error"=>false,"user"=>$user)));
    }else{
        die(json_encode(array("error"=>true,"message"=>"You have entered a wrong username and password. Please enter the correct one.")));
    }
}

function register(){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $bycryptPass = md5($password);

    $sql = "insert into users
            (name, email, password, image)
            values
            ('$name', '$email', '$bycryptPass', 'assets/img/default_profile.png')";
    $result = mysqli_query(conn(), $sql);

    if ($result) {
        die(json_encode(array("error"=>false,"message"=>"Your account has been registered successfully. Please login to continue")));
    }else{
        die(json_encode(array("error"=>true,"message"=>"Failed to create account. Please try again")));
    }
}

function search(){
    $courses = array();
    $teachers = array();

    $keyword = $_GET['keyword'];

    $sql = "select * from courses where course_name like '%$keyword%'";
    $result = mysqli_query(conn(), $sql);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($courses, $row);
        }
    }

    $sql = "select * from teachers where name like '%$keyword%'";
    $result = mysqli_query(conn(), $sql);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($teachers, $row);
        }
    }

    die(json_encode(array("error"=>false,"courses"=>$courses,"teachers"=>$teachers)));
}

function fetch_notifications(){
    $sql = "select * from notifications";
    $result = mysqli_query(conn(), $sql);

    $notifications = array();
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($notifications, $row);
        }
    }

    die(json_encode(array("error"=>false,"notifications"=>$notifications)));
}

function fetch_subscribed_courses(){
    $user_id = $_GET['user_id'];

    $sql = "select * from courses where id in (select course_id from subscribed_courses where user_id='$user_id')";
    $result = mysqli_query(conn(), $sql);

    $courses = array();

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($courses, $row);
        }
    }

    die(json_encode(array("error"=>false,"courses"=>$courses)));
}
?>