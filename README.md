# MUT NOC Cloud VPS Provisioning System
**ระบบจัดสรรเครื่อง Server เสมือนและบริหารจัดการเครือข่ายสถาบัน (NOC Server Management)**  
ศูนย์ปฏิบัติการเครือข่ายคอมพิวเตอร์ (NOC) อาคาร Q ชั้น 1 มหาวิทยาลัยเทคโนโลยีมหานคร

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Tests](https://img.shields.io/badge/Tests-18%20Passed-10B981?style=for-the-badge&logo=checkmarx&logoColor=white)](#automated-feature-tests)

---

## 📖 ภาพรวมระบบ (System Overview)
**MUT NOC Cloud VPS Provisioning System** เป็นเว็บแอปพลิเคชันสำหรับการบริหารจัดการและจัดสรรเครื่องคอมพิวเตอร์แม่ข่ายเสมือน (Cloud VPS Self-Service Portal) บนโครงสร้างพื้นฐาน Proxmox VE Cluster ประจำการ ณ ศูนย์ปฏิบัติการเครือข่ายคอมพิวเตอร์ (NOC) อาคาร Q ชั้น 1 มหาวิทยาลัยเทคโนโลยีมหานคร

ระบบถูกพัฒนาด้วย **Laravel Framework (PHP 8.2+ / MVC Architecture)** รองรับการทำงานแบบบริการตนเอง (Self-Service) โดยมีระบบควบคุมโควตาทรัพยากร, ระบบจัดการวงจรชีวิตเครื่องเสมือน (Power Lifecycle), ระบบขอเปิดเส้นทางเครือข่ายโดเมนสถาบัน (`*.mut.ac.th`), คอนโซลเทอร์มินัลจำลอง noVNC Web Terminal และศูนย์บัญชาการ NOC Admin Command Center สำหรับเจ้าหน้าที่เครือข่าย

---

## ✨ คุณสมบัติหลัก (Key Features)

### 1. ฝั่งสมาชิกสถาบัน (Member Portal)
* **Single Sign-On & Authentication:** เข้าสู่ระบบด้วยอีเมลสถาบัน (`@mut.ac.th`) และรหัสผ่านที่เข้ารหัสด้วย Bcrypt Hashing
* **Quota Meter Tracking:** ควบคุมและติดตามสิทธิ์การใช้งานโควตาทรัพยากรแบบเรียลไทม์ (จำกัด 1 เครื่อง ต่อ 1 บัญชีผู้ใช้)
* **1-Click Fast Deploy:** เลือกระบบปฏิบัติการมาตรฐาน (Ubuntu Server, Debian, Rocky Linux, Alpine Linux), เลือก Proxmox Node และตั้งชื่อ Hostname เพื่อจัดสรรเครื่องได้ทันที
* **VM Lifecycle Controls:** สั่งเปิดเครื่อง (Power On), สั่งปิดเครื่อง (Power Off), สั่งรีบูต (ACPI Reboot) แบบเรียลไทม์
* **noVNC Web Terminal:** คอนโซลเทอร์มินัลจำลองบนเว็บสำหรับทดสอบคำสั่ง Linux พื้นฐาน (`uptime`, `free -m`, `ip a`)
* **Edge Domain & Port Forwarding (DNAT):** ฟอร์มยื่นขอจดชื่อโดเมนย่อยสถาบัน `https://[ชื่อ].mut.ac.th` และขอเปิด Public Port Forwarding
* **Profile & Security Management:** แก้ไขข้อมูลส่วนตัว, เปลี่ยนรหัสผ่านใหม่ที่ปลอดภัย, และลบเครื่องเพื่อคืนสิทธิ์โควตา (Destroy VM)
* **Dynamic Theme Switcher:** สลับโหมดการแสดงผล สว่าง / มืด (Light & Dark Theme) พร้อมบันทึกสถานะลงใน Local Storage

### 2. ฝั่งผู้ดูแลระบบศูนย์เครือข่าย (NOC Admin Command Center)
* **Cluster Telemetry Monitoring:** ติดตามสถานะฮาร์ดแวร์ Proxmox VE Real-time (CPU Cores, RAM Pool Allocation, NVMe Storage)
* **Campus Gateway Bandwidth Meter:** มาตรวัดทราฟฟิกเครือข่ายสถาบัน (Inbound / Outbound)
* **Add Node Server:** รองรับการลงทะเบียน Server กายภาพใหม่เข้าสู่คลัสเตอร์ อาคาร Q ชั้น 1 แบบ Dynamic State Persistence
* **All Cluster VMs Inventory:** ตรวจสอบและค้นหาเครื่องเสมือนทั้งหมดของทุกคณะในมหาวิทยาลัย พร้อมสิทธิ์จัดการจากส่วนกลาง
* **Routing Approval Queue:** ตรวจสอบและพิจารณาอนุมัติ (Approve) หรือปฏิเสธ (Reject) คำขอ Subdomain และ Public Port DNAT
* **Member Directory CRUD:** ดูทะเบียนสมาชิก, ค้นหา, สั่งระงับการใช้งานชั่วคราว (Suspend/Activate), รีเซ็ตรหัสผ่านฉุกเฉิน และเพิ่มสมาชิกใหม่

---

## 🔑 บัญชีเริ่มต้นสำหรับเข้าสู่ระบบ (Default Credentials)

| บทบาท (Role) | อีเมล (Email) | รหัสผ่านเริ่มต้น (Password) | สิทธิ์การเข้าถึง |
| :--- | :--- | :--- | :--- |
| **NOC Admin (ผู้ดูแลระบบ)** | `admin@mut.ac.th` | `AdminPass123!` | ศูนย์บัญชาการ NOC, Telemetry, เพิ่ม Node Server, อนุมัติคิวเครือข่าย, จัดการสมาชิก |
| **Member (สมาชิกทั่วไป)** | `kamonchai@mut.ac.th` | `password` | จัดการ Cloud VPS, 1-Click Fast Deploy, Web Terminal, ขอ Subdomain, แก้ไขโปรไฟล์ |

---

## 🚀 การติดตั้งและเริ่มต้นใช้งาน (Installation & Setup)

### ความต้องการของระบบ (System Requirements)
* PHP >= 8.2 (พร้อม Extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, SQLite3)
* Composer 2.x
* Web Server (Nginx, Apache, หรือ PHP Built-in Server)

### ขั้นตอนการติดตั้ง
```bash
# 1. แตกไฟล์ ZIP และเข้าไปยังโฟลเดอร์โปรเจกต์
cd project

# 2. ติดตั้ง PHP Dependencies ผ่าน Composer
composer install

# 3. ตั้งค่าไฟล์ Environment
cp .env.example .env
php artisan key:generate

# 4. สร้างฐานข้อมูลและข้อมูลเริ่มต้น (Migrations & Seeders)
php artisan migrate:fresh --seed

# 5. รันเซิร์ฟเวอร์สำหรับทดสอบ
php artisan serve
```
เข้าใช้งานผ่านเว็บบราวเซอร์ที่: **`http://127.0.0.1:8000`**

---

## ✅ การทดสอบระบบ (Automated Feature Tests)

ระบบผ่านการทดสอบครอบคลุมทุกกระบวนการทำงานจริงด้วยชุดทดสอบ PHPUnit / Feature Tests ครบถ้วน **18 ผ่าน 18 รายการ (61 assertions)**:

```bash
php artisan test
```

ผลการทดสอบ:
```
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

   PASS  Tests\Feature\SystemTest
  ✓ login screen renders successfully
  ✓ login direct without 2fa prompt
  ✓ register screen renders successfully
  ✓ register rejects non mut email
  ✓ authenticated member can view dashboard
  ✓ admin can view noc command center
  ✓ regular member forbidden from admin dashboard
  ✓ member can toggle vm power
  ✓ member can request subdomain
  ✓ admin can approve subdomain request
  ✓ admin can toggle member email verification
  ✓ member without vm cannot request subdomain
  ✓ quota meter tracks vm lifecycle
  ✓ suspended member cannot login
  ✓ member can update profile
  ✓ admin can add node server

  Tests:    18 passed (61 assertions)
  Duration: 1.29s
```

---

## 📂 โครงสร้างโฟลเดอร์สำคัญ (Architecture)

```
project/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # การเข้าสู่ระบบ, ลงทะเบียน, ออกจากระบบ (@mut.ac.th)
│   │   ├── MemberController.php        # 1-Click Deploy, Power Controls, DNAT, แก้ไข Profile
│   │   └── NocAdminController.php      # Telemetry, เพิ่ม Node Server, อนุมัติ Routing, สมาชิก CRUD
│   ├── Http/Middleware/
│   │   └── CheckRole.php               # ตรวจสอบสิทธิ์ผู้ดูแลระบบ (role:admin)
│   └── Models/
│       ├── User.php                    # สมาชิกสถาบัน, บทบาท, รหัสผ่าน Bcrypt
│       ├── VirtualMachine.php          # ข้อมูลเครื่องเสมือน Proxmox VE
│       └── PublicAccess.php            # คำขอ Subdomain *.mut.ac.th และ Port DNAT
├── database/
│   ├── migrations/                     # โครงสร้างตารางฐานข้อมูลเชิงสัมพันธ์
│   └── seeders/DatabaseSeeder.php      # ข้อมูลตั้งต้นสำหรับทดสอบและประเมิน
├── resources/views/
│   ├── layouts/app.blade.php           # Master Layout, Left Sidebar, Quota Box, Theme Switcher
│   ├── auth/                           # หน้า Login และ Register
│   ├── member/dashboard.blade.php      # แดชบอร์ดฝั่งสมาชิก (Cloud VPS, Deploy, DNAT, Profile)
│   └── admin/dashboard.blade.php       # แดชบอร์ดฝั่งผู้ดูแลระบบ (Telemetry, Nodes, VMs, Queue, Members)
├── public/                             # Public Web Root (index.php, .htaccess, robots.txt)
└── routes/web.php                      # เส้นทาง Web Routing ทั้งหมด
```

---

## 🛡️ มาตรการความปลอดภัย (Security Features)
* **Bcrypt Password Hashing:** รหัสผ่านทุกบัญชีถูกเข้ารหัสทางเดียวตามมาตรฐานความปลอดภัย
* **CSRF Protection:** แบบฟอร์มทุกจุดในระบบมี `@csrf` token ป้องกัน Cross-Site Request Forgery
* **Institutional Domain Enforcement:** ป้องกันผู้ใช้งานนอกสถาบัน โดยอนุญาตเฉพาะอีเมล `@mut.ac.th`
* **Role-Based Access Control (RBAC):** กรองสิทธิ์ผู้ดูแลระบบผ่าน Custom Middleware ป้องกันการเข้าถึงโดยไม่ได้รับอนุญาต
* **Account Suspension Enforcement:** ตัดสิทธิ์และปฏิเสธการเข้าสู่ระบบสำหรับบัญชีที่ถูกระงับทันที
