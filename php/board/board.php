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
    <title>PHP class</title>

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
                <h3>게시판</h3>
                <p>웹디자이너, 웹퍼블리셔, 프론트앤드 개발자를 위한 게시판입니다.</p>
                <section class="section-board">
                    <h4 class="ir_so">게시판 컨텐츠</h4>
                    <div class="board-search">
                        <form action="boardSearch.php" name="boardSearch" method="get">
                            <fieldset>
                                <legend class="ir_so">게시판 검색 영역</legend>
                                <input type="search" name="searchKeyword" class="form-search" placeholder="검색어를 입력하세요" aria-label="search" required>
                                <select name="searchOption" id="searchOption" class="form-select">
                                    <option value="title">제목</option>
                                    <option value="content">내용</option>
                                    <option value="name">등록자</option>
                                </select>
                                <button type="submit" class="form-btn">검색</button>
                                <a href="boardWrite.php" class="form-btn black">글쓰기</a>
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

    $viewNum = 20;
    $viewLimit = ($viewNum * $page) - $viewNum;

    //1 ~20  : DESC 0,  20   ---> page1   (viewNum * 1) - viewNum
    //21~40  : DESC 20, 20   ---> page2   (viewNum * 2) - viewNum
    //41~60  : DESC 40, 20   ---> page3   (viewNum * 3) - viewNum
    //61~60  : DESC 60, 20   ---> page4   (viewNum * 4) - viewNum
    //81~100 : DESC 80, 20   ---> page5   (viewNum * 5) - viewNum
    

    //두개의 테이블 JOIN 
    $sql = "SELECT b.boardID, b.boardTitle, m.youName, b.regTime, b.boardView FROM webBoard b JOIN webMember m ON (b.memberID = m.memberID) ORDER BY boardID DESC LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if( $result ){
        $count = $result -> num_rows;

        if( $count > 0 ){
            for ( $i=1; $i <= $count; $i++ ){
                $info = $result -> fetch_array(MYSQLI_ASSOC);
                echo "<tr>";
                echo "<td>".$info['boardID']."</td>";
                echo "<td><a href='boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                echo "<td>".$info['boardView']."</td>";
                echo "</tr>";
            }
        }
    }
?>
                                <!-- <tr>
                                    <td>1</td>
                                    <td class="left"><a href="boardView.html">웹 퍼블리셔 포트폴리오가 궁금합니다.</a></td>
                                    <td>웹쓰</td>
                                    <td>2021.10.01</td>
                                    <td>30</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <div class="board-page">
                        <ul>
<?php
    $sql = "SELECT count(boardID) FROM webBoard";
    $result = $connect -> query($sql);

    $boardTotalCount = $result -> fetch_array(MYSQLI_ASSOC);
    $boardTotalCount = $boardTotalCount['count(boardID)'];

    //echo $boardTotalCount;

    //총 페이지 수
    $boardTotalPage = ceil($boardTotalCount/$viewNum);

    //echo $boardTotalPage;

    //1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16
    //현재 페이지를 기준으로 보여주고 싶은 갯수
    $pageView = 5;
    $startPage = $page - $pageView;
    $endPage = $page + $pageView;

    //처음 페이지 초기화 
    if( $startPage < 1 ) $startPage = 1;

    //마지막 페이지 초기화
    if( $endPage >= $boardTotalPage ) $endPage = $boardTotalPage;

    //처음으로
    if( $page != 1 ) {
        echo "<li><a href='board.php?page=1'>처음으로</a></li>";
    }

    //이전 페이지
    if( $page !=1 ){
        $prevPage = $page - 1;
        echo "<li><a href='board.php?page={$prevPage}'>이전</a></li>";
    }

    for( $i=$startPage; $i<=$endPage; $i++ ){
        $active = "";
        if( $i == $page ) $active = "active";

        echo "<li class='{$active}'><a href='board.php?page={$i}'>{$i}</a></li>";
    }

    //다음 페이지
    if($page !=$endPage){
        $nextPage = $page + 1;
        echo "<li><a href='board.php?page={$nextPage}'>다음</a></li>";
    }


    //마지막으로
    if($page !=$endPage){
        echo "<li><a href='board.php?page={$boardTotalPage}'>마지막으로</li>";
    }


?>
                    
                        <!-- <ul>
                            <li><a href="#">처음으로</a></li>
                            <li><a href="#">처음</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li><a href="#">7</a></li>
                            <li><a href="#">다음</a></li>
                            <li><a href="#">마직막으로</a></li>
                        </ul> —>
                        </ul>
                    </div>
                </section>
            </article>
        </section>
    </main>
    <!— //main —>

    <!— footer —>
    <?php
        include "../include/footer.php";
    ?>
    <!— //footer —>
</body>
</html>