<?php
    include_once "../connect/connect.php";
    include_once "../connect/session.php";
    include_once "../connect/sessionCheck.php";

    $memberID = $_SESSION['memberID'];
    $memberID = $connect -> real_escape_string($memberID);

    $sql = "DELETE FROM webMember WHERE memberID = {$memberID}";
    $connect -> query($sql);
?>

<script>
    location.href = "login.php";
</script>