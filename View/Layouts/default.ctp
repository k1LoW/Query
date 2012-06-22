<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo __d('Query', 'Query:'). ' ' . $source; ?>
        </title>
        <?php
          echo $this->Html->meta('icon');
          echo $this->Html->css('/query/css/codemirror');
          echo $this->Html->css('/query/css/prettify');
          echo $this->Html->css('/query/css/base');
          echo $this->Html->script('/query/js/codemirror');
          // echo $this->Html->script('/query/js/prettify');
          echo $this->Html->script('/query/js/mysql');
        ?>
        <script src="//cdnjs.cloudflare.com/ajax/libs/prettify/188.0.0/prettify.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $this->Html->link(__d('Query', 'Query:'), array('action' => 'index')); ?><small><?php echo $source; ?></small></h1>
            </div>
            <div id="content">
                <?php echo $this->Session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script type="text/javascript">
                $(function() {
                $('#query').on('ready keyup', function() {
                $('#hidden_query').val($(this).val());
                });

                // CodeMirror
                if (document.getElementById("query")) {
                var editor = CodeMirror.fromTextArea(document.getElementById("query"), {
                mode: "text/x-mysql",
                tabMode: "indent",
                matchBrackets: true
                });

                $('.tables span').on('click', function() {
                if (editor.getValue()) {
                var query = editor.getValue() + "\n" + 'select * from ' + $(this).text() + ';';
                } else {
                var query = 'select * from ' + $(this).text() + ';';
                }
                editor.setValue(query);
                });
                }

                // Google Code Prettify
                prettyPrint();
                });
            </script>
            <div id="footer">
                <?php echo $this->Html->link(
                  $this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework'), 'border' => '0')),
                  'http://www.cakephp.org/',
                  array('target' => '_blank', 'escape' => false)
                  );
                ?>
            </div>
        </div>
    </body>
</html>