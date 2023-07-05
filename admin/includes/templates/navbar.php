


<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-inverse ">
   <div class="container">
            <div class="navbar-header">

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
  
           </div>
            <a class="navbar-brand " href="Dashboard.php"><?php echo lang('HOME_ADMIN');?></a>

  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">
     
           <li class="nav-item active">
              <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES');?></a>
           </li>
           <li class="nav-item active">
              <a class="nav-link" href="items.php"><?php echo lang('ITEMS');?></a>
           </li>
           <li class="nav-item active">
              <a class="nav-link" href="members.php"><?php echo lang('MEMBERS');?></a>
           </li>
            <li class="nav-item active">
              <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS');?></a>
           </li>
           <li class="nav-item active">
              <a class="nav-link" href="cards.php"><?php echo lang('CARDS');?></a>
           </li>
           <li class="nav-item active">
              <a class="nav-link" href="report.php"><?php echo lang('REPORTS');?></a>
           </li>
   </ul>
   <ul class="nav navbar-nav navbar-right">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $_SESSION['Username'] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a  class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
        <!--  <a class="dropdown-item" href="#">Settings</a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="Logout.php">Logout</a>
        </div>
      </li>
    </ul>
   </div>
  </div>
</nav>