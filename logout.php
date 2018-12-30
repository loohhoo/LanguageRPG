<?php

require "backend/sessionInfo.php";

session_destroy();
$ISLOGGEDIN = false;

echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'">';

?>