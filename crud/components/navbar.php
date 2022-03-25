 <!-- Navbar -->
 <nav class="navbar navbar-admin p-5 navbar-expand-lg navbar-dark bg-light mb-5">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
            <img class="userImage img-thumbnail rounded-circle" src="../img/<?php echo $row['picture']; ?>" alt="<?php echo $row['fname']; ?>" width="100" height="100" class="d-inline-block align-text-top">
            <div class="text-white ms-3">Hi <?php echo $row['fname']; ?></div></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-5">
                <a class="nav-link" href="pets_available.php"><button class="btn btn-success p-3">See available pets</button></a>
                <a class="nav-link" href="logout.php?logout"><button class="btn btn-outline-danger p-3">Log out</button></a>
            </div>
            </div>
        </div>
    </nav>