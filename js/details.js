$(document).ready(function(){
(function update() {
    $.ajax({
   type: 'POST',
  url: 'get_sensor_data.php',
  timeout: 1000,
  success: function(data) {
      var res = data.split(" ");
      $("#timer").html(res[0]);
      $("#id_tank_temp").html(res[1]);
      $("#id_env_temp").html(res[2]);
      $("#id_tank_ph").html(res[3]);
      $("#id_tank_fans").html(res[4] == 1 ? "ON" : "OFF");
      $("#id_tank_ac").html(res[5] == 1 ? "ON" : "OFF");
      $("#id_tank_overflow").html(res[6] == 1 ? "ON" : "OFF");
      
   },
    }).then(function() {           // on completion, restart
       setTimeout(update, 5000);  // function refers to itself
    });
})(); 



});

