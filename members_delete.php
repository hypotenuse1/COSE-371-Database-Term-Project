<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_id = $_GET['member_id'];



mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$ret1 = mysqli_query($conn, "delete from apply where member_id = $member_id");
$ret = mysqli_query($conn, "delete from members where member_id = $member_id");

if($ret){
	if($ret1){
		mysqli_query($conn, "commit");
		s_msg ("성공적으로 탈퇴되었습니다!");
		echo "<meta http-equiv='refresh' content='0;url=members.php'>";
	}
	else{
		mysqli_query($conn, "rollback;");
		s_msg("회원탈퇴가 이루어지지 않았습니다. 다시 시도하여 주십시오");
		echo "<meta http-equiv='refresh' content='0;url=members.php'>";
	}
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("회원탈퇴가 이루어지지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=members.php'>";
}

?>

