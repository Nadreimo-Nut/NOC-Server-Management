@extends('layouts.app')

@section('title', 'จัดการเครื่อง Cloud VPS ของฉัน - MUT NOC')
@section('breadcrumb', 'Member Portal')
@section('header_title', 'จัดการเครื่อง Server และบริการสถาบัน')

@section('content')

    @if(($currentTab ?? 'instances') === 'instances')
    
    @if($vm)
            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-6 space-y-6 shadow-xl">
        
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-[#1a2336]">
          <div class="flex items-start gap-4">
            @php
              $vmOs = strtolower($vm->os ?? '');
              $isDebian = str_contains($vmOs, 'debian');
              $isRocky = str_contains($vmOs, 'rocky') || str_contains($vmOs, 'redhat');
              $isWindows = str_contains($vmOs, 'windows');
            @endphp
            <div class="w-14 h-14 rounded-2xl {{ $isDebian ? 'bg-rose-500/10 border-rose-500/20 text-rose-500' : ($isRocky ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : ($isWindows ? 'bg-blue-500/10 border-blue-500/20 text-blue-400' : 'bg-orange-500/10 border-orange-500/20 text-orange-400')) }} border flex items-center justify-center text-3xl shrink-0">
              @if($isDebian)
                <i class="devicon-debian-plain text-rose-500 text-3xl"></i>
              @elseif($isRocky)
                <i class="fa-brands fa-redhat text-emerald-400"></i>
              @elseif($isWindows)
                <i class="fa-brands fa-windows text-blue-400"></i>
              @else
                <i class="fa-brands fa-ubuntu text-orange-400"></i>
              @endif
            </div>
            <div>
              <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-xl font-bold text-white font-mono">{{ $vm->hostname }}</h2>
                @if($vm->isRunning())
                  <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    RUNNING (ปกติ)
                  </span>
                @else
                  <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-rose-500/15 text-rose-400 border border-rose-500/30 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                    STOPPED (ปิดการทำงาน)
                  </span>
                @endif
                <span class="text-xs text-slate-400 font-mono">VMID: <strong class="text-slate-200">{{ $vm->vmid }}</strong></span>
              </div>
              <div class="text-xs text-slate-400 mt-1.5 flex items-center gap-2 flex-wrap font-mono">
                <span>โหนด: <strong class="text-slate-300">{{ $vm->node }}</strong></span>
                <span class="text-slate-600">•</span>
                <span>OS: <strong class="text-slate-300">{{ $vm->os }}</strong></span>
                <span class="text-slate-600">•</span>
                <span>IP ภายใน: <strong class="text-blue-400 font-bold">{{ $vm->ip_address }}</strong></span>
              </div>
            </div>
          </div>

                    <div class="flex items-center gap-2 flex-wrap">
            <form action="{{ route('member.vm.power') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="px-3.5 py-2 {{ $vm->isRunning() ? 'bg-rose-600/90 hover:bg-rose-600' : 'bg-emerald-600 hover:bg-emerald-500' }} text-white text-xs font-semibold rounded-xl shadow transition flex items-center gap-1.5">
                <i class="fa-solid fa-power-off"></i> <span>{{ $vm->isRunning() ? 'Power Off' : 'Power On' }}</span>
              </button>
            </form>

            <form action="{{ route('member.vm.reboot') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-xl border border-slate-700 shadow transition flex items-center gap-1.5">
                <i class="fa-solid fa-rotate-right text-blue-400"></i> Reboot
              </button>
            </form>

            <button type="button" onclick="openModal('modalTerminal')" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl shadow transition flex items-center gap-1.5">
              <i class="fa-solid fa-terminal"></i> noVNC Console
            </button>
          </div>
        </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 font-mono">
          
          <div class="bg-[#0b101c] border border-slate-800/80 rounded-xl p-4 space-y-2">
            <div class="flex justify-between items-center text-xs">
              <span class="text-slate-400">CPU Usage:</span>
              <span class="text-emerald-400 font-bold">{{ $vm->isRunning() ? $vm->cpu_load : '0.0%' }}</span>
            </div>
            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
              <div class="bg-emerald-500 h-full transition-all duration-700" style="width: {{ $vm->isRunning() ? '24%' : '0%' }}"></div>
            </div>
            <div class="text-[10px] text-slate-500">2 vCores (AMD EPYC™ 7742)</div>
          </div>

          <div class="bg-[#0b101c] border border-slate-800/80 rounded-xl p-4 space-y-2">
            <div class="flex justify-between items-center text-xs">
              <span class="text-slate-400">Memory (RAM):</span>
              <span class="text-indigo-400 font-bold">{{ $vm->isRunning() ? $vm->ram_load : '0.0 / 2.0 GB' }}</span>
            </div>
            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
              <div class="bg-indigo-500 h-full transition-all duration-700" style="width: {{ $vm->isRunning() ? '45%' : '0%' }}"></div>
            </div>
            <div class="text-[10px] text-slate-500">2.0 GB ECC DDR4 Allocation</div>
          </div>

          <div class="bg-[#0b101c] border border-slate-800/80 rounded-xl p-4 space-y-2">
            <div class="flex justify-between items-center text-xs">
              <span class="text-slate-400">NVMe ZFS Storage:</span>
              <span class="text-amber-400 font-bold">4.2 / 100 GB</span>
            </div>
            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
              <div class="bg-amber-500 h-full" style="width: 4.2%"></div>
            </div>
            <div class="text-[10px] text-slate-500">Enterprise ZFS Thin-Provisioning</div>
          </div>

        </div>

                <div class="bg-[#0b0f19] border border-slate-800 rounded-xl p-4 space-y-3 font-mono text-xs">
          <div class="flex items-center justify-between">
            <div class="text-slate-400 font-bold flex items-center gap-2">
              <i class="fa-solid fa-key text-blue-400"></i> ข้อมูลการเชื่อมต่อเครื่องผ่าน SSH ภายในมหาวิทยาลัย
            </div>
            <span class="text-[10px] text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">Active Internal Route</span>
          </div>

          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-2.5 rounded-lg bg-[#0e1424] border border-slate-800">
            <code class="text-emerald-400 select-all" id="textSshCommand">{{ $vm->ssh_command }}</code>
            <div class="flex items-center gap-2 shrink-0">
              <button type="button" onclick="navigator.clipboard.writeText('{{ $vm->ssh_command }}'); Swal.fire({icon:'success', title:'คัดลอกคำสั่งแล้ว', timer:1000, showConfirmButton:false})" 
                class="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] transition flex items-center gap-1">
                <i class="fa-solid fa-copy"></i> Copy
              </button>
              <button type="button" onclick="downloadSshKey()" 
                class="px-2.5 py-1 bg-blue-600/80 hover:bg-blue-600 text-white rounded text-[11px] transition flex items-center gap-1">
                <i class="fa-solid fa-download"></i> Private Key
              </button>
            </div>
          </div>
        </div>

                <div class="pt-4 border-t border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div>
            <div class="font-bold text-xs text-rose-400 flex items-center gap-1.5">
              <i class="fa-solid fa-trash-can"></i> ลบเครื่อง Server และคืน Quota
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">การลบเครื่องจะปลดปล่อยทรัพยากรบนโหนด PVE และคืน Quota ให้คุณสามารถเพิ่มเครื่อง Server ใหม่ได้</div>
          </div>
          
          <form action="{{ route('member.vm.delete') }}" method="POST" id="formDeleteVm" onsubmit="return confirmDelete(event)">
            @csrf
            <button type="submit" class="px-4 py-2 bg-rose-600/80 hover:bg-rose-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-1.5 shadow">
              <i class="fa-solid fa-trash-can"></i> คืน Quota และลบเครื่องนี้
            </button>
          </form>
        </div>

      </div>

    @else
            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-12 text-center space-y-4 shadow-xl">
        <div class="w-16 h-16 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-3xl mx-auto shadow-lg">
          <i class="fa-solid fa-server"></i>
        </div>
        <h3 class="text-lg font-bold text-white">คุณยังไม่มีเครื่อง Cloud VPS ในขณะนี้</h3>
        <p class="text-xs text-slate-400 max-w-md mx-auto leading-relaxed">
          คุณได้รับ Quota จำนวน <strong>1 เครื่อง</strong> สามารถเลือกโหนดคลัสเตอร์ฮาร์ดแวร์และระบบปฏิบัติการเพื่อเพิ่มเครื่อง Server ได้ทันที
        </p>
        <div class="pt-2">
          <a href="{{ route('member.dashboard', ['tab' => 'new-vm']) }}" 
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/20 transition inline-flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Deploy ({{ $user->used_quota }}/{{ $user->quota_max ?? 1 }})
          </a>
        </div>
      </div>
    @endif

    @elseif(($currentTab ?? '') === 'new-vm')

    @if($user->hasAvailableQuota())
      <div class="space-y-6">
        
        <div class="pb-3 border-b border-[#1a2336] flex items-center justify-between">
          <div>
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
              <i class="fa-solid fa-microchip text-blue-400"></i> การเพิ่มเครื่อง Server (Deploy Server)
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">เลือกโหนดคลัสเตอร์ฮาร์ดแวร์, เลือกระบบปฏิบัติการ และสั่งสร้างเครื่องแบบอัตโนมัติ</p>
          </div>
          <span class="px-2.5 py-1 rounded-lg text-xs font-mono bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold">Quota ว่าง 1/1</span>
        </div>

        <form action="{{ route('member.vm.deploy') }}" method="POST" class="space-y-6">
          @csrf

                    <div class="space-y-3">
            <label class="block text-xs font-bold text-slate-200 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">1</span>
              เลือกคลัสเตอร์โหนดฮาร์ดแวร์กายภาพ (Compute Pool Nodes):
            </label>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
              @foreach($nodes as $key => $node)
                @php $isFull = ($node['status'] === 'FULL'); @endphp
                <label class="relative p-4 rounded-xl border transition cursor-pointer {{ $isFull ? 'bg-[#0e1422] border-slate-800 opacity-60 cursor-not-allowed' : 'bg-[#0b0f19] border-[#1f293d] hover:border-blue-500' }}">
                  <input type="radio" name="node" value="{{ $node['pool_name'] }}" {{ $key === 'pve-01' ? 'checked' : '' }} {{ $isFull ? 'disabled' : '' }} class="sr-only">
                  <div class="flex items-center justify-between mb-2">
                    <div class="font-bold text-xs text-white flex items-center gap-2">
                      <i class="fa-solid fa-server text-blue-400"></i>
                      <span>{{ $node['name'] }}</span>
                    </div>
                    <span class="text-[9px] font-bold px-2 py-0.5 rounded font-mono {{ $isFull ? 'bg-rose-500/20 text-rose-400' : 'bg-emerald-500/20 text-emerald-400' }}">
                      {{ $isFull ? 'โหนดเต็ม' : 'ว่างพร้อมจัดสรร' }}
                    </span>
                  </div>
                  <div class="text-[10px] text-slate-400 font-mono mb-2">{{ $node['location'] }}</div>
                  <div class="space-y-1 font-mono text-[10px] text-slate-400">
                    <div class="flex justify-between">
                      <span>จัดสรรแล้ว:</span>
                      <span>{{ $node['vms'] }} / {{ $node['max_vms'] }} เครื่อง</span>
                    </div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                      <div class="h-full {{ $isFull ? 'bg-rose-500' : 'bg-blue-500' }}" style="width: {{ ($node['vms'] / $node['max_vms']) * 100 }}%"></div>
                    </div>
                  </div>
                </label>
              @endforeach
            </div>
          </div>

                    <div class="space-y-3">
            <label class="block text-xs font-bold text-slate-200 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">2</span>
              เลือกระบบปฏิบัติการมาตรฐาน (OS Golden Templates):
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
              @foreach($osTemplates as $idx => $os)
                <label class="p-4 rounded-xl bg-[#0b0f19] border border-[#1f293d] hover:border-blue-500 transition cursor-pointer space-y-2">
                  <input type="radio" name="os" value="{{ $os['name'] }}" {{ $idx === 0 ? 'checked' : '' }} class="sr-only">
                  <div class="flex items-center gap-3">
                    <i class="{{ $os['icon'] }} text-2xl"></i>
                    <div>
                      <div class="font-bold text-xs text-white">{{ $os['name'] }}</div>
                      <div class="text-[10px] text-slate-500 font-mono">{{ $os['specs'] }}</div>
                    </div>
                  </div>
                  <p class="text-[10px] text-slate-400 leading-relaxed">{{ $os['desc'] }}</p>
                </label>
              @endforeach
            </div>
          </div>

                    <div class="bg-[#0b0f19] border border-[#1f293d] rounded-2xl p-5 space-y-4">
            <label class="block text-xs font-bold text-slate-200 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">3</span>
              กำหนดชื่อประจำเครื่องและข้อมูลการศึกษา:
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
              <div>
                <label class="block text-slate-300 font-medium mb-1">ชื่อเครื่อง (Hostname ภาษาอังกฤษและขีดกลาง):</label>
                <input type="text" name="hostname" required placeholder="cpe-research-01" value="cpe-lab-node-01"
                  class="w-full bg-[#070a12] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
              </div>
              <div>
                <label class="block text-slate-300 font-medium mb-1">รอบการใช้งานตามปฏิทินการศึกษา:</label>
                <select name="term" class="w-full bg-[#070a12] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
                  <option value="ภาคเรียนที่ 1/2569">ภาคเรียนที่ 1/2569 (ปีการศึกษาปัจจุบัน)</option>
                  <option value="ภาคเรียนที่ 2/2569">ภาคเรียนที่ 2/2569</option>
                  <option value="โครงงานวิจัยตลอดปี 2569">โครงงานวิจัยตลอดปี 2569</option>
                </select>
              </div>
            </div>

            <div class="pt-2 flex items-center justify-between border-t border-slate-800">
              <label class="flex items-center gap-2 text-[11px] text-slate-400 cursor-pointer">
                <input type="checkbox" required checked class="rounded border-slate-700 bg-slate-900 text-blue-600">
                <span>ยอมรับระเบียบการใช้งานระบบเทคโนโลยีสารสนเทศ มหาวิทยาลัยเทคโนโลยีมหานคร</span>
              </label>

              <button type="submit" 
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/20 transition flex items-center gap-2">
                <i class="fa-solid fa-rocket"></i> ยืนยันการเพิ่มเครื่อง Server (Deploy)
              </button>
            </div>
          </div>

        </form>

      </div>
    @else
            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-8 text-center space-y-3">
        <i class="fa-solid fa-circle-exclamation text-amber-400 text-3xl"></i>
        <h3 class="text-base font-bold text-white">คุณได้ใช้ Quota ครบแล้ว (1/1)</h3>
        <p class="text-xs text-slate-400 max-w-md mx-auto">
          ปัจจุบันคุณกำลังถือครองเครื่อง <strong>{{ $vm->hostname ?? 'เครื่อง Server' }}</strong> หากต้องการเพิ่มเครื่องใหม่ กรุณากลับไปที่หน้า "เครื่อง Cloud VPS ของฉัน" และกดคืน Quota ก่อน
        </p>
        <div class="pt-2">
          <a href="{{ route('member.dashboard', ['tab' => 'instances']) }}" class="px-4 py-2 bg-slate-800 text-slate-200 text-xs font-semibold rounded-xl hover:bg-slate-700 transition">
            กลับไปที่หน้าเครื่องของฉัน
          </a>
        </div>
      </div>
    @endif

    @elseif(($currentTab ?? '') === 'public-access')

    <div class="space-y-6">
      
      <div class="pb-3 border-b border-[#1a2336] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-network-wired text-indigo-400"></i> บริการ Subdomain (*.mut.ac.th) และ Public IP DNAT
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">เปิดเส้นทางการเข้าถึงจากอินเทอร์เน็ตภายนอกผ่าน Nginx SSL Reverse Proxy และ Gateway Port Forwarding</p>
        </div>
        @if($user->hasActiveVm())
          <button type="button" onclick="openModal('modalDomainDnat')" 
            class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> ขอเปิดเส้นทางใหม่
          </button>
        @else
          <a href="{{ route('member.dashboard', ['tab' => 'new-vm']) }}" 
            class="px-3.5 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-bold rounded-xl transition flex items-center gap-1.5">
            <i class="fa-solid fa-triangle-exclamation"></i> กรุณาจัดสรรเครื่อง (Deploy) ก่อนขอเปิดบริการ
          </a>
        @endif
      </div>

      @if(!$user->hasActiveVm())
        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-center gap-3">
          <i class="fa-solid fa-circle-exclamation text-amber-400 text-lg shrink-0"></i>
          <div>
            <div class="font-bold">ยังไม่มีเครื่อง Cloud VPS ในระบบ</div>
            <div class="text-[11px] text-amber-200/80 mt-0.5">การขอชื่อ Subdomain หรือ Port Forwarding จำเป็นต้องมี IP เครื่อง Server ปลายทาง กรุณาไปที่เมนู <strong>"การเพิ่มเครื่อง Server (Deploy)"</strong> เพื่อสร้างเครื่องก่อน</div>
          </div>
        </div>
      @endif

            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs font-mono text-slate-300">
            <thead class="bg-[#0b101c] text-slate-400 uppercase text-[10px]">
              <tr>
                <th class="p-3">รหัสคำขอ</th>
                <th class="p-3">ประเภท</th>
                <th class="p-3">Public Endpoint (*.mut.ac.th / IP)</th>
                <th class="p-3">Internal Target</th>
                <th class="p-3">สถานะ SSL / Security</th>
                <th class="p-3">สถานะ</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#1a2336]">
              @forelse($accesses as $acc)
                <tr class="hover:bg-[#121929] transition">
                  <td class="p-3 font-bold text-blue-400">{{ $acc->req_code }}</td>
                  <td class="p-3 uppercase text-[10px] text-slate-400">{{ $acc->type }}</td>
                  <td class="p-3 text-emerald-400 font-bold select-all">{{ $acc->endpoint }}</td>
                  <td class="p-3 text-slate-300">{{ $acc->internal_target }}</td>
                  <td class="p-3 text-slate-400 text-[11px]">{{ $acc->ssl_status }}</td>
                  <td class="p-3">
                    @if($acc->status === 'approved')
                      <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold text-[10px]">Online</span>
                    @elseif($acc->status === 'pending')
                      <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-400 font-bold text-[10px]">Pending NOC</span>
                    @else
                      <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-bold text-[10px]">Rejected</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="p-6 text-center text-slate-500 font-sans">ยังไม่มีประวัติการขอเชื่อมต่อสาธารณะ</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    @elseif(($currentTab ?? '') === 'account')

    <div class="space-y-6">
      
      <div class="pb-3 border-b border-[#1a2336] flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-id-badge text-amber-400"></i> ข้อมูลสมาชิกและความปลอดภัย (Member Account & Security)
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">จัดการสถานะการยืนยันอีเมลสถาบัน, Quota และเปลี่ยนรหัสผ่าน</p>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-xs font-mono bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1.5">
          <i class="fa-solid fa-circle-check"></i> บัญชีปกติ (Active)
        </span>
      </div>

            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-6 shadow-xl space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
              <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="text-lg font-bold text-white">{{ $user->name }}</h3>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">{{ $user->academic_role }}</span>
              </div>
              <div class="text-xs text-blue-400 font-mono mt-0.5">{{ $user->email }}</div>
              <div class="text-xs text-slate-400 mt-0.5">{{ $user->department }}</div>
            </div>
          </div>
          <div class="text-left sm:text-right font-mono text-xs">
            <div class="text-slate-500 text-[10px]">รหัสสมาชิกสถาบัน</div>
            <div class="text-white font-bold">{{ $user->member_code ?? 'MUT-M0491' }}</div>
            <div class="text-emerald-400 text-[11px] mt-1">Quota: {{ $user->used_quota }}/{{ $user->quota_max ?? 1 }}</div>
          </div>
        </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-xs">
          
                    <div class="p-5 rounded-xl bg-[#0b101c] border border-slate-800 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800/80">
              <div class="font-bold text-slate-200 flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-blue-400 text-sm"></i>
                <span>แก้ไขข้อมูลโปรไฟล์ (Edit Profile)</span>
              </div>
              <span class="text-[10px] text-slate-500 font-mono">Personal Information</span>
            </div>

            <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-3">
              @csrf
              <div>
                <label class="block text-slate-300 font-medium mb-1">ชื่อ-นามสกุลจริง:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                  class="w-full bg-[#0d1322] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
              </div>

              <div>
                <label class="block text-slate-300 font-medium mb-1">สังกัดคณะ / สำนัก:</label>
                <input type="text" name="department" value="{{ old('department', $user->department) }}" required
                  class="w-full bg-[#0d1322] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
              </div>

              <div>
                <label class="block text-slate-300 font-medium mb-1">ตำแหน่งวิชาการ / สถานะ:</label>
                <select name="academic_role" class="w-full bg-[#0d1322] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
                  <option value="อาจารย์ / บุคลากร" {{ $user->academic_role === 'อาจารย์ / บุคลากร' ? 'selected' : '' }}>อาจารย์ / บุคลากร</option>
                  <option value="อาจารย์ประจำภาควิชา" {{ $user->academic_role === 'อาจารย์ประจำภาควิชา' ? 'selected' : '' }}>อาจารย์ประจำภาควิชา</option>
                  <option value="นักศึกษาโครงงานวิจัย" {{ $user->academic_role === 'นักศึกษาโครงงานวิจัย' ? 'selected' : '' }}>นักศึกษาโครงงานวิจัย</option>
                  <option value="นักศึกษาระดับปริญญาตรี" {{ $user->academic_role === 'นักศึกษาระดับปริญญาตรี' ? 'selected' : '' }}>นักศึกษาระดับปริญญาตรี</option>
                  <option value="นักศึกษาระดับบัณฑิตศึกษา" {{ $user->academic_role === 'นักศึกษาระดับบัณฑิตศึกษา' ? 'selected' : '' }}>นักศึกษาระดับบัณฑิตศึกษา</option>
                </select>
              </div>

              <div>
                <label class="block text-slate-400 font-medium mb-1">อีเมลสถาบัน (SSO Identifier):</label>
                <input type="email" value="{{ $user->email }}" disabled
                  class="w-full bg-[#090d17] border border-slate-800 rounded-xl px-3 py-2 text-slate-500 font-mono cursor-not-allowed">
                <span class="text-[10px] text-slate-500 mt-0.5 block">• บัญชีผูกกับโดเมน @mut.ac.th ของสถาบัน</span>
              </div>

              <div class="pt-2">
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
                  <i class="fa-solid fa-floppy-disk text-xs"></i>
                  <span>บันทึกการแก้ไขโปรไฟล์</span>
                </button>
              </div>
            </form>
          </div>

                    <div class="p-5 rounded-xl bg-[#0b101c] border border-slate-800 space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
              <div class="flex items-center justify-between pb-2 border-b border-slate-800/80">
                <div class="font-bold text-slate-200 flex items-center gap-2">
                  <i class="fa-solid fa-server text-emerald-400 text-sm"></i>
                  <span>Cloud VPS Quota</span>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/15 text-blue-400 border border-blue-500/30 flex items-center gap-1 font-mono">
                  <i class="fa-solid fa-cube"></i> {{ $user->hasActiveVm() ? '1 / 1 Used' : '0 / 1 Available' }}
                </span>
              </div>
              <p class="text-[11px] text-slate-400 leading-relaxed">
                Quota เครื่อง Server สูงสุด 1 เครื่อง บน Proxmox VE คลัสเตอร์ อาคาร Q ชั้น 1 (NOC Data Center)
              </p>
              <div class="p-3 bg-[#0d1322] rounded-xl border border-slate-800 font-mono text-[11px] space-y-1">
                <div class="text-slate-400">สถานะ: <span class="{{ $user->hasActiveVm() ? 'text-blue-400 font-bold' : 'text-emerald-400 font-bold' }}">{{ $user->hasActiveVm() ? 'In Use (1 Instance)' : 'Available' }}</span></div>
                <div class="text-slate-500">Spec: 2 vCPU • RAM 2 GB • SSD 100 GB</div>
              </div>
            </div>

            <div class="pt-3">
              @if($user->hasActiveVm())
                <div class="p-3 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-between">
                  <span class="flex items-center gap-2"><i class="fa-solid fa-desktop"></i> {{ $user->virtualMachine->hostname }}</span>
                  <a href="{{ route('member.dashboard', ['tab' => 'instances']) }}" class="text-xs hover:underline font-bold">ไปยังคอนโซล &rarr;</a>
                </div>
              @else
                <a href="{{ route('member.dashboard', ['tab' => 'new-vm']) }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-semibold transition flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-600/20">
                  <i class="fa-solid fa-plus-circle text-xs"></i> Deploy ({{ $user->used_quota }}/{{ $user->quota_max ?? 1 }})
                </a>
              @endif
            </div>
          </div>

        </div>

      </div>

      <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl p-6 shadow-xl space-y-4">
        <div class="pb-3 border-b border-slate-800 flex items-center justify-between">
          <div>
            <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
              <i class="fa-solid fa-key text-amber-400"></i> เปลี่ยนรหัสผ่าน (Change Password)
            </h3>
            <p class="text-[11px] text-slate-400 mt-0.5">ความยาวอย่างน้อย 8 ตัวอักษร</p>
          </div>
        </div>

        <form action="{{ route('member.change-password') }}" method="POST" class="space-y-3 text-xs max-w-xl">
          @csrf
          <div>
            <label class="block text-slate-300 font-medium mb-1">รหัสผ่านปัจจุบัน:</label>
            <input type="password" name="current_password" required placeholder="••••••••"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-medium mb-1">รหัสผ่านใหม่ (>= 8 ตัว):</label>
              <input type="password" name="password" required placeholder="••••••••"
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
            </div>
            <div>
              <label class="block text-slate-300 font-medium mb-1">ยืนยันรหัสผ่านใหม่:</label>
              <input type="password" name="password_confirmation" required placeholder="••••••••"
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
            </div>
          </div>

          <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow transition flex items-center gap-1.5">
              <i class="fa-solid fa-floppy-disk"></i> บันทึกรหัสผ่านใหม่
            </button>
          </div>
        </form>
      </div>

    </div>

  @endif

    <div id="modalTerminal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#0b0f19] border border-[#1f293d] rounded-2xl max-w-2xl w-full p-4 space-y-3 font-mono shadow-2xl">
      <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div class="flex items-center gap-2 text-xs">
          <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
          <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
          <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
          <span class="text-slate-300 font-bold ml-2">noVNC Console • {{ $vm->hostname ?? 'cpe-ai-research-01' }} (VMID: {{ $vm->vmid ?? 104 }})</span>
        </div>
        <button type="button" onclick="closeModal('modalTerminal')" class="text-slate-400 hover:text-white text-base">&times;</button>
      </div>
      
      <div id="termOutput" class="h-64 overflow-y-auto bg-black/60 p-3 rounded-xl border border-slate-800/80 text-[11px] text-slate-300 space-y-1.5">
        <div class="text-emerald-400">Connected to Proxmox VE Serial Console (xterm.js)...</div>
        <div class="text-slate-500">Linux {{ $vm->hostname ?? 'cpe-ai-research-01' }} 5.15.0-107-generic #117-MUT-Ubuntu SMP</div>
        <div class="text-slate-400">Type <span class="text-amber-300 font-bold">help</span> for available commands (uptime, ip a, free -m, clear)</div>
      </div>

      <div class="flex items-center gap-2 bg-[#050810] border border-slate-800 rounded-xl px-3 py-2 text-xs">
        <span class="text-emerald-400 font-bold">root@{{ $vm->hostname ?? 'cpe-node' }}:~#</span>
        <input type="text" id="termInput" onkeydown="handleTerminalCommand(event)" placeholder="พิมพ์คำสั่ง Linux แล้วกด Enter..." 
          class="flex-1 bg-transparent border-none text-white outline-none font-mono text-xs">
      </div>
    </div>
  </div>

    <div id="modalDomainDnat" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-[#1f293d] rounded-2xl max-w-lg w-full p-6 space-y-4 text-xs shadow-2xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="font-bold text-sm text-white flex items-center gap-2">
          <i class="fa-solid fa-network-wired text-indigo-400"></i> ขอเปิดเส้นทาง Subdomain (*.mut.ac.th) / Port DNAT
        </h3>
        <button type="button" onclick="closeModal('modalDomainDnat')" class="text-slate-400 hover:text-white text-base">&times;</button>
      </div>

      <form action="{{ route('member.dnat.store') }}" method="POST" class="space-y-4">
        @csrf

                <div class="p-3 bg-[#0b0f19] border border-slate-800 rounded-xl text-xs flex items-center justify-between">
          <div>
            <div class="text-[11px] text-slate-400">เครื่องเป้าหมายปลายทาง (Internal Target):</div>
            <div class="font-mono font-bold text-slate-200 mt-0.5">
              {{ $vm->hostname ?? 'ไม่มีเครื่อง VM' }} 
              <span class="text-emerald-400">({{ $vm->ip_address ?? '10.20.155.x' }})</span>
            </div>
          </div>
          <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-blue-500/20 text-blue-400 border border-blue-500/30 font-bold">MUT LAN</span>
        </div>

        <div class="grid grid-cols-2 gap-2 p-1 bg-[#0b0f19] border border-slate-800 rounded-xl text-center">
          <label class="py-2 px-3 rounded-lg font-bold cursor-pointer text-white bg-indigo-600 shadow" id="tabSubdomainBtn">
            <input type="radio" name="type" value="subdomain" checked onchange="switchDnatType('subdomain')" class="sr-only">
            ขอ Subdomain (*.mut.ac.th)
          </label>
          <label class="py-2 px-3 rounded-lg font-bold cursor-pointer text-slate-400 hover:text-white" id="tabDnatBtn">
            <input type="radio" name="type" value="dnat" onchange="switchDnatType('dnat')" class="sr-only">
            ขอ Port DNAT (TCP)
          </label>
        </div>

                <div id="secSubdomain" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">ชื่อ Subdomain ที่ต้องการ (*.mut.ac.th):</label>
            <div class="flex items-center">
              <span class="px-3 py-2 bg-slate-800 text-slate-400 border border-r-0 border-slate-700 rounded-l-xl font-mono">https://</span>
              <input type="text" name="subdomain_prefix" placeholder="cpe-ai-research" value="{{ old('subdomain_prefix') }}"
                class="flex-1 bg-[#0b0f19] border border-slate-700 px-3 py-2 text-white font-mono outline-none focus:border-indigo-500">
              <span class="px-3 py-2 bg-slate-800 text-slate-400 border border-l-0 border-slate-700 rounded-r-xl font-mono">.mut.ac.th</span>
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-medium mb-1">พอร์ตของเครื่อง Server เสมือนที่ให้บริการเว็บ:</label>
            <select name="subdomain_port" class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none">
              <option value="80">Port 80 (HTTP Web Standard)</option>
              <option value="8080">Port 8080 (API Service / Node.js / Python)</option>
              <option value="3000">Port 3000 (React / Vue Frontend)</option>
              <option value="8000">Port 8000 (Laravel Development)</option>
            </select>
          </div>
        </div>

                <div id="secDnat" class="hidden space-y-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">เลือกพอร์ตภายในที่ต้องการเปิดเชื่อมต่อ:</label>
            <select name="dnat_port" class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none">
              <option value="22">Port 22 (SSH Remote Administration)</option>
              <option value="3389">Port 3389 (RDP Windows Remote Desktop)</option>
              <option value="3306">Port 3306 (MySQL Database Direct)</option>
              <option value="5432">Port 5432 (PostgreSQL Direct)</option>
            </select>
            <span class="text-[10px] text-slate-500 mt-1 block font-mono">ระบบจะสุ่มพอร์ตสาธารณะส่วนกลาง เช่น 202.28.15.20:2200x ให้โดยอัตโนมัติ</span>
          </div>
        </div>

        <div>
          <label class="block text-slate-300 font-medium mb-1">วัตถุประสงค์ในการขอใช้งาน:</label>
          <input type="text" name="purpose" required placeholder="งานวิจัยโครงงานวิศวกรรมคอมพิวเตอร์ / พัฒนาระบบเพื่อการเรียนการสอน" value="{{ old('purpose') }}"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-indigo-500">
        </div>

        <div class="pt-2 border-t border-slate-800 flex justify-end gap-2">
          <button type="button" onclick="closeModal('modalDomainDnat')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl">ยกเลิก</button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow flex items-center gap-1.5">
            <i class="fa-solid fa-paper-plane"></i> ส่งคำขอไปยังเจ้าหน้าที่ NOC
          </button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  function switchDnatType(type) {
    const tabSub = document.getElementById('tabSubdomainBtn');
    const tabDnat = document.getElementById('tabDnatBtn');
    const secSub = document.getElementById('secSubdomain');
    const secDnat = document.getElementById('secDnat');
    if (type === 'subdomain') {
      tabSub.className = 'py-2 px-3 rounded-lg font-bold cursor-pointer text-white bg-indigo-600 shadow';
      tabDnat.className = 'py-2 px-3 rounded-lg font-bold cursor-pointer text-slate-400 hover:text-white';
      secSub.classList.remove('hidden');
      secDnat.classList.add('hidden');
    } else {
      tabDnat.className = 'py-2 px-3 rounded-lg font-bold cursor-pointer text-white bg-indigo-600 shadow';
      tabSub.className = 'py-2 px-3 rounded-lg font-bold cursor-pointer text-slate-400 hover:text-white';
      secDnat.classList.remove('hidden');
      secSub.classList.add('hidden');
    }
  }

  function confirmDelete(e) {
    e.preventDefault();
    Swal.fire({
      title: 'ยืนยันคืน Quota และลบเครื่อง?',
      text: 'เครื่อง Server เสมือนจะถูกลบออกจากคลัสเตอร์ Proxmox VE และคืน Quota กลับสู่บัญชีของคุณทันที',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#475569',
      confirmButtonText: 'ใช่, สั่งลบเครื่อง',
      cancelButtonText: 'ยกเลิก'
    }).then((res) => {
      if (res.isConfirmed) {
        document.getElementById('formDeleteVm').submit();
      }
    });
    return false;
  }

  function downloadSshKey() {
    const keyContent = `-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAAAMwAAAAtzc2gtZW
QyNTUxOQAAACB8mutNOCMUT...MUT-NOC-ED25519-ACADEMIC-KEY...
-----END OPENSSH PRIVATE KEY-----`;
    const blob = new Blob([keyContent], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'id_ed25519_mut_vps';
    a.click();
    window.URL.revokeObjectURL(url);
    Swal.fire({ icon: 'success', title: 'ดาวน์โหลดสำเร็จ', text: 'บันทึกไฟล์ id_ed25519_mut_vps ลงในเครื่องแล้ว', timer: 1500, showConfirmButton: false });
  }

  function handleTerminalCommand(e) {
    if (e.key === 'Enter') {
      const cmd = e.target.value.trim().toLowerCase();
      e.target.value = '';
      const out = document.getElementById('termOutput');
      out.innerHTML += `<div><span class="text-emerald-400 font-bold">root@cpe-ai-research-01:~#</span> <span class="text-white">${cmd}</span></div>`;

      if (cmd === 'uptime') {
        out.innerHTML += `<div class="text-slate-300"> 10:45:12 up 3 days, 12:20, 1 user, load average: 0.05, 0.03, 0.01</div>`;
      } else if (cmd === 'free -m' || cmd === 'free') {
        out.innerHTML += `<div class="text-slate-300">              total        used        free      shared  buff/cache   available<br>Mem:           2048         512        1120          12         416        1410<br>Swap:             0           0           0</div>`;
      } else if (cmd === 'ip a') {
        out.innerHTML += `<div class="text-slate-300">1: lo: &lt;LOOPBACK,UP&gt; inet 127.0.0.1/8<br>2: eth0: &lt;BROADCAST,MULTICAST,UP&gt; inet 10.20.155.4/24 brd 10.20.155.255</div>`;
      } else if (cmd === 'clear') {
        out.innerHTML = '';
      } else if (cmd === 'help') {
        out.innerHTML += `<div class="text-amber-300">Available: help, uptime, ip a, free -m, clear</div>`;
      } else {
        out.innerHTML += `<div class="text-red-400">bash: ${cmd}: command not found. Type 'help' for options.</div>`;
      }
      out.scrollTop = out.scrollHeight;
    }
  }
</script>
@endpush
