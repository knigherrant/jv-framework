<div class="timer">
<?php
if($this['option']->get('extension.date.enable')){
		$string = "";
		if($this['option']->get('extension.date.pretext'))
			$string = $this['option']->get('extension.date.pretext').' ';
	if(!$this['option']->get('extension.date.type')){ 
		?>
		<?php echo $string; ?><time datetime="<?php echo date('Y-m-d'); ?>"><?php echo date($this['option']->get('extension.date.format','l, d F Y')); ?></time>		
<?php
	}else{?>
		<script type='text/javascript'>
			document.write('<?php echo $string;?><time datetime="'+ jvDate.getClientDate('Y-m-d') +'">'+ jvDate.getClientDate('<?php echo $this['option']->get('extension.date.format','l, d F Y');?>') +'</time>');
		</script>
	<?php }
}?>
</div>