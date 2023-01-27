<?php include "core/auth.php"; ?>
<?php require_once "core/isAdmin.php"; ?>
<?php include "template/header.php"; ?>


            
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ads</li>
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
                                    <i class="feather-list text-primary"></i> Ad List
                                </h4>
                                <div>
                                    <a href="<?php echo $url; ?>ad_add.php" class="btn btn-outline-primary">
                                        <i class="feather-plus-circle"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary full-screen-btn">
                                            <i class="feather-maximize-2"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>

                            <table class="table table-hover table-bordered mt-3 mb-0">
                                <thead>
                                    <th>Id</th>
                                    <th>Owner_name</th>
                                    <th>Link</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Control</th>
                                    <th>Created</th>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach(adList() as $ad){

                                    ?>

                                    <tr>
                                        <td><?php echo $ad['id']; ?></td>
                                        <td><?php echo $ad['owner_name']; ?></td>
                                        <td><?php echo $ad['link']; ?></td>
                                       <td class="text-nowrap"><?php echo showTime($ad['start']); ?></td>
                                        <td class="text-nowrap"><?php echo showTime($ad['end']); ?></td>
                                        <td class="text-nowrap">          <!--text-nowrap columnကျဥ်းပီးအောက်မရောက်အောင် -->
                                            
                                            <a href="ad_delete.php?id=<?php echo $ad['id']; ?>"
                                                onclick="return confirm('Are U Sure to Delete.')"
                                                class="btn btn-outline-danger btn-sm" title="delete">
                                                <i class="feather-trash-2 fa-fw"></i>
                                            </a>
                                            <a title="edit" href="ad_edit.php?id=<?php echo $ad['id']; ?>" class="btn btn-outline-warning btn-sm">
                                                <i class="feather-edit-2 fa-fw"></i>
                                            </a>
                                        </td>
                                        <td class="text-nowrap"><?php echo showTime($ad['created_at']); ?></td>
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