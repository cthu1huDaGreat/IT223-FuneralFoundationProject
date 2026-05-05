<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Kapunongan sa Dayong</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo e(url('img/logo.png')); ?>">
<link rel="stylesheet" href="<?php echo e(url('css/index.css')); ?>">


<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($err); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
</head>
<body>

<div class="animated-bg"></div>
<div class="animated-overlay"></div>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container d-flex align-items-center">
    <a class="navbar-brand titles">
      <img src="<?php echo e(url('img/logo.png')); ?>" alt="logo" style="height:34px;margin-right:10px;"> Kapunongan sa Dayong
    </a>  

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="rgba(230,238,243,0.9)" stroke-width="1.6" stroke-linecap="round"/></svg>
    </button>

    <div class="collapse navbar-collapse" id="navCollapse">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#membership">Membership</a></li>
        <li class="nav-item ms-2"><a class="nav-link btn btn-primary-custom text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="container">
    <div class="card-hero glass-card">
      <div style="flex:1; min-width:220px">
        <h1 class="fw-bold">United in Bayanihan — Serving Families in Times of Loss</h1>
        <p class="lead mt-2 text-muted-2">Kapunongan sa Dayong supports members through community contributions, funeral assistance, and mutual aid. </p>

        <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
          <a class="btn btn-primary-custom btn-lg" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register now</a>
          <a class="btn btn-outline-light rec " href="#membership">Learn more</a>

          <!-- CSV import controls-->
          <label class="btn btn-outline-light" for="csvInput" style="cursor:pointer;border-radius:10px;padding:10px 14px;border:1px solid rgba(255,255,255,0.04);display:none;"></label>
            <input id="csvInput" type="file" accept=".csv" style="display:none" />
          </label>
        </div>
      </div>

      <div style="min-width:240px; text-align:right">
        <div style="font-size:13px;color:var(--muted)">Total Members</div>
        <div id="totalMembers" style="font-weight:800;font-size:40px;margin-top:6px;color:transparent;background:linear-gradient(90deg,var(--accent-a),var(--accent-b));-webkit-background-clip:text;background-clip:text">0</div>
       
      </div>
    </div>
  </div>
</header>

<!-- ABOUT -->
<section id="about">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="section-title" style="color:#e9fbf5; font-size:32px;">About Us</h2>
    </div>

    <div class="text-center mb-4">
      <p class="text">Kapunongan sa Dayong is a community-led organization preserving the Filipino values of <b>bayanihan</b> and <b>pakikiramay</b>. It aims to strengthen unity among members by promoting cooperation, 
        mutual support, and cultural pride. Through various programs and activities, the organization fosters compassion, solidarity, and a deep sense of belonging within the community.</p>
    </div>

    <div class="row align-items-center mb-5 about-row">
      <div class="col-md-6">
        <div class="about-card glass-card p-0">
            <img src="<?php echo e(url('img/SMCT-Brand-photos-53.webp')); ?>" alt="Community Gathering" class="img-fluid rounded about-img">
        </div>
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold" style="color:#e9fbf5; font-size:26px">Our Story</h4>
        <p class="text-muted-2 mt-3">Born from the compassion of local families, Kapunongan sa Dayong started as a small group helping neighbors manage funeral expenses and emotional burdens. What began as simple bayanihan has grown into a strong organization that continues to uplift the community through coordinated financial and volunteer support.</p>
      </div>
    </div>

    <div class="row align-items-center flex-md-row-reverse about-row">
      <div class="col-md-6">
        <div class="about-card glass-card p-0">
              <img src="<?php echo e(url('img/how-to-include-community-outreach-programs-in-your-nursing-home-1.jpg')); ?>" class="img-fluid rounded about-img">
        </div>
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold" style="color:#e9fbf5; font-size:26px;">Our Mission</h4>
        <p class="text-muted-2 mt-3">We aim to strengthen the bonds of unity by promoting compassion, preparedness, and shared responsibility. Through regular outreach programs, wellness seminars, and emergency aid, we ensure that no member stands alone during life’s most difficult moments.</p>
      </div>
    </div>
  </div>
</section>
<br><br>

<!-- MEMBERSHIP -->
<section id="membership">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="section-title" style="color:#e9fbf5; font-size:32px;">Membership Benefits</h2>
    </div>

    <div class="row mt-4">
      <div class="col-md-4 mb-4">
        <div class="glass-card membership-card text-center">
          <img src="<?php echo e(url('img/discussion.png')); ?>" class="membership-icon mb-3" alt="discussion icon" style="width:64px;height:64px">
          <h5 class="fw-bold">Financial Support</h5>
          <p class="text-muted-2">It supports timely assistance during funeral expenses and emergencies.</p>
        </div>
      </div>

      <div class="col-md-4 mb-4 ">
        <div class="glass-card membership-card text-center ">
          <img src="<?php echo e(url('img/community-building.png')); ?>" class="membership-icon mb-3" alt="community icon" style="width:64px;height:64px">
          <h5 class="fw-bold">Community Unity</h5>
          <p class="text-muted-2">Participate in bayanihan activities and strengthen ties with fellow members.</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="glass-card membership-card text-center">
          <img src="<?php echo e(url('img/wreath.png')); ?>" class="membership-icon mb-3" alt="wreath icon" style="width:64px;height:64px">
          <h5 class="fw-bold">Funeral Assistance</h5>
          <p class="text-muted-2">Coordinated volunteers and guidance for funeral arrangements.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<br><br>
<!-- CONTACT -->
<section style="background: linear-gradient(180deg, rgba(255,255,255,0.01), transparent);">
  <div class="container">
    <div class="text-center mb-3">
      <h2 class="section-title" style="color:#e9fbf5; font-size:30px;">Contact & Information</h2>
    </div>
    <div class="glass-card contact-section text-center">
      <p class="text-muted-2 mb-4">For inquiries, suggestions, or partnership opportunities, reach out to us.</p>

      <div class="d-flex justify-content-center gap-4 mb-3">
        <a href="mailto:info@kapunongansadayong.org" target="_blank" aria-label="Email"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/gmail.svg" alt="gmail" style="width:36px"></a>
        <a href="https://facebook.com/kapunongansadayong" target="_blank" aria-label="Facebook"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="fb" style="width:36px"></a>
        <a href="https://instagram.com/kapunongansadayong" target="_blank" aria-label="Instagram"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="ig" style="width:36px"></a>
      </div>

      <p class="text-muted-2"><b>Kapunongan sa Dayong</b> is dedicated to supporting Filipino families through community, compassion, and shared responsibility.</p>
    </div>
  </div>
</section>

<footer class="footer text-center py-3">
  <div class="container">
    <small>&copy; 2025 Kapunongan sa Dayong — Contact: info@kapunongansadayong.org</small>
  </div>
</footer>

<!-- Login Modal-->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h3 class="text-center fw-bold mb-3" style="color:var(--accent-a); font-size: 40px;">Login</h3>
      <form id="loginForm" action="<?php echo e(route('login')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" id="loginEmail" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
         <div class="password-wrapper">
  <input name="password" type="password" id="loginPassword" class="form-control" required>
  <img src="<?php echo e(url('img/hide.png')); ?>" class="toggle-password" data-target="loginPassword">
</div>

        </div>
        <button type="submit" class="btn btn-primary-custom w-100 mb-2">Login</button>
        <p class="text-center mb-0">Don't have an account? 
          <span class="text-link" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal" style="cursor:pointer;color:var(--accent-a)">Register</span>
        </p>
      </form>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h3 class="text-center fw-bold mb-3" style="color:var(--accent-a); font-size: 40px;">Register</h3>
      <form id="registerForm" method="POST" action="<?php echo e(route('register.user')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" name="lname" id="reglname" class="form-control" required>
        </div>
          <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" name="fname" id="regfname" class="form-control" required>
        </div>
          <div class="mb-3">
          <label class="form-label">Middle Name</label>
          <input type="text" name="mi" id="regmname" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" id="regEmail" class="form-control" required>
        </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="regPassword" class="form-control" required>
            <img src="<?php echo e(url('img/hide.png')); ?>" class="toggle-password" data-target="regPassword">
          </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
          <div class="password-wrapper">
            <input type="password" name="password_confirmation" id="regConfirmPassword" class="form-control" required>
            <img src="<?php echo e(url('img/hide.png')); ?>" class="toggle-password" data-target="regConfirmPassword">
          </div>
      </div>
        <button type="submit" class="btn btn-primary-custom w-100 mb-2">Register</button>
        <p class="text-center mb-0">Already have an account? <span class="text-link" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal" style="cursor:pointer;color:var(--accent-a)">Login</span></p>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

/* UX: smooth scroll for in-page links (non-functional, safe) */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click', function(e){
    const target = this.getAttribute('href');
    if(target.length>1 && document.querySelector(target)){
      e.preventDefault();
      document.querySelector(target).scrollIntoView({behavior:'smooth', block:'start'});
      const collapseEl = document.querySelector('#navCollapse');
      if(collapseEl.classList.contains('show')) new bootstrap.Collapse(collapseEl).hide();
    }
  });
});


// SHOW / HIDE PASSWORD FUNCTION
document.querySelectorAll(".toggle-password").forEach(icon => {
  icon.addEventListener("click", () => {
    const input = document.getElementById(icon.dataset.target);

    if (input.type === "password") {
      input.type = "text";
        icon.src = "<?php echo e(url('img/show.png')); ?>"; // replace with your show icon
    } else {
      input.type = "password";
      icon.src = "<?php echo e(url('img/hide.png')); ?>"; // replace with your hide icon
    }
  });
});
</script>
</body>
</script>
</html>
<?php /**PATH C:\xampp\htdocs\kapunongan\resources\views/page/index.blade.php ENDPATH**/ ?>