
<script type="text/javascript">

(function(w,d,s,g,js,fjs){
	g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
	js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
	js.src='https://apis.google.com/js/platform.js';
	fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));


gapi.analytics.ready(function() {

	/**
	* Authorize the user immediately if the user has already granted access.
	* If no access has been created, render an authorize button inside the
	* element with the ID "embed-api-auth-container".
	*/
	gapi.analytics.auth.authorize({
		container: 'embed-api-auth-container',
		clientid: '749953420100-mu1cdra49frb0msaggg0vi0hr9eej4t8.apps.googleusercontent.com'
	});


	/**
	* Create a ViewSelector for the first view to be rendered inside of an
	* element with the id "view-selector-1-container".
	*/
	var viewSelector1 = new gapi.analytics.ViewSelector({
		container: 'view-selector-1-container'
	});

	/**
	* Create a ViewSelector for the second view to be rendered inside of an
	* element with the id "view-selector-2-container".
	*/
	var viewSelector2 = new gapi.analytics.ViewSelector({
		container: 'view-selector-2-container'
	});

	// Render both view selectors to the page.
	viewSelector1.execute();
	viewSelector2.execute();


	/**
	* Create the first DataChart for top countries over the past 30 days.
	* It will be rendered inside an element with the id "chart-1-container".
	*/
	var dataChart1 = new gapi.analytics.googleCharts.DataChart({
		query: {
			metrics: 'ga:sessions',
			dimensions: 'ga:country',
			'start-date': '30daysAgo',
			'end-date': 'today',
			'max-results': 6,
			sort: '-ga:sessions'
		},
		chart: {
			container: 'chart-1-container',
			type: 'LINE',
			options: {
				width: '100%',
				pieHole: 4/9
			}
		}
	});


	/**
	* Create the second DataChart for top countries over the past 30 days.
	* It will be rendered inside an element with the id "chart-2-container".
	*/
	var dataChart2 = new gapi.analytics.googleCharts.DataChart({
		query: {
			metrics: 'ga:sessions',
			dimensions: 'ga:country',
			'start-date': '30daysAgo',
			'end-date': 'today',
			'max-results': 6,
			sort: '-ga:sessions'
		},
		chart: {
			container: 'chart-2-container',
			type: 'PIE',
			options: {
				width: '100%',
				pieHole: 4/9
			}
		}
	});

	/**
	* Update the first dataChart when the first view selecter is changed.
	*/
	viewSelector1.on('change', function(ids) {
		dataChart1.set({query: {ids: ids}}).execute();
	});

	/**
	* Update the second dataChart when the second view selecter is changed.
	*/
	viewSelector2.on('change', function(ids) {
		dataChart2.set({query: {ids: ids}}).execute();
	});

});
</script>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i> Reports
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<div id="embed-api-auth-container"></div>
		<div id="chart-1-container"></div>
		<div id="chart-2-container"></div>
		<div id="view-selector-1-container"></div>
		<div id="view-selector-2-container"></div>
	</div>
</div>