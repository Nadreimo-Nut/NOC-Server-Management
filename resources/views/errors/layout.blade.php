<!DOCTYPE html>
<html lang="th" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - MUT NOC Cloud VPS</title>
  
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

    html:not(.dark) body {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }
    html:not(.dark) .bg-\[\#101726\] {
      background-color: #ffffff !important;
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.08) !important;
    }
    html:not(.dark) .border-\[\#1d2a44\] {
      border-color: #e2e8f0 !important;
    }
    html:not(.dark) .text-white {
      color: #0f172a !important;
    }
    html:not(.dark) .text-slate-400 {
      color: #64748b !important;
    }
  </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-blue-600 selection:text-white">

  <div class="max-w-md w-full text-center space-y-6">
    
    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-700 via-red-600 to-rose-500 flex items-center justify-center text-white text-3xl font-black mx-auto shadow-xl shadow-red-600/30">
      MUT
    </div>

    <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-8 shadow-2xl space-y-4">
      <div class="text-5xl font-black font-mono @yield('code_color', 'text-amber-400')">
        @yield('code')
      </div>
      <h1 class="text-lg font-bold text-white">
        @yield('message')
      </h1>
      <p class="text-xs text-slate-400 leading-relaxed">
        @yield('description')
      </p>

      <div class="pt-4 border-t border-slate-800">
        <a href="{{ url('/') }}" 
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs rounded-xl shadow-lg transition">
          <i class="fa-solid fa-house"></i>
          <span>กลับสู่หน้าหลักของระบบ</span>
        </a>
    </div>

  </div>

</body>
</html>
