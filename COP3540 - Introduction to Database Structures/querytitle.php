<html>
<head>
</head>
<body>
<?php 
  if (isset($_GET["query"]))
  {
    if ($_GET["query"] == "01") 
    {
      echo "<h5 align='center'>Query 01 - Print the names of professors who work in departments that have fewer than 50 PhD students.</h5>";
    }
    if ($_GET["query"] == "02") 
    {
      echo "<h5 align='center'>Query 02 - Print the name(s) of student(s) with the lowest gpa.</h5>";
    }
    if ($_GET["query"] == "03") 
    {
      echo "<h5 align='center'>Query 03 - For each Computer Sciences class, print the cno, sectno, and the average gpa of the students enrolled in the class.</h5>";
    }
    if ($_GET["query"] == "04") 
    {
      echo "<h5 align='center'>Query 04 - Print the course names, course numbers and section numbers of all classes with less than six students enrolled in them.</h5>";
    }
    if ($_GET["query"] == "05") 
    {
      echo "<h5 align='center'>Query 05 - Print the name(s) and sid(s) of the student(s) enrolled in the most classes.</h5>";
    }
    if ($_GET["query"] == "06") 
    {
      echo "<h5 align='center'>Query 06 - Print the names of departments that have one or more majors who are under 18 years old.</h5>";
    }
    if ($_GET["query"] == "07") 
    {
      echo "<h5 align='center'>Query 07 - Print the names and majors of students who are taking one of the College Geometry courses.</h5>";
    }
    if ($_GET["query"] == "08") 
    {
      echo "<h5 align='center'>Query 08 - For those departments that have no majors taking a College Geometry course, print the department name and the number of PhD students in the department.</h5>";
    }
    if ($_GET["query"] == "09") 
    {
      echo "<h5 align='center'>Query 09 - Print the names of students who are taking both a Computer Sciences course and a Mathematics course.</h5>";
    }
    if ($_GET["query"] == "10") 
    {
      echo "<h5 align='center'>Query 10 - Print the age difference between the oldest and youngest Computer Sciences major.</h5>";
    }
    if ($_GET["query"] == "11") 
    {
      echo "<h5 align='center'>Query 11 - For each department that has one or more majors with a GPA under 1.0, print the name of the department and the average GPA of its majors.</h5>";
    }
    if ($_GET["query"] == "12") 
    {
      echo "<h5 align='center'>Query 12 - Print the ids, names, and GPAs of the students who are currently taking all of the Civil Engineering courses.</h5>";
    }
  }
  else
  {
      echo "<h5 align='center'>Welcome to Database Structures COP3540 Spring 2015 Homework by Maciej Medyk.</h5>";
  }
?>
</html>