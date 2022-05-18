<?php
include_once('./_common.php');
$vidx = $_POST['vidx'];


$sql = " update {$g5['video_table']}
                    set states      = '3'
                    where idx = '{$vidx}' ";
        sql_query($sql);

echo(json_encode(array("resutl" => "ok", "msg" => "처리되었습니다.")))
?>