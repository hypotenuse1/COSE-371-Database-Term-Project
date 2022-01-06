<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$apply_id = $_GET['apply_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$ret = mysqli_query($conn, "delete from apply where apply_id = $apply_id");

if($ret){
	mysqli_query($conn, "commit");
	s_msg ("활동신청이 성공적으로 취소되었습니다!");
	echo "<meta http-equiv='refresh' content='0;url=applyLists.php'>";
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("신청이 취소되지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=applyLists.php'>";
}

?>

