<?php
    include "process.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>
        <link href='http://fonts.googleapis.com/css?family=Roboto&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="js/resources/css/ext-all.css">
        <link rel="stylesheet" type="text/css" href="js/examples/shared/example.css">
		<script type="text/javascript" src="javascript/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript">
            $(function () {
                $('#container').highcharts({
            chart: {
                type: 'spline',
                zoomType: 'x',  
                style: {
                fontFamily: 'Roboto'}
            },
            title: {
                text: 'Nồng độ <?php echo $name;?> theo thời gian'
            },
            subtitle: {
                text: 'Dữ liệu gốc (5 phút) ngày <?php echo $day?> tháng <?php echo $month+1?> năm <?php echo $year?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                text: 'Thời gian'
            },
            yAxis: {
                title: {
                    text: 'Nồng độ (<?php echo $unit_show?>)'
                },
                plotLines: [{
                   value: <?php if ($count<>0) echo trungbinh($total,$count); else echo 0 ?>,
	                color: 'purple',
	                width: 2,
	                label: {
	                    text: 'Trung bình số học: <?php if ($count<>0) echo trungbinh($total,$count); else echo 0 ?>',
                        align: 'left',
	                    style: {
	                        color: 'gray'
                      }
                   }  
	           },{
                   value: <?php echo $qcvn ?>,
	                color: 'red',
	                width: 2,
	                label: {
	                    text: 'Qui chuẩn Việt Nam: <?php echo $qcvn." ".$unit_show?>',
                        align: 'left',
	                    style: {
	                        color: 'gray'
                      }
                   }  
	           }]
            },
            tooltip: {
                formatter: function() {
                        return 'Thời gian: ' + Highcharts.dateFormat('%H:%M', this.x)+'<br/>'+
                            'Nồng độ: '+ this.y +' <?php echo $unit_show?>';
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            plotOptions: {
                series: {
                    cursor: 'pointer'
                },
            },    
            series: [{
                
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [<?php echo join($datachart, ','); ?>]
            }],
            lang: {
                noData: "Không có số liệu theo yêu cầu"
            },
            noData: {
                style: {    
                fontWeight: 'bold',     
                fontSize: '20px',
                color: '#303030'        
            }
        }
        });
    });
		</script>
        <script type="text/javascript">
            /*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
    'Ext.state.*'
]);

Ext.onReady(function() {
    Ext.QuickTips.init();
    
    // setup the state provider, all state information will be saved to a cookie
    Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));

    // sample static data for the store
    var myData = [
        
        <?php echo join($data, ','); ?>
        
    ];

    /**
     * Custom function used for column renderer
     * @param {Object} val

    function change(val) {
        if (val > 0) {
            return '<span style="color:green;">' + val + '</span>';
        } else if (val < 0) {
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    }     */

    // create the data store
    var store = Ext.create('Ext.data.ArrayStore', {
        fields: [
           {name: 'time', type: 'date', dateFormat: 'Y-n-j H:i:s'},
           {name: 'Metan',      type: 'float'},
           {name: 'NMHC',     type: 'float'},
           {name: 'Ozone',  type: 'float'},
           {name: 'SO2',      type: 'float'},
           {name: 'CO',     type: 'float'},
           {name: 'PM25',  type: 'float'}
           
        ],
        data: myData
    });

    // create the Grid
    var grid = Ext.create('Ext.grid.Panel', {
        store: store,
        stateful: true,
        stateId: 'stateGrid',
        columns: [
            {
                text     : 'Thời gian',
                width    : 100,
                sortable : true,
                renderer : Ext.util.Format.dateRenderer('d/m/Y H:i:s'),
                dataIndex: 'time'
            },
            {
                text     : 'Metan',
                width    : 75,
                sortable : true,
                dataIndex: 'Metan'
            },
            {
                text     : 'NMHC',
                width    : 75,
                sortable : true,
                dataIndex: 'NMHC'
            },
            {
                text     : 'Ozone',
                width    : 75,
                sortable : true,
                dataIndex: 'Ozone'
            },
            {
                text     : 'SO2',
                width    : 75,
                sortable : true,
                dataIndex: 'SO2'
            },
            {
                text     : 'CO',
                width    : 75,
                sortable : true,
                dataIndex: 'CO'
            },
            {
                text     : 'PM25',
                width    : 75,
                sortable : true,
                dataIndex: 'PM25'
            },
            
        ],
        height: 350,
        width: 600,
        title: 'Bảng nồng độ',
        renderTo: 'grid-example',
        viewConfig: {
            stripeRows: true
        }
    });
});


        </script>
	</head>
	<body>
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/no-data-to-display.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">Test1</div>
<div id="grid-example">Test2</div>

	</body>
</html>
