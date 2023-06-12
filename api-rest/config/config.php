<?php 
define('REGEX_EMAIL', "/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/");
define('REGEX_TEXT', "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/");
define('REGEX_ALLCHAR', '/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/');
define("REGEX_NUMBERS", "/^[0-9]+/");
?>