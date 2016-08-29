<?php
global $poll;
$results = array();
$colors = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F' );
$fancy_colors = array('#1abc9c', '#3498db', '#f39c12', '#8e44ad', '#34495e', '#bdc3c7', '#e74c3c', '#7f8c8d', '#19b5fe');
foreach ( get_poll_choices() as $index => $choice ):
    
    if (isset($fancy_colors[$index])):
	$color = $fancy_colors[$index];
    else:
	$color = '#';
	for ( $i = 1; $i <= 6; $i++ ):
	    $color .= $colors[array_rand($colors)];
	endfor;
    endif;


    $results[$index] = array(
        'value' => $choice->votes,
        'percentage' => $choice->votes_percentage,
        'color' => $color,
        'label' => empty($choice->text) ? empty($choice->label) ? '' : $choice->label : $choice->text
    );
endforeach;
?>

<canvas id="results-chart" width="250" height="250"></canvas>

<style type="text/css">
    .doughnut-legend {
	list-style: none;
	margin: 30px 0 0;
    }
    .doughnut-legend li {
	display: block;
	padding-left: 30px;
	position: relative;
	margin-bottom: 4px;
	border-radius: 5px;
	padding: 2px 8px 2px 28px;
	font-size: 14px;
	cursor: default;
	-webkit-transition: background-color 200ms ease-in-out;
	-moz-transition: background-color 200ms ease-in-out;
	-o-transition: background-color 200ms ease-in-out;
	transition: background-color 200ms ease-in-out;
    }
    .doughnut-legend li:hover {
	cursor: pointer;
	background-color: #fafafa;
    }
    .doughnut-legend li span {
	display: block;
	position: absolute;
	left: 0;
	top: 0;
	width: 20px;
	height: 100%;
	border-radius: 5px;
    }
</style>
<script type="text/javascript">
    jQuery(function($) {
	var helpers = Chart.helpers;
	var ctx = document.getElementById("results-chart").getContext("2d");
	var resultsChart = new Chart(ctx).Doughnut(<?php echo json_encode($results); ?>, {});
	var legendHolder = document.createElement('div');
	legendHolder.innerHTML = resultsChart.generateLegend();
	// Include a html legend template after the module doughnut itself
	helpers.each(legendHolder.firstChild.childNodes, function(legendNode, index) {
	    helpers.addEvent(legendNode, 'mouseover', function() {
		var activeSegment = resultsChart.segments[index];
		activeSegment.save();
		activeSegment.fillColor = activeSegment.highlightColor;
		resultsChart.showTooltip([activeSegment]);
		activeSegment.restore();
	    });
	});
	helpers.addEvent(legendHolder.firstChild, 'mouseout', function() {
	    resultsChart.draw();
	});
	document.getElementById("results-chart").parentNode.appendChild(legendHolder.firstChild);
    });
</script>