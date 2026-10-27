<!DOCTYPE html>
<html lang="th" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MUT Cloud VPS Management') - สำนักพัฒนาระบบเครือข่าย มหาวิทยาลัยเทคโนโลยีมหานคร</title>
  
    <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

  <script>
    (function() {
      const saved = localStorage.getItem('mut_theme');
      if (saved === 'light') {
        document.documentElement.classList.remove('dark');
      } else {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    };
  </script>

  <style>
    body { font-family: 'Prompt', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }

    /* ================= LIGHT THEME REFINEMENTS ================= */
    html:not(.dark) {
      color-scheme: light;
    }
    html:not(.dark) body {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }
    html:not(.dark) main {
      background-color: #f1f5f9 !important;
    }
    html:not(.dark) .bg-\[\#0b0f19\] {
      background-color: #f1f5f9 !important;
    }
    html:not(.dark) .bg-\[\#0d1322\] {
      background-color: #ffffff !important;
    }
    html:not(.dark) .bg-\[\#101726\],
    html:not(.dark) .bg-\[\#111827\] {
      background-color: #ffffff !important;
      box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.06), 0 1px 2px -1px rgb(0 0 0 / 0.06) !important;
      border-color: #e2e8f0 !important;
    }
    html:not(.dark) .bg-\[\#0b101c\],
    html:not(.dark) .bg-\[\#090d17\] {
      background-color: #f8fafc !important;
    }
    html:not(.dark) .bg-\[\#0e1424\],
    html:not(.dark) .bg-\[\#0e1422\],
    html:not(.dark) .bg-\[\#050810\] {
      background-color: #f8fafc !important;
      border-color: #e2e8f0 !important;
    }

    /* Cards and option labels inside main content */
    html:not(.dark) main label.bg-\[\#0b0f19\],
    html:not(.dark) main div.rounded-2xl.bg-\[\#0b0f19\],
    html:not(.dark) main div.rounded-xl.bg-\[\#0b0f19\] {
      background-color: #ffffff !important;
      border-color: #e2e8f0 !important;
      box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.04) !important;
    }

    /* Sidebar Footer Quota Card */
    html:not(.dark) aside .bg-gradient-to-b {
      background: #f8fafc !important;
      border-color: #e2e8f0 !important;
    }

    /* Borders and Dividers */
    html:not(.dark) .border-\[\#1a2336\],
    html:not(.dark) .border-\[\#1d2a44\],
    html:not(.dark) .border-\[\#1f293d\],
    html:not(.dark) .border-\[\#161e30\] {
      border-color: #e2e8f0 !important;
    }
    html:not(.dark) .divide-\[\#1a2336\] > * + * {
      border-color: #e2e8f0 !important;
    }

    /* Text Contrast for Light Theme */
    html:not(.dark) .text-white {
      color: #0f172a !important;
    }
    html:not(.dark) .text-slate-100 {
      color: #0f172a !important;
    }
    html:not(.dark) .text-slate-200 {
      color: #1e293b !important;
    }
    html:not(.dark) .text-slate-300 {
      color: #334155 !important;
    }
    html:not(.dark) .text-slate-400 {
      color: #64748b !important;
    }
    html:not(.dark) .text-slate-500 {
      color: #64748b !important;
    }

    /* Vibrant & Legible Status/Accent Text in Light Mode */
    html:not(.dark) .text-blue-400 {
      color: #2563eb !important;
    }
    html:not(.dark) .text-emerald-400 {
      color: #059669 !important;
    }
    html:not(.dark) .text-amber-400 {
      color: #d97706 !important;
    }
    html:not(.dark) .text-rose-400 {
      color: #e11d48 !important;
    }
    html:not(.dark) .text-indigo-400 {
      color: #4f46e5 !important;
    }
    html:not(.dark) .text-teal-400 {
      color: #0d9488 !important;
    }
    html:not(.dark) .text-purple-400 {
      color: #7c3aed !important;
    }

    /* Form Controls & Pills */
    html:not(.dark) .bg-slate-800,
    html:not(.dark) [class*="bg-slate-800"] {
      background-color: #f1f5f9 !important;
      color: #1e293b !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) .bg-slate-800:hover,
    html:not(.dark) [class*="bg-slate-800"]:hover {
      background-color: #e2e8f0 !important;
    }
    html:not(.dark) .bg-slate-900 {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .border-slate-800,
    html:not(.dark) .border-slate-700 {
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input,
    html:not(.dark) select,
    html:not(.dark) textarea {
      background-color: #ffffff !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input::placeholder,
    html:not(.dark) textarea::placeholder {
      color: #94a3b8 !important;
    }

    /* Progress bar tracks in light mode */
    html:not(.dark) div.bg-slate-800[class*="h-"] {
      background-color: #e2e8f0 !important;
    }

    /* Sign Out Button in Light Theme */
    html:not(.dark) .sign-out-btn,
    html:not(.dark) aside form button[type="submit"] {
      background-color: #f8fafc !important;
      border: 1px solid #e2e8f0 !important;
      color: #475569 !important;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
    }
    html:not(.dark) .sign-out-btn i,
    html:not(.dark) aside form button[type="submit"] i,
    html:not(.dark) .sign-out-btn span,
    html:not(.dark) aside form button[type="submit"] span {
      color: #475569 !important;
    }
    html:not(.dark) .sign-out-btn:hover,
    html:not(.dark) aside form button[type="submit"]:hover {
      background-color: #ffe4e6 !important;
      border-color: #fecdd3 !important;
      color: #e11d48 !important;
    }
    html:not(.dark) .sign-out-btn:hover i,
    html:not(.dark) aside form button[type="submit"]:hover i,
    html:not(.dark) .sign-out-btn:hover span,
    html:not(.dark) aside form button[type="submit"]:hover span {
      color: #e11d48 !important;
    }

    /* Theme Toggle Button in Light Mode */
    html:not(.dark) #themeBtn,
    html:not(.dark) button[onclick*="toggleTheme"] {
      background-color: #ffffff !important;
      border-color: #cbd5e1 !important;
      color: #334155 !important;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }
    html:not(.dark) #themeBtn:hover,
    html:not(.dark) button[onclick*="toggleTheme"]:hover {
      background-color: #f1f5f9 !important;
      border-color: #94a3b8 !important;
      color: #0f172a !important;
    }

    /* Modal Cancel & Auxiliary Buttons in Light Mode */
    html:not(.dark) button[onclick*="closeModal"] {
      background-color: #f1f5f9 !important;
      border: 1px solid #cbd5e1 !important;
      color: #475569 !important;
    }
    html:not(.dark) button[onclick*="closeModal"]:hover {
      background-color: #e2e8f0 !important;
      border-color: #94a3b8 !important;
      color: #0f172a !important;
    }
    html:not(.dark) a.bg-slate-800,
    html:not(.dark) button.bg-slate-800 {
      background-color: #f8fafc !important;
      border: 1px solid #cbd5e1 !important;
      color: #475569 !important;
    }
    html:not(.dark) a.bg-slate-800:hover,
    html:not(.dark) button.bg-slate-800:hover {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .hover\:bg-amber-900:hover {
      background-color: #fef3c7 !important;
    }
    html:not(.dark) .hover\:bg-rose-900:hover {
      background-color: #ffe4e6 !important;
    }
    html:not(.dark) .hover\:bg-slate-700:hover {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }

    /* High-contrast text colors for light-tinted labels in light mode */
    html:not(.dark) .text-amber-300 {
      color: #b45309 !important;
    }
    html:not(.dark) .text-rose-300 {
      color: #e11d48 !important;
    }
    html:not(.dark) .text-emerald-300 {
      color: #059669 !important;
    }
    html:not(.dark) .text-blue-300 {
      color: #1d4ed8 !important;
    }

    /* Ensure Solid Colored Buttons, Badges, Logos, and Active Tabs PRESERVE White Text */
    html:not(.dark) .bg-blue-600,
    html:not(.dark) .bg-blue-600 *,
    html:not(.dark) .bg-blue-500,
    html:not(.dark) .bg-blue-500 *,
    html:not(.dark) .bg-indigo-600,
    html:not(.dark) .bg-indigo-600 *,
    html:not(.dark) .bg-indigo-500,
    html:not(.dark) .bg-indigo-500 *,
    html:not(.dark) .bg-amber-600,
    html:not(.dark) .bg-amber-600 *,
    html:not(.dark) .bg-teal-600,
    html:not(.dark) .bg-teal-600 *,
    html:not(.dark) .bg-emerald-600,
    html:not(.dark) .bg-emerald-600 *,
    html:not(.dark) .bg-rose-600,
    html:not(.dark) .bg-rose-600 *,
    html:not(.dark) .bg-gradient-to-tr,
    html:not(.dark) .bg-gradient-to-tr *,
    html:not(.dark) .bg-gradient-to-r,
    html:not(.dark) .bg-gradient-to-r * {
      color: #ffffff !important;
    }

    /* Inactive Sidebar Links in Light Theme */
    html:not(.dark) aside nav a:not(.bg-blue-600):not(.bg-amber-600):not(.bg-teal-600) {
      color: #475569 !important;
    }
    html:not(.dark) aside nav a:not(.bg-blue-600):not(.bg-amber-600):not(.bg-teal-600):hover {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }

    /* Table Row Hover */
    html:not(.dark) .hover\:bg-\[\#121929\]:hover,
    html:not(.dark) tr.vm-row:hover,
    html:not(.dark) tr.member-row:hover {
      background-color: #f8fafc !important;
    }

    /* Terminal Console Modal Remains Authentic Dark Console */
    html:not(.dark) #modalTerminal .bg-\[\#0b0f19\],
    html:not(.dark) #modalTerminal #termOutput,
    html:not(.dark) #modalTerminal .bg-\[\#050810\] {
      background-color: #090d16 !important;
      color: #e2e8f0 !important;
      border-color: #1e293b !important;
    }
    html:not(.dark) #modalTerminal input#termInput {
      background-color: transparent !important;
      color: #ffffff !important;
    }
  </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex flex-col font-sans selection:bg-blue-600 selection:text-white antialiased transition-colors duration-200">

  <div class="flex-1 flex overflow-hidden">
    
    <aside class="w-72 bg-[#0d1322] border-r border-[#1a2336] flex flex-col shrink-0 select-none">
      
      <div class="p-4 border-b border-[#1a2336] flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-700 via-red-600 to-rose-500 flex items-center justify-center text-white text-lg font-black shadow-lg shadow-red-600/30 shrink-0">
            MUT
          </div>
          <div>
            <h1 class="font-bold text-sm text-white tracking-tight leading-none">MUT CLOUD VPS</h1>
            <p class="text-[10px] text-slate-400 font-mono mt-1">NOC อาคาร Q ชั้น 1</p>
          </div>
        </div>
        <span class="text-[10px] font-mono px-2 py-0.5 rounded font-bold shrink-0 {{ auth()->user()->isAdmin() ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">
          {{ auth()->user()->isAdmin() ? 'NOC ADMIN' : 'MEMBER' }}
        </span>
      </div>

      <div class="px-4 py-2.5 bg-[#090d17] border-b border-[#161e30] flex items-center justify-between text-xs">
        <div class="flex items-center gap-2 truncate">
          <span class="w-2 h-2 rounded-full {{ auth()->user()->isAdmin() ? 'bg-amber-400 animate-pulse' : 'bg-emerald-400' }}"></span>
          <span class="text-slate-300 font-medium truncate">{{ auth()->user()->name }}</span>
        </div>
        <span class="text-[10px] font-mono text-slate-500 uppercase">{{ auth()->user()->isAdmin() ? 'Superuser' : 'Active' }}</span>
      </div>

      <nav class="flex-1 p-3 space-y-1.5 overflow-y-auto text-xs">
        
        @if(!auth()->user()->isAdmin())
          <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-left">Services</div>

          <a href="{{ route('member.dashboard', ['tab' => 'instances']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? 'instances') === 'instances' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-server w-4 text-center shrink-0 {{ ($currentTab ?? '') === 'instances' ? 'text-white' : 'text-blue-400' }}"></i>
            <span class="text-left">My Cloud VPS</span>
          </a>

          <a href="{{ route('member.dashboard', ['tab' => 'new-vm']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'new-vm' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-plus-circle w-4 text-center shrink-0 {{ ($currentTab ?? '') === 'new-vm' ? 'text-white' : 'text-emerald-400' }}"></i>
            <span class="text-left">Deploy New VM</span>
          </a>

          <a href="{{ route('member.dashboard', ['tab' => 'public-access']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'public-access' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-globe w-4 text-center shrink-0 {{ ($currentTab ?? '') === 'public-access' ? 'text-white' : 'text-indigo-400' }}"></i>
            <span class="text-left">Domain & Port Forwarding</span>
          </a>

          <a href="{{ route('member.dashboard', ['tab' => 'account']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'account' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-id-badge w-4 text-center shrink-0 {{ ($currentTab ?? '') === 'account' ? 'text-white' : 'text-amber-400' }}"></i>
            <span class="text-left">Profile & Account</span>
          </a>

        @else
          <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-amber-400 text-left">NOC Admin</div>

          <a href="{{ route('admin.dashboard', ['tab' => 'noc-dashboard']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? 'noc-dashboard') === 'noc-dashboard' ? 'bg-amber-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-chart-line w-4 text-center shrink-0 text-amber-400"></i>
            <span class="text-left">Cluster Telemetry</span>
          </a>

          <a href="{{ route('admin.dashboard', ['tab' => 'noc-nodes']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'noc-nodes' ? 'bg-amber-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-server w-4 text-center shrink-0 text-blue-400"></i>
            <span class="text-left">Proxmox VE Nodes</span>
          </a>

          <a href="{{ route('admin.dashboard', ['tab' => 'noc-vms']) }}" 
            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'noc-vms' ? 'bg-amber-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <i class="fa-solid fa-cubes w-4 text-center shrink-0 text-indigo-400"></i>
            <span class="text-left">All Virtual Machines</span>
          </a>

          <a href="{{ route('admin.dashboard', ['tab' => 'noc-dnat']) }}" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'noc-dnat' ? 'bg-amber-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <div class="flex items-center gap-3 text-left">
              <i class="fa-solid fa-network-wired w-4 text-center shrink-0 text-purple-400"></i>
              <span class="text-left">Domain & DNAT Requests</span>
            </div>
            <span class="text-[10px] font-mono px-1.5 py-0.2 bg-emerald-500/20 text-emerald-400 rounded font-bold shrink-0">{{ \App\Models\PublicAccess::where('status', 'pending')->count() }}</span>
          </a>

          <a href="{{ route('admin.dashboard', ['tab' => 'noc-members']) }}" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-left transition {{ ($currentTab ?? '') === 'noc-members' ? 'bg-teal-600 text-white font-semibold shadow' : 'text-slate-400 hover:text-white hover:bg-[#151e33]' }}">
            <div class="flex items-center gap-3 text-left">
              <i class="fa-solid fa-users-gear w-4 text-center shrink-0 text-teal-400"></i>
              <span class="text-left">Member Management</span>
            </div>
            <span class="text-[10px] font-mono px-1.5 py-0.2 bg-teal-500/20 text-teal-400 rounded font-bold shrink-0">{{ \App\Models\User::where('role', 'member')->count() }}</span>
          </a>
        @endif

      </nav>

      <div class="p-4 border-t border-[#1a2336] bg-[#0b0f19]">
        @if(!auth()->user()->isAdmin())
        <div class="p-3 rounded-xl bg-gradient-to-b from-[#121929] to-[#0d1424] border border-[#1f293d] space-y-2">
          <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400 text-[11px] font-medium">VPS Quota</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ auth()->user()->hasActiveVm() ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
              {{ auth()->user()->used_quota }} / {{ auth()->user()->quota_max ?? 1 }}
            </span>
          </div>
          <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
            <div class="h-full {{ auth()->user()->hasActiveVm() ? 'bg-blue-500 w-full' : 'bg-emerald-500 w-0' }} transition-all duration-500"></div>
          </div>
          <div class="text-[10px] text-slate-500 font-mono flex items-center justify-between">
            <span>{{ auth()->user()->hasActiveVm() ? 'In Use' : 'Available' }}</span>
            <span class="text-blue-400 font-bold">1 VM / Account</span>
          </div>
        </div>
        @else
        <div class="p-3 rounded-xl bg-gradient-to-b from-[#121929] to-[#0d1424] border border-[#1f293d] space-y-1 text-[11px]">
          <div class="flex items-center justify-between text-amber-400 font-bold">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-tower-broadcast"></i> NOC Cluster</span>
            <span class="font-mono text-[10px] bg-amber-500/20 px-1.5 py-0.5 rounded">ONLINE</span>
          </div>
          <div class="text-[10px] text-slate-400 font-mono">อาคาร Q ชั้น 1 (NOC Data Center)</div>
        </div>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="mt-3">
          @csrf
          <button type="submit" class="sign-out-btn w-full py-2.5 px-3.5 rounded-xl bg-slate-800/80 hover:bg-rose-950 text-slate-300 hover:text-rose-300 border border-slate-700/50 hover:border-rose-900 transition flex items-center gap-3 text-left text-xs font-semibold">
            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center shrink-0 text-xs"></i>
            <span class="text-left">Sign Out</span>
          </button>
        </form>
      </div>

    </aside>

        <main class="flex-1 flex flex-col overflow-y-auto bg-[#0b0f19]">
      
            <div class="h-16 border-b border-[#1a2336] bg-[#0d1322] px-6 flex items-center justify-between shrink-0">
        <div>
          <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
            <a href="/" class="hover:text-blue-400">MUT NOC</a>
            <span>/</span>
            <span class="text-slate-200">@yield('breadcrumb', 'Dashboard')</span>
          </div>
          <h2 class="text-base sm:text-lg font-bold text-white tracking-tight leading-tight mt-0.5">
            @yield('header_title', 'จัดการเครื่องและบริการสถาบัน')
          </h2>
        </div>

                <div class="flex items-center gap-2">
          <button type="button" onclick="toggleTheme()" id="themeBtn"
            class="px-3 py-1.5 rounded-xl border border-slate-700 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium flex items-center gap-2 transition shadow-sm"
            title="สลับธีม สว่าง / มืด">
            <i class="fa-solid fa-sun text-amber-400 theme-icon-sun"></i>
            <i class="fa-solid fa-moon text-blue-400 theme-icon-moon" style="display: none;"></i>
            <span class="theme-text text-[11px] font-mono">ธีมสว่าง/มืด</span>
          </button>
        </div>
      </div>

            <div class="p-6 max-w-6xl w-full space-y-6">
        @yield('content')
      </div>

    </main>

  </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ',
          text: {!! json_encode(session('success')) !!},
          confirmButtonColor: '#2563eb'
        });
      @endif

      @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'ข้อผิดพลาด',
          text: {!! json_encode(session('error')) !!},
          confirmButtonColor: '#d33'
        });
      @endif

      @if(session('warning'))
        Swal.fire({
          icon: 'warning',
          title: 'แจ้งเตือน',
          text: {!! json_encode(session('warning')) !!},
          confirmButtonColor: '#d97706'
        });
      @endif

      @if(session('info'))
        Swal.fire({
          icon: 'info',
          title: 'ข้อมูล',
          text: {!! json_encode(session('info')) !!},
          confirmButtonColor: '#2563eb'
        });
      @endif

      @if(session('temp_password'))
        Swal.fire({
          icon: 'info',
          title: 'รหัสผ่านชั่วคราวใหม่',
          html: `
            <div class="text-xs text-slate-300 text-left space-y-2">
              <p>ระบบสร้างรหัสผ่านชั่วคราวสำหรับสมาชิก <strong>{!! json_encode(session('target_member')) !!}</strong> เรียบร้อยแล้ว:</p>
              <div class="p-3 rounded-xl bg-[#0b0f19] border border-slate-700 font-mono text-center text-sm font-bold text-amber-400 select-all">
                {{ session('temp_password') }}
              </div>
              <p class="text-[11px] text-slate-400">กรุณาคัดลอกรหัสผ่านนี้ส่งมอบให้แก่สมาชิก</p>
            </div>
          `,
          confirmButtonText: 'คัดลอกและปิดหน้าต่าง',
          confirmButtonColor: '#2563eb'
        }).then(() => {
          navigator.clipboard.writeText("{{ session('temp_password') }}");
        });
      @endif
    });

    function openModal(id) {
      const el = document.getElementById(id);
      if (el) el.classList.remove('hidden');
    }
    function closeModal(id) {
      const el = document.getElementById(id);
      if (el) el.classList.add('hidden');
    }
    function togglePasswordVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (!input || !icon) return;
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function toggleTheme() {
      const isDark = document.documentElement.classList.toggle('dark');
      localStorage.setItem('mut_theme', isDark ? 'dark' : 'light');
      updateThemeUI();
    }

    function updateThemeUI() {
      const isDark = document.documentElement.classList.contains('dark');
      document.querySelectorAll('.theme-icon-sun').forEach(el => el.style.display = isDark ? 'inline-block' : 'none');
      document.querySelectorAll('.theme-icon-moon').forEach(el => el.style.display = isDark ? 'none' : 'inline-block');
      document.querySelectorAll('.theme-text').forEach(el => el.innerText = isDark ? 'ธีมมืด (Dark)' : 'ธีมสว่าง (Light)');
    }
    document.addEventListener('DOMContentLoaded', updateThemeUI);
  </script>

  @stack('scripts')
</body>
</html>
