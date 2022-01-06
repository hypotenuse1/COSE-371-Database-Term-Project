<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$event_name = $_POST['event_name'];
$date = $_POST['date'];
$place_id = $_POST['place_id'];
$eventtype_id = $_POST['eventtype_id'];
$event_desc = $_POST['event_desc'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$ret = mysqli_query($conn, "insert into eventLists	values(default, '$event_name', '$date', '$place_id','$eventtype_id','$event_desc', default)");

if($ret){
	mysqli_query($conn, "commit");
	s_msg ("활동이 성공적으로 추가되었습니다!");
	echo "<meta http-equiv='refresh' content='0;url=eventLists.php'>";
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("활동이 추가되지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=eventLists.php'>";
}




?>


