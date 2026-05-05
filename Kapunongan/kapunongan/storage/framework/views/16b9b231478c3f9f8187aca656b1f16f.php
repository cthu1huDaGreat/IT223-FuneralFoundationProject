<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Contributions - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo e(url('img/logo.png')); ?>">
<link rel="stylesheet" href="<?php echo e(url('css/member-contribution.css')); ?>">

</head>
<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="<?php echo e(url('img/logo.png')); ?>" alt="logo">
    <div class="fw-bold">Kapunongan
    </div>
  </div>
  <nav>
    <a href="<?php echo e(route('page.dashboard-member')); ?>">Dashboard</a>
    <a href="<?php echo e(route('page.member-contribution')); ?>" class="active">Transactions</a>
    <a href="<?php echo e(route('page.member-funeral')); ?>">Funeral Information</a>
    <a href="<?php echo e(route('page.member-settings')); ?>">Settings</a>
    <a href="<?php echo e(route('logout')); ?>" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div id="welcomeTextMember" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">Transactions</h2>

    <div class="row g-3 mb-4">
      <div class="col-md-4"><div class="card p-3"><h6>Outstanding Balance</h6><h3 id="memberOutstanding">₱0</h3></div></div>
      <div class="col-md-4"><div class="card p-3"><h6>Total Penalties</h6><h3 id="memberPenalties">₱0</h3></div></div>
    </div>


    <div class="card mb-4">
      <div class="card-body">
        <h5>Make a Payment</h5>
        <input type="number" id="paymentAmount" class="form-control mb-2" placeholder="Enter amount (₱)">
        <select id="paymentType" class="form-select mb-2">
          <option value="Contribution" style="color: #000;">Contribution</option>
          <option value="Penalty" style="color: #000;">Penalty</option>
        </select>
        <button id="payBtn" class="btn btn-accent">Pay Now</button>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body table-responsive">
        <h5>Contribution History</h5>
        <table class="table table-dark table-hover align-middle">
          <thead><tr><th>#</th><th>Date</th><th>Amount (₱)</th><th>Type</th><th>Recorded By</th></tr></thead>
          <tbody id="memberContribTable"></tbody>
        </table>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body table-responsive">
        <h5>Penalties</h5>
        <table class="table table-dark table-hover align-middle">
          <thead><tr><th>#</th><th>Date</th><th>Amount (₱)</th><th>Reason</th><th>Status</th></tr></thead>
          <tbody id="memberPenaltyTable"></tbody>
        </table>
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="notificationList">
        <p class="text-muted-2">Loading notifications...</p>
      </div>
    </div>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
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
// Sidebar toggle okay rani nga naa sa diri kay mobile friendly ni sya
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
</body>
</html>
<?php /**PATH C:\xampp\htdocs\kapunongan\resources\views/page/member-contribution.blade.php ENDPATH**/ ?>