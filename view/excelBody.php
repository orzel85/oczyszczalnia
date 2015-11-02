<Column ss:Width="120"/>

<Row ss:AutoFitHeight="0" ss:StyleID="s65">
    <Cell><Data ss:Type="String">Nazwa obiektu</Data></Cell>
    <Cell><Data ss:Type="String">Suma</Data></Cell>
    <Cell><Data ss:Type="String">Taryfa 1</Data></Cell>
    <Cell><Data ss:Type="String">Taryfa 2</Data></Cell>
    <Cell><Data ss:Type="String">Taryfa 3</Data></Cell>
</Row>

<?php

    foreach ($results as $objectName => $invoice) {
        ?>
        <?php //debug($foundapp);  ?>
        <Row ss:AutoFitHeight="0">
            <Cell><Data ss:Type="String"><?php echo $objectName ?></Data></Cell>
            <Cell><Data ss:Type="String"><?php echo $invoice['sum'] ?></Data></Cell>
            <Cell><Data ss:Type="String"><?php echo $invoice['tarif1'] ?></Data></Cell>
            <Cell><Data ss:Type="String"><?php echo $invoice['tarif2'] ?></Data></Cell>
            <Cell><Data ss:Type="String"><?php echo $invoice['tarif3'] ?></Data></Cell>
        </Row>
    <?php };