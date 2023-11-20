
<nav class="navbar navbar-expand-lg bg-white shadow">
  <div class="container">
    <a class="navbar-brand" href="#">POS System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home</a>
        </li>
        <?php if(isset($_SESSION['loggedIn'])): ?>
        
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['loggedInUser']['name'] ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><a class="dropdown-item text-white" href="admin/index.php">dashboard</a></li>
              <li class="dropdown-item"><a class="text-decoration-none text-white" href="logout.php">Logout</a>
            </li>
          </ul>
        </li>
     
        <?php else: ?>
            <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php endif; ?>
       
      </ul>
    </div>
  </div>
</nav>
