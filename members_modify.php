<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_id = $_POST['member_id'];
$member_name = $_POST['member_name'];
$member_student_id = $_POST['member_student_id'];
$membertype_id = $_POST['membertype_id'];



mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");


$ret = mysqli_query($conn, "update members set member_name = '$member_name', member_student_id = '$member_student_id', membertype_id = $membertype_id
							where member_id = $member_id");
if($ret){
	mysqli_query($conn, "commit");
	s_msg ("회원정보가 성공적으로 수정되었습니다!");
	echo "<meta http-equiv='refresh' content='0;url=members.php'>";
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("회원정보가 수정되지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=members.php'>";
}


?>

