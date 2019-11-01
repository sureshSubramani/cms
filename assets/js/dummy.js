if (data.length > 0) {
    var result = JSON.parse(JSON.stringify(data));
    console.log(data);
    var j = 0;
    var html = '';
    var tt = 1;
    var dp = [];
    var count_total = 0;

    for (var i = 0; i < result.length; i++) {

        dp.push(result[i].dat+'-'+result[i].empID);

    }
    console.log(dp)
    var count = [];

    dp.forEach(function(i) {

        count[i] = (count[i] || 0) + 1;
    });
    // console.log(count)
    for (var i = 0; i < result.length; i++) {
        // console.log(result)
        var rows = count[result[i].dat+'-'+result[i].empID];
        count_total+=parseFloat(result[i].tot);

        // console.log(result[i].tot);
        var sum = 0;

        html += '<tr>';
        if (j == 0) { // render for first row of user data only
            html += '<td rowspan="' + rows + '">' + tt + '</td>';
            // html += '<td rowspan="' + rows + '" >' + result[i].dat + '</td>';

            // html += '<td rowspan="' + rows + '" >' + result[i].empID + '</td>';

            // html += '<td rowspan="' + rows + '">' + result[i].name + '</td>';

        }
        html += '<td>' + result[i].dat + '</td>';
        html += '<td >' + result[i].empID + '</td>';
        html += '<td>' + result[i].name + '</td>';

        html += '<td>' + result[i].comp + '</td>';
        html += '<td>' + result[i].proc_bundle + '</td>';
        html += '<td>' + result[i].bundle_wise + '</td>';
        html += '<td>' + result[i].comp_wise + '</td>';
        html += '<td>' + result[i].tot + '</td>';
       

        html += '</tr>';

        if (j == (rows - 1)) {                  
                html += '<tr>';
                html += '<td colspan="3">Total</td>';
                html += '<td >'+count_total+'</td>';
                html += '</tr>';                 
            }  

        j += 1;

        if (j == rows) {
            j = 0;
            tt++;
            count_total = 0;
        }

    }
    $('#billData').append(html);
    $("#billreport").show();