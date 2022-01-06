<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="titleofpage">최신 신청현황</div>
<div class="subtitleofpage"><br>자유롭게 취소/변경해주세요!<br></div>
<br>
<div class="searchBox">
     <form action="applyLists.php" method="post">
     <input type="text" name="search_keyword" placeholder="이름.활동">
     </form>
</div>
<div class = "addButton">
	<a href='apply_form.php'><button class='button primary small adding'>신청하기</button></a>
</div>
<br>                
<div class="container">
	
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select apply_id, event_name, member_name, apply_date 
				from apply natural join members natural join eventLists";
				
				

    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where event_name like '%$search_keyword%' or member_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>활동명</th>
            <th>이름</th>
            <th>신청시각</th>
            <th>기능</th>
            
        </tr>
        </thead>
        <tbody>
       <?
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row['event_name']}</td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td>{$row['apply_date']}</td>";
            
            echo "<td width='17%'>
                <a href='apply_form.php?apply_id={$row['apply_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['apply_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(apply_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "apply_delete.php?apply_id=" + apply_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
