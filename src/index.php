<html>
    <body>
        <a href="https://adventofcode.com/2022">Avent of Code</a> 
        <p></p>
        Results:
        <ul>
        <?php
        for($i = 1; $i<=25; $i++) {
            echo "<li><a href='/day". $i ."/'>Day ". $i ."</a></li>";
        }
        ?>
        
        </ul>
    </body>
</html>



