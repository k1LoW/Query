<?php if(!empty($result)): ?>
<table>
    <tr>
        <?php foreach($result[0] as $tablename => $fields): ?>
        <?php foreach($fields as $field => $value): ?>
        <th>
            <?php echo $tablename; ?>.<?php echo $field; ?>
        </th>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </tr>
    <?php foreach($result as $record): ?>
    <tr>    
        <?php foreach($record as $tablename => $fields): ?>
        <?php foreach($fields as $field => $value): ?>
        <td>
            <?php echo $value; ?>
        </td>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>