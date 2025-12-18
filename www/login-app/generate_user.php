<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
header('Content-Type: application/json');

$ref = time();
$digits = ["0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H",
"I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
$base = count($digits);
$output = "";
$timestamp = $ref;
while($ref > 0){
    $output .= ($digits[$ref % $base]);
    $ref = floor($ref / $base);
}
$result = strrev($output);

echo json_encode(['success' => true, 'user' => $result]);
exit;
?>

