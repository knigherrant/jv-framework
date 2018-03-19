<?php 
if($this['option']->get('extension.analytic.google.enable')): ?>
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '<?php echo $this['option']->get('extension.analytic.google.id'); ?>']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
<?php 
endif;

if($this['option']->get('extension.analytic.yahoo.enable')): 
	if($this['option']->get('extension.analytic.yahoo.secure')):?>
		<script type="text/javascript" src="http://s.yimg.com/mi/ywa.js"></script>
		<script type="text/javascript">
		/*globals YWA*/
		var YWATracker = YWA.getTracker("<?php echo $this['option']->get('extension.analytic.yahoo.id'); ?>");
		/*YWATracker.setDocumentName("");*/
		/*YWATracker.setDocumentGroup("");*/
		YWATracker.submit();
		</script>
		<noscript>
			<div><img src="https://a.analytics.yahoo.com/p.pl?a=<?php echo $this['option']->get('extension.analytic.yahoo.id'); ?>&js=no" width="1" height="1" alt="" /></div>
		</noscript> 
<?php else:?>
		<script type="text/javascript" src="http://d.yimg.com/mi/ywa.js"></script>
		<script type="text/javascript">
		/*globals YWA*/
		var YWATracker = YWA.getTracker("<?php echo $this['option']->get('extension.analytic.yahoo.id'); ?>");
		/*YWATracker.setDocumentName("");*/
		/*YWATracker.setDocumentGroup("");*/
		YWATracker.submit();
		</script>
		<noscript>
			<div><img src="http://a.analytics.yahoo.com/p.pl?a=<?php echo $this['option']->get('extension.analytic.yahoo.id'); ?>&js=no" width="1" height="1" alt="" /></div>
		</noscript> 
<?php endif;
endif;


