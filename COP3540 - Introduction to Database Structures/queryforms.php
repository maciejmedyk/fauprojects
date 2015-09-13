<html>
<head>
</head>
<body>
<?php 
  if (isset($_GET["query"]))
  {
    include('connection.php');
    if ($_GET["query"] == "01") 
    {
      
      $data = mysql_query("SELECT P.pname FROM dept D, prof P WHERE P.dname = D.dname AND D.numphds < 50") or die(mysql_error()); 
      //$data = mysql_query("SELECT p.pname FROM enroll e, prof p WHERE p.dname=e.dname AND e.sid GROUP BY p.pname HAVING COUNT(e.sid) < 50") or die(mysql_error());

      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Professor Name</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0101\" width=\"100%\">" . $info['pname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "02") 
    {
      $data = mysql_query("SELECT s1.sname FROM student s1 WHERE s1.gpa = (SELECT MIN(s2.gpa) FROM student s2)") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Student Name</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0201\" width=\"100%\">" . $info['sname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "03") 
    {
      $data = mysql_query("SELECT c.cname, sec.cno, sec.sectno, AVG(s.gpa) AS student_gpa FROM section sec, enroll e, student s, course c WHERE ((sec.dname=\"Computer Sciences\") AND (sec.cno=e.cno) AND (sec.cno=c.cno) AND (e.sid=s.sid)) GROUP BY sec.cno, sec.sectno ") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"60%\">Class Name</th>" . "<th width=\"20%\">Course Number</th>" . "<th width=\"20%\">Section Number</th>" . "<th width=\"20%\">Student GPA</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0301\">" . $info['cname'] . "</td>"; 
            Print "<td id=\"q0302\">" . $info['cno'] . "</td>";
            Print "<td id=\"q0303\">" . $info['sectno'] . "</td>";
            Print "<td id=\"q0304\">" . number_format($info['student_gpa'],3) . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "04") 
    {
      $data = mysql_query("SELECT c.cname, e.cno, e.sectno FROM enroll e, course c WHERE c.cno=e.cno AND c.dname=e.dname GROUP BY c.cname HAVING COUNT(e.sid) < 6") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"80%\">Class Name</th>" . "<th width=\"20%\">Course Number</th>" . "<th width=\"20%\">Section Number</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0401\">" . $info['cname'] . "</td>"; 
            Print "<td id=\"q0402\">" . $info['cno'] . "</td>";
            Print "<td id=\"q0403\">" . $info['sectno'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "05") 
    { 
      $data = mysql_query("SELECT DISTINCT s.sid, s.sname FROM student s WHERE s.sid IN (SELECT e1.sid FROM enroll e1 GROUP BY e1.sid HAVING COUNT(*)>= ALL(SELECT COUNT(*) FROM enroll e2 GROUP BY e2.sid ))") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"10%\">Student ID</th>" . "<th width=\"100%\">Student Name</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0501\">" . $info['sid'] . "</td>"; 
            Print "<td id=\"q0502\">" . $info['sname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "06") 
    {
      $data = mysql_query("SELECT m.dname FROM major m, student s WHERE m.sid=s.sid AND s.age < 18") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Department Name</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0601\" width=\"100%\">" . $info['dname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "07") 
    {
      $data = mysql_query("SELECT s.sname, m.dname FROM student s, major m, enroll e, course c WHERE s.sid=e.sid AND e.sid=m.sid AND e.cno=c.cno AND (c.cno=461 OR c.cno=462) ORDER BY s.sname") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"80%\">Student Name</th>" . "<th width=\"500px\">              Major              </th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0701\">" . $info['sname'] . "</td>"; 
            Print "<td id=\"q0702\">" . $info['dname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "08") 
    {
      $data = mysql_query("SELECT D.dname, D.numphds FROM dept D WHERE D.dname NOT IN ( SELECT M.dname FROM student S, enroll E, course C, major M WHERE S.sid = E.sid AND E.cno = C.cno AND E.sid = M.sid AND C.cname LIKE \"College Geometry%\")") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Department Name</th>" . "<th width=\"20%\">PHD Students</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0801\">" . $info['dname'] . "</td>"; 
            Print "<td id=\"q0802\">" . $info['numphds'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);

    }
    if ($_GET["query"] == "09") 
    {
      $data = mysql_query("SELECT s.sname FROM student s, enroll a, enroll b WHERE s.sid=a.sid AND a.dname=\"Computer Sciences\" AND s.sid=b.sid AND b.dname=\"Mathematics\"") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Student Name</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q0901\" width=\"100%\">" . $info['sname'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "10") 
    {
      $data = mysql_query("SELECT (max(s.age) - min(s.age)) AS age_difference FROM student s, major m WHERE s.sid = m.sid AND m.dname=\"Computer Sciences\"") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"100%\">Age Difference</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q1001\" width=\"100%\">" . $info['age_difference'] . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "11") 
    {
      $data = mysql_query("SELECT dname, AVG(gpa) AS average_gpa FROM major, student WHERE dname IN(SELECT dname FROM major, student WHERE major.sid = student.sid AND student.gpa < 1.0 GROUP BY dname) AND major.sid = student.sid GROUP BY dname ") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"90%\">Department Name</th>" . "<th width=\"500px\">Average GPA</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q1101\">" . $info['dname'] . "</td>"; 
            Print "<td id=\"q1102\">" . number_format($info['average_gpa'],3) . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con);
    }
    if ($_GET["query"] == "12") 
    {
      $data = mysql_query("SELECT s.sid, s.sname, s.gpa FROM student s WHERE NOT EXISTS (SELECT * FROM course c WHERE c.dname=\"Civil Engineering\" AND c.cno NOT IN (SELECT e.cno FROM enroll e WHERE e.cno=c.cno AND e.sid=s.sid))") or die(mysql_error()); 
      
      Print "<table border cellpadding = 3 class=\"resulttable\">";

      {
        Print "<th width=\"10%\">Student ID</th>" . "<th width=\"90%\">Student Name</th>" . "<th width=\"50%\">Student GPA</th>";
      }
      while($info = mysql_fetch_array( $data )) 
      { 
            Print "<tr><td id=\"q1201\">" . $info['sid'] . "</td>"; 
            Print "<td id=\"q1202\">" . $info['sname'] . "</td>";
            Print "<td id=\"q1203\">" . number_format($info['gpa'],3) . "</td></tr>";
      }   
      Print "</table>";
      mysql_close($con); 
    }
  }
  else
  {
      
  }
?>
</html>