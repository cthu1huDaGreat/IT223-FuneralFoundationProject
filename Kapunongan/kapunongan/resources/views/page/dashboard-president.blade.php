<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>President Dashboard - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/dashboard-president.css')}}">

</head>
<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="{{url('img/logo.png')}}" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="{{route('page.dashboard-president')}}" class="active">Dashboard</a>
    <a href="{{route('page.president-contribution')}}">Transactions</a>
    <a href="{{route('page.president-funeral')}}">Funeral Assistance</a>
    <a href="{{route('page.president-members')}}">Manage Members</a>
    <a href="{{route('page.president-settings')}}">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
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

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 style="color: #00E5FF;">Total Balance</h6>
            <h3 id="totalBalance">₱{{ number_format($balance ?? 0, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 style="color: #00E5FF;">Total Funeral Fund</h6>
            <h3 id="totalFuneral">₱{{ number_format($totalFuneral ?? 0, 2) }}</h3>
        </div>
    </div>
</div>

<div class="card mb-4">
  <div class="card-header" data-bs-toggle="collapse" data-bs-target="#announcementsCollapse" style="cursor:pointer;">
    Announcements
  </div>
  <div id="announcementsCollapse" class="collapse">
    <div class="card-body" id="announcementsList">
      <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">+ New Announcement</button><br><br>
      @php
          use App\Http\Controllers\AnnouncementController;
          $announcementController = new AnnouncementController();
          $announcements = $announcementController->getAnnouncements();
      @endphp

      @forelse($announcements as $note)
        <div class="announcement-item" id="announcement-{{ $note->announcement_id }}">
          <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item text-danger delete-announcement" href="#" data-id="{{ $note->announcement_id }}">Delete</a></li>
            </ul>
          </div>

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
</div>

<!-- ADD ANNOUNCEMENT MODAL -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Post New Announcement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addAnnouncementForm">
        <div class="modal-body">
          <div id="announcementAlerts"></div>
          
          <!-- Title Input -->
          <div class="mb-3">
            <label for="announcementTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="announcementTitle" name="title" required>
          </div>

          <!-- Content Input -->
          <div class="mb-3">
            <label for="announcementContent" class="form-label">Content</label>
            <textarea class="form-control" id="announcementContent" name="content" rows="5" placeholder="What would you like to announce?" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-accent">Post Announcement</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Members Table -->
<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">All Members Overview</h5>
      <div class="text-end">
        <small class="text">Total Members</small>
        <h3 class="mb-0" id="totalMembers">0</h3>  
      </div>
    </div>
    <div class="mb-3">
      <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role">
    </div>
    <div class="table-responsive">
      <table class="table table-dark table-hover" id="membersTable">
        <thead>
          <tr>
            <th data-sort="name">Name</th>
            <th data-sort="role">Family List</th>
            <th data-sort="contribution">Funeral Fund Balance</th>
            <th data-sort="penalty">Penalties</th>
            <th data-sort="total  ">Total</th>
          </tr>
        </thead>
        <tbody><tr><td colspan="6" class="text-center">Loading...</td></tr></tbody>
      </table>
    </div>
  </div>
</div>

  </main>
</div>

<!-- Delete Announcement Modal -->
<div class="modal fade" id="deleteAnnouncementModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this announcement?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAnnouncementBtn">Delete</button>
            </div>
        </div>
    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    let announcementToDelete = null;
    
    document.querySelectorAll('.delete-announcement').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            announcementToDelete = this.getAttribute('data-id');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteAnnouncementModal'));
            deleteModal.show();
        });
    });
    
    document.getElementById('confirmDeleteAnnouncementBtn').addEventListener('click', function() {
        if (!announcementToDelete) return;
        
        const originalText = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
        
        fetch('{{ route("announcements.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                announcement_id: announcementToDelete
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
                const announcementElement = document.getElementById(`announcement-${announcementToDelete}`);
                if (announcementElement) {
                    announcementElement.remove();
                    checkEmptyAnnouncements();
                }
                
                alert('Announcement deleted successfully!');
            } else {
                throw new Error(data.message || 'Failed to delete announcement');
            }
        })
        .catch(error => {
            console.error('Error deleting announcement:', error);
            alert('Error deleting announcement: ' + error.message);
        })
        .finally(() => {  
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteAnnouncementModal'));
            deleteModal.hide();
            
            this.disabled = false;
            this.innerHTML = originalText;
            announcementToDelete = null;
        });
    });
    
    function checkEmptyAnnouncements() {
        const announcementsList = document.getElementById('announcementsList');
        const remainingAnnouncements = announcementsList.querySelectorAll('.announcement-item');
        
        if (remainingAnnouncements.length === 0) {
            announcementsList.innerHTML = '<p class="text-muted-2">No announcements available.</p>';
        }
    }
});
</script>
<script>//Announcement Form Submission
document.getElementById('announcementForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const button = form.querySelector('button[type="submit"]');
    const messageContainer = document.getElementById('announcementMessageContainer');
    
    button.disabled = true;
    button.textContent = 'Posting...';
    
    messageContainer.innerHTML = '';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            form.reset();
        } else {
            messageContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }
    })
    .catch(error => {
        messageContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                An error occurred while posting the announcement.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = 'Post';
    });
});
</script>
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
  window.location='{{route('page.index')}}';
});

</script>
</body>
</html>
