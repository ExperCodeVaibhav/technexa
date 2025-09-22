<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
</body>
</html>