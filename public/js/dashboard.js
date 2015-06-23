function drawMoodleChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Gedaan', 90],
        ['Nog te doen', 10]
    ]);

    // Set chart options
    var options = {
        'width': 600,
        'height': 300,
    slices: {
         0: {color: '#ff0000' },
         1: {color: '#ff9999' }}
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('moodle_graph'));
    chart.draw(data, options);
}

function drawLyndaChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Gedaan', 25],
        ['Nog te doen', 75]
    ]);

    // Set chart options
    var options = {
        'width': 600,
        'height': 300,
    slices: {
            0: { color: '#0000FF' },
            1: { color: '#9999ff' }
          }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('lynda_graph'));
    chart.draw(data, options);
}
function drawMPLChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Gedaan', 30],
        ['Nog te doen', 70]
    ]);

    // Set chart options
    var options = {
        'width': 600,
        'height': 300,
    slices: {
            0: { color: '#00FF00' },
            1: { color: '#b2ffb2' }
          }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('mpl_graph'));
    chart.draw(data, options);
}
function drawCourseChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Gedaan', 40],
        ['Nog te doen', 60]
    ]);

    // Set chart options
    var options = {
        'width': 600,
        'height': 300,
    slices: {
            0: { color: '#FFA500' },
            1: { color: '#ffd27f' }
          }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('course_graph'));
    chart.draw(data, options);
}

google.load('visualization', '1.0', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawMoodleChart);
google.setOnLoadCallback(drawLyndaChart);
google.setOnLoadCallback(drawMPLChart);
google.setOnLoadCallback(drawCourseChart);
