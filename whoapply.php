<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("event_id", $_GET)) {
    $event_id = $_GET["event_id"];
    $query =  "select member_name, apply_date from apply natural join members natural join eventLists where event_id= $event_id";
    $res = mysqli_query($conn, $query);

}

?>
   <div class="container">
	

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>No.</th>
            <th>이름</th>
            <th>신청시각</th>
        </tr>
        </thead>
        <tbody>
        <?
        
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td>{$row['apply_date']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
  
</div>
<? include("footer.php") ?>