<!DOCTYPE html>
<html>
<head>
    <?php
    if (isset($title)) {
        print  "<title>" . $title . "</title>";
    } else echo "<title>Kszton statistics</title>";

/*    if (isset($styles))
        foreach ($styles as $s)
            echo "<link rel=\"stylesheet\" href=\"public/css/" . $s . ".css\" type=\"text/css\">";*/


    ?>

    <link rel="stylesheet" href="public/css/headerStyle.css" type="text/css">
    <link rel="stylesheet" href="public/css/loggedOutStyle.css" type="text/css">
    <link rel="stylesheet" href="public/css/mojeZaklady.css" type="text/css">
    <link rel="stylesheet" href="public/css/register.css" type="text/css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">




    <script src="https://kit.fontawesome.com/7b7c159c58.js" crossorigin="anonymous"></script>

</head>
