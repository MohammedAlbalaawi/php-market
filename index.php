<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Market Project</title>


    <link rel="stylesheet" href="css/style.css">

    <!-- Cairo Font -->
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Fontawesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<!-- Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

            <a class="navbar-brand" href="#">
                <img src="images/logo.PNG" alt="" width="40" height="40" class="d-inline-block align-text-top">
                ماركت
            </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">الطلبات</a>
                </li>
            </ul>
            <form class="d-flex">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-dark" style="height: 100%;margin-right:5px;"><i
                                    class="fa fa-magnifying-glass text-light"></i></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </form>
        </div>
    </div>
</nav>
<!-- Content (Products)-->
<section style="background-color: #eee;">
    <!-- Main Contanier -->
    <div class="container py-5">
        <!-- Fetsh from Database -->
        <?php
        include "conn.php";
        //$stmt = $conn->prepare("SELECT * FROM market_db.products");
        $stmt = $conn->prepare("
        SELECT
        market_db.products.*, 
        market_db.categories.title as cat_title, 
        market_db.tags.title as tag_title
        FROM market_db.products 
        inner JOIN market_db.products_has_tags on  market_db.products_has_tags.product_id = products.id
        inner JOIN market_db.tags on market_db.products_has_tags.tag_id = market_db.tags.id
        JOIN market_db.categories on market_db.products.category_id = market_db.categories.id
        group by  market_db.products.id
        order by  market_db.products.id
        ");
        $stmt->execute();
        $products = $stmt->fetchAll();
        foreach ($products as $product) {
            ?>
            <!-- Product DIV -->
            <div class="row justify-content-center mb-3">
                <div class="col-md-12 col-xl-10">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                    <img src="images/01-orange.PNG" class="w-100"/>
                                </div>
                                <div class="col-md-6 col-lg-3 col-xl-6 mt-4">
                                    <h5><?= $product['title'] ?></h5>
                                    <div class="d-flex flex-row">
                                        التصنيف : <span class="text-success mx-1"><?= $product['cat_title'] ?></span>
                                    </div>
                                    <!-- RATING -->
                                    <!-- <div class="d-flex flex-row">
                                        <div class="text-danger mb-1 me-2">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <span>310</span>
                                    </div> -->
                                    <div class="mt-1 mb-0 text-muted small">
                                        <?php
                                        $tagQuery = $conn->prepare("
                                        SELECT
                                        market_db.products.id as prod_id, 
                                        market_db.tags.title as tag_title
                                        FROM market_db.products 
                                        inner JOIN market_db.products_has_tags on  market_db.products_has_tags.product_id = products.id
                                        inner JOIN market_db.tags on market_db.products_has_tags.tag_id = market_db.tags.id
                                        JOIN market_db.categories on market_db.products.category_id = market_db.categories.id
                                        order by  market_db.products.id
                                        ");
            $tagQuery->execute();

            // Returns tags titles and product ids
            $allTags = $tagQuery->fetchAll();
            foreach ($allTags as $tag) {
                if ($product['id'] == $tag['prod_id']) {
                    ?>
                                                <span> <?= $tag['tag_title'] ?> </span>
                                                <span class="text-primary"> • </span>
                                                <?php
                }
            } ?>

                                    </div>
                                    <p class="text-truncate mb-4 mb-md-0">
                                        <?= $product['description'] ?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                    <div class="d-flex flex-row-reverse">
                                        <a href=""><i class=" px-2 fa-solid fa-table-cells-large"></i></a>
                                        <a href=""><i class="fa-solid fa-list"></i></a>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h4 class="mb-1 me-1"><?= $product['price'] ?></h4>
                                        <span class="text-danger"><s><?= $product['discount'] ?></s></span>
                                    </div>
                                    <h6 class="text-success">توصيل مجاني</h6>
                                    <div class="d-flex flex-column mt-4">
                                        <button class="btn btn-primary btn-sm" type="button">تفاصيل</button>
                                        <button class="btn btn-outline-primary btn-sm mt-2" type="button">
                                            إضافة إلى السلة
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } ?>
    </div>
</section>
</body>
</html>