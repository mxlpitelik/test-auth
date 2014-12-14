<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/test-auth/css/style.css" />
    <script src="/test-auth/js/jquery-2.0.3.min.js" type="text/javascript"></script>
<?php 
    if(isset($title)) echo '<title>', $title, '</title>'; 
    if(isset($js)) echo '<script src="/test-auth/js/', $js, '" type="text/javascript"></script>'; 
    if(isset($css)) echo '<link rel="stylesheet" type="text/css" href="/test-auth/css/'.$css.'" />'; 
?>
</head>
<body>
    <table cellspacing="0" cellpadding="0" class="head">
        <tr>
            <td class="logo">
                Личный кабинетЪ
            </td>
            <td class="loggedas">
                Вы вошли как <b><?php echo $_SESSION['email']; ?></b> | <a href="/test-auth/user/logout">Выйти</a>
            </td>
        </tr>
    </table>
    <?php include 'lib/application/views/'.$content_view; ?>
</body>
</html>