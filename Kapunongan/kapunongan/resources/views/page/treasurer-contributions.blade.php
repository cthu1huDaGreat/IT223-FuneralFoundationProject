<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Contributions - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/treasurer-contributions.css')}}">

</head>
<body>

<!-- Overlay -->
<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand">
<img src="{{url('img/logo.png')}}" alt="logo">  
 <div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="{{route('page.dashboard-treasurer')}}">Dashboard</a>
    <a href="{{route('page.treasurer-contributions')}}" class="active">Transactions</a>
    <a href="{{route('page.treasurer-funeral')}}">Funeral Assistance</a>
    <a href="{{route('page.treasurer-members')}}">Manage Members</a>
    <a href="{{route('page.treasurer-settings')}}">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div class="fw-bold" id="treasurerName">Treasurer Panel</div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">Contributions Management</h2>

    <!-- Quick Add Payment -->
    <div class="card mb-4">
      <div class="card-header fw-bold" style="background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#000;">Add Payment</div>
      <div class="card-body">
        <div class="row g-2 align-items-end">
          <div class="col-md-3"><input type="email" id="paymentEmail" class="form-control" placeholder="Member Email"></div>
          <div class="col-md-2"><input type="number" id="paymentAmount" class="form-control" placeholder="₱0"></div>
          <div class="col-md-3">
            <select id="paymentType" class="form-select">
              <option value="Contribution" style="color:#000;">Contribution</option>
              <option value="Penalty" style="color:#000;">Penalty</option>
            </select>
          </div>
          <div class="col-md-2">
            <select id="paymentMethod" class="form-select">
              <option value="Cash" style="color:#000;">Cash</option>
              <option value="Gcash" style="color:#000;">Gcash</option>
            </select>
          </div>
          <div class="col-md-2"><button class="btn-accent w-100" onclick="addPayment()">Add Payment</button></div>
        </div>
      </div>
    </div>

    <!-- Contribution Records Table -->
    <div class="card mb-4">
      <div class="card-header fw-bold" style="background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#000;">All Contribution Records</div>
      <div class="card-body table-responsive">
        <div class="mb-3">
          <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role">
        </div>
        <table class="table table-dark align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Member Name</th>
              <th>Email</th>
              <th>Date</th>
              <th>Amount (₱)</th>
              <th>Type</th>
              <th>Method</th>
              <th>Recorded By</th>
            </tr>
          </thead>
          <tbody id="recordsTableBody"></tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Notifications</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="notificationList"><p class="text-muted-2">Loading notifications...</p></div>
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
// Sidebar toggle
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
document.getElementById('logoutBtn').addEventListener('click', e=>{
  e.preventDefault();
  new bootstrap.Modal(document.getElementById('logoutModal')).show();
});
document.getElementById('confirmLogoutBtn').addEventListener('click', ()=>{
  
  window.location='{{route('page.index')}}';
});
</script>
</body>
</html>
