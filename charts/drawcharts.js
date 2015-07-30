google.load("visualization", "1", {packages:["corechart", "gauge", "map"]});

var drawCharts = function() {
    $('.drawcharts').each(function(index) {
        var element = $(this);

        var url = chart_data[element[0].id]['url'];
        var postdata = chart_data[element[0].id]['post'];
        var chart = chart_data[element[0].id]['chart'];
        var options = chart_data[element[0].id]['options'];

        $.ajax({
            async: false,
            type: 'POST',
            url: url,
            data: postdata,
            success: function(results) {
                var json = $.parseJSON(results);

                var data = google.visualization.arrayToDataTable(json.data);

                var gchart = new google.visualization[chart](element[0]);

                gchart.draw(data, options);
            }
        });
    });
}

$(function() {
    google.setOnLoadCallback(drawCharts);
});