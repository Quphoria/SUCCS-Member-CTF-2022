<?php

include "session.php";

$FLAG = file_get_contents("/flag");

if (strcmp($QSESSION, "root") === 0) {
    echo $FLAG;
} else {
    echo "Nice try pal, only cool ppl get flagz";
}

?>