<?php 

    include_once 'connection.php' 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- dataTable  -->
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    
    

    <title>CRUD BOOTSTRAP 4 SWEETALERT 2</title>
</head>
<body>
    <div class="container-fluid text-center mt-5">
        <h3>ระบบ เพิ่ม ลบ แก้ไข อัพเดท ข้อมูล </h3>
        <h5>CRUD BOOTSTRAP 4 SWEETALERT 2</h5>
    </div>
    <div class="container mt-5">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newUserModal">+ เพิ่มข้อมูล</button>
        <table class="table table-striped table-bordered mydatatable" id="table_id">
            <thead class="text-center">
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เพศ</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                    $sql = "SELECT * FROM user_info";
                    $query = $con->query($sql) or die($con->error);
                    while($row = $query->fetch_assoc()){
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $row['id']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td class="text-center"><?php echo $row['gender']; ?></td>
                                <td class="text-center"><?php echo $row['phone']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm updateUser" id="<?php echo $row['id']; ?>">แก้ไขข้อมูล</button>
                                    <button type="button" class="btn btn-danger btn-sm deleteUser" id="<?php echo $row['id']; ?>">ลบข้อมูล</button>
                                </td>
                            </tr>
                        <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>    
    <div class="modal fade" id="newUserModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="newUserForm" method="post">
                <div class="modal-body">
                    <h3 class="text-center">เพิ่มข้อมูล</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input type="text" id="first_name" class="form-control" name="first_name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>นามสกุล</label>
                                <input type="text" id="last_name" class="form-control" name="last_name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>เพศ</label>
                                <select name="gender" id="gender" class="custom-select">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>เบอร์โทรศัพท์</label>
                                <input type="number" id="phone" class="form-control" name="phone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <div id="display_user"></div>


    <!-- jQuery  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    
    <!-- dataTable  -->
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- Sweet Alert  -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            // dataTable
            $('#table_id').DataTable();
            // viewData and UpdateUser ----------------------------------------------- 3 ------------------------------------------
            $(document).on('click','.updateUser', function(){
                var id = $(this).attr('id');
                $("#display_user").html('');
                $.ajax({
                    url: 'viewUser.php',
                    type: 'POST',
                    cache: false,
                    data: {id:id},
                    success:function(data){
                        $("#display_user").html(data);
                        $("#updateUserModal").modal('show');
                    }    

                })
            })
            
            // CheckDeleteConfirm ----------------------------------------------- 2 ------------------------------------------
            $(document).on('click','.deleteUser',function(){
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'คุณต้องการลบข้อมูลนี้หรือไม่',
                    text: "ระบบจะลบข้อมูลนี้และไม่สามารถนำกลับมาใหม่ได้",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยันการลบข้อมูล'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'deleteUser.php',
                            type: 'POST',
                            data: {id:id},
                            success:function(data){
                                Swal.fire({
                                    title: 'ลบข้อมูลสำเร็จ',
                                    icon: 'success',
                                    text: 'ลบข้อมูลเสร็จเรียบร้อย',
                                    showConfirmButton: false,
                                    timer: 2000,
                                }).then(()=>{
                                    window.location.reload();
                                })
                            }
                        })
                    }
                    })
            }) 

            // CheckUser ----------------------------------------------- 1 ------------------------------------------
            $("#newUserForm").submit(function(e){
                e.preventDefault();

                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                var phone = $("#phone").val();
                
            if(first_name == '' || last_name == '' || phone == ''){
                Swal.fire(
                    'ผิดพลาด!',
                    'กรุณากรอกข้อมูลให้ครบถ้วน',
                    'error',
                    )
            }else{
                Swal.fire({
                title: 'คุณต้องการเพิ่มข้อมูลใช่หรือไม่?',
                text: "หากต้องการเพิ่มข้อมูลให้กด ใช่ ",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่!'
                }).then((result) => {
                if (result.isConfirmed) {
                                $.ajax({
                                url: 'newUser.php',
                                type: 'POST',
                                data: $(this).serialize(),
                                cache: false,
                                success:function(data){
                                    Swal.fire({
                                        title: 'เพิ่มข้อมูลสำเร็จ',
                                        text: 'เพิ่มข้อมูลเรียบร้อย',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false,
                                    }).then(()=>{
                                        window.location.reload();
                                    });
                                }
                            })
                        }
                    })          
                }    
            })
        })
    </script>
</body>
</html>