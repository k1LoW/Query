<?php if (!empty($queries)): ?>
<?php foreach($queries as $query): ?>
<div class="query">
    <pre class="prettyprint lang-sql"><?php echo str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', h($query['Query']['query'])); ?></pre>

    <div class="action">
        <?php echo $this->Form->create('Query', array('url' => array('controller' => 'query', 'action' => 'index'))); ?>
        <?php echo $this->Form->input('query', array('type' => 'hidden', 'value' => $query['Query']['query'], 'label' => false)); ?>
        <?php echo $this->Form->submit(__d('Query', 'Execute'), array('div' => false)); ?>
        <?php echo $this->Form->end(); ?>
        <?php echo $this->Form->postLink(__d('Query', 'Delete'), array('controller' => 'query', 'action' => 'delete', $query['Query']['id'], $this->action), array('class' => 'button')); ?>
        <?php echo $query['Query']['modified']; ?>
    </div>

</div>
<?php endforeach; ?>
<?php endif; ?>