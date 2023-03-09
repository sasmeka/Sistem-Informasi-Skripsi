$(function () {
	"use strict";
	// Set your date
	$('#count-down').countDown({
		targetDate: {
			'day': 21,
			'month': 3,
			'year': 2023,
			'hour': 0,
			'min': 0,
			'sec': 0
		},
		omitWeeks: true
	});

});