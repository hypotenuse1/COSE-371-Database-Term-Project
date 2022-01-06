<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("place_id", $_GET)) {
    $place_id = $_GET["place_id"];
    $query = "select * from places where place_id = $place_id";
    $res = mysqli_query($conn, $query);
    $places = mysqli_fetch_assoc($res);
    if (!$places) {
        msg("장소가 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>장소 세부사항</h3>

        <p>
            <label for="place_id">장소코드</label>
            <input readonly type="text" id="place_id" name="place_id" value="<?= $places['place_id'] ?>"/>
        </p>

        <p>
            <label for="place_name">장소명</label>
            <input readonly type="text" id="place_name" name="place_name" value="<?= $places['place_name'] ?>"/>
        </p>

        <p>
            <label for="place_address">상세주소</label>
            <input readonly type="text" id="place_address" name="place_address" value="<?= $places['place_address'] ?>"/>
        </p>

        <p>
            <label for="transport_time">거리(편도, 시간단위)</label>
            <input readonly type="text" id="transport_time" name="transport_time" value="<?= $places['transport_time'] ?>"/>
        </p>

		<p>
            <label for="transportation">이동수단</label>
            <input readonly type="text" id="transportation" name="transportation" value="<?= $places['transportation'] ?>"/>
        </p>
       

    </div>
<? include("footer.php") ?>