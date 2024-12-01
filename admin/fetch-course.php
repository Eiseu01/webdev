<?php
    require_once('../classes/course.class.php');

    $courseObj = new Course();

    $courses = $courseObj->fetchCourse();

    header('Content-Type: application/json');
    echo json_encode($courses);
?>
