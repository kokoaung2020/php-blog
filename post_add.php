<?php include "core/auth.php" ?>
<?php include "template/header.php"; ?>


            
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>post_list.php">Post</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Post</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <?Php 

                if(isset($_POST['addBtn'])){
                    postAdd();
                }
                ?>
            <form class="row" method="post">
                <div class="col-12 col-xl-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="feather-plus-circle text-primary"></i> Create New Post
                                </h4>
                                <a href="<?php echo $url; ?>post_list.php" class="btn btn-outline-primary">
                                    <i class="feather-list"></i>
                                </a>
                            </div>
                            <hr>

                           
                            
                                <div class="form-group">
                                    <label for="">Post Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="">Post Description</label>
                                    <textarea name="description" id="descForSummernote" class="form-control" cols="30" rows="10" required></textarea>
                                </div>
                                
                            
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="feather-layers text-primary"></i> Add Category
                                </h4>
                                <a href="<?php echo $url; ?>category_list.php" class="btn btn-outline-primary">
                                    <i class="feather-list"></i>
                                </a>
                            </div>
                            <hr>
                            <div class="form-group">
                                <?php foreach(categories() as $c){ ?>
                                    <div class="custom-control custom-radio mb-1">
                                        <input type="radio" id="customRadio<?php echo $c['id']; ?>" value="<?php echo $c['id']; ?>" name="category_id" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio<?php echo $c['id']; ?>"><?php echo $c['title']; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <button name="addBtn" class="btn btn-primary">Add Post</button>
                        </div>
                    </div>
                </div>
            </form>
            
        
<?php include "template/footer.php"; ?>
<script>
    $("#descForSummernote").summernote({
        
        tabsize: 2,
        height: 500,
        
    });
</script>