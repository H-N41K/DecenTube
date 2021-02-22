/*!
 * Chart_script.js
 * Author       : Bestwebcreator.
 * Template Name: Landing Page
 * Version      : 1.0
*/
var config = {
type: 'doughnut',
data: {
	
	datasets: [{
		data: [20, 19, 15, 10, 12],
		backgroundColor: ['#ff7876','#36ffad','#3b8a99','#13afcc','#cc1667'],
		borderColor: [
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
		],
		borderWidth: 2,
		label: 'Dataset 1'
	}],
	labels: [
		'Interconnection Dev.',
		'Marketing & General',
		'Mobile Ad Platform',
		'Ad Platform Integration',
		'Operational Overhead'
	]
},
options: {
	responsive: true,
	legend: {
	  display: false,
	},
	title: {
	  display: false,
	  text: 'Chart.js Doughnut Chart'
	},
	pieceLabel: {
		render: 'percentage',
		fontColor: ['#ff7876','#36ffad','#3b8a99','#13afcc','#cc1667'],
		fontSize: 16,
		fontStyle: 'bold',
		position: 'outside',
		precision: 2
	},
	animation: {
	  animateScale: true,
	  animateRotate: true
	}
}
};

var config2 = {
type: 'doughnut',
data: {
	
	datasets: [{
		data: [10, 20, 25, 18, 15],
		backgroundColor: ['#13AFCC','#DA5D85','#B877DF','#3B8A99','#36FFAD'],
		borderColor: [
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
		],
		borderWidth: 2,
		label: 'Dataset 1'
	}],
	labels: [
		'ICO Sale',
		'Build Out',
		'Team & Advisers',
		'Private Investors',
		'Bounty'
	]
},
options: {
	responsive: true,
	legend: {
	  display: false,
	},
	title: {
	  display: false,
	  text: 'Chart.js Doughnut Chart'
	},
	pieceLabel: {
		render: 'percentage',
		fontColor: ['#13AFCC','#DA5D85','#B877DF','#3B8A99','#36FFAD'],
		fontSize: 16,
		fontStyle: 'bold',
		position: 'outside',
		precision: 2
	},
	animation: {
	  animateScale: true,
	  animateRotate: true
	}
	
}
};

window.onload = function() {
var ctx = document.getElementById('token_sale').getContext('2d');
window.myPie = new Chart(ctx, config);
var ctx2 = document.getElementById('token_dist').getContext('2d');
window.myPie = new Chart(ctx2, config2);
};

var config = {
type: 'doughnut',
data: {
	
	datasets: [{
		data: [20, 19, 15, 10, 12],
		backgroundColor: ['#ff7876','#36ffad','#3b8a99','#13afcc','#cc1667'],
		borderColor: [
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
		],
		borderWidth: 2,
		label: 'Dataset 1'
	}],
	labels: [
		'Interconnection Dev.',
		'Marketing & General',
		'Mobile Ad Platform',
		'Ad Platform Integration',
		'Operational Overhead'
	]
},
options: {
	responsive: true,
	legend: {
	  display: false,
	},
	title: {
	  display: false,
	  text: 'Chart.js Doughnut Chart'
	},
	pieceLabel: {
		render: 'percentage',
		fontColor: ['#ff7876','#36ffad','#3b8a99','#13afcc','#cc1667'],
		fontSize: 16,
		fontStyle: 'bold',
		position: 'outside',
		precision: 2
	},
	animation: {
	  animateScale: true,
	  animateRotate: true
	}
}
};

var config2 = {
type: 'doughnut',
data: {
	
	datasets: [{
		data: [10, 20, 25, 18, 15],
		backgroundColor: ['#13AFCC','#DA5D85','#B877DF','#3B8A99','#36FFAD'],
		borderColor: [
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
			'rgba(255,255,255,0.5)',
		],
		borderWidth: 2,
		label: 'Dataset 1'
	}],
	labels: [
		'ICO Sale',
		'Build Out',
		'Team & Advisers',
		'Private Investors',
		'Bounty'
	]
},
options: {
	responsive: true,
	legend: {
	  display: false,
	},
	title: {
	  display: false,
	  text: 'Chart.js Doughnut Chart'
	},
	pieceLabel: {
		render: 'percentage',
		fontColor: ['#13AFCC','#DA5D85','#B877DF','#3B8A99','#36FFAD'],
		fontSize: 16,
		fontStyle: 'bold',
		position: 'outside',
		precision: 2
	},
	animation: {
	  animateScale: true,
	  animateRotate: true
	}
	
}
};

window.onload = function() {
var ctx = document.getElementById('token_sale').getContext('2d');
window.myPie = new Chart(ctx, config);
var ctx2 = document.getElementById('token_dist').getContext('2d');
window.myPie = new Chart(ctx2, config2);
};

