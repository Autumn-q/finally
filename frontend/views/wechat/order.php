<table class="table table-border table-hover">
    <tr>
        <th>商品名</th>
        <th>价格</th>
        <th>后货地址</th>
        <th>手机号</th>
        <th>配送方式</th>
        <th>订单生成时间</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td>手机</td>
            <td><?=$row->price?></td>
            <td><?=$row->province.$row->city.$row->area.$row->address?></td>
            <td><?=$row->tel?></td>
            <td><?=$row->pay_type_name?></td>
            <td><?=$row->create_time?></td>
        </tr>
    <?endforeach;?>
</table>