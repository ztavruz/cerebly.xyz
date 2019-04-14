<?php
?>
<div class="price-counter">




    <table class="admin-table price-count-table">
        <tr>
            <th>Срок абонемента</th>
            <th>Кол-во сеансов в день</th>
            <th>Кол-во сеансов за все время продолжительности абонемента</th>
            <th>Стоимость сеанса</th>
            <th>Стоимость абонемента</th>
        </tr>

        <?php

        foreach($data as $row)
        {
            ?>

            <tr>
                <td><?php echo $row["period"] ?></td>
                <td><?php echo $row["times"] ?></td>
                <td><?php echo $row["listen_count"] ?></td>
                <td><?php echo $row["listen_one_cost"] ?></td>
                <td><?php echo $row["cost"] ?></td>
            </tr>

            <?php
        }

        ?>

    </table>


</div>
