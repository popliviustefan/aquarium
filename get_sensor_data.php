<?php
    $tmp = exec("python3 python/get_sensor_data.py");
    echo strftime("%H:%M ").$tmp;
?>
