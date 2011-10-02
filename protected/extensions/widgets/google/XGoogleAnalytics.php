<?php
/**
 * XGoogleAnalytics class file
 *
 * Widget to implement a Google Analytics
 *
 * Example of usage:
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleAnalytics', array(
 *     'visible'=>true,
 *     'tracker'=>'UA-4477704-X',
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XGoogleAnalytics extends CWidget
{
	public $tracker;
	public $visible = true;

	public function run()
	{
		if(!$this->visible || !$this->tracker)
			return;

		echo '
			<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("'.$this->tracker.'");
			pageTracker._trackPageview();
			} catch(err) {}</script>
		';
	}
}