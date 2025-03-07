<!-- Home page -->
<?php include "../includes/header.php";?>
<div class="product-main">
    <h2 id="title">Kit Collective</h2>
    <h1 id="deal-subtitle">Welcome, have a cozy yarn-filled day!</h1>
    <?php include "../includes/connectdb.php";?>
</div>
<div>
    <div
        id="carouselExampleAutoplaying"
        class="carousel slide"
        data-bs-ride="carousel"
    >
        <div class="carousel-inner">
        <div class="carousel-item active">
            <img
            src="./assets/images/carousel-1.jpg"
            class="d-block w-100"
            alt="Coding in Action"
            />
        </div>
        <div class="carousel-item">
            <img
            src="./assets/images/carousel-2.jpg"
            class="d-block w-100"
            alt="Designing in Action"
            />
        </div>
        <div class="carousel-item">
            <img
            src="./assets/images/carousel-3.jpg"
            class="d-block w-100"
            alt="Crocheting In Action"
            />
        </div>
        </div>
        <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="prev"
        >
        <span
            class="carousel-control-prev-icon"
            aria-hidden="true"
        ></span>
        <span class="visually-hidden"><</span>
        </button>
        <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="next"
        >
        <span
            class="carousel-control-next-icon"
            aria-hidden="true"
        ></span>
        <span class="visually-hidden">></span>
        </button>
    </div>
</div>
<?php include "../includes/footer.php"?>

    