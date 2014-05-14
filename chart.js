$(function () {
                $('#container').highcharts({
            chart: {
                type: 'spline',
                zoomType: 'x',  
                style: {
                fontFamily: 'Roboto'}
            },
            title: {
                text: 'Nồng độ ozone theo thời gian'
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
                    text: 'Nồng độ (ppb)'
                },
                plotLines: [{
                   value: <?php if ($x<>0) echo round($average/$x,3); else echo 0 ?>,
	                color: 'red',
	                width: 1,
	                label: {
	                    text: 'Trung bình số học: <?php if ($x<>0) echo round($average/$x,3); else echo 0 ?>',
                        align: 'center',
	                    style: {
	                        color: 'gray'
                      }
                   }  
	           },
                {
                   value: 2.44,
	                color: 'red',
	                width: 1,
	                label: {
	                    text: 'Trung bình số học: <?php if ($x<>0) echo round($average/$x,3); else echo 0 ?>',
                        align: 'center',
	                    style: {
	                        color: 'gray'
                      }
                   }  
	           }]
            },
            tooltip: {
                formatter: function() {
                        return 'Thời gian: ' + Highcharts.dateFormat('%H:%M', this.x)+'<br/>'+
                            'Nồng độ: '+ this.y +' ppb';
                }
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
                data: [<?php if ($x==0) echo ""; else echo join($data, ','); ?>]
            }],
            lang: {
                noData: "Không có số liệu vào ngày này"
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