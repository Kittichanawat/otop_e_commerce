<table id="myTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>ชื่อสินค้า</th>
                <th>รายละเอียด</th>
                <th>รูป</th>
                <th>อีเมล</th>
                <th>ระดับการเข้าใช้งาน</th>
                <th>สถานะบัญชี</th>
                <th>สถานะบัญชี</th>
                <th>สถานะบัญชี</th>
                <th>สถานะบัญชี</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require('../connectPDO/connnectpdo.php');
                $stmt = $conn->query("SELECT * FROM product");
                $stmt->execute();
                $members = $stmt->fetchAll();

                $isAdmin = $_SESSION['status'] === 'admin';

                foreach ($members as $member) {
            ?>
            <tr>
                <td><?php echo $member['prd_id'] ?></td>
                <td><?php echo $member['prd_name'] ?></td>
                <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $member['prd_desc'] ?></td>
                <td><img src="<?php echo $member['prd_img'] ?>" alt="" style="max-width: 100px; max-height: 100px;"></td>
                <td><?php echo $member['prd_price'] ?></td>
                <td><?php echo $member['pty_id'] ?></td>
                <td><?php echo $member['prd_show'] == 1 ? 'Enable' : 'Disable'; ?></td>
                <td><?php echo $member['prd_reccom'] == 1 ? 'Enable' : 'Disable'; ?></td>
                <td>
                    <?php if ($isAdmin) : ?>
                        <a href="product_edit.php?prd_id=<?php echo $member['prd_id'] ?>" class="btn btn-warning">แก้ไข</a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($isAdmin) : ?>
                        <a onclick="confirmDelete(<?php echo $member['prd_id']; ?>, '<?php echo $member['prd_name']; ?>')" class="btn btn-danger">ลบ</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
