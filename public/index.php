<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TECHNEXA® – Web, App, AI/ML, DevOps, Cybersecurity & Marketing Agency</title>
<meta name="description" content="TECHNEXA is a next-generation technology & marketing agency delivering world-class web, app, AI/ML, DevOps, cybersecurity, blockchain and performance marketing solutions.">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary:'#1e2a4a',secondary:'#17a2b8',accent:'#20c997'
      }
    }
  }
}
</script>
<style>
.fade-in-up{opacity:0;transform:translateY(20px);transition:opacity .8s ease,transform .8s ease;}
.fade-in-up.show{opacity:1;transform:none;}
</style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<!-- HEADER with hamburger -->
<header class="fixed top-0 w-full bg-white/100 backdrop-blur z-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <a href="/" class="flex items-center gap-3">
      <img src="logo.png" alt="TECHNEXA" class="h-20 w-30 bg-transparent">
      <span class="font-extrabold text-xl">TECHNEXA</span>
    </a>
    <nav id="nav-links" class="hidden md:flex gap-6 text-sm">
      <a href="#services" class="hover:text-secondary">Services</a>
      <a href="#about" class="hover:text-secondary">About</a>
      <a href="#process" class="hover:text-secondary">Process</a>
      <a href="#projects" class="hover:text-secondary">Case Studies</a>
      <a href="#contact" class="hover:text-secondary">Contact</a>
      <a href="/contact.php" class="ml-3 px-4 py-2 bg-secondary text-white rounded-lg hover:bg-accent ">Get a Quote</a>
    </nav>
    <button id="hamburger" class="md:hidden flex flex-col gap-1.5">
      <span class="w-6 h-0.5 bg-slate-800"></span>
      <span class="w-6 h-0.5 bg-slate-800"></span>
      <span class="w-6 h-0.5 bg-slate-800"></span>
    </button>
  </div>
  <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg">
    <div class="px-6 py-4 flex flex-col gap-4 text-sm">
      <a href="#services" class="hover:text-secondary">Services</a>
      <a href="#about" class="hover:text-secondary">About</a>
      <a href="#process" class="hover:text-secondary">Process</a>
      <a href="#projects" class="hover:text-secondary">Case Studies</a>
      <a href="#contact" class="hover:text-secondary">Contact</a>
      <a href="/contact.php" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-accent text-center">Get a Quote</a>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="relative overflow-hidden text-white pt-28 pb-32">
  <!-- background video -->
  <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
    <source src="hero.mp4" type="video/mp4">
  </video>
  <!-- dark overlay to keep text readable -->
  <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-slate-900/80 to-black/80"></div>

  <!-- content -->
  <div class="relative max-w-7xl mx-auto px-6 text-center">
    <h1 class="text-5xl md:text-6xl font-extrabold leading-tight fade-in-up">
      Build, Secure &amp; Grow Your Digital Business
    </h1>
    <p class="mt-6 text-lg md:text-xl text-slate-200 fade-in-up">
      TECHNEXA blends cutting-edge development, cybersecurity, AI/ML and marketing to deliver measurable impact.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-4 fade-in-up">
      <a href="/contact.php" class="px-8 py-3 bg-secondary rounded-xl text-white hover:bg-accent">Request Consultation</a>
      <a href="#services" class="px-8 py-3 border border-white/30 rounded-xl hover:bg-white/10">Explore Services</a>
    </div>
  </div>
</section>


<!-- SERVICES -->
<section id="services" class="relative bg-gradient-to-b from-slate-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-6">
    <!-- heading -->
    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-extrabold text-primary">Our Services</h2>
      <p class="mt-3 text-slate-600 max-w-2xl mx-auto">Product engineering meets growth marketing. Every service is delivered by certified experts and hardened by real-world scale.</p>
    </div>

    <!-- grid -->
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
      <?php
      // add an icon filename as third element
      $services = [
        ["Web Development","High-performance, SEO-first websites built on modern stacks with pixel-perfect design.","globe-alt"],
        ["App Development","Cross-platform apps with analytics and rapid release cycles.","device-phone-mobile"],
        ["Social Media Marketing","Content strategy, creative production & community management.","share"],
        ["Performance Marketing","Search, display & paid social optimized for ROAS.","chart-bar"],
        ["Cybersecurity","Hardening, VAPT, WAF & incident response to safeguard assets.","shield-check"],
        ["Blockchain","Smart contracts, dApps, token utilities with audits.","hexagon"],
        ["DevOps & Cloud","CI/CD, Docker/K8s, autoscaling, monitoring & SRE.","cloud"],
        ["AI/ML Solutions","Chatbots, predictive models, RAG pipelines & MLOps.","sparkles"]
      ];
      foreach ($services as $s) {
        $icon = $s[2];
        echo '
        <div class="group relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur border shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1">
          <div class="absolute inset-0 bg-gradient-to-r from-secondary/0 to-accent/0 group-hover:from-secondary/10 group-hover:to-accent/10 transition"></div>
          <div class="p-6 relative z-10">
            <!-- icon -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-secondary/10 text-secondary mb-4 group-hover:scale-110 transition-transform">
              <!-- heroicons outline -->
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
                <use xlink:href="#'.$icon.'"></use>
              </svg>
            </div>
            <h3 class="font-bold text-lg text-primary">'.$s[0].'</h3>
            <p class="mt-2 text-slate-600">'.$s[1].'</p>
            <span class="mt-3 inline-block text-secondary font-medium opacity-0 group-hover:opacity-100 transition-opacity">Learn more →</span>
          </div>
        </div>';
      }
      ?>
    </div>
  </div>

  <!-- inline SVG sprite for icons (you can replace with your own) -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="globe-alt" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor"/><path d="M2 12h20M12 2c3 4 3 16 0 20" stroke="currentColor"/></symbol>
    <symbol id="device-phone-mobile" viewBox="0 0 24 24"><rect x="7" y="2" width="10" height="20" rx="2" stroke="currentColor"/><circle cx="12" cy="18" r="1" fill="currentColor"/></symbol>
    <symbol id="share" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2" fill="currentColor"/><circle cx="19" cy="5" r="2" fill="currentColor"/><circle cx="19" cy="19" r="2" fill="currentColor"/><path d="M7 12l10-7m0 14L7 12" stroke="currentColor"/></symbol>
    <symbol id="chart-bar" viewBox="0 0 24 24"><path d="M3 3v18h18" stroke="currentColor"/><rect x="7" y="10" width="3" height="7" fill="currentColor"/><rect x="12" y="6" width="3" height="11" fill="currentColor"/><rect x="17" y="13" width="3" height="4" fill="currentColor"/></symbol>
    <symbol id="shield-check" viewBox="0 0 24 24"><path d="M12 2l8 4v6c0 5-3 9-8 10-5-1-8-5-8-10V6l8-4z" stroke="currentColor"/><path d="M9 12l2 2 4-4" stroke="currentColor"/></symbol>
    <symbol id="hexagon" viewBox="0 0 24 24"><path d="M4 7l8-5 8 5v10l-8 5-8-5V7z" stroke="currentColor"/></symbol>
    <symbol id="cloud" viewBox="0 0 24 24"><path d="M5 17a4 4 0 010-8 5.5 5.5 0 0110.9-1.5A4 4 0 1119 17H5z" stroke="currentColor"/></symbol>
    <symbol id="sparkles" viewBox="0 0 24 24"><path d="M12 3l1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3z" stroke="currentColor"/></symbol>
  </svg>
</section>


<!-- ABOUT -->
<section id="about" class="relative bg-slate-50 py-20">
  <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
    <!-- left: text -->
    <div>
      <h2 class="text-4xl md:text-5xl font-extrabold text-primary">About <span class="text-secondary">TECHNEXA</span></h2>
      <p class="mt-4 text-slate-700">We are a multidisciplinary team of engineers, marketers and designers dedicated to delivering technology that drives growth. From startup MVPs to enterprise transformation, our philosophy stays the same: build fast, secure and scalable products, then help them reach the right audience.</p>
      <ul class="mt-6 grid sm:grid-cols-2 gap-4 text-slate-700">
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>50+ successful digital launches across industries</li>
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>ISO-level security and compliance practices</li>
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>Dedicated 24×7 support for mission-critical systems</li>
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>Certified experts in AWS, Azure, GCP, Meta Ads and Google Ads</li>
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>In-house UX/UI designers & brand storytellers</li>
        <li class="flex items-start gap-2"><span class="text-secondary font-bold">✔</span>Data-driven marketing with transparent reporting</li>
      </ul>
    </div>
    <!-- right: image or illustration -->
    <div class="relative">
      <img src="team.png" alt="TECHNEXA Team" class="rounded-2xl shadow-xl object-cover">
      <div class="absolute -inset-4 bg-secondary/10 rounded-3xl blur-3xl -z-10"></div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<!-- PROCESS -->
<section id="process" class="relative bg-gradient-to-r from-secondary to-accent text-white py-20">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-4xl md:text-5xl font-extrabold">Our Process</h2>
    <p class="mt-4 text-white/80 max-w-3xl mx-auto">We combine agile development with growth marketing to deliver rapid results without compromising quality.</p>

    <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
      <?php
        $steps = [
          ["Discover","Deep dive into your goals, audience and tech stack.","search-circle"],
          ["Design","Craft user-centric experiences and secure architectures.","pencil-square"],
          ["Develop","Iterative build with automated testing & CI/CD.","code-bracket"],
          ["Grow","Deploy, monitor and fuel adoption with marketing.","arrow-trending-up"]
        ];
        foreach ($steps as $st) {
          $icon = $st[2];
          echo '
          <div class="group relative p-6 rounded-xl bg-white/10 backdrop-blur hover:bg-white/20 transition">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white/20 text-white mb-4 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
                <use xlink:href="#'.$icon.'"></use>
              </svg>
            </div>
            <h3 class="font-bold text-xl">'.$st[0].'</h3>
            <p class="mt-2 text-white/80">'.$st[1].'</p>
          </div>';
        }
      ?>
    </div>
  </div>

  <!-- inline icons sprite -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="search-circle" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" stroke="currentColor"/><line x1="16.65" y1="16.65" x2="21" y2="21" stroke="currentColor"/></symbol>
    <symbol id="pencil-square" viewBox="0 0 24 24"><path d="M4 16v4h4l10-10-4-4L4 16z" stroke="currentColor"/><path d="M14 6l4 4" stroke="currentColor"/></symbol>
    <symbol id="code-bracket" viewBox="0 0 24 24"><path d="M8 9L3 12l5 3M16 9l5 3-5 3" stroke="currentColor"/></symbol>
    <symbol id="arrow-trending-up" viewBox="0 0 24 24"><path d="M3 17l6-6 4 4 7-7" stroke="currentColor"/></symbol>
  </svg>
</section>


<!-- CASE STUDIES -->
<section id="projects" class="max-w-7xl mx-auto px-6 py-20">
  <div class="flex items-end justify-between">
    <h2 class="text-4xl font-extrabold text-primary">Case Studies</h2>
    <a href="/projects.php" class="text-secondary">View all →</a>
  </div>
  <div class="mt-10 grid gap-6 md:grid-cols-3">
    <?php
    $projects = $pdo->query("SELECT id,title,category,description,image_path FROM projects ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
    if (!$projects) {
      echo '<p class="text-slate-600">Add projects in the admin panel to showcase them here.</p>';
    } else {
      foreach ($projects as $p) {
        $img = $p['image_path'] ?: '/assets/images/logo.png';
        echo '<article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-1 transition">
                <img src="'.htmlspecialchars($img).'" alt="'.htmlspecialchars($p['title']).'" class="h-48 w-full object-cover">
                <div class="p-5">
                  <span class="text-xs uppercase tracking-wide text-slate-500">'.htmlspecialchars($p['category']).'</span>
                  <h3 class="mt-1 font-bold text-lg text-primary">'.htmlspecialchars($p['title']).'</h3>
                  <p class="mt-2 text-sm text-slate-600 line-clamp-3">'.htmlspecialchars($p['description']).'</p>
                </div>
              </article>';
      }
    }
    ?>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="bg-slate-100 py-16">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-4xl font-extrabold text-primary">What Our Clients Say</h2>
    <div class="mt-10 grid md:grid-cols-3 gap-6 text-left">
      <div class="p-6 bg-white rounded-xl shadow">
        <p>"TECHNEXA transformed our outdated portal into a high-performing platform. Traffic doubled within three months."</p>
        <span class="mt-3 block font-bold">– CTO, Fintech Startup</span>
      </div>
      <div class="p-6 bg-white rounded-xl shadow">
        <p>"Their security audit saved us from a major vulnerability. Professional, fast and thorough."</p>
        <span class="mt-3 block font-bold">– Head of IT, Retail Chain</span>
      </div>
      <div class="p-6 bg-white rounded-xl shadow">
        <p>"We love their data-driven marketing approach. Our ROAS improved 4x compared to our previous agency."</p>
        <span class="mt-3 block font-bold">– Marketing Director, eCommerce Brand</span>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section id="contact" class="bg-gradient-to-r from-primary to-secondary text-white">
  <div class="max-w-7xl mx-auto px-6 py-16 text-center">
    <h2 class="text-3xl md:text-4xl font-extrabold">Ready to Build Something Extraordinary?</h2>
    <p class="mt-3 text-white/80 max-w-2xl mx-auto">Tell us about your goals. We’ll propose a practical roadmap and a transparent budget.</p>
    <a href="/contact.php" class="mt-6 inline-block px-8 py-3 rounded-xl bg-white text-secondary hover:text-accent">Start a Project</a>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-white border-t">
  <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-4 gap-8">
    <div>
      <img src="logo.png" alt="TECHNEXA logo" class="h-10">
      <p class="mt-3 text-sm text-slate-600">TECHNEXA is a technology & growth partner for startups and enterprises worldwide.</p>
    </div>
    <div>
      <h4 class="font-semibold mb-3">Services</h4>
      <ul class="space-y-2 text-sm text-slate-600">
        <li>Web & App Development</li><li>AI/ML</li><li>DevOps & Cloud</li><li>Cybersecurity</li><li>Blockchain</li><li>Social & Performance</li>
      </ul>
    </div>
    <div>
      <h4 class="font-semibold mb-3">Company</h4>
      <ul class="space-y-2 text-sm text-slate-600">
        <li><a href="/projects.php">Projects</a></li>
        <li><a href="/clients.php">Clients</a></li>
        <li><a href="/contact.php">Contact</a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-semibold mb-3">Contact</h4>
      <p class="text-sm text-slate-600">hello@technexa.example<br>+91-00000-00000</p>
    </div>
  </div>
  <div class="text-center text-xs text-slate-500 py-4 border-t">© <?php echo date('Y'); ?> TECHNEXA. All rights reserved.</div>
</footer>

<script>
// animate fade-in
const observer=new IntersectionObserver((entries)=>{
  entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('show');});
});
document.querySelectorAll('.fade-in-up').forEach(el=>observer.observe(el));

// mobile menu toggle
const hamburger=document.getElementById('hamburger');
const mobileMenu=document.getElementById('mobile-menu');
hamburger.addEventListener('click',()=>{mobileMenu.classList.toggle('hidden');});
</script>

</body>
</html>
