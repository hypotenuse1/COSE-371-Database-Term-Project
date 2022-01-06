<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_name = $_POST['member_name'];
$member_student_id = $_POST['member_student_id'];
$membertype_id = $_POST['membertype_id'];

//echo "insert into members values(default, '$member_name', '$member_student_id', '$membertype_name')";


mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$ret = mysqli_query($conn, "insert into members(member_id, member_name, member_student_id, membertype_id)
							values(default, '$member_name', $member_student_id, $membertype_id)");
if($ret){
	mysqli_query($conn, "commit");
	s_msg ("회원이 성공적으로 등록되었습니다!");
	echo "<meta http-equiv='refresh' content='0;url=members.php'>";
}
else{
	mysqli_query($conn, "rollback;");
	s_msg("회원이 등록되지 않았습니다. 다시 시도하여 주십시오");
	echo "<meta http-equiv='refresh' content='0;url=members.php'>";
}
?>


