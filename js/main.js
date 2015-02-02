var opts = {
    lines: 13, // The number of lines to draw
    length: 20, // The length of each line
    width: 10, // The line thickness
    radius: 30, // The radius of the inner circle
    corners: 1, // Corner roundness (0..1)
    rotate: 0, // The rotation offset
    direction: 1, // 1: clockwise, -1: counterclockwise
    color: '#000', // #rgb or #rrggbb or array of colors
    speed: 1, // Rounds per second
    trail: 60, // Afterglow percentage
    shadow: false, // Whether to render a shadow
    hwaccel: false, // Whether to use hardware acceleration
    className: 'spinner', // The CSS class to assign to the spinner
    zIndex: 2e9, // The z-index (defaults to 2000000000)
    top: '50%', // Top position relative to parent
    left: '50%' // Left position relative to parent
};
$(function() {
    updatetable($('#select').val());
});
function updatetable(sel) {
    var target = document.getElementById('index');
    var spinner = new Spinner(opts).spin(target);
    var column;
    if (jQuery.type(sel) == "string")
        column = sel;
    else
        column = sel.value;
    $.ajax({
        type: "GET",
        url: "bdd.php?column=" + column,
        dataType: "XML",
        success: function(xml) {
            initialize();
            var count = 1;
            $(xml).find('value').each(function() {
               var value = '<tr><td>' 
                   + count
                   + '</td><td>' 
                   + $(this).find('name').text() 
                   + '</td><td>' 
                   + $(this).find('total').text() 
                   + '</td><td>' 
                   + $(this).find('age').text() 
                   + '</td></tr>';
                addvalue(value);
                count++;
            });
            var total_values = $(xml).find('total_values').text();
            var total_values_content = "";
            if (total_values > 100) {
                total_values_content = "Displayed values : 100/" + total_values + " (" + $(xml).find('total_missing_rows').text() + " rows are missing)"; 
            } else {
                total_values_content = "Displayed values : " + total_values + "/" + total_values;
            }
            $('#total_values').text(total_values_content);
            spinner.stop();
        }
    });
}

function initialize() {
    $('#table_values').empty();
}

function addvalue(value) {
    var table_values = $('#table_values');
    table_values.append(value);
    return false;
}


