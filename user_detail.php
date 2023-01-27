<?php include "core/auth.php"; ?>
<?php include "core/isAdmin.php"; ?>
<?php include "template/header.php"; ?>

<?php 

$id = $_GET['id'];
$current = post($id);
    
?>
            
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>user_list.php">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="feather-list text-primary"></i> Post List
                                </h4>
                                <div>
                                    
                                    <a href="#" class="btn btn-outline-secondary full-screen-btn">
                                            <i class="feather-maximize-2"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>

                            <table class="table table-hover table-bordered mt-3 mb-0">
                                <thead>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Device</th>
                                    <th>Time</th>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach(viewerCountByUser($id) as $u){

                                    ?>

                                    <tr>
                                        
                                        <td><?php echo short(post($u['post_id'])['title'],"50"); ?></td>
                                        <td class="text-nowrap"><?php echo category(post($u['post_id'])['category_id'])['title']; ?></td>
                                        
                                        
                                        <td><?php echo $u['device']; ?></td>
                                        <td class="text-nowrap"><?php echo showTime($u['created_at']); ?></td>
                                    </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        
<?php include "template/footer.php"; ?>
<script>
    $(".table").dataTable({
        "order": [[0,"desc"]]
    });
</script>