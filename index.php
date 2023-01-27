<?php session_start(); ?>
<?php require_once "front_panel/head.php"; ?>
<title>Home</title>
<?php require_once "front_panel/side_head.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white mb-4">
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </nav>
            <div class="">
                <div class="dropdown mb-4 text-right">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                       <i class="feather-calendar"></i> Sort News
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="?order_by=created_at&order_type=asc">
                            <i class="feather-arrow-down-circle"></i> Oldest to Newest
                        </a>
                        <a class="dropdown-item" href="?order_by=created_at&order_type=desc">
                            <i class="feather-arrow-up-circle"></i> Newest to Oldest
                        </a>
                        <a class="dropdown-item" href="?order_by=created_at&order_type=desc">
                            <i class="feather-list"></i>  Default
                        </a>
                       
                    </div>
                </div>

                <?php 

                if(isset($_GET['order_by'],$_GET['order_type'])){

                    $orderBy = $_GET['order_by'];
                    $orderType = strtoupper($_GET['order_type']);
                    $fPosts = fPosts($orderBy,$orderType);
                }
                else{

                    $fPosts = fPosts();
                }
                
                
                foreach($fPosts as $p){ 
                    
                ?>

                <div class="card shadow-sm mb-4 post">
                    <div class="card-body">
                        <a href="detail.php?id=<?php echo $p['id']; ?>" class="text-primary">
                            <h4><?php echo $p['title']; ?></h4>
                        </a>
                        <div class="my-3">
                                <i class="feather-users text-primary"></i>
                                <?php echo user($p['user_id'])['name']; ?>
                                <i class="feather-layers text-success"></i>
                                <?php echo category($p['category_id'])['title']; ?>
                                <i class="feather-calendar text-danger"></i>
                                <?php echo date("j M Y",strtotime($p['created_at'])); ?>
                            </div>
                        <p class="text-black-50">
                            <?php echo short(strip_tags(html_entity_decode($p['description'])),"400"); ?>
                            
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php require_once "right_sidebar.php"; ?>
    </div>
</div>

<?php require_once "front_panel/foot.php"; ?>