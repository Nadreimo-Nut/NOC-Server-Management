<!DOCTYPE html>
<html lang="th" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MUT NOC Cloud VPS</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
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
    html:not(.dark) .text-emerald-400 {
      color: #059669 !important;
    }
    html:not(.dark) .bg-slate-800,
    html:not(.dark) [class*="bg-slate-800"] {
      background-color: #f1f5f9 !important;
      color: #1e293b !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) .bg-slate-800:hover,
    html:not(.dark) [class*="bg-slate-800"]:hover,
    html:not(.dark) #themeBtnRegister:hover {
      background-color: #e2e8f0 !important;
      border-color: #94a3b8 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .border-slate-800,
    html:not(.dark) .border-slate-700 {
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input,
    html:not(.dark) select {
      background-color: #ffffff !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
    html:not(.dark) input::placeholder {
      color: #94a3b8 !important;
    }
    html:not(.dark) button.bg-emerald-600,
    html:not(.dark) a.bg-emerald-600,
    html:not(.dark) button.bg-emerald-600 *,
    html:not(.dark) a.bg-emerald-600 *,
    html:not(.dark) .bg-gradient-to-tr,
    html:not(.dark) .bg-gradient-to-tr * {
      color: #ffffff !important;
    }
  </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex items-center justify-center p-4 selection:bg-blue-600 selection:text-white antialiased relative transition-colors duration-200">

  <div class="absolute top-4 right-4">
    <button type="button" onclick="toggleTheme()" id="themeBtnRegister"
      class="px-3 py-1.5 rounded-xl border border-slate-700 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium flex items-center gap-2 transition shadow-sm"
      title="Theme">
      <i class="fa-solid fa-sun text-amber-400 theme-icon-sun"></i>
      <i class="fa-solid fa-moon text-blue-400 theme-icon-moon" style="display: none;"></i>
      <span class="theme-text text-[11px] font-mono">Theme</span>
    </button>
  </div>

  <div class="max-w-lg w-full space-y-6">
    
    <div class="text-center space-y-2">
      <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-red-700 via-red-600 to-rose-500 flex items-center justify-center text-white text-2xl font-black mx-auto shadow-xl shadow-red-600/30">
        MUT
      </div>
      <h1 class="text-xl font-bold text-white tracking-tight">ลงทะเบียนสมาชิกใหม่</h1>
      <p class="text-xs text-slate-400 font-mono">Cloud VPS Quota (1 Instance)</p>
    </div>

    <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-6 sm:p-8 shadow-2xl space-y-5">
      
      <div class="pb-3 border-b border-slate-800 flex items-center justify-between">
        <h2 class="text-sm font-bold text-white flex items-center gap-2">
          <i class="fa-solid fa-user-plus text-emerald-400"></i> กรอกข้อมูลสมาชิกสถาบัน
        </h2>
      </div>

      @if(isset($errors) && $errors->any())
        <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs space-y-1">
          <div class="font-bold flex items-center gap-1.5">
            <i class="fa-solid fa-circle-exclamation"></i> ไม่สามารถลงทะเบียนได้:
          </div>
          <ul class="list-disc list-inside text-[11px] text-rose-300">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('register.submit') }}" method="POST" class="space-y-3.5 text-xs">
        @csrf

        <div>
          <label class="block text-slate-300 font-medium mb-1">ชื่อ - นามสกุล:</label>
          <input type="text" name="name" required 
            placeholder="เช่น สมศักดิ์ รักเรียน" 
            value="{{ old('name') }}"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500 transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">คณะ / สังกัด:</label>
            <select name="department" required class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500 transition">
              <option value="คณะวิศวกรรมศาสตร์">คณะวิศวกรรมศาสตร์</option>
              <option value="คณะวิทยาการและเทคโนโลยีสารสนเทศ">คณะวิทยาการและเทคโนโลยีสารสนเทศ</option>
              <option value="สำนักพัฒนาระบบเครือข่ายคอมพิวเตอร์ (NOC)">สำนักพัฒนาระบบเครือข่าย (NOC)</option>
              <option value="คณะบริหารธุรกิจ">คณะบริหารธุรกิจ</option>
            </select>
          </div>
          <div>
            <label class="block text-slate-300 font-medium mb-1">สถานะผู้ใช้งาน:</label>
            <select name="academic_role" required class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500 transition">
              <option value="student">นักศึกษา (Student)</option>
              <option value="lecturer">อาจารย์ (Lecturer)</option>
              <option value="researcher">นักวิจัย (Researcher)</option>
              <option value="staff">บุคลากร (Staff)</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-slate-300 font-medium mb-1">Email (@mut.ac.th):</label>
          <input type="email" name="email" required 
            placeholder="username@mut.ac.th" 
            value="{{ old('email') }}"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500 transition">
          <span class="text-[10px] text-slate-500 mt-1 block font-mono">
            ใช้อีเมลมหาวิทยาลัย @mut.ac.th เท่านั้น
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">Password (>= 8 ตัวอักษร):</label>
            <div class="relative">
              <input type="password" id="inputRegPassword" name="password" required 
                placeholder="••••••••"
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl pl-3 pr-10 py-2 text-white font-mono outline-none focus:border-blue-500 transition">
              <button type="button" onclick="togglePasswordVisibility('inputRegPassword', 'eyeReg1')" 
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white">
                <i id="eyeReg1" class="fa-solid fa-eye text-xs"></i>
              </button>
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-medium mb-1">Confirm Password:</label>
            <div class="relative">
              <input type="password" id="inputRegConfirm" name="password_confirmation" required 
                placeholder="••••••••"
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl pl-3 pr-10 py-2 text-white font-mono outline-none focus:border-blue-500 transition">
              <button type="button" onclick="togglePasswordVisibility('inputRegConfirm', 'eyeReg2')" 
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white">
                <i id="eyeReg2" class="fa-solid fa-eye text-xs"></i>
              </button>
            </div>
          </div>
        </div>

        <button type="submit" 
          class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2">
          <i class="fa-solid fa-user-check"></i>
          <span>Register</span>
        </button>
      </form>

      <div class="pt-2 text-center text-xs text-slate-400 border-t border-slate-800">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:underline">Sign In</a>
      </div>

    </div>

  </div>

  <script>
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
