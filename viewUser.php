<?php 

    include_once 'connection.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql = "SELECT * FROM user_info WHERE id = '$id'";
        $query = $con->query($sql) or die($con->error);
        $row = $query->fetch_assoc();

        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $phone = $row['phone'];
    }

?>

<div class="modal fade" id="updateUserModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <form id="editUserForm" method="post">
        <div class="modal-body">
            <h3 class="text-center">แก้ไขข้อมูล</h3>
            <div class="row">

                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">

                <div class="col-md-12">
                   <div class="form-group">
                       <label>ชื่อ</label>
                       <input type="text" name="edit_first_name" id="edit_first_name" class="form-control" value="<?php echo $row['first_name']; ?>">
                   </div> 
                </div>
                <div class="col-md-12">
                   <div class="form-group">
                       <label>นามสกุล</label>
                       <input type="text" name="edit_last_name" id="edit_last_name" class="form-control" value="<?php echo $row['last_name']; ?>">
                   </div> 
                </div>
                <div class="col-md-12">
                   <div class="form-group">
                       <label>เพศ</label>
                       <select name="edit_gender" id="edit_gender" class="custom-select">
                           <option value="Male" <?php echo $row['gender'] == "Male"? 'selected':'' ?>>Male</option>
                           <option value="Female" <?php echo $row['gender'] == "Female"? 'selected':'' ?>>Female</option>
                       </select>
                   </div> 
                </div>
                <div class="col-md-12">
                   <div class="form-group">
                       <label>เบอร์โทรศัพท์</label>
                       <input type="number" name="edit_phone" id="edit_phone" class="form-control" value="<?php echo $row['phone']; ?>">
                   </div> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark">ยกเลิก</button>
            <button type="submit" class="btn btn-success">อัพเดทข้อมูล</button>
        </div>
        </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#editUserForm").submit(function(e){
            e.preventDefault();

            var first_name = $("#edit_first_name").val();
            var last_name = $("#edit_last_name").val();
            var phone = $("#edit_phone").val();

            if(first_name == '' || last_name == '' || phone == ''){
                Swal.fire({
                    title: 'ผิดพลาด!',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    icon: 'warning',
                })
            }else{
                Swal.fire({
                    title: 'คุณต้องการแก้ไขข้อมูลใช่หรือไม่',
                    text: "หากต้องการแก้ไขข้อมูลให้กด ใช่",
                    icon: 'questions',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: 'editUser.php',
                            type: 'POST',
                            cache: false,
                            data: $(this).serialize(),
                            success:function(data){
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: 'อัพเดทข้อมูลเรียบร้อย',
                                    timer: 2000,
                                    showCancelButton: false,
                                    icon: 'success',
                                }).then(()=>{
                                    window.location.reload();
                                })
                            }
                        })
                    }
                })
            }
        })
    })
</script>