<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Funeral Information - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/member-funeral.css')}}">

</head>
<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand">
<img src="{{url('img/logo.png')}}" alt="logo">
    <div class="fw-bold">Kapunongan</div>
  </div>
  <nav>
    <a href=" {{route('page.dashboard-member')}}">Dashboard</a>
    <a href="{{route('page.member-contribution')}}">Transactions</a>
    <a href="{{route('page.member-funeral')}}" class="active">Funeral Information</a>
    <a href="{{route('page.member-settings')}}">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger" class="btn-menu">☰</button>
    <div id="welcomeTextMember" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">Funeral Information</h2>

<!-- Request Form - Compact Version -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#000; cursor: pointer;"
         data-bs-toggle="collapse" 
         data-bs-target="#requestFormBody" 
         aria-expanded="true">
        <span class="fw-bold">Request Funeral Information</span>
        <i class="bi bi-chevron-down collapse-icon"></i>
    </div>
    
    <div class="collapse hide" id="requestFormBody">
        <div class="card-body">
            <div class="mb-3">
                <!-- First Row: 3 fields -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Deceased Name</label>
                        <input type="text" class="form-control" id="deceasedName" placeholder="Full name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sex</label>
                        <select id="deceasedSex" class="form-select">
                            <option value="">Select sex</option>
                            <option style="color:#000;">Male</option>
                            <option style="color:#000;">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Age</label>
                        <input type="number" class="form-control" id="deceasedAge" placeholder="Age">
                    </div>
                </div>

                <!-- Second Row: 3 fields -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Relation</label>
                        <input type="text" class="form-control" id="relation" placeholder="Your relation">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cause of Death</label>
                        <input type="text" class="form-control" id="causeOfDeath" placeholder="Cause of death">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date of Death</label>
                        <input type="date" class="form-control" id="dateOfDeath">
                    </div>
                </div>

                <!-- Message field at the bottom -->
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Message to the President</label>
                        <textarea class="form-control" id="messageToPresident" rows="3" placeholder="Enter your message to the President"></textarea>
                    </div>
                </div>

                <button id="requestBtn" class="btn btn-accent mt-3 w-100">Submit Request</button>
            </div>
        </div>
    </div>
</div>
    <!-- Request History Table -->
    <div class="card mb-4">
      <div class="card-body table-responsive">
        <h5>Submitted Funeral Information</h5>
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Deceased Name</th>
              <th>Sex</th>
              <th>Age</th>
              <th>Relation</th>
              <th>Cause of Death</th>
              <th>Date of Death</th>
              <th>Message</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="funeralTable"></tbody>
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
// Sidebar toggle & overlay
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

logoutBtn.addEventListener('click',(e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});
confirmLogoutBtn.addEventListener('click',()=>{
  window.location='{{route('page.index')}}';
});
</script>
</body>
</html>
