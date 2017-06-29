<div class="row">
	<div class="col-md-12">
        <div class="head-title">
            <div class="name">Sessions</div>
            <div class="desc">
            Total number of Sessions within the date range.<br/>
            A session is the period time a user is actively engaged with your website, app, etc. All usage data (Screen Views, Events, Ecommerce, etc.) is associated with a session.
            </div>
        </div>
		<div class="ajax_sessionschart"></div>
        <div class="foot-title">
            <span><?=$count_sessions?></span> views
        </div>
	</div>
    <div class="col-md-6">
        <div class="head-title">
            <div class="name">Users</div>
            <div class="desc">Users that have had at least one session within the selected date range. Includes both new and returning users.</div>
        </div>
        <div class="ajax_userschart"></div>
        <div class="foot-title">
            <span><?=$count_users?></span> users
        </div>
    </div>
    <div class="col-md-6">
        <div class="head-title">
            <div class="name">Pageviews</div>
            <div class="desc">Pageviews is the total number of pages viewed. Repeated views of a single page are counted.</div>
        </div>
        <div class="ajax_pageviewschart"></div>
        <div class="foot-title">
            <span><?=$count_pageviews?></span> pages
        </div>
    </div>
    <div class="col-md-6">
        <div class="head-title">
            <div class="name">Pages / Session</div>
            <div class="desc">Pages/Session (Average Page Depth) is the average number of pages viewed during a session. Repeated views of a single page are counted.</div>
        </div>
        <div class="ajax_pages_sessionchart"></div>
        <div class="foot-title">
            <span><?=$count_pages_session?></span> pages
        </div>
    </div>

    <div class="col-md-6">
        <div class="head-title">
            <div class="name">Avg. Session Duration</div>
            <div class="desc">The average length of a Session.<br/><br/><br/></div>
        </div>
        <div class="ajax_sessionDuration_sessions"></div>
        <div class="foot-title">
            <span><?=$count_avgSessionDuration?></span> seconds
        </div>
    </div>

    <div class="col-md-6">
        <div class="head-title">
            <div class="name">Bounce Rate</div>
            <div class="desc">Bounce Rate is the percentage of single-page visits (i.e. visits in which the person left your site from the entrance page without interacting with the page).</div>
        </div>
        <div class="ajax_bounceRate"></div>
        <div class="foot-title">
            <span><?=$count_bounceRate?>%</span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="head-title">
            <div class="name">% New Sessions</div>
            <div class="desc">An estimate of the percentage of first time visits.<br/><br/><br/></div>
        </div>
        <div class="ajax_percentNewSessions"></div>
        <div class="foot-title">
            <span><?=$count_percentNewSessions?>%</span>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
    	Main.Highcharts({
    		element : '.ajax_sessionschart',
    		titlex  : 'datetime',
    		colorx  : '#00a65a',
    		colory  : '#00a65a',
    		name    : 'Views',
    		data    : [<?=!empty($data_sessions)?$data_sessions:""?>]
    	});

        Main.Highcharts({
            element : '.ajax_userschart',
            titlex  : 'datetime',
            colorx  : '#0089cf',
            colory  : '#0089cf',
            name    : 'Users',
            data    : [<?=!empty($data_users)?$data_users:""?>]
        });

        Main.Highcharts({
            element : '.ajax_pageviewschart',
            titlex  : 'datetime',
            colorx  : '#333333',
            colory  : '#333333',
            name    : 'Pageviews',
            data    : [<?=!empty($data_pageviews)?$data_pageviews:""?>]
        });

        Main.Highcharts({
            element : '.ajax_pages_sessionchart',
            titlex  : 'datetime',
            colorx  : '#8fd227',
            colory  : '#8fd227',
            name    : 'Pageviews',
            data    : [<?=!empty($data_pages_session)?$data_pages_session:""?>]
        });

        Main.Highcharts({
            element : '.ajax_sessionDuration_sessions',
            titlex  : 'datetime',
            colorx  : '#d73925',
            colory  : '#d73925',
            name    : 'seconds',
            data    : [<?=!empty($data_avgSessionDuration)?$data_avgSessionDuration:""?>]
        });

        Main.Highcharts({
            element : '.ajax_sessionDuration_sessions',
            titlex  : 'datetime',
            colorx  : '#d73925',
            colory  : '#d73925',
            name    : 'seconds',
            data    : [<?=!empty($data_avgSessionDuration)?$data_avgSessionDuration:""?>]
        });

        Main.Highcharts({
            element : '.ajax_bounceRate',
            titlex  : 'datetime',
            colorx  : '#aeaeae',
            colory  : '#aeaeae',
            name    : 'Bounce Rate',
            suffix  : ' %',
            data    : [<?=!empty($data_bounceRate)?$data_bounceRate:""?>]
        });

        Main.Highcharts({
            element : '.ajax_percentNewSessions',
            titlex  : 'datetime',
            colorx  : '#e03686',
            colory  : '#e03686',
            name    : 'Percent New Sessions',
            suffix  : ' %',
            data    : [<?=!empty($data_percentNewSessions)?$data_percentNewSessions:""?>]
        });
	});
</script>