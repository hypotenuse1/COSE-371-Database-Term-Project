<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="titleofpage">활동목록</div>
<div class="subtitleofpage"><br>자유롭게 참여해 주세요!<br></div>
<br>
<div class="searchBox">
     <form action="eventLists.php" method="post">
     <input type="text" name="search_keyword" placeholder="활동명">
     </form>
</div>
<br>  
<div class = "addButton">
	<a href='eventLists_form.php'><button class='button primary small adding'>활동추가</button></a>
</div>
<div class = "addButton">
	<a href='apply_form.php'><button class='button primary small adding'>활동신청</button></a>
</div>
<br>   
<div class="container">
	
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select event_id, event_name, place_name, place_id, eventtype_name, date, event_desc,total from eventLists natural join eventTypes natural join places  group by event_id";
 
			
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  "select event_id, event_name, place_name, place_id, eventtype_name, date, event_desc
			from eventLists natural join eventTypes natural join places
			where event_name like '%$search_keyword%' or place_name like '%$search_keyword%' 
			or event_desc like '%$search_keyword%' group by event_id ";

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
            <th>활동명</th>
            <th>장소</th>
            <th>분류</th>
            <th>모임시간</th>
            <th>참가인원</th>
            <th>비고</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
       <?
       
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['event_name']}</td>";
            echo "<td><a href='places_view.php?place_id={$row['place_id']}'>{$row['place_name']}</a></td>";
            echo "<td>{$row['eventtype_name']}</td>";
            echo "<td>{$row['date']}</td>";
            
            $q = "select eventLists.event_id, count(*) from eventLists inner join apply on eventLists.event_id = apply.event_id
						 where eventLists.event_id = {$row['event_id']};";
			$res1 = mysqli_query($conn, $q);
    		$arr = mysqli_fetch_array($res1);
    		$appliers = $arr['count(*)']; 
            echo "<td><a href='whoapply.php?event_id={$row['event_id']}'>{$appliers}</a></td>"; //needs work
            echo "<td>{$row['event_desc']}</td>";
            echo "<td width='17%'>
                <a href='eventLists_form.php?event_id={$row['event_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['event_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(event_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "eventLists_delete.php?event_id=" + event_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
