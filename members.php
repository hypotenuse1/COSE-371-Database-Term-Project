<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="titleofpage">FLIP 회원목록</div>
<div class="subtitleofpage"><br>반갑습니다!<br></div>
<br>
<div class="searchBox">
     <form action="members.php" method="post">
     <input type="text" name="search_keyword" placeholder="이름.활동">
     </form>
</div>
<div class = "addButton">
	<a href='members_form.php'><button class='button primary small adding'>회원등록</button></a>
</div>
<br>                
<div class="container">
	
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select member_id,	member_name, membertype_name,  member_student_id 
			    from members natural join memberTypes ";

    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where member_student_id like '%$search_keyword%' or member_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>이름</th>
            <th>학번</th>
            <th>구분</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
       <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td>{$row['member_student_id']}</td>";
            echo "<td>{$row['membertype_name']}</td>";
           
            echo "<td width='17%'>
                <a href='members_form.php?member_id={$row['member_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['member_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
             $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(member_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "members_delete.php?member_id=" + member_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
