<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    // include "../connect/sessionCheck.php";
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
                <h3>검색 결과</h3>
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
                        </fieldset>
                    </form>
                </div>

<?php
    $searchKeyword = $_GET['searchKeyword'];
    $searchOption = $_GET['searchOption'];

    // echo $searchKeyword, $searchOption;

    if( $searchKeyword == '' || $searchOption == ''){
        echo "<p>검색어가 없습니다.</p>";
    }

    function msg($alert){
        echo "<p>총 ".$alert." 건이 검색되었습니다.</p>";
    }
    
    if( isset($_GET['page']) ){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;

    $searchKeyword = $connect -> real_escape_string($searchKeyword);
    $searchOption = $connect -> real_escape_string($searchOption);

    $sql = "SELECT b.boardID, b.boardTitle, b.boardContent, b.boardView, m.youName, b.regTime FROM webBoard b JOIN webMember m ON (b.memberID = m.memberID) ";

    switch($searchOption){
        case 'title' : 
            $sql .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$viewNum}";
            break;
        case 'content' : 
            $sql .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$viewNum}";
            break;
        case 'name' : 
            $sql .= "WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$viewNum}";
            break;
    };
    //echo $sql;
    $result = $connect -> query($sql);

    if( $result ){
        $count = $result -> num_rows;

        msg($count);
    };
?>

                    <section class="section-board">
                    <h4 class="ir_so">게시판 컨텐츠</h4>
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

    if( $result ){
        $count = $result -> num_rows;

        if( $count > 0 ){
            
            for ( $i=0; $i < $count; $i++ ){
                $info = $result -> fetch_array(MYSQLI_ASSOC);
                echo "<tr>";
                echo "<td>".$info['boardID']."</td>";
                echo "<td><a href='boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</a></td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                echo "<td>".$info['boardView']."</td>";
                echo "</tr>";
            }
        }
    }
?>

                            </tbody>
                        </table>
                    </div>
                    <div class="board-page">
                        <ul>
<?php

    $sql = "SELECT count(boardID) FROM webBoard";
                        //count() : webBoard에 있는 boardID의 배열 개수 구하기
    $result = $connect -> query($sql);

    //결과를 배열로 저장한 값을 $boardTotalCount 변수에 저장
    $boardTotalCount = $result -> fetch_array(MYSQLI_ASSOC);
    //그 배열에 boardID의 개수 넣어줌
    $boardTotalCount = $boardTotalCount['count(boardID)'];

    
    //총 페이지 수 = boardTotalCount를 20으로 나눈 값 올림(ceil)
    $searchTotalPage = ceil($boardTotalCount/$viewNum);
    
    // echo $searchTotalPage;

    $pageView = 6;        //현재 페이지를 기준으로 보여주고 싶은 개수
    $pageViewMax = 3;     //endPage일 때 추가로 보여줄 개수

    //$pageCount = (내가 보고 있는 페이지 / 6)을 올림한 값
    $pageCount = ceil($page / $pageView);
    

    //$startPage = ((1 - 1) * (6)) + 1 = 1;
    //$endPage = 1 * 6 = 6;
    $startPage = (($pageCount - 1) * ($pageView)) + 1;
    $endPage = $pageCount * $pageView;

    
    //현재 페이지와 마지막 페이지가 같으면 
    //1($startPage) + 3 = 4;
    //6($endPage) + 3 = 9;
    if($page == $endPage){
        $startPage = $startPage + $pageViewMax;
        $endPage = $endPage + $pageViewMax;
    }

    //마지막 페이지 초기화
    if( $endPage >= $searchTotalPage ) $endPage = $searchTotalPage;

    //처음으로
    if( $startPage != 1 ) {
        echo "<li><a href='boardSearch.php?page=1&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>처음으로</a></li>";
    }

    //이전 페이지
    if( $page !=1 ){
        $prevPage = $page - 1;
        echo "<li><a href='boardSearch.php?page={$prevPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>이전</a></li>";
    }

    for( $i=$startPage; $i<=$endPage; $i++ ){
        $active = "";
        if( $i == $page ) $active = "active";

        echo "<li class='{$active}'><a href='boardSearch.php?page={$i}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>{$i}</a></li>";
    }

    //다음 페이지
    if( $page != $searchTotalPage ) {
        $nextPage = $page + 1;
        echo "<li><a href='boardSearch.php?page={$nextPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>다음</a></li>";
    }

    //마지막으로
    if( $page != $searchTotalPage ) {
        echo "<li><a href='boardSearch.php?page={$searchTotalPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>마지막으로</a></li>";
    }
?>
                        </ul>
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