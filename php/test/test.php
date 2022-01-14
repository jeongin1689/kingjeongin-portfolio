<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP class | 테스트입니다</title>

    <!-- link -->
    <?php
        include "../include/link.php";
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

    <main id="main">
        <section id="mainContent">
            <h2 class="ir_so">메인 컨텐츠</h2>
            <article class="content-article">
                <h3>뿌엥 </h3>
                <p>뿌엥 게시판입니다!!!</p>
                <section class="section-board">
                    <h4 class="ir_so">게시판 컨텐츠</h4>
                    <div class="board-search">
                        <form action="testSearch.php" name="testSearch" method="get">
                            <fieldset>
                                <legend class="ir_so">게시판 검색 영역</legend>
                                <input type="search" name="searchKeyword" class="form-search" placeholder="검색어를 입력하세요" aria-label="search" required>
                                <select name="searchOption" id="searchOption" class="form-select">
                                    <option value="title">제목</option>
                                    <option value="content">내용</option>
                                    <option value="name">등록자</option>
                                </select>
                                <button type="submit" class="form-btn">검색</button>
                                <a href="testWrite.php" class="form-btn black">글쓰기</a>
                            </fieldset>
                        </form>
                    </div>
                    <div class="board-table">
                        <table>
                            <colgroup>
                                <col style="width: 5%" />
                                <col />
                                <col style="width: 10%" />
                                <col style="width: 12%" />
                                <col style="width: 7%" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>번호</th>
                                    <th>제목</th>
                                    <th>등록자</th>
                                    <th>등록일</th>
                                    <th>조회수</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
    if( isset($_GET['page']) ){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    // echo $page;

    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;
    //1~20 : DESC 0, 20     ---> page1   (viewNum * 1) - viewNum
    //21~40 : DESC 20, 20   ---> page2   (viewNum * 2) - viewNum
    //41~60 : DESC 40, 20   ---> page3   (viewNum * 3) - viewNum
    //61~80 : DESC 60, 20   ---> page4   (viewNum * 4) - viewNum
    //81~100 : DESC 80, 20  ---> page5   (viewNum * 5) - viewNum



    //두개의 테이블 JOIN 
    $sql = "SELECT t.testID, t.testTitle, m.youName, t.regTime, t.testView FROM webTest t JOIN webMember m ON (t.memberID = m.memberID) ORDER BY testID DESC LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if( $result ){
        $count = $result -> num_rows;

        if( $count > 0 ){
            for ( $i=1; $i <= $count; $i++ ){
                $info = $result -> fetch_array(MYSQLI_ASSOC);
                echo "<tr>";
                echo "<td>".$info['testID']."</td>";
                echo "<td><a href='testView.php?testID={$info['testID']}'>".$info['testTitle']."</a></td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                echo "<td>".$info['testView']."</td>";
                echo "</tr>";
            }
        }
    }
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="board-page">
                        <?php
                            include "../include/paging.php";
                        ?>
                    </div>
                </section>
            </article>
        </section>
    </main>
    <!-- //main -->

    <!-- footer -->
    <?php
        include "../include/footer.php";
    ?>
    <!-- //footer -->
</body>
</html>