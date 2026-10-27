# MUT NOC Cloud VPS Provisioning System
**ระบบจัดสรรเครื่อง Server เสมือนและบริหารจัดการเครือข่ายสถาบัน (NOC Server Management)**  
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
