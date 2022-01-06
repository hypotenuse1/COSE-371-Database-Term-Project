<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "eventLists_insert.php";

if (array_key_exists("event_id", $_GET)) {
    $event_id = $_GET["event_id"];
    $query =  "select * from eventLists where event_id = $event_id";
    $res = mysqli_query($conn, $query);
    $events = mysqli_fetch_array($res);
    if(!$events) {
        msg("등록이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "eventLists_modify.php";
    
}

$places  = array();

$query = "select * from places";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $places[$row['place_id']] = $row['place_name'];
}

$eventTypes = array();

$query = "select * from eventTypes";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $eventTypes[$row['eventtype_id']] = $row['eventtype_name'];
}
?>
    <div class="container">
        <form name="event_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="event_id" value="<?=$events['event_id']?>"/>
            <h3> 신청서 작성 <?php echo $mode; ?></h3>
            
            <p>
                <label for="event_name">활동명</label>
                <input type="text" placeholder="활동명 입력" name="event_name" value="<?=$events['event_name']?>"/>
            </p>
            
            <p>
                <label for="place_id">장소 선택</label>
                <select name="place_id" id="place_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($places as $id => $name) {
                            if($id == $events['place_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
           
        	<p>
                <label for="date">모임시간</label></label>
                <input type="text" placeholder="ex) 2021/11/23 오후 7시" name="date" value="<?=$events['date']?>"/>
            </p>
            
            <p>
            	<label for="eventtype_id">보드 분류</label>
                <select name="eventtype_id" id="eventtype_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($eventTypes as $id => $name) {
                            if($id == $events['eventtype_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
                
            </p>
            
            <p>
                <label for="event_desc">세부사항</label>
                <textarea placeholder="설명 추가" id="event_desc" name="event_desc" rows="10"><?=$events['event_desc']?></textarea>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("place_id").value == "-1") {
                        alert ("장소를 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("event_name").value == "-1") {
                        alert ("활동명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("date").value == "") {
                        alert ("시간을 지정해 주십시오"); return false;
                    }
                    else if(document.getElementById("eventtype_id").value == "-1") {
                        alert ("보드분류를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("event_desc").value == "") {
                        alert ("세부사항을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>