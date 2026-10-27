<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VirtualMachine;
use App\Models\PublicAccess;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'member_code' => 'NOC-STAFF-01',
            'name' => 'เจ้าหน้าที่ NOC ประจำศูนย์คอมพิวเตอร์',
            'email' => env('SEED_ADMIN_EMAIL', 'admin@mut.ac.th'),
            'password' => env('ADMIN_PASSWORD', 'AdminPass123!'),
            'department' => 'NOC อาคาร Q ชั้น 1',
            'academic_role' => 'เจ้าหน้าที่ผู้ดูแลระบบ (NOC Admin)',
            'role' => 'admin',
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'quota_max' => 10,
            'status' => 'Active',
            'last_login_text' => 'วันนี้ 22:30 น.',
            'email_verified_at' => now(),
        ]);

        $kamonchai = User::create([
            'member_code' => 'MUT-M0491',
            'name' => 'อ.กมลชัย เกียรติสกุลชัย',
            'email' => env('SEED_MEMBER_EMAIL', 'kamonchai@mut.ac.th'),
            'password' => env('SEED_MEMBER_PASSWORD', 'password'),
            'department' => 'สำนักพัฒนาระบบเครือข่าย (NOC)',
            'academic_role' => 'อาจารย์ / บุคลากร',
            'role' => 'member',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'MUT-2FA-7X9K-82LQ',
            'quota_max' => 1,
            'status' => 'Active',
            'last_login_text' => 'วันนี้ 22:15 น.',
            'email_verified_at' => now(),
        ]);

        VirtualMachine::create([
            'vmid' => 104,
            'user_id' => $kamonchai->id,
            'hostname' => 'cpe-ai-research-01',
            'node' => 'Alpha Pool Rack 01 (pve-01)',
            'os' => 'Ubuntu 22.04 LTS',
            'ip_address' => '10.20.155.4',
            'status' => 'running',
            'term' => 'ภาคเรียนที่ 1/2569',
            'cpu_load' => '5.8%',
            'ram_load' => '0.9 / 2.0 GB',
        ]);

        PublicAccess::create([
            'user_id' => $kamonchai->id,
            'req_code' => 'DNAT-2026-001',
            'type' => 'subdomain',
            'endpoint' => 'https://cpe-ai-research.mut.ac.th',
            'internal_target' => '10.20.155.4:80',
            'ssl_status' => 'Let\'s Encrypt SSL (Valid)',
            'purpose' => 'งานวิจัยปัญญาประดิษฐ์และเซิร์ฟเวอร์ทดสอบโมเดล',
            'status' => 'approved',
        ]);

        PublicAccess::create([
            'user_id' => $kamonchai->id,
            'req_code' => 'DNAT-2026-002',
            'type' => 'dnat',
            'endpoint' => '202.28.15.20:22004',
            'internal_target' => '10.20.155.4:22',
            'ssl_status' => 'OpenSSH Encrypted',
            'purpose' => 'การเชื่อมต่อ Secure Shell จากภายนอกเครือข่าย',
            'status' => 'approved',
        ]);

        PublicAccess::create([
            'user_id' => $kamonchai->id,
            'req_code' => 'DNAT-2026-003',
            'type' => 'subdomain',
            'endpoint' => 'https://iot-telemetry.mut.ac.th',
            'internal_target' => '10.20.155.4:8080',
            'ssl_status' => 'Pending Review',
            'purpose' => 'โครงงานวิจัย IoT Sensor Gateway สถาบัน',
            'status' => 'pending',
        ]);

        $members = [
            [
                'member_code' => 'MUT-M0102',
                'name' => 'ดร.สมศักดิ์ นิลเจริญ',
                'email' => 'somsak.n@mut.ac.th',
                'department' => 'วิศวกรรมไฟฟ้า',
                'academic_role' => 'อาจารย์ประจำภาค',
                'two_factor_enabled' => true,
                'email_verified' => true,
                'status' => 'Active',
                'last_login' => 'เมื่อวาน 14:10 น.',
                'vm' => [
                    'vmid' => 101,
                    'hostname' => 'ee-power-sim-02',
                    'node' => 'Alpha Pool Rack 01 (pve-01)',
                    'os' => 'Debian 12 Bookworm',
                    'ip_address' => '10.20.155.2',
                    'status' => 'running',
                    'cpu_load' => '4.2%',
                    'ram_load' => '0.8 / 2.0 GB',
                ]
            ],
            [
                'member_code' => 'MUT-M0224',
                'name' => 'ผศ.ดร.วิภา สุริยา',
                'email' => 'wipha.s@mut.ac.th',
                'department' => 'วิศวกรรมโยธา',
                'academic_role' => 'อาจารย์ประจำภาค',
                'two_factor_enabled' => false,
                'email_verified' => true,
                'status' => 'Active',
                'last_login' => '3 วันที่แล้ว',
                'vm' => [
                    'vmid' => 102,
                    'hostname' => 'ce-structural-calc',
                    'node' => 'Beta Pool Rack 02 (pve-02)',
                    'os' => 'Windows Server 2022',
                    'ip_address' => '10.20.155.3',
                    'status' => 'running',
                    'cpu_load' => '14.8%',
                    'ram_load' => '1.4 / 2.0 GB',
                ]
            ],
            [
                'member_code' => 'MUT-M0388',
                'name' => 'ดร.อนุสรณ์ ปัญญาดี',
                'email' => 'anusorn.p@mut.ac.th',
                'department' => 'วิทยาการข้อมูล',
                'academic_role' => 'นักวิจัยโครงการ',
                'two_factor_enabled' => true,
                'email_verified' => true,
                'status' => 'Active',
                'last_login' => '5 วันที่แล้ว',
                'vm' => [
                    'vmid' => 105,
                    'hostname' => 'ds-spark-analytics',
                    'node' => 'Gamma Pool AI Lab (pve-03)',
                    'os' => 'Rocky Linux 9',
                    'ip_address' => '10.20.155.5',
                    'status' => 'running',
                    'cpu_load' => '45.2%',
                    'ram_load' => '1.8 / 2.0 GB',
                ]
            ],
            [
                'member_code' => 'MUT-M0512',
                'name' => 'อ.ชลธิชา รัตนวงษ์',
                'email' => 'cholticha.r@mut.ac.th',
                'department' => 'เทคโนโลยีสารสนเทศ',
                'academic_role' => 'อาจารย์ประจำภาค',
                'two_factor_enabled' => false,
                'email_verified' => false,
                'status' => 'Active',
                'last_login' => '1 สัปดาห์ที่แล้ว',
                'vm' => [
                    'vmid' => 106,
                    'hostname' => 'it-webdev-lab',
                    'node' => 'Alpha Pool Rack 01 (pve-01)',
                    'os' => 'Ubuntu 22.04 LTS',
                    'ip_address' => '10.20.155.6',
                    'status' => 'stopped',
                    'cpu_load' => '0.0%',
                    'ram_load' => '0.0 / 2.0 GB',
                ]
            ],
            [
                'member_code' => 'MUT-M0610',
                'name' => 'นายธนกร วรรณสิทธิ์',
                'email' => 'thanakorn.w@mut.ac.th',
                'department' => 'วิศวกรรมคอมพิวเตอร์',
                'academic_role' => 'นักศึกษา',
                'two_factor_enabled' => false,
                'email_verified' => true,
                'status' => 'Active',
                'last_login' => '2 ชั่วโมงที่แล้ว',
                'vm' => null
            ],
            [
                'member_code' => 'MUT-M0778',
                'name' => 'นางสาวกัญญา พิทักษ์',
                'email' => 'kanya.p@mut.ac.th',
                'department' => 'วิศวกรรมโทรคมนาคม',
                'academic_role' => 'นักศึกษาปริญญาโท',
                'two_factor_enabled' => false,
                'email_verified' => false,
                'status' => 'Suspended',
                'last_login' => '1 เดือนที่แล้ว',
                'vm' => null
            ]
        ];

        foreach ($members as $m) {
            $user = User::create([
                'member_code' => $m['member_code'],
                'name' => $m['name'],
                'email' => $m['email'],
                'password' => 'password',
                'department' => $m['department'],
                'academic_role' => $m['academic_role'],
                'role' => 'member',
                'two_factor_enabled' => $m['two_factor_enabled'],
                'two_factor_secret' => $m['two_factor_enabled'] ? 'MUT-SECRET-KEY-MEMBER' : null,
                'quota_max' => 1,
                'status' => $m['status'],
                'last_login_text' => $m['last_login'],
                'email_verified_at' => $m['email_verified'] ? now() : null,
            ]);

            if ($m['vm']) {
                VirtualMachine::create([
                    'vmid' => $m['vm']['vmid'],
                    'user_id' => $user->id,
                    'hostname' => $m['vm']['hostname'],
                    'node' => $m['vm']['node'],
                    'os' => $m['vm']['os'],
                    'ip_address' => $m['vm']['ip_address'],
                    'status' => $m['vm']['status'],
                    'term' => 'ภาคเรียนที่ 1/2569',
                    'cpu_load' => $m['vm']['cpu_load'],
                    'ram_load' => $m['vm']['ram_load'],
                ]);
            }
        }
    }
}
