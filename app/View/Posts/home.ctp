<?php
echo $this->Html->link('English', array('language'=>'eng')); 
echo "&nbsp;";
echo $this->Html->link('Bahasa', array('language'=>'msa')); 
echo "&nbsp;|&nbsp;";
echo $this->Html->link(__('New Post'), array('action' => 'add')); 
?>
<div class="posts home">
	<h2><?php echo __('Posts'); ?></h2>	
	<?php foreach ($posts as $post): ?>	
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Post']['title'], array('action'=>'details',$post['Post']['id'])); ?>
			&nbsp;
		</dd>		
	</dl>
<?php endforeach; ?>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>