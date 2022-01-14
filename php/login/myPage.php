<?php
    error_reporting(E_ALL);
    ini_set("diplay_errors", 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP class : 마이페이지</title>

    <!-- link -->
    <?php
        include "../include/link.php";
        include_once "../connect/connect.php";
        include_once "../connect/session.php";
        include_once "../connect/sessionCheck.php";
    ?>
    <!-- //link -->

</head>
<body>
    <div id="skip">
        <a href="#main">컨텐츠 바로가기</a>
        <a href="#footer">푸터 바로가기</a>
    </div>
    <!-- //skip -->

    <!-- header -->
    <?php
        include "../include/header.php";
    ?>
    <!-- //header -->

    <?php
        $sql = "SELECT * FROM webMember WHERE memberID = {$_SESSION['memberID']}";
        $result = $connect -> query($sql);

        if( $result ){
            $info = $result -> fetch_array(MYSQLI_ASSOC);
        }
    ?>

        <main id="main">
            <section id="mainContent" class="gray">
                <h2 class="ir_so">메인 컨텐츠</h2>
                <article class="content-article">
                    <div class="member-form">
                        <h3>마이페이지</h3>
                        <form name="join" action="myPageSave.php" method="POST">
                            <fieldset>
                                <legend class="ir_so">마이페이지</legend>
                                <div class="member-box">
                                    <div>
                                        <label for="youEmail">이메일</label>
                                        <input type="email" name="youEmail" id="youEmail" class="input_write" value="<?=$info["youEmail"]?>" readOnly="" disabled="" autocmplete="off" autofocus required>
                                    </div>
                                    <div>
                                        <label for="youPass">비밀번호 수정</label>
                                        <input type="password" name="youPass" id="youPass" class="input_write" maxlength="20" placeholder="변경할 비밀번호를 적어주세요!" autocmplete="off" required>
                                    </div>
                                    <div>
                                        <label for="youPassC">비밀번호 수정 확인</label>
                                        <input type="password" name="youPassC" id="youPassC" class="input_write" maxlength="20" placeholder="다시 한 번 비밀번호를 적어주세요!" autocmplete="off" required>
                                    </div>
                                    <div>
                                        <label for="youName">이름 수정</label>
                                        <input type="text" name="youName" id="youName" class="input_write" value="<?=$info["youName"]?>" maxlength="5" placeholder="변경할 이름을 적어주세요!" autocmplete="off" required>
                                    </div>
                                    <div>
                                        <label for="youBirth">생년월일 수정</label>
                                        <input type="text" name="youBirth" id="youBirth" class="input_write" value="<?=$info["youBirth"]?>" placeholder="YYYY-MM-DD" autocmplete="off" required>
                                    </div>
                                    <div>
                                        <label for="youPhone">휴대폰 번호</label>
                                        <input type="text" name="youPhone" id="youPhone" class="input_write" readOnly="" disabled="" value="<?=$info["youPhone"]?>" placeholder="000-0000-0000" autocmplete="off" required>
                                    </div>
                                </div>
                                                        </fieldset>
                            <button id="joinBtn" class="btn_submit" type="submit">수정하기</button>
                        </form>
                        <div class="stop_mem"><a href="myPageRemove.php?memberID=<?=$_SESSION['memberID']?>" id="stopBtn" onclick="confirm('정말 탈퇴하시겠습니까?', ''); confirm('정말?', ''); confirm('또 와요.', '');">회원 탈퇴</a></div>
                    </div>
                </article>
            </section>
        </main>
        <?  ?>

        <!-- footer -->
            <?php
                include "../include/footer.php";
            ?>
        <!-- //footer -->

</body>
</html>