<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>President Contributions - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/president-contribution.css')}}">

</head>
<body>

<!-- Overlay -->
<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="{{url('img/logo.png')}}" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="{{route('page.dashboard-president')}}">Dashboard</a>
    <a href="{{route('page.president-contribution')}}" class="active">Transactions</a>
    <a href="{{route('page.president-funeral')}}">Funeral Assistance</a>
    <a href="{{route('page.president-members')}}">Manage Members</a>
    <a href="{{route('page.president-settings')}}">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div id="welcomeTextPresident" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">Contributions Overview</h2>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card p-3">
          <h6 style="color: #00E5FF;">Members Contributed</h6>
          <h3 id="membersContributed">0/0</h3>
        </div>
      </div>
    <div class="col-md-4">
        <div class="card p-3">
          <h6 style="color: #00E5FF;">Outstanding Balance</h6>
          <h3 id="totalOutstanding">₱0</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <h6 style="color: #00E5FF;">Total Contributions</h6>
          <h3 id="totalContributions">₱0</h3>
        </div>
      </div>
    </div>
    
    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#">New Payment</button><br><br>

    <!-- Contribution Table -->
    <div class="card mb-4">
          <div class="card-header">Contribution Table</div>
      <div class="card-body table-responsive">
   
        <div class="mb-3">
          <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role">
        </div>
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Member Name</th>
              <th>Date</th>
              <th>Amount (₱)</th>
              <th>Type</th>
              <th>Recorded By</th>
            </tr>
          </thead>
          <tbody id="contributionsTableBody"></tbody>
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

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
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

// Logout modal
const logoutBtn = document.getElementById('logoutBtn');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

logoutBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});

confirmLogoutBtn.addEventListener('click', ()=>{

  window.location='{{route('page.index')}}';
});
</script>
</body>
</html>
