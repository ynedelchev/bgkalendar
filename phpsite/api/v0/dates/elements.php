<?php
require dirname(__DIR__) . "/include/" . "config.php";
$element = isset($_SERVER["REDIRECT_ELEMENT"]) ? $_SERVER["REDIRECT_ELEMENT"] : ( isset($_SERVER["ELEMENT"]) ? $_SERVER["ELEMENT"] : null );
if ($element == null) {
   http_exit(404, "Not Found");
} 

    #$element = getenv("ELEMENT");
    $name = isset($_GET["name"]) ? $_GET["name"] : "";

    http_response_code(200);
    header('Content-Type: application/json');
    header('X-Result-Size: 0');
    echo "{\n";
    echo "  \"size\": 0,\n";
    echo "  \"code\": 0,\n";
    echo "  \"message\": \"elements\"\n";
    echo "  \"element\": \"" . $element . "\"\n";
    echo "  \"name\": \"" . $name . "\"\n";
    echo "  \"QUERY_STRING\": \"" . $_SERVER["QUERY_STRING"] . "\"\n";
    echo "  \"HTTP_HOST\": \"" . $_SERVER["HTTP_HOST"] . "\"\n";
    echo "  \"PHP_SELF\": \"" . $_SERVER["PHP_SELF"] . "\"\n";
    echo "}\n";
    exit(0);
?>
