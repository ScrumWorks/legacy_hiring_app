<?php

mysql_connect("localhost", "username", "password");
mysql_select_db("legacy_app");
$res = mysql_query("SELECT * FROM users");

while($data = mysql_fetch_array($res)) {
    echo "Sending data of user: " . $data['id'];
    $ok = sendDataToApi($data["id"], $data["name"]);
    echo $ok ? "ok" : "not ok";
    echo "\n";
}

echo "Done";

function sendDataToApi($userId, $name) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://example.com/api/dosomething?userId=$userId&name=$name");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpcode === 200;
}
