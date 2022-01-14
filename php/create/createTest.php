<?php
    include "../connect/connect.php";  //DB 연결

    $sql = "CREATE TABLE webTest (";  //테이블명은 webTest
    $sql .= "testID int(10) unsigned NOT NULL AUTO_INCREMENT,";  //컬럼명 testID, 정수형(10글자), 범위 양수, NULL값 허용X, 값 자동증가
    $sql .= "memberID int(10) unsigned NOT NULL,";  //컬럼명 memberID, 정수형(10글자) 범위 양수, NULL값 허용X
    $sql .= "testTitle varchar(50) NOT NULL,";  //컬럼명 testTitle, 문자형(50글자) NULL값(빈 데이터) 허용X 
    $sql .= "testContent longtext NOT NULL,";  //컬럼명 Content, 최대 4294967295글자, 〃
    $sql .= "testView int(10) unsigned NOT NULL,";  //컬럼명 testView, 정수형(10글자), 범위 양수, 〃
    $sql .= "regTime int(15) unsigned NOT NULL,";  //시간  정수형(15글자), 시간은 양수만 있으니까 unsigned사용, 〃
    $sql .= "PRIMARY KEY (testID)) CHARSET=utf8"; //testID 컬럼을 주 키로 지정. 이유는??

    $result = $connect -> query($sql);  //쿼리문을 DB에 넣어주는 변수 

    if($result){  //쿼리문이 DB에 제대로 들어갔다면 True 아니면 Flase
        echo "Create Board True";
    } else {
        echo "Create Board False";
    }
?>