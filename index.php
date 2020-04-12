<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="./calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="./calendar.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
</head>
    <body>

    <?php
        // include calendar class definition
        include 'CalendarClass.php';
    
        // instantiate object from class 
        $calendar = new Calendar();
        
        // display calendar object
        echo $calendar->show();

        // // instantiate 2nd object from class 
        // $calendar2 = new Calendar();
        
        // // display 2nd calendar object
        // echo $calendar2->show();
    ?>
        
    </body>
</html>