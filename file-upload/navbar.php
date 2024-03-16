<?php 
$current_page = basename($_SERVER['PHP_SELF']);
?>
<html>
    <head>
        <style>
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

body {
  font-family: 'Quicksand', sans-serif;
  background-color: #f0f0f0;
}


.active {
    background-color: #45a049; /* Green */
  }



.top-nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #302f49;
  display: flex;
  justify-content: space-around;
  padding: 10px;
}

.top-nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.top-nav li {
  display: inline-block;
}

.top-nav a {
  color: #fff;
  text-decoration: none;
  display: flex;
  align-items: center;
  padding: 10px 20px;
  border-radius: 5px;
  transition: all 0.2s ease-in-out;
}

.top-nav a i {
  margin-right: 10px;
}

.top-nav a:hover {
  background-color: #45a049;
}


@media only screen and (max-width: 768px) {
  .top-nav {
    justify-content: space-between;
  }
}

@media only screen and (max-width: 480px) {
  .top-nav li {
    font-size: 12px;
  }
}

        </style>
    </head>
    <body>
  <nav class="top-nav">
  <ul>
  <li <?php if ($current_page === 'home.php') echo 'class="active"'; ?>><a href="home.php">Home</a></li>
  <li <?php if ($current_page === 'upload.php') echo 'class="active"'; ?>><a href="upload.php">Upload</a></li>
  </ul>
</nav>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-zkaj7mnR14/3snqG4S4/vBUJACn+zruidfhLEW7aOiGSzqRkWuh7lwOTMDRcrhAgzRWobz+rInrD+nOxkMBzowe" crossorigin="anonymous" referrerpolicy="no-referrer">


    </body>
</html>