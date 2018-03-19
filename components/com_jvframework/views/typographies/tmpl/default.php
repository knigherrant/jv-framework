<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );

$bbcode = JV::helper('bbcode');
$bbcode->setReplacement($this->items);
?>

<div id="typography">
	<h1 class="page_heading">Typography List</h1>
	<div class="items">
<?php
		foreach ($this->items as $i => $item) :
				
			$examples = explode("\n", $item->example);?>
			<div class="item">
				<h3 class="title"><span><?php echo $this->escape($item->title); ?></span></h3>
					
				<?php foreach ($examples as $index => $example):
				$output  = $bbcode->replace($example);?>
				<a href="javascript:void(0)" class="viewcode" data-toggle="collapse" data-target="#typo<?php echo $i.$index; ?>"><span></span>Code</a>
				<div class="typo_content">
                <div id="typo<?php echo $i.$index; ?>" class="collapse">			
					<div class="example">
						<span>Example Usage: </span>
						<span class="code"><code><?php echo $this->escape($example); ?></code></span>
					</div>
					<div class="rcode">
						<span>Example Code Output: </span>
						<pre class="prettyprint linenums"><?php echo $this->escape($output); ?></pre>
					</div>	
				</div>
				<div class="output">	
					<span>Example Output: </span>													
					<div class="result-exam">
						<?php echo $output; ?>
					</div>
				</div>
                </div>
	<?php endforeach;?>
		</div>	
<?php endforeach;?>
	</div>
</div>