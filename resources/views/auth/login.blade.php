<!DOCTYPE html>
<html lang="th" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ - MUT NOC Cloud VPS</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    html:not(.dark) {
      color-scheme: light;
    }
    html:not(.dark) body {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .bg-\[\#0b0f19\] {
      background-color: #f1f5f9 !important;
    }
    html:not(.dark) .bg-\[\#101726\],
    html:not(.dark) .bg-\[\#111827\] {
      background-color: #ffffff !important;
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.08), 0 2px 4px -2px rgb(0 0 0 / 0.08) !important;
    }
    html:not(.dark) .border-\[\#1a2336\],
    html:not(.dark) .border-\[\#1d2a44\],
    html:not(.dark) .border-\[\#1f293d\] {
      border-color: #e2e8f0 !important;
    }
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
    html:not(.dark) .text-blue-400 {
      color: #2563eb !important;
    }
    html:not(.dark) .text-amber-400 {
      color: #d97706 !important;
    }
    html:not(.dark) .bg-slate-800,
    html:not(.dark) [class*="bg-slate-800"] {
      background-color: #f1f5f9 !important;
      color: #1e293b !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) .bg-slate-800:hover,
    html:not(.dark) [class*="bg-slate-800"]:hover,
    html:not(.dark) #themeBtnLogin:hover {
      background-color: #e2e8f0 !important;
      border-color: #94a3b8 !important;
      color: #0f172a !important;
    }
    html:not(.dark) button[onclick*="closeModal"] {
      background-color: #f1f5f9 !important;
      border: 1px solid #cbd5e1 !important;
      color: #475569 !important;
    }
    html:not(.dark) button[onclick*="closeModal"]:hover {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .border-slate-800,
    html:not(.dark) .border-slate-700 {
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input {
      background-color: #ffffff !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input::placeholder {
      color: #94a3b8 !important;
    }
    html:not(.dark) button.bg-blue-600,
    html:not(.dark) a.bg-blue-600,
    html:not(.dark) button.bg-blue-600 *,
    html:not(.dark) a.bg-blue-600 *,
    html:not(.dark) .bg-gradient-to-tr,
    html:not(.dark) .bg-gradient-to-tr * {
      color: #ffffff !important;
    }
  </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex items-center justify-center p-4 selection:bg-blue-600 selection:text-white antialiased relative transition-colors duration-200">

  <div class="absolute top-4 right-4">
    <button type="button" onclick="toggleTheme()" id="themeBtnLogin"
      class="px-3 py-1.5 rounded-xl border border-slate-700 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium flex items-center gap-2 transition shadow-sm"
      title="Theme">
      <i class="fa-solid fa-sun text-amber-400 theme-icon-sun"></i>
      <i class="fa-solid fa-moon text-blue-400 theme-icon-moon" style="display: none;"></i>
      <span class="theme-text text-[11px] font-mono">Theme</span>
    </button>
  </div>

  <div class="max-w-md w-full space-y-6">
    
    <div class="text-center space-y-2">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-700 via-red-600 to-rose-500 flex items-center justify-center text-white text-3xl font-black mx-auto shadow-xl shadow-red-600/30">
        MUT
      </div>
      <h1 class="text-xl font-bold text-white tracking-tight">MUT CLOUD VPS PROVISIONING</h1>
      <p class="text-xs text-slate-400 font-mono">NOC อาคาร Q ชั้น 1</p>
    </div>

    <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-6 sm:p-8 shadow-2xl space-y-5">
      
      <div class="pb-3 border-b border-slate-800 flex items-center justify-between">
        <div>
          <h2 class="text-sm font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-right-to-bracket text-blue-400"></i> เข้าสู่ระบบสถาบัน
          </h2>
        </div>
      </div>

      @if(isset($errors) && $errors->any())
        <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs space-y-1">
          <div class="font-bold flex items-center gap-1.5">
            <i class="fa-solid fa-circle-exclamation"></i> ไม่สามารถเข้าสู่ระบบได้:
          </div>
          <ul class="list-disc list-inside text-[11px] text-rose-300">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('status'))
        <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs flex items-center gap-2">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <form action="{{ route('login.submit') }}" method="POST" class="space-y-4 text-xs">
        @csrf

        <div>
          <label class="block text-slate-300 font-medium mb-1.5">Email (@mut.ac.th):</label>
          <div class="relative">
            <input type="email" name="email" required 
              placeholder="username@mut.ac.th" 
              value="{{ old('email') }}"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2.5 text-white font-mono outline-none focus:border-blue-500 transition">
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 text-xs">
              <i class="fa-solid fa-envelope"></i>
            </span>
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-slate-300 font-medium">Password:</label>
            <button type="button" onclick="openModal('modalForgotPwd')" class="text-[11px] text-blue-400 hover:underline">
              Forgot Password?
            </button>
          </div>
          <div class="relative">
            <input type="password" id="inputLoginPassword" name="password" required 
              placeholder="••••••••" value=""
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl pl-3 pr-10 py-2.5 text-white font-mono outline-none focus:border-blue-500 transition">
            <button type="button" onclick="togglePasswordVisibility('inputLoginPassword', 'eyeLoginIcon')" 
              class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white">
              <i id="eyeLoginIcon" class="fa-solid fa-eye text-xs"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center gap-2 cursor-pointer text-slate-400 text-[11px]">
            <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-900 text-blue-600">
            <span>Remember me</span>
          </label>
        </div>

        <button type="submit" 
          class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 transition flex items-center justify-center gap-2">
          <i class="fa-solid fa-arrow-right-to-bracket"></i>
          <span>Sign In</span>
        </button>
      </form>

      <div class="pt-3 border-t border-slate-800/80 text-center text-xs text-slate-400">
        ยังไม่มีบัญชีสถาบัน? 
        <a href="{{ route('register') }}" class="text-blue-400 font-bold hover:underline">Register</a>
      </div>

    </div>

  </div>

  <div id="modalForgotPwd" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-[#1f293d] rounded-2xl max-w-md w-full p-6 space-y-4 text-xs shadow-2xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="font-bold text-sm text-white flex items-center gap-2">
          <i class="fa-solid fa-key text-amber-400"></i> Reset Password
        </h3>
        <button onclick="closeModal('modalForgotPwd')" class="text-slate-400 hover:text-white text-base">&times;</button>
      </div>

      <p class="text-slate-400 text-[11px] leading-relaxed">
        กรอกอีเมลสถาบัน (@mut.ac.th) เพื่อรับลิงก์รีเซ็ตรหัสผ่าน
      </p>

      <form action="{{ route('forgot-password.submit') }}" method="POST" class="space-y-3">
        @csrf
        <div>
          <label class="block text-slate-300 font-medium mb-1">Email (@mut.ac.th):</label>
          <input type="email" name="email" required placeholder="username@mut.ac.th" value="{{ old('email') }}"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2.5 text-white font-mono outline-none focus:border-blue-500">
        </div>

        <div class="pt-2 border-t border-slate-800 flex justify-end gap-2">
          <button type="button" onclick="closeModal('modalForgotPwd')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow flex items-center gap-1.5">
            <i class="fa-solid fa-paper-plane"></i> Send Reset Link
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    function togglePasswordVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
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
      document.querySelectorAll('.theme-text').forEach(el => el.innerText = isDark ? 'Theme' : 'Theme');
    }
    document.addEventListener('DOMContentLoaded', updateThemeUI);
  </script>
</body>
</html>
