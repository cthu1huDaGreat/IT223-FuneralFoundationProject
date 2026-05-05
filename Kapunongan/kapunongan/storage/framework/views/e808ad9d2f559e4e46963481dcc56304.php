<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>President Dashboard - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo e(url('img/logo.png')); ?>">
<link rel="stylesheet" href="<?php echo e(url('css/dashboard-president.css')); ?>">

</head>
<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="<?php echo e(url('img/logo.png')); ?>" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="<?php echo e(route('page.dashboard-president')); ?>" class="active">Dashboard</a>
    <a href="<?php echo e(route('page.president-members')); ?>">Manage Members</a>
    <a href="<?php echo e(route('page.president-contribution')); ?>">Contributions</a>
    <a href="<?php echo e(route('page.president-funeral')); ?>">Funeral Assistance</a>
    <a href="<?php echo e(route('page.president-settings')); ?>">Settings</a>
    <a href="<?php echo e(route('logout')); ?>" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <div class="d-flex align-items-center gap-2">
      <button id="hamburger">☰</button>
      <div id="welcomeTextPresident" class="fw-bold"></div>
    </div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">President Dashboard</h2>

    <!-- Funeral Notifications -->
    <div class="card mb-4" id="funeralNotificationsCard">
      <div class="card-body">
        <h5>New Funeral Information Submissions</h5>
        <div id="funeralNotifications"><p class="text">Loading notifications...</p></div>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 style="color: #00E5FF;">Total Members</h6>
            <h3 id="totalMembers"><?php echo e($totalMembers); ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 style="color: #00E5FF;">Total Contributions</h6>
            <h3 id="totalContributions">₱<?php echo e(number_format($totalContributions ?? 0, 2)); ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 style="color: #00E5FF;">Total Funeral Assistance</h6>
            <h3 id="totalFuneral">₱<?php echo e(number_format($totalFuneral ?? 0, 2)); ?></h3>
        </div>
    </div>
</div>


    <!-- Announcements -->
    <?php if(session('success')): ?>
    <div class="alert alert-success">
      <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
        <div class="card mb-4">
          <div class="card-body">
            <h5>Post Announcement</h5>
            <form id="announcementForm" action="<?php echo e(url('announcements/store')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <input type="text" name="title" id="announcementTitle" class="form-control" placeholder="Title" required>
              </div>
              <div class="mb-3">
                <textarea id="announcementMessage" name="message" class="form-control" placeholder="Message" rows="3" required></textarea>
              </div>
              <button class="btn-accent" type="submit">Post</button>
            </form>
              <script>
                document.getElementById('announcementForm').addEventListener('submit', function(e) {
                    e.preventDefault(); // prevent normal form submission

                    let formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            alert(data.message || 'Announcement posted!');
                            this.reset(); // clear the form
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Something went wrong.');
                    });
                });
              </script>
          </div>
        </div>

     <div class="card mb-4">
      <div class="card-header">Announcements from President</div>
      <div class="card-body" id="announcementsList">
        <p class="text-muted-2">Loading announcements...</p>
      </div>
    </div>


    <!-- Members Table -->
    <div class="card mb-4">
      <div class="card-body">
        <h5>All Members Overview</h5>
        <div class="mb-3">
          <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role">
        </div>
        <div class="table-responsive">
          <table class="table table-dark table-hover" id="membersTable">
            <thead>
              <tr>
                <th data-sort="name">Name ▲▼</th>
                <th data-sort="email">Email ▲▼</th>
                <th data-sort="role">Role ▲▼</th>
                <th data-sort="outstanding">Outstanding ▲▼</th>
                <th data-sort="contribution">Total Contributions ▲▼</th>
                <th data-sort="funeral">Funeral Claimed ▲▼</th>
              </tr>
            </thead>
            <tbody><tr><td colspan="6" class="text-center">Loading...</td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Notifications</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="notificationList">
        <p class="text-muted">Loading notifications...</p>
      </div>
    </div>
  </div>
</div>


<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"><p>Are you sure you want to logout?</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>


const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

hamburger.addEventListener('click', () => {
  if(sidebar.classList.contains('active')) {
    sidebar.classList.remove('active');
    overlay.style.display='none';
  } else {
    sidebar.classList.add('active');
    overlay.style.display='block';
  }
});
overlay.addEventListener('click', ()=>{ sidebar.classList.remove('active'); overlay.style.display='none'; });

// Logout modal okay rasad nga naa ni sya kay for logout button ni ug confirmation
const logoutBtn = document.getElementById('logoutBtn');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

logoutBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});


confirmLogoutBtn.addEventListener('click', ()=>{
  window.location='<?php echo e(route('page.index')); ?>';
});

</script>
<script>
document.getElementById('announcementForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message);
            this.reset();
        }
    })
    .catch(err => console.error(err));
});
</script>
</body>
</html>
<?php /**PATH D:\Backup\kapunongan\resources\views/page/dashboard-president.blade.php ENDPATH**/ ?>