<nav class="navbar navbar-expand-lg bg-body-tertiary mt-0 pt-0">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">TypingGen</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about.php">About</a>
        </li>
      </ul>
      <div class="d-flex">
        <?php 
        if(!isset($_SESSION['user_id'])){
          echo '<a class=" me-2 btn btn-danger "href="/auth/login.php">Login</a><a class=" me-2 btn btn-warning " href="/auth/register.php">Register</a>';
        }else{
       echo '<a href="/typing.php/" class="btn btn-outline-secondary me-1">Practice</a> ';
          echo "<a class='me-2 btn btn-success' href='/dashboard.php/'>Dashboard</a>";
        }
        ?>
</div>
    </div>
  </div>
</nav>