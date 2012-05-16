	
<div data-role="footer" data-id="mainfooter" data-position="fixed">
	<div data-role="navbar" data-iconpos="top">
		<ul>
			<li><a href="<?php echo config('basepath') ?>/m/?hot=off" data-icon="forward">Recent</a></li>
			<li><a href="<?php echo config('basepath') ?>/m/?hot=today" data-icon="star">Popular</a></li>
			<li><a href="<?php echo config('basepath') ?>/m/search" data-icon="search">Search</a></li>
			<li><a href="#settings" data-icon="gear">Settings</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->
</div><!-- /page one -->


<!-- Start of #settings page -->
<div data-role="page" id="settings" data-theme="c">

	<div data-role="header">
		<h1>Settings</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="c">	
	<form action="<?php echo config('basepath') ?>/m/" method="get">
	
		<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" >
			<legend>Select Language:</legend>
			<input type="radio" name="lang" id="lang_all" value="all" checked="checked" />
			<label for="lang_all">All</label>
			<input type="radio" name="lang" id="lang_si" value="si"  />
			<label for="lang_si">Sinhala</label>
			<input type="radio" name="lang" id="lang_ta" value="ta"  />
			<label for="lang_ta">Tamil</label>
			<input type="radio" name="lang" id="lang_en" value="en"  />
			<label for="lang_en">English</label>
		</fieldset>
		
		<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" >
			<legend>Hot Posts:</legend>
			<input type="radio" name="hot" id="hot_off" value="off" checked="checked" />
			<label for="hot_off">Off</label>
			<input type="radio" name="hot" id="hot_today" value="today"  />
			<label for="hot_today">Today</label>
			<input type="radio" name="hot" id="hot_week" value="week"  />
			<label for="hot_week">This Week</label>
			<input type="radio" name="hot" id="hot_month" value="month"  />
			<label for="hot_month">This Month</label>
		</fieldset>
		
		<p><br><br></p>

		<a data-rel="back" href="#mainpage" data-mini="true" data-inline="true" 
		data-direction="reverse" data-icon="arrow-l" data-role="button">Go back</a>		
		<button type="submit" data-mini="true" data-inline="true" data-theme="b" data-icon="check">Submit</button>
		
		<p><br><br></p>
		
	</form>
		
	</div><!-- /content -->
	
<div data-role="footer" data-id="mainfooter" data-position="fixed">
	<div data-role="navbar" data-iconpos="top">
		<ul>
			<li><a href="#mainpage" data-icon="home">Home</a></li>
			<li><a href="#aboutus" data-icon="plus">About Us</a></li>
			<li><a href="<?php echo config('basepath') ?>/m/blogroll" data-icon="grid">Blogroll</a></li>
			<li><a href="#settings" data-icon="gear">Settings</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->
	
</div><!-- /page two -->

<!-- Start of #aboutus page -->
<div data-role="page" id="aboutus" data-theme="c">

	<div data-role="header">
		<h1>About Us</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="c">	
	
	<p>Kottu is a Sri Lankan blog aggregator. It basically collects a slice of 
	the Sri Lankan blogosphere in one place. The only criteria for joining Kottu is:</p>
	<ol>
	<li>Having a working feed (which most blogs do)</li>
	<li>Being ‘Sri Lankan’, as in based in or covering Sri Lankan experiences</li>
	<li>Being original content (not copy/pasted)</li>
	<li>Observing very basic standards of libel and obscenity</li>
	<li>Being updated in the last two month</li>
	</ol>
	<p>To join just send a mail to <a href="mailto:indi@indi.ca">indi@indi.ca</a>. 
	I’ll get around to a contact form someday.</p>
	
	<a href="#settings" data-mini="true" data-inline="true" 
		data-direction="reverse" data-icon="arrow-l" data-role="button">Go back</a>
	</div><!-- /content -->

<div data-role="footer" data-id="mainfooter" data-position="fixed">
	<div data-role="navbar" data-iconpos="top">
		<ul>
			<li><a href="#mainpage" data-icon="home">Home</a></li>
			<li><a href="#aboutus" data-icon="plus">About Us</a></li>
			<li><a href="<?php echo config('basepath') ?>/m/blogroll" data-icon="grid">Blogroll</a></li>
			<li><a href="#settings" data-icon="gear">Settings</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->
</div><!-- /page three -->


</body>
</html>

