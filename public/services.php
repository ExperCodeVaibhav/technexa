<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Services | TECHNEXA</title>
<meta name="description" content="All TECHNEXA services in detail: web & app development, AI/ML solutions, DevOps, cybersecurity audits, blockchain development, social media & performance marketing.">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<?php include '../partials/header.php'; ?> <!-- your header with mobile menu -->

<section class="bg-gradient-to-br from-primary via-slate-900 to-black text-white py-24 text-center">
  <h1 class="text-5xl font-extrabold">Our Services</h1>
  <p class="mt-3 max-w-2xl mx-auto text-white/80">End-to-end technology and marketing solutions for ambitious brands.</p>
</section>

<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="grid gap-12 md:grid-cols-2">
    <div>
      <h2 class="text-3xl font-extrabold text-primary">Web Development</h2>
      <p class="mt-3 text-slate-700">Responsive, SEO-optimized websites built on PHP, Tailwind, and Node. Accessibility & Core Web Vitals A-scores by default.</p>
    </div>
    <div>
      <h2 class="text-3xl font-extrabold text-primary">App Development</h2>
      <p class="mt-3 text-slate-700">iOS & Android apps with robust APIs, analytics, crash reporting, and CI/CD for rapid iteration.</p>
    </div>
    <!-- repeat for each service -->
  </div>
</section>

<?php include '../partials/footer.php'; ?>
</body>
</html>
