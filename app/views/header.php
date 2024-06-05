<?php
  require_once(__DIR__ . '/../core/init.php');
  require_once(__DIR__ . '/../config/mysql.php');
  require_once(__DIR__ . '/../databaseconnect.php'); 
  require_once(__DIR__ . '/../functions.php');

  $userInfo = null;

  if (isset($_SESSION['user_id'])) {
      $userInfo = getUserInfos($_SESSION['user_id'], ['illustration', 'role_id']);
  }

?>

<!-- header.php -->
<div class="shadow px-4">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo.png" alt="" height="80">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="recipes-list.php">Les recettes</a>
          </li>
          <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="recipe-form.php">Partager une recette</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <div>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Rechercher une recette" aria-label="Rechercher une recette">
          <button class="btn btn-outline-dark" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
          </button>
        </form>
      </div>
      <?php if(isset($_SESSION['user_id'])): ?>
        <div class="dropdown ms-5" id="profile-btn">
          <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?php echo htmlspecialchars($userInfo['illustration'])?>" alt="" ></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="user_profile.php"><i class="fa-solid fa-user me-2" aria-hidden="true"></i>Voir mon profil</a></li>
            <?php if($userInfo['role_id'] == "2"): ?>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-wrench me-2" aria-hidden="true"></i>Administration</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Se déconnecter</a></li>
          </ul>
        </div>
      <?php else: ?>
        <button class="btn btn-primary ms-5" id="header_login-btn">
              <a href="login.php">Se connecter</a>
        </button>
      <?php endif; ?>
    </div>
  </nav>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>