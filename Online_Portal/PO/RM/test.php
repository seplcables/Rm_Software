<html>
<script src="https://jspreadsheet.com/v7/jspreadsheet.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jspreadsheet.com/v7/jspreadsheet.css" type="text/css" />
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
<div id="spreadsheet2"></div>
</html> 
<script>
var data2 = [
    [3, 'Cheese', true],
    [1, 'Apples', true],
    [2, 'Carrots', true],
    [1, 'Oranges', false],
];
 
var filterOptions = function(o, cell, x, y, value, config) {
    var value = o.getValueFromCoords(x - 1, y);
 
    if (value == 1) {
        config.source = ['Apples','Bananas','Oranges'];
    } else if (value == 2) {
        config.source = ['Carrots'];
    } else {
        config.source = ['Apples','Bananas','Carrots','Oranges','Cheese'];
    }
 
    return config;
}
 
jspreadsheet(document.getElementById('spreadsheet2'), {
    data: data2,
    columns: [
        { type:'dropdown', title:'Category', width:'300', source:[ {'id':'1', 'name':'Fruits'}, {'id':'2', 'name':'Legumes'}, {'id':'3', 'name':'General Food'} ] },
        { type:'dropdown', title:'Food', width:'200', source:['Apples','Bananas','Carrots','Oranges','Cheese'], filterOptions: filterOptions },
        { type: 'checkbox', title:'Buy', width:'100' },
    ],
    onchange: function(instance, cell, c, r, value) {
        if (c == 0) {
            var columnName = jspreadsheet.getColumnNameFromId([c + 1, r]);
            instance.jexcel.setValue(columnName, '');
        }
    },
    license: 'MTExNjBlNmIwMDIwNmUyMzQ1MjlmYmRkYWJmYzNjZWY2MTA2MWNkZjJmY2ZmNTViYWY0NjM1N2Q0YzYwMjQ1OTZjOThkZTJmNWQxMGUwODA5ZGMxMzNkZGQ5YmVhMDhiZGI1ZTA2ZTQ4ZTdjMjYwMGRlZTBiMDE3MzZmOTliNTUsZXlKdVlXMWxJam9pVTI1bGFHRnNJRkJoZEdWc0lpd2laR0YwWlNJNk1UWTROakE1TWpRd01Dd2laRzl0WVdsdUlqcGJJakV3TXk0MU15NDNNaTR4T0RnaUxDSXlOeTQxTkM0eE56SXVOakFpTENJeE9USXVNVFk0TGpFdU1qRTFJaXdpTVRreUxqRTJPQzR3TGpJME5TSXNJakU1TWk0eE5qZ3VNUzR5TkRJaUxDSXhPVEl1TVRZNExqRXVNVEl5SWl3aWJHOWpZV3hvYjNOMElsMHNJbkJzWVc0aU9pSTFJaXdpYzJOdmNHVWlPbHNpZGpjaUxDSjJPQ0pkZlE9PQ==',
});
</script>
