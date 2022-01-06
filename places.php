<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="titleofpage">장소 목록</div>
<div class="subtitleofpage"><br>시간은 자차 기준이며, 시간/날짜에 따라 다를 수 있습니다.<br></div>
<br>
<div class="searchBox">
     <form action="places.php" method="post">
     <input type="text" name="search_keyword" placeholder="장소명, 주소">
     </form>
</div>
<br>                
<div class="container">
	
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select* from places";
				
				

    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where place_name like '%$search_keyword%' or place_address like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>장소ID</th>
            <th>장소명</th>
            <th>상세주소</th>
            <th>거리(편도, 시간단위)</th>
            <th>이동수단</th>
            
        </tr>
        </thead>
        <tbody>
       <?
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row['place_id']}</td>";
            echo "<td>{$row['place_name']}</td>";
            echo "<td>{$row['place_address']}</td>";
            echo "<td>{$row['transport_time']}</td>";
            echo "<td>{$row['transportation']}</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
   
</div>
<? include("footer.php") ?>
