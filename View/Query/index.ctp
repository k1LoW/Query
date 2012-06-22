<div class="tables">
    <?php foreach($tables as $table): ?>
    <span><?php echo $table; ?></span>
    <?php endforeach; ?>
</div>
<?php echo $this->Form->create('Query', array('url' => array('controller' => 'query', 'action' => 'index'))); ?>

<?php echo $this->Form->input('query', array('type' => 'textarea', 'id' => 'query', 'label' => false)); ?>

<?php echo $this->Form->submit(__d('Query', 'Execute'), array('div' => false)); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Form->create('Query', array('id' => 'form_save', 'url' => array('controller' => 'query', 'action' => 'add'))); ?>
<?php echo $this->Form->input('query', array('type' => 'hidden', 'id' => 'hidden_query')); ?>
<?php $this->Form->unlockField('Query.query'); ?>
<?php echo $this->Form->submit(__d('Query', 'Save Query'), array('div' => false)); ?>
<?php echo $this->Form->end(); ?>    

<?php if (!empty($queries)): ?>
<h2>Recent Queries</h2>
<?php echo $this->element('queries'); ?>

<?php if (count($queries) === 5): ?>
<?php echo $this->Html->link(__d('Query', 'More'), array('controller' => 'query', 'action' => 'queries')); ?>
<?php endif; ?>

<?php endif; ?>

<?php if (!empty($result)): ?>
<h2>Result</h2>
<?php echo $this->element('result'); ?>
<?php endif; ?>