<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style>#ref { margin: 2% 10%; } #ref .link { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 80%; }</style>
</head>
<body>
<?php
if (file_exists('config.php')) 
    include 'config.php'; 
else 
    $PASSWORD = 'abcdef';
if (!isset($_POST["pwd"]) || ($_POST["pwd"] !== $PASSWORD)) { 
    echo '<form action="" method="post"><p><input type="password" name="pwd" autofocus></p><p><input type="submit" /></p></form></body></html>'; 
    die(); 
}
$visitors = [];
$referers = [];
if (($log = fopen("aayi.log", "r")) !== FALSE) {
    while (($data = fgetcsv($log, 1000, "\t")) !== FALSE) {
        if ($data[0] < (time() - 2678400))   // 31*24*3600 = 1 month
            continue;
        $rowdate = date("Y-m-d", $data[0]);
        $ip = $data[1];
        $ua = $data[3];
        $referer = $data[4];
        static $bots = array('bot', 'crawl', 'slurp', 'spider', 'yandex', 'WordPress', 'AHC', 'jetmon');
        foreach ($bots as $bot) {
            if (strpos($ua, $bot) !== false)
                continue;
        }
        if (array_key_exists($referer, $referers)) {
            $referers[$referer] = $referers[$referer] + 1;
        }
        else
            $referers[$referer] = 1;
        if (in_array($ip, $visitors[$rowdate]))  // already counted this day
            continue;
        $visitors[$rowdate][] = $ip;
    }
    fclose($log);
}    
for ($i = 0; $i < 30; $i++) {
    $key = date("Y-m-d", time() - $i * 3600 * 24);
    $y = ((isset($visitors[$key])) ? count($visitors[$key]) : 0);
    $points .= $y . ',';
}

echo '<div class="chart" data="' . substr($points, 0, -1) . '"></div>';
echo '<div id="ref"><strong>Referers</strong><br>';
foreach ($referers as $url => $mult) {
    if ($url !== '')
        echo '<div class="link">' . $mult . ': <a href="' . $url . '">' . $url . '</a></div>';
}
echo '</div>';
?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', { callback: function () { drawChart(); window.addEventListener('resize', drawChart, false); },  packages:['corechart'] });
function drawChart() {
    var formatDate = new google.visualization.DateFormat({ pattern: 'MMM d' });
    var ticksAxisH;
    function createDataTable(values)
    {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('date', 'Day');
        dataTable.addColumn('number', 'Unique visitors');
        var today = new Date();
        ticksAxisH = [];
        for (var i = 0; i < values.length; i++) {
            var rowDate = new Date(today - i * 24 * 3600 * 1000);
            var xValue = { v: rowDate, f: formatDate.formatValue(rowDate) };
            var yValue = parseInt(values[i]);
            dataTable.addRow([xValue, yValue]);
            if ((i % 7) === 0) { ticksAxisH.push(xValue); }      // add tick every 7 days
        }
        return dataTable;
    }
    var charts = document.getElementsByClassName("chart");
    for(var i = 0; i < charts.length; i++)
    {
        var chart = new google.visualization.AreaChart(charts[i]);
        var data = charts[i].getAttribute('data').split(',');
        var dataTable = createDataTable(data);
        chart.draw(dataTable, {
            hAxis: { gridlines: { color: '#f5f5f5' }, ticks: ticksAxisH },
            legend: 'none',
            pointSize: 6,
            lineWidth: 3,
            colors: ['#058dc7'],
            areaOpacity: 0.1,
            vAxis: { gridlines: { color: '#f5f5f5' } },
        });  
    }
}
</script>
</body>
</html>
