<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="titleofpage">보드 종류</div>
<div class="subtitleofpage"><br>4계절 내내 보드를 타 보아요!<br></div>
<br>
<div class="searchBox">
     <form action="boardtype_view.php" method="post">
     <input type="text" name="search_keyword" placeholder="보드 종류, 계절">
     </form>
</div>
<br>                
<div class="container">
	
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select* from eventTypes";
				
				

    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where eventtype_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>종류ID</th>
            <th>보드종류</th>
            <th>계절</th>

        </tr>
        </thead>
        <tbody>
       <?
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row['eventtype_id']}</td>";
            echo "<td>{$row['eventtype_name']}</td>";
            echo "<td>{$row['season']}</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
   
</div>
<? include("footer.php") ?>
