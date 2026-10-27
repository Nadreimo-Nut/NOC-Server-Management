@extends('layouts.app')

@section('title', 'ศูนย์บัญชาการ NOC Command Center - MUT')
@section('breadcrumb', 'NOC Admin Portal')
@section('header_title', 'NOC server management')

@section('content')

    <div class="flex items-center gap-2 border-b border-slate-800 pb-3 overflow-x-auto text-xs font-mono">
    <a href="{{ route('admin.dashboard', ['tab' => 'noc-dashboard']) }}" 
      class="px-3.5 py-1.5 rounded-lg transition {{ ($currentTab ?? 'noc-dashboard') === 'noc-dashboard' ? 'bg-amber-600 text-white font-bold' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
      <i class="fa-solid fa-chart-line"></i> ภาพรวมคลัสเตอร์ (Telemetry)
    </a>
    <a href="{{ route('admin.dashboard', ['tab' => 'noc-nodes']) }}" 
      class="px-3.5 py-1.5 rounded-lg transition {{ ($currentTab ?? '') === 'noc-nodes' ? 'bg-amber-600 text-white font-bold' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
      <i class="fa-solid fa-server"></i> โหนด Proxmox VE
    </a>
    <a href="{{ route('admin.dashboard', ['tab' => 'noc-vms']) }}" 
      class="px-3.5 py-1.5 rounded-lg transition {{ ($currentTab ?? '') === 'noc-vms' ? 'bg-amber-600 text-white font-bold' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
      <i class="fa-solid fa-cubes"></i> คลังเครื่องเสมือน (VMs)
    </a>
    <a href="{{ route('admin.dashboard', ['tab' => 'noc-dnat']) }}" 
      class="px-3.5 py-1.5 rounded-lg transition {{ ($currentTab ?? '') === 'noc-dnat' ? 'bg-amber-600 text-white font-bold' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
      <i class="fa-solid fa-network-wired"></i> คิว Domain & DNAT ({{ $pendingDnat->count() }})
    </a>
    <a href="{{ route('admin.dashboard', ['tab' => 'noc-members']) }}" 
      class="px-3.5 py-1.5 rounded-lg transition {{ ($currentTab ?? '') === 'noc-members' ? 'bg-teal-600 text-white font-bold' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
      <i class="fa-solid fa-users-gear"></i> จัดการสมาชิกสถาบัน ({{ $stats['total_members'] }})
    </a>
  </div>

    @if(($currentTab ?? 'noc-dashboard') === 'noc-dashboard' || ($currentTab ?? '') === 'noc-nodes')

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
      <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
        <div class="text-[11px] text-slate-400 font-medium">Clustered CPU Allocation</div>
        <div class="text-xl sm:text-2xl font-bold text-white font-mono">{{ $telemetry['cluster_cpu'] }}</div>
        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
          <div class="bg-blue-500 h-full" style="width: 24.2%"></div>
        </div>
      </div>
      <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
        <div class="text-[11px] text-slate-400 font-medium">RAM Pool Allocation</div>
        <div class="text-xl sm:text-2xl font-bold text-indigo-400 font-mono">{{ $telemetry['cluster_ram'] }}</div>
        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
          <div class="bg-indigo-500 h-full" style="width: 42.8%"></div>
        </div>
      </div>
      <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
        <div class="text-[11px] text-slate-400 font-medium">NVMe ZFS Storage Pool</div>
        <div class="text-xl sm:text-2xl font-bold text-amber-400 font-mono">{{ $telemetry['cluster_storage'] }}</div>
        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
          <div class="bg-amber-500 h-full" style="width: 18.4%"></div>
        </div>
      </div>
      <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
        <div class="text-[11px] text-slate-400 font-medium">Active VMs in Cluster</div>
        <div class="text-xl sm:text-2xl font-bold text-emerald-400 font-mono">{{ $allVms->count() }} <span class="text-xs text-slate-400 font-sans font-normal">/ 58 เครื่อง</span></div>
        <div class="text-[10px] text-slate-500 font-mono">PVE Cluster Alpha, Beta, Gamma</div>
      </div>
    </div>

        <div class="space-y-3 pt-2">
      <div class="flex items-center justify-between flex-wrap gap-2">
        <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
          <i class="fa-solid fa-server text-blue-400"></i> สถานะเครื่อง Server กายภาพ (Proxmox VE Clustered Nodes)
        </h3>
        <div class="flex items-center gap-2">
          <span class="text-[10px] text-emerald-400 font-mono bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-lg">Quorum: {{ count($nodes) }} Nodes (Healthy)</span>
          <button type="button" onclick="openModal('modalAddNode')" 
            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> เพิ่ม Node Server
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
        @foreach($nodes as $node)
          <div class="bg-[#111827] border border-[#1f293d] rounded-2xl p-4 space-y-3 shadow">
            <div class="flex items-start justify-between">
              <div>
                <div class="font-bold text-white text-xs flex items-center gap-1.5 font-mono">
                  <i class="fa-solid fa-server text-blue-400"></i> {{ $node['name'] }}
                </div>
                <div class="text-[10px] text-slate-400 mt-0.5">{{ $node['location'] }}</div>
              </div>
              <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[10px] font-bold font-mono flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> {{ $node['status'] }}
              </span>
            </div>

            <div class="space-y-2 text-xs font-mono">
              <div>
                <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                  <span>CPU Load:</span>
                  <span class="text-white font-bold">{{ $node['cpu_percent'] }}%</span>
                </div>
                <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                  <div class="bg-blue-500 h-full" style="width: {{ $node['cpu_percent'] }}%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                  <span>RAM Usage:</span>
                  <span class="text-indigo-400 font-bold">{{ $node['ram_usage'] }}</span>
                </div>
                <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                  <div class="bg-indigo-500 h-full" style="width: {{ $node['ram_percent'] }}%"></div>
                </div>
              </div>
            </div>

            <div class="pt-2 border-t border-[#1a2336] flex items-center justify-between text-[10px] text-slate-400 font-mono">
              <span>VMs: <strong class="text-white">{{ $node['vms'] }} / {{ $node['max_vms'] }}</strong></span>
              <span>Uptime: <strong class="text-slate-300 font-sans">{{ $node['uptime'] }}</strong></span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  @endif

    @if(($currentTab ?? '') === 'noc-vms' || ($currentTab ?? 'noc-dashboard') === 'noc-dashboard')
    
    <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl overflow-hidden shadow-xl space-y-0">
      <div class="p-4 border-b border-[#1a2336] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
            <i class="fa-solid fa-cubes text-indigo-400"></i> คลังเครื่อง Server เสมือนทั้งหมดในคลัสเตอร์ (Active VMs Inventory)
          </h3>
          <span class="text-[11px] text-slate-400 mt-0.5 block">มอนิเตอร์และสั่งการระดับ Superuser ไปยังเครื่องเสมือนทุกเครื่องของสถาบัน</span>
        </div>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-500 pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
          </span>
          <input type="text" id="vmSearchInput" oninput="filterVmTable()" placeholder="ค้นหา VMID, Hostname, อาจารย์, โหนด..." 
            class="bg-[#0b0f19] border border-slate-700 rounded-lg pl-8 pr-3 py-1.5 text-xs text-white placeholder-slate-500 outline-none w-64 font-mono focus:border-blue-500">
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300 font-mono" id="tableVmsInventory">
          <thead class="bg-[#0b101c] text-slate-400 uppercase text-[10px]">
            <tr>
              <th class="p-3">VMID</th>
              <th class="p-3">Hostname & OS</th>
              <th class="p-3">ผู้ถือครอง & ภาควิชา</th>
              <th class="p-3">โหนดฮาร์ดแวร์</th>
              <th class="p-3">IP ภายใน</th>
              <th class="p-3">สถานะ</th>
              <th class="p-3">ทรัพยากร</th>
              <th class="p-3 text-right">คำสั่ง NOC</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#1a2336]">
            @foreach($allVms as $v)
              <tr class="hover:bg-[#121929] transition vm-row">
                <td class="p-3 font-bold text-blue-400">{{ $v->vmid }}</td>
                <td class="p-3">
                  <div class="font-bold text-white">{{ $v->hostname }}</div>
                  <div class="text-[10px] text-slate-400 font-sans flex items-center gap-1.5 mt-0.5">
                    @if(str_contains(strtolower($v->os), 'debian'))
                      <i class="devicon-debian-plain text-rose-500 text-xs"></i>
                    @elseif(str_contains(strtolower($v->os), 'rocky') || str_contains(strtolower($v->os), 'redhat'))
                      <i class="fa-brands fa-redhat text-emerald-400 text-xs"></i>
                    @elseif(str_contains(strtolower($v->os), 'windows'))
                      <i class="fa-brands fa-windows text-blue-400 text-xs"></i>
                    @else
                      <i class="fa-brands fa-ubuntu text-orange-400 text-xs"></i>
                    @endif
                    <span>{{ $v->os }}</span>
                  </div>
                </td>
                <td class="p-3">
                  <div class="text-slate-200 font-sans font-medium">{{ $v->user->name ?? 'N/A' }}</div>
                  <div class="text-[10px] text-slate-500 font-sans">{{ $v->user->department ?? '-' }}</div>
                </td>
                <td class="p-3 text-slate-300">{{ $v->node }}</td>
                <td class="p-3 text-blue-400 font-bold">{{ $v->ip_address }}</td>
                <td class="p-3">
                  @if($v->isRunning())
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 flex items-center gap-1.5 w-fit">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span> RUNNING
                    </span>
                  @else
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-500/20 text-rose-400 flex items-center gap-1.5 w-fit">
                      <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> STOPPED
                    </span>
                  @endif
                </td>
                <td class="p-3 text-slate-400 text-[11px]">
                  <div>CPU: <span class="text-white">{{ $v->cpu_load }}</span></div>
                  <div>RAM: <span class="text-indigo-400">{{ $v->ram_load }}</span></div>
                </td>
                <td class="p-3 text-right">
                  <div class="flex items-center justify-end gap-1">
                    <form action="{{ route('admin.vm.action', $v->id) }}" method="POST" class="inline">
                      @csrf
                      <input type="hidden" name="action" value="power">
                      <button type="submit" title="{{ $v->isRunning() ? 'Shutdown' : 'Power On' }}" 
                        class="p-1.5 rounded text-[10px] text-white {{ $v->isRunning() ? 'bg-amber-600 hover:bg-amber-500' : 'bg-emerald-600 hover:bg-emerald-500' }}">
                        <i class="fa-solid fa-power-off"></i>
                      </button>
                    </form>

                    <form action="{{ route('admin.vm.action', $v->id) }}" method="POST" class="inline">
                      @csrf
                      <input type="hidden" name="action" value="reboot">
                      <button type="submit" title="Reboot ACPI" class="p-1.5 rounded bg-blue-600 hover:bg-blue-500 text-white text-[10px]">
                        <i class="fa-solid fa-rotate-right"></i>
                      </button>
                    </form>

                    <form action="{{ route('admin.vm.action', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันทำลายและลบเครื่องนี้ถาวร?')">
                      @csrf
                      <input type="hidden" name="action" value="destroy">
                      <button type="submit" title="ลบเครื่องถาวร" class="p-1.5 rounded bg-red-900/60 hover:bg-red-800 text-red-300 text-[10px]">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  @endif

    @if(($currentTab ?? '') === 'noc-dnat' || ($currentTab ?? 'noc-dashboard') === 'noc-dashboard')
    
    <div class="space-y-6">
      
            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl overflow-hidden shadow-xl">
        <div class="p-4 border-b border-[#1a2336] flex items-center justify-between">
          <div>
            <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
              <i class="fa-solid fa-inbox text-amber-400"></i> คิวคำขอ Subdomain (*.mut.ac.th) และ Port DNAT รอการอนุมัติ
            </h3>
            <span class="text-[11px] text-slate-400 mt-0.5 block">ตรวจสอบสิทธิ์การตั้งชื่อและแมปพอร์ตความปลอดภัยก่อนเปิดให้บริการสู่ภายนอก</span>
          </div>
          <span class="text-xs font-mono text-amber-400 font-bold">{{ $pendingDnat->count() }} คำขอคงค้าง</span>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs font-mono text-slate-300">
            <thead class="bg-[#0b101c] text-slate-400 uppercase text-[10px]">
              <tr>
                <th class="p-3">รหัสคำขอ</th>
                <th class="p-3">ประเภท</th>
                <th class="p-3">ผู้ขอ & หมายเลขเป้าหมาย</th>
                <th class="p-3">Public Endpoint ➔ Internal Target</th>
                <th class="p-3">วัตถุประสงค์</th>
                <th class="p-3 text-right">การอนุมัติ NOC</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#1a2336]">
              @forelse($pendingDnat as $dnat)
                <tr class="hover:bg-[#121929] transition">
                  <td class="p-3 font-bold text-amber-400">{{ $dnat->req_code }}</td>
                  <td class="p-3 uppercase text-[10px] text-slate-400">{{ $dnat->type }}</td>
                  <td class="p-3 text-white font-sans">{{ $dnat->user->name ?? 'สมาชิก' }}</td>
                  <td class="p-3 text-emerald-400 font-mono">{{ $dnat->endpoint }} ➔ <span class="text-blue-400">{{ $dnat->internal_target }}</span></td>
                  <td class="p-3 text-slate-400 font-sans">{{ $dnat->purpose }}</td>
                  <td class="p-3 text-right">
                    <div class="flex items-center justify-end gap-1.5 font-sans">
                      <form action="{{ route('admin.queue.approve', $dnat->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-[11px] rounded-lg shadow">
                          Approve
                        </button>
                      </form>
                      <form action="{{ route('admin.queue.reject', $dnat->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-400 rounded-lg text-[11px]">
                          Reject
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="p-6 text-center text-slate-500 font-sans">ไม่มีคำขอเชื่อมต่อคงค้างในขณะนี้</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl overflow-hidden shadow-xl">
        <div class="p-4 border-b border-[#1a2336]">
          <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
            <i class="fa-solid fa-route text-emerald-400"></i> ผังเส้นทางเครือข่ายและไฟร์วอลล์มหาวิทยาลัย (Campus Edge Routing Matrix)
          </h3>
          <span class="text-[11px] text-slate-400 mt-0.5 block">Nginx SSL Reverse Proxy (*.mut.ac.th) และ Gateway DNAT ที่เปิดให้บริการอยู่ทั้งหมด</span>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs font-mono text-slate-300">
            <thead class="bg-[#0b101c] text-slate-400 uppercase text-[10px]">
              <tr>
                <th class="p-3">ประเภทโปรโตคอล</th>
                <th class="p-3">Public Endpoint (*.mut.ac.th / IP)</th>
                <th class="p-3">เป้าหมายภายใน (IP:Port)</th>
                <th class="p-3">ใบรับรอง SSL</th>
                <th class="p-3">ผู้รับผิดชอบ</th>
                <th class="p-3">สถานะ</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#1a2336]">
              @foreach($approvedRoutes as $route)
                <tr class="hover:bg-[#121929] transition">
                  <td class="p-3 font-bold text-white">{{ $route->type === 'subdomain' ? 'HTTPS (Subdomain)' : 'Port DNAT (TCP)' }}</td>
                  <td class="p-3 text-emerald-400 font-bold select-all">{{ $route->endpoint }}</td>
                  <td class="p-3 text-blue-400">{{ $route->internal_target }}</td>
                  <td class="p-3 text-slate-300 font-sans text-[11px]">{{ $route->ssl_status }}</td>
                  <td class="p-3 text-slate-300 font-sans">{{ $route->user->name ?? '-' }}</td>
                  <td class="p-3"><span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold text-[10px]">Active</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>

  @endif

    @if(($currentTab ?? '') === 'noc-members')

    <div class="space-y-6">
      
      <div class="pb-3 border-b border-[#1a2336] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-users-gear text-teal-400"></i> ทำเนียบสมาชิกสถาบันและการจัดการความปลอดภัย (Member Directory)
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">ตรวจสอบการยืนยันอีเมลสถาบัน (@mut.ac.th), รีเซ็ต 2FA, สร้างรหัสผ่านชั่วคราว และระงับ/ลบบัญชี</p>
        </div>
        <button type="button" onclick="openModal('modalAddMember')" 
          class="px-3.5 py-2 bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs rounded-xl shadow transition flex items-center gap-1.5">
          <i class="fa-solid fa-user-plus"></i> เพิ่มสมาชิกใหม่
        </button>
      </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
        <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
          <div class="text-[11px] text-slate-400 font-medium">สมาชิกที่ลงทะเบียนทั้งหมด</div>
          <div class="text-xl sm:text-2xl font-bold text-white font-mono">{{ $stats['total_members'] }} <span class="text-xs text-slate-400 font-sans font-normal">คน</span></div>
          <div class="text-[10px] text-slate-500 font-mono">คณาจารย์, นักวิจัย และนักศึกษา</div>
        </div>
        <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
          <div class="text-[11px] text-slate-400 font-medium">ยืนยันอีเมลสถาบันแล้ว</div>
          <div class="text-xl sm:text-2xl font-bold text-emerald-400 font-mono">{{ $stats['verified_count'] }} <span class="text-xs text-slate-400 font-sans font-normal">คน ({{ $stats['verified_percent'] }}%)</span></div>
          <div class="text-[10px] text-slate-500 font-mono">ตรวจสอบผ่านโดเมน @mut.ac.th</div>
        </div>
        <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
          <div class="text-[11px] text-slate-400 font-medium">บัญชีพร้อมใช้งาน (Active Status)</div>
          <div class="text-xl sm:text-2xl font-bold text-blue-400 font-mono">{{ $stats['active_count'] }} <span class="text-xs text-slate-400 font-sans font-normal">คน ({{ $stats['active_percent'] }}%)</span></div>
          <div class="text-[10px] text-slate-500 font-mono">สถานะปกติ ไม่ถูกระงับสิทธิ์</div>
        </div>
        <div class="bg-[#111827] border border-[#1f293d] p-4 rounded-2xl space-y-2">
          <div class="text-[11px] text-slate-400 font-medium">โควตาจัดสรรเครื่อง (VMs)</div>
          <div class="text-xl sm:text-2xl font-bold text-amber-400 font-mono">{{ $stats['allocated_vms'] }} <span class="text-xs text-slate-400 font-sans font-normal">/ {{ $stats['total_members'] }} เครื่อง</span></div>
          <div class="text-[10px] text-slate-500 font-mono">1 สิทธิ์ต่อสมาชิก</div>
        </div>
      </div>

            <div class="bg-[#101726] border border-[#1d2a44] rounded-2xl overflow-hidden shadow-xl">
        <div class="p-4 border-b border-[#1a2336] flex flex-col lg:flex-row lg:items-center justify-between gap-3">
          <div>
            <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
              <i class="fa-solid fa-address-book text-teal-400"></i> ทำเนียบบัญชีสมาชิกสถาบัน (Institutional Members Roster)
            </h3>
            <span class="text-[11px] text-slate-400 mt-0.5 block">ค้นหา จัดการการยืนยันตัวตน และควบคุมความปลอดภัยของสมาชิกรายบุคคล</span>
          </div>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-500 pointer-events-none">
              <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
            </span>
            <input type="text" id="memberSearchInput" oninput="filterMemberTable()" placeholder="ค้นหาชื่อ, รหัส, อีเมล, สังกัด..." 
              class="bg-[#0b0f19] border border-slate-700 rounded-lg pl-8 pr-3 py-1.5 text-xs text-white placeholder-slate-500 outline-none w-64 font-mono focus:border-teal-500">
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs text-slate-300 font-mono" id="tableMembersRoster">
            <thead class="bg-[#0b101c] text-slate-400 uppercase text-[10px]">
              <tr>
                <th class="p-3">รหัสสมาชิก</th>
                <th class="p-3">ชื่อ - นามสกุล & สังกัด</th>
                <th class="p-3">อีเมลสถาบัน</th>
                <th class="p-3">ยืนยันอีเมล</th>
                <th class="p-3">โควตาเครื่อง</th>
                <th class="p-3">สถานะบัญชี</th>
                <th class="p-3 text-right">การจัดการ NOC Admin</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#1a2336]">
              @foreach($members as $m)
                @php $isSuspended = ($m->status === 'Suspended'); @endphp
                <tr class="hover:bg-[#121929] transition member-row">
                  <td class="p-3 font-bold text-teal-400">{{ $m->member_code ?? 'MUT-M0' . $m->id }}</td>
                  <td class="p-3">
                    <div class="font-bold text-white font-sans">{{ $m->name }}</div>
                    <div class="text-[10px] text-slate-400 font-sans">{{ $m->academic_role }} • {{ $m->department }}</div>
                  </td>
                  <td class="p-3">
                    <span class="text-blue-400 font-mono select-all">{{ $m->email }}</span>
                    <div class="text-[10px] text-slate-500 font-sans">ใช้งานล่าสุด: {{ $m->last_login_text }}</div>
                  </td>
                  <td class="p-3">
                    @if($m->isEmailVerified())
                      <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold text-[10px] flex items-center gap-1 w-fit">
                        <i class="fa-solid fa-circle-check"></i> Verified
                      </span>
                    @else
                      <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-400 font-bold text-[10px] flex items-center gap-1 w-fit">
                        <i class="fa-solid fa-clock"></i> Pending
                      </span>
                    @endif
                  </td>
                  <td class="p-3 font-mono">
                    <div class="text-slate-200">{{ $m->virtualMachine ? '1 / 1 เครื่อง' : '0 / 1 เครื่อง' }}</div>
                    <div class="text-[10px] text-slate-500 font-sans">{{ $m->virtualMachine->hostname ?? '-' }}</div>
                  </td>
                  <td class="p-3">
                    @if($isSuspended)
                      <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-bold text-[10px] flex items-center gap-1 w-fit">
                        <i class="fa-solid fa-ban"></i> Suspended
                      </span>
                    @else
                      <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold text-[10px] flex items-center gap-1 w-fit">
                        <i class="fa-solid fa-circle-check"></i> Active
                      </span>
                    @endif
                  </td>
                  <td class="p-3 text-right">
                    <div class="flex items-center justify-end gap-1 font-sans">
                      
                                            <form action="{{ route('admin.members.verify', $m->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="{{ $m->isEmailVerified() ? 'เปลี่ยนเป็นรอยืนยัน' : 'ยืนยันอีเมลทันที' }}" 
                          class="p-1.5 rounded text-[10px] {{ $m->isEmailVerified() ? 'bg-slate-800 hover:bg-amber-900 text-amber-300' : 'bg-emerald-600 hover:bg-emerald-500 text-white' }}">
                          <i class="fa-solid fa-envelope-circle-check"></i>
                        </button>
                      </form>



                                            <form action="{{ route('admin.members.reset-password', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('ต้องการสร้างรหัสผ่านชั่วคราวใหม่ให้สมาชิกท่านนี้?')">
                        @csrf
                        <button type="submit" title="สร้างรหัสผ่านชั่วคราว" class="p-1.5 rounded bg-amber-600 hover:bg-amber-500 text-white text-[10px]">
                          <i class="fa-solid fa-key"></i>
                        </button>
                      </form>

                                            <form action="{{ route('admin.members.suspend', $m->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="{{ $isSuspended ? 'ปลดระงับ' : 'ระงับการใช้งาน' }}" 
                          class="p-1.5 rounded text-[10px] {{ $isSuspended ? 'bg-emerald-600 hover:bg-emerald-500 text-white' : 'bg-slate-800 hover:bg-rose-900 text-rose-300' }}">
                          <i class="fa-solid {{ $isSuspended ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                        </button>
                      </form>

                                            <form action="{{ route('admin.members.remove', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันลบบัญชี {{ $m->name }} ถาวร?')">
                        @csrf
                        <button type="submit" title="ลบบัญชีถาวร" class="p-1.5 rounded bg-red-900/60 hover:bg-red-800 text-red-300 text-[10px]">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>

                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>

        <div id="modalAddMember" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-[#111827] border border-[#1f293d] rounded-2xl max-w-lg w-full p-6 space-y-4 text-xs shadow-2xl">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
          <h3 class="font-bold text-sm text-white flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-teal-400"></i> เพิ่มสมาชิกสถาบันใหม่ (NOC Superuser)
          </h3>
          <button type="button" onclick="closeModal('modalAddMember')" class="text-slate-400 hover:text-white text-base">&times;</button>
        </div>

        <form action="{{ route('admin.members.add') }}" method="POST" class="space-y-3.5">
          @csrf

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-medium mb-1">ชื่อ - นามสกุล:</label>
              <input type="text" name="name" required placeholder="ดร.สมชาย ใจดี" 
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-teal-500">
            </div>
            <div>
              <label class="block text-slate-300 font-medium mb-1">อีเมลสถาบัน (@mut.ac.th):</label>
              <input type="email" name="email" required placeholder="somchai.j@mut.ac.th" 
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-teal-500">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-medium mb-1">สังกัดคณะ / ภาควิชา:</label>
              <input type="text" name="department" required placeholder="วิศวกรรมคอมพิวเตอร์" 
                class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-teal-500">
            </div>
            <div>
              <label class="block text-slate-300 font-medium mb-1">บทบาท / สถานะ:</label>
              <select name="academic_role" class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-teal-500">
                <option value="อาจารย์ประจำภาค">อาจารย์ประจำภาค</option>
                <option value="นักวิจัยโครงการ">นักวิจัยโครงการ</option>
                <option value="เจ้าหน้าที่สายสนับสนุน">เจ้าหน้าที่สายสนับสนุน</option>
                <option value="นักศึกษาโครงงาน">นักศึกษาโครงงาน</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-slate-300 font-medium mb-1">กำหนดรหัสผ่านเริ่มต้น:</label>
            <input type="text" name="password" required value="mut2026@Initial" 
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-teal-500">
          </div>

            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" name="verify_email" value="1" checked class="rounded border-slate-700 bg-slate-900 text-teal-600">
              <span>รับรองอีเมลสถาบัน (@mut.ac.th) ทันทีหลังสร้าง</span>
            </label>
          </div>

          <div class="pt-2 border-t border-slate-800 flex justify-end gap-2">
            <button type="button" onclick="closeModal('modalAddMember')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl">ยกเลิก</button>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white font-bold rounded-xl shadow flex items-center gap-1.5">
              <i class="fa-solid fa-floppy-disk"></i> สร้างบัญชีสมาชิก
            </button>
          </div>
        </form>
      </div>
    </div>

  @endif

  <div id="modalAddNode" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-[#1f293d] rounded-2xl max-w-lg w-full p-6 space-y-4 text-xs shadow-2xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="font-bold text-sm text-white flex items-center gap-2">
          <i class="fa-solid fa-server text-blue-400"></i> เพิ่ม Node Server (Proxmox VE Clustered Node)
        </h3>
        <button type="button" onclick="closeModal('modalAddNode')" class="text-slate-400 hover:text-white text-base">&times;</button>
      </div>

      <form action="{{ route('admin.nodes.add') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-slate-300 font-medium mb-1">ชื่อ Node Server (Cluster Node Name):</label>
          <input type="text" name="name" required placeholder="Delta Worker" value="Delta Worker"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">หมายเลข IP ประจำโหนด (Internal Mgmt):</label>
            <input type="text" name="ip" required placeholder="10.20.0.14" value="10.20.0.14"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
          </div>
          <div>
            <label class="block text-slate-300 font-medium mb-1">ขนาดหน่วยความจำ (RAM Pool):</label>
            <input type="text" name="ram" required placeholder="128 GB" value="128 GB"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
          </div>
        </div>

        <div>
          <label class="block text-slate-300 font-medium mb-1">ข้อมูลฮาร์ดแวร์ CPU (Processor Model):</label>
          <input type="text" name="cpu" required placeholder="AMD EPYC 7742 (24 Cores)" value="AMD EPYC 7742 (24 Cores)"
            class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-slate-300 font-medium mb-1">ตำแหน่งตู้ Rack ที่ตั้งเซิร์ฟเวอร์:</label>
            <input type="text" name="location" placeholder="อาคาร Q ชั้น 1 (NOC Data Center Rack 04)" value="อาคาร Q ชั้น 1 (NOC Data Center Rack 04)"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white outline-none focus:border-blue-500">
          </div>
          <div>
            <label class="block text-slate-300 font-medium mb-1">ความจุ VM สูงสุด (Max Capacity):</label>
            <input type="number" name="max_vms" required min="5" max="100" value="25"
              class="w-full bg-[#0b0f19] border border-slate-700 rounded-xl px-3 py-2 text-white font-mono outline-none focus:border-blue-500">
          </div>
        </div>

        <div class="pt-2 border-t border-slate-800 flex justify-end gap-2">
          <button type="button" onclick="closeModal('modalAddNode')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl">ยกเลิก</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> ยืนยันเพิ่ม Node Server
          </button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  function filterVmTable() {
    const q = document.getElementById('vmSearchInput').value.toLowerCase();
    document.querySelectorAll('.vm-row').forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  }

  function filterMemberTable() {
    const q = document.getElementById('memberSearchInput').value.toLowerCase();
    document.querySelectorAll('.member-row').forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  }
</script>
@endpush
