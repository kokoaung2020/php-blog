<?php include "core/auth.php"; ?>
<?php require_once "core/isAdmin.php"; ?>
<?php include "template/header.php"; ?>


            
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>ad_list.php">Ads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Ad</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <?Php 

                if(isset($_POST['addAd'])){
                    adAdd();
                }
                ?>
            <form class="row" method="post" enctype="multipart/form-data">
                <div class="col-12 col-xl-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="feather-plus-circle text-primary"></i> Create New Ad
                                </h4>
                                <a href="<?php echo $url; ?>ad_list.php" class="btn btn-outline-primary">
                                    <i class="feather-list"></i>
                                </a>
                            </div>
                            <hr>

                           
                            
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="owner_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Ad Link</label>
                                    <input type="text" name="ad_link" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Ad File</label>
                                    <input type="file" name="file[]" class="form-control-file" Multiple required>
                                </div>
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input type="date" name="startAd" class="form-control" require>
                                </div>
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input type="date" name="endAd" class="form-control" require>
                                </div>
                                <button class="btn btn-primary" name="addAd">Add Ad</button>
                            
                        </div>
                    </div>
                </div>
                
            </form>
            
        
<?php include "template/footer.php"; ?>
