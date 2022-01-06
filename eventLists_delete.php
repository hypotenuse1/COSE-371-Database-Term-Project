<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$event_id = $_GET['event_id'];

$queryApply = "delete from apply where event_id = $event_id";
$mainQuery = "delete from eventLists where event_id = $event_id";


mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$ret1 = mysqli_query($conn, $queryApply);
$ret = mysqli_query($conn, $mainQuery);

if($ret){
	if($ret1){
		mysqli_query($conn, "commit");
		s_msg ("활동이 성공적으로 삭제되었습니다!");
		echo "<meta http-equiv='refresh' content='0;url=eventLists.php'>";
	}
	else{
		mysqli_query($conn, "rollback;");
		s_msg("활동이 삭제되지 않았습니다. 다시 시도하여 주십시오");
		echo "<meta http-equiv='refresh' content='0;url=eventLists.php'>";
	}
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("활동이 삭제되지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=eventLists.php'>";
}


?>

