<?php
    include "../connect/connect.php";  //DB연결

    for( $i=1; $i<=100; $i++ ){
        $regTime = time();  //time() : 타임스탬프 출력 함수

        $sql = "INSERT INTO webTest(memberID, testTitle, testContent, testView, regTime) 
            VALUES(1, '게시판 타이틀${i}입니다.', '게시판 컨텐츠${i}입니다. 게시판 컨텐츠${i}입니다.', '1', '$regTime')";
            //webTest 테이블에 memberID, testTitle, testContent, testView, regTime 삽입 (띄어쓰기 필수) 
            //값은 순서대로 글쓴이 고유번호, '타이틀${i}', '컨텐츠${i}', '조회수', 시간
          
        $result = $connect -> query($sql);  //위에 쿼리문 짠거 DB에 넣는 변수 설정
    }
		if($result){
        echo "Create Notice True";
    } else {
        echo "Create Notice False";
    }
?>