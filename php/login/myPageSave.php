<?php
    include_once "../connect/connect.php";
    include_once "../connect/session.php";
    include_once "../connect/sessionCheck.php";


    $youPass = $_POST['youPass'];
    $youPassC = $_POST['youPassC'];
    $youName = $_POST['youName'];
    $youBirth = $_POST['youBirth'];
    $memberID = $_SESSION['memberID'];

    //메세지 출력
    function msg( $alert ){
        echo "<p class='alert'> {$alert} </p>";
    }

    //비밀번호 유효성 검사
    if( $youPass !== $youPassC ){
        msg("비밀번호가 일치하지 않아요!! <br> 다시 한번 확인해주세요!!");
    }

    //이름 유효성 검사
    $check_name = preg_match("/^[가-힣]{1,}$/", $youName);

    if( $check_name == false ){
        msg("이름이 정확하지 않습니다!!!! <br> 한글로만 적어주세요!!!");
        exit;
    }

    //생년월일 유효성 검사
    $check_birth = preg_match("/^(19[0-9][0-9]|20\d{2})-(0[0-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $youBirth);

    if( $check_birth == false ){
        msg("생년월일이 정확하지 않습니다!!! <br> 올바른 생년월일을 적어주세요!(YYYY-MM-DD)");
        exit;
    }

    //마이페이지
    $sql = "UPDATE webMember SET youPass = '{$youPass}', youName = '{$youName}', youBirth = '{$youBirth}' WHERE memberID = '{$memberID}'";
    $result = $connect -> query($sql);

    if( $result ){
        $_SESSION['youName'] = $youName;
        echo "<script> alert('정보가 수정되었습니다!!'); location.href='myPage.php'; </script>";
    } else {
        msg("에러발생03 - 관리자에게 문의하세요.");
        exit;
    }

?>