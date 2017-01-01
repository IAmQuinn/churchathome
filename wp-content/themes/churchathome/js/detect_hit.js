$j(document).ready(function() {
    //check to see if we already have a unique ID
    if($j.cookie('unique_id')) {
        unique_id = $j.cookie('unique_id');
        console.log("Have Unique ID: " + unique_id);
    } else {
        //if we don't have a unique ID, then create one and save it
        var seconds = new Date().getTime() / 1000;
        //hopefully creating a unique ID. Not 100% guarantee, but for these purposes it's ok.
        var unique_id = Math.floor(seconds + (Math.random()*1000)+1);

        var date = new Date();
        var hours = 2;
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        $j.cookie('unique_id', unique_id, { expires: date });
    }

    var minutes = 0;
    if($j.cookie('minutes')) {
        minutes = parseInt($j.cookie('minutes'));
        console.log(minutes + " minutes");
    }

    var id_interval_5_min = setInterval(function() {
        minutes += 5;
        $j.cookie('minutes', minutes, { expires: 1 });
        console.log(minutes + " minutes");

        $j.post("api/record_hit.php", { instance_id:unique_id, minutes: minutes }, function(response) {
            console.log(response);
        });

//    }, (60000)); //60000 = 60 seconds x 30 equals 5 minutes
    }, (60000 * 5)); //60000 = 60 seconds x 30 equals 5 minutes
});