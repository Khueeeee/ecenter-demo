<div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
  
      </section>
   
   </header>   
<div class="side-bar">
   
      <div id="close-btn">
         <i class="fas fa-times"></i>
      </div>
   
      <div class="profile">
            <img src="<?php echo $result['anh'] ?>" alt=""  class="image">
            <h3><?php echo $result['hoten'] ?></h3>
            <p class="role">Giảng viên</p>
            <a href="profile.php?id=<?php echo $id ?>" class="btn">view profile</a>
      </div>
   
      <nav class="navbar">
      <a href="course_gv.php"><i class="fas fa-graduation-cap"></i><span>Khóa học</span></a>
      <a href="idgv_gv.php"><i class="fas fa-chalkboard-user"></i><span>Giảng viên</span></a>
      <a href="idhs_gv.php"><i class="fas fa-user-pen"></i><span>Học sinh</span></a>
      <a href="dangkylich_gv.php"><i class="fas fa-calendar-days"></i><span> Đăng ký lịch dạy</span></a>
      <a href="logout.php"><i class="fas fa-power-off"></i><span>Đăng xuất</span></a>
      </nav>
      
   </div>