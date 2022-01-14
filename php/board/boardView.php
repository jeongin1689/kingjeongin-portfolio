<?php
    $title = "PHP Class | boardView";

    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
    include "../include/doctype.php";
?>

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

    <main id="main">
        <section id="mainContent">
            <h2 class="ir_so">메인 컨텐츠</h2>

            <article class="content-article">
                <h3>게시판</h3>
                <p>웹디자이너, 웹퍼블리셔, 프론트앤드 개발자를 위한 게시판입니다.</p>
                <section class="section-board">
                    <h4 class="ir_so">게시판 컨텐츠 보기</h4>
                    <div class="board-table view mt50">
                        <table>
                            <colgroup>
                                <col style="width: 20%" />
                                <col style="width: 80%" />
                            </colgroup>
                            <tbody>
<?php
    $boardID = $_GET['boardID'];

    // echo $boardID;

    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContent, b.o_name FROM webBoard b JOIN webMember m ON(b.memberID = m.memberID) WHERE b.boardID = {$boardID}";
    $result = $connect -> query($sql);

    echo var_dump($result);

    $view = "UPDATE webBoard SET boardView = boardView + 1 WHERE boardID = {$boardID}";
    $connect -> query($view);

    if( $result ){
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo "<tr><th>제목</th><td class='left'>".$info['boardTitle']."</td></tr>";
        echo "<tr><th>글쓴이</th><td class='left'>".$info['youName']."</td></tr>";
        echo "<tr><th>등록일</th><td class='left'>".date('Y-m-d H:i', $info['regTime'])."</td></tr>";
        echo "<tr><th>조회수</th><td class='left'>".$info['boardView']."</td></tr>";
        echo "<tr><th>파일</th><td class='left'>".$info['o_name']."</td></tr>";
        echo "<tr><th class='height'>내용</th><td class='height left'><img src='".$info['o_name']."'>".$info['boardContent']."</td></tr>";
    }
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="board-btn right mb50">
                        <a href="boardModify.php?boardID=<?=$_GET['boardID']?>">수정하기</a>
                        <a href="boardRemove.php?boardID=<?=$_GET['boardID']?>" onclick="confirm('정말 삭제하시겠습니까?', '')">삭제하기</a>
                        <a href="board.php">목록보기</a>
                    </div>
                </section>
            </article>
        </section>
<!— footer —>
<?php
    include "../include/footer.php";
?>
<!— //footer —>
    </main>