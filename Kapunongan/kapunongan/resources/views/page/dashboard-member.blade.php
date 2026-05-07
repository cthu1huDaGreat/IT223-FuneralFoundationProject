<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Member Dashboard - Kapunongan</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/dashboard-member.css')}}">


</head>

<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="{{url('img/logo.png')}}" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="{{route('page.dashboard-member')}}" class="active">Dashboard</a>
    <a href="{{route('page.member-contribution')}}">Transactions</a>
    <a href="{{route('page.member-funeral')}}">Funeral Information</a>
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
    <h2 class="fw-bold mb-4">Member Dashboard</h2>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card p-3">
          <h6 style="color:#00E5FF;">Outstanding Balance</h6>
          <h3 id="memberOutstanding">₱0</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <h6 style="color:#00E5FF;">Total Penalties</h6>
          <h3 id="memberOutstanding">₱0</h3>
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h5>Profile Snapshot</h5>
        <p class="text-muted-2">View and Complete your personal details in your profile page.</p>
        
        <a href="{{ route('page.member-settings') }}" class="btn btn-accent">Go to Settings</a>
      </div>
    </div>

<div class="card mb-4">
  <div class="card-header">Announcements from President</div>
  <div class="card-body" id="announcementsList">
    @php
        use App\Http\Controllers\AnnouncementController;
        $announcementController = new AnnouncementController();
        $announcements = $announcementController->getAnnouncements();
    @endphp

    @forelse($announcements as $note)
      <div class="announcement-item" id="announcement-{{ $note->announcement_id }}">
        <!-- Dismiss Button (X) -->
        <button class="dismiss-btn" data-id="{{ $note->announcement_id }}" title="Dismiss announcement">&times;</button>

        <div class="announcement-content">
          <strong>{{ $note->title }}</strong>
          <small class="text-info">{{ $note->date }}</small><br>
          <p>{{ $note->content }}</p>
        </div>
      </div>
    @empty
      <p class="text-muted-2">No announcements available.</p>
    @endforelse
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dismiss announcement functionality
    initializeDismissButtons();

    function initializeDismissButtons() {
        document.querySelectorAll('.dismiss-btn').forEach(button => {
            // Remove existing event listeners to prevent duplicates
            button.removeEventListener('click', handleDismissClick);
            // Add new event listener
            button.addEventListener('click', handleDismissClick);
        });
    }

    function handleDismissClick(event) {
        const button = event.currentTarget;
        const announcementId = button.getAttribute('data-id');
        
        if (!announcementId) {
            console.error('No announcement ID found');
            return;
        }
        
        dismissAnnouncement(announcementId, button);
    }

    function dismissAnnouncement(announcementId, button) {
        // Show loading state
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '...';
        
        fetch('{{ route("announcements.dismiss") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                announcement_id: announcementId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remove the announcement from the UI with animation
                const announcementElement = document.getElementById(`announcement-${announcementId}`);
                if (announcementElement) {
                    // Add fade-out animation
                    announcementElement.classList.add('announcement-fade-out');
                    
                    setTimeout(() => {
                        announcementElement.remove();
                        
                        // Check if no announcements left
                        checkEmptyAnnouncements();
                    }, 300);
                }
            } else {
                throw new Error(data.message || 'Failed to dismiss announcement');
            }
        })
        .catch(error => {
            console.error('Error dismissing announcement:', error);
            
            // Show user-friendly error message
            alert('Error dismissing announcement: ' + error.message);
            
            // Reset button state
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    function checkEmptyAnnouncements() {
        const announcementsList = document.getElementById('announcementsList');
        const remainingAnnouncements = announcementsList.querySelectorAll('.announcement-item');
        
        if (remainingAnnouncements.length === 0) {
            announcementsList.innerHTML = '<p class="text-muted-2">No announcements available.</p>';
        }
    }
});
</script>

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

document.getElementById('welcomeTextMember').innerText = `Welcome, ${user.name || ''}`;


document.querySelectorAll('.dismiss-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const announcementId = this.getAttribute('data-id');

        fetch('/announcement/dismiss', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ announcement_id: announcementId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                // Smooth fade-out before removal
                const item = document.getElementById('announcement-' + announcementId);
                item.style.transition = "opacity 0.4s ease";
                item.style.opacity = "0";
                setTimeout(() => item.remove(), 400);
            }
        });
    });
});

// Logout modal okay rasad nga naa ni sya kay for logout button ni ug confirmation
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
