<?php

function check_method() {
    if($_SERVER['REQUEST_METHOD'] == "GET") return 1;   //  1 - GET
    elseif($_SERVER['REQUEST_METHOD'] == 'POST') return 2;   //  2 - POST
    else return FALSE;
}
